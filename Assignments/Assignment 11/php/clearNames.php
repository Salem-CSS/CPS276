<?php
require_once '../classes/Pdo_methods.php';

header('Content-Type: application/json');

$pdo = new PdoMethods();
$sql = "DELETE FROM names";
$result = $pdo->otherNotBinded($sql);

if ($result === 'error') {
    echo json_encode(['masterstatus' => 'error', 'msg' => 'Database error — names were not cleared']);
} else {
    echo json_encode(['masterstatus' => 'noerror', 'msg' => 'All names have been cleared']);
}
