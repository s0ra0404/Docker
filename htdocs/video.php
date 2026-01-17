<?php
header('Content-Type: text/html; charset=UTF-8');
?>
<!DOCTYPE html>
<html lang="ja">
<head>
  <meta charset="UTF-8">
  <title>動画再生</title>
  <link rel="stylesheet" href="style.css">
</head>
<body>
  <div class="container">
    <h2>動画を再生する</h2>
    <video width="600" controls>
      <source src="videos/movie_1.mp4" type="video/mp4">
      お使いのブラウザは video タグをサポートしていません。
    </video>
    <p><a href="main_menu.php">メインメニューに戻る</a></p>
  </div>
</body>
</html>
