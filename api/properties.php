<?php
// api/properties.php — REST endpoint para la app móvil Bardial
// GET /api/properties.php           -> lista todas
// GET /api/properties.php?id=3     -> detalle

header('Content-Type: application/json; charset=utf-8');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET, OPTIONS');
header('Access-Control-Allow-Headers: Content-Type');

if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') { http_response_code(204); exit; }

require_once __DIR__ . '/../includes/db.php';

try {
    if (isset($_GET['id'])) {
        $id = (int)$_GET['id'];
        $prop = getPropertyById($id);
        if (!$prop) { http_response_code(404); echo json_encode(['error' => 'Propiedad no encontrada']); exit; }
        echo json_encode($prop, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
        exit;
    }
    $all = getAllProperties();
    echo json_encode($all, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
} catch (Throwable $e) {
    http_response_code(500);
    echo json_encode(['error' => 'Error interno', 'detail' => $e->getMessage()]);
}
