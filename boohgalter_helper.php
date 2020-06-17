<?php

class boohgalter_helper
{
    public static function uniqidReal($length = 13)
    {
        // uniqid gives 13 chars, but you could adjust it to your needs.
        if (function_exists("random_bytes")) {
            $bytes = random_bytes(ceil($length / 2));
        } elseif (function_exists("openssl_random_pseudo_bytes")) {
            $bytes = openssl_random_pseudo_bytes(ceil($length / 2));
        } else {
            throw new Exception("no cryptographically secure random function available");
        }
        return substr(bin2hex($bytes), 0, $length);
    }

    public static function generateID($bd_name, $id_name, $conn)
    {
        $result = strval(rand(0, 999999));
        for($i = 0; $i < 6 - strlen($result); $i++){
            $result = "0" + $result;
        }
        $sql = "SELECT * FROM '$bd_name' WHERE '$id_name'";
        $query = mysqli_query($conn, $sql);
        if (!$query)
            return $result;
        else
            return self::generateID($bd_name, $id_name, $conn);
    }

    public static function getDishes($conn){
        $sql = "SELECT * FROM dishes WHERE 1";
        $query = mysqli_query($conn, $sql);

        $result = array(array(), array());
        while ($row = mysqli_fetch_array($query)){
            if(in_array($row['dish_id'], $result[0]))
                continue;
            array_push($result[0], $row['dish_id']);
            array_push($result[1], $row['dish_name']);
        }

        return $result;
    }

    public static function get_ing_by_id($conn, $ing_id){
        $sql = "SELECT * FROM ingridients WHERE ingridient_id = '$ing_id'";
        $query = mysqli_query($conn, $sql);
        $row = mysqli_fetch_assoc($query);
        return $row['ingridient_name'];
    }

    public static function get_dish_by_id($conn, $dish_id){
        $sql = "SELECT * FROM dishes WHERE $dish_id = '$dish_id'";
        $query = mysqli_query($conn, $sql);
        $row = mysqli_fetch_assoc($query);
        return $row['$dish_name'];
    }

    //first is earlier - returns -1; equal - returns 0; first is later - returns 1
    public static function compareDates($first, $second){
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

    public static function utf8ize($d) {
        if (is_array($d)) {
            foreach ($d as $k => $v) {
                $d[$k] = utf8_encode($v);
            }
        } else if (is_string ($d)) {
            return utf8_encode($d);
        }
        return $d;
    }
}
