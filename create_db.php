<?php
try {
    $pdo = new PDO("mysql:host=127.0.0.1", "root", "");
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $pdo->exec("CREATE DATABASE IF NOT EXISTS travelh");
    echo "Database created successfully.";
} catch (PDOException $e) {
    echo "Connection failed: " . $e->getMessage();
    exit(1);
}
