<?php
session_start();
$conn = mysqli_connect("127.0.0.1:3306", "root", "", "boohgalter");
include 'boohgalter_helper.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Title</title>
</head>
<body>

<form action="add_dishes.php" method="post">
    <select name="org_id" required>
        <option value="" selected disabled>Выберите организацию</option>
<?php
$sql = "SELECT * FROM organizations WHERE 1";
$query = mysqli_query($conn, $sql);
while ($row = mysqli_fetch_array($query)){
    $org_id = $row['org_id'];
    $org_name = $row['org_name'];

    echo "<option value = '$org_id'>$org_name</option>";
}
?>
    </select><br>
    <label for="name">Введите имя клиента</label>
    <input type="text" id = "name" name = "name" required><br>
    <label for="phone">Введите телефон клиента</label>
    <input type="text" id="phone" name="phone" required><br>
    <label for="adress">Введите адрес клиента</label>
    <input type="text" id="dress" name="adress" required><br>
    <label for="datetime">Укажите время заказа</label>
    <input type="datetime-local" id="datetime" name="datetime"><br>
    <label for="commentary">Введите комментарий к заказу</label>
    <input type="text" id="commentary" name="commentary"><br>
    <label for="dishesCount">Введите количество блюд в заказе</label>
    <input type="number" id="dishesCount" name="dishes_count" min="1" required><br>
    <input type="submit" value="Перейти к выбору блюд">
</form>

</body>
</html>