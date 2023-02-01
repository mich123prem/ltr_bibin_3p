<?php
include_once "agig.inc.php";
if (!isset($_SESSION))
	session_start();
function getQuery( $queryTerm = "charlotte brontë", $nr_hits=20 ) {
  $query = <<<QRY
	{
	"sort" : [
    "_score"
    ],
    "size": $nr_hits,           # get 20 docs (default = 10)
    #"_source": ["work", "work.subjects"], # get only wanted fields
	 "query": { 
         "query_string":{"query":"$queryTerm"}# the query
	 }
   }			
QRY;

  return preg_replace( '~
    (" (?:[^"\\\\] | \\\\\\\\ | \\\\")*+ ") | \# [^\v]*+ | // [^\v]*+ | /\* .*? \*/
  ~xs', '$1', $query );
}
function sendQuery($queryString){
  $curl = "http://localhost:9200/" . "publication" . "/_search";
  $ch = curl_init();
  // set URL and other appropriate options
  //For å få resultatet i retur 
  curl_setopt( $ch, CURLOPT_RETURNTRANSFER, 1 );
  curl_setopt( $ch, CURLOPT_CUSTOMREQUEST, "POST" );
  curl_setopt( $ch, CURLOPT_POSTFIELDS, $queryString );
  curl_setopt( $ch, CURLOPT_HTTPHEADER, array( 'Content-Type: application/json' ) );
  curl_setopt( $ch, CURLOPT_URL, $curl );
  $ret=curl_exec( $ch );
  //Få resultatet i retur
  return $ret;
}
?>