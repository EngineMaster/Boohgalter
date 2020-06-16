<?php
echo "<meta name=\"http-equiv\" content=\"Content-type: text/html; charset=utf-8\">";
include 'boohgalter_helper.php';

?>
<script type='text/javascript' src="scripts.js">

</script>
<?php
$conn = mysqli_connect("127.0.0.1:3306", "root", "", "boohgalter");
$org_id = $_POST['org_id'];
$name = $_POST['name'];
$phone = $_POST['phone'];
$adress = $_POST['adress'];
$commentary = $_POST['commentary'];
$dishes_count = $_POST['dishes_count'];
$datetime = str_replace("T", ' ', $_POST['datetime']);

$sql = "SELECT * FROM organizations WHERE org_id = '$org_id'";
$query = mysqli_query($conn, $sql);
while ($row = mysqli_fetch_array($query))
    $org_name = $row['org_name'];

$dish_id_array = array();
$dish_amount_array = array();
?>
<form action="submit_order.php" id="dishesForm" method="post">
    <?php
    echo "<input type='hidden' value=$org_id name='org_id'>";
    echo "<input type='hidden' value=$name name='name'>";
    echo "<input type='hidden' value=$phone name='phone'>";
    echo "<input type='hidden' value=$adress name='adress'>";
    echo "<input type='hidden' value=$commentary name='commentary'>";
    echo "<input type='hidden' value=$dishes_count name='dishes_count'>";
    echo "<input type='hidden' value=$datetime name='datetime'>";
    echo "<label>Организация: $org_name</label><br>";
    echo "<label>Имя: $name</label><br>";
    echo "<label>Телефон: $phone</label><br>";
    echo "<label>Адрес: $adress</label><br>";
    echo "<label>Время заказа: $datetime</label><br>";
    echo "<label>Комментарий: $commentary</label><br>";

    $dishes = boohgalter_helper::getDishes($conn);

    for($k = 1; $k <= $dishes_count; $k++) {
        echo "<label>$k. </label>";
        $select_name = "dish$k";
        echo "<select name='$select_name' required>";
        echo "<option value='' selected disabled>Выберите блюдо</option>";

        for ($i = 0; $i < count($dishes); $i += 2) {
            $dish_id = $dishes[$i];
            $dish_name = $dishes[$i + 1];
            echo "<option value = '$dish_id'>$dish_name</option>";
        }

        echo "</select>";
        $number_name = "dish_amount$k";
        echo "<input type='number' min='1' placeholder='Кол-во порций' name='$number_name' required><br>";
    }
    echo "<input type='submit' value='Подтвердить заказ'>";
    ?>
</form>

