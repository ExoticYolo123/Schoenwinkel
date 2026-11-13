<?php
require_once __DIR__ . '/includes/auth.php';
require_once __DIR__ . '/includes/database.php';
require_once __DIR__ . '/includes/helpers.php';
verplichtInloggen();
$stmt = $pdo->prepare('SELECT id,naam,merk,maat,prijs,conditie FROM schoenen WHERE gebruiker_id=:id ORDER BY id DESC');
$stmt->execute(['id' => $_SESSION['gebruiker_id']]);
$schoenen = $stmt->fetchAll();
?>
<!DOCTYPE html>
<html lang="nl">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Mijn schoenen - SoleSwap</title>
    <link rel="stylesheet" href="/assets/css/style.css">
</head>

<body>
    <?php require __DIR__ . '/includes/header.php'; ?>
    <main class="beheer-pagina">
        <div class="container">
            <div class="page-top">
                <h1>Mijn schoenen 👟</h1><a class="button" href="/schoen-toevoegen.php">+ Schoen toevoegen</a>
            </div>
            <?php if (!$schoenen): ?>
                <p class="empty">Je hebt nog geen schoenen aangeboden.</p><?php endif; ?>
            <div class="beheer-lijst"><?php foreach ($schoenen as $s): ?>
                    <article class="beheer-item">
                        <div>
                            <h2><?= veilig($s['naam']) ?></h2>
                            <p><?= veilig($s['merk']) ?> · Maat <?= veilig(maatWeergave($s['maat'])) ?> ·
                                €<?= number_format((float) $s['prijs'], 2, ',', '.') ?></p>
                        </div>
                        <div class="acties"><a class="button alt" href="/schoen.php?id=<?= (int) $s['id'] ?>">Bekijken</a><a
                                class="button" href="/schoen-bewerken.php?id=<?= (int) $s['id'] ?>">Aanpassen</a>
                            <form method="post" action="/schoen-verwijderen.php"
                                data-confirm="Deze schoen echt verwijderen?"><input type="hidden" name="csrf_token"
                                    value="<?= veilig(csrfToken()) ?>"><input type="hidden" name="id"
                                    value="<?= (int) $s['id'] ?>"><button class="danger" type="submit">Verwijderen</button>
                            </form>
                        </div>
                    </article><?php endforeach; ?>
            </div>
        </div>
    </main>
    <?php require __DIR__ . '/includes/footer.php'; ?>
</body>

</html>