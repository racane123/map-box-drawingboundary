<?php
require '../PHPMailer/src/Exception.php';
require '../PHPMailer/src/PHPMailer.php';
require '../PHPMailer/src/SMTP.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

session_start();
include ('../db/dbconn.php');

if (!$conn) {
    die("Connection to the Database is not established: " . mysqli_connect_error());
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $email = mysqli_real_escape_string($conn, $_POST['email']);

    $otp = generateOTP();
   
    $_SESSION['otp'] = $otp;

    sendOTP($email, $otp);

    $response = [
        'message' => "OTP sent to your email. Please check your inbox.",
        'otp_sent' => true
    ];
    echo json_encode($response);

} else {
    $response = ['message' => "Invalid request method."];
    echo json_encode($response);
}

mysqli_close($conn);

// Function to generate OTP code
function generateOTP() {
    // Generate a random 6-digit OTP code
    return str_pad(mt_rand(0, 999999), 6, '0', STR_PAD_LEFT);
}

// Function to send OTP code via email
function sendOTP($email, $otp) {
    $mail = new PHPMailer(true);
    try {
      
        $mail->isSMTP();
        $mail->Host       = 'smtp.gmail.com';  
        $mail->SMTPAuth   = true;           
        $mail->Username   = 'samej.delacruz59@gmail.com';   
        $mail->Password   = 'ygmz ebex pilm kmhd';    
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;       
        $mail->Port       = 465;            


        $mail->setFrom('samej.delacruz59@gmail.com', 'OTP CODE');
        $mail->addAddress($email);              

       
        $mail->isHTML(true);               
        $mail->Subject = 'OTP Code';
        $mail->Body    = "Your OTP code is: $otp";

        $mail->send();
    } catch (Exception $e) {
       
    }
}
?>
