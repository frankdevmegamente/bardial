<?php
require_once __DIR__ . '/config.php';

function getDB(): PDO {
    static $pdo = null;
    if ($pdo === null) {
        $dsn = sprintf('mysql:host=%s;port=%s;dbname=%s;charset=%s', DB_HOST, DB_PORT, DB_NAME, DB_CHARSET);
        $pdo = new PDO($dsn, DB_USER, DB_PASS, [
            PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
            PDO::ATTR_EMULATE_PREPARES   => false,
        ]);
    }
    return $pdo;
}

function getAllProperties(): array {
    $stmt = getDB()->query('SELECT * FROM propiedades ORDER BY id ASC');
    return $stmt->fetchAll();
}

function getPropertyById(int $id): ?array {
    $stmt = getDB()->prepare('SELECT * FROM propiedades WHERE id = ?');
    $stmt->execute([$id]);
    $row = $stmt->fetch();
    return $row ?: null;
}

function createProperty(array $data): int {
    $stmt = getDB()->prepare('INSERT INTO propiedades (price, price_value, location, type, city, bed, bath, sqm, services, description, badge, sold, video, img, images) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)');
    $stmt->execute([
        $data['price'],
        !empty($data['price_value']) ? (float)$data['price_value'] : null,
        $data['location'],
        $data['type'] ?: null,
        $data['city'] ?: null,
        (int)($data['bed'] ?? 0),
        (int)($data['bath'] ?? 0),
        (int)($data['sqm'] ?? 0),
        $data['services'] ?: null,
        $data['description'] ?? null,
        $data['badge'] ?: null,
        !empty($data['sold']) ? 1 : 0,
        $data['video'] ?: null,
        $data['img'],
        $data['images'] ?? null,
    ]);
    return (int)getDB()->lastInsertId();
}

function updateProperty(int $id, array $data): void {
    $stmt = getDB()->prepare('UPDATE propiedades SET price = ?, price_value = ?, location = ?, type = ?, city = ?, bed = ?, bath = ?, sqm = ?, services = ?, description = ?, badge = ?, sold = ?, video = ?, img = ?, images = ? WHERE id = ?');
    $stmt->execute([
        $data['price'],
        !empty($data['price_value']) ? (float)$data['price_value'] : null,
        $data['location'],
        $data['type'] ?: null,
        $data['city'] ?: null,
        (int)($data['bed'] ?? 0),
        (int)($data['bath'] ?? 0),
        (int)($data['sqm'] ?? 0),
        $data['services'] ?: null,
        $data['description'] ?? null,
        $data['badge'] ?: null,
        !empty($data['sold']) ? 1 : 0,
        $data['video'] ?: null,
        $data['img'],
        $data['images'] ?? null,
        $id,
    ]);
}

function deleteProperty(int $id): void {
    $stmt = getDB()->prepare('DELETE FROM propiedades WHERE id = ?');
    $stmt->execute([$id]);
}
