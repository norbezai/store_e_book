
<?php include "header.php"; ?>
<?php include "navigation.php"; ?>

<!--Update User details-->
<?php  
    if (isset($_SESSION['edit_detail'])) {
        echo'<div class="alert alert-success alert-dismissible">
                <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                <strong>Success!</strong> Changes Made!!!
              </div>';
         $_SESSION['edit_detail'] = null;
    }
?>

<?php
    if(isset($_POST['submit'])) {
        $username = $_SESSION['username'];
        $user_city = $_POST['city'];
        $first_name = $_POST['fname'];
        $prepare_stmt = $connection->prepare("UPDATE users SET first_name=?, city=? WHERE username=?");
        $prepare_stmt->bind_param("iss", $first_name, $user_city, $username);

        if(!$prepare_stmt->execute()) {
            die("QUERY FAILED ".mysqli_error($connection));
            $prepare_stmt->close();
        } else {
            $_SESSION['edit_detail'] = 'true';
            $prepare_stmt->close();
            $redirect_url = "http://{$_SERVER['HTTP_HOST']}"."{$_SERVER['REQUEST_URI']}";
            header("Location: $redirect_url");
        }
    }
?>

<!--View User details-->
<?php  
	$query = "SELECT * FROM users WHERE username='".addslashes($_SESSION['username'])."'";
	$details_set = mysqli_query($connection, $query);
	if(!$details_set){
            die("QUERY FAILED ".mysqli_error($connection));
    } else {
        $detail_row = mysqli_fetch_assoc($details_set);
        $username = $detail_row['username'];
        $password = $detail_row['password'];
        $firstName = $detail_row['first_name'];
        $lastName = $detail_row['last_name'];
        $city = $detail_row['city'];
    }

?>

  <div class="container">
    <h1 class="text-center"><?php echo $_SESSION['username']?>'s details</h1>
    <form method="post" action="./edit_details.php">
        <div class="row">
            <div class="col-sm-3"></div>
                <div class="col-sm-6">
                    <label for="email">Email</label>
                    <div class="input-group">
                        <span class="input-group-addon"><i class="fa fa-envelope"></i></span>
                        <input type="Email" class="form-control" id="email" value="<?php echo $username?>" 
                            placeholder="Email ID" disabled> 
                    </div>
                    <div class="row">
                        <div class="col-sm-4">
                        <label for="fname">First Name</label>
                            <div class="input-group">
                            <span class="input-group-addon"><i class="fa fa-user"></i></span>

                                <input name="fname" type="text" class="form-control" id="fname" 
                                    value="<?php echo $city?>" placeholder="First name">
                            </div>
                        </div>
                        <div class="col-sm-4">
                            <label for="lname">Last Name</label>
                            <div class="input-group">
                                <span class="input-group-addon"><i class="fa fa-user"></i></span>
                                <input type="text" class="form-control" id="lname" value="<?php echo $lastName?>" 
                                    placeholder="Last name" disabled>
                            </div>
                        </div>
                    </div>
                    
                    <div class="row">
                        <div class="col-sm-6">
                            <label for="city">City</label>
                            <div class="input-group">
                                <span class="input-group-addon"><i class="fa fa-address-book"></i></span>
                                <input name="city" type="text" class="form-control" id="city" 
                                    value="<?php echo $city?>" placeholder="City">
                            </div>
                        </div>
                    </div><br>
                    <div class="row">
                        <div class="col-sm-6 form-group">
                            <input name="submit" type="submit" class="form-control btn btn-primary" value="Save Changes">
                        </div>
                    </div>
                </div>
            <div class="col-sm-3"></div>
        </div>
    </form>
</div>
