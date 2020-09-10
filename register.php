<?php
    function customPageHeader(){
        echo "<script type='text/javascript' src='includes/javascript/register.js'></script>";
    }
?>
<?php include "header.php"; ?>
<?php include "navigation.php"; ?>


<?php
    if(isset($_POST['submit'])){
        $username = $_POST['username'];
        $user_password = $_POST['password'];
        $user_email = $_POST['email'];
        $user_firstName = $_POST['firstname'];
        $user_lastname = $_POST['lastname'];
        $user_city = $_POST['city'];
        $user_role = "user";

        $password = mysqli_real_escape_string($connection,$user_password);
        $hash_password = password_hash($password, PASSWORD_DEFAULT);
        
        $query = "INSERT INTO 
                users(username, password, email, first_name, last_name, city, role)  
                VALUES ('$username', '$hash_password', '$user_email', '$user_firstName'
                    , '$user_lastname', '$user_city', '$user_role')";

        $query_result = mysqli_query($connection, $query);
        
        if(!$query_result){
            die('QUERY FAILED '.mysqli_error($connection));
        }else{
            include "login_modal.php";
            echo "<script>$(window).on('load', function(){
                    $('#loginModal').modal('show');
                  });</script>";
        }
       
    }
?>
<div class="container">
    <h1 class="text-center">Registration Form</h1>
    <p id="errorMsg" style='color:#F00'></p>
    <form method="post" onsubmit="return checkForm()" action="./register.php">
        <div class="row">
            <div class="col-sm-3"></div>
                <div class="col-sm-6">
                   <div class='form-group'>
                        <label for="username">Username</label>
                        <div class="input-group">
                            <span class="input-group-addon"><i class="fa fa-user"></i></span>
                            <input name="username" type="text" class="form-control" id="username" placeholder="Username" required="true">
                        </div>
                    </div>
                    <div class='form-group'>
                        <label for="passwd">Password</label>
                        <div class="input-group">
                            <span class="input-group-addon"><i class="fa fa-lock"></i></span>
                            <input name="password" type="Password" class="form-control" id="passwd" placeholder="Password" required="true"> 
                        </div>
                    </div>
                    
                    <div class='form-group'>
                        <label for="confirmpwd">Confirm Password</label>
                        <div class="input-group">
                            <span class="input-group-addon"><i class="fa fa-lock"></i></span>
                            <input onfocusout="checkPassword()"  name="confirmpassword" type="Password" class="form-control" id="confirmpwd" placeholder="Re-type password" required="true">
                        </div>
                        <p id="error_msg_confirmpwd" style="color:#F00; padding-top: 5px; display:none">ERROR!!! Password doesnt match</p> 
                    </div>
                    <div class='form-group'>
                        <label for="email">Email</label>
                        <div class="input-group">
                            <span class="input-group-addon"><i class="fa fa-envelope"></i></span>
                            <input name="email" type="Email" class="form-control" id="email" placeholder="Enter Email" required="true">
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-4">
                            <div class='form-group'>
                                <label for="fname">First Name</label>
                                <div class="input-group">
                                    <span class="input-group-addon"><i class="fa fa-user"></i></span>
                                    <input name="firstname" type="text" class="form-control" id="fname" placeholder="First name" required="true">
                                </div>
                            </div>
                        </div>    
                        <div class="col-sm-4">
                           <div class='form-group'>
                                <label for="lname">Last Name</label>
                                <div class="input-group">
                                    <span class="input-group-addon"><i class="fa fa-user"></i></span>
                                    <input name="lastname" type="text" class="form-control" id="lname" placeholder="Last name" required="true">
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="row">
                        <div class="col-sm-6">
                           <div class='form-group'>
                                <label for="city">City</label>
                                <div class="input-group">
                                    <span class="input-group-addon"><i class="fa fa-address-book"></i></span>
                                    <input name="city" type="text" class="form-control" id="city" placeholder="City" required="true">
                                </div>
                            </div>
                        </div>
                    
                    </div>
                    <div class='form-group'>
                    <input name="submit" type="submit" id="final_submit" class="btn btn-primary" value="Verify and Register">
                    </div>
                </div>
            <div class="col-sm-3"></div>
        </div>
    </form>
</div>

<?php include "footer.php"; ?>