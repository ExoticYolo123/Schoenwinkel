<?php
require_once __DIR__.'/includes/auth.php';
require_once __DIR__.'/includes/database.php';
require_once __DIR__.'/includes/helpers.php';
verplichtInloggen();
$stmt=$pdo->prepare('SELECT COUNT(*) FROM schoenen WHERE gebruiker_id=:id');$stmt->execute(['id'=>$_SESSION['gebruiker_id']]);$aantal=(int)$stmt->fetchColumn();
?>
<!DOCTYPE html>
<html lang="nl"><head><meta charset="UTF-8"><meta name="viewport" content="width=device-width, initial-scale=1"><title>Dashboard - SoleSwap</title><link rel="stylesheet" href="/assets/css/style.css"></head><body>
<?php require __DIR__.'/includes/header.php'; ?>
<main class="beheer-pagina"><div class="container"><h1>Welkom, <?= veilig($_SESSION['gebruikersnaam']??'Gebruiker') ?>! 👋</h1><p>Beheer jouw aanbiedingen op SoleSwap.</p><div class="dashboard-kaarten"><div class="dashboard-kaart"><h2>👟 Mijn schoenen</h2><p>Je hebt <?= $aantal ?> advertenties.</p><a class="button" href="/mijn-schoenen.php">Mijn schoenen bekijken</a></div><div class="dashboard-kaart"><h2>➕ Schoen aanbieden</h2><p>Plaats een paar schoenen.</p><a class="button" href="/schoen-toevoegen.php">Nieuwe advertentie</a></div><div class="dashboard-kaart"><h2>🏷️ Categorieën</h2><p>Beheer de soorten schoenen.</p><a class="button" href="/categorieen-beheren.php">Categorieën beheren</a></div></div></div></main>
<?php require __DIR__.'/includes/footer.php'; ?>
</body></html>
