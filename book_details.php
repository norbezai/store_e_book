<?php
    function customPageHeader(){
        echo "<link rel='stylesheet' type='text/css' href='includes/css/book_details.css'>";
        echo "<script type='text/javascript' src='includes/javascript/book_details.js'></script>";
    }
?>

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
                header("Location: error.php");
                }
                $num_rows = mysqli_num_rows($query_result);
                if($num_rows==1){
                    while($row = mysqli_fetch_assoc($query_result)){
                        $book_name = $row['book_name'];
                        $seller_username = $row['username'];
                        $author = $row['author'];
                        $edition = $row['edition'];
                        $subject = $row['subject'];
                        $category_id = $row['category_id'];
                        $book_price = $row['book_price'];
                        $book_original_price = $row['book_original_price'];
                        $book_description = $row['book_description'];
                        $book_image = $row['book_image'];
                        $book_status = $row['book_status'];
                        $date = $row['date'];
                    }
                }
                
                //For loading category
                $query = "SELECT * FROM categories WHERE category_id = {$category_id}";
                $query_result = mysqli_query($connection,$query);
                if(!$query_result){
                    header("Location: error.php");
                }
                $num_rows = mysqli_num_rows($query_result);
                if($num_rows != 0){
                    while($row = mysqli_fetch_assoc($query_result)){
                        $category_name_temp = $row['category_name'];
                        $parent_category_id = $row['parent_category_id'];
                        if($parent_category_id == 0){
                            //IT has no parent
                            $category_name = $category_name_temp;
                        }else{
                            //get the parent category name
                            $query_parent = "SELECT * FROM categories WHERE category_id = {$parent_category_id}";
                            
                            $query_result_parent = mysqli_query($connection,$query_parent);
                            
                            if(!$query_result_parent){
                                die("FAILED" . mysqli_error($connection));
                            }else{
                                $num_rows = mysqli_num_rows($query_result_parent);
                                if($num_rows != 0){
                                    while($row_parent = mysqli_fetch_assoc($query_result_parent)){
                                        $parent_category_name = $row_parent['category_name'];
                                        
                                        $category_name = $parent_category_name . ' -> ' . $category_name_temp;
                                    }
                                }else{
                                    //some error occured, print only chid category
                                    $category_name = $category_name_temp;
                                }
                            }
                        }
                    }
                } else {
                    $category_name = "NO CATEGORY AVAILABLE";
                }
            } else {
                header('Location: ./');
            }
        ?>


<div class="container close_bookmark_sidebar" id='container'>
<div class="container" style="width: 100%;margin-left: 2%;margin-right: 2%;">
    <div class="row">
        <div class="col-lg-6 col-sm-12 col-xs-12 col-md-12" id="bookImage">
            <img style="width:50%;margin-top: 5%;margin-left: 25%;margin-right: 25%" 
                src="includes/images/<?php echo $book_image; ?>">
        </div>
        <div class="col-lg-6 col-sm-12 col-xs-12 col-md-12">
            <div style="margin-top: 5%"></div>
            <div class="bookName" style="font-size: 35px;font-weight: 550; font-family: Karla, Arial, Helvetica">
                <?php echo $book_name; ?>
            </div>
            <div class="author" style="font-size: 20px;">
                by <?php echo $author; ?>
            </div>
            <br>
            <div class="price" style="font-family: Karla, Arial, Helvetica">
                <div style="font-size: 28px">
                    <span>Was : </span><span style="text-decoration: line-through;">
                        Da <?php echo $book_original_price; ?></span>
                </div>
                <div style="font-size: 28px">
                    <span>Now : </span><span>Da <?php echo $book_price; ?></span>
                    <span id="discount" style="font-size: 12px; color: #878787; border-style: solid; border-width: 1px;padding: 4px;margin-left: 8px; color: green;border-color: green">
                        <script type="text/javascript">
                            var discount = Math.round((<?php echo $book_original_price;?> - <?php echo $book_price; ?>)*100/<?php echo $book_original_price; ?>);
                            document.getElementById('discount').innerHTML = discount+'% off';
                        </script>
                    </span>
                </div>
                <br>
            </div>

            <div class="bookReview">                
                <span>
                    <u>Review</u>
                </span>
            </div>
            <br>            
            <br>
            <br>
            <?php 
                if (isset($_SESSION['username'])) {
                    $openBuyNow = "buy_now.php";
                }
            ?>
            <div id="buynow_parent">
                <?php
                    if ($book_status == 'unavailable') {
                ?>
                    <a href="#" type="button" disabled="true" class="btn" id="buyNow" 
                        style="background-color: #666; color: white;">Buy Now</a>
				<?php
                    } else if(isset($_SESSION['username'])&&$seller_username==$_SESSION['username']) {    
				?>
                    <a type="button" data-toggle="tooltip" title="You Cannot Buy Your Own Book" 
                        class="btn" id="buyNow" style="background-color: #666; color: white;">Buy Now</a>
                <?php
                    } else if(!isset($_SESSION['username'])) {
                ?>
                    <a href="#" type="button" onclick="javascript:showLoginModal('#loginModal')" 
                        class="btn" id="buyNow" style="background-color: #666; color: white;">Buy Now</a>
				<?php
					} else {
				?>
                    <a href="<?php echo $openBuyNow ?>?book_id=<?php echo $book_id ?>" type="button" 
                        class="btn" id="buyNow" style="background-color: #666; color: white;">Buy Now</a>
				<?php	
					}
                ?>
                
            </div>
            <br>
            <br>
        </div>
    </div>
