<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Upload CSV to Vicidial Users</title>
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
    </style>
</head>
<body>
    <div class="container">
        <div class="card">
            <div class="card-header">
                <h3>Upload CSV to Vicidial Users</h3>
            </div>
            <div class="card-body">
                <form action="upload.php" method="post" enctype="multipart/form-data">
                    <div class="form-group">
                        <label for="csv_file">Choose CSV File:</label>
                        <input type="file" class="form-control" id="csv_file" name="csv_file" accept=".csv" required>
                    </div>
                    <button type="submit" class="btn btn-primary">Upload</button>
                </form>
            </div>
        </div>
    </div>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
