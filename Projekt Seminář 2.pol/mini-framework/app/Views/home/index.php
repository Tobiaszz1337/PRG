<h1><?= htmlspecialchars($heading) ?></h1>

<div class="card">
    <h2>Co tento framework umí?</h2>
    <p style="color:var(--muted); line-height:1.7; margin-top:0.5rem;">
        Jednoduchý PHP MVC framework napsaný od základů bez závislostí.
        Obsahuje autoloading, router, base Controller a Model s ORM metodami nad PDO.
    </p>
</div>

<div style="display:grid; grid-template-columns:repeat(auto-fit,minmax(220px,1fr)); gap:1rem; margin-top:1rem;">
    <div class="card">
        <div style="font-size:1.5rem; margin-bottom:0.5rem;">🔀</div>
        <strong>Router</strong>
        <p style="color:var(--muted); font-size:0.85rem; margin-top:0.3rem;">GET/POST/PUT/DELETE, parametry z URL (:id)</p>
    </div>
    <div class="card">
        <div style="font-size:1.5rem; margin-bottom:0.5rem;">⚙️</div>
        <strong>Autoloader</strong>
        <p style="color:var(--muted); font-size:0.85rem; margin-top:0.3rem;">PSR-4 style, žádný Composer není potřeba</p>
    </div>
    <div class="card">
        <div style="font-size:1.5rem; margin-bottom:0.5rem;">🗄️</div>
        <strong>ORM / PDO</strong>
        <p style="color:var(--muted); font-size:0.85rem; margin-top:0.3rem;">find, all, create, update, delete, where, orderBy</p>
    </div>
    <div class="card">
        <div style="font-size:1.5rem; margin-bottom:0.5rem;">👁️</div>
        <strong>Views + Layouts</strong>
        <p style="color:var(--muted); font-size:0.85rem; margin-top:0.3rem;">Šablony s layoutem, flash zprávy, extrakce dat</p>
    </div>
</div>

<div style="margin-top:1.5rem;">
    <a href="/users" class="btn btn-primary">Zobrazit uživatele (CRUD demo)</a>
</div>
