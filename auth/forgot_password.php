<?php
include ("../includes/template.php");
?>

<style>

</style>

<body class="hold-transition login-page" id="background">
    <div id="liveAlertPlaceholder" class="alert alert-primary" role="alert" style="display: none;">
        OTP sent to your email. Please check your Inbox/Spam.
    </div>
    <div class="login-box">
        <div class="login-logo">
            <a href="#"><b>TownTech</b>Innovations</a>
        </div>
        <!-- /.login-logo -->
        <div class="card">
            <div class="card-body login-card-body">
                <p class="login-box-msg">Enter your Valid Email</p>

                <form id="forgotPassForm">
                    <div class="input-group mb-3">
                        <input type="email" class="form-control" id="email" name="email" placeholder="Email" required>
                        <div class="input-group-append">
                            <div class="input-group-text">
                                <span class="fas fa-envelope"></span>
                            </div>
                        </div>
                    </div>
                </form>
                <div class="col-4 offset-8">
                    <button class="btn btn-primary btn-block" id="nextButton" onclick="sendOtp()">NEXT</button>
                </div>
                <div class="d-flex justify-content-center">
                    <div class="spinner-border" role="status" id="spinner" style="display: none;">
                        <span class="visually-hidden">Loading...</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script>
    function sendOtp() {
        var email = document.getElementById('email').value;
        document.getElementById("nextButton").style.display = "none";
        document.getElementById('spinner').style.display = 'inline-block';
        $.ajax({
            url: 'phpmailer.php',
            type: 'POST',
            data: {
                email: email
            },
            success: function(response) {
                document.getElementById("liveAlertPlaceholder").style.display = "block";
                setTimeout(hideLiveAlert, 9000);

                console.log(response)
                document.getElementById('spinner').style.display = 'none';

                var otpField = '<div class="input-group mb-3">' +
                    '<input type="text" class="form-control" id="otp" name="otp" placeholder="Code -> Mail Inbox/Spam" required>' +
                    '<div class="input-group-append">' +
                    '<div class="input-group-text">' +
                    '<span class="fas fa-lock"></span>' +
                    '</div>' +
                    '</div>' +
                    '</div>' +
                    '<div class="col-8 offset-4">' +
                    '<button  class="btn btn-primary btn-block" id"forgotPassForm" >Change password</button>' +
                    '</div>' +
                    '</div>';

                $('#forgotPassForm').append(otpField);


            },
            error: function(error) {
                console.log('Error:', error);
            }
        });

    }


    $(document).ready(function() {
        $('#forgotPassForm').submit(function(e) {
            e.preventDefault();
            var email = document.getElementById('email').value;
            var otp = document.getElementById('otp').value;

            // Send AJAX request
            $.ajax({
                url: 'forgot_pass_auth.php',
                type: 'POST',
                data: {
                    email: email,
                    otp: otp
                },
                dataType: 'json',
                success: function(response) {
                    var alertClass = response.message.includes("successful") ?
                        'alert-success' : 'alert-danger';
                    var alertHTML = '<div class="alert ' + alertClass +
                        ' alert-dismissible fade show" role="alert" id="Close">' +
                        response.message +
                        '<button type="button" class="btn-close text-left" data-bs-dismiss="alert" aria-label="Close" onclick="fClose()">X</button>' +
                        '</div>';

                    $('#background').before(alertHTML);
                    setTimeout(function() {
                        window.location.href = "../resetPass/resetPass.php";
                    }, 2000);

                },
                error: function(error) {
                    console.log('Error:', error);
                }
            });
        });

    });


    function hideLiveAlert() {
        document.getElementById("liveAlertPlaceholder").style.display = "none";
    }

    function fClose() {
        document.getElementById('Close').style.display = "none";
    }
    </script>

</body>