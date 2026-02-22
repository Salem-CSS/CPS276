<?php
$output = "";

if($_SERVER["REQUEST_METHOD"] == "POST"){
    require_once 'processNames.php';
    $output = addClearNames();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Names</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
</head>
<body>
<div class="container mt-4">
    <h1>Add Names</h1>
    <form method="post" action="index.php">
        <button type="submit" name="action" value="add" class="btn btn-primary">Add Name</button>
        <button type="submit" name="action" value="clear" class="btn btn-primary">Clear Names</button>

        <div class="mt-2">
            <label for="nameInput">Enter Name</label><br>
            <input type="text" class="form-control" id="nameInput" name="nameInput">
        </div>

        <div class="mt-2">
            <label for="namelist">List of Names</label><br>
            <textarea style="height: 500px;" class="form-control"
                id="namelist" name="namelist"><?php echo $output ?></textarea>
        </div>
    </form>
</div>
</body>
</html>

<!--  What is the purpose of separating the functionality between index.php and processNames.php in this assignment?
How does the $_SERVER["REQUEST_METHOD"] variable help determine when to process form submissions in PHP?
How does PHP handle string-to-array conversion using the explode function, and why is this useful in this application?
What role does the implode function play in formatting the output for the textarea?
How does processNames.php determine whether to add a new name or clear all names based on which button was clicked? -->