<?php
declare(strict_types=1);
require_once "php/listFilesProc.php";
?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>File List</title>
</head>
<body>

    <h1>Uploaded PDFs</h1>

    <p><a href="index.php">Back to Upload</a></p>

    <hr>

    <?php echo $output; ?>

</body>
</html>
