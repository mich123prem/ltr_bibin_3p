<?php
include_once __DIR__."/../mysql.inc.php";
if (!isset($_SESSION))
	session_start();

function nameByID($id){
	$sql=<<<SQLEND
	select name FROM user
	WHERE id=$id	
SQLEND;
	$_SESSION['dblink'] = database_connect();
	$result = mysqli_query($_SESSION['dblink'], $sql);
	if ($result === false) {
		die("error in $sql: " . mysqli_error($_SESSION['dblink']));
	}
	$row = mysqli_fetch_assoc($result);
	return $row['name'];
}
function passByID($id){
    $sql=<<<SQLEND
	select pass FROM user
	WHERE id=$id	
SQLEND;
    $_SESSION['dblink'] = database_connect();
    $result = mysqli_query($_SESSION['dblink'], $sql);
    if ($result === false) {
        die("error in $sql: " . mysqli_error($_SESSION['dblink']));
    }
    $row = mysqli_fetch_assoc($result);
    return $row['pass'];
}
function namePassByID($id){
    $sql=<<<SQLEND
	select name, pass FROM user
	WHERE id=$id	
SQLEND;
    $_SESSION['dblink'] = database_connect();
    $result = mysqli_query($_SESSION['dblink'], $sql);
    if ($result === false) {
        die("error in $sql: " . mysqli_error($_SESSION['dblink']));
    }
    $row = mysqli_fetch_assoc($result);
    if ($_GET['pass'] == $row["pass"])
        return $row['name'];
    else
        return array($row['name'], "wrong pass");
}

function getUserOptions(){
	print("entering getUserOptions");
	$sql=<<<SQLEND
	select id, name FROM user
SQLEND;
	$_SESSION['dblink'] = database_connect();
	$result = mysqli_query($_SESSION['dblink'], $sql);
	if ($result === false) {
		die("error in $sql: " . mysqli_error($_SESSION['dblink']));
	}
	$opts="";
	$row = mysqli_fetch_assoc($result);
    if ($row === false) {
        die("error in $sql: " . mysqli_error($_SESSION['dblink']));
    }

	while (!is_null($row)){
		$opts.=<<<OPT
	<option 
		value="{$row['id']}">
		{$row["name"]}
	</option> 		
OPT;
		$row = mysqli_fetch_assoc($result);
	}
	return $opts;
}



?>