<?php include '../connection/connect.php'; ?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.1/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-iYQeCzEYFbKjA/T2uDLTpkwGzCiq6soy8tYaI1GyVh/UjpbCx/TYkiZhlZB6+fzT" crossorigin="anonymous">
</head>
<style>
    * {
        margin: 0;
        padding: 0;
        box-sizing: border-box;
    }
    body{
        background: #009FFF;  /* fallback for old browsers */
    background: -webkit-linear-gradient(to right, #ec2F4B, #009FFF);  /* Chrome 10-25, Safari 5.1-6 */
    background: linear-gradient(to right, #ec2F4B, #009FFF); /* W3C, IE 10+/ Edge, Firefox 16+, Chrome 26+, Opera 12+, Safari 7+ */
    }
    .container {
        text-align: center;
        height: 100vh;
        display: flex;
        align-items: center;
        flex-direction: column;
        justify-content: center;
    }

    .container form {
        display: flex;
        flex-direction: column;
        justify-content: center;
        align-items: center;
    }

    .container form input,
    textarea {
        margin: 10px;
        padding: 15px;
        display: block;
        width: 55em;
        border: 2px solid black;
        border-radius: 8px;
    }

    button {
        margin: 10px;
        padding: 7px;
        cursor: pointer;
        border: 2px solid black;
        border-radius: 5px;
    }

    .success {
        font-size: large;
        color: green;
        font-weight: bolder;
    }
    .red {
        font-size: large;
        color: red;
        font-weight: bolder;
    }
    .btn:hover {
        text-decoration: underline;
    }
</style>
<script>
    function validateForm() {
        var phoneField = document.forms["loginForm"]["Phone_no"].value;
        if (!Number.isInteger(Number(phoneField)) || phoneField.length > 10) {
            document.getElementById("error-message").innerHTML = "Phone number must be a number and not exceed 10 digits.";
            return false;
        }
        return true;
    }
</script>
<body>
    <div class="container">
        <h1 class="title">Welcome to Login</h1>
        <p>Enter your details to login.</p>
        <p id="error-message" class="red"></p>

        <?php
            if(isset($_POST['submit'])) {
                $phoneno = $_POST['Phone_no'];
                $password = $_POST['Password'];

                if ($phoneno != "" && $password != "") {
                    $query = "SELECT * FROM customer_details WHERE phone_number='$phoneno'";
                    $result = mysqli_query($con, $query);
                    
                    if ($result) {
                        $user = mysqli_fetch_assoc($result);
                        if ($user && password_verify($password, $user['password'])) {
                            echo "<p class='success'>Login successful. Welcome, " . $user['given_name'] . "!</p>";
                            header('location:../index.html');
                        } else {
                            echo "<p class='red'>Invalid phone number or password.</p>";
                        }
                    } else {
                        echo "<p class='red'>Error executing query: " . mysqli_error($con) . "</p>";
                    }
                    
                } else {
                    echo "<p class='red'>All fields are required.</p>";
                }
            }
        ?>

        <form name="loginForm" action="#" method="post" onsubmit="return validateForm()">
            <input type="text" name="Phone_no" placeholder="Enter your Phone Number:" maxlength="10" required>
            <input type="password" name="Password" placeholder="Enter your Password:" required>
            <button class="btn btn-primary" type="submit" name="submit">Login</button>
        </form>
    </div>
</body>

</html>
