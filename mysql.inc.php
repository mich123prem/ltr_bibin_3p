<?php
if (!isset($_SESSION))
	session_start();
include_once "mysql/document.inc.php";
include "mysql/qry.inc.php";
include_once "mysql/qd.inc.php";
include_once "mysql/users.inc.php";

function getOptionsFromDB($what){

	if ($what=="users")
		return getUserOptions();
	else
		return getQueryOptions($_SESSION["user"]);
}

function database_connect(){
	if (!isset($_SESSION))
		session_start();
	$tjener="127.0.0.1";
	$port="3306";
	$bruker="michaelp";
	$passord="sar12sur";
	if (!isset($_SESSION['configs']['database']))
        $_SESSION['configs']['database']="michaelp_ltr_4p2";

	$database=$_SESSION['configs']['database'];
	$connect_setning=$tjener.":".$port."/$database";
	$_SESSION['dblink']=mysqli_connect($tjener, $bruker, $passord, $database,$port);
	if ($_SESSION['dblink'] == false)
	    die("Cannot conect to database");
	//$db_success=mysqli_select_db($_SESSION['db']);
	//print_r($_SESSION['dblink']);
	
	return $_SESSION['dblink'];
	/*
	$dok=0;
	if (isset($_SESSION['dok'])){
  		$dok=$_SESSION['dok'];
	}
	*/
}
?>