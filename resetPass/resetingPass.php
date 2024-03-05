<?php
session_start();
include ('../db/dbconn.php');

if (!$conn) {
    die("Connection to the Database is not established: " . mysqli_connect_error());
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $newPass = $_POST['newPass'];

    $sql = "UPDATE users SET password = ? WHERE email = ?";
    $stmt = mysqli_prepare($conn, $sql);

    if (!$stmt) {
        $response = ['message' => 'Error preparing query: ' . mysqli_error($conn)];
        echo json_encode($response);
        exit;
    }

    $hashedNewPass = password_hash($newPass, PASSWORD_DEFAULT);
    mysqli_stmt_bind_param($stmt, "ss", $hashedNewPass, $email);
    
    if (mysqli_stmt_execute($stmt)) {
        $response = ['message' => 'Password successfully changed'];
    } else {
        $response = ['message' => 'Error executing query: ' . mysqli_error($conn)];
    }
    
    echo json_encode($response);
    mysqli_stmt_close($stmt);
} else {
    $response = ['message' => 'Invalid request method.'];
    echo json_encode($response);
}

mysqli_close($conn);
?>
