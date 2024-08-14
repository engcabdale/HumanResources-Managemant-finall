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

// Fetch attendance data
$query = "SELECT * FROM attendance";
$result = mysqli_query($conn, $query);
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0">
<title>View Attendance</title>

<link rel="stylesheet" href="assets/css/bootstrap.min.css">
<link rel="stylesheet" href="assets/plugins/fontawesome/css/fontawesome.min.css">
<link rel="stylesheet" href="assets/plugins/fontawesome/css/all.min.css">
<link rel="stylesheet" href="assets/css/style.css">
</head>
<body>

<div class="main-wrapper">

    <!-- Your header and sidebar code here -->

    <div class="page-wrapper">
        <div class="content container-fluid">
            <div class="row">
                <div class="col-xl-12 col-sm-12 col-12">
                    <div class="breadcrumb-path mb-4">
                        <ul class="breadcrumb">
                            <li class="breadcrumb-item"><a href="index.php"><img src="assets/img/dash.png" class="mr-2" alt="breadcrumb">Home</a></li>
                            <li class="breadcrumb-item active">View Attendance</li>
                        </ul>
                        <h3>View Attendance</h3>
                    </div>
                </div>

                <div class="col-xl-12 col-sm-12 col-12">
                    <div class="card card-lists">
                        <div class="card-header">
                            <h2 class="card-titles">Attendance</h2>
                            <a href="add_attendance.php" class="btn btn-head"> Add Attendance </a>
                        </div>
                        <div class="card-body p-0">
                            <div class="table-responsive">
                                <table class="table custom-table no-footer">
                                    <thead>
                                        <tr>
                                            <th>Schedule ID</th>
                                            <th>Time In</th>
                                            <th>Time Out</th>
                                            <th>Employee ID</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        if (mysqli_num_rows($result) > 0) {
                                            while($row = mysqli_fetch_assoc($result)) {
                                                echo "<tr>";
                                                echo "<td>" . $row['sch_id'] . "</td>";
                                                echo "<td>" . $row['time_in'] . "</td>";
                                                echo "<td>" . $row['time_out'] . "</td>";
                                                echo "<td>" . $row['emp_id'] . "</td>";
                                                echo "</tr>";
                                            }
                                        } else {
                                            echo "<tr><td colspan='4'>No records found</td></tr>";
                                        }
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
</div>

<script src="assets/js/jquery-3.6.0.min.js"></script>
<script src="assets/js/popper.min.js"></script>
<script src="assets/js/bootstrap.min.js"></script>
<script src="assets/js/feather.min.js"></script>
<script src="assets/plugins/slimscroll/jquery.slimscroll.min.js"></script>
<script src="assets/js/script.js"></script>
</body>
</html>
