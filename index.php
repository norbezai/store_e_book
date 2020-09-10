    
<?php include "header.php"; ?>
<style type="text/css">
    .viewMore {
        height: 300px;
        background-color: #d5e6f3
    }
    .books {
        padding-right: 15px;
        padding-left: 5px;
    }
</style>

<?php 
    if (isset($_SESSION['username'])) {
        $username = $_SESSION['username'];
        $verify_query = "SELECT * FROM users WHERE username = '{$username}'";
        
        $verify_query_result = mysqli_query($connection, $verify_query);
        
        if(!$verify_query_result) {
            die("FAILED" . mysqli_error($connection));
        } else {
            $verify_row = mysqli_fetch_assoc($verify_query_result);
            $email_id = $verify_row['email'];
            $username = $verify_row['username'];
        }
    }
?>
<div id="wrapper">
    <?php include "navigation.php"; ?>
    <br>
    <div class="container close_bookmark_sidebar" id='container'>
        <div class="row" >
            <div class="col-sm-3">
                <h2>Categories</h2>
                <?php include "sidebar.php"; ?>
            </div>
            <div class="col-sm-9">
            
            <?php
                $query = "SELECT * FROM categories WHERE parent_category_id = 0";
                $category_result = mysqli_query($connection,$query);
                if(!$category_result) {
                    die("QUERY FAILED ".mysqli_error($connection));
                } else {
                    while($category_row = mysqli_fetch_assoc($category_result)) {
                        $category_id = $category_row['category_id'];
                        $category_name = $category_row['category_name'];

                        $all_category_ids = array();
                        $all_category_ids[] = $category_id;

                        $sub_query = "SELECT * FROM categories WHERE parent_category_id = {$category_id}";
                        $sub_query_result = mysqli_query($connection,$sub_query);
                        if(!$sub_query_result) {
                            die("QUERY FAILED ".mysqli_error($connection));
                        } else {
                            while($sub_query_row = mysqli_fetch_assoc($sub_query_result)) {
                                $sub_category_id = $sub_query_row['category_id'];
                                $all_category_ids[] = $sub_category_id;
                            }
                        }
                        $title_printed = false;
                        
                        foreach ($all_category_ids as $single_category_id) {
                            $product_query = "SELECT * FROM books WHERE category_id = {$single_category_id} AND book_status='available' ORDER BY date DESC";
                            $product_query_result = mysqli_query($connection,$product_query);
        
                            if(!$product_query_result){
                                die("QUERY FAILED ".mysqli_error($connection));
                            } else {
                                $num_products = mysqli_num_rows($product_query_result);
                                if($num_products != 0) {
                                    if(!$title_printed) {
                                        $count = 0;
                                        echo "<h3>{$category_name}</h3>";
                                        //row div started
                                        echo "<div class='row'>";
                                        $title_printed = true;
                                    }

                                    while($count < 4 && $product_row = mysqli_fetch_assoc($product_query_result)) {
                                        $count = $count + 1;
                                        $book_id = $product_row['book_id'];
                                        $book_name = $product_row['book_name'];
                                        $book_author = $product_row['author'];
                                        $book_edition = $product_row['edition'];
                                        $book_subject = $product_row['subject'];
                                        $book_price = $product_row['book_price'];
                                        $book_image = $product_row['book_image'];
            ?>
                                        <div class="books col-sm-6 col-md-3 col-lg-3 col-xs-6">
                                            <div class="thumbnail">
                                                <div class="w3-display-container w3-hover-opacity">
                                                    <img src="includes/images/<?php echo $book_image ?>" 
                                                        alt="<?php echo $book_name ?>" style="width:100%; height: 230px;">
                                                    <div class="w3-display-middle w3-display-hover">
                                                        <a href="book_details.php?book_id=<?php echo $book_id?>">
                                                            <button class="w3-button" style="background-color: #0b113e; color: white">
                                                                View Details</button></a>
                                                    </div>
                                                </div>
                                                <div class="caption" style="height: 60px; border-top: 5px solid blue">
                                                    <p align="center"><?php echo $book_name ?></p>
                                                </div>
                                            </div>
                                        </div>
            <?php
                                    }
                                }
                            }
                        }
                        if($title_printed) {
                            //row div end
                            echo "</div>";
                        }
                    }
                }
            ?>
		</div>
    </div>
</div>

<?php include "footer.php"; ?>
