<?php

	
 	//Routes

	$tpl 	= "includes/templets/";
	$lang   = "includes/languages/";
	$func   = "includes/functions/";
	$css    = "layout/css/";
	$js	    = "layout/js/";

	// include the important file
	include $func .'function.php';
	include $lang  .'english.php';
	include 'connect.php';
	include $tpl ."header.php";

	if(!isset($noNavbar)){ include $tpl .'navbar.php';}

	
	

?>