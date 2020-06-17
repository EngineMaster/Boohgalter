<?php
include 'boohgalter_helper.php';
$conn = mysqli_connect($_SESSION['host'], "root", "", "boohgalter");

$order_id = boohgalter_helper::uniqidReal();
$org_id = $_POST['org_id'];
$name = $_POST['name'];
$phone = $_POST['phone'];
$adress = $_POST['adress'];
$commentary = $_POST['commentary'];
$client_comment = $_POST['client_comment'];
$dishes_count = $_COOKIE['dishes'];
$datetime = date("d-m-y H:i:s");


$sql = "SELECT * FROM clients WHERE phone = '$phone' AND name = '$name'";
$query = mysqli_query($conn, $sql);

if (mysqli_num_rows($query) == 0){
    $client_id = boohgalter_helper::generateID("clients", "client_id", $conn);
    $sql = "INSERT INTO clients (`client_id`, `phone`, `name`, `comment`) 
        VALUES ('$client_id', '$phone', '$name', '$client_comment')";
    $query = mysqli_query($conn, $sql);
}
else{
    $client_id = mysqli_fetch_assoc($query)['client_id'];
    $sql = "UPDATE clients SET comment = '$client_comment' WHERE client_id = '$client_id'";
    $query = mysqli_query($conn, $sql);
}

$dish_id_array = array();
$dish_amount_array = array();

for($i = 1; $i <= $dishes_count; $i++){
    $dish_id = $_POST["dish$i"];
    $dish_amount = $_POST["dish_amount$i"];
    array_push($dish_id_array, $dish_id);
    array_push($dish_amount_array, $dish_amount);
}

for($i = 0; $i < $dishes_count; $i++){
    $dish_id = $dish_id_array[$i];
    $dish_amount = $dish_amount_array[$i];
    $sql = "INSERT INTO `orders`(`order_id`, `organization_id`, `client_id`, `client_adress`, `order_commentary`, `order_time`,
            `dish_id`, `dish_amount`)
    VALUES ('$order_id', '$org_id', '$client_id', '$adress', '$commentary', '$datetime',
        '$dish_id', '$dish_amount')";
    echo $sql;
    $query = mysqli_query($conn, $sql);

    if($query){
        $num = $i+1;
        echo "Dish $num loaded";
    }
}
?>
<br>
<a href=".">На главную страницу</a>