</div>
</div>

<div class="row" id="more_details">
   <div class="col-lg-6">
       <div class="container desc_container">
            <!-- Tab links -->
            <div class="tab">
              <button class="tablinks active" id="defaultOpen">DESCRIPTION</button>
            </div>
            <!-- Tab content -->
            <div id="Description" class="tabcontent">
                <div class="desc_content" style="margin-bottom: 20px;line-height:10;">
                    <p style="line-height: 2;"><font size="3">
                    <?php echo $book_description; ?></font></p>
                </div>
            </div>
        </div>
   </div>    
   <div class="col-lg-6">
       <div class="container desc_container">
            <!-- Tab links -->
            <div class="tab">
              <button class="tablinks active" id="defaultOpen">DETAILED INFO</button>
            </div>
            <!-- Tab content -->
            <div id="Description" class="tabcontent">
                <div class="desc_content" style="margin-bottom: 20px">
                    <h5><font size="4"><b>Subject:</b>&nbsp;&nbsp;
                    <?php echo $subject; ?></font></h5>
                </div>

                <div class="desc_content" style="margin-bottom: 20px">
                    <h5><font size="4"><b>Category:</b>&nbsp;&nbsp;
                    <?php echo $category_name; ?></font></h5>
                </div>

                <div class="desc_content" style="margin-bottom: 20px">
                    <h5><font size="4"><b>Book Name:</b>&nbsp;&nbsp;
                    <?php echo $book_name; ?></font></h5>
                </div>

                <div class="desc_content" style="margin-bottom: 20px">
                    <h5><font size="4"><b>Author:</b>&nbsp;&nbsp;
                    <?php echo $author; ?></font></h5>
                </div>

                <div class="desc_content" style="margin-bottom: 20px">
                    <h5><font size="4"><b>Original Price:</b>&nbsp;&nbsp;
                    <?php echo $book_original_price; ?></font></h5>
                </div>

                <div class="desc_content" style="margin-bottom: 20px">
                    <h5><font size="4"><b>Book Price:</b>&nbsp;&nbsp;
                    <?php echo $book_price; ?></font></h5>
                </div>

                <div class="desc_content" style="margin-bottom: 20px">
                    <h5><font size="4"><b>Edition:</b>&nbsp;&nbsp;
                    <?php echo $edition; ?></font></h5>
                </div>

                <div class="desc_content" style="margin-bottom: 20px">
                    <h5><font size="4"><b>Subject:</b>&nbsp;&nbsp;
                    <?php echo $subject; ?></font></h5>
                </div>

                <div class="desc_content" style="margin-bottom: 20px">
                    <h5><font size="4"><b>Category:</b>&nbsp;&nbsp;
                    <?php echo $category_name; ?></font></h5>
                </div>

                <div class="desc_content" style="margin-bottom: 20px">
                    <h5><font size="4"><b>Sold By:</b>&nbsp;&nbsp;
                    <?php echo $seller_username; ?></font></h5>
                </div>
            </div>
        </div>
   </div>
</div>

