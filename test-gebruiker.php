
<?php

// Dit bestand mag alleen via de terminal draaien
if (PHP_SAPI !== 'cli') {
    http_response_code(403);
    exit('Geen toegang.');
}

// Databasegegevens
$host = 'db';
$database = 'soleswap';
$gebruikersnaam = 'soleswap_user';
$databaseWachtwoord = getenv('MYSQL_PASSWORD');

try {
    // Verbinding maken met MySQL
    $pdo = new PDO(
        "mysql:host=$host;dbname=$database;charset=utf8mb4",
        $gebruikersnaam,
        $databaseWachtwoord,
        [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
        ]
    );

    echo "Databaseverbinding gelukt!\n";

    // Gegevens van Sam
    $naam = 'Sam';
    $email = 'sam@example.com';

    // Controleren of Sam al bestaat
    $controle = $pdo->prepare(
        "SELECT id FROM gebruikers WHERE email = :email"
    );

    $controle->execute([
        'email' => $email
    ]);

    if ($controle->fetch()) {
        exit("Sam bestaat al in de database.\n");
    }

    // Wachtwoord beveiligen
    $wachtwoord = password_hash(
        'Test1234!',
        PASSWORD_DEFAULT
    );

    // Sam toevoegen
    $sql = "INSERT INTO gebruikers
            (gebruikersnaam, email, wachtwoord)
            VALUES (:naam, :email, :wachtwoord)";

    $stmt = $pdo->prepare($sql);

    $stmt->execute([
        'naam' => $naam,
        'email' => $email,
        'wachtwoord' => $wachtwoord
    ]);

    echo "Testgebruiker Sam is toegevoegd!\n";

} catch (PDOException $e) {

    // Tijdelijk de foutmelding tonen voor debugging
    echo "DATABASEFOUT:\n";
    echo $e->getMessage() . "\n";
}
