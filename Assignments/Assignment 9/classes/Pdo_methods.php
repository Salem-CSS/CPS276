<?php

require_once 'Db_conn.php';

class Pdo_methods extends Db_conn {

    public function insertRecord($table, $fields, $values) {
        $fieldList = implode(', ', $fields);
        $placeholders = implode(', ', array_fill(0, count($values), '?'));
        $sql = "INSERT INTO $table ($fieldList) VALUES ($placeholders)";
        $stmt = $this->db->prepare($sql);
        $stmt->execute($values);
    }

    public function selectAll($table) {
        $sql = "SELECT * FROM $table";
        $stmt = $this->db->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function selectWhere($table, $field, $value) {
        $sql = "SELECT * FROM $table WHERE $field = ?";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([$value]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
