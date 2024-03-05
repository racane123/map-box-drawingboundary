<?php
include ("../includes/template.php");
session_start();

if(!isset($_SESSION['validToChangePassword'])){
  
    header('Location:..\auth\login.php');
    exit();
}

?>

<body class="hold-transition login-page" id="background">

    <div class="login-box">
        <div class="login-logo">
            <a href="#"><b>TownTech</b>Innovations</a>
        </div>
        <!-- /.login-logo -->
        <div class="card">
            <div class="card-body login-card-body">
                <p class="login-box-msg">Create your new password</p>

                <form id="resetPassForm">
                    <div class="input-group mb-3">
                        <input type="email" class="form-control" id="email" name="email"
                            placeholder="Re-Enter your Email" required>
                        <div class="input-group-append">
                            <div class="input-group-text">
                                <span class="fas fa-envelope"></span>
                            </div>
                        </div>
                    </div>
                    <div class="input-group mb-3">
                        <input type="password" class="form-control" id="password" name="password"
                            placeholder="Your New Password">
                        <div class="input-group-append">
                            <div class="input-group-text">
                                <span class="fas fa-lock"></span>
                            </div>
                        </div>
                    </div>
                    <div class="col-8 offset-4">
                        <button class="btn btn-primary btn-block" onclick="resetPass()">Confirm</button>
                    </div>
            </div>
            </form>
        </div>
    </div>
    </div>



    <script>
    function resetPass() {

        var email = document.getElementById('email').value;
        var newPass = document.getElementById('password').value;
        $.ajax({
            url: 'resetingPass.php',
            type: 'POST',
            data: {
                email: email,
                newPass: newPass
            },
            dataType: 'json',
            success: function(response) {
                window.location.href = "../auth/login.php";   

            },
            error: function(error) {
                console.log('Error:', error);
            }


        });
    }

    </script>


</body>