<?php
    session_start();
?>

<!DOCTYPE html>
<html>
<head>
    <title>display_score</title>
</head>
<body>
    <h1>ScoreList</h1>
    <?php
        if (isset($_SESSION['data'])) {
            $data = $_SESSION['data'];
            if (count($data) > 0) {
                echo "<table>";
                echo "<thead><tr>";
                foreach (array_keys($data[0]) as $column) {
                    echo "<th>" . htmlspecialchars($column) . "</th>";
                }
                echo "</tr></thead>";
                echo "<tbody>";
                foreach ($data as $row) {
                    echo "<tr>";
                    foreach ($row as $value) {
                        echo "<td>" . htmlspecialchars($value) . "</td>";
                    }
                    echo "</tr>";
                }
                echo "</tbody>";
                echo "</table>";
            } else {
                echo "<p>no dataA</p>";
            }
            unset($_SESSION['data']);
        }
        else{
            echo "<p>no dataB</p>";
        }
    ?>
</body>
</html>
