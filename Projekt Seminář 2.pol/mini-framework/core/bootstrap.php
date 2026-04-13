<?php
/**
 * bootstrap.php
 * Loaded by public/index.php — sets up constants, env, autoloader, session.
 */

define('BASE_PATH', dirname(__DIR__));

// ── Load .env ──────────────────────────────────────────────────────────────
$envFile = BASE_PATH . '/.env';
if (file_exists($envFile)) {
    foreach (file($envFile, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES) as $line) {
        if (str_starts_with(trim($line), '#') || !str_contains($line, '=')) {
            continue;
        }
        [$key, $value] = explode('=', $line, 2);
        $_ENV[trim($key)] = trim($value);
        putenv(trim($key) . '=' . trim($value));
    }
}

// ── Helper: read env variable ──────────────────────────────────────────────
function env(string $key, mixed $default = null): mixed
{
    return $_ENV[$key] ?? getenv($key) ?: $default;
}

// ── Error display based on environment ────────────────────────────────────
if (env('APP_DEBUG', 'false') === 'true') {
    ini_set('display_errors', 1);
    error_reporting(E_ALL);
} else {
    ini_set('display_errors', 0);
    error_reporting(0);
}

// ── Autoloader ────────────────────────────────────────────────────────────
require BASE_PATH . '/core/Autoloader.php';
Autoloader::register();
Autoloader::addNamespace('', BASE_PATH . '/core');
Autoloader::addNamespace('', BASE_PATH . '/app/Controllers');
Autoloader::addNamespace('', BASE_PATH . '/app/Models');

// ── Session ───────────────────────────────────────────────────────────────
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
