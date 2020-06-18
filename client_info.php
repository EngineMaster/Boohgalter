<?php
include 'client_data.php';
$conn = mysqli_connect($_SESSION['host'], "root", "", "boohgalter");

if (isset($_POST['comment_change'])){
    $client_id = $_POST['client_id'];
    $new_comment = $_POST['new_comment'];
    $sql = "UPDATE clients SET comment = '$new_comment' WHERE client_id = '$client_id'";
    $query = mysqli_query($conn, $sql);
}

else {
    $client_id = $_POST['client_id'];
    $client_data = new client_data($client_id, $conn);
    $name = $client_data->name;
    $phone = $client_data->phone;
    $comment = $client_data->comment;

    echo "<form action='#' method='post'>
    <label'>Имя: $name</label><br>
    <label>Телефон: $phone</label><br>
    <label>Заказов: $client_data->orders</label><br>
    <label for='comment'>Комментарий: </label>
    <input type='hidden' name='client_id' value='$client_id'>
    <input type='text' id='comment' name='new_comment' value='$comment'><br>
    <input type='submit' name='comment_change' value='Изменить комментарий'><br>
    </form>
    ";
}
echo "<br><a href='./clients.php'>Вернуться обратно</a>";
