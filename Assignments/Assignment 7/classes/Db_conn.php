<?php
declare(strict_types=1);

class Db_conn {

    private string $host = "localhost";
    private string $db = "sbenkalefa";
    private string $user = "sbenkalefa";
    private string $pass = "mngMJHuL7n7mtlP";
    private string $charset = "utf8mb4";

    public function dbOpen(): PDO {
        $dsn = "mysql:host={$this->host};dbname={$this->db};charset={$this->charset}";
        $options = [
            PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
            PDO::ATTR_EMULATE_PREPARES   => false,
        ];

        $pass = getenv("DB_PASSWORD");
        if ($pass === false || $pass === "") {
            $pass = $this->pass;
        }

        return new PDO($dsn, $this->user, $pass, $options);
    }
}
