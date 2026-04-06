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
    <title>Add Note</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="p-4">
    <h1>Add Note</h1>
    <p><a href="display_notes.php">Display Notes</a></p>

    <?php echo $date_time->addNote(); ?>

    <form method="post" action="">
        <div class="mb-3">
            <label class="form-label" for="dateTime">Date and Time</label>
            <input type="datetime-local" class="form-control" id="dateTime" name="dateTime">
        </div>
        <div class="mb-3">
            <label class="form-label" for="note">Note</label>
            <textarea class="form-control" id="note" name="note" rows="6"></textarea>
        </div>
        <button type="submit" class="btn btn-primary">Add Note</button>
    </form>

    <!--Why are we using timestamps instead of the date.
//Is there any advantage to using the Date_time class over just having a PHP function file.  What are they?
//When a user requests to view notes within a specific date range, what logical steps must the application take to retrieve and present only the relevant notes, show that in your code and explain it?
//Explain the importance of converting dates and times into a standardized format (like a timestamp) before storing them in a database. What problems might arise if you don't?
//Imagine the application becomes very popular and has millions of notes. What performance considerations might arise when displaying notes, and how could you address them? -->
</body>
</html>


