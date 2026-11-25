<?php
// diagnostico.php — súbelo a la RAÍZ del subdominio, visítalo una vez y BÓRRALO.
// No muestra la contraseña, solo si conecta y cuántas propiedades hay.
header('Content-Type: text/plain; charset=utf-8');

echo "== Bardial diagnostico ==\n";
echo "PHP: " . PHP_VERSION . "\n";
echo "PDO mysql: " . (extension_loaded('pdo_mysql') ? 'si' : 'NO') . "\n";
echo "Host: " . ($_SERVER['HTTP_HOST'] ?? '?') . "\n";

$root = __DIR__;
echo "Docroot archivo: $root\n";
echo "config.php: " . (file_exists($root . '/includes/config.php') ? 'existe' : 'FALTA') . "\n";
echo "uploads/ existe: " . (is_dir($root . '/uploads') ? 'si' : 'NO (crear con 755)') . "\n";
echo "uploads/ escribible: " . (is_writable($root . '/uploads') ? 'si' : 'NO') . "\n";

if (!file_exists($root . '/includes/config.php')) {
    echo "\nFALTA includes/config.php en el servidor. Crealo con los datos de cPanel > MySQL Databases.\n";
    exit;
}

require $root . '/includes/config.php';
echo "DB_HOST: " . DB_HOST . "\n";
echo "DB_NAME: " . DB_NAME . "\n";
echo "DB_USER: " . DB_USER . "\n";
echo "baseUrl: '" . siteBaseUrl() . "'\n";
echo "absoluteUrl: '" . siteAbsoluteUrl() . "'\n";

try {
    require $root . '/includes/db.php';
    $props = getAllProperties();
    echo "Conexion BD: OK\n";
    echo "Total propiedades: " . count($props) . "\n";
    if (count($props) === 0) {
        echo "CAUSA MAS PROBABLE: tabla 'propiedades' vacia en ESTA bd. Importa sql/setup.sql y corre sql/seed.php o crea desde /admin.\n";
    } else {
        $p = $props[0];
        echo "Ejemplo id=" . ($p['id'] ?? '?') . " img=" . ($p['img'] ?? '?') . "\n";
        echo "img resuelta: " . propertyImgUrl($p['img'] ?? '') . "\n";
    }
} catch (Throwable $e) {
    echo "Conexion BD: FALLO\n";
    echo "Error: " . $e->getMessage() . "\n";
    echo "Revisa DB_HOST/NAME/USER/PASS de cPanel. La web muestra vacio por este error (ver error_log).\n";
}

echo "\nBORRA este archivo despues de usarlo.\n";
