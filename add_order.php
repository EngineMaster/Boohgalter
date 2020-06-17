<script>
    document.cookie = "dishes = 1";
    num = 2;
    function addDishOrder() {
        var name = "dish" + num.toString();
        var form = document.getElementById("orderForm");
        var selectElement = document.createElement("select");
        selectElement.id = name;
        selectElement.name = name;
        selectElement.required = true;
        var brElement = document.createElement("br");
        var labelElement = document.createElement("label");
        labelElement.for = name;
        labelElement.innerHTML = "Выберите блюдо " + (num).toString() + ": ";

        var optionElement = document.createElement("option");
        optionElement.value = '';
        optionElement.innerHTML = "Выберите блюдо";
        optionElement.disabled = true;
        optionElement.selected = true;
        selectElement.appendChild(optionElement);
        selectElement.innerHTML = document.getElementById("dish1").innerHTML;

        var numberElement = document.createElement("input");
        numberElement.type = "number";
        numberElement.placeholder = " кол-во порций";
        numberElement.min = "1";
        numberElement.required =true;
        numberElement.name = "dish_amount" + num.toString();

        form.insertBefore(labelElement, document.getElementById("addDish"));
        form.insertBefore(selectElement, document.getElementById("addDish"));
        form.insertBefore(numberElement, document.getElementById("addDish"));
        form.insertBefore(brElement, document.getElementById("addDish"));

        document.cookie = "dishes = " + (num).toString();
        num++;
    }
</script>

<?php
$conn = mysqli_connect($_SESSION['host'], "root", "", "boohgalter");
include 'boohgalter_helper.php';
?>

<form id="orderForm" action="submit_order.php" method="post">
    <select name="org_id" required>
        <option value="" selected disabled>Выберите организацию</option>
<?php
$sql = "SELECT * FROM organizations WHERE 1";
$query = mysqli_query($conn, $sql);
while ($row = mysqli_fetch_array($query)){
    $org_id = $row['org_id'];
    $org_name = $row['org_name'];

    echo "<option value = '$org_id'>$org_name</option>";
}
?>
    </select><br>
    <label for="name">Введите имя клиента</label>
    <input type="text" id = "name" name = "name" required><br>
    <label for="phone">Введите телефон клиента</label>
    <input type="text" id="phone" name="phone" required><br>
    <label for="adress">Введите адрес клиента</label>
    <input type="text" id="dress" name="adress" required><br>
    <label for="commentary">Введите комментарий к заказу</label>
    <input type="text" id="commentary" name="commentary"><br>
    <label for="clientComment">Введите комментарий о клиенте</label>
    <input type="text" id="clientComment" name="client_comment"><br>

    <label for="dish1">Выберите блюдо 1: </label>
    <select id="dish1" name="dish1" required>
        <option value='' selected disabled>Выберите блюдо</option>
        <?php
        $dishes = boohgalter_helper::getDishes($conn);
        for($i = 1; $i <= count($dishes[0]); $i++){
            $dish_id = $dishes[0][$i - 1];
            $dish_name = $dishes[1][$i - 1];
            echo "<option value='$dish_id'>$dish_name</option>";
        }
        ?>
    </select>
    <input type="number" name="dish_amount1" placeholder="кол-во порций" min="1" required><br>

    <input type="button" id="addDish" onclick="addDishOrder()" value="Добавить блюдо"><br>
    <input type="submit" value="Подтвердить заказ">
</form><br>
<a href=".">На главную страницу</a>



<!--
<form action="add_order_dishes.php" method="post">
    <select name="org_id" required>
        <option value="" selected disabled>Выберите организацию</option>

$sql = "SELECT * FROM organizations WHERE 1";
$query = mysqli_query($conn, $sql);
while ($row = mysqli_fetch_array($query)){
    $org_id = $row['org_id'];
    $org_name = $row['org_name'];

    echo "<option value = '$org_id'>$org_name</option>";
}
?>
    </select><br>
    <label for="name">Введите имя клиента</label>
    <input type="text" id = "name" name = "name" required><br>
    <label for="phone">Введите телефон клиента</label>
    <input type="text" id="phone" name="phone" required><br>
    <label for="adress">Введите адрес клиента</label>
    <input type="text" id="dress" name="adress" required><br>
    <label for="commentary">Введите комментарий к заказу</label>
    <input type="text" id="commentary" name="commentary"><br>
    <label for="dishesCount">Введите количество блюд в заказе</label>
    <input type="number" id="dishesCount" name="dishes_count" min="1" required><br>
    <input type="submit" value="Перейти к выбору блюд">
</form>