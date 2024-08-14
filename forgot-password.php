<?php
// Start session
session_start();

// Check if user is not logged in, redirect to login page
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

// Include your database connection
include 'database/conn.php';

error_reporting(E_ALL);
ini_set('display_errors', 1);

if (isset($_POST['email'])) {
    $email = $_POST['email'];

    // Prepare the query to select user by email
    $stmt = $conn->prepare("SELECT * FROM employees WHERE email = ?");
    if ($stmt === false) {
        die('Prepare failed: ' . $conn->error);
    }

    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        // User exists, create token and reset link
        $token = bin2hex(random_bytes(50));
        $reset_link = "https://yourwebsite.com/reset_password.php?token=" . $token;

        // Prepare the update query to store token and expiration
        $stmt = $conn->prepare("UPDATE employees SET reset_token = ?, token_expire = NOW() + INTERVAL 1 HOUR WHERE email = ?");
        if ($stmt === false) {
            die('Prepare failed: ' . $conn->error);
        }

        $stmt->bind_param("ss", $token, $email);
        $stmt->execute();

        // Send email
        $subject = "Password Reset Request";
        $message = "Click on the following link to reset your password: " . $reset_link;
        $headers = "From: no-reply@yourwebsite.com";

        if (mail($email, $subject, $message, $headers)) {
            echo "Password reset link has been sent to your email.";
        } else {
            echo "Failed to send reset link.";
        }
    } else {
        echo "Email does not exist.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0">
<title>Human Resources Management</title>

<link rel="shortcut icon" href="assets/img/favicon.png">
<link rel="stylesheet" href="assets/css/bootstrap.min.css">
<link rel="stylesheet" href="assets/plugins/fontawesome/css/fontawesome.min.css">
<link rel="stylesheet" href="assets/plugins/fontawesome/css/all.min.css">
<link rel="stylesheet" href="assets/css/style.css">
<!--[if lt IE 9]>
    <script src="assets/js/html5shiv.min.js"></script>
    <script src="assets/js/respond.min.js"></script>
<![endif]-->
</head>
<body>

<div class="main-wrapper login-body">
<div class="login-wrapper">
<div class="container">
<img class="img-fluid logo-dark mb-2" src="assets/img/logo.png" alt="Logo">
<div class="loginbox">
<div class="login-right">
<div class="login-right-wrap">
<h1>Forgot Password?</h1>
<p class="account-subtitle">Enter your email to get a password reset link</p>

<form action="forgot-password.php" method="POST">
    <div class="form-group">
        <label class="form-control-label">Email Address</label>
        <input class="form-control" type="email" name="email" required>
    </div>
    <div class="form-group mb-0">
        <button class="btn btn-lg btn-block btn-primary" type="submit">Reset Password</button>
    </div>
</form>

<div class="text-center dont-have">Remember your password? <a href="login.php">Login</a></div>
</div>
</div>
</div>
</div>
</div>
</div>

<?php
if (isset($_GET['token'])) {
    $token = $_GET['token'];

    // Prepare the query to check the token
    $stmt = $conn->prepare("SELECT * FROM employees WHERE reset_token = ? AND token_expire > NOW()");
    if ($stmt === false) {
        die('Prepare failed: ' . $conn->error);
    }

    $stmt->bind_param("s", $token);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        // Token is valid, allow user to reset their password
        if (isset($_POST['password'])) {
            $new_password = password_hash($_POST['password'], PASSWORD_DEFAULT);

            // Prepare the update query to reset the password
            $stmt = $conn->prepare("UPDATE employees SET password = ?, reset_token = NULL, token_expire = NULL WHERE reset_token = ?");
            if ($stmt === false) {
                die('Prepare failed: ' . $conn->error);
            }

            $stmt->bind_param("ss", $new_password, $token);
            $stmt->execute();

            echo "Password has been reset.";
        }
    } else {
        echo "Invalid or expired token.";
    }
}
?>

<form action="" method="POST">
    <div class="form-group">
        <label class="form-control-label">New Password</label>
        <input class="form-control" type="password" name="password" required>
    </div>
    <div class="form-group mb-0">
        <button class="btn btn-lg btn-block btn-primary" type="submit">Reset Password</button>
    </div>
</form>

<script src="assets/js/jquery-3.6.0.min.js"></script>
<script src="assets/js/popper.min.js"></script>
<script src="assets/js/bootstrap.min.js"></script>
<script src="assets/js/feather.min.js"></script>
<script src="assets/js/script.js"></script>
</body>
</html>
