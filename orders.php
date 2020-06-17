<script>
    var lowToHigh = new Boolean(5);
    function sortTable(column) {
        var table, rows, switching, i, x, y, shouldSwitch;
        table = document.getElementById("ordersTable");
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
include 'order_data.php';
$conn = mysqli_connect($_SESSION['host'], "root", "", "boohgalter");
?>
    <style>
        table, th, td{
            border: 1px solid black;
            border-collapse: collapse;
        }
    </style>

<?php
$sql = "SELECT * FROM orders";
$query = mysqli_query($conn, $sql);
?>

<table id="ordersTable">
    <tr>
        <th onclick="sortTable(0)">Организация</th>
        <th onclick="sortTable(1)">Имя клиента</th>
        <th onclick="sortTable(2)">Телефон</th>
        <th onclick="sortTable(3)">Адрес</th>
        <th onclick="sortTable(4)">Комментарий</th>
        <th onclick="sortTable(5)">Время заказа</th>
        <th onclick="sortTable(6)">Блюда</th>
        <th onclick="sortTable(7)">Стоимость заказа</th>
    </tr>
    <?php
    $orders_listed = array();
    $orders = array();
    while ($row = mysqli_fetch_array($query)) {
        if (!in_array($row['order_id'], $orders_listed))
            array_push($orders_listed, $row['order_id']);
        else continue;

        $order_data = new order_data($row['order_id'], $conn);
        echo "<tr>
        <td>
        $order_data->org_name
        </td>

        <td>
        $order_data->client_name
        </td>

        <td>
        $order_data->client_phone
        </td>

        <td>
        $order_data->client_adress
        </td>

        <td>
        $order_data->order_comment
        </td>

        <td>
        $order_data->order_time
        </td>

        <td>";
        $dishes = $order_data->dishes;
        for($i = 0; $i < count($dishes) - 1; $i++){
            echo "$dishes[$i],<br>";
        }
        echo $dishes[count($dishes) - 1];
        echo "</td>

        <td>
        $order_data->cost
        </td>
        </tr>";
    }
    ?>
</table>
<a href='.'>Вернуться на главную страницу</a>