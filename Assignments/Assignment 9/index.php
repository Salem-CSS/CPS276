<?php
require_once 'classes/Pdo_methods.php';
require_once 'classes/StickyForm.php';
require_once 'classes/Validation.php';

$pdo = new Pdo_methods();
$sticky = new StickyForm();
$validate = new Validation();

$errors = [];
$successMessage = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $firstName = trim($_POST['firstName'] ?? '');
    $lastName = trim($_POST['lastName'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $password = $_POST['password'] ?? '';
    $confirmPassword = $_POST['confirmPassword'] ?? '';

    // Validate first name
    if (empty($firstName) || !$validate->validateName($firstName)) {
        $errors['firstName'] = 'You must enter a first name and it must be alpha characters only.';
    }

    // Validate last name
    if (empty($lastName) || !$validate->validateName($lastName)) {
        $errors['lastName'] = 'You must enter a last name and it must be alpha characters only.';
    }

    // Validate email
    if (empty($email) || !$validate->validateEmail($email)) {
        $errors['email'] = 'You must enter a email address and it must be in the format of example@example.com.';
    }

    // Validate password
    if (empty($password) || !$validate->validatePassword($password)) {
        $errors['password'] = 'Must have at least (8 characters, 1 uppercase, 1 symbol, 1 number)';
    }

    // Validate confirm password
    if (empty($confirmPassword) || !$validate->validatePassword($confirmPassword)) {
        $errors['confirmPassword'] = 'Must have at least (8 characters, 1 uppercase, 1 symbol, 1 number)';
    }

    // Check if passwords match (only if both passed validation)
    if (empty($errors['password']) && empty($errors['confirmPassword'])) {
        if ($password !== $confirmPassword) {
            $errors['confirmPassword'] = 'Your passwords do not match';
        }
    }

    // If no errors so far, check for duplicate email
    if (empty($errors)) {
        $existingRecords = $pdo->selectWhere('users', 'email', $email);
        if (count($existingRecords) > 0) {
            $errors['duplicate'] = 'There is already a record with that email';
        }
    }

    // If still no errors, insert the record
    if (empty($errors)) {
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
        $pdo->insertRecord(
            'users',
            ['first_name', 'last_name', 'email', 'password'],
            [$firstName, $lastName, $email, $hashedPassword]
        );
        $successMessage = 'You have been added to the database';
        $sticky->clearFields();
    }
}

// Get all records to display
$records = $pdo->selectAll('users');
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Registration Form</title>
    <style>
        * {
            box-sizing: border-box;
        }
        body {
            font-family: Arial, Helvetica, sans-serif;
            background-color: #fff;
            color: #000;
            margin: 0;
            padding: 24px 16px 40px;
            line-height: 1.4;
        }
        .page-shell {
            max-width: 960px;
            margin: 0 auto;
        }
        .card {
            border-radius: 5px;
            overflow: hidden;
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.08);
        }
        .card-header {
            background-color: #e6c200;
            color: #000;
            padding: 10px 14px;
            font-size: 14px;
            display: flex;
            align-items: center;
            gap: 8px;
        }
        .card-header .caret {
            font-size: 9px;
            line-height: 1;
            margin-top: 2px;
        }
        .form-container {
            background-color: #fff;
            padding: 20px 22px 24px;
        }
        .required-msg,
        .success-msg,
        .duplicate-msg {
            margin: 0 0 10px;
            font-size: 14px;
            color: #000;
        }
        .duplicate-msg {
            margin-top: 0;
        }
        .form-row {
            display: flex;
            gap: 16px;
            margin-bottom: 0;
        }
        .form-row-three {
            display: flex;
            gap: 16px;
            margin-bottom: 0;
        }
        .form-group {
            flex: 1;
            min-width: 0;
            margin-bottom: 14px;
        }
        .form-group label {
            display: block;
            font-weight: normal;
            font-size: 13px;
            margin-bottom: 4px;
            color: #000;
        }
        .form-group input {
            width: 100%;
            padding: 8px 10px;
            border: 1px solid #ccc;
            border-radius: 4px;
            background-color: #fff;
            font-size: 14px;
            font-family: inherit;
        }
        .form-group input:focus {
            outline: none;
            border-color: #999;
        }
        .error-message {
            color: #dc3545;
            font-size: 12px;
            margin: 4px 0 0;
            line-height: 1.35;
        }
        .btn-register {
            background-color: #007bff;
            color: #fff;
            padding: 8px 22px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            font-size: 14px;
            font-family: inherit;
            margin-top: 6px;
        }
        .btn-register:hover {
            background-color: #0069d9;
        }
        .records-area {
            margin-top: 18px;
            padding-top: 4px;
        }
        .records-empty {
            margin: 14px 0 0;
            font-size: 14px;
            color: #000;
        }
        .data-table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 14px;
            font-size: 14px;
        }
        .data-table th,
        .data-table td {
            text-align: left;
            padding: 10px 8px 10px 0;
            border: none;
            border-bottom: 1px solid #ddd;
            vertical-align: top;
        }
        .data-table thead th {
            font-weight: bold;
            border-bottom: 1px solid #ccc;
            padding-top: 4px;
        }
        .data-table tbody tr:last-child td {
            border-bottom: 1px solid #ddd;
        }
        @media (max-width: 720px) {
            .form-row,
            .form-row-three {
                flex-direction: column;
                gap: 0;
            }
        }
    </style>
