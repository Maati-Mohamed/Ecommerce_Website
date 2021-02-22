<?php
	ob_start();
	session_start();
	$pageTitle = "Create New Item";
	include "init.php";
	if (isset($_SESSION['user'])) {

	if ($_SERVER['REQUEST_METHOD'] == 'POST') {

		$formErrors = array();

		$name 			= filter_var($_POST['name'],FILTER_SANITIZE_STRING);
		$desc 			= filter_var($_POST['description'],FILTER_SANITIZE_STRING);
		$price 			= filter_var($_POST['price'],FILTER_SANITIZE_NUMBER_INT);
		$country 		= filter_var($_POST['country'],FILTER_SANITIZE_STRING);
		$status 		= filter_var($_POST['status'],FILTER_SANITIZE_NUMBER_INT);
		$category 		= filter_var($_POST['category'],FILTER_SANITIZE_NUMBER_INT);
		$tags 			= filter_var($_POST['tags'],FILTER_SANITIZE_STRING);

		if(strlen($desc) < 10) {
			$formErrors[] = "Item Description must be 10 Charcter";
		}

		if(strlen($country) < 2) {
			$formErrors[] = "Item country must be more than 2 Charcter";
		}
		if (empty($price)) {
			$formErrors[] = "Item price must be not empty";
		}
		if (empty($country)) {
			$formErrors[] = "Item country must be not empty";
		}
		if (empty($status)) {
			$formErrors[] = "Item status must be not empty";
		}
		if (empty($category)) {
			$formErrors[] = "Item category must be not empty";
		}

			if(empty($formErrors)){

               //Insert userinfo into database
                $stmt=$con->prepare("INSERT INTO 

                            items(Name,Description,Price,Country_Made,Status,Add_Date,Cat_ID,Member_ID,tags)

                          VALUES(:zname, :zdesc, :zprice, :zcountry,:zstatus,now(),:zcat,:zmember,:ztags )");
                $stmt->execute(array(

                  'zname'     => $name,
                  'zdesc'     => $desc,
                  'zprice'    => $price,
                  'zcountry'  => $country,
                  'zstatus'   => $status,
                  'zmember'   => $_SESSION['uid'],
                  'zcat'      => $category,
                  'ztags'     => $tags

                ));
               // echo success messege
                if ($stmt) {
                  $succesMsg = "Item Has Been Added";
                }
	        }



	}
?>
	<h1 class="text-center"><?php echo $pageTitle ;?></h1>
	<div class="create-ad block">
		<div class="container">
			<div class="panel panel-primary">
				<div class="panel-heading"><?php echo $pageTitle ;?></div>
				<div class="panel-body">
				 	<div class="row">
				 		<div class="col-md-8">
							<form class="form-horizontal" action="<?php echo $_SERVER['PHP_SELF'] ?>" method="POST">
					      
					            <!--start name field-->
					            <div class="form-group form-group-lg">
					              <label class="col-sm-3 control-label">Name</label>
					              <div class="col-sm-10  col-md-9">
					                <input
					                       type="text"
					                       name="name"
					                       class="form-control live-name"
					                       placeholder="Name Of The Item"
					                       required="required">
					                       
					              </div>
					            </div>
					            <!--End name field -->
					            <!--start Description field -->
					              <div class="form-group form-group-lg">
					              <label class="col-sm-3 control-label">Description</label>
					              <div class="col-sm-10  col-md-9">
					                <input
					                       type="text"
					                       name="description"
					                       class="form-control live-desc"
					                       placeholder="Description Of The Item"
					                       required="required">
					                       
					              </div>
					            </div>
					            <!--End Description field -->
					            <!--start Price field -->
					              <div class="form-group form-group-lg">
					              <label class="col-sm-3 control-label">Price</label>
					              <div class="col-sm-10  col-md-9">
					                <input
					                       type="text"
					                       name="price"
					                       class="form-control live-price"
					                       placeholder="$123"
					                       required="required">
					                       
					              </div>
					            </div>
					            <!--End Price field -->
					            <!--start Country field -->
					              <div class="form-group form-group-lg">
					              <label class="col-sm-3 control-label">Country</label>
					              <div class="col-sm-10  col-md-9">
					                <input
					                       type="text"
					                       name="country"
					                       class="form-control"
					                       placeholder="Country of made"
					                       required="required">
					                       
					              </div>
					            </div>
					            <!--End Country field -->
					            <!--start Status field -->
					              <div class="form-group form-group-lg">
					              <label class="col-sm-3 control-label">Status</label>
					              <div class="col-sm-10  col-md-9">
					                <select class="form-control" name="status" required>
					                    <option value="0">...</option>
					                    <option value="1">New</option>
					                    <option value="2">Like New</option>
					                    <option value="3">Used</option>
					                    <option value="4">Very Old</option>
					                </select>                       
					              </div>
					            </div>
					            <!--End Status field -->
					            <!--start Category field -->
					              <div class="form-group form-group-lg">
					              <label class="col-sm-3 control-label">Category</label>
					              <div class="col-sm-10  col-md-9">
					                <select class="form-control" name="category">
					                    <option value="0" required>...</option>
					                      <?php 
											 $allCats = getAllFrom("*", "categories","where parent = 0","", "ID");
					                          foreach ($allCats as $cat) {
					                          echo "<option value='".$cat['ID']."'>".$cat['Name']."</option>";
					                        }
					                      ?>
					                </select>                       
					              </div>
					            </div>
					            <!--End Category field -->
					            <!--start Tags field -->
					              <div class="form-group form-group-lg">
					              <label class="col-sm-3 control-label">Tags</label>
					              <div class="col-sm-10  col-md-9">
					                <input
					                       type="text"
					                       name="tags"
					                       class="form-control"
					                       placeholder="Seprate tags with comma (,)">
					                       
					              </div>
					            </div>
					            <!--End Tags field -->
					            <!--start button -->
					            <div class="form-group">
					              <div class="col-sm-offset-3 col-sm-9">
					                <input type="submit" value ="Add Item" class="btn btn-primary btn-sm">
					              </div>
					            </div>
					            <!--End button-->

					          </form>
				 		</div>
				 		<div class="col-md-4">
				 			<div class='thumbnail item-box live-preview'>
								 <span class='price'>0</span>
								   	<img class='img-responsive' src='ecommerce.png' alt=''>
								   	<div class='caption'>
								   	  	<h3>Title</h3>
								   	  	<p>Description</p>
								   	</div>
							</div>
				 		</div>
				 	</div>
				 	<!------- Start looping --------->
				 	<?php 
				 		if (! empty($formErrors)) {
				 			foreach ($formErrors as $error) {
				 				echo "<div class='alert alert-danger'>".$error."</div>";
				 			}
				 		}
				 		if (isset($succesMsg)) {
					  		echo "<div class='alert alert-success'>".$succesMsg."</div>";
					  	}

				 	?>
				 	<!------- End looping ----------->
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
