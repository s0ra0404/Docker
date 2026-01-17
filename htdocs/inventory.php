<?php
header('Content-Type: text/html; charset=UTF-8');
require 'db.php';

$sql = "SELECT d.drink_name, d.image_path, p.number_of_drink 
        FROM player_drinks p 
        JOIN drinks d ON p.drink_id = d.drink_id";
$stmt = $pdo->query($sql);
$inventory = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html lang="ja">
<head>
  <meta charset="UTF-8">
  <title>所持ドリンク</title>
  <link rel="stylesheet" href="style.css">
</head>
<body>
  <div class="container">
    <h2>所持ドリンク</h2>
    <?php foreach ($inventory as $item): ?>
      <div class="drink-item">
        <img src="<?= $item['image_path'] ?>" alt="<?= $item['drink_name'] ?>">
        <div>
          <strong><?= $item['drink_name'] ?></strong><br>
          <?= $item['number_of_drink'] ?> 本
        </div>
      </div>
    <?php endforeach; ?>
    <p><a href="menu.php">メインメニューに戻る</a></p>
  </div>
</body>
</html>
