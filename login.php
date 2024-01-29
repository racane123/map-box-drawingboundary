<?php
include_once "header.php";


?>
<form id="loginForm">
        <label for="username">Username:</label> 
        <input type="text" id="email" name="email" required><br>

        <label for="password">Password:</label>
        <input type="password" id="password" name="password" required><br>

        <input type="submit" value="Login">
    </form>

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
                        '<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>' +
                        '</div>';

                $('#loginForm').before(alertHTML);

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