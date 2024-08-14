<?php
// Start session
session_start();

// Check if user is not logged in, redirect to login page
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

// Include your database connection and other necessary files
include 'database/conn.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0">
<title>Human Resources Management</title>

<link rel="shortcut icon" href="assets/img/teamwork.png">

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

<div class="main-wrapper">

<div class="header">

<div class="header-left">
<a href="index.php" class="logo">
<p class="account-subtitle">HRM</p>
</a>
<a href="index.php" class="logo logo-small">
<!-- <img src="assets/img/logo-small.png" alt="Logo" width="30" height="30"> -->
</a>
<a href="javascript:void(0);" id="toggle_btn">
<span class="bar-icon">
<span></span>
<span></span>
<span></span>
</span>
</a>
</div>




<div class="top-nav-search">
<form>
<input type="text" class="form-control" placeholder="">
<button class="btn" type="submit"><i class="fas fa-search"></i></button>
</form>
</div>


<a class="mobile_btn" id="mobile_btn">
<i class="fas fa-bars"></i>
</a>


<ul class="nav user-menu">

<li class="nav-item dropdown">
<a href="#" class="dropdown-toggle nav-link pr-0" data-toggle="dropdown">
<i data-feather="bell"></i> <span class="badge badge-pill"></span>
</a>

</li>


<li class="nav-item dropdown has-arrow main-drop">
<a href="#" class="dropdown-toggle nav-link" data-toggle="dropdown">
<span class="user-img">
<img src="assets\img\profiles/min.png" alt="" height="50">
<span class="status online"></span>
</span>
<span><?php echo "$_SESSION[name]" ?></span>
</a>
<div class="dropdown-menu">
<!-- <a class="dropdown-item" href="profile.php"><i data-feather="user" class="mr-1"></i> Profile</a> -->
<!-- <a class="dropdown-item" href="settings.php"><i data-feather="settings" class="mr-1"></i> Settings</a> -->
<a class="dropdown-item" href="login.php"><i data-feather="log-out" class="mr-1"></i> Logout</a>
</div>
</li>

</ul>
<div class="dropdown mobile-user-menu show">
<a href="#" class="nav-link dropdown-toggle" data-toggle="dropdown" aria-expanded="false"><i class="fa fa-ellipsis-v"></i></a>
<div class="dropdown-menu dropdown-menu-right ">
<a class="dropdown-item" href="profile.php">My Profile</a>
<a class="dropdown-item" href="settings.php">Settings</a>
<a class="dropdown-item" href="login.php">Logout</a>
</div>
</div>

</div>


<div class="sidebar" id="sidebar">
<div class="sidebar-inner slimscroll">
<div class="sidebar-contents">
<div id="sidebar-menu" class="sidebar-menu">
<div class="mobile-show">
<div class="offcanvas-menu">
<div class="user-info align-center bg-theme text-center">
<span class="lnr lnr-cross  text-white" id="mobile_btn_close">X</span>
<a href="javascript:void(0)" class="d-block menu-style text-white">
<div class="user-avatar d-inline-block mr-3">
<img src="assets/img/profiles/avatar-18.jpg" alt="user avatar" class="rounded-circle" width="50">
</div>
</a>
</div>
</div>
<div class="sidebar-input">
<div class="top-nav-search">
<form>
<input type="text" class="form-control" placeholder="Search here">
<button class="btn" type="submit"><i class="fas fa-search"></i></button>
</form>
</div>
</div>
 </div>
<ul>
<li class="active">
<a href="index.php"><img src="assets/img/home.svg" alt="sidebar_img"> <span>Dashboard</span></a>
</li>
<li>
<a href="employee.php"><img src="assets/img/employee.svg" alt="sidebar_img"><span> Employees</span></a>
</li>
<li>
<a href="attendance.php"><img src="assets/img/company.svg" alt="sidebar_img"> <span> Attendance</span></a>
</li>
<li>
<a href="department.php"><img src="assets/img/calendar.svg" alt="sidebar_img"> <span>Department</span></a>
</li>
<li>
<a href="schedule.php"><img src="assets/img/leave.svg" alt="sidebar_img"> <span>Schedule</span></a>
</li>

<li>
<a href="report.php"><img src="assets/img/report.svg" alt="sidebar_img"><span>Report</span></a>
</li>

