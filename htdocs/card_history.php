<?php
require 'db.php';

// 全履歴を取得（最新順）
$stmt = $pdo->query("
    SELECT h.id, c.card_name, c.card_rarity, c.image_path
    FROM card_gacha_history h
    JOIN character_cards c ON h.card_id = c.card_id
    ORDER BY h.id DESC
");
$history = $stmt->fetchAll();
?>
<!DOCTYPE html>
<html lang="ja">
<head>
  <meta charset="UTF-8">
  <title>ガチャ履歴</title>
  <link rel="stylesheet" href="style.css">
  <style>
    .history-scroll {
      max-height: 600px;
      overflow-y: auto;
      padding: 10px;
      border: 1px solid #444;
      border-radius: 10px;
      background-color: rgba(255,255,255,0.03);
    }
    .history-group {
      margin-bottom: 30px;
      border-bottom: 1px dashed #666;
      padding-bottom: 15px;
    }
    .history-cards {
      display: flex;
      flex-wrap: wrap;
      justify-content: center;
      gap: 15px;
    }
    .history-card {
      background-color: rgba(255,255,255,0.05);
      padding: 10px;
      border-radius: 10px;
      text-align: center;
      width: 120px;
    }
    .history-card img {
      width: 80px;
      height: auto;
      border-radius: 6px;
      box-shadow: 0 0 8px rgba(0,255,255,0.2);
    }
    .history-card p {
      margin-top: 8px;
      font-size: 13px;
    }
  </style>
</head>
<body>
  <div class="container">
    <h2>ガチャ履歴</h2>
    <?php if (empty($history)): ?>
      <p>まだガチャ履歴がありません。</p>
    <?php else: ?>
      <div class="history-scroll">
        <?php
        $grouped = array_chunk($history, 10);
        $count = count($grouped);
        foreach ($grouped as $index => $group):
        ?>
          <div class="history-group">
            <h3>第 <?= $count - $index ?> 回 10連</h3>
            <div class="history-cards">
              <?php foreach ($group as $card): ?>
                <div class="history-card">
                  <img src="<?= htmlspecialchars($card['image_path']) ?>" alt="<?= htmlspecialchars($card['card_name']) ?>">
                  <p><?= htmlspecialchars($card['card_name']) ?><br>（<?= htmlspecialchars($card['card_rarity']) ?>）</p>
                </div>
              <?php endforeach; ?>
            </div>
          </div>
        <?php endforeach; ?>
      </div>
    <?php endif; ?>
    <div style="text-align:center; margin-top:20px;">
      <a href="card_menu.php">メニューに戻る</a>
    </div>
  </div>
</body>
</html>
