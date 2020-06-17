<?php
include 'boohgalter_helper.php';

class dish_data
{
    public $name;
    public $cost;
    public $ingridients;
    private $dish_id;
    private $conn;

    public function __construct($conn, $dish_id)
    {
        $this->conn = $conn;
        $this->dish_id = $dish_id;
        $this->ingridients = array(
            "id" => array(),
            "amount" => array()
        );

        $sql = "SELECT * FROM dishes WHERE dish_id = '$dish_id'";
        $query = mysqli_query($conn, $sql);

        while($row = mysqli_fetch_array($query)){
            $this->name = $row['dish_name'];
            $this->cost = $row['dish_cost'];
            array_push($this->ingridients["id"], $row['ingridient_id']);
            array_push($this->ingridients["amount"], $row['ingridient_amount']);
        }
    }

    public function get_ingridients_str(){
        $result = array();
        for($i = 0; $i < count($this->ingridients["id"]); $i++){
            $id = $this->ingridients["id"]["$i"];
            $name = boohgalter_helper::get_ing_by_id($this->conn, $id);
            $amount = $this->ingridients["amount"]["$i"];
            array_push($result, "$name ($amount гр.)");
        }
        return implode(",<br> ", $result);
    }
}