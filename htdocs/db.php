<?php
$host = 'mysql';
$user = 'Sora';
$pass = 'Test';
$dbname = 'c_database';

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $user, $pass);
} catch (PDOException $e) {
    exit('DB Connection Error: ' . $e->getMessage());
}
