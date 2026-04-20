<?php
require_once '../classes/Pdo_methods.php';

header('Content-Type: application/json');

$input = json_decode(file_get_contents('php://input'), true);
$name = trim($input['name'] ?? '');

$parts = explode(' ', $name, 2);
if (count($parts) < 2 || trim($parts[1]) === '') {
    echo json_encode(['masterstatus' => 'error', 'msg' => 'Please enter both a first and last name separated by a space']);
    exit;
}

$firstName = trim($parts[0]);
$lastName  = trim($parts[1]);
$formatted = $lastName . ', ' . $firstName;

$pdo = new PdoMethods();
$sql = "INSERT INTO names (name) VALUES (:name)";
$bindings = [[':name', $formatted, 'str']];
$result = $pdo->otherBinded($sql, $bindings);

if ($result === 'error') {
    echo json_encode(['masterstatus' => 'error', 'msg' => 'Database error — name was not added']);
} else {
    echo json_encode(['masterstatus' => 'noerror', 'msg' => htmlspecialchars($formatted) . ' has been added']);
}
