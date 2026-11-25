<?php
// API JSON para el checklist de documentos por casa.
// Acciones: ?action=save (POST JSON, upsert), ?action=update (POST JSON con id),
// ?action=delete (POST id -> soft-delete), ?action=restore (POST id, solo dev),
// ?action=load&casa=..&direccion=.., ?action=list, ?action=get&id=..
// SOFT-DELETE: delete solo pone deleted_at=NOW(); el registro queda en la DB
// para el desarrollador y se oculta del front (list/load/get filtran deleted_at IS NULL).
header('Content-Type: application/json; charset=utf-8');
require_once __DIR__ . '/includes/db.php';

function out($data, $code = 200) {
    http_response_code($code);
    echo json_encode($data, JSON_UNESCAPED_UNICODE);
    exit;
}

function ensureSchema(PDO $pdo): void {
    $pdo->exec("CREATE TABLE IF NOT EXISTS checklist_expedientes (
        id INT AUTO_INCREMENT PRIMARY KEY,
        casa_nombre VARCHAR(255) NOT NULL,
        direccion VARCHAR(255) NOT NULL DEFAULT '',
        item1 TINYINT(1) NOT NULL DEFAULT 0,
        item2 TINYINT(1) NOT NULL DEFAULT 0,
        item3 TINYINT(1) NOT NULL DEFAULT 0,
        item4 TINYINT(1) NOT NULL DEFAULT 0,
        item5 TINYINT(1) NOT NULL DEFAULT 0,
        item6 TINYINT(1) NOT NULL DEFAULT 0,
        item7 TINYINT(1) NOT NULL DEFAULT 0,
        item8 TINYINT(1) NOT NULL DEFAULT 0,
        item9 TINYINT(1) NOT NULL DEFAULT 0,
        item10 TINYINT(1) NOT NULL DEFAULT 0,
        item11 TINYINT(1) NOT NULL DEFAULT 0,
        created_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
        updated_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
        deleted_at DATETIME DEFAULT NULL,
        UNIQUE KEY uq_casa_direccion (casa_nombre, direccion),
        KEY idx_casa (casa_nombre),
        KEY idx_deleted (deleted_at)
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci");
    // Migración para DBs ya creadas sin deleted_at
    $col = $pdo->query("SHOW COLUMNS FROM checklist_expedientes LIKE 'deleted_at'")->fetch();
    if (!$col) {
        $pdo->exec("ALTER TABLE checklist_expedientes ADD COLUMN deleted_at DATETIME DEFAULT NULL, ADD KEY idx_deleted (deleted_at)");
    }
}

function readBody(): array {
    $body = json_decode(file_get_contents('php://input'), true);
    return is_array($body) ? $body : $_POST;
}

function readItems(array $body): array {
    $items = [];
    for ($i = 1; $i <= 11; $i++) {
        $items[$i] = !empty($body["item$i"]) ? 1 : 0;
    }
    return $items;
}

try {
    $pdo = getDB();
    ensureSchema($pdo);

    $action = $_GET['action'] ?? 'list';

    if ($action === 'save' && $_SERVER['REQUEST_METHOD'] === 'POST') {
        $body = readBody();
        $casa = trim($body['casa_nombre'] ?? $body['casa'] ?? '');
        $direccion = trim($body['direccion'] ?? '');
        if ($casa === '') out(['ok' => false, 'error' => 'El nombre de la casa es obligatorio.'], 422);
        $items = readItems($body);
        // Upsert por (casa_nombre, direccion) solo entre no borrados;
        // si estaba borrado, se revive (deleted_at=NULL).
        $stmt = $pdo->prepare('SELECT id FROM checklist_expedientes WHERE casa_nombre = ? AND direccion = ?');
        $stmt->execute([$casa, $direccion]);
        $row = $stmt->fetch();
        if ($row) {
            $pdo->prepare('UPDATE checklist_expedientes SET item1=?,item2=?,item3=?,item4=?,item5=?,item6=?,item7=?,item8=?,item9=?,item10=?,item11=?,deleted_at=NULL WHERE id=?')
                ->execute([$items[1],$items[2],$items[3],$items[4],$items[5],$items[6],$items[7],$items[8],$items[9],$items[10],$items[11], $row['id']]);
            $id = (int)$row['id'];
        } else {
            $pdo->prepare('INSERT INTO checklist_expedientes (casa_nombre,direccion,item1,item2,item3,item4,item5,item6,item7,item8,item9,item10,item11) VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?)')
                ->execute([$casa,$direccion,$items[1],$items[2],$items[3],$items[4],$items[5],$items[6],$items[7],$items[8],$items[9],$items[10],$items[11]]);
            $id = (int)$pdo->lastInsertId();
        }
        out(['ok' => true, 'id' => $id]);
    }

    if ($action === 'update' && $_SERVER['REQUEST_METHOD'] === 'POST') {
        $body = readBody();
        $id = (int)($body['id'] ?? 0);
        $casa = trim($body['casa_nombre'] ?? $body['casa'] ?? '');
        $direccion = trim($body['direccion'] ?? '');
        if ($id <= 0) out(['ok' => false, 'error' => 'Falta el id.'], 422);
        if ($casa === '') out(['ok' => false, 'error' => 'El nombre de la casa es obligatorio.'], 422);
        $cur = $pdo->prepare('SELECT id FROM checklist_expedientes WHERE id = ? AND deleted_at IS NULL');
        $cur->execute([$id]);
        if (!$cur->fetch()) out(['ok' => false, 'error' => 'No encontrado.'], 404);
        $dup = $pdo->prepare('SELECT id FROM checklist_expedientes WHERE casa_nombre = ? AND direccion = ? AND id <> ? AND deleted_at IS NULL');
        $dup->execute([$casa, $direccion, $id]);
        if ($dup->fetch()) out(['ok' => false, 'error' => 'Ya existe otro expediente con esa casa/dirección.'], 409);
        $items = readItems($body);
        $pdo->prepare('UPDATE checklist_expedientes SET casa_nombre=?,direccion=?,item1=?,item2=?,item3=?,item4=?,item5=?,item6=?,item7=?,item8=?,item9=?,item10=?,item11=? WHERE id=?')
            ->execute([$casa,$direccion,$items[1],$items[2],$items[3],$items[4],$items[5],$items[6],$items[7],$items[8],$items[9],$items[10],$items[11], $id]);
        out(['ok' => true, 'id' => $id]);
    }

    if ($action === 'delete' && $_SERVER['REQUEST_METHOD'] === 'POST') {
        $body = readBody();
        $id = (int)($body['id'] ?? $_GET['id'] ?? 0);
        if ($id <= 0) out(['ok' => false, 'error' => 'Falta el id.'], 422);
        $stmt = $pdo->prepare('UPDATE checklist_expedientes SET deleted_at = NOW() WHERE id = ? AND deleted_at IS NULL');
        $stmt->execute([$id]);
        if ($stmt->rowCount() === 0) out(['ok' => false, 'error' => 'No encontrado o ya eliminado.'], 404);
        out(['ok' => true, 'id' => $id, 'soft' => true]);
    }

    if ($action === 'restore' && $_SERVER['REQUEST_METHOD'] === 'POST') {
        // Solo para el desarrollador (revivir un soft-deleted desde la DB/API directa)
        $body = readBody();
        $id = (int)($body['id'] ?? $_GET['id'] ?? 0);
        if ($id <= 0) out(['ok' => false, 'error' => 'Falta el id.'], 422);
        $stmt = $pdo->prepare('UPDATE checklist_expedientes SET deleted_at = NULL WHERE id = ?');
        $stmt->execute([$id]);
        if ($stmt->rowCount() === 0) out(['ok' => false, 'error' => 'No encontrado.'], 404);
        out(['ok' => true, 'id' => $id]);
    }

    if ($action === 'load') {
        $casa = trim($_GET['casa'] ?? '');
        $direccion = trim($_GET['direccion'] ?? '');
        if ($casa === '') out(['ok' => false, 'error' => 'Falta el parámetro casa.'], 422);
        $stmt = $pdo->prepare('SELECT * FROM checklist_expedientes WHERE casa_nombre = ? AND direccion = ? AND deleted_at IS NULL');
        $stmt->execute([$casa, $direccion]);
        $row = $stmt->fetch();
        if (!$row) out(['ok' => false, 'error' => 'No existe expediente para esa casa/dirección.'], 404);
        out(['ok' => true, 'expediente' => $row]);
    }

    if ($action === 'get') {
        $stmt = $pdo->prepare('SELECT * FROM checklist_expedientes WHERE id = ? AND deleted_at IS NULL');
        $stmt->execute([(int)($_GET['id'] ?? 0)]);
        $row = $stmt->fetch();
        if (!$row) out(['ok' => false, 'error' => 'No encontrado.'], 404);
        out(['ok' => true, 'expediente' => $row]);
    }

    // action=list (default): el front solo ve no borrados.
    // Para desarrollo: ?action=list&todos=1 muestra también los borrados con su deleted_at.
    if (!empty($_GET['todos'])) {
        $rows = $pdo->query('SELECT id, casa_nombre, direccion, (item1+item2+item3+item4+item5+item6+item7+item8+item9+item10+item11) AS completados, updated_at, deleted_at FROM checklist_expedientes ORDER BY updated_at DESC LIMIT 500')->fetchAll();
    } else {
        $rows = $pdo->query('SELECT id, casa_nombre, direccion, (item1+item2+item3+item4+item5+item6+item7+item8+item9+item10+item11) AS completados, updated_at FROM checklist_expedientes WHERE deleted_at IS NULL ORDER BY updated_at DESC LIMIT 200')->fetchAll();
    }
    out(['ok' => true, 'expedientes' => $rows]);
} catch (Throwable $e) {
    out(['ok' => false, 'error' => 'Error de base de datos.'], 500);
}
