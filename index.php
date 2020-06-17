<?php
session_start();
$_SESSION['host'] = "127.0.0.1:3306";
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Title</title>
</head>
<body>
<a href="add_order.php">Добавить заказ</a><br>
<a href="clients.php">База клиентов</a><br>
<a href="orders.php">Заказы</a><br>
<a href="add_org.php">Добавить организацию</a><br>
<a href="dishes.php">Блюда</a><br>
</body>
</html>