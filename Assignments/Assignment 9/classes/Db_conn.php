<?php

class Db_conn {
    protected $db;

    public function __construct() {
        $dsn = 'mysql:host=localhost;dbname=sbenkalefa;charset=utf8mb4';
        $username = 'sbenkalefa';
        $password = 'mngMJHuL7n7mtlP';

        try {
            $this->db = new PDO($dsn, $username, $password);
            $this->db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $e) {
            echo "Connection failed: " . $e->getMessage();
            exit;
        }
    }
}
