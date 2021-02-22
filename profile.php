<?php
	ob_start();
	session_start();
	$pageTitle = "Profile";
	include "init.php";
	if (isset($_SESSION['user'])) {
	$getUser = $con->prepare("SELECT * FROM users WHERE Username = ? ");
	$getUser->execute(array($sessionUser));
	$info = $getUser->fetch();
	?>
	<h1 class="text-center">My Profile</h1>
	<div class="information block">
		<div class="container">
			<div class="panel panel-primary">
				<div class="panel-heading">My Information</div>
				<div class="panel-body">
					<ul class="list-unstyled">
						<li>
							<i class="fa fa-unlock-alt fa-fw"></i>
							<span>Name </span>: <?php echo $info['Username'];?>
						</li>
						<li>
							<i class="fa fa-envelope fa-fw"></i>
							<span>Email </span>: <?php echo $info['Email'];?>
						</li>
						<li>
							<i class="fa fa-user fa-fw"></i>
							<span>Full Name </span>: <?php echo $info['FullName'];?> 
						</li>
						<li>
							<i class="fa fa-calendar fa-fw"></i>
							<span>Register Date </span>: <?php echo $info['Date'];?> 
						</li>
						<li>
							<i class="fa fa-tags fa-fw"></i>
							<span>Favorite Categories </span>:</li>
				    </ul>
				    <a class="btn btn-default" href="#">Edit Informations</a>
				</div>
			</div>
		</div>
	</div>

	<div id="my-ads" class="Ads block">
		<div class="container">
			<div class="panel panel-primary">
				<div class="panel-heading">My Ads</div>
				<div class="panel-body">
						<?php 
							if (! empty(getItems('Member_id', $info['UserID']))){
							echo "<div class='row'>";
							foreach (getItems('Member_id', $info['UserID']) as $item) {
								echo "<div class='col-sm-6 col-md-3'>";
								   echo "<div class='thumbnail item-box'>";
								   	 if ($item['Approve'] == 0) {echo "<span class='Approve-status'>Not Approved</span>";}
								      echo "<span class='price'>$" . $item['Price']. "</span>";
								   	  echo "<img class='img-responsive' src='ecommerce.png' alt=''>";

								   	  echo "<div class='caption'>";
								   	  	 echo "<h3><a href='item.php?itemid=". $item['Item_ID'] ."'>".$item['Name']."</a></h3>";
								   	  	 echo "<p>" .$item['Description']."</p>";
								   	  	 echo "<div class='date'>" .$item['Add_Date']."</div>";

								   	  echo "</div>";
								   echo "</div>";
								echo "</div>";
							}
							echo "</div>";
						  } else {
						  		echo " There is No Ads To Show Create <a href='newad.php'>New Ad</a>";
						  }
						?>
				</div>
			</div>
		</div>
	</div>

	<div class="comment block">
		<div class="container">
			<div class="panel panel-primary">
				<div class="panel-heading">Last Comments</div>
				<div class="panel-body">
					<?php
           				 $stmt = $con->prepare("SELECT 
							                         comment
							                     FROM
							                         comments
							                    
							                     WHERE user_id = ?");
        				 $stmt->execute(array($info['UserID']));
                         $comments = $stmt->fetchAll(); 

                         if (! empty($comments)) {
                         	foreach ($comments as $comment) {
                         		echo "<p>".$comment['comment'] ."</p>";
                         	}

                         } else {
                         	echo "There is no Comments to show";
                         }

                        ?>
				</div>
			</div>
		</div>
	</div>
	
<?php	
	} else {
		header('Location: login.php');
	}

	include $tpl ."footer.php";
	ob_end_flush();
	