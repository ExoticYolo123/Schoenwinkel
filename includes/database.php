<?php
$wachtwoord = getenv('MYSQL_PASSWORD');
if (!$wachtwoord) {
    http_response_code(500);
    exit('Databaseconfiguratie ontbreekt.');
}
try {
    $pdo = new PDO('mysql:host=db;dbname=soleswap;charset=utf8mb4', 'soleswap_user', $wachtwoord, [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
        PDO::ATTR_EMULATE_PREPARES => false
    ]);
} catch (PDOException $e) {
    error_log($e->getMessage());
    http_response_code(500);
    exit('Databaseverbinding mislukt.');
}
