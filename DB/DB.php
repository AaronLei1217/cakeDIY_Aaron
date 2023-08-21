<?php
class DB {
    private static $mysqli;
    function __construct() {
        mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);

        $host = "127.0.0.1:3306";
        $user = "root";
        $pwd  = "";
        $db   = "cake";

        DB::$mysqli = new mysqli($host, $user, $pwd, $db);
    }

    private static function getTypes($params) {
        $types = '';
        foreach($params as $param) {
            switch(gettype($param)) {
                case 'string':
                    $types .= 's';
                    break;
                case 'integer':
                    $types .= 'i';
                    break;
                case 'double':
                    $types .= 'd';
                    break;
                case 'array':
                    $types .= 'b';
                    break;
                case 'NULL':
                    $types .= 's';
                    break;
            }
        }
        return $types;
    }

    private static function query($sql, ?Array $params=null) {
        if ($params == null) {
            $stmt = DB::$mysqli->prepare($sql);
            $stmt->execute();
            $result = $stmt->get_result();
            $stmt->close();
        } else {
            $types = DB::getTypes($params);
            $stmt = DB::$mysqli->prepare($sql);

            $arr = [];
            for($i = 0; $i < strlen($types); $i++) {
                if (substr($types, $i, 1) != 'b') {
                    $arr[] = $params[$i];
                } else {
                    $arr[] = $params[$i][0];
                }
            }
            $stmt->bind_param($types, ...$arr);

            for($i = 0; $i < strlen($types); $i++) {
                if (substr($types, $i, 1) == 'b') {
                    $stmt->send_long_data($i, $arr[$i]);
                }
            }

            $stmt->execute();
            $result = $stmt->get_result();
            $stmt->close();
        }

        return $result;
    }

    static function select($sql, $complete, ?Array $params=null) {
        $result = DB::query($sql, $params);
        $rows = $result->fetch_all(MYSQLI_ASSOC);
        $complete($rows);
    }

    static function insert($sql, ?Array $params=null) {
        return DB::query($sql, $params);
    }

    static function delete($sql, ?Array $params=null) {
        return DB::query($sql, $params);
    }

    static function update($sql, ?Array $params=null) {
        return DB::query($sql, $params);
    }

    static function call($sql, ?Array $params=null) {
        return DB::query($sql, $params);
    }
}

$db = new DB();