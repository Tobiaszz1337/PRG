# 📚 Librarium — CRUD Knihkupectví

Webová aplikace pro správu katalogu knih v knihkupectví.  
Školní zadání: **CRUD na libovolném objektu** (objekt = Kniha).

---

## 🛠 Stack & Architektura

| Vrstva | Technologie |
|---|---|
| Frontend | Vanilla HTML5 + CSS3 + JavaScript (ES Modules) |
| Databáze | `localStorage` (JSON, persists po refresh, bez backendu) |
| Fonty | Google Fonts — Playfair Display, Cormorant Garamond, Josefin Sans |
| Styl | vlastní CSS, Art Deco estetika |

**Žádná instalace, žádný build krok.** Stačí otevřít `index.html` v prohlížeči.

---

## 📁 Struktura projektu

```
librarium/
├── index.html              # Hlavní HTML stránka
├── README.md
└── src/
    ├── css/
    │   └── style.css       # Veškeré styly (CSS Variables, Art Deco téma)
    └── js/
        ├── main.js         # Vstupní bod — init, event listenery
        ├── db.js           # Databázová vrstva (localStorage CRUD)
        ├── form.js         # Logika formuláře (CREATE / UPDATE / DELETE)
        ├── list.js         # Vykreslování seznamu, filtry, řazení
        └── ui.js           # Toast, modal, HTML escape, statistiky
```

---

## ✅ Implementované CRUD operace

### CREATE — Vytvoření knihy
- Formulář s poli: Název *, Autor *, Rok vydání, Počet stran, Cena (Kč), Skladem (ks), Žánr, ISBN, Popis
- Validace povinných polí (název + autor)
- Po uložení okamžité zobrazení v katalogu + toast notifikace

### READ — Zobrazení katalogu
- Karty knih načtené z `localStorage`
- Statistiky: počet titulů, kusů na skladu, celková hodnota
- **Live search** podle názvu nebo autora
- **Filtr** podle žánru
- **Řazení**: nejnovější / název / autor / cena ↑↓ / sklad

### UPDATE — Úprava záznamu
- Tlačítko „Upravit" vyplní formulář daty existující knihy
- Formulář přepne do edit módu (změna nadpisu + tlačítek)
- Po uložení se záznam aktualizuje v databázi

### DELETE — Smazání záznamu
- Tlačítko „Smazat" otevře potvrzovací modal
- Po potvrzení trvale odstraní záznam z databáze

---

## 📦 Datový model — Kniha

```js
{
  id:      String,   // unikátní ID (timestamp + random)
  title:   String,   // název (povinné)
  author:  String,   // autor (povinné)
  year:    Number,   // rok vydání
  pages:   Number,   // počet stran
  price:   Number,   // cena v Kč
  stock:   Number,   // počet kusů na skladě
  genre:   String,   // žánr
  isbn:    String,   // ISBN
  desc:    String,   // popis
  created: Number,   // timestamp vytvoření (ms)
}
```

Data jsou uložena v `localStorage` pod klíčem `librarium_books`.

---

## 🎨 Grafika

- **Estetika:** Art Deco / luxusní knižní obchod
- **Paleta:** zlatá `#C9A84C`, krémová `#F5EFE0`, inkoustová `#1A1208`
- **Typografie:** Playfair Display (nadpisy) · Cormorant Garamond (text) · Josefin Sans (labels/badges)
- **Animace:** slide-in karty, hover efekty zlaté linky, CSS toast, modální dialog s overlay
- **Grid:** CSS Grid 2-sloupcový layout, responzivní na mobil

---

## 🚀 Spuštění

```bash
# Otevřít přímo v prohlížeči:
open index.html

# Nebo spustit lokální server (doporučeno kvůli ES Modules):
npx serve .
# → http://localhost:3000
```

> **Poznámka k ES Modules:** Soubory `src/js/*.js` používají `import/export`.  
> Při otevření přes `file://` protokol mohou některé prohlížeče blokovat moduly.  
> Doporučujeme spustit přes lokální HTTP server (viz výše).

---

## 👤 Autor

Školní projekt · CRUD aplikace · 2024
