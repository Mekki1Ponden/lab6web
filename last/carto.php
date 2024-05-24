<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Список покупок</title>
    <style>
        header {
    background-color: #333;
    border-radius: 10px;
    padding: 20px;
    margin-bottom: 20px;
    width: 100%;
}

.header-container {
    display: flex;
    justify-content: space-between;
    align-items: center;
    text-align: center;
    margin: 0;
}

h1 {
    color: white;
    margin: 0;
}

nav ul {
    list-style-type: none;
    padding: 0;
    margin: 0;
}

nav ul li {
    display: inline;
    margin-right: 20px;
}

nav ul li a {
    color: white;
    text-decoration: none;
    font-weight: bold;
}

nav ul li a:hover {
    text-decoration: underline;
}

body {
    background-color: #f2f2f2;
    font-family: Arial, sans-serif;
}

.container {
    width: 80%;
    margin: 0 auto;
    padding-top: 50px;
}

.purchases-list {
    background-color: white;
    padding: 20px;
    border-radius: 10px;
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
}

table {
    width: 100%;
    border-collapse: collapse;
}

th, td {
    padding: 10px;
    border-bottom: 1px solid #ddd;
    text-align: left;
}

th {
    background-color: #f2f2f2;
    cursor: pointer;
}

th a {
    color: #333;
    text-decoration: none;
    display: inline-block;
    padding: 0 5px;
}

th a:hover {
    text-decoration: underline;
}

th a.sort-asc:after {
    content: '▲';
    font-size: 0.8em;
    margin-left: 5px;
}

th a.sort-desc:after {
    content: '▼';
    font-size: 0.8em;
    margin-left: 5px;
}

button {
    background-color: #f44336;
    color: white;
    border: none;
    padding: 5px 10px;
    border-radius: 5px;
    cursor: pointer;
}

button:hover {
    background-color: #d32f2f;
}
    </style>
</head>
<body>
<header>
    <div class="header-container">
        <h1>Действия</h1>
        <nav>
            <ul>
                <li><a href="admin_profile.php">на страницу профиля</a></li>
                <li><a href="redact.php">Вернуться к редактированию списка</a></li>
            </ul>
        </nav>
    </div>
</header>
<div class="container">
    <div class="purchases-list">
        <h3>Список купленных товаров</h3>
        <table>
            <thead>
                <tr>
                    <th>Номер заказа</th>
                    <th><a href="?sort=client">Клиент</a></th>
                    <th>Название товара</th>
                    <th>
                        Количество
                        <a href="?sort=quantity&order=asc">&#8593;</a>
                        <a href="?sort=quantity&order=desc">&#8595;</a>
                    </th>
                    <th><a href="?sort=default">Сбросить сортировку</a></th>
                </tr>
            </thead>
            <tbody>
                <?php
                session_start();

                // Подключение к базе данных
                $servername = "localhost";
                $username = "root";
                $password = "";
                $dbname = "armoryshopdb";

                $conn = new mysqli($servername, $username, $password, $dbname);

                // Проверка соединения
                if ($conn->connect_error) {
                    die("Connection failed: " . $conn->connect_error);
                }

                // Определение параметров сортировки
                $sort_column = 'cart.CartID';
                $sort_order = 'ASC';
                if (isset($_GET['sort']) && $_GET['sort'] != 'default') {
                    if ($_GET['sort'] == 'client') {
                        $sort_column = 'clients.FirstName';
                    } elseif ($_GET['sort'] == 'quantity') {
                        $sort_column = 'cart.Quantity';
                    }
                }
                if (isset($_GET['order'])) {
                    $sort_order = ($_GET['order'] == 'desc') ? 'DESC' : 'ASC';
                }

                // Получение списка купленных товаров с сортировкой
                $purchase_query = "SELECT cart.CartID, clients.FirstName, products.ProductName, cart.Quantity
                                   FROM cart
                                   INNER JOIN clients ON cart.UserID = clients.ClientID
                                   INNER JOIN products ON cart.ProductID = products.ProductID
                                   ORDER BY $sort_column $sort_order";
                $purchase_result = $conn->query($purchase_query);
                if ($purchase_result->num_rows > 0) {
                    while ($purchase_row = $purchase_result->fetch_assoc()) {
                        echo "<tr>";
                        echo "<td>" . $purchase_row['CartID'] . "</td>";
                        echo "<td>" . $purchase_row['FirstName'] . "</td>";
                        echo "<td>" . $purchase_row['ProductName'] . "</td>";
                        echo "<td>" . $purchase_row['Quantity'] . "</td>";
                        echo "</tr>";
                    }
                } else {
                    echo "<tr><td colspan='5'>Нет данных</td></tr>";
                }

                // Закрытие соединения
                $conn->close();
                ?>
            </tbody>
        </table>
    </div>
</div>
</body>
</html>
