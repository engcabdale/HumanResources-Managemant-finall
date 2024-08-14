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

<link rel="stylesheet" href="assets/plugins/select2/css/select2.min.css">

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
<img src="assets/img/logo.png" alt="Logo">
</a>
<a href="index.php" class="logo logo-small">
<img src="assets/img/logo-small.png" alt="Logo" width="30" height="30">
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
<div class="dropdown-menu notifications">
<div class="topnav-dropdown-header">
<span class="notification-title">Notifications</span>
<a href="javascript:void(0)" class="clear-noti"> Clear All</a>
</div>
<div class="noti-content">
<ul class="notification-list">
<li class="notification-message">
<a href="activities.php">
<div class="media">
<span class="avatar avatar-sm">
<img class="avatar-img rounded-circle" alt="" src="assets/img/profiles/avatar-02.jpg">
</span>
<div class="media-body">
<p class="noti-details"><span class="noti-title">Brian Johnson</span> paid the invoice <span class="noti-title">#DF65485</span></p>
<p class="noti-time"><span class="notification-time">4 mins ago</span></p>
</div>
</div>
</a>
</li>
<li class="notification-message">
<a href="activities.php">
<div class="media">
<span class="avatar avatar-sm">
<img class="avatar-img rounded-circle" alt="" src="assets/img/profiles/avatar-03.jpg">
</span>
<div class="media-body">
<p class="noti-details"><span class="noti-title">Marie Canales</span> has accepted your estimate <span class="noti-title">#GTR458789</span></p>
<p class="noti-time"><span class="notification-time">6 mins ago</span></p>
</div>
</div>
</a>
</li>
<li class="notification-message">
<a href="activities.php">
<div class="media">
<div class="avatar avatar-sm">
 <span class="avatar-title rounded-circle bg-primary-light"><i class="far fa-user"></i></span>
</div>
<div class="media-body">
<p class="noti-details"><span class="noti-title">New user registered</span></p>
<p class="noti-time"><span class="notification-time">8 mins ago</span></p>
</div>
</div>
</a>
</li>
<li class="notification-message">
<a href="activities.php">
<div class="media">
<span class="avatar avatar-sm">
<img class="avatar-img rounded-circle" alt="" src="assets/img/profiles/avatar-04.jpg">
</span>
<div class="media-body">
<p class="noti-details"><span class="noti-title">Barbara Moore</span> declined the invoice <span class="noti-title">#RDW026896</span></p>
<p class="noti-time"><span class="notification-time">12 mins ago</span></p>
</div>
</div>
</a>
</li>
<li class="notification-message">
<a href="activities.php">
<div class="media">
<div class="avatar avatar-sm">
<span class="avatar-title rounded-circle bg-info-light"><i class="far fa-comment"></i></span>
</div>
<div class="media-body">
<p class="noti-details"><span class="noti-title">You have received a new message</span></p>
<p class="noti-time"><span class="notification-time">2 days ago</span></p>
</div>
</div>
</a>
</li>
</ul>
</div>
<div class="topnav-dropdown-footer">
<a href="activities.php">View all Notifications</a>
</div>
</div>
</li>


<li class="nav-item dropdown has-arrow main-drop">
<a href="#" class="dropdown-toggle nav-link" data-toggle="dropdown">
<span class="user-img">
<img src="assets/img/profile.jpg" alt="">
<span class="status online"></span>
</span>
<span>Kavin Hansen</span>
</a>
<div class="dropdown-menu">
<a class="dropdown-item" href="profile.php"><i data-feather="user" class="mr-1"></i> Profile</a>
<a class="dropdown-item" href="settings.php"><i data-feather="settings" class="mr-1"></i> Settings</a>
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
<li>
<a href="index.php"><img src="assets/img/home.svg" alt="sidebar_img"> <span>Dashboard</span></a>
</li>
<li class="active">
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
<a href="profile.php"><img src="assets/img/profile.svg" alt="sidebar_img"> <span>Profile</span></a>
</li> -->
</ul>
<ul class="logout">
<li>
<a href="profile.php"><img src="assets/img/logout.svg" alt="sidebar_img"><span>Log out</span></a>
</li>
</ul>
</div>
</div>
</div>
</div>


<div class="page-wrapper">
<div class="content container-fluid">
<class="row">
<div class="col-xl-12 col-sm-12 col-12">
<div class="breadcrumb-path mb-4">
<ul class="breadcrumb">
<li class="breadcrumb-item"><a href="index.php"><img src="assets/img/dash.png" class="mr-2" alt="breadcrumb" />Home</a>
</li>
<li class="breadcrumb-item"><a href="employee.php">Employee</a>
</li>
<li class="breadcrumb-item active">View Employees</li>
</ul>
<h3>View Employees</h3>
</div>
</div>
<div class="col-xl-12 col-sm-12 col-12 mb-4">
<div class="head-link-set">
<ul>

</ul>
</div>
</div>

<div class="col-xl-12 col-sm-12 col-12 mb-4">
<div class="card bg bg-success">
<div class="table-heading ">
<h2>Employees Details</h2>
</div>
					<div class="col-md-12">
						<div class="card">
							<div class="card-header">
							</div>
							<div class="card-body">
<?php
// Include the configuration file
include 'database/conn.php';

// Fetch employee data
$employee_id = $_GET['id']; // Assuming employee ID is passed as a query parameter
$sql = "SELECT * FROM employees WHERE id = $employee_id";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    // Display employee data
    while ($row = $result->fetch_assoc()) {
        echo "<p>Employee ID: " . $row["id"] . "</p>";
        echo "<p>First Name: " . $row["firstname"] . "</p>";
        echo "<p>Last Name: " . $row["lastname"] . "</p>";
        echo "<p>Email: " . $row["email"] . "</p>";
        echo "<p>Country: " . $row["country"] . "</p>";
        echo "<p>Employment Start Date: " . $row["employment_startdate"] . "</p>"; // Fixed column name
        echo "<p>Job Title: " . $row["job_title"] . "</p>";
        echo "<p>Employment Type: " . $row["employment_type"] . "</p>";
        echo "<p>Currency: " . $row["currency"] . "</p>";
        echo "<p>Frequency: " . $row["frequency"] . "</p>";
        echo "<p>Salary Start Date: " . $row["salary_startdate"] . "</p>"; // Fixed column name
    }
} else {
    echo "<p>No results found</p>";
}
$conn->close();
?>

							</div>
						</div>
					</div>
				</div>
			</div>

</div>
				</div>
</div>
</div>

</div>


<script src="assets/js/jquery-3.6.0.min.js"></script>

<script src="assets/js/popper.min.js"></script>
<script src="assets/js/bootstrap.min.js"></script>

<script src="assets/js/feather.min.js"></script>

<script src="assets/plugins/slimscroll/jquery.slimscroll.min.js"></script>

<script src="assets/plugins/select2/js/select2.min.js"></script>

<script src="assets/js/script.js"></script>
</body>
</html>