<?php
header('Content-Type: text/html; charset=UTF-8');
require 'db.php';

$stmt = $pdo->query("SELECT * FROM drinks");
$drinks = $stmt->fetchAll(PDO::FETCH_ASSOC);
$total_weight = array_sum(array_column($drinks, 'weight'));
?>
<!DOCTYPE html>
<html lang="ja">
<head>
  <meta charset="UTF-8">
  <title>出現確率</title>
  <link rel="stylesheet" href="style.css">
</head>
<body>
  <div class="container">
    <h2>ドリンクの出現確率</h2>
    <ul>
      <?php foreach ($drinks as $drink): ?>
        <?php $percent = round(($drink['weight'] / $total_weight) * 100, 2); ?>
        <li><?= htmlspecialchars($drink['drink_name']) ?>：<?= $percent ?>%</li>
      <?php endforeach; ?>
    </ul>
    <p><a href="menu.php">メインメニューに戻る</a></p>
  </div>
</body>
</html>
