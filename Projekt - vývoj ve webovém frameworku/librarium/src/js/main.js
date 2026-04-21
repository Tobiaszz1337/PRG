/**
 * main.js — Vstupní bod aplikace
 * Inicializace, event listenery, propojení modulů.
 */

import { seedIfEmpty } from './db.js';
import { closeModal }  from './ui.js';
import { renderList }  from './list.js';
import {
  saveBook,
  editBook,
  deleteBook,
  confirmDelete,
  cancelEdit,
} from './form.js';

// ── Expose functions to HTML (inline onclick handlers) ─────────────────────
// Moduly jsou v ES module scope, proto potřebujeme explicitní export na window.
window.saveBook      = saveBook;
window.editBook      = editBook;
window.deleteBook    = deleteBook;
window.confirmDelete = confirmDelete;
window.cancelEdit    = cancelEdit;
window.closeModal    = closeModal;
window.renderList    = renderList;

// ── Event listenery ────────────────────────────────────────────────────────

// Zavření modalu kliknutím na overlay
document.getElementById('modal-overlay').addEventListener('click', e => {
  if (e.target === document.getElementById('modal-overlay')) {
    closeModal();
  }
});

// Klávesa Escape zavře modal
document.addEventListener('keydown', e => {
  if (e.key === 'Escape') closeModal();
});

// ── Init ───────────────────────────────────────────────────────────────────
seedIfEmpty();
renderList();
