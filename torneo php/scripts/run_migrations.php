<?php

// Esegue le migrations SQL usando la classe DB del progetto
require __DIR__ . '/../vendor/autoload.php';

use App\Database\DB;

echo "Running migrations...\n";

$file = __DIR__ . '/../migrations/001_create_tournament_schema.sql';
if (!file_exists($file)) {
    echo "Migration file not found: $file\n";
    exit(1);
}

$sql = file_get_contents($file);
// Split per statement (semplice): cerca ';' seguito da newline
$parts = preg_split('/;\s*\n/', $sql);

foreach ($parts as $part) {
    $stmt = trim($part);
    if ($stmt === '') continue;
    try {
        DB::statement($stmt);
        echo "Executed statement...\n";
    } catch (\Throwable $e) {
        echo "Error executing statement: " . $e->getMessage() . "\n";
        exit(1);
    }
}

echo "Migrations applied successfully.\n";
