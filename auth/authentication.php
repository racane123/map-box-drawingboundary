<?php
session_start();
include ('../db/dbconn.php');

if (!$conn) {
    die("Connection to the Database is not established: " . mysqli_connect_error());
}

if (isset($_POST['remember'])) {
    setcookie('rememberedEmail', $_POST['email'], time() + (86400 * 30), "/"); // 30 days
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $password = mysqli_real_escape_string($conn, $_POST['password']);

    $sql = "SELECT * FROM users WHERE email = ?";
    $stmt = mysqli_prepare($conn, $sql);

    mysqli_stmt_bind_param($stmt, "s", $email);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    $user = mysqli_fetch_assoc($result);

    if ($user && password_verify($password, $user['password'])) {
        // Check if OTP verification is required
        if (isset($_SESSION['otp']) && isset($_POST['otp'])) {
            $otp = $_POST['otp'];
            // Verify OTP
            if ($otp == $_SESSION['otp']) {
                // OTP is correct, proceed with login
                session_regenerate_id(true);
                $_SESSION['email'] = $user['email'];
                $_SESSION['role'] = $user['role'];
                $response = [
                    'message' => "Login successful! Welcome, $email!",
                    'role' => $user['role'],
                ];
                // Remove OTP from session after successful login
                unset($_SESSION['otp']);
            } else {
                $response = ['message' => "Invalid OTP. Please try again."];
            }
        } else {
            $response = ['message' => "OTP verification required."];
        }
    } else {
        $response = ['message' => "Invalid username or password. Please try again."];
    }

    echo json_encode($response);

    mysqli_stmt_close($stmt);
} else {
    $response = ['message' => "Invalid request method."];
    echo json_encode($response);
}

mysqli_close($conn);
?>
