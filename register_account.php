<?php
session_start();
include_once('dbconn.php');

if (isset($_POST['first_name'], $_POST['last_name'], $_POST['email'], $_POST['password'], $_POST['role'])) {

    $form_data = array();
    $form_data['first_name'] = mysqli_real_escape_string($conn, $_POST['first_name']);
    $form_data['last_name'] = mysqli_real_escape_string($conn, $_POST['last_name']);
    $form_data['email'] = mysqli_real_escape_string($conn, $_POST['email']);
    $form_data['password'] = password_hash($_POST['password'], PASSWORD_DEFAULT);
    $form_data['role'] = mysqli_real_escape_string($conn, $_POST['role']);

    $sql = "INSERT INTO users (first_name, last_name, email, password, role) VALUES (?, ?, ?, ?, ?)";

    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, "sssss", $form_data['first_name'], $form_data['last_name'], $form_data['email'], $form_data['password'], $form_data['role']);

    $response = mysqli_stmt_execute($stmt);

    if ($response) {
        echo json_encode($form_data);
    } else {
        echo "Error inserting data. " . mysqli_error($conn);
    }

    mysqli_stmt_close($stmt);
} else {
    echo "No data has been inserted";
}
?>
