<?php  
$connect = mysqli_connect("localhost", "root", "", "armoryshopdb");
if (!$connect) {
    die("Error connect to database!");
}

if(isset($_POST["UpdUser"])) {
    $updN = mysqli_real_escape_string($connect, $_POST['UpdN']);
    $updLN = mysqli_real_escape_string($connect, $_POST['UpdLN']);
    $updEm = mysqli_real_escape_string($connect, $_POST['UpdEm']);
    $updTel = mysqli_real_escape_string($connect, $_POST['UpdTel']);
    
    $user_id = $_POST['user_id'];
    
    mysqli_query($connect, "UPDATE `clients` SET `FirstName` = '$updN', `LastName` = '$updLN', `Email` = '$updEm', `PhoneNumber` = '$updTel' WHERE `clients`.`ClientID` = '$user_id'");
}

// Обработчик формы добавления нового клиента
if(isset($_POST["AddUser"])) {
    $addN = mysqli_real_escape_string($connect, $_POST['AddN']);
    $addLN = mysqli_real_escape_string($connect, $_POST['AddLN']);
    $addEm = mysqli_real_escape_string($connect, $_POST['AddEm']);
    $addTel = mysqli_real_escape_string($connect, $_POST['AddTel']);
    
    mysqli_query($connect, "INSERT INTO `clients` (`FirstName`, `LastName`, `Email`, `PhoneNumber`) VALUES ('$addN', '$addLN', '$addEm', '$addTel')");
}

?>

<!DOCTYPE html> 
<html lang="ru"> 
<head> 
    <meta charset="UTF-8">
    <title>armoryshop</title> 
    <style>
        
        body {
            font-family: Arial, sans-serif;
            background-color: #f0f0f0;
            margin: 0;
            padding: 0;
            width: 100%;
        }

        .page-container {
            background-color: #f0f0f0;
            padding: 20px;
            max-width: 800px;
            margin: 0 auto;
        }

        .table-container {
            margin-top: 20px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            background-color: #fff;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        th, td {
            padding: 10px;
            text-align: center;
            border-bottom: 1px solid #ddd;
        }

        th {
            background: #999999;
            color: white;
        }

        form {
            margin-top: 20px;
            display: flex;
            justify-content: center;
        }

        input[type="text"],
        input[type="email"],
        input[type="submit"] {
            padding: 8px;
            border-radius: 4px;
            border: 1px solid #ccc;
            margin-right: 10px;
        }

        input[type="submit"] {
            background-color: #FF8C00;
            color: white;
            cursor: pointer;
            border: none;
        }

        input[type="submit"]:hover {
            background-color: #FFA500;
        }

        a {
            text-decoration: none;
            color: #333;
        }

        .modal {
            display: none;
            position: fixed;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            background-color: #fff;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.3);
            z-index: 1001;
        }

        .modal button {
            margin-top: 10px;
            background-color: #FF8C00;
            color: white;
            cursor: pointer;
            border: none;
            padding: 8px 20px;
            border-radius: 4px;
        }

        .modal button:hover {
            background-color: #FFA500;
        }
    </style>
</head> 
<body> 
    <div class="page-container">
        <h1 style="text-align: center;">Список клиентов</h1>
        <div class="table-container">
            <table>
                <tr>
                    <th>id клиента</th>
                    <th>Имя</th>
                    <th>Фамилия</th>
                    <th>Email</th>
                    <th>Номер телефона</th>
                    <th colspan="2">Действие</th>
                </tr>

                <?php
                $as = mysqli_query($connect, "SELECT `ClientID`, `FirstName`, `LastName`, `Email`, `PhoneNumber` FROM clients");
                while ($Clients = mysqli_fetch_array($as)) {
                    ?>
                    <tr>
                        <td><?= $Clients['ClientID'] ?></td>
                        <td><?= $Clients['FirstName'] ?></td>
                        <td><?= $Clients['LastName'] ?></td>
                        <td><?= $Clients['Email'] ?></td>
                        <td><?= $Clients['PhoneNumber'] ?></td>
                        <td><a href="#" onclick="openUpdateModal('<?= $Clients['ClientID'] ?>', '<?= $Clients['FirstName'] ?>', '<?= $Clients['LastName'] ?>', '<?= $Clients['Email'] ?>', '<?= $Clients['PhoneNumber'] ?>')">Обновить данные</a></td>
                        <td><a href="delete.php?id=<?= $Clients['ClientID'] ?>">Удалить данные</a></td>
                    </tr>
                <?php } ?>
            </table>
        </div> <!-- Закрываем .table-container -->

        <!-- Форма для обновления данных, изначально скрыта -->
        <div class="modal" id="updateModal">
            <h2 style="text-align: center;">Обновление данных клиента</h2>
            <form method="POST">
                <!-- Поля для обновления данных -->
                <input type="hidden" name="user_id" id="userId">
                <p><label>Имя</label>    
                <input type="text" name="UpdN" id="updN"></p>

                <p><label>Фамилия</label>    
                <input type="text" name="UpdLN" id="updLN"></p>
                
                <p><label>Email</label>    
                <input type="text" name="UpdEm" id="updEm"></p>

                <p><label>Телефон</label>    
                <input type="text" name="UpdTel" id="updTel"></p>
                
                <p style="text-align: center;"><input type="submit" name="UpdUser" value="Обновить"></p> 
            </form>
            <!-- Кнопка для закрытия окна обновления данных -->
            <button onclick="closeUpdateModal()" style="margin-left: calc(50% - 50px);">Закрыть</button>
        </div>
         <!-- Форма для добавления нового клиента -->
    <h2 style="text-align: center;">Добавление нового клиента</h2>
    <form method="POST">
        <p><label>Имя</label>    
        <input type="text" name="AddN" required></p>

        <p><label>Фамилия</label>    
        <input type="text" name="AddLN" required></p>
        
        <p><label>Email</label>    
        <input type="email" name="AddEm" required></p>

        <p><label>Телефон</label>    
        <input type="text" name="AddTel" required></p>
        
        <p style="text-align: center;"><input type="submit" name="AddUser" value="Добавить"></p> 
    </form>
    </div>

    <script>
        // Функция для открытия окна обновления данных
        function openUpdateModal(clientID, firstName, lastName, email, phoneNumber) {
            document.getElementById('userId').value = clientID;
            document.getElementById('updN').value = firstName;
            document.getElementById('updLN').value = lastName;
            document.getElementById('updEm').value = email;
            document.getElementById('updTel').value = phoneNumber;
            document.getElementById('updateModal').style.display = 'block';
        }

        // Функция для закрытия окна обновления данных
        function closeUpdateModal() {
            document.getElementById('updateModal').style.display = 'none';
        }
    </script>
</body> 
</html>
