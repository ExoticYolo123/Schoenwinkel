
<?php

// Alleen uitvoeren via de terminal
if (PHP_SAPI !== 'cli') {
    http_response_code(403);
    exit('Geen toegang.');
}

// Databaseverbinding laden
require_once __DIR__ . '/includes/database.php';

// Alle schoenen ophalen
$sql = "SELECT id, naam, merk, maat, prijs
        FROM schoenen";

$stmt = $pdo->query($sql);

$schoenen = $stmt->fetchAll();

// Resultaten tonen
echo "Databaseverbinding werkt!\n";
echo "Aantal schoenen: " . count($schoenen) . "\n\n";

foreach ($schoenen as $schoen) {
    echo "Naam: " . $schoen['naam'] . "\n";
    echo "Merk: " . $schoen['merk'] . "\n";
    echo "Maat: " . $schoen['maat'] . "\n";
    echo "Prijs: EUR " . $schoen['prijs'] . "\n";
    echo "----------------------\n";
}
