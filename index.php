<?php
// DB connection
include 'config.php';
$conn = new mysqli("localhost", "root", "", "millionaire_db");

if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}

// Get form data
$full_name = $_POST['full_name'] ?? '';
$mobile    = $_POST['mobile'] ?? '';
$email     = $_POST['email'] ?? '';
$user_id   = $_POST['user_id'] ?? '';
$location  = $_POST['location'] ?? '';
$age       = $_POST['age'] ?? '';
$gender    = $_POST['gender'] ?? '';
$password  = $_POST['password'] ?? '';

// Validate empty
if (!$full_name || !$mobile || !$email || !$user_id || !$location || !$age || !$gender || !$password) {
  echo "All fields are required!";
  exit;
}

// Check if user ID already exists
$checkUser = $conn->prepare("SELECT id FROM users WHERE user_id = ?");
$checkUser->bind_param("s", $user_id);
$checkUser->execute();
$checkUser->store_result();

if ($checkUser->num_rows > 0) {
  echo "User ID already taken!";
  exit;
}

// Hash password
$hashedPassword = password_hash($password, PASSWORD_DEFAULT);

// Insert user
$stmt = $conn->prepare("INSERT INTO users (full_name, mobile, email, user_id, location, age, gender, password) VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
$stmt->bind_param("sssssiss", $full_name, $mobile, $email, $user_id, $location, $age, $gender, $hashedPassword);

if ($stmt->execute()) {
  echo "success";
} else {
  echo "Something went wrong!";
}
?>
