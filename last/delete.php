<?php
$connect = mysqli_connect("localhost", "root", "", "armoryshopdb");
if (!$connect) {
    die("Error connect to database!");
}

if (isset($_GET['id'])) {
    $clientId = $_GET['id'];

    // Сначала удаляем записи из таблицы purchases, связанные с этим клиентом
    $deletePurchasesQuery = "DELETE FROM purchases WHERE ClientID='$clientId'";
    if (mysqli_query($connect, $deletePurchasesQuery)) {
        // Затем удаляем саму запись клиента
        $deleteClientQuery = "DELETE FROM clients WHERE ClientID='$clientId'";
        if (mysqli_query($connect, $deleteClientQuery)) {
            // Перенаправляем пользователя на страницу sql.php после успешного удаления
            header("Location: sql.php");
            exit(); // Важно завершить выполнение скрипта после перенаправления
        } else {
            echo "Ошибка при удалении клиента: " . mysqli_error($connect);
        }
    } else {
        echo "Ошибка при удалении покупок: " . mysqli_error($connect);
    }
}

mysqli_close($connect);
?>
