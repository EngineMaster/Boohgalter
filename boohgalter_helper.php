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

    public static function getDishes($conn){
        $sql = "SELECT * FROM dishes WHERE 1";
        $query = mysqli_query($conn, $sql);

        $result = array();
        while ($row = mysqli_fetch_array($query)){
            $dish_id = $row['dish_id'];
            if(!in_array($dish_id, $result)){
                array_push($result, $dish_id);
                array_push($result, $row['dish_name']);
            }
        }

        return $result;
    }

    public static function getDishesCost($conn, $dishes){
        $result = 0.0;
        for ($i = 0; $i < count($dishes); $i++){
            $sql = "SELECT * FROM dishes WHERE dish_id = '$dishes[$i]'";
            $query = mysqli_query($conn, $sql);

            while ($row = mysqli_fetch_array($query)){
                $dish_cost = $row['dish_cost'];
                $result += $dish_cost;
            }
        }
        return $result;
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
