<?php

$host = 'localhost';
    $dbname = 'lab2';
    $username = 'root';
    $password = '27892789';

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);

    // Вызываем процедуру для объединения таблиц Position и Objects
    $sql = 'CALL join_tables_data("Position", "Objects")';
    $stmt = $pdo->query($sql);

    echo '<h2>Данные из объединенных таблиц Position и Objects:</h2>';
    echo '<table>';
    echo '<tr><th>id</th><th>earth</th><th>sun</th><th>moon</th><th>type</th><th>accuracy</th><th>count</th><th>detected_date</th><th>detected_time</th><th>notes</th></tr>';
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        echo '<tr>';
        echo '<td>' . htmlspecialchars($row['id']) . '</td>';
        echo '<td>' . htmlspecialchars($row['earth']) . '</td>';
        echo '<td>' . htmlspecialchars($row['sun']) . '</td>';
        echo '<td>' . htmlspecialchars($row['moon']) . '</td>';

        echo '<td>' . htmlspecialchars($row['type']) . '</td>';
        echo '<td>' . htmlspecialchars($row['accuracy']) . '</td>';
        echo '<td>' . htmlspecialchars($row['count']) . '</td>';
        echo '<td>' . htmlspecialchars($row['detected_date']) . '</td>';
        echo '<td>' . htmlspecialchars($row['detected_time']) . '</td>';
        echo '<td>' . htmlspecialchars($row['notes']) . '</td>';
        echo '</tr>';
    }
    echo '</table>';

} catch (PDOException $e) {
    die('Ошибка: ' . $e->getMessage());
}
?>