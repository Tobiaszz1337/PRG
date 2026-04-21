/**
 * list.js — Vykreslení seznamu knih
 * Filtrování, řazení a renderování karet.
 */

import { getBooks } from './db.js';
import { esc, updateStats } from './ui.js';

/**
 * Sestaví HTML kartu pro jednu knihu.
 * @param {Object} book
 * @returns {string} HTML string
 */
function renderBookCard(book) {
  const stockClass = book.stock === 0 || book.stock < 3 ? 'low' : '';
  const stockLabel = book.stock > 0 ? `${book.stock} ks` : 'Není skladem';
  const descSnippet = book.desc
    ? `<div class="book-desc">${esc(book.desc).slice(0, 120)}${book.desc.length > 120 ? '…' : ''}</div>`
    : '';

  return `
    <div class="book-card">
      <div>
        <div class="book-title">${esc(book.title)}</div>
        <div class="book-author">${esc(book.author)}${book.year ? ` — ${book.year}` : ''}</div>
        <div class="book-meta">
          ${book.price  ? `<span class="badge badge-price">${book.price.toLocaleString('cs-CZ')} Kč</span>` : ''}
          ${book.genre  ? `<span class="badge badge-genre">${esc(book.genre)}</span>` : ''}
          <span class="badge badge-stock ${stockClass}">${stockLabel}</span>
          ${book.pages  ? `<span class="badge">${book.pages} s.</span>` : ''}
          ${book.isbn   ? `<span class="badge badge-isbn">${esc(book.isbn)}</span>` : ''}
        </div>
        ${descSnippet}
      </div>
      <div class="book-actions">
        <button class="btn btn-ghost" onclick="window.editBook('${book.id}')">Upravit</button>
        <button class="btn btn-danger" onclick="window.deleteBook('${book.id}')">Smazat</button>
      </div>
    </div>
  `;
}

/**
 * Seřadí pole knih podle zvoleného kritéria.
 * @param {Array} books
 * @param {string} sort
 * @returns {Array}
 */
function sortBooks(books, sort) {
  return [...books].sort((a, b) => {
    switch (sort) {
      case 'title-asc':   return a.title.localeCompare(b.title);
      case 'author-asc':  return a.author.localeCompare(b.author);
      case 'price-asc':   return a.price - b.price;
      case 'price-desc':  return b.price - a.price;
      case 'stock-desc':  return b.stock - a.stock;
      default:            return b.created - a.created; // date-desc
    }
  });
}

/**
 * Filtruje a vykreslí seznam knih podle aktuálního stavu UI.
 * Volá se při každé změně: search, filtr, řazení, i po CRUD operacích.
 */
export function renderList() {
  const query = document.getElementById('search').value.toLowerCase();
  const genre = document.getElementById('filter-genre').value;
  const sort  = document.getElementById('sort').value;

  const allBooks = getBooks();

  const filtered = allBooks.filter(book => {
    const matchQuery = !query ||
      book.title.toLowerCase().includes(query) ||
      book.author.toLowerCase().includes(query);
    const matchGenre = !genre || book.genre === genre;
    return matchQuery && matchGenre;
  });

  const sorted = sortBooks(filtered, sort);

  const listEl = document.getElementById('book-list');

  if (sorted.length === 0) {
    listEl.innerHTML = `
      <div class="empty-state">
        <div class="big">📚</div>
        <p>Žádné knihy k zobrazení.</p>
      </div>`;
  } else {
    listEl.innerHTML = sorted.map(renderBookCard).join('');
  }

  updateStats(allBooks);
}
