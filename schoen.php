<?php
require_once __DIR__.'/includes/auth.php';
require_once __DIR__.'/includes/database.php';
require_once __DIR__.'/includes/helpers.php';
$id=filter_input(INPUT_GET,'id',FILTER_VALIDATE_INT,['options'=>['min_range'=>1]]);
if(!$id){http_response_code(400);exit('Ongeldig schoen-ID.');}
$stmt=$pdo->prepare("SELECT s.*, g.gebruikersnaam AS verkoper,c.naam AS categorie FROM schoenen s INNER JOIN gebruikers g ON s.gebruiker_id=g.id INNER JOIN categorieen c ON s.categorie_id=c.id WHERE s.id=:id");
$stmt->execute(['id'=>$id]);$schoen=$stmt->fetch();
if(!$schoen){http_response_code(404);exit('Schoen niet gevonden.');}
$foto=schoenFoto($schoen['afbeelding']??null);
?>
<!DOCTYPE html>
<html lang="nl"><head><meta charset="UTF-8"><meta name="viewport" content="width=device-width, initial-scale=1"><title>Schoen bekijken - SoleSwap</title><link rel="stylesheet" href="/assets/css/style.css"></head><body>
<?php require __DIR__.'/includes/header.php'; ?>
<main class="schoen-detail"><a class="terug-link" href="/schoenen.php">← Terug naar schoenen</a><div class="detail-container"><div class="detail-afbeelding">
<?php if($foto): ?><img src="<?= veilig($foto) ?>" alt="<?= veilig($schoen['naam']) ?>"><?php else: ?><div class="geen-foto">Geen foto beschikbaar</div><?php endif; ?></div>
<div class="detail-info"><span class="label <?= $schoen['conditie']==='Nieuw'?'nieuw':'tweedehands' ?>"><?= veilig($schoen['conditie']) ?></span><h1><?= veilig($schoen['naam']) ?></h1><p class="detail-prijs">€<?= number_format((float)$schoen['prijs'],2,',','.') ?></p>
<p><strong>Maat:</strong> <?= veilig(maatWeergave($schoen['maat'])) ?></p><p><strong>Merk:</strong> <?= veilig($schoen['merk']) ?></p><p><strong>Categorie:</strong> <?= veilig($schoen['categorie']) ?></p><p><strong>Verkoper:</strong> <?= veilig($schoen['verkoper']) ?></p><p><strong>Datum:</strong> <?= veilig(date('d-m-Y',strtotime($schoen['aangemaakt_op']))) ?></p><p>Contactfunctie komt later.</p></div></div>
<section class="beschrijving"><h2>Beschrijving</h2><p><?= nl2br(veilig($schoen['beschrijving'] ?: 'Geen beschrijving beschikbaar.')) ?></p></section></main>
<?php require __DIR__.'/includes/footer.php'; ?>
</body></html>
