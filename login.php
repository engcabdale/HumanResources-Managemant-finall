<?php
include 'database/conn.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST['email'];
    $password = $_POST['password'];

    // Prepare and bind
    $stmt = $conn->prepare("SELECT id, password, name FROM register WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $stmt->store_result();

    if ($stmt->num_rows > 0) {
        $stmt->bind_result($id, $hashed_password, $name);
        $stmt->fetch();

        // Verify password
        if (password_verify($password, $hashed_password)) {
            // Start session and set session variables
            session_start();
            $_SESSION['user_id'] = $id;
            $_SESSION['email'] = $email;
            $_SESSION['name'] = $name; // Store the user's name in the session

            // Redirect to dashboard or index page
            header("Location: index.php");
            exit();
        } else {
            echo "Invalid password.";
        }
    } else {
        echo "No account found with that email.";
    }

    // Close statement and connection
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

<link rel="shortcut icon" href="#">
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
<p class="account-subtitle">Human Resources Management</p>
<div class="loginbox">
<div class="login-right">
<div class="login-right-wrap">
<h1>Login</h1>
<p class="account-subtitle">Access to our dashboard</p>
<form action="login.php" method="post">
<div class="form-group">
<label class="form-control-label">Email Address</label>
<input type="email" name="email" class="form-control" required>
</div>
<div class="form-group">
<label class="form-control-label">Password</label>
<div class="pass-group">
<input type="password" name="password" class="form-control pass-input" required>
<span class="fas fa-eye toggle-password"></span>
</div>
</div>
<div class="form-group">
<div class="row">
<div class="col-6">
<div class="custom-control custom-checkbox">
<input type="checkbox" class="custom-control-input" id="cb1">
<label class="custom-control-label" for="cb1">Remember me</label>
</div>
</div>
<div class="col-6 text-right">
<a class="forgot-link" href="forgot-password.php">Forgot Password ?</a>
</div>
</div>
</div>
<button class="btn btn-lg btn-block btn-primary" type="submit">Login</button>
<div class="login-or">
<span class="or-line"></span>
<span class="span-or">or</span>
</div>
<div class="social-login mb-3">
<span>Login with</span>
<a href="#" class="facebook"><i class="fab fa-facebook-f"></i></a>
<a href="#" class="google"><i class="fab fa-google"></i></a>
</div>
<div class="text-center dont-have">Don't have an account yet? <a href="register.php">Register</a></div>
</form>
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
