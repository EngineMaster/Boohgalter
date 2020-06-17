<script>
    var lowToHigh = new Boolean(3);
    function sortTable(column) {
        var table, rows, switching, i, x, y, shouldSwitch;
        table = document.getElementById("dishesTable");
        switching = true;
        /*Make a loop that will continue until
        no switching has been done:*/
        if(lowToHigh[column]){
            while (switching) {
                //start by saying: no switching is done:
                switching = false;
                rows = table.rows;
                /*Loop through all table rows (except the
                first, which contains table headers):*/
                for (i = 1; i < (rows.length - 1); i++) {
                    //start by saying there should be no switching:
                    shouldSwitch = false;
                    /*Get the two elements you want to compare,
                    one from current row and one from the next:*/
                    x = rows[i].getElementsByTagName("TD")[column];
                    y = rows[i + 1].getElementsByTagName("TD")[column];
                    //check if the two rows should switch place:
                    if (x.innerHTML.toLowerCase() > y.innerHTML.toLowerCase()) {
                        //if so, mark as a switch and break the loop:
                        shouldSwitch = true;
                        break;
                    }
                }
                if (shouldSwitch) {
                    /*If a switch has been marked, make the switch
                    and mark that a switch has been done:*/
                    rows[i].parentNode.insertBefore(rows[i + 1], rows[i]);
                    switching = true;
                }
            }
        }
        if(!lowToHigh[column]){
            while (switching) {
                //start by saying: no switching is done:
                switching = false;
                rows = table.rows;
                /*Loop through all table rows (except the
                first, which contains table headers):*/
                for (i = 1; i < (rows.length - 1); i++) {
                    //start by saying there should be no switching:
                    shouldSwitch = false;
                    /*Get the two elements you want to compare,
                    one from current row and one from the next:*/
                    x = rows[i].getElementsByTagName("TD")[column];
                    y = rows[i + 1].getElementsByTagName("TD")[column];
                    //check if the two rows should switch place:
                    if (x.innerHTML.toLowerCase() < y.innerHTML.toLowerCase()) {
                        //if so, mark as a switch and break the loop:
                        shouldSwitch = true;
                        break;
                    }
                }
                if (shouldSwitch) {
                    /*If a switch has been marked, make the switch
                    and mark that a switch has been done:*/
                    rows[i].parentNode.insertBefore(rows[i + 1], rows[i]);
                    switching = true;
                }
            }
        }

        lowToHigh[column] = !lowToHigh[column];
    }
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
        <th onclick="sortTable(0)">Название блюда</th>
        <th>Ингридиенты</th>
        <th onclick="sortTable(2)">Стоимость, руб.</th>
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
<input type='submit' name='delete' value='Удалить'>
</form>
</td>
</tr>";
    }
    ?>
</table>
<a href="add_dish.php">Добавить блюдо</a><br>
<a href="add_ingridient.php">Добавить ингридиент</a><br>
<a href='.'>Вернуться на главную страницу</a>
