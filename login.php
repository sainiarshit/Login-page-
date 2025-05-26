<?php
include 'config.php';

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    // Sanitize and fetch form data
    $name = trim($_POST['fullName'] ?? '');
    $email = strtolower(trim($_POST['email'] ?? ''));
    $user_id = trim($_POST['userId'] ?? '');
    $mobile = trim($_POST['mobile'] ?? '');
    $location = trim($_POST['location'] ?? '');
    $age = trim($_POST['age'] ?? '');
    $gender = trim($_POST['gender'] ?? '');
    $password = $_POST['password'] ?? '';

    // Basic validation
    if (!$name || !$email || !$user_id || !$mobile || !$location || !$age || !$gender || !$password) {
        echo "All fields are required.";
        exit;
    }

    // Hash the password before saving
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);

    // Prepare insert query
    $stmt = $conn->prepare("INSERT INTO users (name, email, user_id, mobile, location, age, gender, password)
                            VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("ssssssss", $name, $email, $user_id, $mobile, $location, $age, $gender, $hashed_password);

    if ($stmt->execute()) {
        echo "success";
    } else {
        echo "Error: " . $stmt->error;
    }

    $stmt->close();
    $conn->close();
}
?>
