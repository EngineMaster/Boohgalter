<script type="text/javascript" src="sortTable.js">
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
        <th onclick="sortTable(0, 'ordersTable', 8)">Организация</th>
        <th onclick="sortTable(1, 'ordersTable', 8)">Имя клиента</th>
        <th onclick="sortTable(2, 'ordersTable', 8)">Телефон</th>
        <th onclick="sortTable(3, 'ordersTable', 8)">Адрес</th>
        <th onclick="sortTable(4, 'ordersTable', 8)">Комментарий</th>
        <th onclick="sortTable(5, 'ordersTable', 8)">Время заказа</th>
        <th onclick="sortTable(6, 'ordersTable', 8)">Блюда</th>
        <th onclick="sortTable(7, 'ordersTable', 8)">Стоимость заказа</th>
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