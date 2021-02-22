<?php 
 //////////////////Categories Page
  ob_start();
  session_start();
  $pageTitle = '';
  if (isset($_SESSION['Username'])){
  	include 'init.php';
  	$do = isset($_GET['do']) ? $_GET['do'] : 'Manage';
  	if($do == 'Manage'){
      $sort = "ASC";
      $sort_array = array('ASC','DESC');
      if(isset($_GET['sort']) && in_array($_GET['sort'],$sort_array)){
        $sort = $_GET['sort'];
      }
      $stmt2 = $con->prepare("SELECT * FROM categories where parent = 0 ORDER BY Ordering $sort");
      $stmt2->execute();
      $cats = $stmt2->fetchAll(); 
      if (! empty($cats)){
      ?>
        <h1 class="text-center"> Manage category </h1>
        <div class="container categories">
          <div class="panel panel-default">
            <div class="panel-heading">
              <i class="fa fa-edit"></i> Manage category
              <div class='option pull-right'>
                <i class="fa fa-sort"></i> Ordering: [
                <a class="<?php if($sort == 'ASC'){echo 'active';}?>" href="?sort=ASC">Asc</a> | 
                <a class="<?php if($sort == 'DESC'){echo 'active';}?>" href="?sort=DESC">Desc</a> ]
                <i class="fa fa-eye"></i> View: [
                <span class="active" data-view="full">Full</span> | 
                <span data-view="classic">Classic</span> ]
              </div>
            </div>
            <div class="panel-body">
              <?php 
                foreach ($cats as $cat) {
                  echo '<div class="cat">';
                    echo '<div class="hidden-buttons">';
                          echo "<a href='categories.php?do=Edit&catid=".$cat['ID']."' class='btn-xs btn-primary'><i class='fa fa-edit'></i>Edit</a>";
                          echo "<a href='categories.php?do=Delete&catid=".$cat['ID']."' class='confirm btn-xs btn-danger'><i class='fa fa-close'></i>Delete</a>";
          
                    echo '</div>';
                    echo '<h3>'. $cat["Name"]. '</h3>';
                    echo '<div class="full-view">';
                      echo '<p>'; if($cat["Description"] == ""){echo 'This is empty';}else {echo $cat["Description"];} echo '</p>';
                      if ($cat["Visibilty"] == 1){echo '<span class="visiblity"><i class="fa fa-eye"></i> Hidden</span>';}
                      if ($cat["Allow_Comment"] == 1){echo '<span class="commenting"><i class="fa fa-close"></i> Commenting Disable</span>';}
                      if ($cat["Allow_Ads"] == 1){echo '<span class="advarties"><i class="fa fa-close"></i> Ads Disable</span>';}
                    echo '</div>';
                    // Get child categories 
                  $childCats = getAllFrom("*", "categories", "WHERE parent = {$cat['ID']}", "", "ID", "ASC");
                  if (! empty($childCats)) {
                    echo "<h4 class='child-head'>Child Categories</h4>";
                    echo "<ul class='list-unstyled child-cats'>";
                    foreach ($childCats as $c) {
                      echo "<li class='child-link'>
                          <a href='categories.php?do=Edit&catid=".$c['ID']."'>".$c['Name']."</a>
                          <a href='categories.php?do=Delete&catid=".$c['ID']."' class='show-delet confirm'> Delete</a>
                          </li>";
                    }
                    echo "</ul>";

                 }
                  echo '</div>';
                 echo "<hr>";
                }
              ?>

            </div>
          </div>
            <a class="add-cat btn btn-primary" href="categories.php?do=Add"><i class="fa fa-plus"></i> Add New Category</a>
        </div>
  <?php } else {
              echo "<div class='container'>";
                echo "<div class='nice-messege'>";
                  echo "There is no Categories to show";
                echo "</div>";
                 echo '<a href="categories.php?do=Add" class="btn btn-sm btn-primary"><i class="fa fa-plus"></i> New Category</a>';
              echo "</div>";
              } ?>
        </div>

<?php
  	} elseif ($do == 'Add') { ?>
     <h1 class="text-center">Add New category</h1>
         <div class="container">
          <form class="form-horizontal" action="?do=Insert" method="POST">
      
            <!--start name field-->
            <div class="form-group form-group-lg">
              <label class="col-sm-2 control-labal">Name</label>
              <div class="col-sm-10  col-md-4">
                <input type="text" name="name" class="form-control" autocomplete="off" placeholder="Name of category" required="required">
              </div>
            </div>
            <!--End name field -->
            <!--start Description  -->
            <div class="form-group form-group-lg">
              <label class="col-sm-2 control-labal">Description</label>
              <div class="col-sm-10 col-md-4">
                <input type="text" name="description" class="form-control" placeholder="Description The Categories">
              </div>
            </div>
            <!--End Description-->
            <!--start Ordering -->
            <div class="form-group form-group-lg">
              <label class="col-sm-2 control-labal">Ordering</label>
              <div class="col-sm-10 col-md-4">
                <input type="text" name="ordering" class="form-control" autocomplete="off"  placeholder="Ordering Number To Aarrung Categories">
              </div>
            </div>
            <!--End Ordering -->
            <!--Start cat type -->
            <div class="form-group form-group-lg">
              <label class="col-sm-2 control-labal">Parent ?</label>
              <div class="col-sm-10 col-md-4">
                <select name="parent">
                  <option value="0">None</option>
                  <?php 
                    $allCats = getAllFrom("*", "categories", "WHERE parent = 0", "", "ID", "ASC");
                    foreach ($allCats as $cat) {
                      echo "<option value = '".$cat['ID']."'>".$cat['Name']."</option>";
                    }
                  ?>
                </select>
              </div>
            </div>
            <!--End cat type -->
            <!--start Visiblity field -->
            <div class="form-group form-group-lg">
              <label class="col-sm-2 control-labal">Visible</label>
              <div class="col-sm-10 col-md-4">
                <div>
                  <input id="vis-yas" type="radio" name="visibilty" value="0" checked >
                  <label for="vis-yas">Yas</label>
                </div>
                <div>
                  <input id="vis-no" type="radio" name="visibilty" value="1">
                  <label for="vis-no">No</label>
                </div>
              </div>
            </div>
            <!--End Visiblity field  -->
            <!--start Commenting field -->
            <div class="form-group form-group-lg">
              <label class="col-sm-2 control-labal">Allow Commenting</label>
              <div class="col-sm-10 col-md-4">
                <div>
                  <input id="com-yas" type="radio" name="commenting" value="0" checked >
                  <label for="com-yas">Yas</label>
                </div>
                <div>
                  <input id="com-no" type="radio" name="commenting" value="1">
                  <label for="com-no">No</label>
                </div>
              </div>
            </div>
            <!--End Commenting field  -->
             <!--start Ads field -->
            <div class="form-group form-group-lg">
              <label class="col-sm-2 control-labal">Allow Ads</label>
              <div class="col-sm-10 col-md-4">
                <div>
                  <input id="ads-yas" type="radio" name="ads" value="0" checked >
                  <label for="ads-yas">Yas</label>
                </div>
                <div>
                  <input id="ads-no" type="radio" name="ads" value="1">
                  <label for="ads-no">No</label>
                </div>
              </div>
            </div>
            <!--End Ads field  -->
            <!--start button -->
            <div class="form-group">
              <div class="col-sm-offset-2 col-sm-10">
                <input type="submit" value ="Add Category" class="btn btn-primary btn-lg">
              </div>
            </div>
            <!--End button-->

          </form>
        </div>
    <?php
  	} elseif ($do == 'Insert') {
      if($_SERVER['REQUEST_METHOD'] == 'POST'){
            echo "<h1 class='text-center'>Insert Member</h1>";
              echo "<div class='container'>";
          //get varibale from form 
            
            $name      = $_POST['name'];
            $desc      = $_POST['description'];
            $parent     = $_POST['parent'];
            $order     = $_POST['ordering'];
            $visible   = $_POST['visibilty'];
            $comment   = $_POST['commenting'];
            $ads       = $_POST['ads'];

              //check if user exit in database
               $check = checkItem('Name','categories',$name);
               if ($check == 1) {
                  $theMsg = "<div class='alert alert-danger'> Sorry this Categories is exsit in database</div>";
                redirectHome($theMsg ,'back');
               } else {
                   //Insert userinfo into database
                    $stmt=$con->prepare("INSERT INTO 
                                categories(Name,Description,parent,Ordering,Visibilty,Allow_Comment,Allow_Ads)
                                  VALUES(:zname,:zdesc,:zparent,:zorder,:zvisible,:zcomment,:zads)");
                    $stmt->execute(array(
                      'zname'    => $name,
                      'zdesc'    => $desc,
                      'zparent'  => $parent,
                      'zorder'   => $order,
                      'zvisible' => $visible,
                      'zcomment' => $comment,
                      'zads'     => $ads
                    ));
                   // echo success messege

                    $theMsg = "<div class='alert alert-success'>". $stmt->rowCount() . ' Record Insert</div>';
                     redirectHome($theMsg, 'back');
                   }
             }else{
                echo "<div class='container'>";

              $theMsg = "<div class='alert alert-danger btn-block'>you cant browse this page dirictly</div>";

              redirectHome($theMsg, 'back');
               echo "</div>";
               }
          echo "</div>";


  	} elseif ($do == 'Edit') {
       //check if get request catid numeric 
        $catid = isset($_GET['catid']) && is_numeric($_GET['catid']) ? intval($_GET['catid']): 0;
        // select all data depent on this id
        $stmt =$con->prepare("SELECT * FROM categories WHERE ID = ? ");

        //execute query 
        $stmt->execute(array($catid));
        // fetch the data
        $cat = $stmt->fetch();

        $count =$stmt->rowCount();

      

        //if there is such id show the form 

        if($stmt->rowCount() > 0){  ?>
             <h1 class="text-center">Edit category</h1>
                 <div class="container">
                  <form class="form-horizontal" action="?do=Update" method="POST">
                    <input type="Hidden" name="catid" value="<?php echo $catid ?>">
                    <!--start name field-->
                    <div class="form-group form-group-lg">
                      <label class="col-sm-2 control-labal">Name</label>
                      <div class="col-sm-10  col-md-4">
                        <input type="text" name="name" class="form-control" placeholder="Name of category" required="required" value="<?php echo $cat['Name'];?>">
                      </div>
                    </div>
                    <!--End name field -->
                    <!--start Description  -->
                    <div class="form-group form-group-lg">
                      <label class="col-sm-2 control-labal">Description</label>
                      <div class="col-sm-10 col-md-4">
                        <input type="text" name="description" class="form-control" placeholder="Description The Categories" value="<?php echo $cat['Description'];?>">
                      </div>
                    </div>
                    <!--End Description-->
                    <!--start Ordering -->
                    <div class="form-group form-group-lg">
                      <label class="col-sm-2 control-labal">Ordering</label>
                      <div class="col-sm-10 col-md-4">
                        <input type="text" name="ordering" class="form-control" placeholder="Ordering Number To Aarrung Categories" value="<?php echo $cat['Ordering'];?>">
                      </div>
                    </div>
                    <!--End Ordering -->
                    <!--Start cat type -->
                    <div class="form-group form-group-lg">
                      <label class="col-sm-2 control-labal">Parent ?</label>
                      <div class="col-sm-10 col-md-4">
                        <select name="parent">
                          <option value="0">None</option>
                          <?php 
                            $allCats = getAllFrom("*", "categories", "WHERE parent = 0", "", "ID", "ASC");
                            foreach ($allCats as $c) {
                              echo "<option value = '".$c['ID']."'";
                                if ($cat['parent'] == $c['ID']) { echo "selected";}
                              echo ">".$c['Name']."</option>";
                            }
                          ?>
                        </select>
                      </div>
                    </div>
                    <!--End cat type -->
                    <!--start Visiblity field -->
                    <div class="form-group form-group-lg">
                      <label class="col-sm-2 control-labal">Visible</label>
                      <div class="col-sm-10 col-md-4">
                        <div>
                          <input id="vis-yas" type="radio" name="visibilty" value="0"  <?php if ($cat['Visibilty'] == '0'){ echo 'checked';}?>>
                          <label for="vis-yas">Yas</label>
                        </div>
                        <div>
                          <input id="vis-no" type="radio" name="visibilty" value="1"  <?php if ($cat['Visibilty'] == '1'){ echo 'checked';}?>>
                          <label for="vis-no">No</label>
                        </div>
                      </div>
                    </div>
                    <!--End Visiblity field  -->
                    <!--start Commenting field -->
                    <div class="form-group form-group-lg">
                      <label class="col-sm-2 control-labal">Allow Commenting</label>
                      <div class="col-sm-10 col-md-4">
                        <div>
                          <input id="com-yas" type="radio" name="commenting" value="0" <?php if ($cat['Allow_Comment'] == '0'){ echo 'checked';}?>>
                          <label for="com-yas">Yas</label>
                        </div>
                        <div>
                          <input id="com-no" type="radio" name="commenting" value="1" <?php if ($cat['Allow_Comment'] == '1'){ echo 'checked';}?>>
                          <label for="com-no">No</label>
                        </div>
                      </div>
                    </div>
                    <!--End Commenting field  -->
                     <!--start Ads field -->
                    <div class="form-group form-group-lg">
                      <label class="col-sm-2 control-labal">Allow Ads</label>
                      <div class="col-sm-10 col-md-4">
                        <div>
                          <input id="ads-yas" type="radio" name="ads" value="0" <?php if ($cat['Allow_Ads'] == '0'){ echo 'checked';}?>>
                          <label for="ads-yas">Yas</label>
                        </div>
                        <div>
                          <input id="ads-no" type="radio" name="ads" value="1" <?php if ($cat['Allow_Ads'] == '1'){ echo 'checked';}?>>
                          <label for="ads-no">No</label>
                        </div>
                      </div>
                    </div>
                    <!--End Ads field  -->
                    <!--start button -->
                    <div class="form-group">
                      <div class="col-sm-offset-2 col-sm-10">
                        <input type="submit" value ="Save" class="btn btn-primary btn-lg">
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


  	} elseif ($do == 'Update') {

      echo "<h1 class='text-center'>Update Category</h1>";
          echo "<div class='container'>";
          if($_SERVER['REQUEST_METHOD'] == 'POST'){
          //Get varibale from form 
            $id         = $_POST['catid'];
            $name       = $_POST['name'];
            $desc       = $_POST['description'];
            $order      = $_POST['ordering'];
            $parent     = $_POST['parent'];
            $visible    = $_POST['visibilty'];
            $comment    = $_POST['commenting'];
            $ads        = $_POST['ads'];

            $stmt =$con->prepare("UPDATE 
                                      categories
                                  SET 
                                      Name = ?,
                                      Description = ?, 
                                      Ordering = ?,
                                      parent = ?,
                                      Visibilty = ?,
                                      Allow_Comment =?,
                                      Allow_Ads =?
                                  WHERE 
                                      ID = ?");
            $stmt->execute(array($name,$desc,$order,$parent,$visible,$comment,$ads,$id));

            // echo success messege

            $theMsg = "<div class='alert alert-success'>". $stmt->rowCount() . ' Record Update</div>';

             redirectHome($theMsg, 'back');
          
          }else{

            $theMsg = "<div class='alert alert-danger'>You cant browse this page dirictly</div>";
            redirectHome($theMsg, 'back');
          }
        echo "</div>";
  	} elseif ($do == 'Delete') {

       //check if get request catid numeric 
        $catid = isset($_GET['catid']) && is_numeric($_GET['catid']) ? intval($_GET['catid']): 0;
        $check = checkItem('ID','categories',$catid);

        //if there is such id show the form 

        if( $check > 0){ 

          echo "<h1 class='text-center'>Delete category</h1>";
              echo "<div class='container'>";
            
            $stmt= $con->prepare("DELETE FROM categories WHERE ID = :zid");
            $stmt->bindParam(":zid",$catid);
            $stmt->execute();


                // echo success messege

              $theMsg = "<div class='alert alert-success'>". $stmt->rowCount() . ' Record Deleted</div>';
              redirectHome ($theMsg,'back');

            }else{
              echo "<div class='container'>";
              $theMsg = '<div class="alert alert-danger">this id is not exist</div>';
              redirectHome ($theMsg, 'back');
              echo "</div>";
            }

            echo "</div>";


  	} 
    include $tpl ."footer.php";
  } else {
	  header('Location:index.php');
		exit();
	     }

