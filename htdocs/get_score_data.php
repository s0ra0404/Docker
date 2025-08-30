<?php
$host = 'mysql';
$username = 'data_sora';
$password = 'data';
$database = 'score_db';

try {
    // PDOでMySQLに接続
    $pdo = new PDO("mysql:host=$host;dbname=$database;charset=utf8", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $stmt = $pdo->query("SELECT * FROM score_table");
    $results = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // 取得したデータをセッションに保存
    session_start();
    $_SESSION['data'] = $results;

    // リダイレクト
    header("Location: display_score_data.php");
    exit();

} catch (PDOException $e) {
    // エラー処理
    echo "データベースエラー: " . $e->getMessage();
}
?>