<script>
    var lowToHigh = new Boolean(5);
    function sortTable(column) {
        var table, rows, switching, i, x, y, shouldSwitch;
        table = document.getElementById("clientsTable");
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
        <th onclick="sortTable(0)">Имя</th>
        <th onclick="sortTable(1)">Телефон</th>
        <th onclick="sortTable(2)">Покупок</th>
        <th onclick="sortTable(3)">Последняя покупка</th>
        <th onclick="sortTable(4)">Комментарий</th>
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
        <input type='submit' value='Подробно'><br>
        </form>
        <form onsubmit=\"return confirm('Вы уверены?');\" action='delete_client.php' method='post'>
        <input type='hidden' name='client_id' value='$client_data->client_id'>
        <input type='submit' value='Удалить клиента'>
        </form>
        </td>
        </tr>";
    }
    ?>
</table>
<a href='.'>Вернуться на главную страницу</a>
