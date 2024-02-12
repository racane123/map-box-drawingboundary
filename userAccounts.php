<div class="text-center">
<div class="text-right">
    <button type="button" class="btn btn-primary" onclick="DisplayForm()"><i class="fas fa-plus"></i> Add Users</button>
</div>

    <form class="p-4 mx-auto form-container" id="form-container">
        <div class="text-right">
            <i class="fas fa-close" onclick="FormClose()"></i>
        </div>
        
        <div class="header text-center text-uppercase font-weight-bold pb-4">Register Accounts</div>
        <div class="row mb-4">
            <div class="col-md-6">
                <div data-mdb-input-init class="form-outline">
                    <input type="text" id="first_name" class="form-control" placeholder="First Name" name="firstname">
                </div>
            </div>

            <div class="col-md-6">
                <div class="form-outline">
                    <input type="text" id="last_name" class="form-control" placeholder="Last Name" name="lastname">
                </div>
            </div>
        </div>

        <div class="form-outline mb-4">
            <input type="email" id="email" class="form-control" placeholder="Email" name="email" required>
        </div>

        <div class="form-outline mb-4">
            <input type="password" id="password" class="form-control" placeholder="Password" name="password" required>
        </div>

        <div class="mb-4">
            <label for="role" class="form-label">Role:</label>
            <select id="role" class="form-select" name="role" required>
                <option value="admin">Admin</option>
                <option value="user">User</option>
            </select>
        </div>

        <div class="text-center">
            <button type="submit" class="btn btn-primary" id="submitBtn">Submit</button>
        </div>
    </form>

    <div id="results"></div>
    <!---Table of User Data-->
    <div class="container mt-5">
    <table class="table table-bordered" id="userTable">
        <thead class="thead-dark">
            <tr class="text-center">
                <th>First Name</th>
                <th>Last Name</th>
                <th>Email</th>
                <th>Password</th>
                <th>Role</th>
            </tr>
        </thead>
        <tbody id="userData">
        </tbody>
    </table>
</div>
</div>

<style>
.form-container {
    border-style:solid;
    border-color:#172663;
    border-radius:10px;
    background-color: #b5c2f7;
    width: 40%;
    position: absolute;
    right:25%;
    display: none;
    cursor: pointer;
}
</style>


<script>


function submitForm(event) {
    event.preventDefault();

    var formData = {
        'first_name': $('#first_name').val(),
        'last_name': $('#last_name').val(),
        'email': $('#email').val(),
        'password': $('#password').val(),
        'role': $('#role').val()
    };

    $.ajax({
        type: 'POST',
        url: 'register_account.php', 
        data: formData,
        dataType: 'json',
        encode: true,
        success: function(xhr,response) {
            console.log(response)
            $('#results').text("Successful Submiting the data");
        },
        error: function(xhr, status, error){
            console.error(xhr.responseText)
            $('#results').text("Error Submitting the Data")
        }
    });

    location.reload();
}


$('#form-container').submit(submitForm);



function DisplayForm(){
    document.getElementById("form-container").style.display="block"
}

function FormClose(){
    document.getElementById("form-container").style.display="none"
}



function displayUsers() {
            $.ajax({
                url: 'displayUser.php',
                type: 'GET',
                dataType: 'json',
                success: function(data) {
                    // Clear previous data
                    $('#userData').empty();

                    // Iterate through the received data and append to the table
                    $.each(data, function(index, user) {
                        $('#userData').append('<tr><td>' + user.first_name + '</td><td>' + user.last_name + '</td><td>' + user.email + '</td><td>' + user.password + '</td><td>' + user.role +'</td></tr>');
                    });
                },
                error: function(error) {
                    console.log('Error fetching data:', error);
                }
            });
        }

        // Call the function to display users when the page loads
        $(document).ready(function() {
            displayUsers();
            });


</script>