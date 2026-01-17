<?php
session_start();
require_once 'db.php'; // データベース接続ファイル（db.php）を読み込む

// ゲーム終了判定
if ($_SESSION['player_win'] >= 3 || $_SESSION['cpu_win'] >= 3) {
    $winner = ($_SESSION['player_win'] >= 3) ? "プレイヤー" : "CPU";
    ?>

    <!DOCTYPE html>
    <html>
    <head>
        <meta charset="UTF-8">
        <title>ゲーム終了</title>
        <style>
            body {
                background: #f4f4f4;
                font-family: 'Segoe UI', sans-serif;
                text-align: center;
                padding: 50px;
            }
            .result-box {
                background: white;
                padding: 30px;
                border-radius: 10px;
                box-shadow: 0 4px 10px rgba(23, 13, 13, 0.1);
                display: inline-block;
            }
            .btn {
                display: inline-block;
                margin-top: 20px;
                padding: 10px 25px;
                background: #3498db;
                color: #fff;
                text-decoration: none;
                border-radius: 6px;
                transition: 0.3s;
            }
            .btn:hover {
                background: #2980b9;
            }
        </style>
    </head>
    <body>

        <div class="result-box">
            <h1>🎉 ゲーム終了！</h1>
            <h2>勝者：<?= $winner ?></h2>
            <h3>最終結果</h3>
            <p><strong>プレイヤー：</strong><?= $_SESSION['player_win'] ?> 勝</p>
            <p><strong>CPU：</strong><?= $_SESSION['cpu_win'] ?> 勝</p>

            <h3>戦闘ログ</h3>
            <div>
                <?php foreach ($_SESSION['log'] as $log): ?>
                    <p><?= htmlspecialchars($log) ?></p>
                <?php endforeach; ?>
            </div>

            <a class="btn" href="index.php">トップへ戻る</a>
        </div>

    </body>
    </html>

    <?php
    // ゲーム終了後、セッションをリセットする（再プレイ時に影響しないように）
    session_destroy();
    exit;
}

// カードがすべて使い切った場合、かつ勝者が決まっていないとき
if (empty($_SESSION['player_cards']) && empty($_SESSION['cpu_cards']) && $_SESSION['player_win'] < 3 && $_SESSION['cpu_win'] < 3) {
    ?>

    <!DOCTYPE html>
    <html>
    <head>
        <meta charset="UTF-8">
        <title>引き分け</title>
        <style>
            body {
                background: #f4f4f4;
                font-family: 'Segoe UI', sans-serif;
                text-align: center;
                padding: 50px;
            }
            .result-box {
                background: white;
                padding: 30px;
                border-radius: 10px;
                box-shadow: 0 4px 10px rgba(0,0,0,0.1);
                display: inline-block;
            }
            .btn {
                display: inline-block;
                margin-top: 20px;
                padding: 10px 25px;
                background: #3498db;
                color: #fff;
                text-decoration: none;
                border-radius: 6px;
                transition: 0.3s;
            }
            .btn:hover {
                background: #2980b9;
            }
        </style>
    </head>
    <body>

        <div class="result-box">
            <h1>💥 ゲーム終了！</h1>
            <h2>引き分け！</h2>
            <h3>最終結果</h3>
            <p><strong>プレイヤー：</strong><?= $_SESSION['player_win'] ?> 勝</p>
            <p><strong>CPU：</strong><?= $_SESSION['cpu_win'] ?> 勝</p>

            <h3>戦闘ログ</h3>
            <div>
                <?php foreach ($_SESSION['log'] as $log): ?>
                    <p><?= htmlspecialchars($log) ?></p>
                <?php endforeach; ?>
            </div>

            <a class="btn" href="index.php">トップへ戻る</a>
        </div>

    </body>
    </html>

    <?php
    // ゲーム終了後、セッションをリセットする（再プレイ時に影響しないように）
    session_destroy();
    exit;
}

