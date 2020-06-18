<?php
include 'boohgalter_helper.php';
$conn = mysqli_connect($_SESSION['host'], "root", "", "boohgalter");

if(isset($_POST['ing_name'])){
    $ing_id = boohgalter_helper::generateID("ingridients", "ingridient_id", $conn);
    $ing_name = $_POST['ing_name'];
    echo $ing_name;
    $sql = "INSERT INTO `ingridients`(`ingridient_id`, `ingridient_name`) VALUES ('$ing_id','$ing_name')";
    $query = mysqli_query($conn, $sql);
}
?>
<form action="#" method="post">
    <label for="ing_name">Введите название ингредиента: </label>
    <input type="text" id="ing_name" name="ing_name"><br>
    <input type="submit" value="Добавить ингредиент">
</form><br>
<a href=".">На главную страницу</a>
