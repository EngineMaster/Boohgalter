<?php
$conn = mysqli_connect($_SESSION['host'], "root", "", "boohgalter");
$client_id = $_POST['client_id'];
$sql = "DELETE FROM clients WHERE client_id = '$client_id'";
$query = mysqli_query($conn, $sql);
echo "<br><a href='./clients.php'>Вернуться обратно</a>";
