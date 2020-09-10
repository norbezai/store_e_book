
<?php include "header.php"; ?>

<div id="wrapper">
	<?php include "navigation.php"; ?>
	<br>
	<div class= "container close_bookmark_sidebar" id="container" >
		<div class="row" >
			<div class="col-sm-3">
				<h2>Categories</h2>
				<?php include "sidebar.php"; ?>
			</div>
			<div class="col-sm-9">
				<?php
				if(isset($_GET['category'])) {
					$category = $_GET['category'];
					$category = mysqli_real_escape_string($connection, $category);
					$product_query = "SELECT * FROM books WHERE book_status='available' AND category_id = (SELECT category_id FROM categories WHERE category_name = '$category')";
					$product_query_result = mysqli_query($connection,$product_query);
					$num_rows = mysqli_num_rows($product_query_result);
					if($num_rows==0) {
						echo "<br><br><h3 style='margin-left:30%;'><b>No Books Found for this Category</b></h3>";
					}
					if(!$product_query_result) {
						die("QUERY FAILED ".mysqli_error($connection));
					} else {
						while($product_row = mysqli_fetch_assoc($product_query_result)){
							$book_id = $product_row['book_id'];
							$book_name = $product_row['book_name'];
							$book_author = $product_row['author'];
							$book_edition = $product_row['edition'];
							$book_subject = $product_row['subject'];
							$book_price = $product_row['book_price'];
							$book_image = $product_row['book_image'];
				?>
				<div class="col-sm-6 col-md-3 col-lg-3 col-xs-6">
					<div class="thumbnail">
						<div class="w3-display-container w3-hover-opacity">
							<img src="includes/images/<?php echo $book_image ?>" alt="<?php echo $book_name ?>" style="width:100%; height: 230px;">
							<div class="w3-display-middle w3-display-hover">
								<a href="book_details.php?book_id=<?php echo $book_id?>">
									<button class="w3-button" style="background-color: #0b113e; color: white">View Details</button></a>
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
				?>

			</div>
		</div>
	</div>
</div>

<?php include "footer.php"; ?>