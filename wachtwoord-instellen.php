<?php
// Alleen via de terminal uitvoeren
if (PHP_SAPI !== 'cli') {
    http_response_code(403);
    exit('Geen toegang.');
}

// Databaseverbinding
require_once __DIR__ . '/includes/database.php';

// Testgebruiker
$email = 'sam@example.com';

// Tijdelijk testwachtwoord
$wachtwoord = 'Test1234!';

// Wachtwoord veilig hashen
$hash = password_hash(
    $wachtwoord,
    PASSWORD_DEFAULT
);

// Bestaande gebruiker bijwerken
$sql = "UPDATE gebruikers
        SET wachtwoord = :wachtwoord
        WHERE email = :email";

$stmt = $pdo->prepare($sql);

$stmt->execute([
    'wachtwoord' => $hash,
    'email' => $email
]);

if ($stmt->rowCount() > 0) {
    echo "Wachtwoord van Sam ingesteld!\n";
} else {
    echo "Sam niet gevonden of niet bijgewerkt.\n";
}
