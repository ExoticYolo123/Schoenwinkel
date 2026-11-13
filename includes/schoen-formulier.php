<form class="stack" method="post" enctype="multipart/form-data">
<input type="hidden" name="csrf_token" value="<?= veilig(csrfToken()) ?>">
<label>Naam<input type="text" name="naam" maxlength="150" required value="<?= veilig($waarden['naam']) ?>"></label>
<label>Merk<input type="text" name="merk" maxlength="100" required value="<?= veilig($waarden['merk']) ?>"></label>
<div class="form-grid"><label>Maat<input type="number" name="maat" min="15" max="60" step="0.5" required value="<?= veilig($waarden['maat']) ?>"></label><label>Prijs in euro's<input type="number" name="prijs" min="0.01" max="99999999.99" step="0.01" required value="<?= veilig($waarden['prijs']) ?>"></label></div>
<label>Categorie<select name="categorie_id" required><option value="">Kies een categorie</option><?php foreach($categorieen as $c): ?><option value="<?= (int)$c['id'] ?>" <?= (string)$waarden['categorie_id']===(string)$c['id']?'selected':'' ?>><?= veilig($c['naam']) ?></option><?php endforeach; ?></select></label>
<label>Conditie<select name="conditie"><option value="Nieuw" <?= $waarden['conditie']==='Nieuw'?'selected':'' ?>>Nieuw</option><option value="Tweedehands" <?= $waarden['conditie']==='Tweedehands'?'selected':'' ?>>Tweedehands</option></select></label>
<label>Beschrijving<textarea name="beschrijving" rows="5" maxlength="5000"><?= veilig($waarden['beschrijving']) ?></textarea></label>
<label>Foto (JPG, PNG, WebP, maximaal 5 MB)<input type="file" name="afbeelding" accept=".jpg,.jpeg,.png,.webp,image/jpeg,image/png,image/webp"></label>
<?php if(!empty($waarden['afbeelding'])): ?><p>Huidige foto: <?= veilig($waarden['afbeelding']) ?> (nieuwe foto kiezen om te vervangen)</p><?php endif; ?>
<button type="submit"><?= veilig($knopTekst) ?></button>
</form>
