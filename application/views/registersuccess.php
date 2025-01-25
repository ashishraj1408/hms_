<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registration Successful</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css"> <!-- Bootstrap CSS -->
</head>
<body>
    <div class="container mt-5">
        <div class="text-center">
            <h1>Registration Successful</h1> <!-- Registration success message -->
            <p>You have registered successfully. Please proceed to login.</p> <!-- Prompt to log in -->
            <a href="<?= base_url('login'); ?>" class="btn btn-primary">Go to Login</a> <!-- Redirect to login -->
        </div>
    </div>
</body>
</html>
