<?php

include "template.php";

?>

<body class="hold-transition login-page" id="background">
<div class="login-box">
  <div class="login-logo">
    <a href="../../index2.html"><b>TownTech</b>Innovations</a>
  </div>
  <!-- /.login-logo -->
  <div class="card">
    <div class="card-body login-card-body">
      <p class="login-box-msg">Sign in to start your session</p>

      <form id="loginForm">
        <div class="input-group mb-3">
          <input type="email" class="form-control" id="email" name="email" placeholder="Email" required>
          <div class="input-group-append">
            <div class="input-group-text">
              <span class="fas fa-envelope"></span>
            </div>
          </div>
        </div>
        <div class="input-group mb-3">
          <input type="password" class="form-control" id="password" name="password" placeholder="Password">
          <div class="input-group-append">
            <div class="input-group-text">
              <span class="fas fa-lock"></span>
            </div>
          </div>
        </div>
        <div class="row">
          <div class="col-8">
            <div class="icheck-primary">
              <input type="checkbox" id="remember">
              <label for="remember">
                Remember Me
              </label>
            </div>
          </div>
          <div class="col-4">
            <button type="submit" class="btn btn-primary btn-block">Sign In</button>
          </div>
        </div>
      </form>
    </div>
  </div>
</div>
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
                    setTimeout(function (){
                        if (response.role === 'admin') {
                        window.location.href="dashboard.php";
                    } else if (response.role === 'user') {
                       window.location.href="index.php";
                    }
                    }, 2200);

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

</body>

