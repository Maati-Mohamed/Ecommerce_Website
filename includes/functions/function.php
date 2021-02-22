<?php
/*
** Check if User Not Actiavted 
** Check RegStatus of User 
*/

	function checkUserStatus($user){
		global $con;
		$stmtx = $con->prepare(" SELECT
									Username,RegStatus
							    FROM
							         users 
							    WHERE
							         Username = ?
							    AND 
							         RegStatus = 0 ");

		$stmtx->execute(array($user));
		$status =$stmtx->rowCount();
		return $status;
	}
/*
** Get  All function v2.0
** function get All record from database
*/
	function getAllFrom($faild, $table, $where = NULL, $and = NULL, $orderfaild, $ordering = 'ASC'){
		global $con;
		$getAll = $con->prepare("SELECT $faild FROM $table $where $and ORDER BY $orderfaild $ordering");
		$getAll->execute();
		$all = $getAll->fetchall();
		return $all; 
	}
/*
** Get  categories function v1.0
** function get record  in database
*/
	function getCat(){
		global $con;
		$getCat = $con->prepare("SELECT * FROM categories ORDER BY ID ASC");
		$getCat->execute();
		$cats = $getCat->fetchall();
		return $cats; 
	}

/*
** Get  items function v1.0
** function get items  in database
*/
	function getItems($where,$value,$approve = NULL){
		global $con;
		if ($approve = NULL) {
			$sql = "AND Approve = 1";
		} else {
			$sql = NULL;
		}
		$getItems = $con->prepare("SELECT * FROM items WHERE $where = ? $sql ORDER BY Item_id DESC");
		$getItems->execute(array($value));
		$items = $getItems->fetchall();
		return $items; 
	}


	function getTitle(){
		global $pageTitle;
		if(isset($pageTitle)){
			echo $pageTitle;
		}else{
			echo "defulte";
		}
	}
	function redirectHome ($theMsg,$url = null, $seconds = 3){

		if($url === null) {

			$url = 'index.php';
		} else {
			if(isset($_SERVER["HTTP_REFERER"]) && $_SERVER["HTTP_REFERER"] !== ''){
				$url = $_SERVER["HTTP_REFERER"];
			} else {
				$url = 'index.php';
			}

			echo $theMsg;
			echo "<div class='alert alert-info'>You Will Redirected to Home after $seconds seconds</div>";
			header("refresh:$seconds;url=$url");
			exit();
		}
	}
/*
** Check items functions 
** function to check item in database [function eccept pramiter] 
** $select [example: username ,item , category]
** $form   [example: users ,item , category]
** $value  [example: osama ,box , Electronics]
*/

	function checkItem($select,$from,$value){

		global $con;
		$statment = $con->prepare("SELECT $select FROM $from WHERE $select = ?");
		$statment->execute(array($value));
		$count = $statment->rowCount();

		return $count;
	}
/*
** Count number of item function v1.0
** function to count number of items rows 
** $item = the item to count
** $table = the table to choose from 
*/
	function countItem($item,$table){
		global $con;
		$stmt2 = $con->prepare("SELECT COUNT($item) FROM $table");
		$stmt2->execute();
	    return $stmt2->fetchcolumn();
	}
/*
** Get Latest Record function v1.0
** function get latest item in database
** $select =  field to select
** $table  = the table to choose from 
** $order  = the desc ordering
** $limit  = number of record to get 
*/
	function getLatest($select,$table,$order,$limit){
		global $con;
		$stmt = $con->prepare("SELECT $select FROM $table ORDER BY $order DESC LIMIT $limit");
		$stmt->execute();
		$row = $stmt->fetchall();
		return $row; 
	}