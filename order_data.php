<?php


class order_data
{
    public $order_id;
    public $conn;
    public $org_name;
    public $client_name;
    public $client_phone;
    public $client_adress;
    public $order_comment;
    public $order_time;
    public $dishes;
    public $cost;

    function __construct($order_id, $conn)
    {
        $this->order_id = $order_id;
        $this->conn = $conn;
        $this->dishes = array();
        $this->cost = 0;

        $sql = "SELECT * FROM orders WHERE order_id = '$this->order_id'";
        $query = mysqli_query($this->conn, $sql);

        while ($row = mysqli_fetch_array($query)){
            $this->order_time = $row['order_time'];
            $this->order_comment = $row['order_commentary'];
            $this->getClientInfo($row['client_id']);
            $this->client_adress = $row['client_adress'];
            $this->org_name = $this->getOrgName($row['organization_id']);
            array_push($this->dishes, $this->getDishName($row));

            $this->cost += $this->calculateDishCost($row);
        }
    }

    function getClientInfo($client_id){
        $sql = "SELECT * FROM clients WHERE client_id = '$client_id'";
        $query = mysqli_query($this->conn, $sql);
        $row = mysqli_fetch_assoc($query);
        $this->client_name = $row['name'];
        $this->client_phone = $row['phone'];
    }

    function calculateDishCost($row){
        $dish_id = $row['dish_id'];
        $dish_amount = $row['dish_amount'];

        $sql = "SELECT * FROM dishes WHERE dish_id = $dish_id";
        $query = mysqli_query($this->conn, $sql);
        $row_result = mysqli_fetch_assoc($query);

        return $row_result['dish_cost'] * $dish_amount;
    }

    function getOrgName($org_id){
        $sql = "SELECT * FROM organizations WHERE org_id = '$org_id'";
        $query = mysqli_query($this->conn, $sql);
        $row = mysqli_fetch_assoc($query);
        return $row['org_name'];
    }

    function getDishName($row){
        $dish_id = $row['dish_id'];
        $sql = "SELECT * FROM dishes WHERE dish_id = '$dish_id'";
        $query = mysqli_query($this->conn, $sql);

        $row_dish = mysqli_fetch_assoc($query);
        $dish_amount = $row['dish_amount'];
        $dish_name = $row_dish['dish_name'];
        $result = "$dish_name($dish_amount пор.)";
        return $result;
    }
}