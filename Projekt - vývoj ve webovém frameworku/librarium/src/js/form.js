/**
 * form.js — CRUD logika formuláře
 * Vytváření, úprava a mazání knih.
 */

import { getBooks, createBook, updateBook, deleteBook as dbDelete, findBook, generateId } from './db.js';
import { showToast, openDeleteModal, closeModal } from './ui.js';
import { renderList } from './list.js';

// ID knihy, která čeká na potvrzení smazání
let pendingDeleteId = null;

// ── Helpers ────────────────────────────────────────────────────────────────

/**
 * Přečte hodnoty formuláře a vrátí objekt knihy.
 * @param {string} [existingId] - při editaci zachová původní ID a datum
 * @returns {Object}
 */
function readForm(existingId) {
  return {
    id:      existingId || generateId(),
    title:   document.getElementById('f-title').value.trim(),
    author:  document.getElementById('f-author').value.trim(),
    year:    +document.getElementById('f-year').value  || null,
    pages:   +document.getElementById('f-pages').value || null,
    price:   +document.getElementById('f-price').value || 0,
    stock:   +document.getElementById('f-stock').value || 0,
    genre:   document.getElementById('f-genre').value,
    isbn:    document.getElementById('f-isbn').value.trim(),
    desc:    document.getElementById('f-desc').value.trim(),
    created: existingId
      ? (findBook(existingId) || {}).created ?? Date.now()
      : Date.now(),
  };
}

/**
 * Validuje povinná pole.
 * @param {Object} book
 * @returns {string|null} chybová zpráva nebo null
 */
function validate(book) {
  if (!book.title)  return '⚠ Vyplňte název knihy';
  if (!book.author) return '⚠ Vyplňte autora';
  return null;
}

// ── Public API ─────────────────────────────────────────────────────────────

/**
 * CREATE / UPDATE — uloží formulář do databáze.
 * Rozlišuje novou knihu vs. editaci podle skrytého pole #edit-id.
 */
export function saveBook() {
  const editId = document.getElementById('edit-id').value;
  const book   = readForm(editId || null);
  const error  = validate(book);

  if (error) { showToast(error); return; }

  if (editId) {
    updateBook(book);
    showToast('✦ Kniha byla aktualizována');
  } else {
    createBook(book);
    showToast('✦ Kniha byla přidána do katalogu');
  }

  resetForm();
  renderList();
}

/**
 * Naplní formulář daty existující knihy (přepne do edit módu).
 * @param {string} id
 */
export function editBook(id) {
  const book = findBook(id);
  if (!book) return;

  document.getElementById('edit-id').value  = book.id;
  document.getElementById('f-title').value  = book.title;
  document.getElementById('f-author').value = book.author;
  document.getElementById('f-year').value   = book.year   ?? '';
  document.getElementById('f-pages').value  = book.pages  ?? '';
  document.getElementById('f-price').value  = book.price  ?? '';
  document.getElementById('f-stock').value  = book.stock  ?? '';
  document.getElementById('f-genre').value  = book.genre  ?? '';
  document.getElementById('f-isbn').value   = book.isbn   ?? '';
  document.getElementById('f-desc').value   = book.desc   ?? '';

  document.getElementById('form-panel-title').textContent = 'Upravit knihu';
  document.getElementById('btn-label').textContent        = '✦ Uložit změny';
  document.getElementById('btn-cancel').style.display     = '';

  document.getElementById('f-title').focus();
  document.getElementById('form-panel').scrollIntoView({ behavior: 'smooth', block: 'start' });
}

/**
 * Zahájí proces mazání — otevře potvrzovací modal.
 * @param {string} id
 */
export function deleteBook(id) {
  const book = findBook(id);
  if (!book) return;
  pendingDeleteId = id;
  openDeleteModal(book.title);
}

/**
 * Potvrdí smazání (volá se z tlačítka v modalu).
 */
export function confirmDelete() {
  if (!pendingDeleteId) return;
  dbDelete(pendingDeleteId);
  pendingDeleteId = null;
  closeModal();
  renderList();
  showToast('Kniha byla smazána');
}

/**
 * Zruší editaci a vrátí formulář do výchozího stavu.
 */
export function cancelEdit() {
  resetForm();
}

/**
 * Resetuje formulář do prázdného (CREATE) stavu.
 */
export function resetForm() {
  ['edit-id', 'f-title', 'f-author', 'f-year', 'f-pages',
   'f-price', 'f-stock', 'f-isbn', 'f-desc'].forEach(id => {
    document.getElementById(id).value = '';
  });
  document.getElementById('f-genre').value = '';
  document.getElementById('form-panel-title').textContent = 'Přidat novou knihu';
  document.getElementById('btn-label').textContent        = '✦ Zapsat do katalogu';
  document.getElementById('btn-cancel').style.display     = 'none';
}
