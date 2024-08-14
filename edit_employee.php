<?php
// Include your database connection file
include_once 'database/conn.php';

// Start session
session_start();

// Check if user is not logged in, redirect to login page
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}



// Initialize variables to store employee data
$employee_id = $firstname = $lastname = $email = $country = $employment_startdate = $job_title = $employment_type = $currency = $frequency = $salary_startdate = $photo = '';

// Check if employee_id is passed in the URL
if (isset($_GET['id'])) {
    $employee_id = $_GET['id'];

    // SQL query to fetch employee details
    $sql = "SELECT * FROM employees WHERE id = $employee_id";
    $result = mysqli_query($conn, $sql);

    if (mysqli_num_rows($result) > 0) {
        // Fetch the employee data
        $employee = mysqli_fetch_assoc($result);
        $firstname = $employee['firstname'];
        $lastname = $employee['lastname'];
        $email = $employee['email'];
        $country = $employee['country'];
        $employment_startdate = isset($employee['employment_startdate']) ? $employee['employment_startdate'] : '';
        $job_title = $employee['job_title'];
        $employment_type = $employee['employment_type'];
        $currency = $employee['currency'];
        $frequency = $employee['frequency'];
        $salary_startdate = isset($employee['salary_startdate']) ? $employee['salary_startdate'] : '';
        $photo = $employee['photo'];
    } else {
        echo "Employee not found.";
    }
}

// Check if form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve form data
    $employee_id = $_POST['employee_id'];
    $firstname = $_POST['firstname'];
    $lastname = $_POST['lastname'];
    $email = $_POST['email'];
    $country = $_POST['country'];
    $employment_startdate = $_POST['employment_startdate'];
    $job_title = $_POST['job_title'];
    $employment_type = $_POST['employment_type'];
    $currency = $_POST['currency'];
    $frequency = $_POST['frequency'];
    $salary_startdate = $_POST['salary_startdate'];

    // Handle file upload
    if (isset($_FILES['photo']) && $_FILES['photo']['error'] == 0) {
        $target_dir = "uploads/";
        $target_file = $target_dir . basename($_FILES["photo"]["name"]);
        $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

        // Check if image file is a actual image or fake image
        $check = getimagesize($_FILES["photo"]["tmp_name"]);
        if ($check !== false) {
            if (move_uploaded_file($_FILES["photo"]["tmp_name"], $target_file)) {
                $photo = $target_file;
            } else {
                echo "Sorry, there was an error uploading your file.";
            }
        } else {
            echo "File is not an image.";
        }
    }

    // SQL query to update employee details
    $sql = "UPDATE employees SET 
            firstname = '$firstname', 
            lastname = '$lastname', 
            email = '$email', 
            country = '$country', 
            employment_startdate = '$employment_startdate', 
            job_title = '$job_title', 
            employment_type = '$employment_type', 
            currency = '$currency', 
            frequency = '$frequency', 
            salary_startdate = '$salary_startdate', 
            photo = '$photo' 
            WHERE id = $employee_id";

    // Execute SQL query
    if (mysqli_query($conn, $sql)) {
        echo "Employee details updated successfully.";
        header("Location: employee.php");
    } else {
        echo "Error updating employee details: " . mysqli_error($conn);
    }

    // Close database connection
    mysqli_close($conn);
}
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

<li>
<a href="settings.php"><img src="assets/img/settings.svg" alt="sidebar_img"><span>Settings</span></a>
</li>
<li>
<a href="profile.php"><img src="assets/img/profile.svg" alt="sidebar_img"> <span>Profile</span></a>
</li>
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
<li class="breadcrumb-item"><a href="employee.php">Employees</a>
</li></ul>

<li class="breadcrumb-item active">Edit Employees</li>
</div>
</div>
<div class="col-xl-12 col-sm-12 col-12 mb-4">
<div class="head-link-set">
<ul>

</ul>
</div>
</div>
<div class="col-xl-12 col-sm-12 col-12">
<form method="post" action="edit_employee.php?id=<?php echo $employee_id; ?>" enctype="multipart/form-data">
<input type="hidden" name="employee_id" value="<?php echo $employee_id; ?>">

