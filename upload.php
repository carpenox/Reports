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
            echo "Data successfully imported!<br>";

            // Ask for confirmation to create phone extensions
            echo '<form action="upload.php" method="post">';
            echo '<input type="hidden" name="create_phones" value="1">';
            echo '<div class="form-group">';
            echo '<label for="server_ips">Server IPs (comma-separated):</label>';
            echo '<input type="text" class="form-control" id="server_ips" name="server_ips" required>';
            echo '</div>';
            echo '<button type="submit" class="btn btn-primary">Create Phone Extensions</button>';
            echo '</form>';
        } else {
            echo "Error opening the CSV file.";
        }
    } elseif (isset($_POST['create_phones']) && $_POST['create_phones'] == 1) {
        // Create phone extensions based on the phone_login field from vicidial_users
        $server_ips = explode(',', $_POST['server_ips']);
        $sql = "SELECT user, phone_login, pass FROM vicidial_users";
        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
            $stmt = $conn->prepare("INSERT INTO phones (extension, dialplan_number, voicemail_id, phone_ip, computer_ip, server_ip, login, pass, status, active, phone_type) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");

            if ($stmt === false) {
                die("Error preparing the query: " . $conn->error);
            }

            while ($row = $result->fetch_assoc()) {
                foreach ($server_ips as $server_ip) {
                    $extension = $row['phone_login'];
                    $dialplan_number = $row['phone_login'];
                    $voicemail_id = $row['phone_login'];
                    $phone_ip = '';
                    $computer_ip = '';
                    $login = $row['phone_login'];
                    $pass = $row['pass'];
                    $status = 'ACTIVE';
                    $active = 'Y';
                    $phone_type = 'SIP';

                    $stmt->bind_param("sssssssssss", $extension, $dialplan_number, $voicemail_id, $phone_ip, $computer_ip, $server_ip, $login, $pass, $status, $active, $phone_type);
                    $stmt->execute();

                    // Create phone_alias entry
                    $alias_stmt = $conn->prepare("INSERT INTO phones_alias (alias_name, logins_list, user_group) VALUES (?, ?, ?)");
                    if ($alias_stmt === false) {
                        die("Error preparing the alias query: " . $conn->error);
                    }
                    $alias_name = $row['phone_login'];
                    $logins_list = $row['phone_login'];
                    $user_group = ''; // Set the appropriate user group if needed
                    $alias_stmt->bind_param("sss", $alias_name, $logins_list, $user_group);
                    $alias_stmt->execute();
                    $alias_stmt->close();
                }
            }

            $stmt->close();
            echo "Phone extensions and aliases successfully created!";
        } else {
            echo "No users found to create phone extensions.";
        }
    } else {
        echo "Error uploading the file.";
    }
}

$conn->close();
?>
