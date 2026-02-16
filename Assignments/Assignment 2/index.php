<?php

// Even Numbers 1–50 (even only)
$SevenNumbers = "Even Numbers: ";
$numbers = range(1, 50);

foreach ($numbers as $num) {
    if ($num % 2 == 0) {
        $SevenNumbers .= $num . " - ";
    }
}

// Remove last " - "
$SevenNumbers = rtrim($SevenNumbers, " - ");


// Heredoc Form (Bootstrap styled with accessibility)
$form = <<<FORM
<form class="mt-4">
  <div class="mb-3">
    <label for="email" class="form-label">Email address</label>
    <input type="email" class="form-control" id="email" aria-describedby="emailHelp" placeholder="name@example.com">
  </div>

  <div class="mb-3">
    <label for="exampleTextarea" class="form-label">Example textarea</label>
    <textarea class="form-control" id="exampleTextarea" rows="3"></textarea>
  </div>
</form>
FORM;


// Function to create Bootstrap Table
function createTable($rows, $columns) {
    $table = '<table class="table table-bordered mt-4">';
    
    for ($r = 1; $r <= $rows; $r++) {
        $table .= "<tr>";
        
        for ($c = 1; $c <= $columns; $c++) {
            $table .= "<td>Row $r, Col $c</td>";
        }
        
        $table .= "</tr>";
    }
    
    $table .= "</table>";
    
    return $table;
}

/* The assignment specifies that "all PHP written at the top above the HTML Doctype". Explain the implications of this placement on how the server processes the page. What advantage does generating all PHP variables ($evenNumbers, $form, $table) before any HTML output provide in terms of execution flow?
Beyond simply finding even numbers, describe a scenario where you would use a similar foreach loop with a conditional (if) statement to filter or process elements from an array based on different criteria like finding all numbers divisiable by 7
Discuss the primary benefits of using heredoc for embedding large blocks of HTML or other text within PHP strings, especially when that text contains quotes or multiple lines. How does it improve code readability compared to concatenating strings with double quotes?
The createTable function uses nested for loops to build the table. Describe the role of each loop: which one is responsible for iterating through the rows, and which for the columns? How does the concatenation (.=) inside these loops incrementally build the complete HTML table string?
The createTable() function returns a string that is later echoed, rather than echoing directly inside the function. Explain the benefits of this approach. How does returning a value make the function more reusable and flexible compared to having the function echo directly? What are the implications for testing or reusing this function in different contexts?
*/

?>

<!DOCTYPE html>
<html>
<head>
    <title>PHP Assignment</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body class="container mt-4">

<?php
echo $SevenNumbers;
echo $form;
echo createTable(8, 6);
?>

</body>
</html>