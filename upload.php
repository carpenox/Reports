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

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_FILES['csv_file']) && $_FILES['csv_file']['error'] == 0) {
        $csv_file = $_FILES['csv_file']['tmp_name'];

        // Open the CSV file for reading
        if (($handle = fopen($csv_file, "r")) !== FALSE) {
            // Get the first row, which contains the column headers
            $headers = fgetcsv($handle, 1000, ",");

            // Prepare the SQL statement
            $columns = implode(", ", $headers);
            $placeholders = implode(", ", array_fill(0, count($headers), "?"));
            $sql = "INSERT INTO vicidial_users ($columns) VALUES ($placeholders)";
            $stmt = $conn->prepare($sql);

            if ($stmt === false) {
                die("Error preparing the query: " . $conn->error);
            }

            // Bind parameters dynamically
            $types = str_repeat("s", count($headers)); // Assuming all columns are strings

            // Loop through the CSV file and insert data
            while (($data = fgetcsv($handle, 1000, ",")) !== FALSE) {
                $stmt->bind_param($types, ...$data);
                $stmt->execute();
            }

            fclose($handle);
            $stmt->close();
            echo "Data successfully imported!";
        } else {
            echo "Error opening the CSV file.";
        }
    } else {
        echo "Error uploading the file.";
    }
}

$conn->close();
?>
