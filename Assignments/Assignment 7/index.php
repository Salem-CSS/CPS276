<?php
declare(strict_types=1);
require_once "php/fileUploadProc.php";
?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>Upload PDF</title>
</head>
<body>

    <h1>Upload PDF</h1>

    <form method="post" enctype="multipart/form-data" action="">
        <label>
            File Name:
            <input type="text" name="file_name" required>
        </label>
        <br><br>

        <label>
            Choose PDF:
            <input type="file" name="pdf_file" accept="application/pdf" required>
        </label>
        <br><br>

        <button type="submit">Upload</button>
    </form>

    <p><a href="listFiles.php">Show File List</a></p>

    <hr>

    <?php echo $output; ?>

</body>
</html>
