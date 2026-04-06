<?php
declare(strict_types=1);
require_once __DIR__ . "/Db_conn.php";

class Pdo_methods {

    private PDO $pdo;

    public function __construct() {
        $db = new Db_conn();
        $this->pdo = $db->dbOpen();
    }

    /**
     * Run INSERT/UPDATE/DELETE with bound parameters.
     * @param array<int, array{param:string, value:mixed, type:int}> $bindings
     */
    public function otherBinded(string $sql, array $bindings): array {
        try {
            $stmt = $this->pdo->prepare($sql);
            foreach ($bindings as $b) {
                $stmt->bindValue($b["param"], $b["value"], $b["type"]);
            }
            $stmt->execute();
            return ["status" => "success"];
        } catch (Throwable $e) {
            return ["status" => "error", "message" => $e->getMessage()];
        }
    }

    /**
     * Run a SELECT with bound parameters.
     * @param array<int, array{param:string, value:mixed, type:int}> $bindings
     * @return array<int, array<string, mixed>>|string
     */
    public function selectBinded(string $sql, array $bindings) {
        try {
            $stmt = $this->pdo->prepare($sql);
            foreach ($bindings as $b) {
                $stmt->bindValue($b["param"], $b["value"], $b["type"]);
            }
            $stmt->execute();
            return $stmt->fetchAll();
        } catch (Throwable $e) {
            return "Error: " . $e->getMessage();
        }
    }

    /**
     * Run a SELECT with no bindings.
     * @return array<int, array<string, mixed>>|string
     */
    public function selectNotBinded(string $sql) {
        try {
            $stmt = $this->pdo->query($sql);
            return $stmt->fetchAll();
        } catch (Throwable $e) {
            return "Error: " . $e->getMessage();
        }
    }
}
