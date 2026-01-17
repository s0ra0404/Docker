<?php
header('Content-Type: application/json');

require 'db.php';

$stmt = $pdo->query("
    SELECT d.drink_name, d.image_path
    FROM unity_gacha_history h
    JOIN unity_drinks d ON h.drink_id = d.drink_id
    ORDER BY h.id DESC
    LIMIT 50
");

$history = $stmt->fetchAll(PDO::FETCH_ASSOC);
echo json_encode($history);
?>
