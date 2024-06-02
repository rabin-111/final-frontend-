<?php include '../connection/connect.php'; ?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
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
    .success{
        font-size: large;
        color: green;
        font-weight: bolder;
    }
    .red{
        font-size: large;
        color: red;
        font-weight: bolder;
    }
    .btn:hover{
        text-decoration: underline;
    }
</style>
<script>
    function validateForm() {
        var phoneField = document.forms["form"]["Phone_no"].value;
        var errorMessage = document.getElementById("error-message");

        if (isNaN(phoneField)) {
            errorMessage.innerHTML = "Phone number must contain only digits.";
            return false;
        }
        if (phoneField.length != 10) {
            errorMessage.innerHTML = "Phone number must be exactly 10 digits.";
            return false;
        }
        return true;
    }
</script>
<body>
    <div class="container">
        <h1 class="title">Welcome to Form Submission</h1>
        <p>Enter your details and submit this form to confirm your participation.</p>
        <p id="error-message" class="red"></p>

        <?php
            $insert = false;
            if (isset($_POST['submit'])) {
                $name = $_POST['Name'];
                $phoneno = $_POST['Phone_no'];
                $password = $_POST['Password'];

                if ($name != "" && $password != "" && $phoneno != "") {
                    $passwordHash = password_hash($password, PASSWORD_DEFAULT);
                    $query = "INSERT INTO customer_details(name,phone_number,password) VALUES('$name','$phoneno','$passwordHash')";

                    $result = mysqli_query($con, $query);
                    if ($result) {
                        $insert = true;
                    }

                    if ($insert == true) {
                        echo "<p class='success'>Your details have been successfully submitted.</p>";
                        header('location:login.php');
                    }
                } else {
                    echo "<p class='red'>All fields are required.</p>";
                }
            }
        ?>
        <form name="form" action="#" method="post" onsubmit="return validateForm()">
            <input type="text" name="Name" placeholder="Enter your Name:" required>
            <input type="text" name="Phone_no" placeholder="Enter your Phone Number:" maxlength="10" required>
            <input type="password" name="Password" placeholder="Enter your Password:" required>
            <button class="btn btn-primary" type="submit" name="submit">Submit</button>
        </form>
    </div>
</body>

</html>
