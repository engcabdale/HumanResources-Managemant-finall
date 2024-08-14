<?php
include 'database/conn.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get data from the form
    $name = $_POST['name'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $confirm_password = $_POST['confirm_password'];

    // Validate form fields
    if ($password !== $confirm_password) {
        die("Passwords do not match.");
    }

    // Hash the password
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);

    // Prepare and bind
    $stmt = $conn->prepare("INSERT INTO register (name, email, password) VALUES (?, ?, ?)");
    $stmt->bind_param("sss", $name, $email, $hashed_password);

    // Execute the statement
    if ($stmt->execute()) {
        echo "New record created successfully";
        header("Location: login.php");
        exit();
    } else {
        echo "Error: " . $stmt->error;
    }

    // Close the statement and connection
    $stmt->close();
    $conn->close();
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0">
<title>Human Resources Management</title>

<link rel="shortcut icon" href="assets/img/teamwork.png"><link rel="stylesheet" href="assets/css/bootstrap.min.css">
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
<h1>Register</h1>
<p class="account-subtitle">Access to our dashboard</p>
<form action="register.php" method="post">
<div class="form-group">
<label class="form-control-label">Name</label>
<input class="form-control" type="text" name="name">
</div>
<div class="form-group">
<label class="form-control-label">Email Address</label>
<input class="form-control" type="email" name="email">
</div>
<div class="form-group">
<label class="form-control-label">Password</label>
<input class="form-control" type="password" name="password">
</div>
<div class="form-group">
<label class="form-control-label">Confirm Password</label>
<input class="form-control" type="password" name="confirm_password">
</div>
<div class="form-group mb-0">
<button class="btn btn-lg btn-block btn-primary" type="submit">Register</button>
</div>
</form>
<div class="login-or">
<span class="or-line"></span>
<span class="span-or">or</span>
</div>
<div class="social-login">
<span>Register with</span>
<a href="#" class="facebook"><i class="fab fa-facebook-f"></i></a>
<a href="#" class="google"><i class="fab fa-google"></i></a>
</div>
<div class="text-center dont-have">Already have an account? <a href="login.php">Login</a></div>
</div>
</div>
</div>
</div>
</div>
</div>
<script src="assets/js/jquery-3.5.1.min.js"></script>
<script src="assets/js/popper.min.js"></script>
<script src="assets/js/bootstrap.min.js"></script>
<script src="assets/js/feather.min.js"></script>
<script src="assets/js/script.js"></script>
</body>
</html>
