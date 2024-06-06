<?php
$host = 'localhost';
$dbname = 'lab2';
$username = 'root';
$password = '27892789';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
     // Обработка отправленной формы
    try {
        $pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
        $id = $_POST['id'];
        $type = $_POST['type'];
        $galaxy = $_POST['galaxy'];
        $accuracy = $_POST['accuracy'];
        $light_flux = $_POST['light_flux'];
        $associated_objects = $_POST['associated_objects'];
        $note = $_POST['note']; // получаем id объекта для редактирования
        // обновляем данные объекта в базе данных на основе переданных данных из формы
        // Реализуйте эту часть кода в соответствии с вашей логикой

        $stmt = $pdo->prepare('CALL edit_NaturalObjects(:id, :type, :galaxy, :accuracy, :light_flux, :associated_objects, :note)');
        $stmt->execute(['id' => $id, 'type' => $type, 'galaxy' => $galaxy, 'accuracy' => $accuracy, 'light_flux' => $light_flux, 'associated_objects' => $associated_objects, 'note' => $note]);

        echo "Данные успешно обновлены.";
    } catch (PDOException $e) {
        echo "Ошибка: " . $e->getMessage();
    }
}

if (isset($_GET['id'])) {
    $id = $_GET['id'];
    try {
        $pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
        $stmt = $pdo->prepare('SELECT * FROM NaturalObjects WHERE id = :id');
        $stmt->execute(['id' => $id]);
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
    } catch (PDOException $e) {
        echo "Ошибка: " . $e->getMessage();
    }
}
?>

<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Редактирование записи</title>
</head>
<body>
<h1>Редактирование записи</h1>
<form method="POST">
    <input type="hidden" name="id" value="<?= $row['id'] ?>">
    <label for="type">Тип:</label>
    <input type="text" id="type" name="type" value="<?= $row['type'] ?>"><br><br>
    <label for="galaxy">Галактика:</label>
    <input type="text" id="galaxy" name="galaxy" value="<?= $row['galaxy'] ?>"><br><br>
    <label for="accuracy">Точность:</label>
    <input type="text" id="accuracy" name="accuracy" value="<?= $row['accuracy'] ?>"><br><br>
    <label for="light_flux">Поток света:</label>
    <input type="text" id="light_flux" name="light_flux" value="<?= $row['light_flux'] ?>"><br><br>
    <label for="associated_objects">Связанные объекты:</label>
    <input type="text" id="associated_objects" name="associated_objects" value="<?= $row['associated_objects'] ?>"><br><br>
    <label for="note">Примечание:</label>
    <textarea id="note" name="note"><?= $row['note'] ?></textarea><br><br>
    <button type="submit">Сохранить</button>
</form>
</body>
</html>