/**
 * db.js — Databázová vrstva (localStorage)
 * Abstrakce nad localStorage pro práci s knihami.
 */

const DB_KEY = 'librarium_books';

/**
 * Načte všechny knihy z databáze.
 * @returns {Array} pole objektů knih
 */
export function getBooks() {
  return JSON.parse(localStorage.getItem(DB_KEY) || '[]');
}

/**
 * Uloží celé pole knih do databáze.
 * @param {Array} books
 */
export function saveBooks(books) {
  localStorage.setItem(DB_KEY, JSON.stringify(books));
}

/**
 * Přidá novou knihu.
 * @param {Object} book
 */
export function createBook(book) {
  const books = getBooks();
  books.push(book);
  saveBooks(books);
}

/**
 * Aktualizuje existující knihu podle id.
 * @param {Object} updatedBook
 */
export function updateBook(updatedBook) {
  const books = getBooks().map(b => b.id === updatedBook.id ? updatedBook : b);
  saveBooks(books);
}

/**
 * Smaže knihu podle id.
 * @param {string} id
 */
export function deleteBook(id) {
  saveBooks(getBooks().filter(b => b.id !== id));
}

/**
 * Najde knihu podle id.
 * @param {string} id
 * @returns {Object|undefined}
 */
export function findBook(id) {
  return getBooks().find(b => b.id === id);
}

/**
 * Vygeneruje unikátní ID.
 * @returns {string}
 */
export function generateId() {
  return Date.now().toString(36) + Math.random().toString(36).slice(2, 7);
}

/**
 * Naplní databázi ukázkovými daty (pouze pokud je prázdná).
 */
export function seedIfEmpty() {
  if (getBooks().length > 0) return;

  const sample = [
    {
      id: generateId(),
      title: 'Mistr a Markétka',
      author: 'Bulgakov, Michail',
      year: 1967,
      pages: 432,
      price: 349,
      stock: 8,
      genre: 'Beletrie',
      isbn: '978-80-252-0401-5',
      desc: 'Mistrovský román o Ďáblově návštěvě Moskvy a příběhu Pontia Piláta.',
      created: Date.now() - 5000,
    },
    {
      id: generateId(),
      title: 'Sto roků samoty',
      author: 'García Márquez, Gabriel',
      year: 1967,
      pages: 411,
      price: 379,
      stock: 3,
      genre: 'Beletrie',
      isbn: '978-80-207-1456-1',
      desc: 'Magicko-realistická sága rodu Buendía v městečku Macondo.',
      created: Date.now() - 4000,
    },
    {
      id: generateId(),
      title: 'Duna',
      author: 'Herbert, Frank',
      year: 1965,
      pages: 604,
      price: 499,
      stock: 12,
      genre: 'Sci-fi',
      isbn: '978-80-743-0018-0',
      desc: 'Epická sci-fi o planetě Arrakis a vzácném koření.',
      created: Date.now() - 3000,
    },
    {
      id: generateId(),
      title: 'Jméno růže',
      author: 'Eco, Umberto',
      year: 1980,
      pages: 502,
      price: 429,
      stock: 0,
      genre: 'Detektiv',
      isbn: '978-80-207-0989-5',
      desc: 'Detektivní příběh z prostředí středověkého kláštera.',
      created: Date.now() - 2000,
    },
    {
      id: generateId(),
      title: 'Pán prstenů: Společenstvo prstenu',
      author: 'Tolkien, J. R. R.',
      year: 1954,
      pages: 480,
      price: 449,
      stock: 6,
      genre: 'Fantasy',
      isbn: '978-80-257-0289-0',
      desc: 'Začátek slavné fantasy ságy Středozemě.',
      created: Date.now() - 1000,
    },
  ];

  saveBooks(sample);
}
