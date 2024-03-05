<?php

// Semaphore API credentials
$api_key = 'YOUR_SEMAPHORE_API_KEY'; // Replace with your Semaphore API key
$sender_id = 'YOUR_SENDER_ID'; // Replace with your Semaphore sender ID

// Recipient's phone number
$recipient_number = '+1234567890'; // Replace with the recipient's phone number

// Generate OTP
$otp = generateOTP();

// Prepare message content
$message = "Your OTP code is: $otp";

// Prepare API request data
$data = [
    'apikey' => $api_key,
    'number' => $recipient_number,
    'message' => $message,
    'sendername' => $sender_id
];

// Initialize cURL session
$ch = curl_init();

// Set cURL options
curl_setopt($ch, CURLOPT_URL, 'https://semaphore.co/api/v4/messages');
curl_setopt($ch, CURLOPT_POST, true);
curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($data));
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

// Execute cURL request
$response = curl_exec($ch);

// Close cURL session
curl_close($ch);

// Check if message was sent successfully
if ($response === false) {
    echo 'Error: Failed to send OTP code via Semaphore.';
} else {
    echo 'OTP code sent successfully via Semaphore.';
}

// Function to generate OTP code
function generateOTP() {
    // Generate a random 6-digit OTP code
    return str_pad(mt_rand(0, 999999), 6, '0', STR_PAD_LEFT);
}
