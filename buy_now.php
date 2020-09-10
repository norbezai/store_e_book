
<?php include "header.php"; ?>
<div id="wrapper">
<?php include "navigation.php"; ?>

<div class= "container close_bookmark_sidebar" id="page-content-wrapper" style="margin: 0px; padding: 0px">
<?php 
	if(isset($_GET['book_id'])){
        $book_id = $_GET['book_id'];
        $query = "SELECT * FROM books WHERE book_id = $book_id";
        
        $query_result = mysqli_query($connection,$query);
        
        if(!$query_result){
            die('QUERY FAILED '.mysqli_error($connection));
        }
        else{
            $row = mysqli_fetch_assoc($query_result);
            $book_name = $row['book_name'];
            $seller_username = $row['username'];
            $book_price = $row['book_price'];
            $book_image = $row['book_image'];
        }
	    
	    $userQuery = "SELECT * FROM users WHERE username = '{$seller_username}'";
	    $userResult = mysqli_query($connection,$userQuery);
	    if(!$userResult){
            die('QUERY FAILED '.mysqli_error($connection));
        }
        else{
            $user_row = mysqli_fetch_assoc($userResult);
            $firstName = $user_row['first_name'];
            $lastName = $user_row['last_name'];
    	}
	}
?>
<div class="container close_bookmark_sidebar" id='container'>
    <div class="container" style="margin-top: 10px;">
        <div class="row">
            <div class="col-sm-4" id="bookImage">
                <img style="width:100%;" src="includes/images/<?php echo $book_image; ?>">
            </div>
            <div class="col-sm-8">
                <div class="row">
                    <div class="col-sm-5">
                    	<div style="font-size: 35px;font-weight: 550; font-family: Karla, Arial, Helvetica">
                            <span><?php echo $book_name; ?></span><br>
                        </div>
                        <div class="price" style="font-family: Karla, Arial, Helvetica, sans-serif; font-size: 28px; ">
                            <span>Da <?php echo $book_price; ?></span>
                        </div>
                        <div style="font-size: 20px; font-family: Karla, Arial, Helvetica">
                            <label for="seller_username">Username: </label>
                            <span id="seller_username"><?php echo $seller_username ?></span><br>
                            <label for="name">Name: </label>
                            <span id="name"><?php echo $firstName; ?> <?php echo $lastName; ?></span><br>
                        </div>
                    </div>
                    <div class="col-sm-7">
                        <form method="post" action="">
                            <div class="form-group">
                                <label for="sel1">Payment Method:</label>
                                <select class="form-control" name="payment_method" id="sel1">
                                    <option>None</option>
                                    <option>Cash</option>
                                    <option>Net Banking</option>
                                    <option>Freecharge</option>
                                </select>
                            </div>

                            <div class="form-group">
                                <label for="sel2">Delivary Method:</label>
                                <select class="form-control" name="delivary_method" id="sel2">
                                    <option>None</option>
                                    <option>Personal</option>
                                    <option>Courier</option>
                                </select>
                            </div>

                            <input type="submit" id="order" class="btn btn-primary form-control" value="Order" name="order">
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


<!-- adding detials in buyer table -->
    <?php 
        if (isset($_SESSION['username'])) {
            $username = $_SESSION['username'];
        }
        if (isset($_POST['order'])) {
            
            $book_id=$_GET['book_id'];
            
            $payment_method = $_POST['payment_method'];
            $delivary_method = $_POST['delivary_method'];
            $query = "INSERT INTO buyers VALUES('{$username}','{$book_name}','{$seller_username}',now(),'{$book_price}','{$payment_method}')";
            $query_result = mysqli_query($connection,$query);
            
            if(!$query_result){
                die('QUERY FAILED '.mysqli_error($connection));
            }else{
                echo "<h2>Book ordered</h2>";
                echo "<script type='text/javascript'>
                        document.getElementById('order').setAttribute('value', 'Ordered');
                        var att = document.createAttribute('disabled');
                        att.value = 'disabled';
                        document.getElementById('order').setAttributeNode(att);
                        document.getElementById('order').style.backgroundColor = 'red';
                    </script>";
                
                //make book status unavailable
                $updateQuery = "UPDATE books SET book_status='unavailable' WHERE book_id = $book_id";
                $updateResult =  mysqli_query($connection,$updateQuery);
                if(!$updateResult){
                        die('QUERY FAILED '.mysqli_error($connection));
                }   
            }
        }
    ?>


<?php include "footer.php"; ?>