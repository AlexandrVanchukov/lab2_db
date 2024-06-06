<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Обработка отправленной формы
    $type = $_POST['type'];
    $galaxy = $_POST['galaxy'];
    $accuracy = $_POST['accuracy'];
    $light_flux = $_POST['light_flux'];
    $associated_objects = $_POST['associated_objects'];
    $note = $_POST['note'];

    // Добавление записи в базу данных
    $host = 'localhost';
    $dbname = 'lab2';
    $username = 'root';
    $password = '27892789';

    try {
        $pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
        $stmt = $pdo->prepare('INSERT INTO NaturalObjects (type, galaxy, accuracy, light_flux, associated_objects, note) VALUES (:type, :galaxy, :accuracy, :light_flux, :associated_objects, :note)');
        $stmt->execute(['type' => $type, 'galaxy' => $galaxy, 'accuracy' => $accuracy, 'light_flux' => $light_flux, 'associated_objects' => $associated_objects, 'note' => $note]);
        echo 'Запись успешно добавлена в таблицу NaturalObjects.';
    } catch (PDOException $e) {
        echo "Ошибка: " . $e->getMessage();
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Добавить новую запись в NaturalObjects</title>
</head>
<body>
<h1>Добавить новую запись</h1>
<form method="post" action="">
    <label for="type">Тип:</label><br>
    <input type="text" id="type" name="type"><br><br>

    <label for="galaxy">Галактика:</label><br>
    <input type="text" id="galaxy" name="galaxy"><br><br>

    <label for="accuracy">Точность:</label><br>
    <input type="text" id="accuracy" name="accuracy"><br><br>

    <label for="light_flux">Световой поток:</label><br>
    <input type="text" id="light_flux" name="light_flux"><br><br>

    <label for="associated_objects">Ассоциированные объекты:</label><br>
    <input type="text" id="associated_objects" name="associated_objects"><br><br>

    <label for="note">Примечание:</label><br>
    <textarea id="note" name="note"></textarea><br><br>

    <input type="submit" value="Добавить запись">
</form>
</body>
</html>