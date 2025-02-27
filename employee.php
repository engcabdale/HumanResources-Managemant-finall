
<?php
// Include database connection
include 'database/conn.php';

// Fetch employees from database
$sql = "SELECT COUNT(*) as count FROM employees";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $numEmployees = $row['count']; // Assign the count to $numEmployees
} else {
    $numEmployees = 0; // Default to 0 if no employees found
}

$conn->close(); // Close database connection
// Start session
session_start();

// Check if user is not logged in, redirect to login page
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

// Include your database connection and other necessary file
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0">
<title>Employee Management System</title>

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
		<script>
    $(document).ready(function() {
        // Dynamically update the employee count label
        var numEmployees = <?php echo $numEmployees; ?>;
        $(".employee_count").text(numEmployees + " People");
    });
    </script>
</head>
<body>

<div class="main-wrapper">

<div class="header">

<div class="header-left">
<a href="index.php" class="logo">
<p class="account-subtitle">HRM</p>
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
<span><?php echo "$_SESSION[name]" ?></span>
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
<!-- <a class="dropdown-item" href="profile.php">My Profile</a>
<a class="dropdown-item" href="settings.php">Settings</a> -->
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
<a href="Note.php"><img src="assets/img/profile.svg" alt="sidebar_img"> <span>Note</span></a>
</li>
</ul>
<ul class="logout"> -->
<!-- <li>
<a href="profile.php"><img src="assets/img/logout.svg" alt="sidebar_img"><span>Log out</span></a>
</li> -->
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
<li class="breadcrumb-item active"> Employees</li>
</ul>
<h3>Employees</h3>
</div>
</div>
<div class="col-xl-12 col-sm-12 col-12 mb-4">
<div class="head-link-set">
<ul>

</ul>
</div>
</div>
<div class="col-xl-12 col-sm-12 col-12 mb-4">
<div class="row">
<div class="col-xl-10 col-sm-8 col-12 ">
<label class="employee_count"><?php echo $numEmployees; ?> People</label>
</div>
<div class="col-xl-2 col-sm-4 col-12 ">
<a class="btn-view btn-add" href="add-employee.php"><i data-feather="plus"></i> Add Person</a>
</div>
</div>
</div>
<div class="col-xl-12 col-sm-12 col-12 mb-4">
<div class="card">
<div class="table-heading">
<h2>Employees</h2>
</div>
<div class="table-responsive">
<table class="table  custom-table no-footer">
<thead>
<tr>
<th>Full Name</th>
<th>Email</th>
<th>Job Title</th>
<th>Employment Type</th>
<th>Country</th>
<th>Action</th>
</tr>
</thead>
<tbody>
                                <?php
                                // Include database connection
                                include 'database/conn.php';

                                // Fetch employees from database
                                $sql = "SELECT * FROM employees";
                                $result = $conn->query($sql);

                                if ($result->num_rows > 0) {
                                    while($row = $result->fetch_assoc()) {
                                        echo '<tr>';
                                        echo '<td>';
                                        echo '<div class="table-img">';
                                        echo '<a href="profile.php">';
                                        // Check if photo exists, otherwise show default image
                                        $photo_path = 'uploads' . $row['photo'];
                                        if (file_exists($photo_path) && $row['photo'] !== '') {
                                            echo '<img src="' . $photo_path . '" alt="profile" class="img-table" />';
                                        } else {
                                            echo '<img src="assets/img/profiles/avatar-default.jpg" alt="profile" class="img-table" />';
                                        }
                                        echo '<label>' . $row['firstname'] . ' ' . $row['lastname'] . '</label>';
                                        echo '</a>';
                                        echo '</div>';
                                        echo '</td>';
                                        echo '<td>';
                                        echo '<label class="action_label">' . $row['email'] . '</label>';
                                        echo '</td>';
                                        echo '<td>';
                                        echo '<label class="action_label2">' . $row['job_title'] . '</label>';
                                        echo '</td>';
                                        echo '<td>';
                                        echo '<label>' . $row['employment_type'] . '</label>';
                                        echo '</td>';
                                        echo '<td>';
                                        echo '<label>' . $row['country'] . '</label>';
                                        echo '</td>';
                                        echo '<td>';
                                        echo '<a href="view_employee.php?id=' . $row['id'] . '">View</a> | ';
                                        echo '<a href="edit_employee.php?id=' . $row['id'] . '">Edit</a> | ';
                                        echo '<a href="#" onclick="deleteEmployee(' . $row['id'] . ')">Delete</a>';
                                        echo '</td>';
                                        echo '</tr>';
                                    }
                                } else {
                                    echo '<tr><td colspan="6">No employees found.</td></tr>';
                                }
                                $conn->close();
                                ?>
                            </tbody>
</table>
</div>
</div>
</div>
				</div>
</div>
</div>

</div>



    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="assets/js/popper.min.js"></script>
    <script src="assets/js/bootstrap.min.js"></script>
    <script src="assets/js/feather.min.js"></script>
    <script src="assets/plugins/slimscroll/jquery.slimscroll.min.js"></script>
    <script src="assets/plugins/select2/js/select2.min.js"></script>
    <script src="assets/js/script.js"></script>
	<script>
    $(document).ready(function() {
        function deleteEmployee(employeeId) {
            if (confirm("Are you sure you want to delete this employee?")) {
                $.ajax({
                    url: 'employee.php', // Assuming this is the same file
                    type: 'POST',
                    data: { delete_employee: true, id: employeeId },
                    success: function(response) {
                        alert(response);
                        location.reload(); // Reload the page after deletion
                    },
                    error: function(xhr, status, error) {
                        console.error(error);
                    }
                });
            }
        }

        $(".delete-employee").click(function(e) {
            e.preventDefault();
            var employeeId = $(this).data("id");
            deleteEmployee(employeeId);
        });
    });
    </script>
</body>
</html>