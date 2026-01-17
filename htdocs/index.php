<?php
session_start();
require_once 'db.php';

// ゲーム初期化
$stmt = $pdo->query("SELECT * FROM cards");
$cards = $stmt->fetchAll(PDO::FETCH_ASSOC);

$_SESSION['player_cards'] = $cards;
$_SESSION['cpu_cards'] = $cards;

$_SESSION['player_win'] = 0;
$_SESSION['cpu_win'] = 0;
$_SESSION['log'] = [];

?>

<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>カードバトル</title>
    <style>
        body {
            background: #2c3e50;
            font-family: 'Segoe UI', sans-serif;
            color: white;
            text-align: center;
            margin: 0;
        }

        h1 {
            margin-top: 100px;
            font-size: 48px;
            text-shadow: 2px 2px 10px rgba(0,0,0,0.3);
        }

        .container {
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            flex-direction: column;
        }

        .btn {
            padding: 15px 35px;
            font-size: 20px;
            color: #fff;
            background: #3498db;
            border: none;
            border-radius: 50px;
            cursor: pointer;
            margin-top: 30px;
            transition: 0.3s;
        }

        .btn:hover {
            background: #2980b9;
        }

        .footer {
            margin-top: 30px;
            color: #aaa;
        }
    </style>
</head>
<body>

<div class="container">
    <h1>カードバトルへようこそ</h1>
    <!-- ゲーム開始ボタン -->
    <a href="battle.php">
        <button class="btn">ゲーム開始</button>
    <a href="main_menu.php">
        <button class="btn">メインメニューへ</button>
    </a>
</div>

</body>
</html>
