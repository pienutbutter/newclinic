<?php
require 'dbconnection.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $phone = $_POST['phone'];
    $address = $_POST['address'];

    if (empty($name) || empty($email) || empty($password) || empty($phone) || empty($address)) {
        echo "<script>alert('Please fill in all fields.');</script>";
        exit();
    }

    $hashed_password = password_hash($password, PASSWORD_DEFAULT);

    $stmt = $conn->prepare("INSERT INTO tbl_users (user_name, user_email, user_password, user_phone, user_address) VALUES (?, ?, ?, ?, ?)");
    if ($stmt === false) {
        die("Error preparing statement: " . $conn->error);
    }
    $stmt->bind_param("sssss", $name, $email, $hashed_password, $phone, $address);

    if ($stmt->execute()) {
        echo "<script>alert('Registration successful!'); window.location.href = 'login.php';</script>";
    } else {
        echo "Error: " . $stmt->error;
    }

    $stmt->close();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register - Dental Clinic</title>
    <link rel="stylesheet" href="style.css">
    <script src="validation.js"></script>
</head>
<body>
    <header class="header w3-center">
        <h1>Dental Clinic</h1>
    </header>

    <div class="main-content">
        <div class="form-container">
            <h2 class="form-title">Register</h2>
            <form id="registerForm" action="register.php" method="post" onsubmit="return validateRegistration()">
                <label for="name">Name:</label>
                <input type="text" id="name" name="name" autocomplete="name" required>

                <label for="email">Email:</label>
                <input type="email" id="email" name="email" autocomplete="email" required>

                <label for="password">Password:</label>
                <input type="password" id="password" name="password" autocomplete="new-password" required>

                <label for="phone">Phone:</label>
                <input type="text" id="phone" name="phone" autocomplete="tel" required>

                <label for="address">Address:</label>
                <input type="text" id="address" name="address" autocomplete="street-address" required>

                <button type="submit">Register</button>
                <p>Already have an account? <a href="login.php">Login now</a></p>
            </form>
            <p id="errorMessage"></p>
        </div>
    </div>

    <footer class="footer w3-center w3-padding-16">
        <p>&copy; 2024 Dental Clinic. All rights reserved.</p>
    </footer>
</body>
</html>
