<div style="display:flex; align-items:center; gap:1rem; margin-bottom:1.5rem;">
    <a href="/users" style="color:var(--muted); text-decoration:none; font-size:0.9rem;">← Zpět</a>
    <h1 style="margin:0;"><?= htmlspecialchars($user['name']) ?></h1>
</div>

<div class="card" style="max-width:480px;">
    <table>
        <tr><th>ID</th><td><?= (int) $user['id'] ?></td></tr>
        <tr><th>Jméno</th><td><?= htmlspecialchars($user['name']) ?></td></tr>
        <tr><th>E-mail</th><td><?= htmlspecialchars($user['email']) ?></td></tr>
        <tr><th>Vytvořeno</th><td><?= htmlspecialchars($user['created_at'] ?? '—') ?></td></tr>
    </table>

    <div style="display:flex; gap:0.75rem; margin-top:1rem;">
        <a href="/users/<?= (int) $user['id'] ?>/edit" class="btn btn-ghost">Upravit</a>
        <form method="POST" action="/users/<?= (int) $user['id'] ?>" onsubmit="return confirm('Opravdu smazat?');">
            <input type="hidden" name="_method" value="DELETE">
            <button type="submit" class="btn btn-danger">Smazat</button>
        </form>
    </div>
</div>
