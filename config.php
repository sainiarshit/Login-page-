<?php
$host = "localhost";
$db = "millionaire_db";
$user = "root"; // default XAMPP username
$pass = "";     // default XAMPP password is empty

$conn = new mysqli($host, $user, $pass, $db);

if ($conn->connect_error) {
    die("Database connection failed: " . $conn->connect_error);
}
?>
