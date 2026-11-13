<?php
ini_set('session.use_strict_mode', '1');
ini_set('session.use_only_cookies', '1');
if (session_status() === PHP_SESSION_NONE) {
    session_set_cookie_params([
        'lifetime' => 0, 'path' => '/',
        'secure' => !empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off',
        'httponly' => true, 'samesite' => 'Lax'
    ]);
    session_start();
}
function veilig($waarde): string {
    return htmlspecialchars((string)$waarde, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8');
}
function isIngelogd(): bool {
    return isset($_SESSION['gebruiker_id']);
}
function verplichtInloggen(): void {
    if (!isIngelogd()) {
        header('Location: /login.php');
        exit;
    }
}
function csrfToken(): string {
    if (empty($_SESSION['csrf_token'])) {
        $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
    }
    return $_SESSION['csrf_token'];
}
function geldigCsrfToken($waarde): bool {
    return is_string($waarde) && hash_equals(csrfToken(), $waarde);
}
function eisPostEnCsrf(): void {
    if ($_SERVER['REQUEST_METHOD'] !== 'POST' || !geldigCsrfToken($_POST['csrf_token'] ?? null)) {
        http_response_code(403);
        exit('Ongeldig verzoek. Ga terug en probeer opnieuw.');
    }
}
