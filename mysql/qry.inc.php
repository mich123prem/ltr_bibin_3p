<?php
include_once __DIR__."/../mysql.inc.php";
if (!isset($_SESSION))
	session_start();

function getQueryId($q){
	$sql = <<<SQLEND
	select id, q FROM query
 WHERE q="$q"
SQLEND;
	
	$_SESSION['dblink'] = database_connect();
	$result = mysqli_query($_SESSION['dblink'], $sql);
	if ($result === false) {
		die("error in $sql: " . mysqli_error($_SESSION['dblink']));
	}

	$row = mysqli_fetch_assoc($result);
    if ($row === false) {
        die("error in $sql: " . mysqli_error($_SESSION['dblink']));
    }
	if (!is_null($row)){
		return $row["id"];
	}else{
		$id = mysqli_fetch_array(mysqli_query("SELECT max(id) FROM query"))[0] + 1;
		$sql=<<<SQLEND
			INSERT INTO query  (id, q) VALUES ($id, '')
SQLEND;
		$_SESSION['dblink'] = database_connect();
		$result = mysqli_query($_SESSION['dblink'], $sql);
		if ($result === false) {
			die("error in $sql: " . mysqli_error($_SESSION['dblink']));
		}
	}
	return $id;
}

function qid2qry($qid){
#   if (!isset($_SESSION))
#        session_start();
#  print("sid=");
#    print_r($_SESSION );
    $sql = <<<SQLEND
  SELECT q FROM query
  WHERE id=$qid
SQLEND;
#	print("sdbl=");
#	print_r($_SESSION['dblink']);
	$_SESSION['dblink'] = database_connect();
	$result = mysqli_query($_SESSION['dblink'], $sql);
	if ($result === false) {
		die("error in $sql: " . mysqli_error($_SESSION['dblink']));
	}

	$row = mysqli_fetch_array($result);
	if ($row===false){
        die("error in $sql: " . mysqli_error($_SESSION['dblink']));
    }
	if (!is_null($row)){
		return $row[0];
	}else{
        die("error in $sql: " . "cannot find query by qid $qid");
	}
}

function hasInteractedWith($user, $query)
{
    $sql = <<<SQLEND
	select qid, assessor FROM relevance
	WHERE qid=$query AND assessor=$user
SQLEND;
    $_SESSION['dblink'] = database_connect();
    $result = mysqli_query($_SESSION['dblink'], $sql);
    if ($result === false) {
        die("error in $sql: " . mysqli_error($_SESSION['dblink']));
    }
    $row = mysqli_fetch_assoc($result);
    if ($row === false) {
        die("error in $sql: " . mysqli_error($_SESSION['dblink']));
    }
    if (is_null($row)) {
        return false;
    } else {
        return true;
    }
}

function getQueryOptions($user){
	$sql=<<<SQLEND
	SELECT q.id as id, q.q as text
	FROM query q, user_query uq
    WHERE q.id = uq.query
	AND uq.user=$user	
SQLEND;
	
	$_SESSION['dblink'] = database_connect();
	$result = mysqli_query($_SESSION['dblink'], $sql);
	if ($result === false) {
		die("error in $sql: " . mysqli_error($_SESSION['dblink']));
	}
	$row = mysqli_fetch_assoc($result);
    if ($row === false) {
        die("error in $sql: " . mysqli_error($_SESSION['dblink']));
    }
	$opts="";
	while ( !is_null($row) ){
		$colorclass="black";
		if ( hasInteractedWith($user, $row['id']) )
			$colorclass="red";
		$opts.=<<<OPT
	<option 
		class="$colorclass"	
		value="{$row['id']}">
		{$row["text"]}
	</option> 		
OPT;
		$row = mysqli_fetch_assoc($result);
	}
	return $opts;
}



?>