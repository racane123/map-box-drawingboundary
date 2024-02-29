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

    // Generate OTP code
    $otp = generateOTP();

    // Store OTP in session
    $_SESSION['otp'] = $otp;

    // Send OTP code via email
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
       //Server settings
        $mail->isSMTP();
        $mail->Host       = 'smtp.elasticemail.com';  // Elastic Email SMTP server
        $mail->SMTPAuth   = true;               // Enable SMTP authentication
        $mail->Username   = 'samej.delacruz59@gmail.com';   // Your Elastic Email username
        $mail->Password   = '61E0C1F8AB49921E4F7DDFA4381121C369AD';     // Your Elastic Email API key
        $mail->SMTPSecure = 'tls';              // Enable TLS encryption; `PHPMailer::ENCRYPTION_SMTPS` encouraged
        $mail->Port       = 2525;                // TCP port to connect to Elastic Email SMTP

        //Recipients
        $mail->setFrom('samej.delacruz59@gmail.com', 'OTP CODE');
        $mail->addAddress($email);                // Add a recipient

        // Content
        $mail->isHTML(true);                     // Set email format to HTML
        $mail->Subject = 'OTP Code';
        $mail->Body    = "Your OTP code is: $otp";

        $mail->send();
    } catch (Exception $e) {
        // Handle exception
    }
}
?>
