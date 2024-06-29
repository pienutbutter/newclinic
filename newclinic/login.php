<?php
session_start();
require 'dbconnection.php';

// Check if the email and password are remembered
$remembered_email = isset($_COOKIE['user_email']) ? $_COOKIE['user_email'] : '';
$remembered_password = isset($_COOKIE['user_password']) ? $_COOKIE['user_password'] : '';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $password = $_POST['password'];
    $remember = isset($_POST['remember']);

    if (empty($username) || empty($password)) {
        echo "<script>alert('Please fill in all fields.');</script>";
        exit();
    }

    $stmt = $conn->prepare("SELECT user_id, user_name, user_email, user_password FROM tbl_users WHERE user_email = ?");
    if ($stmt === false) {
        die("Error preparing statement: " . $conn->error);
    }

    $stmt->bind_param("s", $username);
    $stmt->execute();
    $stmt->store_result();

    if ($stmt->num_rows > 0) {
        $stmt->bind_result($id, $name, $email, $hashed_password);
        $stmt->fetch();

        if (password_verify($password, $hashed_password)) {
            $_SESSION['user_id'] = $id;
            $_SESSION['user_name'] = $name;

            if ($remember) {
                // Set cookies to remember email and password
                setcookie("user_email", $username, time() + (86400 * 30), "/");
                setcookie("user_password", $password, time() + (86400 * 30), "/");

                // Display alert confirming the remember me option
                echo "<script>alert('Your email and password will be saved for future logins.');</script>";
            } else {
                // Clear cookies if remember checkbox is not checked
                setcookie("user_email", "", time() - 3600, "/");
                setcookie("user_password", "", time() - 3600, "/");
            }

            echo "<script>alert('Login successful!'); window.location.href = 'services.html';</script>";
        } else {
            echo "<script>alert('Invalid password.');</script>";
        }
    } else {
        echo "<script>alert('No user found with this email.');</script>";
    }

    $stmt->close();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Dental Clinic</title>
    <link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
    <link rel="stylesheet" href="style.css">
    <script src="validation.js"></script>
</head>
<body>
    <header class="header w3-padding-16 w3-center">
        <h1><strong>Dental Clinic</strong></h1>
    </header>

    <div class="main-content">
        <div class="form-container">
            <h2>Login</h2>
            <form id="loginForm" action="login.php" method="post" onsubmit="return validateLogin()">
                <label for="username">Email:</label>
                <input type="email" id="username" name="username" value="<?php echo $remembered_email; ?>" autocomplete="email" required>

                <label for="password">Password:</label>
                <input type="password" id="password" name="password" value="<?php echo $remembered_password; ?>" autocomplete="current-password" required>

                <div class="checkbox-container">
                    <input type="checkbox" id="remember" name="remember">
                    <label for="remember">Remember Me</label>
                </div>

                <button type="submit">Login</button>
                <p>Don't have an account? <a href="register.php">Register now</a></p>
            </form>
            <p id="errorMessage"></p>
        </div>
    </div>

    <footer class="footer w3-center w3-padding-16">
        <p>&copy; 2024 Dental Clinic. All rights reserved.</p>
    </footer>
</body>
</html>
