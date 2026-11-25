<?php
// api/search.php — búsqueda + filtros + orden + paginación
// Query params: q, type[], price_min, price_max, bed, sqm_min, sqm_max, services[], sort, page, per_page

header('Content-Type: application/json; charset=utf-8');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET, OPTIONS');
header('Access-Control-Allow-Headers: Content-Type');

if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') { http_response_code(204); exit; }

require_once __DIR__ . '/../includes/db.php';

try {
    $all = getAllProperties();

    $q = isset($_GET['q']) ? trim($_GET['q']) : '';
    // legacy: search param used by catalog
    if ($q === '' && isset($_GET['search'])) $q = trim($_GET['search']);
    $filterType = isset($_GET['type']) ? (array)$_GET['type'] : [];
    $priceMin = isset($_GET['price_min']) ? (float)$_GET['price_min'] : 0;
    $priceMax = isset($_GET['price_max']) ? (float)$_GET['price_max'] : 0;
    $bed = isset($_GET['bed']) ? (int)$_GET['bed'] : 0;
    $sqmMin = isset($_GET['sqm_min']) ? (float)$_GET['sqm_min'] : 0;
    $sqmMax = isset($_GET['sqm_max']) ? (float)$_GET['sqm_max'] : 0;
    $filterServices = isset($_GET['services']) ? (array)$_GET['services'] : [];
    $sort = $_GET['sort'] ?? 'recent';

    $filtered = array_filter($all, function($p) use ($q, $filterType, $priceMin, $priceMax, $bed, $sqmMin, $sqmMax, $filterServices) {
        if ($q !== '' && stripos($p['location'], $q) === false && stripos($p['type'] ?? '', $q) === false) return false;
        if (!empty($filterType) && !in_array($p['type'], $filterType)) return false;
        if ($priceMin > 0 && (float)($p['price_value'] ?? 0) < $priceMin) return false;
        if ($priceMax > 0 && (float)($p['price_value'] ?? 0) > $priceMax) return false;
        if ($bed > 0 && (int)$p['bed'] < $bed) return false;
        if ($sqmMin > 0 && (float)($p['sqm'] ?? 0) < $sqmMin) return false;
        if ($sqmMax > 0 && (float)($p['sqm'] ?? 0) > $sqmMax) return false;
        if (!empty($filterServices)) {
            $pSvc = array_map('trim', explode(',', $p['services'] ?? ''));
            $match = false;
            foreach ($filterServices as $fs) { if (in_array($fs, $pSvc)) { $match = true; break; } }
            if (!$match) return false;
        }
        return true;
    });
    $filtered = array_values($filtered);

    // Sorting
    if ($sort === 'price_asc') usort($filtered, fn($a,$b)=> ($a['price_value']??0) <=> ($b['price_value']??0));
    elseif ($sort === 'price_desc') usort($filtered, fn($a,$b)=> ($b['price_value']??0) <=> ($a['price_value']??0));
    elseif ($sort === 'sqm') usort($filtered, fn($a,$b)=> ($b['sqm']??0) <=> ($a['sqm']??0));

    // Search autocomplete mode: ?q=xxx&limit=5
    if (isset($_GET['limit'])) {
        $limit = max(1, min(20, (int)$_GET['limit']));
        echo json_encode(array_slice($filtered, 0, $limit), JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
        exit;
    }

    // Pagination
    $perPage = isset($_GET['per_page']) ? max(1, min(20, (int)$_GET['per_page'])) : 4;
    $page = isset($_GET['page']) ? max(1, (int)$_GET['page']) : 1;
    $total = count($filtered);
    $totalPages = max(1, (int)ceil($total / $perPage));
    $page = min($page, $totalPages);
    $data = array_slice($filtered, ($page - 1) * $perPage, $perPage);

    echo json_encode([
        'data' => $data,
        'total' => $total,
        'page' => $page,
        'per_page' => $perPage,
        'total_pages' => $totalPages,
    ], JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
} catch (Throwable $e) {
    http_response_code(500);
    echo json_encode(['error' => 'Error interno', 'detail' => $e->getMessage()]);
}
