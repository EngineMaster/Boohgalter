<?php
include 'boohgalter_helper.php';
$conn = mysqli_connect("127.0.0.1:3306", "root", "", "boohgalter");

$order_id = boohgalter_helper::uniqidReal();
$org_id = $_POST['org_id'];
$name = $_POST['name'];
$phone = $_POST['phone'];
$adress = $_POST['adress'];
$commentary = $_POST['commentary'];
$dishes_count = $_POST['dishes_count'];
$datetime = date("d:m:y H-i-s");

$dishes = array();
$dish_amount_array = array();

for($i = 1; $i <= $dishes_count; $i++){
    $dish_id = $_POST["dish$i"];
    $dish_amount = $_POST["dish_amount$i"];
    array_push($dishes, $dish_id);
    array_push($dish_amount_array, $dish_amount);
}

$order_cost = boohgalter_helper::getDishesCost($conn, $dishes);

for($i = 0; $i < $dishes_count; $i++){
    $dish_id = $dishes[$i];
    $dish_amount = $dish_amount_array[$i];
    $sql = "INSERT INTO `orders`(`order_id`, `organization_id`, `client_name`,
            `client_phone`, `client_adress`, `order_commentary`, `order_time`,
            `dish_id`, `dish_amount`, `order_cost`)
    VALUES ('$order_id', '$org_id', '$name', '$phone', '$adress', '$commentary', '$datetime',
        '$dish_id', '$dish_amount', '$order_cost')";

    $query = mysqli_query($conn, $sql);

    if($query){
        $num = $i+1;
        echo "Dish $num loaded";
    }
}

$sql = "SELECT * FROM clients WHERE phone = '$phone'";
$query = mysqli_query($conn, $sql);

if (mysqli_num_rows($query) == 0){
    $sql = "INSERT INTO clients (`phone`, `name`) 
        VALUES ('$phone', '$name')";
    $query = mysqli_query($conn, $sql);
}
?>
<a href=".">Перейти обратно</a>


