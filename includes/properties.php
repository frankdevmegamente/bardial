<?php
require_once __DIR__ . '/db.php';

try {
    $properties = getAllProperties();
} catch (PDOException $e) {
    $properties = [];
}
