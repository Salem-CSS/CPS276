<?php
declare(strict_types=1);
require_once __DIR__ . "/../classes/Pdo_methods.php";

$output = "";

try {
    $pdo = new Pdo_methods();
} catch (PDOException $e) {
    $output = "<p style='color:red;'>Unable to connect to the database. Check <code>classes/Db_conn.php</code> and that the <code>uploaded_pdfs</code> table exists (see <code>sql/create_uploaded_pdfs.sql</code>).</p>";
    return;
}

$sql = "SELECT id, file_name, file_path FROM uploaded_pdfs ORDER BY id DESC";
$rows = $pdo->selectNotBinded($sql);

if (is_string($rows)) {
    $output = "<p style='color:red;'>" . htmlspecialchars($rows, ENT_QUOTES, "UTF-8") . "</p>";
} elseif (empty($rows)) {
    $output = "<p>No files found.</p>";
} else {
    $output .= "<ul>";
    foreach ($rows as $r) {
        $name = htmlspecialchars((string)$r["file_name"], ENT_QUOTES, "UTF-8");
        $path = htmlspecialchars((string)$r["file_path"], ENT_QUOTES, "UTF-8");
        $output .= "<li><a target=\"_blank\" href=\"/{$path}\">{$name}</a></li>";
    }
    $output .= "</ul>";
}