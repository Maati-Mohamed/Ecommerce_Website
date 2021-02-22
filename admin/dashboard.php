<?php
ob_start(); // Output Buffering start
session_start();
$pageTitle = "Dashboard";
if (isset($_SESSION['Username'])) {
	include 'init.php';
	/* Start Dashboard Page */
	 $numUsers = 5; // Number OF Last Users
	 $letastUsers = getLatest("*","users","UserID",$numUsers); //Latese User Array
	 $numItems = 6; // Number OF Last Items
	 $letastItems = getLatest("*","items","Item_ID",$numItems);
	 $numComments = 4;
	?>
	<div class="container home-stats text-center">
		<h1>Dashborad</h1>
		<div class="row">
			<div class="col-md-3">
				<div class="stat st-member"> <i class="fa fa-users"></i>
				 	<div class="info">
				 	   Total Member
				       <span><a href="member.php"><?php echo countItem('UserID','users') ?>
				       </a></span>
				 	</div>
				</div>
			</div>
			<div class="col-md-3">
				<div class="stat st-pending">
					<i class="fa fa-user-plus"></i>
					  <div class="info">
						 Pending Member
						 <span><a href="member.php?do=Manage&page=Pending">
						 <?php echo checkItem('RegStatus','users',0);?>
						 </a></span>
				      </div>
			    </div>
			</div>
			<div class="col-md-3">
				<div class="stat st-item">
					<i class="fa fa-tag"></i>
					   <div class="info">
						 Total Items
						 <span><a href="items.php"><?php echo countItem('Item_ID','items') ?></a></span>
				       </div>
				</div>
			</div>
			<div class="col-md-3">
				<div class="stat st-comment">
					<i class="fa fa-comments"></i>
					   <div class="info">
						 Total Comments
						 <span>
						 	<a href="comments.php"><?php echo countItem('c_id','comments') ?></a>
						 </span>
				       </div>
				</div>
			</div>
		</div>
	</div>
	<div class="container letast">
		<div class="row">
			<div class="col-sm-6">
				<div class="panel panel-default">
					<div class="panel-heading">
						<i class="fa fa-users"></i> Letast <?php echo $numUsers;?> Register Users
						<span class="toggle-info pull-right">
							<i class="fa fa-plus fa-lg"></i>
						</span>
					</div>
					<div class="panel-body">
						<ul class="list-unstyled letast-users">
							<?php
							if (! empty($letastUsers )){
								foreach ($letastUsers as $user) {
								 echo '<li>';
								  echo $user['Username'];
								   echo "<a href='member.php?do=Edit&userid=". $user['UserID']." '>";
								   echo "<span class='btn btn-success pull-right'>";
								     echo "<i class='fa fa-edit'></i>Edit ";
								      if($user['RegStatus'] == 0){
											echo "<a href='member.php?do=Activate&userid=".$user['UserID']. " 'class='btn btn-info activate pull-right'><i class='fa fa-check'></i>Activate</a>";
										};
								   echo"</span>";
								   echo "</a>";
								 echo "</li>";
								}
							} else {
								echo "<div class='nice-messege'>";
									echo "There is no users to show";
								echo "</div>";
							}
							?>
					    </ul>
					</div>
				</div>
			</div>
			<div class="col-sm-6">
				<div class="panel panel-default">
					<div class="panel-heading">
						<i class="fa fa-tag"></i> Letast <?php echo $numItems;?> Items
						<span class="toggle-info pull-right">
							<i class="fa fa-plus fa-lg"></i>
						</span>
					</div>
					<div class="panel-body">
						<ul class="list-unstyled letast-users">
							<?php
							if (! empty($letastItems )){
								foreach ($letastItems as $item) {
								 echo '<li>';
								  echo $item['Name'];
								   echo "<a href='items.php?do=Edit&itemid=". $item['Item_ID']." '>";
								   echo "<span class='btn btn-success pull-right'>";
								     echo "<i class='fa fa-edit'></i> Edit ";
								      if($item['Approve'] == 0){
											echo "<a href='items.php?do=Approve&itemid=".$item['Item_ID']. " 'class='btn btn-info activate pull-right'><i class='fa fa-check'></i> Approve</a>";
										};
								   echo"</span>";
								   echo "</a>";
								 echo "</li>";
								}
							} else{
								echo "<div class='nice-messege'>";
									echo "There is no items to show";
								echo "</div>";
							}
							?>
					    </ul>
					</div>
				  </div>
			   </div>
			</div>
			<!-- Start Letest Comment -->
			<div class="row">
			<div class="col-sm-6">
				<div class="panel panel-default">
					<div class="panel-heading">
						<i class="fa fa-comments"></i> Letast <?php echo $numComments;?> Comments
						<span class="toggle-info pull-right">
							<i class="fa fa-plus fa-lg"></i>
						</span>
					</div>
					<div class="panel-body">
				<?php
            		$stmt = $con->prepare("SELECT 
                      comments.*,users.Username AS Member
                     FROM
                        comments
                     INNER JOIN
                        users
                     ON 
                        users.UserID = comments.user_id 
                     ORDER BY 
                     	c_id DESC
                     LIMIT $numComments ");
			        $stmt->execute();
			        $comments = $stmt->fetchAll();

			        if (! empty($comments )){
				        foreach ($comments as $comment) {

				        	echo '<div class="comment-box">';
				        		echo '<span class="member-n">' .$comment["Member"].'</span>';
				        		echo '<p class="member-c">' .$comment['comment'].'</p>';
				        	echo '</div>';
				        }
				     }else{
				     	echo "<div class='nice-messege'>";
							echo "There is no comments to show";
						echo "</div>";
				     }
        		?>
					
					</div>
				</div>
			</div>

			</div>
			<!--End Letest Comment -->
		</div>
	</div>
	<?php
	/* Start Dashboard Page */
	include $tpl ."footer.php";

} else {
    header('Location:index.php');
    exit();
}
ob_end_flush();

?>
