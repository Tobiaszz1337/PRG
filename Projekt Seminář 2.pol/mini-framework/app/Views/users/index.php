<div style="display:flex; align-items:center; justify-content:space-between; margin-bottom:1.5rem;">
    <h1 style="margin:0;">Uživatelé</h1>
    <a href="/users/create" class="btn btn-primary">+ Nový uživatel</a>
</div>

<?php if (empty($users)): ?>
    <div class="card" style="text-align:center; color:var(--muted); padding:3rem;">
        Zatím žádní uživatelé. <a href="/users/create" style="color:var(--accent2);">Přidat prvního</a>.
    </div>
<?php else: ?>
    <div class="card" style="padding:0; overflow:hidden;">
        <table>
            <thead>
                <tr>
                    <th>#</th>
                    <th>Jméno</th>
                    <th>E-mail</th>
                    <th>Vytvořeno</th>
                    <th>Akce</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($users as $user): ?>
                <tr>
                    <td style="color:var(--muted);"><?= (int) $user['id'] ?></td>
                    <td><strong><?= htmlspecialchars($user['name']) ?></strong></td>
                    <td style="color:var(--muted);"><?= htmlspecialchars($user['email']) ?></td>
                    <td style="color:var(--muted); font-size:0.8rem;"><?= htmlspecialchars($user['created_at'] ?? '—') ?></td>
                    <td style="display:flex; gap:0.5rem; align-items:center;">
                        <a href="/users/<?= (int) $user['id'] ?>/edit" class="btn btn-ghost" style="padding:0.3rem 0.7rem; font-size:0.8rem;">Upravit</a>

                        <form method="POST" action="/users/<?= (int) $user['id'] ?>" onsubmit="return confirm('Opravdu smazat?');" style="display:inline;">
                            <input type="hidden" name="_method" value="DELETE">
                            <button type="submit" class="btn btn-danger" style="padding:0.3rem 0.7rem; font-size:0.8rem;">Smazat</button>
                        </form>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
<?php endif; ?>
