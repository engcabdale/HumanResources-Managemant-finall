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

// Handle deletion request
if (isset($_POST['delete_employee'])) {
    $employeeId = intval($_POST['id']);
    $conn = new mysqli('localhost', 'root', '', 'hrmanagement_db'); // Update with your DB credentials

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Check for related records in department table
    $sql = "SELECT COUNT(*) as count FROM department WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param('i', $employeeId);
    $stmt->execute();
    $result = $stmt->get_result();
    $row = $result->fetch_assoc();
    if ($row['count'] > 0) {
        echo "Cannot delete employee. There are related records in the department table.";
        $conn->close();
        exit();
    }

    // Check for related records in attendance table
    $sql = "SELECT COUNT(*) as count FROM attendance WHERE employee_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param('i', $employeeId);
    $stmt->execute();
    $result = $stmt->get_result();
    $row = $result->fetch_assoc();
    if ($row['count'] > 0) {
        echo "Cannot delete employee. There are related records in the attendance table.";
        $conn->close();
        exit();
    }

    // Check for related records in schedule table
    $sql = "SELECT COUNT(*) as count FROM schedule WHERE emp_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param('i', $employeeId);
    $stmt->execute();
    $result = $stmt->get_result();
    $row = $result->fetch_assoc();
    if ($row['count'] > 0) {
        echo "Cannot delete employee. There are related records in the schedule table.";
        $conn->close();
        exit();
    }

    // Delete employee if no related records found
    $sql = "DELETE FROM employees WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param('i', $employeeId);
    if ($stmt->execute()) {
        echo "Employee deleted successfully.";
    } else {
        echo "Error deleting employee.";
    }

    $conn->close();
    exit();
}
?>
