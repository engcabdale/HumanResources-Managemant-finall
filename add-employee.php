<?php
include 'database/conn.php';  // Ensure this path is correct based on your file structure

session_start();

// Check if user is not logged in, redirect to login page
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

// Check if form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    
    // Check if all required fields are set
    if (isset($_POST['firstname'], $_POST['lastname'], $_POST['email'], $_POST['country'], $_POST['employment_startdate'], $_POST['job_title'], $_POST['employment_type'], $_POST['currency'], $_POST['frequency'], $_POST['salary_startdate'])) {
        
        // Handle file upload
        $photo = null;
        if (isset($_FILES["photo"]) && $_FILES["photo"]["error"] == UPLOAD_ERR_OK) {
            $target_dir = "uploads/";
            $unique_filename = uniqid() . "_" . basename($_FILES["photo"]["name"]);
            $target_file = $target_dir . $unique_filename;
            $uploadOk = 1;
            $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

            // Check if file already exists
            if (file_exists($target_file)) {
                echo "Sorry, file already exists.";
                $uploadOk = 0;
            }
            
            // Check file size
            if ($_FILES["photo"]["size"] > 500000) {
                echo "Sorry, your file is too large.";
                $uploadOk = 0;
            }
            
            // Allow certain file formats
            $allowed_types = array('jpg', 'jpeg', 'png', 'gif');
            if (!in_array($imageFileType, $allowed_types)) {
                echo "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
                $uploadOk = 0;
            }
            
            // Check if $uploadOk is set to 0 by an error
            if ($uploadOk == 0) {
                echo "Sorry, your file was not uploaded.";
            // if everything is ok, try to upload file
            } else {
                if (move_uploaded_file($_FILES["photo"]["tmp_name"], $target_file)) {
                    echo "The file " . htmlspecialchars(basename($_FILES["photo"]["name"])) . " has been uploaded.";
                    $photo = $unique_filename;  // Assign the uploaded file name to $photo
                } else {
                    echo "Sorry, there was an error uploading your file.";
                }
            }
        } else {
            echo "Error: No file uploaded or file upload error.";
        }
        
        // Prepare SQL query with photo included
        $sql = "INSERT INTO employees (firstname, lastname, email, country, employment_startdate, job_title, employment_type, currency, frequency, salary_startdate, photo)
                VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
        
        // Prepare statement
        $stmt = $conn->prepare($sql);
        
        if (!$stmt) {
            die("Error preparing statement: " . $conn->error);
        }
        
        // Bind parameters including photo file
        $stmt->bind_param("sssssssssss", $firstname, $lastname, $email, $country, $employment_startdate, $job_title, $employment_type, $currency, $frequency, $salary_startdate, $photo);
        
        // Set parameters from POST
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
        
        // Debugging output
        echo "<pre>";
        print_r($_POST);
        echo "</pre>";

        // Execute statement if upload is successful and $photo is set
        if ($uploadOk && isset($photo)) {
            if ($stmt->execute()) {
                echo "New record added successfully";
                header("Location: employee.php");  // Redirect after successful insertion
                exit();  // Ensure script stops executing after redirection
            } else {
                echo "Error executing statement: " . $stmt->error;
            }
        } else {
            echo "Error: File upload failed or photo not set.";
        }
        
        // Close statement
        $stmt->close();
        
    } else {
        // Handle case where required fields are not set
        echo "Error: All fields are required.";
    }
    
} else {
    // Handle case where form is not submitted
    echo "Error: Form not submitted.";
}

// Close connection
$conn->close();
?>







<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0">
<title>Human Resources Management</title>

<!-- <link rel="shortcut icon" href="assets/img/teamwork.png"> -->
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
<!-- <img src="assets/img/logo.png" alt="Logo"> -->
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
<img src="assets\img\profiles/min.png" alt="" height="50">
<span class="status online"></span>
</span>
<span>Cabdale ismail</span>
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
<!-- <li>
<a href="profile.php"><img src="assets/img/logout.svg" alt="sidebar_img"><span>Log out</span></a>
</li> -->
</ul>
</div>
</div>
</div>
</div>

