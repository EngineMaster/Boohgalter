<script type="text/javascript" src="sortTable.js">
</script>

<?php
include 'dish_data.php';
$conn = mysqli_connect($_SESSION['host'], "root", "", "boohgalter");

$sql = "SELECT * FROM dishes";
$query = mysqli_query($conn, $sql);
?>
<style>
    table, th, td{
        border: 1px solid black;
        border-collapse: collapse;
    }
</style>
<table id="dishesTable">
    <tr>
        <th onclick="sortTable(0, 'dishesTable', 3)">Название блюда</th>
        <th>Ингредиенты</th>
        <th onclick="sortTable(2, 'dishesTable', 3)">Стоимость, руб.</th>
        <th>Действия</th>
    </tr>
    <?php
    $dishes_listed = array();
    while ($row = mysqli_fetch_array($query)){
        $dish_id = $row['dish_id'];
        if (!in_array($dish_id, $dishes_listed))
            array_push($dishes_listed, $dish_id);
        else continue;

        $dish_data = new dish_data($conn, $dish_id);
        $ings_str = $dish_data->get_ingridients_str();
        echo "<tr>
<td>
$dish_data->name
</td>
<td>
$ings_str
</td>
<td>
$dish_data->cost
</td>
<td>
<form action='edit_dish.php' method='post'>
<input type='hidden' name='dish_id' value='$dish_id'>
<input type='submit' name='edit' value='Изменить блюдо'><br>
</form>
</td>
</tr>";
    }
    ?>
</table>
<a href="add_dish.php">Добавить блюдо</a><br>
<a href="add_ingridient.php">Добавить ингредиент</a><br>
<a href='.'>Вернуться на главную страницу</a>
