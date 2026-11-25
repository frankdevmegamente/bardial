<?php
include 'includes/properties.php';
$q = isset($_GET['q']) ? trim($_GET['q']) : '';
$results = [];
if ($q !== '') {
    $results = array_filter($properties, function($p) use ($q) {
        return stripos($p['location'], $q) !== false;
    });
    $results = array_slice($results, 0, 5);
}
header('Content-Type: application/json');
echo json_encode(array_values($results));