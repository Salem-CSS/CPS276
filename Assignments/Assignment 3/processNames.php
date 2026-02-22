<?php
function addClearNames() {
    $action = $_POST["action"];
    $currentNames = $_POST["namelist"];

    // If clear button clicked, return empty string
    if ($action == "clear") {
        return "";
    }

    // Add name action
    $nameInput = trim($_POST["nameInput"]);

    // Split input into first and last name
    $parts = explode(" ", $nameInput);
    $firstName = ucfirst(strtolower($parts[0]));
    $lastName = ucfirst(strtolower($parts[1]));

    // Format as "Lastname, Firstname"
    $formattedName = $lastName . ", " . $firstName;

    // Build array of existing names
    $namesArray = [];
    if (!empty(trim($currentNames))) {
        $namesArray = explode("\n", trim($currentNames));
        // Clean up any empty entries
        $namesArray = array_filter($namesArray, function($n) { return trim($n) !== ""; });
        $namesArray = array_values($namesArray);
    }

    // Add new name
    array_push($namesArray, $formattedName);

    // Sort alphabetically
    sort($namesArray);

    // Join back to string
    $output = implode("\n", $namesArray);

    return $output;
}
?>