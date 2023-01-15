<?php
if (!isset($_SESSION)) {
    session_start();
}
//print(__FILE__. " l.". __LINE__ . ": call_func_row:");
//var_dump($_GET);
include_once "html.inc.php";
$hh=$_SESSION['hitArray'];
// print("inside include");
// print_r($hh[0]);
$i=0;
/* == DEFINE */
$arrayOfJudgments=array_pad(array(), $_SESSION['configs']['hitsPerScreen'], "hidden");

$arrayOfCheckedArrays=array_pad(array(),/*PreChecked radio buttons*/
    $_SESSION['configs']['hitsPerScreen'],
    createValuedCheckedArray("hidden"));
$arrayOfWarningStyles=array_pad(array(),
    $_SESSION['configs']['hitsPerScreen'],
    "");

if (isset($_GET['i'])){  // coming from index.htm. $i==0.
	$i=$_GET['i'];
}
/*
if (isset($_GET['fromDropDown'])){  // coming from index.htm. $i==0.
    $i=$_GET['i'];
}
*/
$warn=null;
$relevanceValueTrueFalse=false;
$relCtr=0;
foreach($_GET as $ky => $val){/*LOOK AT ASSESSMENTS FROM PREVIOUS SCREEN*/
	if (strpos($ky, "rn") === 0)  {
        if ($val != "hidden") {# Relevance judgment was selected
            $relevanceValueTrueFalse = true;
            $rel = $val;
            list($rn, $qid, $docid, $user) = explode("_", $ky);
            $arrayOfJudgments[$relCtr]=$val;
            $arrayOfWarningStyles[$relCtr]="";
        }
        else{
            $relevanceValueTrueFalse = false;/*NOT SET!!!*/
            $arrayOfJudgments[$ky]="hidden";
            if (!isset($_GET['previous']))
                $arrayOfWarningStyles[$relCtr]=" warning";
        }
        $arrayOfCheckedArrays[$relCtr]=createValuedCheckedArray($val);
        $relCtr++;
	}
}
if( !($relevanceValueTrueFalse) ){ /*Assessor did not select all relevance grades*/
    if (isset($_GET['next'])){
        //print ("next=" . isset($_GET['next']));
        $i=$_GET['next']-$_SESSION['configs']['hitsPerScreen']; // stay where you are, dont proceed to next.
        $warn=1;
    }
    if (isset($_GET['previous'])) {
        $i = $_GET['previous'];
    }
}else {/*Assessor DID select all relevance grades, can go to next screen*/
    if (isset($_GET['previous'])) {
        //print("previous set" . $_GET['previous']);
        $i = $_GET['previous'];
    }
    if (isset($_GET['next'])) {
        $i = $_GET['next'];
    }
}
$_SESSION['firstInScreen']=$i;
/*
print("list args");
echo $i; // Doc Number current qid 
echo "rn"; // radioName: carries a combination bookid_qid
echo "id" ; // $id carries a combination bookid_qid
echo "charlotte brontë";
print(";;;;;;;;;;;;;hitHash;;;;;;;;;;;;;;;;;;;;;;;;");
print("hh_".$i);
print_r( $hh[$i]);

var_dump($hh);
$cnt=count($hh);
print<<<DBG
i=$i,
qid=$qid 
hh[$i] = $hh[$i]
DBG;
*/
//print("i before func_row=$i");
/*Go through hits in current screen*/
$relCtr=0;
for($i=$_SESSION['firstInScreen'];
    $i<$_SESSION['firstInScreen'] + $_SESSION['configs']['hitsPerScreen'];
    $i++){
    /*THIS IS ONE OF ['hitsPerScreen'] TABLES IN A SINGLE SCREEN*/
    if ($i == count($hh))
        break;

    print( func_row( $i, // \$i = Doc Number in current qid hitlist
                     $hh[$i],/*"title", "author", "bla bla bla"*/
                     $qid,
                    count($hh),
                    $arrayOfJudgments[$relCtr],
                    $arrayOfWarningStyles[$relCtr],
                    $arrayOfCheckedArrays[$relCtr]

                   )
    );
    $relCtr++;
}
//$_SESSION['firstInScreen']=$i;
?>