<?php
require_once __DIR__.'/includes/auth.php';
require_once __DIR__.'/includes/database.php';
require_once __DIR__.'/includes/helpers.php';
verplichtInloggen();eisPostEnCsrf();
$id=filter_var($_POST['id']??null,FILTER_VALIDATE_INT,['options'=>['min_range'=>1]]);
if(!$id){http_response_code(400);exit('Ongeldig ID.');}
$stmt=$pdo->prepare('SELECT afbeelding FROM schoenen WHERE id=:id AND gebruiker_id=:user');$stmt->execute(['id'=>$id,'user'=>$_SESSION['gebruiker_id']]);$s=$stmt->fetch();
if(!$s){http_response_code(404);exit('Advertentie niet gevonden.');}
$stmt=$pdo->prepare('DELETE FROM schoenen WHERE id=:id AND gebruiker_id=:user');$stmt->execute(['id'=>$id,'user'=>$_SESSION['gebruiker_id']]);
if($s['afbeelding'] && preg_match('/^[a-f0-9]{32}\.(jpg|png|webp)$/',$s['afbeelding'])) @unlink(__DIR__.'/assets/img/'.$s['afbeelding']);
header('Location: /mijn-schoenen.php');exit;
