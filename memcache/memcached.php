<?php
if (!isset($_SESSION))
	session_start();
if (!isset($GLOBALS['m'])) {
	$GLOBALS['m'] = new Memcache();
	$m = $GLOBALS['m'];
	$m -> addServer('localhost', 11211);
/*	
	$GLOBALS[''eksternUriHash''] = array();
	$eksternUriHash = $GLOBALS['eksternUriHash'];
	if (!($GLOBALS['eksterUriHash'] = $m -> get('ekstern_uri_hash'))) {
	  $eksternUriHash = makeAuthorityHash_ekstern();
	  $m -> set('ekstern_uri_hash', $eksternUriHash);
	}	
	
	$GLOBALS['eksternUriHash'] = array();
	$eksternUriHash = $GLOBALS['eksternUriHash'];
	if (!($GLOBALS['eksterUriHash'] = $m -> get('ekstern_uri_hash'))) {
	  $eksternUriHash = makeAuthorityHash_ekstern();
	  $m -> set('ekstern_uri_hash', $eksternUriHash);
	}
	
	$GLOBALS['internUriHash'] = array();
	$internUriHash = $GLOBALS['internUriHash'];
	if (!($internUriHash = $m -> get('intern_uri_hash'))) {
	  $eksternUriHash = makeAuthorityHash_intern();
	  $m -> set('inttern_uri_hash', $intternUriHash);
	  
	}
	
	$GLOBALS['docHash'] = array();
	$docHash = $GLOBALS['docHash'];
	if (!($docHash = $m -> get('doc_hash'))) {
	  $docHash = makeDocHash();
	  $m -> set('doc_hash', $docHash);
	}
*/
}
?>