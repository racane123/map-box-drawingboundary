<?php
session_start();
include_once "dbconn.php";

if (!$conn) {
    die("Connection to the Database is not established: " . mysqli_connect_error());
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $email = $_POST['email'];
    $password = $_POST['password'];

    $sql = "SELECT * FROM users WHERE email = ?";
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, "s", $email);
    mysqli_stmt_execute($stmt);

    $result = mysqli_stmt_get_result($stmt);

    $user = mysqli_fetch_assoc($result);

    if ($user && password_verify($password, $user['password'])) {
        $_SESSION['email'] = $user['email'];
        $_SESSION['role'] = $user['role'];
        // Successful login
        $response = [
            'message' => "Login successful! Welcome, $email!",
            'role' => $user['role'],
        ];
        echo json_encode($response);
    } else {
        // Failed login
        $response = ['message' => "Invalid username or password. Please try again."];
        echo json_encode($response);
    }

    // Close the statement
    mysqli_stmt_close($stmt);
}

mysqli_close($conn);
?>
