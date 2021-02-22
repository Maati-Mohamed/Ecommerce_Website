<?php 
	session_start();
	$pageTitle = "Login";
	if(isset($_SESSION['user'])){
		header('Location: index.php');
	}


	include "init.php"; 
// Check if user come from http post request

	if($_SERVER['REQUEST_METHOD'] == 'POST'){

		if (isset($_POST['Login'])) {

		$user 		= $_POST['username'];
		$pass 		= $_POST['password'];
		$hashedPass = sha1($pass);

// Check if user exist in database 

		$stmt = $con->prepare(" SELECT
									UserID,Username,Password
							    FROM
							         users 
							    WHERE
							         Username = ?
							    AND 
							         Password = ?  ");

		$stmt->execute(array($user,$hashedPass));
		$get = $stmt->fetch();
		$count =$stmt->rowCount();

		if ($count > 0){
			$_SESSION['user'] = $user;
			$_SESSION['uid'] = $get['UserID'];
			header('Location: index.php');
			exit(); 
		}
	  } else {

	  	$formErorrs = array();

	  	$username 	= $_POST['username'];
	  	$password 	= $_POST['password'];
	  	$password2  = $_POST['password2'];
	  	$email 		= $_POST['email'];

	  	if (isset($username)) {
	  		$filterUser = filter_var($username,FILTER_SANITIZE_STRING);
	  		   if (strlen($filterUser) < 4) {
	  			 $formErorrs[] = 'Username Must Be Larger Than 4 Character';
	  		}	  	
	  	}
	  	if (isset($password) && isset($password2)) {

	  		 if (empty($_POST['password'])) {
	  		 	 $formErorrs[] = 'Sorry Password Can Not Be Empty';
	  		 }

	  		 if (sha1($password)!== sha1($password2)) {
	  		 	 $formErorrs[] = 'Sorry Password Is Not Match';
	  		 }
	  	}
	  	if (isset($email)) {
	  		$filterEmail = filter_var($email ,FILTER_SANITIZE_EMAIL);
	  		if (filter_var($filterEmail,FILTER_VALIDATE_EMAIL) != true ) {
	  			$formErorrs[] = 'This Email Is Not Valid';
	  		}
	  	}

		 if (empty($formErrors)) {
		   $check = checkItem('Username','users', $username);

		 	if ($check == 1) {
		 		$formErorrs[] = 'Sorry This User Is Exsiet';
		 		
		 	 } else { 
		 	 
	   			 //Insert userinfo into database
	   			 	$stmt=$con->prepare("INSERT INTO 
	   			 							users(Username,Password,Email,RegStatus,Date)
	   			 						    VALUES(:zuser, :zpass, :zemail,0,now() )");
	   			 	$stmt->execute(array(

	   			 		'zuser'	=> $username,
	   			 		'zpass'	=> sha1($password),
	   			 		'zemail'=> $email


	   			 	));
	   			 // echo success messege
	   			 	$succesMsg = "Congrate Now You Are Regestar User";
	   				 
	   			 }

	   		}

	    }
	}
 ?>

<div class="container login-page">
	<h1 class="text-center"><span class="selected" data-class="login">Login </span>|<span data-class="signup"> Signup</span></h1>
	<!------ Start Login Form --->
	<form class="login" action="<?php echo $_SERVER['PHP_SELF']?>" method="POST">
		<input 
			class="form-control" 
			type="text" 
			name="username" 
			autocomplete="off" 
			placeholder="Username" 
			/>
		<input 
			class="form-control"
			type="password" 
			name="password" 
			autocomplete="new-password" 
			placeholder="Password"
			 />
		<input class="btn btn-primary btn-block" name="Login" type="submit" value="Login" />
	</form>
	<!------ End Login Form --->
	<!------ Start Singup Form --->
	<form class="signup" action="<?php echo $_SERVER['PHP_SELF']?>" method="POST">
		<input 
			pattern=".{4,8}" 
			title="Username Must be between 4 & 8 char" 
			class="form-control" 
			type="text" name="username"
			autocomplete="off" 
			placeholder="Username" />
		<input 
			minlength="4" 
			class="form-control"
			type="password" 
			name="password" 
			autocomplete="new-password" 
			placeholder="Password"
			 />
		<input 
			minlength="4" 
			class="form-control"
			type="password" 
			name="password2" 
			autocomplete="new-password" 
			placeholder="Password Again"
			 />

		<input 
			class="form-control"
			type="email"
			name="email" 
			autocomplete="off" 
			placeholder="Valied Email"
			 />
		<input class="btn btn-success btn-block" name="Signup" type="submit" value="Signup" />
	</form>
	<!------ End Singup Form --->
	<div class="the-erorrs text-center">
	  <?php 
	  	if (! empty($formErorrs)){
	  		foreach ($formErorrs as $erorr) {
	  			echo $erorr."<br>";
	  		}

	  	}
	  	if (isset($succesMsg)) {
	  		echo "<div class='msg success'>".$succesMsg."</div>";
	  	}
	  ?>
	</div>
</div>
	
<?php include $tpl ."footer.php";?>