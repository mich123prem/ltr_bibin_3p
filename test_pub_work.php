<?php

//include_once "html.inc.php";
include_once "elastic.inc.php";
#include_once "memcache.inc.php";
//include_once "mysql.inc.php";
//if (!isset($_GET['fromDropDown']))
 //   die("no query number");

//$qid=$_GET['fromDropDown'];
//$qt=qid2qry($qid);
$qt="Karsten og Petra";

$query_json = getQuery( $queryTerm = $qt, $nr_hits = 1000 );

$json=sendQuery( $query_json );
$json = preg_replace('/(\'|&#0*39;)/', '', $json);
$res = json_decode($json , true );
$hits = $res[ 'hits' ][ 'hits' ];
/*
if (!($_SESSION['hitHash'] = $m -> get('hitHash'))) {
	  $hh = array();
	  $m -> set('hitHash', $hh);
	  $_SESSION['hitHash']=&$hh;
}
	else{
		$hh=&$_SESSION['hitHash'];
	}
*/

$hh = array();
$_SESSION['hitHash']=&$hh;


$i=0;
$arr=[];
foreach ( $hits AS $hit ) {
    //print(json_encode($hit)) ;

    $obj = json_decode( json_encode( $hit, true ) );

    $obj=$obj->_source;
    var_dump($obj);
    die();
    $pid=$obj->id;
    $wid=$obj->work->id;
    if (!strstr($obj->mainTitle, "Karsten"))
        continue;
    $arr[$wid][]=array("pid"=>$pid,
                        "pTitle"=>$obj->mainTitle,
                        "pMedia"=>$obj->mediaType,
                        "wTitle"=>$obj->work->mainTitle);

    $i++;

}
print count($arr);
print_r($arr);