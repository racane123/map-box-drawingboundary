<?php

include('../db/dbconn.php');

// API Endpoint
$api_url = 'https://group61.towntechinnovations.com/admin/api/residents.php';

// Fetch data from API
$response = file_get_contents($api_url);

// Check if data is retrieved successfully
if ($response === false) {
    die('Failed to fetch data from API');
}

// Decode JSON response
$data = json_decode($response, true);

// Check if JSON decoding was successful
if ($data === null) {
    die('Failed to decode JSON');
}

// Prepare SQL statement to insert data
$stmt = $conn->prepare("INSERT INTO residents (ResidentID, age, gender, Occupation, height, weight, bmi, bmi_category, feature_id, brgy_no, national_id, citizenship, picture, firstname, middlename, lastname, alias, birthplace, birthdate, civilstatus, voterstatus, household_id, phone, email, address, resident_type, remarks) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");

// Bind parameters
$stmt->bind_param("iisddddssissssssssssssssssi", 
                  $ResidentID, 
                  $age, 
                  $gender, 
                  $Occupation, 
                  $height, 
                  $weight, 
                  $bmi, 
                  $bmi_category, 
                  $feature_id, 
                  $brgy_no, 
                  $national_id, 
                  $citizenship, 
                  $picture, 
                  $firstname, 
                  $middlename, 
                  $lastname, 
                  $alias, 
                  $birthplace, 
                  $birthdate, 
                  $civilstatus, 
                  $voterstatus, 
                  $household_id, 
                  $phone, 
                  $email, 
                  $address, 
                  $resident_type, 
                  $remarks);

// Insert data into database
foreach ($data['data'] as $item) {
    $ResidentID = $item['id']; // Assuming 'id' from the JSON corresponds to 'ResidentID' in the database
    $age = $item['age'];
    $gender = $item['gender'];
    $Occupation = $item['occupation']; 
    $height = ''; 
    $weight = ''; 
    $bmi = ''; 
    $bmi_category = ''; 
    $feature_id = $item['household_id']; 
    $brgy_no = $item['purok']; 
    $national_id = $item['national_id'];
    $citizenship = ''; 
    $picture = $item['picture'];
    $firstname = $item['firstname'];
    $middlename = $item['middlename'];
    $lastname = $item['lastname'];
    $alias = $item['alias'];
    $birthplace = $item['birthplace'];
    $birthdate = $item['birthdate'];
    $civilstatus = $item['civilstatus'];
    $voterstatus = $item['voterstatus'];
    $household_id = $item['household_id'];
    $phone = $item['phone'];
    $email = $item['email'];
    $address = $item['address'];
    $resident_type = $item['resident_type'];
    $remarks = $item['remarks'];
    // Execute the prepared statement
    $stmt->execute();
}

// Close statement
$stmt->close();

// Close connection
$conn->close();

echo 'Data has been fetched from the API endpoint and stored into the database.';
?>
