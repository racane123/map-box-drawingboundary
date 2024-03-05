  <?php

include ("../includes/template.php");
session_start();
function verifyJWT($token, $secretKey) {
  $tokenParts = explode('.', $token);
  if (count($tokenParts) === 3) {     
      $payload = json_decode(base64_decode($tokenParts[1]), true); 
      if (isset($payload['exp']) && isset($payload['email'])) {     
          $signature = base64_decode($tokenParts[2]);
          $expectedSignature = hash_hmac('sha256', $tokenParts[0] . '.' . $tokenParts[1], $secretKey, true);
          if (hash_equals($signature, $expectedSignature)) {
              
              if (time() <= $payload['exp']) {
                  return $payload['email']; 
              }
          }
      }
  }
  return null; 
}

if (isset($_GET['token'])) {
  $token = $_GET['token'];
  $secretKey = '1306da56dce50f3b7e89dd11adb8626f308997d8a5df1080cd32b83c0eac120b';
  $email = verifyJWT($token, $secretKey);
  if ($email !== null) {
      session_start();
      $_SESSION['email'] = $email;
      header("Location: ../admin/dashboard.php");
      exit();
  } else {

      echo "Invalid token";
  }
} else {

  //echo "Token not provided";
}

if(isset($_SESSION['email'])) {
    // If already logged in, redirect to the appropriate page based on role
    if ($_SESSION['role'] === 'admin') {
        header("Location: ../admin/dashboard.php");
        exit;
    } else if ($_SESSION['role'] === 'user') {
        header("Location: index.php");
        exit;
    }
    else if ($_SESSION['role'] === 'driver'){
      header("Location: ../driver/driver-map.php");
      exit;
    }
}

  ?>

  <style>

  </style>

  <body class="hold-transition login-page" id="background">
      <div id="liveAlertPlaceholder" class="alert alert-primary" role="alert" style="display: none;">
          OTP sent to your email. Please check your Inbox/Spam.
      </div>
      <div class="login-box">
          <div class="login-logo">
              <a href="login.php"><b>TownTech</b>Innovations</a>
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
                          <input type="password" class="form-control" id="password" name="password"
                              placeholder="Password">
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
                  <div>
                      <a href="forgot_password.php">forgot password?</a>
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


                      '<div class="col-4 offset-8">' +
                      '<button type="submit" class="btn btn-primary btn-block">Sign In</button>' +
                      '</div>' +
                      '</div>';

                  $('#loginForm').append(otpField);


              },
              error: function(error) {
                  console.log('Error:', error);
              }
          });

      }


      $(document).ready(function() {
          $('#loginForm').submit(function(e) {
              e.preventDefault();

              // Gather form data
              var formData = $(this).serialize();

              // Check if "Remember Me" checkbox is checked
              var rememberMe = $('#remember').is(':checked');

              // Send AJAX request
              $.ajax({
                  url: 'authentication.php',
                  type: 'POST',
                  data: formData + '&remember=' +
                  rememberMe, // Pass remember value to the server
                  dataType: 'json', // Assuming the response is in JSON format
                  success: function(response) {
                      var alertClass = response.message.includes("successful") ?
                          'alert-success' : 'alert-danger';
                      var alertHTML = '<div class="alert ' + alertClass +
                          ' alert-dismissible fade show" role="alert" id="Close">' +
                          response.message +
                          '<button type="button" class="btn-close text-left" data-bs-dismiss="alert" aria-label="Close" onclick="fClose()">X</button>' +
                          '</div>';

                      $('#background').before(alertHTML);

                      if (response.message.includes("successful")) {
                          // Check the role and redirect accordingly
                          setTimeout(function() {
                              if (response.role === 'admin') {
                                  window.location.href = "../admin/dashboard.php";
                              } else if (response.role === 'user') {
                                  window.location.href = "../index.php";
                              } else if (response.role === 'driver') {
                                  window.location.href = "../driver/driver-map.php";
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

      function hideLiveAlert() {
          document.getElementById("liveAlertPlaceholder").style.display = "none";
      }

      function fClose() {
          document.getElementById('Close').style.display = "none";
      }
      </script>

  </body>