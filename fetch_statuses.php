<?php
// Enable error reporting
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Database connection
$servername = "localhost";
$username = "cron";
$password = "1234";
$dbname = "asterisk";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Fetch statuses
$sql = "SELECT status FROM vicidial_statuses";
$result = $conn->query($sql);

$statuses = array();
while($row = $result->fetch_assoc()) {
    $statuses[] = $row;
}

echo json_encode($statuses);

$conn->close();
?>
