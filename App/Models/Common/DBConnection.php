<?php

namespace App\Models\Common;

use PDO;
use App\Models\Common as Common;
use App\Config;

class DBConnection {

    private $db = false;
    private static $database_host = 'localhost';
    private static $database_type = "mysql";
    private static $database_db = "";
    private static $database_user = "";
    private static $database_pass = '';

    function __construct() {
        $data = Config::getDataBaseCredentials();
        static::$database_host = $data['host'];
        static::$database_db = $data['db'];
        static::$database_user = $data['user'];
        static::$database_pass = $data['pass'];
        if ($this->db === false) {
            $this->connect();
        }        
    }

    public function getConnection() {
        return $this->db;
    }

    private function connect() {

        $dsn = self::$database_type . ":dbname=" . self::$database_db . ";host=" . self::$database_host;
        date_default_timezone_set("Asia/Kolkata");
        $this->db = new PDO($dsn, self::$database_user, self::$database_pass, array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8"));
        $this->db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $this->db->exec("SET time_zone = '+5:30';");
    }

}
