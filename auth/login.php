<?php
session_start();
include '../connection/connect.php';

// Enable error reporting
error_reporting(E_ALL);
ini_set('display_errors', 1);

if (isset($_POST['submit'])) {
    $phoneno = $_POST['Phone_no'];
    $password = $_POST['Password'];

    if (isset($_POST['submit'])) {
        $phoneno = $_POST['Phone_no'];
        $password = $_POST['Password'];

        if (!empty($phoneno) && !empty($password)) {
            $query = "SELECT * FROM customer_details WHERE phone_number = '$phoneno'";
            $result = mysqli_query($con, $query);

            if ($result && mysqli_num_rows($result) > 0) {
                $user = mysqli_fetch_assoc($result);
                if (password_verify($password, $user['password'])) {
                    session_start();
                    $_SESSION['user_id'] = $user['customer_id'];
                    header('Location: visits.php');
                    exit;
                } else {
                    $error_message = "Invalid phone number or password.";
                }
            } else {
                $error_message = "Invalid phone number or password.";
            }
        } else {
            $error_message = "All fields are required.";
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
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
            max-width: 400px;
            padding: 20px;
            background-color: white;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
        .form-control {
            margin: 10px 0;
        }
        .btn-primary {
            width: 100%;
        }
        .message {
            margin-top: 15px;
            font-weight: bold;
        }
        .success {
            color: green;
        }
        .error {
            color: red;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1 class="title">Welcome to Login</h1>
        <p>Enter your details to login.</p>
        <?php
        if (isset($error_message)) {
            echo "<div class='message error'>$error_message</div>";
        }
        ?>
        <form name="loginForm" action="#" method="post" onsubmit="return validateForm()">
            <input type="text" name="Phone_no" class="form-control" placeholder="Enter your Phone Number:" maxlength="10" required>
            <input type="password" name="Password" class="form-control" placeholder="Enter your Password:" required>
            <button class="btn btn-primary" type="submit" name="submit">Login</button>
        </form>
        <div id="error-message" class="message error"></div>
    </div>

    <script>
        function validateForm() {
            var phoneField = document.forms["loginForm"]["Phone_no"].value;
            if (isNaN(phoneField) || phoneField.length != 10) {
                document.getElementById("error-message").innerHTML = "Phone number must be a 10-digit number.";
                return false;
            }
            return true;
        }
    </script>
</body>
</html>
