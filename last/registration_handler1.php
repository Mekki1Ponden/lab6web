<?php
session_start();

// Подключение к базе данных
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "ArmoryShopDB";

$connect = new mysqli($servername, $username, $password, $dbname);

// Проверяем соединение с базой данных
if ($connect->connect_error) {
    die("Connection failed: " . $connect->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['register'])) {
    $firstName = $_POST['FirstName'];
    $lastName = $_POST['LastName'];
    $email = $_POST['Email'];
    $phoneNumber = $_POST['PhoneNumber'];
    $password = password_hash($_POST['Password'], PASSWORD_DEFAULT); // Хешируем пароль

    // Подготовленный запрос
    $stmt = $connect->prepare("INSERT INTO administrators (FirstName, LastName, Email, PhoneNumber, Password) VALUES (?, ?, ?, ?, ?)");

    // Проверяем, была ли успешно выполнена подготовка запроса
    if ($stmt === false) {
        die("Error preparing query: " . $connect->error);
    }

    // Привязываем параметры
    $stmt->bind_param("sssss", $firstName, $lastName, $email, $phoneNumber, $password);

    // Выполняем запрос
    if ($stmt->execute()) {
        $stmt->close();
        $connect->close();
        header("Location: admin_profile.php"); // Перенаправляем на страницу профиля после успешной регистрации
        exit();
    } else {
        echo "Error executing query: " . $stmt->error;
        $stmt->close();
        $connect->close();
    }
}
?>
