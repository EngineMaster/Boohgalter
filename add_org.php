<?php
include 'boohgalter_helper.php';
$conn = mysqli_connect($_SESSION['host'], "root", "", "boohgalter");

if(isset($_POST['org_name'])){
    $org_id = boohgalter_helper::generateID("organizations", "org_id", $conn);
    $org_name = $_POST['org_name'];
    $sql = "INSERT INTO organizations(org_id, org_name) VALUES ('$org_id', '$org_name')";
    $query = mysqli_query($conn, $sql);

    if($query){
        echo "Организация добавлена!<br>";
        echo "<a href='.'>Вернуться на главную страницу</a>";
    }
}
else {
    echo "<form action='#' method='post'>
    <label for='orgName'>Введите название организации: </label>
    <input type='text' id='orgName' name='org_name' required><br>
    <input type='submit' value='Добавить огранизацию'>
</form>";
    echo "<a href='.'>Вернуться на главную страницу</a>";
}