</head>
<body>
    <div class="page-shell">
        <div class="card">
            <div class="card-header">
                <span class="caret" aria-hidden="true">▼</span>
                <span>User registration</span>
            </div>
            <div class="form-container">
            <?php if (!empty($successMessage)): ?>
                <p class="success-msg"><?php echo htmlspecialchars($successMessage); ?></p>
            <?php else: ?>
                <p class="required-msg">All fields are required.</p>
            <?php endif; ?>

            <?php if (!empty($errors['duplicate'])): ?>
                <p class="duplicate-msg"><?php echo htmlspecialchars($errors['duplicate']); ?></p>
            <?php endif; ?>

            <form method="POST" action="">
                <div class="form-row">
                    <div class="form-group">
                        <label>*First Name</label>
                        <input type="text" name="firstName" value="<?php echo $sticky->stickyText('firstName'); ?>">
                        <?php if (!empty($errors['firstName'])): ?>
                            <p class="error-message"><?php echo $errors['firstName']; ?></p>
                        <?php endif; ?>
                    </div>
                    <div class="form-group">
                        <label>*Last Name</label>
                        <input type="text" name="lastName" value="<?php echo $sticky->stickyText('lastName'); ?>">
                        <?php if (!empty($errors['lastName'])): ?>
                            <p class="error-message"><?php echo $errors['lastName']; ?></p>
                        <?php endif; ?>
                    </div>
                </div>

                <div class="form-row-three">
                    <div class="form-group">
                        <label>*Email</label>
                        <input type="text" name="email" value="<?php echo $sticky->stickyText('email'); ?>">
                        <?php if (!empty($errors['email'])): ?>
                            <p class="error-message"><?php echo $errors['email']; ?></p>
                        <?php endif; ?>
                    </div>
                    <div class="form-group">
                        <label>*Password</label>
                        <input type="password" name="password" value="<?php echo $sticky->stickyText('password'); ?>">
                        <?php if (!empty($errors['password'])): ?>
                            <p class="error-message"><?php echo $errors['password']; ?></p>
                        <?php endif; ?>
                    </div>
                    <div class="form-group">
                        <label>*Confirm Password</label>
                        <input type="password" name="confirmPassword" value="<?php echo $sticky->stickyText('confirmPassword'); ?>">
                        <?php if (!empty($errors['confirmPassword'])): ?>
                            <p class="error-message"><?php echo $errors['confirmPassword']; ?></p>
                        <?php endif; ?>
                    </div>
                </div>

                <button type="submit" class="btn-register">Register</button>
            </form>

            <div class="records-area">
            <?php if (count($records) > 0): ?>
                <table class="data-table">
                    <thead>
                        <tr>
                            <th>First Name</th>
                            <th>Last Name</th>
                            <th>Email</th>
                            <th>Password</th>
                        </tr>
                    </thead>
                    <tbody>
                    <?php foreach ($records as $record): ?>
                        <tr>
                            <td><?php echo htmlspecialchars($record['first_name']); ?></td>
                            <td><?php echo htmlspecialchars($record['last_name']); ?></td>
                            <td><?php echo htmlspecialchars($record['email']); ?></td>
                            <td><?php echo htmlspecialchars($record['password']); ?></td>
                        </tr>
                    <?php endforeach; ?>
                    </tbody>
                </table>
            <?php else: ?>
                <p class="records-empty">No records to display.</p>
            <?php endif; ?>
            </div>
            </div>
        </div>
    </div>
</body>
</html>
