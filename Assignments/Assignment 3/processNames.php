<?php
function addClearNames() {
    $action = $_POST["action"];
    $currentNames = $_POST["namelist"];

    // Clear Names
    if ($action == "clear") {
        return "";
    }

    // Add name
    $nameInput = trim($_POST["nameInput"]);

    // Split First and Last Name
    $parts = explode(" ", $nameInput);
    $firstName = ucfirst(strtolower($parts[0]));
    $lastName = ucfirst(strtolower($parts[1]));

    // Formats Names
    $formattedName = $lastName . ", " . $firstName;

    // Builds Array
    $namesArray = [];
    if (!empty(trim($currentNames))) {
        $namesArray = explode("\n", trim($currentNames));
        
        $namesArray = array_filter($namesArray, function($n) { return trim($n) !== ""; });
        $namesArray = array_values($namesArray);
    }

    // Adds New Name
    array_push($namesArray, $formattedName);

    // Sort Names
    sort($namesArray);

    // Back to String
    $output = implode("\n", $namesArray);

    return $output;
}
?>