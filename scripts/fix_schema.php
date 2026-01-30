<?php
/**
 * Script per applicare modifiche allo schema esistente (ALTER TABLE)
 */
require __DIR__ . '/../vendor/autoload.php';

use App\Database\DB;

$statements = [
    "ALTER TABLE tournament_participants ADD COLUMN IF NOT EXISTS updated_at TIMESTAMP WITHOUT TIME ZONE DEFAULT now();",
    "ALTER TABLE rounds ADD COLUMN IF NOT EXISTS updated_at TIMESTAMP WITHOUT TIME ZONE DEFAULT now();"
];

foreach ($statements as $sql) {
    try {
        DB::statement($sql);
        echo "Executed: $sql\n";
    } catch (\Exception $e) {
        echo "Error executing statement: " . $e->getMessage() . "\n";
    }
}

echo "Schema fix completed.\n";