<li class="nav-item">
  <a href="backupRecovery.php" class="nav-link nav-backup-recovery">
    <i class="nav-icon fas fa-sync-alt"></i> <!-- Use this icon or replace it with the custom SVG -->
    <p>Backup Recovery</p>
  </a>
</li>

<!-- <li>
<a href="Note.php"><img src="assets/img/profile.svg" alt="sidebar_img"> <span>Profile</span></a>
</li>
</ul>
<ul class="logout"> -->

</ul>
</div>
</div>
</div>
</div>


<div class="page-wrapper">
<div class="content container-fluid">
<div class="page-name 	mb-4">
<h4 class="m-0"><img src="assets\img\profiles/Aarka.png" height="50"="mr-1" alt="profile" /> Welcome <?php echo "$_SESSION[name]" ?></h4>
<label>Eng cabdale ismail</label>
</div>
<div class="row mb-4">
<div class="col-xl-6 col-sm-12 col-12">
<div class="breadcrumb-path ">
<ul class="breadcrumb">
<li class="breadcrumb-item"><a href="index.php"><img src="assets/img/dash.png" class="mr-3" alt="breadcrumb" />Home</a>
</li>
<li class="breadcrumb-item active">Dashboard</li>
</ul>
<h3>Admin Dashboard</h3>
</div>
</div>
<div class="col-xl-6 col-sm-12 col-12">
<div class="row">
<div class="col-xl-6 col-sm-6 col-12">
<a class="btn-dash" href="#"> Admin Dashboard</a>
</div>
<div class="col-xl-6 col-sm-6 col-12">
<a class="btn-emp" href="">Welcome</a>
</div>
</div>
</div>
</div>
<div class="row mb-4">
<div class="col-xl-3 col-sm-6 col-12">
<div class="card board1 fill1 ">
<div class="card-body">
<div class="card_widget_header">
<label>Employees</label>

</div>
<div class="card_widget_img">
<img src="assets/img/dash1.png" alt="card-img" />
</div>
</div>
</div>
</div>
<div class="col-xl-3 col-sm-6 col-12">
<div class="card board1 fill2 ">
<div class="card-body">
<div class="card_widget_header">
<label>Attendance</label>

</div>
<div class="card_widget_img">
<img src="assets/img/dash2.png" alt="card-img" />
</div>
</div>
</div>
</div>
<div class="col-xl-3 col-sm-6 col-12">
<div class="card board1 fill3 ">
<div class="card-body">
<div class="card_widget_header">
<label>Department	</label>

</div>
<div class="card_widget_img">
<img src="assets/img/dash3.png" alt="card-img" />
</div>
</div>
</div>
</div>
<div class="col-xl-6 col-sm-12 col-12">
<div class="row">


</div>
</div>
</div>
<div class="row mb-4">
<div class="col-xl-3 col-sm-6 col-12">
<div class="card board1 fill1 ">
<div class="card-body">
<div class="card_widget_header">
<label>schedule</label>

</div>
<div class="card_widget_img">
<img src="assets/img/dash1.png" alt="card-img" />
</div>
</div>
</div>
</div>
<div class="col-xl-3 col-sm-6 col-12">
<div class="card board1 fill2 ">
<div class="card-body">
<div class="card_widget_header">
<label>report</label>

</div>
<div class="card_widget_img">
<img src="assets/img/dash2.png" alt="card-img" />
</div>
</div>
</div>
</div>
<div class="col-xl-3 col-sm-6 col-12">
<div class="card board1 fill3 ">
<div class="card-body">
<div class="card_widget_header">
<label>backupRecovery	</label>

</div>
<div class="card_widget_img">
<img src="assets/img/dash3.png" alt="card-img" />
</div>
</div>
</div>
</div>


</div>
</div>

</div>
</div>
</body>


<script src="assets/js/jquery-3.6.0.min.js"></script>

<script src="assets/js/popper.min.js"></script>
<script src="assets/js/bootstrap.min.js"></script>

<script src="assets/js/feather.min.js"></script>

<script src="assets/plugins/slimscroll/jquery.slimscroll.min.js"></script>

<script src="assets/plugins/apexchart/apexcharts.min.js"></script>
<script src="assets/plugins/apexchart/chart-data.js"></script>

<script src="assets/js/script.js"></script>
</body>
</html>