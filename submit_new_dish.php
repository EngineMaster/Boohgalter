<?php
include 'boohgalter_helper.php';
$conn = mysqli_connect($_SESSION['host'], "root", "", "boohgalter");

$ings_count = $_COOKIE['ings'];
$ing_id_array = array();
$ing_num_array = array();

for($i = 1; $i <= $ings_count; $i++){
    $select_name = "ingridient$i";
    $number_name = "ingridientAmount$i";
    array_push($ing_id_array, $_POST[$select_name]);
    array_push($ing_num_array, $_POST[$number_name]);
}

$dish_id = boohgalter_helper::generateID("dishes", "dish_id", $conn);
$dish_name = $_POST['dish_name'];
$dish_cost = $_POST['dish_cost'];

for($i = 0; $i < $ings_count; $i++){
    $ing_id = $ing_id_array[$i];
    $ing_amount = $ing_num_array[$i];
    $sql = "INSERT INTO `dishes`(`dish_id`, `dish_name`, `dish_cost`, `ingridient_id`, `ingridient_amount`) 
            VALUES ('$dish_id', '$dish_name', '$dish_cost', '$ing_id', '$ing_amount')";
    $query = mysqli_query($conn, $sql);
}

if($query){
    echo "Блюдо добавлено!<br>";
    echo "<a href='.'>Вернуться на главную страницу</a>";
}
