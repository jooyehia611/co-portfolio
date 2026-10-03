<?php

/**
 * One-off: copy all rows from SQLite -> MySQL after migrations ran on MySQL.
 * Keeps SQLite file untouched. Safe to re-run (truncates MySQL tables first).
 */

declare(strict_types=1);

$sqlitePath = __DIR__ . '/database.sqlite';
if (! is_file($sqlitePath)) {
    fwrite(STDERR, "SQLite file not found: {$sqlitePath}\n");
    exit(1);
}

$mysqlHost = getenv('MYSQL_HOST') ?: '127.0.0.1';
$mysqlPort = getenv('MYSQL_PORT') ?: '3306';
$mysqlDb = getenv('MYSQL_DATABASE') ?: 'ytech_portfolio';
$mysqlUser = getenv('MYSQL_USER') ?: 'root';
$mysqlPass = getenv('MYSQL_PASSWORD') !== false ? (string) getenv('MYSQL_PASSWORD') : '';

$sqlite = new PDO('sqlite:' . $sqlitePath);
$sqlite->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

$dsn = sprintf('mysql:host=%s;port=%s;dbname=%s;charset=utf8mb4', $mysqlHost, $mysqlPort, $mysqlDb);
$mysql = new PDO($dsn, $mysqlUser, $mysqlPass, [
    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
    PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8mb4 COLLATE utf8mb4_unicode_ci",
]);

$tables = $sqlite->query(
    "SELECT name FROM sqlite_master WHERE type='table' AND name NOT LIKE 'sqlite_%' ORDER BY name"
)->fetchAll(PDO::FETCH_COLUMN);

echo "Found " . count($tables) . " tables in SQLite\n";

$mysql->exec('SET FOREIGN_KEY_CHECKS=0');
$mysql->exec('SET UNIQUE_CHECKS=0');

$copied = 0;
$skipped = 0;

foreach ($tables as $table) {
    $exists = $mysql->query("SHOW TABLES LIKE " . $mysql->quote($table))->fetch();
    if (! $exists) {
        echo "SKIP (missing on MySQL): {$table}\n";
        $skipped++;
        continue;
    }

    $rows = $sqlite->query("SELECT * FROM \"{$table}\"")->fetchAll(PDO::FETCH_ASSOC);
    $mysql->exec("TRUNCATE TABLE `{$table}`");

    if ($rows === []) {
        echo "OK empty: {$table}\n";
        continue;
    }

    $columns = array_keys($rows[0]);
    $colList = '`' . implode('`,`', $columns) . '`';
    $placeholders = implode(',', array_fill(0, count($columns), '?'));
    $sql = "INSERT INTO `{$table}` ({$colList}) VALUES ({$placeholders})";
    $stmt = $mysql->prepare($sql);

    $count = 0;
    foreach ($rows as $row) {
        $values = [];
        foreach ($columns as $col) {
            $values[] = $row[$col];
        }
        $stmt->execute($values);
        $count++;
    }

    echo "OK {$table}: {$count} rows\n";
    $copied += $count;
}

$mysql->exec('SET UNIQUE_CHECKS=1');
$mysql->exec('SET FOREIGN_KEY_CHECKS=1');

echo "\nDone. Copied {$copied} rows. Skipped tables: {$skipped}\n";
