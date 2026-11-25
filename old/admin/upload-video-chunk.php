<?php
require_once __DIR__ . '/../includes/auth.php';
requireAdmin();

header('Content-Type: application/json');

$chunkIndex  = (int)($_POST['chunkIndex'] ?? 0);
$totalChunks = (int)($_POST['totalChunks'] ?? 0);
$uniqueId    = preg_replace('/[^a-zA-Z0-9_-]/', '', $_POST['uniqueId'] ?? '');
$filename    = $_POST['filename'] ?? 'video.mp4';

if (empty($uniqueId)) {
    echo json_encode(['error' => 'Falta identificador']);
    exit;
}

$tempDir = __DIR__ . '/../uploads/chunks/';
if (!is_dir($tempDir)) {
    mkdir($tempDir, 0777, true);
}

$chunkFile = $tempDir . $uniqueId . '_' . $chunkIndex . '.part';
move_uploaded_file($_FILES['file']['tmp_name'], $chunkFile);

// Check if all chunks arrived
$received = 0;
for ($i = 0; $i < $totalChunks; $i++) {
    if (file_exists($tempDir . $uniqueId . '_' . $i . '.part')) {
        $received++;
    }
}

if ($received === $totalChunks) {
    $ext = strtolower(pathinfo($filename, PATHINFO_EXTENSION));
    $allowed = ['mp4', 'webm', 'ogg', 'mov', 'avi', 'mkv'];
    if (!in_array($ext, $allowed)) {
        $ext = 'mp4';
    }
    $finalName = uniqid('prop_video_') . '.' . $ext;
    $targetDir = __DIR__ . '/../uploads/';
    $finalPath = $targetDir . $finalName;

    $out = fopen($finalPath, 'wb');
    for ($i = 0; $i < $totalChunks; $i++) {
        $f = $tempDir . $uniqueId . '_' . $i . '.part';
        fwrite($out, file_get_contents($f));
        unlink($f);
    }
    fclose($out);

    echo json_encode(['path' => 'uploads/' . $finalName]);
    exit;
}

echo json_encode(['done' => false]);
