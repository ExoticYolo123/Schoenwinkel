<?php
require_once __DIR__.'/includes/auth.php';
require_once __DIR__.'/includes/database.php';
require_once __DIR__.'/includes/helpers.php';
$schoenen=$pdo->query("SELECT s.*,g.gebruikersnaam AS verkoper FROM schoenen s INNER JOIN gebruikers g ON g.id=s.gebruiker_id ORDER BY s.aangemaakt_op DESC,s.id DESC")->fetchAll();
$merken=array_values(array_unique(array_map(fn($s)=>$s['merk'],$schoenen)));
$maten=array_values(array_unique(array_map(fn($s)=>maatWeergave($s['maat']),$schoenen)));
sort($merken, SORT_NATURAL | SORT_FLAG_CASE); sort($maten,SORT_NUMERIC);
?>
<!DOCTYPE html>
<html lang="nl"><head><meta charset="UTF-8"><meta name="viewport" content="width=device-width, initial-scale=1"><title>Alle schoenen - SoleSwap</title><link rel="stylesheet" href="/assets/css/style.css"></head><body>
<?php require __DIR__.'/includes/header.php'; ?>
<main class="overzicht"><h1>Ontdek alle schoenen 👟</h1><p>Vind jouw volgende favoriete paar!</p><div class="filters">
<label>Zoeken<input type="search" id="zoekInput" placeholder="Bijv. Nike of Adidas"></label>
<label>Merk<select id="merkFilter"><option value="alles">Alle merken</option><?php foreach($merken as $merk): ?><option value="<?= veilig(mb_strtolower($merk)) ?>"><?= veilig($merk) ?></option><?php endforeach; ?></select></label>
<label>Maat<select id="maatFilter"><option value="alles">Alle maten</option><?php foreach($maten as $maat): ?><option value="<?= veilig($maat) ?>"><?= veilig($maat) ?></option><?php endforeach; ?></select></label>
</div><p id="resultaten" aria-live="polite"><?= count($schoenen) ?> schoenen gevonden</p><div class="schoenen-container" id="schoenenLijst">
<?php foreach($schoenen as $schoen) require __DIR__.'/includes/schoen-kaart.php'; ?>
</div><p id="geenResultaten" class="empty" hidden>Geen schoenen gevonden.</p></main>
<?php require __DIR__.'/includes/footer.php'; ?>
</body></html>
