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

// Обработка запроса на удаление записи
if (isset($_GET['delete']) && isset($_GET['id'])) {
    $id = $_GET['id'];
    $sql = "DELETE FROM products WHERE ProductID='$id'";
    if ($conn->query($sql) === TRUE) {
        echo "Record deleted successfully";
    } else {
        echo "Error deleting record: " . $conn->error;
    }
}

// Обработка POST запроса на добавление или редактирование записи
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (!empty($_POST['product_name']) && !empty($_POST['price']) && !empty($_POST['category']) && !empty($_POST['supplier_id'])) {
        $product_name = mysqli_real_escape_string($conn, $_POST['product_name']);
        $price = mysqli_real_escape_string($conn, $_POST['price']);
        $category = mysqli_real_escape_string($conn, $_POST['category']);
        $supplier_id = mysqli_real_escape_string($conn, $_POST['supplier_id']);

        if (isset($_POST['id']) && !empty($_POST['id'])) {
            // Редактирование записи
            $id = $_POST['id'];
            $sql = "UPDATE products SET ProductName='$product_name', Price='$price', Category='$category', SupplierID='$supplier_id' WHERE ProductID='$id'";
            if ($conn->query($sql) === TRUE) {
                echo "Record updated successfully";
            } else {
                echo "Error updating record: " . $conn->error;
            }
        } else {
            // Добавление новой записи
            $sql = "INSERT INTO products (ProductName, Price, Category, SupplierID)
                    VALUES ('$product_name', '$price', '$category', '$supplier_id')";
            if ($conn->query($sql) === TRUE) {
                echo "New record created successfully";
            } else {
                echo "Error: " . $sql . "<br>" . $conn->error;
            }
        }
    } else {
        echo "All fields are required.";
    }
}

// Получение данных для редактирования
$edit_product = null;
if (isset($_GET['edit']) && isset($_GET['id'])) {
    $id = $_GET['id'];
    $sql = "SELECT * FROM products WHERE ProductID='$id'";
    $result = $conn->query($sql);
    if ($result->num_rows > 0) {
        $edit_product = $result->fetch_assoc();
    } else {
        echo "Record not found";
    }
}

// Получение данных из таблицы products
$sql = "SELECT * FROM products";
$result = $conn->query($sql);

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="redact.css">
    <title>Таблица товаров</title>
</head>
<body>
<header>
    <div class="header-container">
        <h1>Действия</h1>
        <nav>
            <ul>
                <li><a href="admin_profile.php">на страницу профиля</a></li>
                <li><a href="carto.php">посмотреть товары</a></li>
            </ul>
        </nav>
    </div>
</header>
    <h2>Таблица товаров</h2>
    <table border="1">
        <tr>
            <th>ID продукта</th>
            <th>Название</th>
            <th>Цена</th>
            <th>Категория</th>
            <th>ID поставщика</th>
            <th>Действия</th>
        </tr>
        <?php
        if ($result->num_rows > 0) {
            while($row = $result->fetch_assoc()) {
                echo "<tr>";
                echo "<td>" . $row["ProductID"]. "</td>";
                echo "<td>" . $row["ProductName"]. "</td>";
                echo "<td>" . $row["Price"]. "</td>";
                echo "<td>" . $row["Category"]. "</td>";
                echo "<td>" . $row["SupplierID"]. "</td>";
                echo "<td><a href='?edit=true&id=" . $row["ProductID"] . "'>Edit</a> | 
                <a href='delete_product.php?id=" . $row["ProductID"] . "' class='delete-link'>Delete</a></td>";
                echo "</tr>";
            }
        } else {
            echo "0 results";
        }
        ?>
    </table>
    <h2><?php echo isset($edit_product) ? 'Редактировать товар' : 'Добавить новый товар'; ?></h2>
    <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
        <?php if (isset($edit_product)): ?>
            <input type="hidden" name="id" value="<?php echo $edit_product['ProductID']; ?>">
        <?php endif; ?>
        <label for="product_name">Название:</label><br>
        <input type="text" id="product_name" name="product_name" value="<?php echo isset($edit_product) ? $edit_product['ProductName'] : ''; ?>" required><br>
        <label for="price">Цена:</label><br>
        <input type="number" id="price" name="price" min="0" step="0.01" value="<?php echo isset($edit_product) ? $edit_product['Price'] : ''; ?>" required><br>
        <label for="category">Категория:</label><br>
        <input type="text" id="category" name="category" value="<?php echo isset($edit_product) ? $edit_product['Category'] : ''; ?>" required><br>
        <label for="supplier_id">ID поставщика:</label><br>
        <input type="number" id="supplier_id" name="supplier_id" min="0" value="<?php echo isset($edit_product) ? $edit_product['SupplierID'] : ''; ?>" required><br>
        <input type="submit" value="<?php echo isset($edit_product) ? 'Обновить запись' : 'Добавить запись'; ?>">
        <?php if (isset($edit_product)): ?>
            <a href="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>"><button type="button">Отменить</button></a>
        <?php endif; ?>
    </form>
</body>
</html>
