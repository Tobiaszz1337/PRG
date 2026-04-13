<div style="display:flex; align-items:center; gap:1rem; margin-bottom:1.5rem;">
    <a href="/users" style="color:var(--muted); text-decoration:none; font-size:0.9rem;">← Zpět</a>
    <h1 style="margin:0;">Upravit uživatele</h1>
</div>

<div class="card" style="max-width:480px;">
    <?php if (!empty($error)): ?>
        <div class="alert alert-danger"><?= htmlspecialchars($error) ?></div>
    <?php endif; ?>

    <form method="POST" action="/users/<?= (int) $user['id'] ?>">
        <input type="hidden" name="_method" value="PUT">

        <div class="form-group">
            <label for="name">Jméno</label>
            <input type="text" id="name" name="name" value="<?= htmlspecialchars($user['name']) ?>" required>
        </div>
        <div class="form-group">
            <label for="email">E-mail</label>
            <input type="email" id="email" name="email" value="<?= htmlspecialchars($user['email']) ?>" required>
        </div>
        <div style="display:flex; gap:0.75rem; margin-top:0.5rem;">
            <button type="submit" class="btn btn-primary">Uložit změny</button>
            <a href="/users" class="btn btn-ghost">Zrušit</a>
        </div>
    </form>
</div>
