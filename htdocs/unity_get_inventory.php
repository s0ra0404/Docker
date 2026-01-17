<?php
header('Content-Type: application/json');

require 'db.php';

$stmt = $pdo->query("
    SELECT d.drink_name, d.image_path, p.number_of_drink
    FROM unity_player_drinks p
    JOIN unity_drinks d ON p.drink_id = d.drink_id
");

$inventory = $stmt->fetchAll(PDO::FETCH_ASSOC);
echo json_encode($inventory);
?>
