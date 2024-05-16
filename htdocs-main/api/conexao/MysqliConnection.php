<?php
namespace api\conexao;
use mysqli;

class MysqliConnection {
    private static $instance;
    private $conn;

    private function __construct() {
        // To-do: should be ENV variables when in production
        $servername = "localhost";
        $username = "root";
        $password_db = "root";
        $dbname = "cpphp_ex";

        $this->conn = new \mysqli($servername, $username, $password_db, $dbname);
        if ($this->conn->connect_error) {
            die("Conexão falhou: " . $this->conn->connect_error);
        }
    }

    public static function getInstance() {
        if (self::$instance === null) {
            self::$instance = new self();
        }
        return self::$instance;
    }

    public function getConnection() {
        return $this->conn;
    }

    private function __clone() {}
    private function __wakeup() {}
}






?>