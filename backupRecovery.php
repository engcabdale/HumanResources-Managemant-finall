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

<?php
// Database configuration
$host = "localhost";
$username = "root";
$password = "";
$database_name = "hrmanagement_db";

// Get the Downloads folder path
$backupDir = getenv("HOMEDRIVE") . getenv("HOMEPATH") . DIRECTORY_SEPARATOR . 'Downloads' . DIRECTORY_SEPARATOR;

// Get connection object and set the charset
$conn = mysqli_connect($host, $username, $password, $database_name);

// Check connection
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

$conn->set_charset("utf8");

// Backup process
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['backup'])) {
    // Get All Table Names From the Database
    $tables = array();
    $sql = "SHOW TABLES";
    $result = mysqli_query($conn, $sql);

    while ($row = mysqli_fetch_row($result)) {
        $tables[] = $row[0];
    }

    $sqlScript = "";
    foreach ($tables as $table) {    
        // Prepare SQL script for creating table structure
        $query = "SHOW CREATE TABLE $table";
        $result = mysqli_query($conn, $query);
        $row = mysqli_fetch_row($result);
        
        $sqlScript .= "\n\n" . $row[1] . ";\n\n";
        
        $query = "SELECT * FROM $table";
        $result = mysqli_query($conn, $query);
        
        $columnCount = mysqli_num_fields($result);    
        // Prepare SQL script for dumping data for each table
        while ($row = mysqli_fetch_row($result)) {
            $sqlScript .= "INSERT INTO $table VALUES(";
            for ($j = 0; $j < $columnCount; $j++) {
                $row[$j] = mysqli_real_escape_string($conn, $row[$j]);
                if (isset($row[$j])) {
                    $sqlScript .= '"' . $row[$j] . '"';
                } else {
                    $sqlScript .= '""';
                }
                if ($j < ($columnCount - 1)) {
                    $sqlScript .= ',';
                }
            }
            $sqlScript .= ");\n";
        }
        $sqlScript .= "\n"; 
    }

    if (!empty($sqlScript)) {
        // Save the SQL script to a backup file in the Downloads folder
        $backup_file_name = $backupDir . $database_name . '_backup_' . time() . '.sql';
        $fileHandler = fopen($backup_file_name, 'w+');
        fwrite($fileHandler, $sqlScript);
        fclose($fileHandler); 

        echo "Backup successful! : " . $backup_file_name;
    } else {
        echo "No data found in the database.";
    }
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Database Backup</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f0f0f0;
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }
        .container {
            background-color: #fff;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            text-align: center;
        }
        h1 {
            margin-bottom: 20px;
        }
        button {
            padding: 10px 20px;
            font-size: 16px;
            color: #fff;
            background-color: #007bff;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }
        button:hover {
            background-color: #0056b3;
        }
        #loadingMessage {
            display: none;
            margin-top: 20px;
            font-size: 14px;
            color: #555;
        }
    </style>
    <script>
        function showLoadingMessage() {
            document.getElementById('loadingMessage').style.display = 'block';
        }
    </script>
</head>
<body>
    <div class="container">
        <h1>Recovery Backup</h1>
        <form method="post" onsubmit="showLoadingMessage()">
            <button type="submit" name="backup">Backup Database</button>
        </form>
        <div id="loadingMessage">Please wait, the backup is being created...</div>
    </div>
</body>
</html>

