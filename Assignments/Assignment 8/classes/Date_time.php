<?php
declare(strict_types=1);
require_once __DIR__ . "/Pdo_methods.php";

class Date_time {

    private Pdo_methods $pdo;

    public function __construct() {
        $this->pdo = new Pdo_methods();
    }

    public function addNote(): string {
        if (($_SERVER["REQUEST_METHOD"] ?? "") !== "POST") {
            return "";
        }

        $dateTime = trim((string)($_POST["dateTime"] ?? ""));
        $note = trim((string)($_POST["note"] ?? ""));

        if ($dateTime === "") {
            return "<p class=\"text-danger\">Please enter a date and time.</p>";
        }
        if ($note === "") {
            return "<p class=\"text-danger\">Please enter a note.</p>";
        }

        $ts = strtotime(str_replace("T", " ", $dateTime));
        if ($ts === false) {
            return "<p class=\"text-danger\">Invalid date and time.</p>";
        }

        $sql = "INSERT INTO notes (date_time, note) VALUES (:date_time, :note)";
        $bindings = [
            ["param" => ":date_time", "value" => $ts, "type" => PDO::PARAM_INT],
            ["param" => ":note", "value" => $note, "type" => PDO::PARAM_STR],
        ];
        $result = $this->pdo->otherBinded($sql, $bindings);

        if (($result["status"] ?? "") === "success") {
            return "<p class=\"text-success\">Note added successfully.</p>";
        }
        $msg = htmlspecialchars((string)($result["message"] ?? "Unknown error"), ENT_QUOTES, "UTF-8");
        return "<p class=\"text-danger\">Could not save note: {$msg}</p>";
    }

    public function getNotes(): string {
        if (($_SERVER["REQUEST_METHOD"] ?? "") !== "POST") {
            return "";
        }

        $begDate = trim((string)($_POST["begDate"] ?? ""));
        $endDate = trim((string)($_POST["endDate"] ?? ""));

        if ($begDate === "" || $endDate === "") {
            return "<p class=\"text-danger\">Please select both a beginning date and an ending date.</p>";
        }

        $begTs = strtotime($begDate . " 00:00:00");
        $endTs = strtotime($endDate . " 23:59:59");
        if ($begTs === false || $endTs === false) {
            return "<p class=\"text-danger\">Invalid date range.</p>";
        }
        if ($begTs > $endTs) {
            return "<p class=\"text-danger\">The beginning date must be on or before the ending date.</p>";
        }

        $sql = "SELECT * FROM notes WHERE date_time BETWEEN :begDate AND :endDate ORDER BY date_time DESC";
        $bindings = [
            ["param" => ":begDate", "value" => $begTs, "type" => PDO::PARAM_INT],
            ["param" => ":endDate", "value" => $endTs, "type" => PDO::PARAM_INT],
        ];
        $rows = $this->pdo->selectBinded($sql, $bindings);

        if (is_string($rows)) {
            return "<p class=\"text-danger\">" . htmlspecialchars($rows, ENT_QUOTES, "UTF-8") . "</p>";
        }
        if (count($rows) === 0) {
            return "<p class=\"text-muted\">No notes found for that date range.</p>";
        }

        $html = "<table class=\"table table-bordered\"><thead><tr><th>Date and Time</th><th>Note</th></tr></thead><tbody>";
        foreach ($rows as $row) {
            $dt = (int)($row["date_time"] ?? 0);
            $formatted = date("m/d/Y h:i a", $dt);
            $text = htmlspecialchars((string)($row["note"] ?? ""), ENT_QUOTES, "UTF-8");
            $html .= "<tr><td>" . htmlspecialchars($formatted, ENT_QUOTES, "UTF-8") . "</td><td>{$text}</td></tr>";
        }
        $html .= "</tbody></table>";
        return $html;
    }
}
