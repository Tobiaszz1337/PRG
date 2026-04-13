<h1><?= htmlspecialchars($heading) ?></h1>

<div class="card" style="max-width:400px;">
    <?php if (!empty($error)): ?>
        <div class="alert alert-danger"><?= htmlspecialchars($error) ?></div>
    <?php endif; ?>

    <form method="POST" action="/login">
        <div class="form-group">
            <label for="email">E-mail</label>
            <input type="email" id="email" name="email" placeholder="admin@example.com" required>
        </div>
        <div class="form-group">
            <label for="password">Heslo</label>
            <input type="password" id="password" name="password" placeholder="••••••••" required>
        </div>
        <button type="submit" class="btn btn-primary" style="width:100%;">Přihlásit se</button>
    </form>

    <p style="color:var(--muted); font-size:0.8rem; margin-top:1rem;">
        Demo: <code style="color:var(--accent2)">admin@example.com</code> / <code style="color:var(--accent2)">tajne123</code>
    </p>
</div>