<form action="add-employee.php" enctype="multipart/form-data" method="post">
<div class="page-wrapper">
<div class="content container-fluid">
<div class="row">
<div class="col-xl-12 col-sm-12 col-12 ">
<div class="breadcrumb-path mb-4">
<ul class="breadcrumb">
<li class="breadcrumb-item"><a href="index.php">Home</a>
</li>
<li class="breadcrumb-item active"> Employees</li>
</ul>
<h3>Create Employees</h3>
</div>
</div>
<div class="col-xl-12 col-sm-12 col-12 ">
<div class="card">
<div class="card-header">
<h2 class="card-titles">Basic Details <span>Organized and secure.</span></h2>
</div>
<div class="card-body">
<div class="row">
<div class="col-xl-6 col-sm-12 col-12 ">
<div class="form-group">
<input type="text" name="firstname" id="firstname" placeholder="First Name">
</div>
</div>
<div class="col-xl-6 col-sm-12 col-12 ">
<div class="form-group">
<input type="text" name="lastname" id="lastname" placeholder="Last Name">
</div>
</div>
</div>
<div class="row">
<div class="col-xl-6 col-sm-12 col-12 ">
<div class="form-group">
<input type="text" name="email" id="email" placeholder="Email">
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
</div>
<div class="col-xl-12 col-sm-12 col-12 ">
<div class="card ">
<div class="card-header">
<h2 class="card-titles">Employment Details<span>Let everyone know the essentials so they're fully prepared.</span></h2>
</div>
<div class="card-body">
<div class="row">
<div class="col-xl-6 col-sm-12 col-12 ">
<div class="form-group">
<select name="country" id="country" class="select">
<option value="Country of Employment" selected="false">Country of Employment</option>
<option value="Somaliland">Somaliland</option>
<option value="USA">USA</option>
</select>
</div>
</div>
<div class="col-xl-6 col-sm-12 col-12 ">
<div class="form-group">
<label for="employment_startdate">employment start date</label>
<input type="date" id="employment_startdate" name="employment_startdate" placeholder="Start Date">
</div>
 </div>
</div>
<div class="row">
<div class="col-xl-6 col-sm-12 col-12 ">
<div class="form-group">
<input type="text" id="job_title" name="job_title" placeholder="Job Title">
</div>
</div>
<div class="col-xl-6 col-sm-12 col-12 ">
<div class="form-group">
<select name="employment_type" id="employment_type" class="select">
<option value="Permanent">Permanent	</option>
<option value="Freelancer">Freelancer</option>
</select>
</div>
</div>
</div>
</div>
</div>
</div>
<div class="col-xl-12 col-sm-12 col-12 ">
<div class="card">
<div class="card-header">
<h2 class="card-titles">Salary Details<span>Stored securely, only visible to Super Admins, Payroll Admins, and themselves.</span></h2>
</div>
<div class="card-body">
<div class="row">
<div class="col-xl-6 col-sm-12 col-12 ">
<div class="form-group">
<select id="currency" name="currency" class="select">
<option value="Currency" selected>Currency</option>
<option value="Usd">USD ($)</option>
<option value="slsh">Shilling (SLSH)</option>
</select>
</div>
</div>
<div class="col-xl-6 col-sm-12 col-12 ">
<div class="form-group">
<select id="frequency"name="frequency" class="select">
<option value="Select leave" selected="false">Select leave </option>
<option value="Frequency">Frequency </option>
<option value="Annualy">Annualy</option>
<option value="Monthly">Monthly</option>
<option value="Weekly">Weekly</option>
<option value="Daily">Daily</option>
</select>
</div>
</div>
</div>
<div class="row">
<div class="col-xl-6 col-sm-12 col-12 ">
<div class="form-group">
<label for="salary_startdate">Salary Start Date</label>
<input type="date" id="salary_startdate" name="salary_startdate" placeholder="Start Date">
</div>
</div>
</div>
</div>
</div>
<div class="row">
<div class="col-xl-12 col-sm-12 col-12 ">
<div class="form-btn">
<button class="btn btn-apply w-auto" type="submit">Add Team Member</button>
<a href="#" class="btn btn-secondary">Cancel</a>
</div>
</div>
</div>
</div>
</div>
</div>
</div>
</form>
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