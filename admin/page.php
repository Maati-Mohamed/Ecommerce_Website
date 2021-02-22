<?php 

	/* 
		Gategories [ Manage - Edit - Update - Insert - Add - Delete - stats ]



	*/
	$do = isset($_GET['do']) ? $_GET['do'] : 'Manage';


	//if the page is main page 

	if($do == 'Manage'){
		echo 'welcome you are in Manage categorie page';

	}elseif($do == 'Add'){
		echo 'welcome you are in Add categorie page';

	}elseif($do == 'Insert'){
		echo 'welcome you are in Insert categorie page';

	}else{
		echo 'Erroe there is no page with this ';
	}