// プレイヤーがカードを選んだ場合
if (isset($_POST['card_id'])) {

    $player_choice = intval($_POST['card_id']);

    // プレイヤーカード検索
    foreach ($_SESSION['player_cards'] as $k => $c) {
        if ($c['card_id'] == $player_choice) {
            $player_card = $c;
            unset($_SESSION['player_cards'][$k]);
            break;
        }
    }

    // CPU ランダム選択
    $cpu_keys = array_keys($_SESSION['cpu_cards']);
    $cpu_key = $cpu_keys[array_rand($cpu_keys)];
    $cpu_card = $_SESSION['cpu_cards'][$cpu_key];
    unset($_SESSION['cpu_cards'][$cpu_key]);

    // 勝敗判定
    if ($player_card['strength'] > $cpu_card['strength']) {
        $_SESSION['player_win']++;
        $result = "プレイヤーの勝ち！";
    } elseif ($player_card['strength'] < $cpu_card['strength']) {
        $_SESSION['cpu_win']++;
        $result = "CPUの勝ち！";
    } else {
        $result = "引き分け！";
    }

    // 勝敗の詳細をログに追加
    $_SESSION['log'][] = "あなた: カード{$player_card['card_id']}（強さ {$player_card['strength']}） / CPU: カード{$cpu_card['card_id']}（強さ {$cpu_card['strength']}） → {$result}";

    // 勝者が決まった時点でゲーム終了判定
    if ($_SESSION['player_win'] >= 3 || $_SESSION['cpu_win'] >= 3) {
        header("Location: battle.php");  // 結果画面へリダイレクト
        exit;
    }
}

// カードがすべて使い切られた場合、かつ勝者が決まっていないとき
if (empty($_SESSION['player_cards']) && empty($_SESSION['cpu_cards']) && $_SESSION['player_win'] < 3 && $_SESSION['cpu_win'] < 3) {
    header("Location: battle.php");  // 引き分け画面へリダイレクト
    exit;
}
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>カードバトル</title>
    <style>
        body {
            background: linear-gradient(135deg, #2c3e50, #4ca1af);
            font-family: 'Segoe UI', sans-serif;
            margin: 0;
            padding: 20px;
            color: #fff;
        }

        h1, h2 {
            text-align: center;
        }

        .score-board {
            text-align: center;
            margin-bottom: 20px;
            font-size: 20px;
        }

        .card-container {
            display: flex;
            justify-content: center;
            flex-wrap: wrap;
            gap: 15px;
            margin-top: 20px;
        }

        .card-button {
            background: white;
            padding: 20px;
            width: 150px;
            border-radius: 12px;
            box-shadow: 0 4px 10px rgba(0,0,0,0.3);
            text-align: center;
            cursor: pointer;
            border: none;
            font-size: 18px;
            transition: 0.3s;
            color: #333;
        }

        .card-button img {
            width: 100%;
            border-radius: 8px;
            margin-bottom: 10px;
        }

        .card-button:hover {
            transform: scale(1.05);
            background: #f1f1f1;
        }

        .log-box {
            margin: 20px auto;
            width: 60%;
            background: rgba(255,255,255,0.2);
            padding: 15px;
            border-radius: 10px;
            max-height: 200px;
            overflow-y: auto;
        }
    </style>
</head>
<body>

<h1>カードバトル</h1>

<div class="score-board">
    プレイヤー：<?= $_SESSION['player_win'] ?> 勝　
    /　CPU：<?= $_SESSION['cpu_win'] ?> 勝
</div>

<h2>あなたの手札</h2>

<form method="POST">
    <div class="card-container">
        <?php 
        // プレイヤーのカードをループして表示
        foreach ($_SESSION['player_cards'] as $card):
            // データベースから画像パスを取得
            $stmt = $pdo->prepare("SELECT image_path FROM cards WHERE card_id = :card_id");
            $stmt->bindParam(':card_id', $card['card_id'], PDO::PARAM_INT);
            $stmt->execute();
            $image_path = $stmt->fetchColumn();

            // デバッグ用：画像パスが正しく取得されているか確認
            // echo $image_path;  // この行を使ってパスを確認できます
        ?>
            <button class="card-button" type="submit" name="card_id" value="<?= $card['card_id'] ?>">
                <!-- トランプの画像を反映 -->
                <img src="<?= $image_path ?>" alt="カード <?= $card['card_id'] ?>" />
                <!-- カードIDと強さを表示する部分 -->
                <br>
                強さ：<?= $card['strength'] ?>
            </button>
        <?php endforeach; ?>
    </div>
</form>



<h2>戦闘ログ</h2>
<div class="log-box">
    <?php foreach (array_reverse($_SESSION['log']) as $line): ?>
        <div><?= htmlspecialchars($line) ?></div>
    <?php endforeach; ?>
</div>

</body>
</html>
