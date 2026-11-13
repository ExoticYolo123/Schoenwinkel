<?php
function schoenFoto(?string $naam): ?string {
    if (!$naam) return null;
    $bestandsnaam = basename($naam);
    if (!preg_match('/^[a-zA-Z0-9_.-]+\.(jpg|jpeg|png|webp)$/i', $bestandsnaam)) return null;
    if (!is_file(__DIR__ . '/../assets/img/' . $bestandsnaam)) return null;
    return '/assets/img/' . rawurlencode($bestandsnaam);
}
function maatWeergave($maat): string {
    return rtrim(rtrim(number_format((float)$maat, 1, '.', ''), '0'), '.');
}
function schoenValidatie(array $post, array $categorieen): array {
    $errors=[];
    $naam=trim((string)($post['naam'] ?? ''));
    $merk=trim((string)($post['merk'] ?? ''));
    $maat=(string)($post['maat'] ?? '');
    $prijs=(string)($post['prijs'] ?? '');
    $conditie=(string)($post['conditie'] ?? '');
    $categorie=(string)($post['categorie_id'] ?? '');
    $beschrijving=trim((string)($post['beschrijving'] ?? ''));
    if ($naam==='' || mb_strlen($naam)>150) $errors[]='Naam: 1 tot 150 tekens.';
    if ($merk==='' || mb_strlen($merk)>100) $errors[]='Merk: 1 tot 100 tekens.';
    if (!preg_match('/^\d{1,2}(?:\.[05])?$/', $maat) || (float)$maat<15 || (float)$maat>60) $errors[]='Kies een geldige maat (15 t/m 60, stappen van 0.5).';
    if (!preg_match('/^\d{1,8}(?:\.\d{1,2})?$/', $prijs) || (float)$prijs<=0) $errors[]='Vul een geldige prijs boven 0 in (bijv. 75.00).';
    if (!in_array($conditie,['Nieuw','Tweedehands'],true)) $errors[]='Ongeldige conditie.';
    if (!in_array($categorie, array_map(fn($c)=>(string)$c['id'],$categorieen),true)) $errors[]='Kies een bestaande categorie.';
    if (mb_strlen($beschrijving)>5000) $errors[]='Beschrijving te lang (maximaal 5000 tekens).';
    return $errors;
}
function verwerkAfbeelding(array $files, ?string $oud = null): array {
    if (!isset($files['afbeelding']) || $files['afbeelding']['error']===UPLOAD_ERR_NO_FILE) return [$oud, null, null];
    $f=$files['afbeelding'];
    if ($f['error']!==UPLOAD_ERR_OK || $f['size']>5*1024*1024 || !is_uploaded_file($f['tmp_name'])) return [$oud, 'Upload mislukt of afbeelding is groter dan 5 MB.', null];
    $type=(new finfo(FILEINFO_MIME_TYPE))->file($f['tmp_name']);
    $ext=['image/jpeg'=>'jpg','image/png'=>'png','image/webp'=>'webp'][$type]??null;
    if (!$ext || !@getimagesize($f['tmp_name'])) return [$oud, 'Gebruik een JPG-, PNG- of WebP-afbeelding.', null];
    $naam=bin2hex(random_bytes(16)).'.'.$ext;
    $pad=__DIR__.'/../assets/img/'.$naam;
    if (!move_uploaded_file($f['tmp_name'],$pad)) return [$oud, 'Afbeelding kon niet worden opgeslagen.', null];
    return [$naam, null, $pad];
}
