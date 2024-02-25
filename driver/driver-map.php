<?php
session_start();


?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Driver Account</title>
</head>
<body>
    <h1>drivers-map</h1>
<aside>
<?php
if(isset($_SESSION['email'])){
    echo 'Welcome back: '.$_SESSION['email'];    
}
?>
</aside>




</body>
</html>