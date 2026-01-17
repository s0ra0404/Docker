<?php
require 'db.php';

// カード一覧と重みを取得
$stmt = $pdo->query("SELECT * FROM character_cards");
$cards = $stmt->fetchAll(PDO::FETCH_ASSOC);

// 重みに応じてカードをプールに追加
$pool = [];
foreach ($cards as $card) {
    for ($i = 0; $i < $card['weight']; $i++) {
        $pool[] = $card;
    }
}

// 10連ガチャを実行
$results = [];
for ($i = 0; $i < 10; $i++) {
    $selected = $pool[array_rand($pool)];
    $results[] = $selected;

    // 所持カードに追加
    $stmt = $pdo->prepare("SELECT * FROM player_cards WHERE card_id = ?");
    $stmt->execute([$selected['card_id']]);
    $existing = $stmt->fetch();

    if ($existing) {
        $stmt = $pdo->prepare("UPDATE player_cards SET card_number = card_number + 1 WHERE card_id = ?");
        $stmt->execute([$selected['card_id']]);
    } else {
        $stmt = $pdo->prepare("INSERT INTO player_cards (card_id, card_number) VALUES (?, 1)");
        $stmt->execute([$selected['card_id']]);
    }

    // 履歴に追加
    $stmt = $pdo->prepare("INSERT INTO card_gacha_history (card_id) VALUES (?)");
    $stmt->execute([$selected['card_id']]);
}
?>
<!DOCTYPE html>
<html lang="ja">
<head>
  <meta charset="UTF-8">
  <title>10連ガチャ結果</title>
  <link rel="stylesheet" href="style.css">
  <style>
    .gacha-grid {
      display: flex;
      flex-wrap: wrap;
      justify-content: center;
      gap: 15px;
    }
    .gacha-card {
      background-color: rgba(255,255,255,0.05);
      padding: 10px;
      border-radius: 10px;
      text-align: center;
      width: 140px;
      box-shadow: 0 0 8px rgba(255, 255, 255, 0.1);
    }
    .gacha-card img {
      width: 100px;
      height: auto;
      border-radius: 8px;
      box-shadow: 0 0 10px rgba(0,255,255,0.3);
    }
    .gacha-card p {
      margin-top: 10px;
      font-size: 14px;
    }
  </style>
</head>
<body>
  <div class="container">
    <h2>10連ガチャ結果</h2>
    <div class="gacha-grid">
      <?php foreach ($results as $card): ?>
        <div class="gacha-card">
          <img src="<?= htmlspecialchars($card['image_path']) ?>" alt="<?= htmlspecialchars($card['card_name']) ?>">
          <p><?= htmlspecialchars($card['card_name']) ?><br>（<?= htmlspecialchars($card['card_rarity']) ?>）</p>
        </div>
      <?php endforeach; ?>
    </div>
    <div style="text-align:center; margin-top:20px;">
      <a href="card_gacha.php">もう一度引く</a>
      <a href="card_menu.php">メニューに戻る</a>
    </div>
  </div>
</body>
</html>
