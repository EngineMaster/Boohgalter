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
include 'dish_data.php';
$conn = mysqli_connect($_SESSION['host'], "root", "", "boohgalter");

if(isset($_POST['delete'])){
    $dish_id = $_POST['dish_id'];
    $sql = "DELETE FROM dishes WHERE dish_id = $dish_id";
    $query = mysqli_query($conn, $sql);
    echo "<a href='.'>Вернуться на главную страницу</a>";
}
else if (isset($_POST['edit'])){
    $dish_id = $_POST['dish_id'];
    $dish_data = new dish_data($conn, $dish_id);
    $name = $dish_data->name;
    $ings = $dish_data->ingridients;
    $ings_count = count($ings["id"]);
    $cost = $dish_data->cost;

    echo "<form action = '#' method='post'>
<label for='dishName'>Название блюда: </label>
<input type='text' id='dishName' name='name' value='$name'><br>";



    echo "
    <input type='button' id='addIngridient' onclick='addDish()' value='Добавить ингредиент'><br>
    <label for=\"dishCost\">Введите стоимость блюда: </label>
    <input type=\"number\" id=\"dishCost\" name=\"dish_cost\" value='$cost' placeholder=\"стоимость блюда\" min=\"1\"><br>
    <input type=\"submit\" name='edit_commit' value=\"Изменить блюдо\"><br>

";
echo "<a href='./dishes.php'>Вернуться обратно</a>";

}