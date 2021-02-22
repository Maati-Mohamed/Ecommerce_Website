<?php 
	session_start();
    include "init.php";?>
	<div class="container">
		<h1 class="text-center">Show Category Items</h1>
		<div class="row">
			<?php 
			    if (isset($_GET['pageid']) && is_numeric($_GET['pageid'])) {
			    	$category = intval($_GET['pageid']);
				    $allItems = getAllFrom("*","items","where Cat_ID ={$category}","And Approve = 1","Item_ID");
					foreach ($allItems as $item) {
						echo "<div class='col-sm-6 col-md-3'>";
						   echo "<div class='thumbnail item-box'>";
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
				} else {
					echo "You must add Page ID";
				}
			?>
	   </div>
	</div>
<?php include $tpl ."footer.php";?>