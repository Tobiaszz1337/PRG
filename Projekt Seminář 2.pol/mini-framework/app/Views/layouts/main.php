<!DOCTYPE html>
<html lang="cs">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= htmlspecialchars($title ?? 'MiniFramework') ?> | MiniFramework</title>
    <style>
        *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }
        :root {
            --bg: #0f1117; --surface: #1a1d27; --surface2: #222536;
            --border: #2e3150; --accent: #6c63ff; --accent2: #a78bfa;
            --text: #e2e4f0; --muted: #7b82a8;
            --success: #34d399; --danger: #f87171;
            --radius: 8px; --font: 'Segoe UI', system-ui, sans-serif;
        }
        body { font-family: var(--font); background: var(--bg); color: var(--text); min-height: 100vh; display: flex; flex-direction: column; }

        nav { background: var(--surface); border-bottom: 1px solid var(--border); padding: 0 2rem; display: flex; align-items: center; gap: 1rem; height: 56px; }
        .nav-brand { font-weight: 700; font-size: 1.1rem; color: var(--accent2); text-decoration: none; }
        .nav-links { display: flex; gap: 0.25rem; margin-left: auto; }
        .nav-links a { color: var(--muted); text-decoration: none; padding: 0.4rem 0.85rem; border-radius: var(--radius); font-size: 0.9rem; transition: color 0.15s, background 0.15s; }
        .nav-links a:hover { color: var(--text); background: var(--surface2); }

        .flash { padding: 0.75rem 1.5rem; font-size: 0.9rem; text-align: center; }
        .flash.success { background: #064e3b; color: var(--success); }
        .flash.error   { background: #450a0a; color: var(--danger); }

        main { flex: 1; max-width: 900px; width: 100%; margin: 2.5rem auto; padding: 0 1.5rem; }
        h1 { font-size: 1.8rem; font-weight: 700; margin-bottom: 1.5rem; }
        h2 { font-size: 1.25rem; font-weight: 600; margin-bottom: 1rem; }

        .card { background: var(--surface); border: 1px solid var(--border); border-radius: var(--radius); padding: 1.5rem; margin-bottom: 1rem; }

        table { width: 100%; border-collapse: collapse; }
        th, td { padding: 0.75rem 1rem; text-align: left; border-bottom: 1px solid var(--border); font-size: 0.9rem; }
        th { color: var(--muted); font-weight: 600; font-size: 0.8rem; text-transform: uppercase; letter-spacing: 0.05em; }
        tr:last-child td { border-bottom: none; }
        tr:hover td { background: var(--surface2); }

        .btn { display: inline-block; padding: 0.5rem 1.1rem; border-radius: var(--radius); font-size: 0.875rem; font-weight: 500; cursor: pointer; border: none; text-decoration: none; transition: opacity 0.15s; }
        .btn:hover { opacity: 0.85; }
        .btn-primary { background: var(--accent); color: #fff; }
        .btn-danger  { background: #7f1d1d; color: var(--danger); }
        .btn-ghost   { background: var(--surface2); color: var(--text); border: 1px solid var(--border); }

        .form-group { margin-bottom: 1.1rem; }
        label { display: block; font-size: 0.85rem; color: var(--muted); margin-bottom: 0.4rem; }
        input[type=text], input[type=email], input[type=password], textarea {
            width: 100%; padding: 0.6rem 0.9rem; background: var(--surface2);
            border: 1px solid var(--border); border-radius: var(--radius);
            color: var(--text); font-size: 0.9rem; outline: none;
        }
        input:focus, textarea:focus { border-color: var(--accent); }

        .alert { padding: 0.75rem 1rem; border-radius: var(--radius); font-size: 0.875rem; margin-bottom: 1rem; }
        .alert-danger   { background: #450a0a; color: var(--danger); border: 1px solid #7f1d1d; }
        .alert-success  { background: #064e3b; color: var(--success); border: 1px solid #065f46; }

        footer { text-align: center; padding: 1.5rem; color: var(--muted); font-size: 0.8rem; border-top: 1px solid var(--border); }
    </style>
</head>
<body>

<nav>
    <a href="/home" class="nav-brand">⚡ MiniFramework</a>
    <div class="nav-links">
        <a href="/home">Domů</a>
        <a href="/users">Uživatelé</a>
        <a href="/kontakt">Kontakt</a>
        <a href="/login">Login</a>
    </div>
</nav>

<?php if (!empty($_SESSION['flash'])): ?>
    <?php foreach ($_SESSION['flash'] as $type => $msg): ?>
        <div class="flash <?= htmlspecialchars($type) ?>"><?= htmlspecialchars($msg) ?></div>
    <?php endforeach; unset($_SESSION['flash']); ?>
<?php endif; ?>

<main>
    <?= $content ?>
</main>

<footer>MiniFramework &copy; <?= date('Y') ?> — PHP MVC od základů</footer>

</body>
</html>
