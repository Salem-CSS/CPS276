<?php
require_once 'classes/Directories.php';

$message = '';
$filePath = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $folderName = isset($_POST['folder_name']) ? trim($_POST['folder_name']) : '';
    $fileContent = isset($_POST['file_content']) ? $_POST['file_content'] : '';

    $dir = new Directories();
    $result = $dir->createDirectory($folderName, $fileContent);

    if ($result['success']) {
        $filePath = $result['path'];
    } else {
        $message = $result['message'];
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>File and Directory Assignment</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            max-width: 900px;
            margin: 30px auto;
            padding: 0 20px;
        }
        h1 {
            font-size: 2em;
            margin-bottom: 5px;
        }
        p.subtitle {
            margin-top: 0;
            margin-bottom: 15px;
            color: #333;
        }
        .message {
            color: #333;
            margin-bottom: 10px;
        }
        .success-link a {
            color: #1a0dab;
            text-decoration: none;
        }
        .success-link a:hover {
            text-decoration: underline;
        }
        label {
            display: block;
            margin-bottom: 5px;
            font-size: 0.95em;
        }
        input[type="text"],
        textarea {
            width: 100%;
            padding: 6px 8px;
            margin-bottom: 15px;
            border: 1px solid #ccc;
            border-radius: 3px;
            box-sizing: border-box;
            font-size: 1em;
        }
        textarea {
            height: 150px;
            resize: vertical;
        }
        button[type="submit"] {
            background-color: #337ab7;
            color: white;
            border: none;
            padding: 8px 16px;
            font-size: 1em;
            border-radius: 4px;
            cursor: pointer;
        }
        button[type="submit"]:hover {
            background-color: #286090;
        }
    </style>
</head>
<body>

    <h1>File and Directory Assignment</h1>
    <p class="subtitle">Enter a folder name and the contents of a file. Folder names should contain alpha numeric characters only.</p>

    <?php if (!empty($message)): ?>
        <p class="message"><?php echo htmlspecialchars($message); ?></p>
    <?php endif; ?>

    <?php if (!empty($filePath)): ?>
        <p class="message">File and directory where created</p>
        <p class="success-link"><a href="<?php echo htmlspecialchars($filePath); ?>"><?php echo htmlspecialchars($filePath); ?></a></p>
    <?php endif; ?>

    <form method="post" action="index.php">
        <label for="folder_name">Folder Name</label>
        <input type="text" id="folder_name" name="folder_name">

        <label for="file_content">File Content</label>
        <textarea id="file_content" name="file_content"></textarea>

        <button type="submit">Submit</button>
    </form>

</body>
</html>

