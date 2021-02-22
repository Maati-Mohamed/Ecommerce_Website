<?php
	ob_start();
?>
<!DOCTYPE html>
<html>
		<head>
			<meta charset="utf-u8">
			<title><?php getTitle() ?></title>
			<link rel="stylesheet" href="<?php echo  $css ; ?>bootstrap.min.css">
			<link rel="stylesheet" href="<?php echo  $css ; ?>all.css">
			<link rel="stylesheet" href="<?php echo  $css ; ?>front.css">
		</head>
		<body>
			<div class="upper-bar">
				<div class="container">

					<?php
					if (isset($_SESSION['user'])) { ?>
						<img class=" my-img img-thumbnail" src='ecommerce.png' alt=''>

						<div class="btn-group my-info">
							<span class="btn dropdown-toggle" data-toggle="dropdown">
								<?php echo $sessionUser; ?>
								<span class="caret"></span>
						    </span>
							<ul class="dropdown-menu">
								<li><a href="profile.php">MY Profile</a></li>
								<li><a href="newad.php">New Item</a></li>
								<li><a href="profile.php#my-ads">My Items</a></li>
								<li><a href="logout.php">Logout</a></li>
							</ul>
						</div>

					<?php

					} else { ?>
				
						<a href="login.php">
						<span class="pull-right">Login/Signup</span>
					    </a> 

					<?php } ?>
				</div>
			</div>
			<nav class="navbar navbar-inverse">
			  <div class="container">
			    
			    <div class="navbar-header">
			      <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#app" aria-expanded="false">
			        <span class="sr-only">Toggle navigation</span>
			        <span class="icon-bar"></span>
			        <span class="icon-bar"></span>
			        <span class="icon-bar"></span>
			      </button>
			      <a class="navbar-brand" href="index.php">Homepage</a>
			    </div>

			  
			    <div class="collapse navbar-collapse" id="app">
			      <ul class="nav navbar-nav navbar-right">
			      	<?php
			   			$allCats = getAllFrom("*", "categories", "WHERE parent = 0", "", "ID", "ASC");
						foreach ($allCats as $cat) {
						echo '<li>
						         <a href="categories.php?pageid=' . $cat['ID'] .'">
						            '.$cat['Name'].'
						         </a>
						      </li>';
						}
					?>
			      </ul>
			    </div>
			  </div>
			</nav>
<?php
	ob_end_flush();
?>

