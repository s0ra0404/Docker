<?php
header('Content-Type: application/json');

require 'db.php';

// ドリンク一覧を取得
$stmt = $pdo->query("SELECT * FROM unity_drinks");
$drinks = $stmt->fetchAll(PDO::FETCH_ASSOC);

// 重み付きランダム選択
$totalWeight = 0;
foreach ($drinks as $drink) {
    $totalWeight += $drink['weight'];
}

$rand = rand(1, $totalWeight);
$current = 0;
$selected = null;

foreach ($drinks as $drink) {
    $current += $drink['weight'];
    if ($rand <= $current) {
        $selected = $drink;
        break;
    }
}

// 所持テーブルに追加または更新
$checkStmt = $pdo->prepare("SELECT * FROM unity_player_drinks WHERE drink_id = ?");
$checkStmt->execute([$selected['drink_id']]);
$existing = $checkStmt->fetch();

if ($existing) {
    $updateStmt = $pdo->prepare("UPDATE unity_player_drinks SET number_of_drink = number_of_drink + 1 WHERE drink_id = ?");
    $updateStmt->execute([$selected['drink_id']]);
} else {
    $insertStmt = $pdo->prepare("INSERT INTO unity_player_drinks (drink_id, number_of_drink) VALUES (?, 1)");
    $insertStmt->execute([$selected['drink_id']]);
}

// 履歴に追加
$historyStmt = $pdo->prepare("INSERT INTO unity_gacha_history (drink_id) VALUES (?)");
$historyStmt->execute([$selected['drink_id']]);

// 結果を返す
echo json_encode($selected);
?>
