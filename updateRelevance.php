<?php

if(isset($_GET['last'])){
	$params="?";
	foreach($_GET as $ky => $val){
		$params .= "${ky}=${val}&";
	}
	$params=rtrim($params, '&');
	print("index.php".$params);
	header("Location: index.php".$params);

}
//phpinfo();
if (!isset($_SESSION))
	session_start();


include_once "html.inc.php";
include_once "elastic.inc.php";
#include_once "memcache.inc.php";
include_once "mysql.inc.php";
?>

<?php
$qid=$_SESSION['qid'];
foreach($_GET as $ky => $val){
	if (strpos($ky, "rn")===0 && $val != "hidden"){
		$rel=$val;
		list($rn, $qid, $docid, $user) = explode("_", $ky);
		setGrade($qid, $docid, $user, $rel);
	}
}
//print("updateRelevance:");
//var_dump($_GET);
include "call_func_row.php";

?>