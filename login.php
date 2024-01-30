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
        <label for="username">Username:</label> 
        <input type="text" id="email" name="email" required><br>

        <label for="password">Password:</label>
        <input type="password" id="password" name="password" required><br>

        <input type="submit" class="btn btn-primary" value="Login">
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
                dataType: 'text',
                success: function(response) {
                    // Display the result with Bootstrap alert styling
                    var alertClass = response.includes("successful") ? 'alert-success' : 'alert-danger';
                    var alertHTML = '<div class="alert ' + alertClass + ' alert-dismissible fade show" role="alert">' +
                        response +
                        '<button type="button" class="btn-close text-left" data-bs-dismiss="alert" aria-label="Close" id="Close">X</button>' +
                        '</div>';

                $('#background').before(alertHTML);

                // Redirect on successful login
                if (response.includes("successful")) {
                    setTimeout(function() {
                            window.location.href = 'dashboard.php';
                        }, 4000);
                }
            },
            error: function(error) {
                console.log('Error:', error);
            }
        });
    });
});
</script>

<style>

@import url('https://fonts.googleapis.com/css2?family=Bree+Serif&family=Roboto:ital,wght@0,100;0,300;0,400;0,500;0,700;0,900;1,100;1,300;1,400;1,500;1,700;1,900&display=swap');
.login-form{
    display:flex;
    justify-content: space-around;
    padding-top:100px;
    flex-wrap:wrap;

}

.login-logo{
    font-family: "Bree Serif", serif;
    font-weight: 400;
    font-style: normal;
    font-size:50px;
}

#loginForm{
    padding-top:80px;
    display:flex;
    flex-direction:column;
    width:300px;
    
}

#loginForm input{
    padding:5px;
    border-radius: 5px;
    border:1px solid #000;
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