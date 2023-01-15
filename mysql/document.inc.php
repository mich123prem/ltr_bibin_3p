<?php
include_once __DIR__."/../mysql.inc.php";
if (!isset($_SESSION))
	session_start();
function doc2db($id, $json) {
	if (!isset($_SESSION))
		session_start();
	$obj=json_decode($json, false);
	$title = $obj->fullTitle;
	//$author = $obj->author;

	$sql = <<<SQLEND
INSERT IGNORE INTO doc
(id, title, doc_obj) values('$id', '$title', '$json')
SQLEND;

	$_SESSION['dblink']=database_connect();
	$result = mysqli_query($_SESSION['dblink'], $sql);
	if ($result === false) {
		die("error in $sql: " . mysqli_error($_SESSION['dblink'])); 
	}
/*
	$row = mysqli_fetch_assoc($result);
	if ($row!=false){
		return $row['id'];
	}else{
		$id=mysqli_fetch_array(mysqli_query("SELECT max(id) FROM query"))[0] + 1;
		$sql=<<<SQLEND
			INSERT INTO query  (id, q) VALUES ($id, '')
SQLEND;
		$result = mysqli_query($_SESSION['dblink'], $sql);
		if ($result == false) {
			die("error in $sql: " . mysqli_error($_SESSION['dblink']));
		}
	}
	return $id;
*/
}
?>					