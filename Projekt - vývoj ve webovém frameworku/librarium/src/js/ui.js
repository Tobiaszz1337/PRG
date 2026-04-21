/**
 * ui.js — UI pomocné funkce
 * Toast notifikace, modální dialog, escape HTML.
 */

// ── Toast ──────────────────────────────────────────────────────────────────

let toastTimer = null;

/**
 * Zobrazí toast notifikaci.
 * @param {string} message
 */
export function showToast(message) {
  const toast = document.getElementById('toast');
  toast.textContent = message;
  toast.classList.add('show');
  clearTimeout(toastTimer);
  toastTimer = setTimeout(() => toast.classList.remove('show'), 2800);
}

// ── Modal ──────────────────────────────────────────────────────────────────

/**
 * Otevře potvrzovací modal před smazáním.
 * @param {string} bookTitle - název knihy pro zobrazení v modalu
 */
export function openDeleteModal(bookTitle) {
  document.getElementById('modal-text').textContent =
    `„${bookTitle}" bude trvale odstraněna z katalogu.`;
  document.getElementById('modal-overlay').classList.add('open');
}

/**
 * Zavře modal.
 */
export function closeModal() {
  document.getElementById('modal-overlay').classList.remove('open');
}

// ── HTML escape ────────────────────────────────────────────────────────────

/**
 * Escapuje HTML speciální znaky (ochrana proti XSS).
 * @param {*} str
 * @returns {string}
 */
export function esc(str) {
  return String(str ?? '')
    .replace(/&/g, '&amp;')
    .replace(/</g, '&lt;')
    .replace(/>/g, '&gt;')
    .replace(/"/g, '&quot;');
}

// ── Stats ──────────────────────────────────────────────────────────────────

/**
 * Aktualizuje statistiky v hlavičce seznamu.
 * @param {Array} books - všechny knihy (nefiltrované)
 */
export function updateStats(books) {
  document.getElementById('stat-count').textContent = books.length;
  document.getElementById('stat-stock').textContent =
    books.reduce((s, b) => s + b.stock, 0).toLocaleString('cs-CZ');
  document.getElementById('stat-value').textContent =
    books.reduce((s, b) => s + b.price * b.stock, 0).toLocaleString('cs-CZ');
}
