<?php
/**
 * Seed script: migrates the hardcoded properties array to the database
 * and creates the default admin user.
 *
 * Run from the browser or CLI:
 *   php sql/seed.php
 */
require_once __DIR__ . '/../includes/config.php';

$adminUsername = 'admin';
$adminPassword = getenv('BARDIAL_ADMIN_PASSWORD') ?: null;
if ($adminPassword === null) {
    if (PHP_SAPI !== 'cli') {
        echo "❌ Configura BARDIAL_ADMIN_PASSWORD (variable de entorno) para crear el usuario admin.\n";
        exit(1);
    }
    echo 'Password para el usuario admin: ';
    $adminPassword = trim(fgets(STDIN));
}

try {
    $dsn = sprintf('mysql:host=%s;port=%s;charset=%s', DB_HOST, DB_PORT, DB_CHARSET);
    $pdo = new PDO($dsn, DB_USER, DB_PASS, [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
    ]);

    // Create database if not exists
    $pdo->exec('CREATE DATABASE IF NOT EXISTS `' . DB_NAME . '` CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci');
    $pdo->exec('USE `' . DB_NAME . '`');

    // Create tables
    $pdo->exec("
        CREATE TABLE IF NOT EXISTS propiedades (
            id INT AUTO_INCREMENT PRIMARY KEY,
            price VARCHAR(50) NOT NULL,
            price_value DECIMAL(15,2) DEFAULT NULL,
            location VARCHAR(255) NOT NULL,
            type VARCHAR(100) DEFAULT NULL,
            city VARCHAR(100) DEFAULT NULL,
            bed TINYINT UNSIGNED NOT NULL DEFAULT 0,
            bath TINYINT UNSIGNED NOT NULL DEFAULT 0,
            sqm SMALLINT UNSIGNED NOT NULL DEFAULT 0,
            services TEXT DEFAULT NULL,
            description TEXT DEFAULT NULL,
            badge VARCHAR(100) DEFAULT NULL,
            sold TINYINT(1) NOT NULL DEFAULT 0,
            video VARCHAR(255) DEFAULT NULL,
            img VARCHAR(500) NOT NULL,
            images TEXT DEFAULT NULL,
            created_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
            updated_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci
    ");

    $pdo->exec("
        CREATE TABLE IF NOT EXISTS usuarios (
            id INT AUTO_INCREMENT PRIMARY KEY,
            username VARCHAR(100) NOT NULL UNIQUE,
            password VARCHAR(255) NOT NULL,
            created_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci
    ");

    // Seed properties (only if table is empty)
    $count = $pdo->query('SELECT COUNT(*) FROM propiedades')->fetchColumn();
    if ((int)$count === 0) {
        $properties = [
            ['price' => '$12,500,000 MXN', 'price_value' => 12500000, 'location' => 'Polanco, CDMX', 'type' => 'Casa Residencial', 'city' => 'CDMX', 'bed' => 4, 'bath' => 3, 'sqm' => 320, 'services' => 'Alberca, Estacionamiento Privado, Jardín, Seguridad 24h, Chimenea', 'description' => 'Elegante residencia en el corazón de Polanco con acabados de lujo y espacios diseñados para el confort familiar.', 'badge' => 'Exclusivo', 'sold' => false, 'video' => '', 'img' => 'https://lh3.googleusercontent.com/aida-public/AB6AXuB1AXqXUcJfkFlfMdCdaMrDINgF1eGZ4ImejO_sUgGFzeDitPA73hJmy8lFxiAklVr0uvErElfjKZqJrgmeg3HPUTqlRveVkkUDa7sITvtJDSp-PO3tfjTN61cL8wiTCXJMNMUtxniV2kh89lZpxjl6H6uOvCPDiFROOjggQA1iWALGgLTqepQOjVneKzyEBvaZODFDirNMQZRDIMGaeXMXHGhJgIbJNSYDvnbu8Hidos2B5U7MFRa7IhncwOTmNCVu4ILwXJkP8Hv2', 'images' => ''],
            ['price' => '$24,500,000 MXN', 'price_value' => 24500000, 'location' => 'San Pedro Garza García, Monterrey', 'type' => 'Mansión', 'city' => 'Monterrey', 'bed' => 6, 'bath' => 7, 'sqm' => 850, 'services' => 'Alberca, Cancha de Tenis, Estacionamiento Privado, Seguridad 24h, Bodega de Vinos, Roof Garden, Gimnasio', 'description' => 'Imponente mansión en la zona más exclusiva de Monterrey con acabados europeos y vistas panorámicas.', 'badge' => 'Nuevo', 'sold' => false, 'video' => '', 'img' => 'https://lh3.googleusercontent.com/aida-public/AB6AXuDemcs02lF6RdmVHKwdp3u8z3NEvD46g7GLhq07CVAPfON2qFnLxPeBeFeH1UTEBmJBpJSkbuVXtKVNGje8pKppqbtuQVSK9UoeLyO-_-pfm5nhLNB0hrxlpj7qu7YfXIa--nza7f4jLc1WXdPgofeGOPTZsVwX-SDf19Fy74Dhc5-MuKGJarcSicTSRwbB68YEL7ETuNoykXMEEuaJ3N2_7_ajJ3EORGpQxB2xwIgKM2PD86seEDFJI_AHuJvPIKZA6gzmtltV2HpZ', 'images' => ''],
            ['price' => '$9,800,000 MXN', 'price_value' => 9800000, 'location' => 'Lomas de Chapultepec, CDMX', 'type' => 'Casa Residencial', 'city' => 'CDMX', 'bed' => 5, 'bath' => 4, 'sqm' => 410, 'services' => 'Alberca, Jardín, Estacionamiento Privado, Chimenea, Casa de Huéspedes', 'description' => 'Casa de lujo en Lomas de Chapultepec con jardín privado y casa de huéspedes.', 'badge' => 'Inversión', 'sold' => false, 'video' => '', 'img' => 'https://lh3.googleusercontent.com/aida-public/AB6AXuAPCliQa21axViQe7D5mOGLeRkOrCueDo3nnAAaCCNgttb3v_q3PU6SeGWoBjicGbtfH19mz6lkokpy1akjsqQT_AuCITCLP6lK_uIGHngLp41CH0gaaF-c9P9Ib5YKC4ihdHeh9ZwRn6ayi7BUiIvrzuHz1RRYcPKzvVdcGYh9hMFO5sFgu89vBXGL_ADTKC_fnNvU5LH8pFVCPasKIZwVhXYYgmpQAfTl2OZMKJZBO5wU-Tv6EtzYH7jsjVSIGigk5NNVSA15Ktnt', 'images' => ''],
            ['price' => '$14,200,000 MXN', 'price_value' => 14200000, 'location' => 'Santa Fe, CDMX', 'type' => 'Penthouse', 'city' => 'CDMX', 'bed' => 5, 'bath' => 4, 'sqm' => 480, 'services' => 'Vista al Mar, Seguridad 24h, Gimnasio, Alberca, Estacionamiento Privado, Roof Garden', 'description' => 'Penthouse de lujo en Santa Fe con roof garden privado y vistas espectaculares.', 'badge' => 'Exclusivo', 'sold' => false, 'video' => 'propiedad-azura-estate.mp4', 'img' => 'https://lh3.googleusercontent.com/aida-public/AB6AXuC3awN3GAOW4qt9CbSkXKYxELvz9S1GYOlRzIZOcuOCGPQyDbBA0NkErH3SWmjwqHW7bcjA0VPkzck_jFN2HvA26f94LnHQRqjHseSw2Bo9QI_ICZUd7pPCp6-1--L-Daa_Ee-GFcjhNHKJdU2RcLx-oVyGYG_HlgdfSt-fxr4gOXqai8Xs3OlBTItJ89rvdqPOk6DtbDddosDhy4w7g1pCis1IuVYGiXlu6RBGMscQ668gmc2qw3fmjCzIzuMxaAmkWkcSV6fnpIqe', 'images' => ''],
            ['price' => '$7,500,000 MXN', 'price_value' => 7500000, 'location' => 'San Miguel de Allende, Gto.', 'type' => 'Casona Colonial', 'city' => 'San Miguel de Allende', 'bed' => 3, 'bath' => 3, 'sqm' => 210, 'services' => 'Jardín, Chimenea, Tinaja, Estacionamiento Privado', 'description' => 'Casona colonial restaurada en el centro histórico de San Miguel de Allende con tinaja y jardín.', 'badge' => '', 'sold' => false, 'video' => '', 'img' => 'https://lh3.googleusercontent.com/aida-public/AB6AXuD4oV-b5mUCFWpNdVGJAqTOgAfjLR7v2Wd7NZK0Dj7pO6ycU9icfsPx3rJxrMko_BJEXgvvhfTOsdo-PHnZyDlgwEAJrgPTYwEX5CBqZyXzk6-48DM6VTkz1aUA-JnsPJmIqqc4F13Pb6RBRuGsAed8FUeiQe0tAdwatnlNZ1MANk0V2fuhiE6H1kYv8CsE35FaOEUe-Q1vmc0-bGmHRhq6nLbRhA36ec2rpppyQl6YwUCEh4-A034VOPFP7GSR0NmqMTNn7ZpKYsir', 'images' => ''],
            ['price' => '$18,900,000 MXN', 'price_value' => 18900000, 'location' => 'Los Cabos, BCS', 'type' => 'Villa', 'city' => 'Los Cabos', 'bed' => 6, 'bath' => 7, 'sqm' => 850, 'services' => 'Alberca Infinity, Vista al Mar, Muelle Privado, Helipuerto, Seguridad 24h, Palapa, Estacionamiento Privado', 'description' => 'Villa frente al mar en Los Cabos con muelle privado y helipuerto. Lujo costero en su máxima expresión.', 'badge' => '', 'sold' => false, 'video' => '', 'img' => 'https://lh3.googleusercontent.com/aida-public/AB6AXuBITVA33GJVywl4X4vmhI6OeSCHrWnGxF09TdYJgKAFNnsjF1pBEJem_XwGzhziMehqYRt0q1EEBZw2FUvg1mey00KeCCbdv7iWcHCBZSaS2EPCRknxbtWATp6V9QGEgWJlSdKAQUCEYVOauhg72dRtD9YNiM_4mqbTNYFUXnGKeQLOiCPtlOIdDv1zyLsm_ylmEW6KTawBziJIKVG4_vi_zj-IlrJOtTYAvi_H9jjtkkdblP-gyg-Y0vUafabNJ0mY1dMPjcn22ovV', 'images' => ''],
            ['price' => '$8,900,000 MXN', 'price_value' => 8900000, 'location' => 'Mérida, Yucatán', 'type' => 'Hacienda', 'city' => 'Mérida', 'bed' => 4, 'bath' => 3, 'sqm' => 320, 'services' => 'Alberca, Jardín, Chimenea, Estacionamiento Privado', 'description' => 'Hacienda restaurada en Mérida con alberca y amplios jardines tropicales.', 'badge' => 'Vendido', 'sold' => true, 'video' => '', 'img' => 'https://lh3.googleusercontent.com/aida-public/AB6AXuAnVkfOmOD0TeOslFsy_yVO9PQ44bcCzJrxjINzTpc32glD_xRzG0zg15stm4Ltzv8k9gCNLgV5JrIEoIWLKDyH8MTZbzCYkwEHxWoEy1VquwdSXzoHLqQLcyNlah8ZFqohUJzW4wvE1btm9Vvu6eX08HxJQ8dSiJOOKXmcD3BzTesdAxIHAtlavH0ZrM10bqt98AC8k-0Nt1cL-__owcnpvcYzdEy7-QeEZigy3zSXRNYLtw3XRsHt55GOs3kAlbF2VyqHq3WGKMGl', 'images' => ''],
            ['price' => '$22,000,000 MXN', 'price_value' => 22000000, 'location' => 'Puerto Vallarta, Jal.', 'type' => 'Villa', 'city' => 'Puerto Vallarta', 'bed' => 7, 'bath' => 8, 'sqm' => 1200, 'services' => 'Alberca Infinity, Vista al Mar, Muelle Privado, Gimnasio, Spa, Roof Garden, Seguridad 24h, Estacionamiento Privado', 'description' => 'Espectacular villa en Puerto Vallarta con spa, gimnasio y acceso directo al mar.', 'badge' => '', 'sold' => false, 'video' => '', 'img' => 'https://lh3.googleusercontent.com/aida-public/AB6AXuCFMG0wgel2uEkU_9YIe9K0J90NiXBHf3qlx_qsak5Rz3rcdrZR5NIP00nfG10JNA_GnMaHwu1NvpsxKNqslxm0FqC9A7NSXxBQhUOEitQmww_ejsHguzfk09bjSqCE9PSUF0jtuR6YMlA9gaLyJfJJNEq8qUrvRApMjrrXAEgrLNSZQejq_2gUButOF1kXmnQQKdAVWGHs30jikObemlH9ASzdRpjQ_-HsWi_yqfWrS7ITkVAJMKPejyiDfurUXr1aJPeyVdXLPcha', 'images' => ''],
            ['price' => '$5,900,000 MXN', 'price_value' => 5900000, 'location' => 'Tulum, Quintana Roo', 'type' => 'Departamento Premium', 'city' => 'Tulum', 'bed' => 2, 'bath' => 2, 'sqm' => 165, 'services' => 'Vista al Mar, Seguridad 24h, Alberca, Gimnasio, Estacionamiento Privado', 'description' => 'Departamento premium frente al mar en Tulum con amenidades de primer nivel.', 'badge' => '', 'sold' => false, 'video' => '', 'img' => 'https://lh3.googleusercontent.com/aida-public/AB6AXuC171uM2HIxfyby1OgpYwTfIxQlos-hF0YWnLXgvxpiKvCPtw8JACSg20s2CsIdujfkoPnUtQYvbv7jkPL11jwM9AxMivcu_eIenyjTrWCrqDQSBd-NOTiCOV2ryoyTUMQIdViiKI5xjfukQSgKdiR9tlMdCnCZI3YIX3uVfLQlc3-YIr-TmDYCHMI95yjUXcdDxkTWvuBUV-GyQiQTZ2wVzwhbzYvDWmAA1h9Ws754PKeutrotuLqyzhg8vKVY-tWddcfwNJlCmWRI', 'images' => ''],
        ];

        $stmt = $pdo->prepare('INSERT INTO propiedades (price, price_value, location, type, city, bed, bath, sqm, services, description, badge, sold, video, img, images) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)');
        foreach ($properties as $p) {
            $stmt->execute([
                $p['price'],
                $p['price_value'],
                $p['location'],
                $p['type'],
                $p['city'],
                $p['bed'],
                $p['bath'],
                $p['sqm'],
                $p['services'],
                $p['description'],
                $p['badge'] ?: null,
                $p['sold'] ? 1 : 0,
                $p['video'] ?: null,
                $p['img'],
                $p['images'] ?: null,
            ]);
        }
        echo "✓ " . count($properties) . " propiedades insertadas.\n";
    } else {
        echo "ℹ La tabla propiedades ya tiene $count registro(s). No se insertaron datos de prueba.\n";
    }

    // Seed admin user (only if not exists)
    $userCheck = $pdo->prepare('SELECT COUNT(*) FROM usuarios WHERE username = ?');
    $userCheck->execute([$adminUsername]);
    if ((int)$userCheck->fetchColumn() === 0) {
        $hash = password_hash($adminPassword, PASSWORD_BCRYPT);
        $pdo->prepare('INSERT INTO usuarios (username, password) VALUES (?, ?)')->execute([$adminUsername, $hash]);
        echo "✓ Usuario admin creado: $adminUsername / $adminPassword\n";
    } else {
        echo "ℹ El usuario '$adminUsername' ya existe.\n";
    }

    // Seed extra admin user(s) via env vars BARDIAL_EXTRA_USERNAME / BARDIAL_EXTRA_PASSWORD
    $extraUser = getenv('BARDIAL_EXTRA_USERNAME') ?: null;
    $extraPass = getenv('BARDIAL_EXTRA_PASSWORD') ?: null;
    if ($extraUser !== null && $extraPass !== null && $extraUser !== '' && $extraPass !== '') {
        $userCheck = $pdo->prepare('SELECT COUNT(*) FROM usuarios WHERE username = ?');
        $userCheck->execute([$extraUser]);
        if ((int)$userCheck->fetchColumn() === 0) {
            $hash = password_hash($extraPass, PASSWORD_BCRYPT);
            $pdo->prepare('INSERT INTO usuarios (username, password) VALUES (?, ?)')->execute([$extraUser, $hash]);
            echo "✓ Usuario extra creado: $extraUser / $extraPass\n";
        } else {
            echo "ℹ El usuario '$extraUser' ya existe.\n";
        }
    }

    echo "\n✅ Setup completado correctamente.\n";

} catch (PDOException $e) {
    echo "❌ Error: " . $e->getMessage() . "\n";
    exit(1);
}
