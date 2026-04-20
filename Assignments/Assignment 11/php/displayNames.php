<?php
require_once '../classes/Pdo_methods.php';

header('Content-Type: application/json');

$pdo = new PdoMethods();
$sql = "SELECT name FROM names ORDER BY name ASC";
$result = $pdo->selectNotBinded($sql);

if ($result === 'error') {
    echo json_encode(['masterstatus' => 'error', 'msg' => 'Database error — could not retrieve names']);
} elseif (empty($result)) {
    echo json_encode(['masterstatus' => 'noerror', 'names' => '<p style="color: orange;">No names to display</p>']);
} else {
    $html = '';
    foreach ($result as $row) {
        $html .= '<p>' . htmlspecialchars($row['name']) . '</p>';
    }
    echo json_encode(['masterstatus' => 'noerror', 'names' => $html]);
}
