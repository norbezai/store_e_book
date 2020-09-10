
<?php include "header.php"; ?>
<?php include "navigation.php"; ?>

<!--View User details-->
<?php  
	$query = "SELECT * FROM users WHERE username='".addslashes($_SESSION['username'])."'";
	$details_set = mysqli_query($connection, $query);
	if(!$details_set){
            die("QUERY FAILED ".mysqli_error($connection));
    } else {
        $detail_row = mysqli_fetch_assoc($details_set);
        // $username = $detail_row['username'];
        $user_email = $detail_row['email'];
        // $password = $detail_row['password'];
        $firstName = $detail_row['first_name'];
        $lastName = $detail_row['last_name'];
        $city = $detail_row['city'];
    }

?>

  <div class="container">
    <h1 class="text-center"><?php echo $_SESSION['username']?>'s details</h1>
    <form>
        <div class="row">
            <div class="col-sm-3"></div>
                <div class="col-sm-6">
                    <label for="email">Email</label>
                    <div class="input-group">
                        <span class="input-group-addon"><i class="fa fa-envelope"></i></span>
                        <input type="Email" class="form-control" id="email" value="<?php echo $user_email?>" 
                            placeholder="Email ID" disabled> 
                    </div>
                    <div class="row">
                        <div class="col-sm-4">
                            <label for="fname">First Name</label>
                            <div class="input-group">
                                <span class="input-group-addon"><i class="fa fa-user"></i></span>
                                <input name="fname" type="text" class="form-control" id="fname" value="<?php echo $firstName?>" 
                                    placeholder="First name" disabled>
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
                                <input type="text" class="form-control" id="city" value="<?php echo $city?>" 
                                    placeholder="City" disabled>
                            </div>
                        </div>
                    </div>
                    <br>
                    <div class="row">
                        <div class="row">
                            <div class="col-sm-6">
                                <a href="edit_details.php" class="btn btn-primary form-control">
                                    <i class="glyphicon glyphicon-edit"> Edit</i></a>
                            </div>

                        </div>
                    </div>
                <!-- </div> -->
            <div class="col-sm-3"></div>
        </div>
    </form>
</div>
