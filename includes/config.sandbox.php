<?php
// config.php PARA EL SERVIDOR sandbox.bardial.mx
// Subelo como: includes/config.php (renombralo, reemplaza el viejo)
// Tu localhost NO se toca, sigue con root/bardial en tu PC.
define('DB_HOST', 'localhost');
define('DB_PORT', '3306');
define('DB_NAME', 'albardim_bardial');
define('DB_USER', 'albardim_bardial');
// CAMBIA esta clave por la nueva que generes en cPanel (la que pegaste ya quedo expuesta).
define('DB_PASS', '!Pq]2L0=_!,JZ=I0');
define('DB_CHARSET', 'utf8mb4');

// En produccion pon la URL publica para QR y lona.
define('SITE_URL', 'https://sandbox.bardial.mx');

function siteBaseUrl(): string {
    static $base = null;
    if ($base !== null) {
        return $base;
    }

    $docRoot = str_replace('\\', '/', realpath($_SERVER['DOCUMENT_ROOT'] ?? '.'));
    $appRoot = str_replace('\\', '/', dirname(__DIR__));

    if ($docRoot && strpos($appRoot, $docRoot) === 0) {
        $rel = substr($appRoot, strlen($docRoot));
    } else {
        $script = str_replace('\\', '/', $_SERVER['SCRIPT_NAME'] ?? '');
        $rel = rtrim(str_replace(basename($script), '', $script), '/');
    }

    $rel = trim($rel, '/');
    $base = $rel === ''
        ? ''
        : '/' . implode('/', array_map('rawurlencode', explode('/', $rel)));
    return $base;
}

function siteAbsoluteUrl(): string {
    static $abs = null;
    if ($abs !== null) {
        return $abs;
    }

    if (defined('SITE_URL') && SITE_URL !== '') {
        $abs = rtrim(SITE_URL, '/');
    } else {
        $scheme = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off') ? 'https' : 'http';
        if (($_SERVER['HTTP_X_FORWARDED_PROTO'] ?? '') === 'https') {
            $scheme = 'https';
        }
        $host = $_SERVER['HTTP_HOST'] ?? 'localhost';
        $abs = $scheme . '://' . $host . siteBaseUrl();
    }
    return $abs;
}

function propertyAbsoluteUrl(int $id): string {
    return siteAbsoluteUrl() . '/detalles.php?id=' . $id;
}

// URL web para imagenes locales (uploads/, assets/) que funciona
// tanto en localhost como en subdominio (raiz /).
function assetUrl(string $path): string {
    $path = trim($path);
    if ($path === '' || preg_match('#^https?://#i', $path) || strpos($path, 'data:') === 0) {
        return $path;
    }
    $path = ltrim($path, '/');
    return siteBaseUrl() . '/' . $path;
}

function propertyImgUrl($img): string {
    return assetUrl((string)($img ?? ''));
}
