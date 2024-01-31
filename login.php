<?php

session_start();
include_once "header.php";


?>

<body id="background">

<div class="login-form">
    <div class="login-logo text-center">
        <img src="images/logo-text.png" alt="Logo" >
        <div class="text-logo">TownTech Innovations</div>
    </div>
<form id="loginForm">
        <div class="mb-3">
        <label for="username" class="form-label">Username:</label> 
        <input type="text" id="email" class="form-control" name="email" required>
        </div>
        <div class="mb-3">
        <label for="password" class="form-label">Password:</label>
        <input type="password" id="password" name="password" class="form-control" required>
        </div>
        <div class="mb-3">
        <input type="submit" class="btn btn-primary" value="Login">
        </div>
        
</form>
</div>
</body>


<script>



$(document).ready(function() {
    $('#loginForm').submit(function(e) {
        e.preventDefault();

        // Gather form data
        var formData = $(this).serialize();

        // Send AJAX request
        $.ajax({
            url: 'authentication.php',
            type: 'POST',
            data: formData,
            dataType: 'json',  // Assuming the response is in JSON format
            success: function(response) {
                var alertClass = response.message.includes("successful") ? 'alert-success' : 'alert-danger';
                var alertHTML = '<div class="alert ' + alertClass + ' alert-dismissible fade show" role="alert" id="Close">' +
                    response.message +
                    '<button type="button" class="btn-close text-left" data-bs-dismiss="alert" aria-label="Close" onclick="fClose()">X</button>' +
                    '</div>';

                $('#background').before(alertHTML);

                if (response.message.includes("successful")) {
                    // Check the role and redirect accordingly
                    if (response.role === 'admin') {
                        window.location.href = 'dashboard.php';
                    } else if (response.role === 'user') {
                        window.location.href = 'index.php';
                    }
                }
            },
            error: function(error) {
                console.log('Error:', error);
            }
        });
    });
});


function fClose(){
    document.getElementById('Close').style.display="none";
}
</script>

<style>

@import url('https://fonts.googleapis.com/css2?family=Bree+Serif&family=Roboto:ital,wght@0,100;0,300;0,400;0,500;0,700;0,900;1,100;1,300;1,400;1,500;1,700;1,900&display=swap');
.login-form{
    display:flex;
    justify-content: space-around;
    padding-top:100px;
    flex-wrap:wrap;

}

#loginForm{
    padding-top: 80px;
}

.login-logo{
    font-family: "Bree Serif", serif;
    font-weight: 400;
    font-style: normal;
    font-size:50px;
}

#background{
    color:#fff;
    background-color:#001845;
    height:650px;
}

#Close{
    border:none;
}


</style>