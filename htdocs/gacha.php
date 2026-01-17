<?php
header('Content-Type: text/html; charset=UTF-8');
require 'db.php';

$stmt = $pdo->query("SELECT * FROM drinks");
$drinks = $stmt->fetchAll(PDO::FETCH_ASSOC);

$pool = [];
foreach ($drinks as $drink) {
    for ($i = 0; $i < $drink['weight']; $i++) {
        $pool[] = $drink;
    }
}

$selected = $pool[array_rand($pool)];

$stmt = $pdo->prepare("INSERT INTO drink_gacha_history (drink_id) VALUES (?)");
$stmt->execute([$selected['drink_id']]);

$stmt = $pdo->prepare("SELECT * FROM player_drinks WHERE drink_id = ?");
$stmt->execute([$selected['drink_id']]);
$existing = $stmt->fetch();

if ($existing) {
    $stmt = $pdo->prepare("UPDATE player_drinks SET number_of_drink = number_of_drink + 1 WHERE drink_id = ?");
    $stmt->execute([$selected['drink_id']]);
} else {
    $stmt = $pdo->prepare("INSERT INTO player_drinks (drink_id, number_of_drink) VALUES (?, 1)");
    $stmt->execute([$selected['drink_id']]);
}
?>
<!DOCTYPE html>
<html lang="ja">
<head>
  <meta charset="UTF-8">
  <title>ガチャ結果</title>
  <link rel="stylesheet" href="style.css">
</head>
<body>
  <div class="container">
    <h2>あなたが引いたドリンクは…</h2>
    <img src="<?= $selected['image_path'] ?>" alt="<?= $selected['drink_name'] ?>" width="100"><br>
    <strong><?= $selected['drink_name'] ?></strong>
    <p>
      <a href="gacha.php">もう一度引く</a> |
      <a href="history.php">履歴を見る</a> |
      <a href="inventory.php">所持ドリンク</a> |
      <a href="probability.php">確率を見る</a> |
      <a href="menu.php">メインメニュー</a>
    </p>
  </div>
</body>
</html>
