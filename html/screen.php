<?php
if (!isset($_SESSION))
	session_start();

include_once "mysql.inc.php";

function getDocsInScreen($screen_number){
    /*NEED:
        $_SESSION['hitArray'] - a sequential array with {$docid . $media_Type} objects as values
        $_SESSION['hitsPerScreen']number of documents in screen
    */
    $hh=$_SESSION['hitArray'];
    $hps=$_SESSION['configs']['hitsPerScreen'];
    $docNrs=array();//array_pad(array(), $hps, null);
    for ($i=0; $i<$hps; $i++) {
        $ind=$screen_number*$hps+$i;
        $docNrs[$ind]=$hh[$screen_number*$hps+$i];
    }
    return $docNrs;
}
function createValuedCheckedArray($val){/* == 3 : 0,1,2,  3 = vet ikke, 4="hidden" == */
    $ret=array_pad(array(), $_SESSION['configs']['levelsPerHit']+1," ");
    $ret["hidden"]=" ";
    if ($val == "hidden")
        //$ret[$_SESSION['configs']['levelsPerHit']+1]=" checked ";
        $ret["hidden"]=" checked ";
    elseif ($val == "-1")
        $ret[3]=<<<CHKD
         checked="checked"
CHKD;
    else
        $ret[$val]=<<<CHKD
         checked="checked"
CHKD;
    return $ret;

}


?>