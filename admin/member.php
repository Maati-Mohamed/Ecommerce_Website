<?php

	session_start();

	include 'init.php';


	$pageTitle= 'Member';  

		if(isset($_SESSION['Username'])) {
		
			// include 'init.php';

			$do = isset($_GET['do']) ? $_GET['do'] : 'Manage';

			// Start manage page 

			if($do == 'Manage'){ //manage member page
				$query = '';
				if(isset($_GET['page']) && $_GET['page'] == 'Pending'){
					$query = 'AND RegStatus = 0';
				}

				$stmt = $con->prepare("SELECT * FROM users WHERE GroupID != 1 $query ORDER BY UserID DESC");
				$stmt->execute();
				$rows=$stmt->fetchAll();
				if (! empty($rows)){

			 ?>

				<h1 class="text-center">Manage Members Page</h1>
				<div class="container">
					<table class="table-responsiv">
					 <table class="main-table manage-member text-center table table-bordered">
						<tr>
							<td>#ID</td>
							<td>avatar</td>
							<td>Usarname</td>
							<td>Email</td>
							<td>FullName</td>
							<td>Register Data</td>
							<td>control</td>
						</tr>
				
						<?php
						 	foreach ($rows as $rows) {
						 		echo "<tr>";
						 			echo "<td>".$rows['UserID']."</td>";
						 			echo "<td>";
						 			     if (empty($rows['avatar'])) {
						 			     	echo "no image";
						 			     } else {
						 			     	echo "<img src='uploads/avatar/" . $rows['avatar'] . "'>";
						 			     }

						 			echo "</td>";
						 			echo "<td>".$rows['Username']."</td>";
						 			echo "<td>".$rows['Email']."</td>";
						 			echo "<td>".$rows['FullName']."</td>";
						 			echo "<td>".$rows['Date']."</td>";
						 			echo "<td> 

						 					<a href='member.php?do=Edit&userid=".$rows['UserID']. " 'class='btn btn-success'><i class='fa fa-edit'></i> Edit</a>

											<a href='member.php?do=Delete&userid=".$rows['UserID']. " 'class='btn btn-danger confirm'><i class='fa fa-close'></i> Delete</a>";

											if($rows['RegStatus'] == 0){
												echo "<a href='member.php?do=Activate&userid=".$rows['UserID']. " 'class='btn btn-info activate'><i class='fa fa-check'></i> Activate</a>";
											};

						 				  echo "</td>";
						 		echo "</tr>";
						 	}
  								
						?>
					 </table>
					</table>
					<a href='member.php?do=Add' class="btn btn-primary"><i class="fa fa-plus"></i> New Member</a>
				</div>
				<?php
				} else {
              echo "<div class='container'>";
                echo "<div class='nice-messege'>";
                  echo "There is no Member to show";
                echo "</div>";
                 echo "<a href='member.php?do=Add' class='btn btn-primary'><i class='fa fa-plus'></i> New Member</a>";
              echo "</div>"; }
				
?>
			<?php
			}elseif($do == 'Add'){ ?>
				<h1 class="text-center">Add New Member</h1>
				 <div class="container">
					<form class="form-horizontal" action="?do=Insert" method="POST" enctype="multipart/form-data">
			
						<!--start user name -->
						<div class="form-group form-group-lg">
							<label class="col-sm-2 control-labal">Username</label>
							<div class="col-sm-10  col-md-4">
								<input type="text" name="username" class="form-control" autocomplete="off" placeholder="Username to login" required="required">
							</div>
						</div>
						<!--End user name -->
						<!--start Password -->
						<div class="form-group form-group-lg">
							<label class="col-sm-2 control-labal">Password</label>
							<div class="col-sm-10 col-md-4">
								<input type="password" name="password" class="password form-control" autocomplete="new-password" placeholder="Password must be complex" required="required">
								<i class="fa fa-eye show-pass"></i>
							</div>
						</div>
						<!--End Password-->
						<!--start Email -->
						<div class="form-group form-group-lg">
							<label class="col-sm-2 control-labal">Email</label>
							<div class="col-sm-10 col-md-4">
								<input type="email" name="email" class="form-control" autocomplete="off"  placeholder="Your Email" required="required">
							</div>
						</div>
						<!--End Email -->
						<!--start Full Name -->
						<div class="form-group form-group-lg">
							<label class="col-sm-2 control-labal">Full Name</label>
							<div class="col-sm-10 col-md-4">
								<input type="text" name="full" class="form-control" autocomplete="off" placeholder="Your Name" required="required">
							</div>
						</div>
						<!-- End Full Name -->
						<!--start Avatar Name -->
						<div class="form-group form-group-lg">
							<label class="col-sm-2 control-labal">User Avatar</label>
							<div class="col-sm-10 col-md-4">
								<input type="file" name="avatar" class="form-control" >
							</div>
						</div>
						<!--End  Avatar -->

						<!--start button -->
						<div class="form-group">
							<div class="col-sm-offset-2 col-sm-10">
								<input type="submit" value ="Add Member" class="btn btn-primary btn-lg">
							</div>
						</div>
						<!--End button-->

					</form>
				</div>


				
			<?php
		    } elseif($do == 'Insert') {
		    	
		   		if ($_SERVER['REQUEST_METHOD'] == 'POST') {
		   			echo "<h1 class='text-center'>Insert Member</h1>";
		   		    echo "<div class='container'>";

		   		 // Varibale Uplode

		   		    $avatarName = $_FILES['avatar']['name'];
		   		    $avatarSize = $_FILES['avatar']['size'];
		   		    $avatarTmp  = $_FILES['avatar']['tmp_name'];
		   		    $avatartype = $_FILES['avatar']['type'];

		   		 // List Of Allowed File Typed To Uplode
	
		   		    $avatarAllowedExtension = array("jpeg","jpg","png","gif");

		   		    //$avatarExtension = strtolower(end(explode('.',$avatarName)));

		   		    $avatar1 = explode('.', $avatarName);
		   		    $avatar1 = end($avatar1);
		   		    $avatar1 = strtolower($avatar1); 

		   		//Get varibale from form 
		   			
		   			$user   = $_POST['username'];
		   			$pass   = $_POST['password'];
		   			$email  = $_POST['email'];
		   			$name   = $_POST['full'];

		   			$hashdpass = sha1($_POST['password']);

		   			 // validate the form 
		   			 $formErrors =array();
		   			 if (strlen($user) <  4) {
		   			 	$formErrors[] = "Username can not be less than<strong> 4 character</strong>";	
		   			 }
		   			 if (strlen($user) >  20) {
		   			 	$formErrors[] = "Username can not be more than<strong> 20 character</strong>";	
		   			 }

		   			 if (empty($user)) {
		   			 	 $formErrors[] = "Username can not be<strong> Empty</strong>";
		   			 }
		   			 if (empty($pass)) {
		   			 	 $formErrors[] = "Password can not be<strong> Empty</strong>";
		   			 }
		   			  if (empty($email)) {
		   			 	 $formErrors[] = "Email can not be<strong> Empty</strong>";
		   			 }
		   			  if (empty($name)) {
		   			 	 $formErrors[] = "FullName can not be<strong> Empty</strong>";
		   			 }
		   			 if (! empty($avatar1) && ! in_array($avatar1,$avatarAllowedExtension)) {
		   			 	$formErrors[] = "This Extenation is not<strong> Allowed</strong>";
		   			 }
		   			 if (empty($avatar1)) {
		   			 	$formErrors[] = "Avatar Is <strong> Required</strong>";
		   			 }
		   			 if ($avatarSize > 4194304) {
		   			 	$formErrors[] = "Avatar Cant Be More <strong>4MB</strong>";
		   			 }



		   			 foreach ($formErrors as $error) {
		   			 	echo '<div class="alert alert-danger">'.$error."</div>";
		   			 } 

		   			 if(empty($formErrors)){
		   			 			   	
		   			 	$avatar = rand(0 , 100000).'_'.$avatarName;
		   			 	
		   			 	move_uploaded_file($avatarTmp, "uploads/avatar/".$avatar);


		   			 	
		   			   $check = checkItem('Username','users', $user);

		   			 	if($check == 1){

		   			 		$theMsg = "<div class='alert alert-danger'> sorry this user is exsit in database </div>";
		   			 		redirectHome($theMsg, 'back'); 
		   			 	 }else{ 


					   			 //Insert userinfo into database
					   			 	$stmt=$con->prepare("INSERT INTO 
					   			 							users(Username,Password,Email,FullName,RegStatus,Date,avatar)
					   			 						    VALUES(:zuser, :zpass, :zemail, :zname,1,now(),:zavatar )");
					   			 	$stmt->execute(array(

					   			 		'zuser'		=> $user,
					   			 		'zpass'		=> $hashdpass,
					   			 		'zemail'	=> $email,
					   			 		'zname'		=> $name,
					   			 		'zavatar'	=> $avatar


					   			 	));
					   			 // echo success messege

					   				$theMsg = "<div class='alert alert-success'>". $stmt->rowCount() . ' Record Insert</div>';

					   				 redirectHome($theMsg, 'back'); 
					   			 } 

					   		} 


		   		   }else{
		   		   		echo "<div class='container'>";

			   			$theMsg = "<div class='alert alert-danger btn-block'>you cant browse this page dirictly</div>";

			   			redirectHome($theMsg, 'back');
			   			 echo "</div>";
		   		     }
		   	  echo "</div>";

		      

			}elseif($do == 'Edit'){ // Edit page

			    //check if get request userid numeric 
				$userid = isset($_GET['userid']) && is_numeric($_GET['userid']) ? intval($_GET['userid']): 0;
				// select all data depent on this id
				$stmt =$con->prepare("SELECT * FROM users WHERE UserID = ? LIMIT 1");

				//execute query 
				$stmt->execute(array($userid));
				// fetch the data
				$row =$stmt->fetch();

		 		$count =$stmt->rowCount();

		 	

		 		//if there is such id show the form 

		 		if($stmt->rowCount() > 0){  ?>
				 <h1 class="text-center">Edit Member</h1>
				 <div class="container">
					<form class="form-horizontal" action="?do=Update" method="POST">
						<input type="hidden" name="userid" value="<?php echo $userid ?>">

						<!--start user name -->
						<div class="form-group form-group-lg">
							<label class="col-sm-2 control-labal">Username</label>
							<div class="col-sm-10  col-md-4">
								<input type="text" name="username" value="<?php echo $row['Username']?>" class="form-control" autocomplete="off" required="required">
							</div>
						</div>
						<!--End user name -->
						<!--start Password -->
						<div class="form-group form-group-lg">
							<label class="col-sm-2 control-labal">Password</label>
							<div class="col-sm-10 col-md-4">
								<input type="hidden" name="oldpassword" value="<?php echo $row['Password']?>">
								<input type="password" name="newpassword" class="form-control" autocomplete="new-password" placeholder="Leave Blank If You Dont Want To Change ">
							</div>
						</div>
						<!--End Password-->
						<!--start Email -->
						<div class="form-group form-group-lg">
							<label class="col-sm-2 control-labal">Email</label>
							<div class="col-sm-10 col-md-4">
								<input type="email" name="email" value="<?php echo $row['Email']?>" class="form-control" autocomplete="off" required="required">
							</div>
						</div>
						<!--End Email -->
						<!--start Full Name -->
						<div class="form-group form-group-lg">
							<label class="col-sm-2 control-labal">Full Name</label>
							<div class="col-sm-10 col-md-4">
								<input type="text" name="full" value="<?php echo $row['FullName']?>" class="form-control" autocomplete="off" required="required">
							</div>
						</div>
						<!--Full Name -->

						<!--start button -->
						<div class="form-group">
							<div class="col-sm-offset-2 col-sm-10">
								<input type="submit" value ="save" class="btn btn-primary btn-lg">
							</div>
						</div>
						<!--End button-->

					</form>
				</div>

		<?php
				//if there is no such id show error

			    } else {
			      echo "<div class='container'>";

			 	  $theMsg = "<div class='alert alert-danger'>Error there is no id like this</div>";
			 	  redirectHome ($theMsg,'back');
			 	  echo "</div>";
				  }

		   }elseif($do == 'Update'){ //update page

		   		echo "<h1 class='text-center'>Update Member</h1>";
		   		echo "<div class='container'>";
		   		if($_SERVER['REQUEST_METHOD'] == 'POST'){
		   		//get varibale from form 
		   			$id     = $_POST['userid'];
		   			$user   = $_POST['username'];
		   			$email  = $_POST['email'];
		   			$name   = $_POST['full'];

		   			// Password 
		   			 $pass ='';
		   			 if(empty($_POST['newpassword'])){
		   			 	$pass= $_POST['oldpassword'];
		   			 }else {
		   			 	$pass= sha1($_POST['newpassword']);
		   			 }

		   			 // validate the form 
		   			 $formErrors =array();
		   			 if(strlen($user) <  4){
		   			 	$formErrors[] = "<div class='alert alert-danger'>Username can not be less than<strong> 4 character</strong></div>";	
		   			 }
		   			 if(strlen($user) >  20){
		   			 	$formErrors[] = "<div class='alert alert-danger'>Username can not be more than<strong> 20 character</strong></div>";	
		   			 }

		   			 if(empty($user)){
		   			 	 $formErrors[] = "<div class='alert alert-danger'>Username can not be<strong> Empty</strong></div>";
		   			 }
		   			  if(empty($email)){
		   			 	 $formErrors[] = "<div class='alert alert-danger'>Email can not be<strong> Empty</strong></div>";
		   			 }
		   			  if(empty($name)){
		   			 	 $formErrors[] = "<div class='alert alert-danger'>FullName can not be<strong> Empty</strong></div>";
		   			 }

		   			 foreach ($formErrors as $error) {
		   			 	echo $error;
		   			 }

		   			 //check if there is no error proced opretion
		   			if(empty($formErrors)){

		   			 	$stmt2 = $con->prepare("SELECT * FROM users WHERE Username = ? AND UserID != ?");
		   			 	$stmt2->execute(array($user,$id));
		   			 	$count = $stmt2->rowCount();

		   			 	if ($count == 1){
		   			 		 $theMsg2 = "<div class='alert alert-danger'>Sorry This User Is Exsit In Database</div>";
		   			 		redirectHome($theMsg2, 'back');
		   			 	}else{
		   			 	    // Update the database with this info 

					   		$stmt =$con->prepare("UPDATE users SET Username = ?, Email = ? , FullName = ?, Password = ? WHERE UserID = ?");
					   		$stmt->execute(array($user,$email,$name,$pass,$id));

			   				// echo success messege
			   				$theMsg = "<div class='alert alert-success'>". $stmt->rowCount() . ' Record Update</div>';


			   				 redirectHome($theMsg, 'back');
			   				}
		   			 }


		   		}else{

		   			$theMsg = "<div class='alert alert-danger'>You cant browse this page dirictly</div>";
		   			redirectHome($theMsg, 'back');
		   		}
		   	echo "</div>";

		}   elseif($do == 'Delete'){ // Delet page 

			 //check if get request userid numeric 
			  $userid = isset($_GET['userid']) && is_numeric($_GET['userid']) ? intval($_GET['userid']): 0;
			  $check = checkItem('userid','users',$userid);

		 		//if there is such id show the form 

		 		if( $check > 0){ 

		 			echo "<h1 class='text-center'>Delete Member</h1>";
		   		    echo "<div class='container'>";
			 			
			 			$stmt= $con->prepare("DELETE FROM users WHERE UserID = :zuser");
			 			$stmt->bindParam(":zuser",$userid);
			 			$stmt->execute();


			   				// echo success messege

			   			$theMsg = "<div class='alert alert-success'>". $stmt->rowCount() . ' Record Deleted</div>';
			   			redirectHome ($theMsg, 'back');

				 		}else{
				 			echo "<div class='container'>";
				 			$theMsg = '<div class="alert alert-danger">this id is not exist</div>';
				 			redirectHome ($theMsg, 'back');
				 			echo "</div>";
				 		}

		 		    echo "</div>";

		    } elseif($do == 'Activate'){
		      //Check if get request userid numeric 
			  $userid = isset($_GET['userid']) && is_numeric($_GET['userid']) ? intval($_GET['userid']): 0;
			  $check = checkItem('UserID','users',$userid);

		 		//if there is such id show the form 

		 		if( $check > 0){ 

		 			echo "<h1 class='text-center'>Activate Member</h1>";
		   		    echo "<div class='container'>";
			 			
			 			$stmt= $con->prepare("UPDATE users SET RegStatus = 1 WHERE UserID = 
			 				?");
			 			$stmt->execute(array($userid));
			   			// echo success messege
			   			$theMsg = "<div class='alert alert-success'>". $stmt->rowCount() . ' Record Activated</div>';
			   			redirectHome ($theMsg, 'back');

				 		}else{
				 			echo "<div class='container'>";
				 			$theMsg = '<div class="alert alert-danger">this id is not exist</div>';
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
