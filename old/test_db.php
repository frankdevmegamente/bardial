<?php
require_once __DIR__ . '/includes/config.php';

echo '<h2>Test de conexión a la base de datos</h2>';
echo '<p><strong>Host:</strong> ' . htmlspecialchars(DB_HOST) . '<br>';
echo '<strong>Puerto:</strong> ' . htmlspecialchars(DB_PORT) . '<br>';
echo '<strong>Base de datos:</strong> ' . htmlspecialchars(DB_NAME) . '<br>';
echo '<strong>Usuario:</strong> ' . htmlspecialchars(DB_USER) . '</p>';

try {
    $dsn = sprintf('mysql:host=%s;port=%s;dbname=%s;charset=%s', DB_HOST, DB_PORT, DB_NAME, DB_CHARSET);
    $pdo = new PDO($dsn, DB_USER, DB_PASS, [
        PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
        PDO::ATTR_EMULATE_PREPARES   => false,
    ]);

    echo '<div style="color:green;padding:10px;border:1px solid green;border-radius:5px;">';
    echo '<strong>✅ CONECTADO correctamente a la base de datos.</strong>';
    echo '</div>';

    // Verificar si existe la tabla usuarios
    $tables = $pdo->query("SHOW TABLES")->fetchAll(PDO::FETCH_COLUMN);
    echo '<p><strong>Tablas encontradas:</strong> ' . (count($tables) ? implode(', ', $tables) : 'ninguna') . '</p>';

    if (in_array('usuarios', $tables)) {
        $count = $pdo->query('SELECT COUNT(*) FROM usuarios')->fetchColumn();
        echo '<p><strong>Usuarios registrados:</strong> ' . (int)$count . '</p>';
        $users = $pdo->query('SELECT id, username FROM usuarios')->fetchAll();
        echo '<ul>';
        foreach ($users as $u) {
            echo '<li>' . htmlspecialchars($u['username']) . '</li>';
        }
        echo '</ul>';
    } else {
        echo '<p style="color:orange;">⚠️ La tabla <code>usuarios</code> no existe aún.</p>';
    }

} catch (PDOException $e) {
    echo '<div style="color:red;padding:10px;border:1px solid red;border-radius:5px;">';
    echo '<strong>❌ ERROR DE CONEXIÓN:</strong><br>';
    echo htmlspecialchars($e->getMessage());
    echo '</div>';
}
?>
<a href="admin/login.php">Ir al login del admin</a>