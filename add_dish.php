<script>
    num = 2;
    function addDish() {
        var name = "ingridient" + num.toString();
        var form = document.getElementById("addDishForm");
        var selectElement = document.createElement("select");
        selectElement.id = name;
        selectElement.name = name;
        selectElement.required =true;
        var brElement = document.createElement("br");
        var labelElement = document.createElement("label");
        labelElement.for = name;
        labelElement.innerHTML = "Выберите ингредиент " + (num).toString() + ": ";

        var optionElement = document.createElement("option");
        optionElement.value = '';
        optionElement.innerHTML = "Выберите ингредиент";
        optionElement.disabled = true;
        optionElement.selected = true;
        selectElement.appendChild(optionElement);
        selectElement.innerHTML = document.getElementById("ingridient1").innerHTML;

        var numberElement = document.createElement("input");
        numberElement.type = "number";
        numberElement.placeholder = " кол-во ингредиента (гр)";
        numberElement.min = "1";
        numberElement.required =true;
        numberElement.name = "ingridientAmount" + num.toString();

        form.insertBefore(labelElement, document.getElementById("addIngridient"));
        form.insertBefore(selectElement, document.getElementById("addIngridient"));
        form.insertBefore(numberElement, document.getElementById("addIngridient"));
        form.insertBefore(brElement, document.getElementById("addIngridient"));

        document.cookie = "ings = " + (num).toString();
        num++;
    }
</script>

<?php
$conn = mysqli_connect($_SESSION['host'], "root", "", "boohgalter");
$ingridients = array(array(), array());

$sql = "SELECT * FROM ingridients WHERE 1";
$query = mysqli_query($conn, $sql);

while($row = mysqli_fetch_array($query)){
    array_push($ingridients[0], $row['ingridient_id']);
    array_push($ingridients[1], $row['ingridient_name']);
}
?>

<form id="addDishForm" action="submit_new_dish.php" method="post">
    <label for="name">Название блюда: </label>
    <input type="text" id="name" name="dish_name" required><br>
    <label for="ingridient1">Выберите ингредиент 1: </label>
    <select id="ingridient1" name="ingridient1" required>
        <option value='' selected disabled>Выберите ингредиент</option>
        <?php
            for($i = 1; $i <= count($ingridients[0]); $i++){
                $ing_id = $ingridients[0][$i - 1];
                $ing_name = $ingridients[1][$i - 1];
                echo "<option value='$ing_id'>$ing_name</option>";
            }
        ?>
    </select>
    <input type="number" name="ingridientAmount1" placeholder="кол-во ингредиента (гр)" min="1" required><br>
    <input type="button" id="addIngridient" onclick="addDish()" value="Добавить ингредиент"><br>
    <label for="dishCost">Введите стоимость блюда: </label>
    <input type="number" id="dishCost" name="dish_cost" placeholder="стоимость блюда" min="1" required><br>
    <input type="submit" value="Добавить блюдо">
</form><br>
<a href=".">На главную страницу</a>