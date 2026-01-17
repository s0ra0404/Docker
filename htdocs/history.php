<?php
header('Content-Type: text/html; charset=UTF-8');
require 'db.php';

$sql = "SELECT h.id, d.drink_name 
        FROM drink_gacha_history h 
        JOIN drinks d ON h.drink_id = d.drink_id 
        ORDER BY h.id DESC";
$stmt = $pdo->query($sql);
$history = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html lang="ja">
<head>
  <meta charset="UTF-8">
  <title>ガチャ履歴</title>
  <link rel="stylesheet" href="style.css">
</head>
<body>
  <div class="container">
    <h2>ガチャ履歴</h2>
    <ul>
      <?php foreach ($history as $entry): ?>
        <li>ID: <?= $entry['id'] ?> - <?= $entry['drink_name'] ?></li>
      <?php endforeach; ?>
    </ul>
    <p><a href="menu.php">メインメニューに戻る</a></p>
  </div>
</body>
</html>
