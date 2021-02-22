<?php
	session_start();
	include 'init.php';

	$pageTitle= 'Comments';  

		if(isset($_SESSION['Username'])) {
		
			// include 'init.php';

			$do = isset($_GET['do']) ? $_GET['do'] : 'Manage';

			// Start Comments page hello

			if($do == 'Manage'){ //Comments member page

				$stmt = $con->prepare("SELECT 
											comments.*,items.Name AS Item_Name,users.Username AS Member
									   FROM
									   		comments
									   INNER JOIN 
									   		items
									   ON 
									   		items.Item_ID = comments.item_id
									   INNER JOIN
									   		users
									   ON 
									   		users.UserID = comments.user_id 
									   ORDER BY 
									   		c_id DESC");
				$stmt->execute();
				$rows=$stmt->fetchAll();
				if (! empty($rows)){

			 	?>

				<h1 class="text-center">Comments Page</h1>
				<div class="container">
					<table class="table-responsiv">
					 <table class="main-table text-center table table-bordered">
						<tr>
							<td>ID</td>
							<td>Comment</td>
							<td>Item Name</td>
							<td>Username</td>
							<td>Added Data</td>
							<td>control</td>
						</tr>
				
						<?php
						 	foreach ($rows as $rows) {
						 		echo "<tr>";
						 			echo "<td>".$rows['c_id']."</td>";
						 			echo "<td>".$rows['comment']."</td>";
						 			echo "<td>".$rows['Item_Name']."</td>";
						 			echo "<td>".$rows['Member']."</td>";
						 			echo "<td>".$rows['comment_date']."</td>";
						 			echo "<td> 

						 					<a href='comments.php?do=Edit&comid=".$rows['c_id']. " 'class='btn btn-success'><i class='fa fa-edit'></i> Edit</a>

											<a href='comments.php?do=Delete&comid=".$rows['c_id']. " 'class='btn btn-danger confirm'><i class='fa fa-close'></i> Delete</a>";

											if($rows['status'] == 0){
												echo "<a href='comments.php?do=Approve&comid=".$rows['c_id']. " 'class='btn btn-info activate'><i class='fa fa-check'></i> Approve</a>";
											};

						 				  echo "</td>";
						 		echo "</tr>";
						 	}
  								
						?>
					 </table>
					</table>
				</div>
				<?php } else {
                  echo "<div class='container'>";
                    echo "<div class='nice-messege'>";
                       echo "There is no Comments to show";
                    echo "</div>";
                  echo "</div>";
              } ?>

				

			<?php
			
			}elseif($do == 'Edit'){ // Edit page

			    //check if get request userid numeric 
				$comid = isset($_GET['comid']) && is_numeric($_GET['comid']) ? intval($_GET['comid']): 0;
				// select all data depent on this id
				$stmt =$con->prepare("SELECT * FROM comments WHERE c_id = ?");

				//execute query 
				$stmt->execute(array($comid));
				// fetch the data
				$row =$stmt->fetch();

		 		$count =$stmt->rowCount();

		 		//if there is such id show the form 

		 		if($stmt->rowCount() > 0){  ?>
				 <h1 class="text-center">Edit Commment</h1>
				 <div class="container">
					<form class="form-horizontal" action="?do=Update" method="POST">
						<input type="hidden" name="comid" value="<?php echo $comid ?>">

						<!--start Comment name -->
						<div class="form-group form-group-lg">
							<label class="col-sm-2 control-labal">Comment</label>
							<div class="col-sm-10  col-md-4">
								<textarea class="form-control" name="comment"><?php echo $row['comment']?></textarea>
							</div>
						</div>
						<!--End Comment name -->
						<!--start button -->
						<div class="form-group">
							<div class="col-sm-offset-2 col-sm-10">
								<input type="submit" value ="save" class="btn btn-primary btn-lg">
							</div>
						</div>
						<!--End button-->

					</form>
		<?php
				//if there is no such id show error

			    } else {
			      echo "<div class='container'>";

			 	  $theMsg = "<div class='alert alert-danger'>Error there is no id like this</div>";
			 	  redirectHome ($theMsg,'back');
			 	  echo "</div>";
				  }

		   }elseif($do == 'Update'){ //update page

		   		echo "<h1 class='text-center'>Update Comment</h1>";
		   		echo "<div class='container'>";
		   		if($_SERVER['REQUEST_METHOD'] == 'POST'){
		   		//get varibale from form 
		   			$comid     = $_POST['comid'];
		   			$comment   = $_POST['comment'];

	   			 	// Update the database with this info 

			   		$stmt =$con->prepare("UPDATE comments SET comment = ? WHERE c_id = ?");
			   		$stmt->execute(array($comment,$comid));

	   				// echo success messege

	   				$theMsg = "<div class='alert alert-success'>". $stmt->rowCount() . ' Record Update</div>';

	   				 redirectHome($theMsg, 'back');


		   		}else{

		   			$theMsg = "<div class='alert alert-danger'>You cant browse this page dirictly</div>";
		   			redirectHome($theMsg, 'back');
		   		}
		   	echo "</div>";

		}   elseif($do == 'Delete'){ // Delet page 

			 //check if get request comid numeric 
			  $comid = isset($_GET['comid']) && is_numeric($_GET['comid']) ? intval($_GET['comid']): 0;
			  $check = checkItem('c_id','comments',$comid);

		 		//If there is such id show the form 

		 		if( $check > 0){ 

		 			echo "<h1 class='text-center'>Delete Comment</h1>";
		   		    echo "<div class='container'>";
			 			
			 			$stmt= $con->prepare("DELETE FROM comments WHERE c_id = :zid");
			 			$stmt->bindParam(":zid",$comid);
			 			$stmt->execute();


			   				// Echo success messege

			   			$theMsg = "<div class='alert alert-success'>". $stmt->rowCount() . ' Record Deleted</div>';
			   			redirectHome ($theMsg, 'back');

				 		}else{
				 			echo "<div class='container'>";
				 			$theMsg = '<div class="alert alert-danger">this id is not exist</div>';
				 			redirectHome ($theMsg, 'back');
				 			echo "</div>";
				 		}

		 		    echo "</div>";

		    } elseif($do == 'Approve'){
		      //Check if get request comid numeric 
			  $comid = isset($_GET['comid']) && is_numeric($_GET['comid']) ? intval($_GET['comid']): 0;
			  $check = checkItem('c_id','comments',$comid);

		 		//If there is such id show the form 

		 		if( $check > 0){ 

		 			echo "<h1 class='text-center'>Approve Comment</h1>";
		   		    echo "<div class='container'>";
		 			
		 			$stmt= $con->prepare("UPDATE comments SET status = 1 WHERE c_id = ?");
		 			$stmt->execute(array($comid));
		   			// Echo success messege
		   			$theMsg = "<div class='alert alert-success'>". $stmt->rowCount() . ' Comment Approved</div>';
		   			redirectHome ($theMsg, 'back');

			 		}else{
			 			echo "<div class='container'>";
			 			$theMsg = '<div class="alert alert-danger">This id is not exist</div>';
			 			redirectHome ($theMsg, 'back');
			 			echo "</div>";
			 		}

		 		    echo "</div>";
		    }
			include $tpl ."footer.php";
		  }else{
		    header('Location:index.php');
		    exit();
	        }

?>
