<?php
require_once __DIR__.'/includes/auth.php';
require_once __DIR__.'/includes/database.php';
require_once __DIR__.'/includes/helpers.php';
verplichtInloggen();$fout='';
if($_SERVER['REQUEST_METHOD']==='POST'){
 eisPostEnCsrf();$actie=(string)($_POST['actie']??'');$naam=trim((string)($_POST['naam']??''));$beschrijving=trim((string)($_POST['beschrijving']??''));
 try{
  if($actie==='toevoegen' && $naam!=='' && mb_strlen($naam)<=100){$stmt=$pdo->prepare('INSERT INTO categorieen (naam,beschrijving) VALUES (:naam,:beschrijving)');$stmt->execute(['naam'=>$naam,'beschrijving'=>$beschrijving]);}
  elseif($actie==='bewerken' && $naam!=='' && mb_strlen($naam)<=100){$stmt=$pdo->prepare('UPDATE categorieen SET naam=:naam,beschrijving=:beschrijving WHERE id=:id');$stmt->execute(['naam'=>$naam,'beschrijving'=>$beschrijving,'id'=>(int)($_POST['id']??0)]);}
  elseif($actie==='verwijderen'){$stmt=$pdo->prepare('DELETE FROM categorieen WHERE id=:id');$stmt->execute(['id'=>(int)($_POST['id']??0)]);}
  else{$fout='Controleer de gegevens.';}
  if(!$fout){header('Location: /categorieen-beheren.php');exit;}
 } catch(PDOException $e){error_log($e->getMessage());$fout='Opslaan of verwijderen lukt niet. Mogelijk wordt de categorie nog door schoenen gebruikt of bestaat de naam al.';}
}
$categorieen=$pdo->query('SELECT * FROM categorieen ORDER BY naam')->fetchAll();
?>
<!DOCTYPE html>
<html lang="nl"><head><meta charset="UTF-8"><meta name="viewport" content="width=device-width, initial-scale=1"><title>Categorieën beheren - SoleSwap</title><link rel="stylesheet" href="/assets/css/style.css"></head><body>
<?php require __DIR__.'/includes/header.php'; ?>
<main class="beheer-pagina"><div class="container"><h1>Categorieën beheren 🏷️</h1><p>Beheer je tweede CRUD-onderdeel. Verwijderen kan alleen wanneer er geen schoenen aan een categorie gekoppeld zijn.</p><?php if($fout): ?><p class="error"><?= veilig($fout) ?></p><?php endif; ?>
<section class="form-card"><h2>Categorie toevoegen</h2><form class="stack" method="post"><input type="hidden" name="csrf_token" value="<?= veilig(csrfToken()) ?>"><input type="hidden" name="actie" value="toevoegen"><label>Naam<input name="naam" maxlength="100" required></label><label>Beschrijving<textarea name="beschrijving"></textarea></label><button type="submit">Toevoegen</button></form></section>
<div class="beheer-lijst categories"><?php foreach($categorieen as $cat): ?><article class="beheer-item"><div class="full"><h2><?= veilig($cat['naam']) ?></h2><form class="stack" method="post"><input type="hidden" name="csrf_token" value="<?= veilig(csrfToken()) ?>"><input type="hidden" name="actie" value="bewerken"><input type="hidden" name="id" value="<?= (int)$cat['id'] ?>"><label>Naam<input name="naam" required maxlength="100" value="<?= veilig($cat['naam']) ?>"></label><label>Beschrijving<textarea name="beschrijving"><?= veilig($cat['beschrijving']??'') ?></textarea></label><button type="submit">Wijzigingen opslaan</button></form><form method="post" data-confirm="Categorie verwijderen? Dit kan alleen als er geen schoenen aan gekoppeld zijn."><input type="hidden" name="csrf_token" value="<?= veilig(csrfToken()) ?>"><input type="hidden" name="actie" value="verwijderen"><input type="hidden" name="id" value="<?= (int)$cat['id'] ?>"><button class="danger" type="submit">Verwijderen</button></form></div></article><?php endforeach; ?></div></div></main>
<?php require __DIR__.'/includes/footer.php'; ?>
</body></html>
