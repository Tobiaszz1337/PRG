# ⚡ Mini PHP MVC Framework

Jednoduchý PHP MVC framework napsaný od základů — bez Composeru, bez závislostí.

## Struktura

```
mini-framework/
├── app/
│   ├── Controllers/        # HomeController, UserController, AuthController, ContactController
│   ├── Models/             # User.php (rozšiřuje base Model s ORM)
│   └── Views/
│       ├── layouts/main.php
│       ├── home/index.php
│       ├── contact/index.php
│       ├── login/index.php
│       └── users/          # index, create, edit, show
├── core/
│   ├── Autoloader.php      # spl_autoload_register
│   ├── Router.php          # GET/POST/PUT/DELETE + URL parametry
│   ├── Controller.php      # view(), redirect(), json(), flash()
│   ├── Model.php           # ORM: find, all, create, update, delete, where, orderBy
│   ├── Database.php        # PDO singleton
│   └── bootstrap.php       # Načte .env, zaregistruje autoloader, spustí session
├── config/
│   └── database.php        # DB konfigurace (čte z .env)
├── database/
│   └── migration.sql       # SQL pro vytvoření tabulky users
├── public/
│   ├── index.php           # Jediný vstupní bod, definice routes
│   └── .htaccess           # Front-controller rewrite
├── .htaccess               # Přesměrování na public/
└── .env.example            # Šablona pro .env
```

## Instalace

### 1. Klonujte / zkopírujte soubory

```bash
git clone <váš-repo> mini-framework
cd mini-framework
```

### 2. Nastavte .env

```bash
cp .env.example .env
```

Upravte `.env`:
```
DB_HOST=127.0.0.1
DB_NAME=mini_framework
DB_USER=root
DB_PASS=vaše_heslo
```

### 3. Vytvořte databázi

```bash
mysql -u root -p < database/migration.sql
```

### 4. Spusťte

**Apache** — nasměrujte DocumentRoot na `public/`, nebo použijte included `.htaccess`.

**PHP built-in server** (vývoj):
```bash
php -S localhost:8000 -t public
```

## Stránky

| URL             | Popis                        |
|-----------------|------------------------------|
| `/home`         | Úvodní stránka               |
| `/kontakt`      | Ukázkový kontaktní formulář  |
| `/login`        | Přihlášení (demo credentials)|
| `/users`        | Seznam uživatelů             |
| `/users/create` | Přidat uživatele             |
| `/users/:id/edit` | Upravit uživatele          |

## ORM – příklady použití

```php
// Všichni uživatelé
User::all();

// Najít podle ID
User::find(1);

// Filtrování + řazení
User::where('email', '=', 'jan@example.com')->first();
User::orderBy('name')->limit(10)->all();

// Vytvoření
User::create(['name' => 'Jan', 'email' => 'jan@test.cz', 'created_at' => date('Y-m-d H:i:s')]);

// Aktualizace
User::update(1, ['name' => 'Nové Jméno']);

// Smazání
User::delete(1);

// Raw SQL
User::raw('SELECT * FROM users WHERE name LIKE ?', ['%jan%']);
```

## Demo login

```
E-mail:  admin@example.com
Heslo:   tajne123
```