<div class="card">
<div class="card-header">
<h2 class="card-titles">Basic Details <span>Organized and secure.</span></h2>
</div>
<div class="card-body">
<div class="row">
<div class="col-xl-6 col-sm-12 col-12">
<div class="form-group">
<input type="text" name="firstname" id="firstname" placeholder="First Name" value="<?php echo $firstname; ?>">
</div>
</div>
<div class="col-xl-6 col-sm-12 col-12">
<div class="form-group">
<input type="text" name="lastname" id="lastname" placeholder="Last Name" value="<?php echo $lastname; ?>">
</div>
</div>
</div>
<div class="row">
<div class="col-xl-6 col-sm-12 col-12">
<div class="form-group">
<input type="text" name="email" id="email" placeholder="Email" value="<?php echo $email; ?>">
</div>
</div>
<div class="col-xl-6 col-sm-12 col-12">
<div class="form-group">
<label for="photo">Upload Photo:</label>
<input type="file" class="form-control-file" id="photo" name="photo">
</div>
</div>
</div>
</div>
</div>

<div class="col-xl-12 col-sm-12 col-12">
<div class="card">
<div class="card-header">
<h2 class="card-titles">Employment Details<span>Let everyone know the essentials so they're fully prepared.</span></h2>
</div>
<div class="card-body">
<div class="row">
<div class="col-xl-6 col-sm-12 col-12">
<div class="form-group">
<select name="country" id="country" class="select">
<option value="Country of Employment" selected>Country of Employment</option>
<option value="Somaliland" <?php if ($country == 'Somaliland') echo 'selected'; ?>>Somaliland</option>
<option value="USA" <?php if ($country == 'USA') echo 'selected'; ?>>USA</select>
</div>
</div>
<div class="col-xl-6 col-sm-12 col-12">
<div class="form-group">
<label for="employment_startdate">Employment Start Date</label>
<input type="date" id="employment_startdate" name="employment_startdate" value="<?php echo $employment_startdate; ?>">
</div>
</div>
</div>
<div class="row">
<div class="col-xl-6 col-sm-12 col-12">
<div class="form-group">
<input type="text" id="job_title" name="job_title" placeholder="Job Title" value="<?php echo $job_title; ?>">
</div>
</div>
<div class="col-xl-6 col-sm-12 col-12">
<div class="form-group">
<select name="employment_type" id="employment_type" class="select">
<option value="Permanent" <?php if ($employment_type == 'Permanent') echo 'selected'; ?>>Permanent</option>
<option value="Freelancer" <?php if ($employment_type == 'Freelancer') echo 'selected'; ?>>Freelancer</option>
</select>
</div>
</div>
</div>
</div>
</div>
</div>

<div class="col-xl-12 col-sm-12 col-12">
<div class="card">
<div class="card-header">
<h2 class="card-titles">Salary Details<span>Stored securely, only visible to Super Admins, Payroll Admins, and themselves.</span></h2>
</div>
<div class="card-body">
<div class="row">
<div class="col-xl-6 col-sm-12 col-12">
<div class="form-group">
<select id="currency" name="currency" class="select">
<option value="Currency" selected>Currency</option>
<option value="USD" <?php if ($currency == 'USD') echo 'selected'; ?>>USD</option>
<option value="Euro" <?php if ($currency == 'Euro') echo 'selected'; ?>>Euro</option>
<option value="Somaliland Shilling" <?php if ($currency == 'Somaliland Shilling') echo 'selected'; ?>>Somaliland Shilling</option>
</select>
</div>
</div>
<div class="col-xl-6 col-sm-12 col-12">
<div class="form-group">
<label for="salary_startdate">Salary Start Date</label>
<input type="date" id="salary_startdate" name="salary_startdate" value="<?php echo $salary_startdate; ?>">
</div>
</div>
<div class="col-xl-6 col-sm-12 col-12 ">
<div class="form-group">
<select id="frequency"name="frequency" class="select">
<option value="Select leave" selected="false">Select leave </option>
<option value="Frequency" <?php if ($frequency == 'Frequency') echo 'selected'; ?>>Frequency </option>
<option value="Annualy"<?php if ($frequency == 'Annualy') echo 'selected'; ?>>Annualy</option>
<option value="Monthly" <?php if ($frequency == 'Monthly') echo 'selected'; ?>>Monthly</option>
<option value="Weekly" <?php if ($frequency == 'Weekly') echo 'selected'; ?>>Weekly</option>
<option value="Daily" <?php if ($frequency == 'Daily') echo 'selected'; ?>>Daily</option>
</select>
</div>
</div>
</div>
</div>
</div>
</div>

<div class="col-xl-12 col-sm-12 col-12">
<div class="form-group text-right">
<button type="submit" class="btn btn-primary">Save Changes</button>
</div>
</div>

</form>
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