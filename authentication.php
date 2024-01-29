<?php
include_once "dbconn.php";

if(!$conn){
    die("Connection to the Database is not stablished". pg_last_error($conn));
}
if($_SERVER['REQUEST_METHOD'] == 'POST' ){
    $email = $_POST['email'];
    $password = $_POST['password'];
    
    $sql = "SELECT * FROM users WHERE email = $1";
    $result = pg_query_params($conn,$sql, [$email]);

    $user = pg_fetch_assoc($result);

    if ($user && password_verify($password, $user['password'])) {
        // Successful login
        echo "Login successful! Welcome, $email!";
    } else {
        // Failed login
        echo "Invalid username or password. Please try again.";
    }

}


pg_close($conn);
?>
