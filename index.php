<?php
require_once __DIR__.'/includes/auth.php';
require_once __DIR__.'/includes/database.php';
require_once __DIR__.'/includes/helpers.php';
$stmt=$pdo->query("SELECT s.*, g.gebruikersnaam AS verkoper FROM schoenen s INNER JOIN gebruikers g ON g.id=s.gebruiker_id ORDER BY s.aangemaakt_op DESC, s.id DESC LIMIT 2");
$schoenen=$stmt->fetchAll();
?>
<!DOCTYPE html>
<html lang="nl"><head><meta charset="UTF-8"><meta name="viewport" content="width=device-width, initial-scale=1"><title>Home - SoleSwap</title><link rel="stylesheet" href="/assets/css/style.css"></head><body>
<?php require __DIR__.'/includes/header.php'; ?>
<main><section class="hero"><p class="eyebrow">JOUW SNEAKERS, JOUW STYLE</p><h1>Geef sneakers een tweede leven! 👟</h1><p>Ontdek unieke schoenen of verkoop jouw eigen paar.</p><a class="button" href="/schoenen.php">Bekijk schoenen</a></section>
<section class="schoenen"><h2>Nieuw aangeboden 🔥</h2><div class="schoenen-container">
<?php foreach($schoenen as $schoen) require __DIR__.'/includes/schoen-kaart.php'; ?>
</div><?php if(!$schoenen): ?><p class="empty">Nog geen schoenen geplaatst.</p><?php endif; ?></section></main>
<?php require __DIR__.'/includes/footer.php'; ?>
</body></html>
