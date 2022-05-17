<?php

// loading database connectivity
require_once("../lib/db.php");

if( !isset($_SESSION['user_id']) || !isset($_SESSION['user_name']) || $_SESSION['auth'] != "b58ac01c6c7a9fb5ffd1a5d9c7d68955-NovaVTeam"){
    header("location: ../login/");
    exit();
}


$user_id    = $_SESSION['user_id'];
$user_name  = $_SESSION['user_name'];
$user_photo = $_SESSION['user_photo'];
// $user_type  = $_SESSION['user_type'];




//  this code use for show and non show all number in system 
if( empty($_SESSION['EYE'])  ){
	$SHOW_EYE  = 'SHOW';
}else {
	$SHOW_EYE = $_SESSION['EYE'];
}


	$DATE       = date('Y-m-d');
	$PDATE      = clean_data(gregorian_to_jalali_date($DATE,'-'));


	update_currency_rate($user_id,$PDATE);

	// how many records should be displayed on a page?
    $records_per_page = 50;
    // include the pagination class
    require_once('../lib/Zebra_Pagination.php');
    // instantiate the pagination object
    $pagination = new Zebra_Pagination();
    // show records in reverse order
    $pagination->reverse(false);
    // pass the total number of records to the pagination class

	if(isset($_GET['page'])){
		$page = $_GET['page'];
		$from = $page * 50 - 50;
		$to   = 51;
		$count=$page * 50 - 50 + 1;
	}else{
		$from = 0;
		$to   = 51;
		$count=1;
	}
?>