<?php

class client_data
{
    public $client_id;
    public $name;
    public $phone;
    public $orders;
    public $last_order;
    public $comment;

    function __construct($client_id, $conn){
        $this->client_id = $client_id;
        $sql = "SELECT * FROM clients WHERE client_id = '$client_id'";
        $query = mysqli_query($conn, $sql);
        $row = mysqli_fetch_assoc($query);

        $this->phone = $row['phone'];
        $this->name = $row['name'];
        $this->comment = $row['comment'];

        $this->orders = 0;
        $this->last_order = "00-00-00 00:00:00";

        $sql = "SELECT * FROM orders WHERE client_id = '$this->client_id'";
        $query_orders = mysqli_query($conn, $sql);
        $orders_listed = array();
        if (mysqli_num_rows($query_orders) == 0){
            $this->last_order = "";
        }
        else while ($row_order = mysqli_fetch_array($query_orders)){
            if(!in_array($row_order['order_id'], $orders_listed)) {
                $this->orders++;
                array_push($orders_listed, $row_order['order_id']);
            }
            if (self::compareDates($row_order['order_time'], $this->last_order) == 1)
                $this->last_order = $row_order['order_time'];
        }
    }

    public function compareDates($first, $second){
        $exploded1 = explode(" ", $first);
        $exploded2 = explode(" ", $second);
        $dates = array($exploded1[0], $exploded2[0]);
        $times = array($exploded1[1], $exploded2[1]);

        $dates_split1 = explode(":", $dates[0]);
        $dates_split2 = explode(":", $dates[1]);

        if($dates_split1[2] > $dates_split2[2])
            return 1;
        if($dates_split1[2] < $dates_split2[2])
            return -1;

        if($dates_split1[1] > $dates_split2[1])
            return 1;
        if($dates_split1[1] < $dates_split2[1])
            return -1;

        if($dates_split1[0] > $dates_split2[0])
            return 1;
        if($dates_split1[0] < $dates_split2[0])
            return -1;

        $times_split1 = explode("-", $times[0]);
        $times_split2 = explode("-", $times[1]);

        if($times_split1[0] > $times_split2[0])
            return 1;
        if($times_split1[0] < $times_split2[0])
            return -1;

        if($times_split1[1] > $times_split2[1])
            return 1;
        if($times_split1[1] < $times_split2[1])
            return -1;

        if($times_split1[2] > $times_split2[2])
            return 1;
        if($times_split1[2] < $times_split2[2])
            return -1;

        return 0;
    }

    public static function getOrders($conn, $client_id){
        $result = array();
        return $result;
    }
}