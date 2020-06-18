<script type="text/javascript" src="sortTable.js">
</script>

<?php
include 'boohgalter_helper.php';
include 'client_data.php';
?>
<style>
    table, th, td{
        border: 1px solid black;
        border-collapse: collapse;
    }
</style>

<?php
$conn = mysqli_connect($_SESSION['host'], "root", "", "boohgalter");

$sql = "SELECT * FROM clients";
$query = mysqli_query($conn, $sql);
?>

<table id="clientsTable">
    <tr>
        <th onclick="sortTable(0, 'clientsTable', 5)">Имя</th>
        <th onclick="sortTable(1, 'clientsTable', 5)">Телефон</th>
        <th onclick="sortTable(2, 'clientsTable', 5)">Покупок</th>
        <th onclick="sortTable(3, 'clientsTable', 5)">Последняя покупка</th>
        <th onclick="sortTable(4, 'clientsTable', 5)">Комментарий</th>
        <th>Действия</th>
    </tr>
    <?php

    while ($row = mysqli_fetch_array($query)){
        $client_data = new client_data($row['client_id'], $conn);
        echo "<tr>
        <td>
        $client_data->name
        </td>
        <td>
        $client_data->phone
        </td>
        <td>
        $client_data->orders
        </td>
        <td>
        $client_data->last_order
        </td>
        <td>
        $client_data->comment
        </td>
        <td>
        <form action='client_info.php' method='post'>
        <input type='hidden' name='client_id' value='$client_data->client_id'>
        <input type='submit' value='Изменить комментарий'><br>
        </form>
        </td>
        </tr>";
    }
    ?>
</table>
<a href='.'>Вернуться на главную страницу</a>
