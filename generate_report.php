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
[root@my Reports]# cat generate_report.php
<?php
// Enable error reporting
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Set content type to JSON
header('Content-Type: application/json');

// Database connection
$servername = "localhost";
$username = "cron";
$password = "1234";
$dbname = "asterisk";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    echo json_encode(["error" => "Connection failed: " . $conn->connect_error]);
    exit;
}

// Get form data
$startDate = isset($_POST['startDate']) ? $_POST['startDate'] . ' 00:00:00' : '';
$endDate = isset($_POST['endDate']) ? $_POST['endDate'] . ' 23:59:59' : '';
$user = isset($_POST['user']) ? $_POST['user'] : '';
$status = isset($_POST['status']) ? $_POST['status'] : '';

if (empty($startDate) || empty($endDate) || empty($user) || empty($status)) {
    echo json_encode(["error" => "Missing required parameters"]);
    exit;
}

// Fetch report data
$sql = "
    SELECT lead_id, status, user, list_id, phone_number, title, first_name, last_name, address1, address2, city, state, postal_code, email, comments, entry_date
    FROM vicidial_list
    WHERE modify_date BETWEEN '$startDate' AND '$endDate'
    AND user = '$user'
    AND status = '$status'
";
$result = $conn->query($sql);

if (!$result) {
    echo json_encode(["error" => "Query failed: " . $conn->error]);
    exit;
}

$report = array();
while($row = $result->fetch_assoc()) {
    $report[] = $row;
}

echo json_encode($report);

$conn->close();
?>
