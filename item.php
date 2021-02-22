<?php
	ob_start();
	session_start();
	$pageTitle = "Show Item";
	include "init.php"; 
	 //Check if get request userid numeric 
    $itemid1 = isset($_GET['itemid']) && is_numeric($_GET['itemid']) ? intval($_GET['itemid']): 0;

    // select all data depent on this id
    $stmt =$con->prepare("SELECT
	                               items.*,categories.Name AS category_name,users.Username
	                           FROM 
	                               items
	                           INNER JOIN 
	                               categories 
	                           ON 
	                               categories.ID = items.Cat_ID 
	                           INNER JOIN 
	                               users 
	                           ON 
	                               users.UserID = items.Member_ID
    						 WHERE 
    						 	Item_ID = ?
    						 AND
    						 	Approve = 1");

    //execute query 
    $stmt->execute(array($itemid1));

    $count = $stmt->rowCount();

    if ($count > 0) {

    // fetch the data
    $item =$stmt->fetch();

	?>
	
	<h1 class="text-center"><?php echo $item['Name']; ?></h1>
	<div class="container">
		<div class="row">
			<div class="col-md-3">
				<img class='img-responsive img-thumbnail center-block' src='ecommerce.png' alt=''>
			</div>
			<div class="col-md-9 item-info">
				<h2><?php echo $item['Name']; ?></h2>
				<p><?php echo $item['Description']; ?></p>
				<ul class="list-unstyled">
					<li>
						<i class="fa fa-calendar fa-fw"></i>
						Added_Date : <?php echo $item['Add_Date']; ?>
					</li>
					<li>
						<i class="fa fa-user fa-fw"></i>
						Price : $<?php echo $item['Price']; ?>
					</li>
					<li>
						<i class="fa fa-building fa-fw"></i>
						Made In : <?php echo $item['Country_Made']; ?>
					</li>
					<li>
						<i class="fa fa-tags fa-fw"></i>
						Category : <a href="categories.php?pageid=<?php echo $item['Cat_ID'];?>"><?php echo $item['category_name']; ?></a>
					</li>
					<li>
						<i class="fa fa-user fa-fw"></i>
						Added By : <a href="#"><?php echo $item['Username']; ?></a>
					</li>
					<li>
						<i class="fa fa-user fa-fw"></i>
						Tags : 
						<?php 
							$allTags = explode(",", $item['tags']);
							foreach ($allTags as $tag) {
								$tag = str_replace(' ', '', $tag);
								$lowertag = strtolower($tag);
								if (! empty($tag)) { 
								echo "<a href='tags.php?name={$lowertag}'>".$tag.'</a> | ';
								}
							}
						?>
					</li>
				</ul>
			</div>
		</div>
		<!---------Start Add comment------------>
		<hr class="custom-hr">
		<?php if(isset($_SESSION['user'])) {

		?>
		<div calss="row">
			<div class="col-md-offset-3">
				<div class="add-comment">
					<h3>Add Your Comment</h3>
					<form action="<?php echo $_SERVER['PHP_SELF'].'?itemid='.$item['Item_ID']?>" method="POST">
						<textarea name="comment" required="required"></textarea>
						<input type="submit" class="btn btn-primary" value="Add Comment">
					</form>
					<?php 
						if ($_SERVER['REQUEST_METHOD'] == 'POST') {
							
							$comment = filter_var($_POST['comment'],FILTER_SANITIZE_STRING);
							$itemid  = $item['Item_ID'];
							$userid  = $_SESSION['uid'];
							
							if (! empty($comment)) {
								$stmt2 =$con->prepare("INSERT INTO 

														comments(comment,status,comment_date,item_id,user_id)

														 VALUES(:zcomment, 0, NOW(), :zitemid, :zuserid)");
								$stmt2->execute(array(

									'zcomment' => $comment,
									'zitemid'  => $itemid,
									'zuserid'  => $userid

								));

								if ($stmt2) {
									echo "<div class='alert alert-success'>Comment Added</div>";
								}
							}
						}
					?>
				</div>
			</div>
		</div>
		<?php } else {

			echo "<a href='login.php'>Login</a> Or <a href='login.php'>Reister </a>To Add Comment";

		} ?>
		<!---------Start Add comment------------>
		<hr class="custom-hr">
		<?php
			$stmt = $con->prepare("SELECT 
										comments.*,users.Username AS Member
								   FROM
								   		comments
								
								   INNER JOIN
								   		users
								   ON 
								   		users.UserID = comments.user_id 
								   WHERE 
								   		item_id = ?
								   AND 
								   		status = 1
								   ORDER BY 
								   		c_id DESC");
			$stmt->execute(array($item['Item_ID']));
			$comments = $stmt->fetchAll();
			
			?>
		 <?php foreach ($comments as $comment) { ?>
				<div class="comment-box">
					<div class='row'>
						<div class='col-sm-2 text-center'>
							<img class='img-responsive img-thumbnail center-block' src='ecommerce.png' alt=''>
							<?php echo $comment['Member']; ?>
						</div>
						<div class='col-sm-10'>
							<p class="lead"><?php echo $comment['comment']; ?></p>
						</div>
				   </div>
				</div>
				<hr class="custom-hr">

			<?php } ?>
		</div>
	</div>
		
<?php	

	} else {
		echo "There Is No Such Id Or this item not appproved";
	}
	include $tpl ."footer.php";

	ob_end_flush();

