<?php
require 'db.php';

$stmt = $pdo->query("
    SELECT c.card_name, c.card_rarity, p.card_number
    FROM player_cards p
    JOIN character_cards c ON p.card_id = c.card_id
");

$cards = $stmt->fetchAll();
?>
<!DOCTYPE html>
<html lang="ja">
<head>
  <meta charset="UTF-8">
  <title>所持カード</title>
  <link rel="stylesheet" href="style.css">
</head>
<body>
  <div class="container">
    <h2>所持カード</h2>
    <ul>
      <?php foreach ($cards as $row): ?>
        <li><?= htmlspecialchars($row['card_name']) ?>（<?= htmlspecialchars($row['card_rarity']) ?>） × <?= $row['card_number'] ?></li>
      <?php endforeach; ?>
    </ul>
    <div style="text-align:center;">
      <a href="card_menu.php">メニューに戻る</a>
    </div>
  </div>
</body>
</html>
