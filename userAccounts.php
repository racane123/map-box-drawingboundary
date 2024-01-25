<div>
<h1>This is the user Account Management Area</h1>
<div class="text-right">
    <button type="button" class="btn btn-primary" onclick="DisplayForm()"><i class="fas fa-plus"></i> Add Users</button>
</div>


    <form action="register_account.php" method="POST" class="p-4 mx-auto form-container" id="form-container">
        <div class="text-right">
            <i class="fas fa-close" onclick="FormClose()"></i>
        </div>
        
        <div class="header text-center text-uppercase font-weight-bold pb-4">Register Accounts</div>
        <div class="row mb-4">
            <div class="col-md-6">
                <div data-mdb-input-init class="form-outline">
                    <input type="text" id="first_name" class="form-control" placeholder="First Name">
                </div>
            </div>

            <div class="col-md-6">
                <div class="form-outline">
                    <input type="text" id="middle_name" class="form-control" placeholder="Last Name">
                </div>
            </div>
        </div>

        <div class="form-outline mb-4">
            <input type="email" id="email" class="form-control" placeholder="Email">
        </div>

        <div class="form-outline mb-4">
            <input type="password" id="password" class="form-control" placeholder="Password">
        </div>

        <div class="mb-4">
            <label for="role" class="form-label">Role:</label>
            <select name="role" id="role" class="form-select">
                <option value="admin">Admin</option>
                <option value="user">User</option>
            </select>
        </div>

        <div class="text-center">
            <button type="submit" class="btn btn-primary">Submit</button>
        </div>
    </form>

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
}
</style>


<script>

function DisplayForm(){
    document.getElementById("form-container").style.display="block"
}

function FormClose(){
    document.getElementById("form-container").style.display="none"
}
</script>