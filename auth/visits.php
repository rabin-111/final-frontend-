<?php
session_start();
include '../connection/connect.php';

// Enable error reporting
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Check if the user is logged in
if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit;
}

$user_id = $_SESSION['user_id'];

// Insert the new visit record with the current date and time
$visit_date = date('Y-m-d');
$visit_time = date('H:i:s');

// Ensure date and time are enclosed in quotes in the SQL query
$insert_query = "INSERT INTO visits (customer_id, visit_date, visit_time) VALUES ('$user_id', '$visit_date', '$visit_time')";

$insert_result = mysqli_query($con, $insert_query);

if (!$insert_result) {
    die("Error inserting visit: " . mysqli_error($con));
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Customer Visits</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-iYQeCzEYFbKjA/T2uDLTpkwGzCiq6soy8tYaI1GyVh/UjpbCx/TYkiZhlZB6+fzT" crossorigin="anonymous">
    <style>
        body {
            background: linear-gradient(to right, #ec2F4B, #009FFF);
            height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
        }
        .container {
            text-align: center;
            max-width: 600px;
            padding: 20px;
            background-color: white;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
        .table {
            margin-top: 20px;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1 class="title">Your Visits</h1>
        <table class="table table-striped">
            <thead>
                <tr>
                    <th>Date</th>
                    <th>Time</th>
                </tr>
            </thead>
            <tbody>
                <?php
                // Retrieve all visits for the logged-in user
                $query = "SELECT * FROM visits WHERE customer_id = '$user_id' ORDER BY visit_date DESC, visit_time DESC";
                $result = mysqli_query($con, $query);

                if (!$result) {
                    die("Error retrieving visits: " . mysqli_error($con));
                }

                if (mysqli_num_rows($result) > 0) {
                    while ($row = mysqli_fetch_assoc($result)) {
                        echo "<tr>";
                        echo "<td>" . date('Y-m-d', strtotime($row['visit_date'])) . "</td>";
                        echo "<td>" . date('H:i:s', strtotime($row['visit_time'])) . "</td>";
                        echo "</tr>";
                    }
                } else {
                    echo "<tr><td colspan='2'>No visits found</td></tr>";
                }
                ?>
            </tbody>
        </table>
        <a href="logout.php" class="btn btn-primary">Logout</a>
    </div>
</body>
</html>
