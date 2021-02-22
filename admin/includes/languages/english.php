<?php

	function lang($phrase){

		static $lang = array(

		// Navbar links 

			'Home'			 => 'Home',
			'CETEGORIES' 	 => 'Cetegories',
			'ITMES'			 => 'Itmes',
			'MEMBERS'		 => 'Members',
			'COMMENTS'		 => 'Commments',
			'STATISTIC'		 => 'Statistc',
			'LOGS'			 => 'Logs'
		);

		return $lang[$phrase];
	}
