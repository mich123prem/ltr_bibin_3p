<?php
include_once __DIR__."/../mysql.inc.php";
if (!isset($_SESSION))
	session_start();


function updateGrade($qid, $docid, $user, $grade){
$sql=<<<SQL
		UPDATE relevance
		SET grade='$grade', `ts`=NOW()
		WHERE qid=$qid
		AND docid='$docid'
		AND assessor=$user
SQL;
	$_SESSION['dblink'] = database_connect();
	$result=mysqli_query($_SESSION['dblink'], $sql );
	if ($result === false) {
		die("error in $sql: " . mysqli_error($_SESSION['dblink']));
	}
}

function insertGrade($qid, $docid, $user, $grade){
	$sql=<<<SQL
		INSERT INTO relevance
		(grade, qid, docid, assessor, `ts`)
		VALUES
		('$grade', $qid, "$docid", $user, now())
SQL;
	$_SESSION['dblink'] = database_connect();
	$result=mysqli_query($_SESSION['dblink'],  $sql);
	if ($result == false) {
		die("error in $sql: " . mysqli_error($_SESSION['dblink']));
	}

}
function isGraded($qid, $docid, $user){
    $sql = <<<SQLEND
	select grade FROM relevance
  WHERE qid=$qid AND docid='$docid' AND assessor=$user
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
        return true;
    }else{
        return false;
    }
}
function getGrade($qid, $docid, $user){
    $sql = <<<SQLEND
	select grade FROM relevance
  WHERE qid=$qid AND docid='$docid' AND assessor=$user
SQLEND;

    $_SESSION['dblink'] = database_connect();
    $result = mysqli_query($_SESSION['dblink'], $sql);
    if ($result === false) {
        die("error in file " . __FILE__ . " line " . __LINE__ .":" . "$sql: " . mysqli_error($_SESSION['dblink']));
    }

    $row = mysqli_fetch_assoc($result);
    if ($row === false){
        die("error in file " . __FILE__ . " line " . __LINE__ .":" . "$sql: " . mysqli_error($_SESSION['dblink']));
    }
    if ($row == null ){
        return null;
    }
    return $row['grade'];
    //}else{
    //    return false;
    //}
}
function setGrade($qid, $docid, $user, $grade){
	/*Allows updating existing grade with a newer one*/
	if (isGraded($qid, $docid, $user))
	    updateGrade($qid, $docid, $user, $grade);
	else
        insertGrade($qid, $docid, $user, $grade);

}

?>