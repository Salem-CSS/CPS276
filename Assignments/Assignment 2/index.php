<?php

// 1️⃣ Even Numbers 1–50 (even only)
$SevenNumbers = "Even Numbers: ";
$numbers = range(1, 50);

foreach ($numbers as $num) {
    if ($num % 2 == 0) {
        $SevenNumbers .= $num . " - ";
    }
}

// Remove last " - "
$SevenNumbers = rtrim($SevenNumbers, " - ");


// 2️⃣ Heredoc Form (Bootstrap styled with accessibility)
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


// 3️⃣ Function to create Bootstrap Table
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
