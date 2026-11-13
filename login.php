<?php
require_once __DIR__.'/includes/auth.php';
require_once __DIR__.'/includes/database.php';
require_once __DIR__.'/includes/helpers.php';
if(isIngelogd()){header('Location: /dashboard.php');exit;}
$email='';$fout='';
if($_SERVER['REQUEST_METHOD']==='POST'){
 $email=trim((string)($_POST['email']??''));$pw=(string)($_POST['wachtwoord']??'');
 if(!geldigCsrfToken($_POST['csrf_token']??null)){$fout='Formulier verlopen. Probeer opnieuw.';}
 elseif(!filter_var($email,FILTER_VALIDATE_EMAIL) || $pw===''){$fout='Vul e-mail en wachtwoord in.';}
 else {
  $stmt=$pdo->prepare('SELECT id,gebruikersnaam,wachtwoord FROM gebruikers WHERE email=:email LIMIT 1');$stmt->execute(['email'=>$email]);$user=$stmt->fetch();
  if($user && password_verify($pw,$user['wachtwoord'])){
   session_regenerate_id(true); $_SESSION['gebruiker_id']=(int)$user['id'];$_SESSION['gebruikersnaam']=$user['gebruikersnaam'];unset($_SESSION['csrf_token']);
   header('Location: /dashboard.php');exit;
  }
  $fout='E-mailadres of wachtwoord onjuist.';
 }
}
?>
<!DOCTYPE html>
<html lang="nl"><head><meta charset="UTF-8"><meta name="viewport" content="width=device-width, initial-scale=1"><title>Inloggen - SoleSwap</title><link rel="stylesheet" href="/assets/css/style.css"></head><body>
<?php require __DIR__.'/includes/header.php'; ?>
<main class="form-page"><section class="form-card small"><h1>Welkom terug! 💜</h1><p>Log in op jouw SoleSwap-account.</p>
<?php if($fout): ?><p class="error" role="alert"><?= veilig($fout) ?></p><?php endif; ?>
<form method="post" class="stack"><input type="hidden" name="csrf_token" value="<?= veilig(csrfToken()) ?>"><label>E-mailadres<input type="email" name="email" autocomplete="username" required value="<?= veilig($email) ?>"></label><label>Wachtwoord<input type="password" name="wachtwoord" autocomplete="current-password" required></label><button type="submit">Inloggen</button></form></section></main>
<?php require __DIR__.'/includes/footer.php'; ?>
</body></html>
