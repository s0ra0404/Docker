<?php
header('Content-Type: text/html; charset=UTF-8');
$code = file_get_contents('C#/NormalBaker.cs');
$escaped = htmlspecialchars($code);
?>
<!DOCTYPE html>
<html lang="ja">
<head>
  <meta charset="UTF-8">
  <title>C# ソースコード</title>
  <link rel="stylesheet" href="style.css">
  <link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/highlight.js/11.8.0/styles/vs2015.min.css">
  <script src="//cdnjs.cloudflare.com/ajax/libs/highlight.js/11.8.0/highlight.min.js"></script>
  <script>hljs.highlightAll();</script>
  <style>
    pre code {
      display: block;
      background-color: #2c2c3c;
      color: #ffffff;
      padding: 20px;
      border-radius: 8px;
      overflow-x: auto;
      font-family: Consolas, 'Courier New', monospace;
      font-size: 14px;
      line-height: 1.5;
      border: 1px solid #444;
    }
  </style>
</head>
<body>
  <div class="container">
    <h2>C# ソースコード</h2>
    <pre><code class="language-csharp"><?= $escaped ?></code></pre>
    <p><a href="main_menu.php">メインメニューに戻る</a></p>
  </div>
</body>
</html>
