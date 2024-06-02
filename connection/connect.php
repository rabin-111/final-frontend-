<?php
$con = new mysqli("localhost", "root", "", "backend");

if ($con->connect_error) {
    die("Connection failed: " . $con->connect_error);
} else {
    echo "Database connected successfully.";
}
?>
