<?php
declare(strict_types=1);
require_once __DIR__ . "/classes/Date_time.php";
$date_time = new Date_time();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Display Notes</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="p-4">
    <h1>Display Notes</h1>
    <p><a href="index.php">Add Note</a></p>

    <form method="post" action="">
        <div class="mb-3">
            <label class="form-label" for="begDate">Beginning Date</label>
            <input type="date" class="form-control" id="begDate" name="begDate">
        </div>
        <div class="mb-3">
            <label class="form-label" for="endDate">Ending Date</label>
            <input type="date" class="form-control" id="endDate" name="endDate">
        </div>
        <button type="submit" class="btn btn-primary">Get Notes</button>
    </form>

    <div class="mt-4">
        <?php echo $date_time->getNotes(); ?>
    </div>
</body>
</html>
