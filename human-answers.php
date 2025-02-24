
<?php

// Database connection details
$servername = "localhost";
$username = "cron";
$password = "1234";
$dbname = "asterisk";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Initialize variables
$start_date = '';
$end_date = '';
$results = [];

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $start_date = $_POST['start_date'];
    $end_date = $_POST['end_date'];

    // Prepare and execute the query
    $query = "
        SELECT
            REPLACE(SUBSTRING_INDEX(vdcl.outbound_cid, '<', -1), '>', '') AS extracted_number,
            COUNT(vdcl.outbound_cid) AS total_calls,
            COUNT(CASE WHEN vad.AMDSTATUS = 'HUMAN' THEN 1 END) AS human_answered_calls,
            (COUNT(CASE WHEN vad.AMDSTATUS = 'HUMAN' THEN 1 END) / COUNT(vdcl.outbound_cid)) * 100 AS human_answer_rate
        FROM
            vicidial_dial_cid_log vdcl
        LEFT JOIN
            vicidial_amd_log vad ON vdcl.caller_code = vad.caller_code
        WHERE
            vdcl.call_date BETWEEN ? AND ?
        GROUP BY
            extracted_number
        ORDER BY
            human_answer_rate DESC
        LIMIT 1000
    ";

    $stmt = $conn->prepare($query);
    if ($stmt === false) {
        die("Error preparing the query: " . $conn->error);
    }

    $stmt->bind_param("ss", $start_date, $end_date);
    $stmt->execute();
    $results = $stmt->get_result();
    $stmt->close();
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Outbound CID Report</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        body {
            background-color: #f8f9fa;
            font-family: Arial, sans-serif;
        }
        .container {
            margin-top: 20px;
        }
        .card {
            margin-bottom: 20px;
            border: none;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }
        .card-header {
            background-color: #007bff;
            color: white;
            border-top-left-radius: 10px;
            border-top-right-radius: 10px;
        }
        .card-body {
            padding: 20px;
        }
        .table {
            margin-top: 20px;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="card">
            <div class="card-header">
                <h3>Outbound CID Report</h3>
            </div>
            <div class="card-body">
                <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
                    <div class="form-group">
                        <label for="start_date">Start Date:</label>
                        <input type="date" class="form-control" id="start_date" name="start_date" required>
                    </div>
                    <div class="form-group">
                        <label for="end_date">End Date:</label>
                        <input type="date" class="form-control" id="end_date" name="end_date" required>
                    </div>
                    <button type="submit" class="btn btn-primary">Generate Report</button>
                </form>
            </div>
        </div>

        <?php if (!empty($results)): ?>
        <div class="card">
            <div class="card-header">
                <h3>Report Results</h3>
            </div>
            <div class="card-body">
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>Outbound CID</th>
                            <th>Total Calls</th>
                            <th>Human Answered Calls</th>
                            <th>Human Answer Rate (%)</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php while ($row = $results->fetch_assoc()): ?>
                        <tr>
                            <td><?php echo htmlspecialchars($row['extracted_number']); ?></td>
                            <td><?php echo htmlspecialchars($row['total_calls']); ?></td>
                            <td><?php echo htmlspecialchars($row['human_answered_calls']); ?></td>
                            <td><?php echo htmlspecialchars(number_format($row['human_answer_rate'], 2)); ?></td>
                        </tr>
                        <?php endwhile; ?>
                    </tbody>
                </table>
            </div>
        </div>
        <?php endif; ?>
    </div>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
