<?php
require_once __DIR__.'/includes/auth.php';
require_once __DIR__.'/includes/database.php';
require_once __DIR__.'/includes/helpers.php';
verplichtInloggen();
$id=filter_input(INPUT_GET,'id',FILTER_VALIDATE_INT,['options'=>['min_range'=>1]]);
if(!$id){http_response_code(400);exit('Ongeldig ID.');}
$stmt=$pdo->prepare('SELECT * FROM schoenen WHERE id=:id AND gebruiker_id=:user');$stmt->execute(['id'=>$id,'user'=>$_SESSION['gebruiker_id']]);$huidig=$stmt->fetch();
if(!$huidig){http_response_code(404);exit('Advertentie niet gevonden.');}
$categorieen=$pdo->query('SELECT id,naam FROM categorieen ORDER BY naam')->fetchAll();
$waarden=$huidig;$fouten=[];
if($_SERVER['REQUEST_METHOD']==='POST'){
 eisPostEnCsrf();foreach(['naam','merk','maat','prijs','categorie_id','conditie','beschrijving'] as $k){$waarden[$k]=(string)($_POST[$k]??'');}
 $fouten=schoenValidatie($waarden,$categorieen);
 if(!$fouten){[$foto,$fout,$nieuwPad]=verwerkAfbeelding($_FILES,$huidig['afbeelding']);if($fout)$fouten[]=$fout;}
 if(!$fouten){
  try{
   $stmt=$pdo->prepare('UPDATE schoenen SET categorie_id=:cat, naam=:naam,merk=:merk,maat=:maat,prijs=:prijs,conditie=:conditie,beschrijving=:beschrijving,afbeelding=:foto WHERE id=:id AND gebruiker_id=:user');
   $stmt->execute(['cat'=>$waarden['categorie_id'],'naam'=>trim($waarden['naam']),'merk'=>trim($waarden['merk']),'maat'=>$waarden['maat'],'prijs'=>$waarden['prijs'],'conditie'=>$waarden['conditie'],'beschrijving'=>$waarden['beschrijving'],'foto'=>$foto,'id'=>$id,'user'=>$_SESSION['gebruiker_id']]);
   if($nieuwPad && $huidig['afbeelding'] && preg_match('/^[a-f0-9]{32}\.(jpg|png|webp)$/',$huidig['afbeelding'])) @unlink(__DIR__.'/assets/img/'.$huidig['afbeelding']);
   header('Location: /mijn-schoenen.php');exit;
  }catch(PDOException $e){if(isset($nieuwPad)&&$nieuwPad)@unlink($nieuwPad);error_log($e->getMessage());$fouten[]='Wijzigen mislukt.';}
 }
}
$knopTekst='Wijzigingen opslaan';
?>
<!DOCTYPE html>
<html lang="nl"><head><meta charset="UTF-8"><meta name="viewport" content="width=device-width, initial-scale=1"><title>Schoen aanpassen - SoleSwap</title><link rel="stylesheet" href="/assets/css/style.css"></head><body>
<?php require __DIR__.'/includes/header.php'; ?>
<main class="form-page"><section class="form-card"><a href="/mijn-schoenen.php">← Terug naar mijn schoenen</a><h1>Schoen aanpassen</h1><?php foreach($fouten as $fout): ?><p class="error" role="alert"><?= veilig($fout) ?></p><?php endforeach; ?><?php require __DIR__.'/includes/schoen-formulier.php'; ?></section></main>
<?php require __DIR__.'/includes/footer.php'; ?>
</body></html>
