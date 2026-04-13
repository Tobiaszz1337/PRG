<h1><?= htmlspecialchars($heading) ?></h1>

<div class="card" style="max-width:520px;">
    <div class="form-group">
        <label>Jméno</label>
        <input type="text" placeholder="Jan Novák" disabled>
    </div>
    <div class="form-group">
        <label>E-mail</label>
        <input type="email" placeholder="jan@example.com" disabled>
    </div>
    <div class="form-group">
        <label>Zpráva</label>
        <textarea rows="4" placeholder="Vaše zpráva..." disabled></textarea>
    </div>
    <button class="btn btn-primary" disabled>Odeslat (ukázkový formulář)</button>
    <p style="color:var(--muted); font-size:0.8rem; margin-top:0.75rem;">
        Tato stránka je pouze ukázka — formulář není funkční.
    </p>
</div>
