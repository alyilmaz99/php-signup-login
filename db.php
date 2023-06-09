<?php
class DB {
    private static mysqli $db;
    private function __construct() {}

    public static function Init() {
        $host = "localhost";
        $dbname = "login_db";
        $username = "root";
        $password = "2901";

        $mysqli = new mysqli($host, 
                            $username, 
                                $password,
                                $dbname);
        if ($mysqli->connect_errno) {
            die ("Error connecting to database: " . $mysqli->connect_error);
        }
        self::$db = $mysqli;
    }

    public static function get() {
        return self::$db;
    }
}