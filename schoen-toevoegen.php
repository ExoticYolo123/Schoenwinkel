<?php
require_once __DIR__.'/includes/auth.php';
require_once __DIR__.'/includes/database.php';
require_once __DIR__.'/includes/helpers.php';
verplichtInloggen();
$categorieen=$pdo->query('SELECT id,naam FROM categorieen ORDER BY naam')->fetchAll();
$waarden=['naam'=>'','merk'=>'','maat'=>'','prijs'=>'','categorie_id'=>'','conditie'=>'Tweedehands','beschrijving'=>'','afbeelding'=>null];$fouten=[];
if($_SERVER['REQUEST_METHOD']==='POST'){
 eisPostEnCsrf();foreach(['naam','merk','maat','prijs','categorie_id','conditie','beschrijving'] as $k){$waarden[$k]=(string)($_POST[$k]??'');}
 $fouten=schoenValidatie($waarden,$categorieen);
 if(!$fouten){[$foto,$fout,$nieuwPad]=verwerkAfbeelding($_FILES);if($fout)$fouten[]=$fout;}
 if(!$fouten){
  try{
   $stmt=$pdo->prepare('INSERT INTO schoenen (gebruiker_id,categorie_id,naam,merk,maat,prijs,conditie,beschrijving,afbeelding,aangemaakt_op) VALUES (:user,:cat,:naam,:merk,:maat,:prijs,:conditie,:beschrijving,:foto,NOW())');
   $stmt->execute(['user'=>$_SESSION['gebruiker_id'],'cat'=>$waarden['categorie_id'],'naam'=>trim($waarden['naam']),'merk'=>trim($waarden['merk']),'maat'=>$waarden['maat'],'prijs'=>$waarden['prijs'],'conditie'=>$waarden['conditie'],'beschrijving'=>$waarden['beschrijving'],'foto'=>$foto]);
   header('Location: /mijn-schoenen.php');exit;
  }catch(PDOException $e){if(isset($nieuwPad)&&$nieuwPad)@unlink($nieuwPad);error_log($e->getMessage());$fouten[]='Opslaan mislukt. Probeer opnieuw.';}
 }
}
$knopTekst='Schoen aanbieden';
?>
<!DOCTYPE html>
<html lang="nl"><head><meta charset="UTF-8"><meta name="viewport" content="width=device-width, initial-scale=1"><title>Schoen toevoegen - SoleSwap</title><link rel="stylesheet" href="/assets/css/style.css"></head><body>
<?php require __DIR__.'/includes/header.php'; ?>
<main class="form-page"><section class="form-card"><a href="/mijn-schoenen.php">← Terug naar mijn schoenen</a><h1>Nieuwe schoen aanbieden 👟</h1><?php foreach($fouten as $fout): ?><p class="error" role="alert"><?= veilig($fout) ?></p><?php endforeach; ?><?php require __DIR__.'/includes/schoen-formulier.php'; ?></section></main>
<?php require __DIR__.'/includes/footer.php'; ?>
</body></html>
