<?php
$host = 'localhost';
$dbname = 'lab2';
$username = 'root';
$password = '27892789';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    try {
        $pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
        $id = $_POST['id']; // получаем id объекта для удаления
        // Удаляем объект из базы данных на основе переданного id
        // Реализуйте эту часть кода в соответствии с вашей логикой
        $stmt = $pdo->prepare('DELETE FROM NaturalObjects WHERE id = :id');
        $stmt->execute(['id' => $id]);
        echo "Данные успешно удалены.";
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
    <title>Удаление записи</title>
</head>
<body>
<h1>Удаление записи</h1>
<p>Вы уверены, что хотите удалить следующую запись?</p>
<p>Тип: <?= $row['type'] ?></p>
<p>Галактика: <?= $row['galaxy'] ?></p>
<form method="POST">
    <input type="hidden" name="id" value="<?= $row['id'] ?>">
    <button type="submit">Подтвердить удаление</button>
    <a href="index.php">Отмена</a>
</form>
</body>
</html>
