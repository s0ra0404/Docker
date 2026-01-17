<?php
header('Content-Type: text/html; charset=UTF-8');
?>
<!DOCTYPE html>
<html lang="ja">
<head>
  <meta charset="UTF-8">
  <title>音の再生</title>
  <link rel="stylesheet" href="style.css">
</head>
<body>
  <div class="container">
    <h2>音を再生する</h2>
    <audio controls>
      <source src="audio/UI_Click_A.mp3" type="audio/mpeg">
      お使いのブラウザは audio タグをサポートしていません。
    </audio>
    <p><a href="main_menu.php">メインメニューに戻る</a></p>
  </div>
</body>
</html>
