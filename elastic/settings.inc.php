<?php
if (!isset($_SESSION))
	session_start();
function closeIndex( $name = "publication" ) {
  $curl = "http://localhost:9200/" . $name . "/_close";
  $ch = curl_init();

  // set URL and other appropriate options
  //For å få resultatet i retur
  curl_setopt( $ch, CURLOPT_RETURNTRANSFER, 1 );
  curl_setopt( $ch, CURLOPT_CUSTOMREQUEST, "POST" );
  //curl_setopt( $ch, CURLOPT_POSTFIELDS, $settingData );
  curl_setopt( $ch, CURLOPT_HTTPHEADER, array( 'Content-Type: application/json' ) );
  curl_setopt( $ch, CURLOPT_URL, $curl );

  //Få resultatet i retur
  return curl_exec( $ch );
}
function openIndex( $name = "publication" ) {
  $curl = "http://localhost:9200/" . $name . "/_open";
  $ch = curl_init();

  // set URL and other appropriate options
  //For å få resultatet i retur
  curl_setopt( $ch, CURLOPT_RETURNTRANSFER, 1 );
  curl_setopt( $ch, CURLOPT_CUSTOMREQUEST, "POST" );
  //curl_setopt( $ch, CURLOPT_POSTFIELDS, $settingData );
  curl_setopt( $ch, CURLOPT_HTTPHEADER, array( 'Content-Type: application/json' ) );
  curl_setopt( $ch, CURLOPT_URL, $curl );

  //Få resultatet i retur
  return  curl_exec( $ch );
}

function getMainSettings() {
  $settings = <<<SETTINGS
{  // two shards with a single replica
    "settings" : {
        "index" : {
           # "number_of_shards" : 6,
           # "number_of_replicas" : 1
           "similarity" : { "default" : { "type" : "LMJelinekMercer", "lambda":"0.4" }
            }
        }
        ,
    "mappings": {
            "html": {
            "properties": {
#                "post_date": { "type": "date" }
#                ,
                "title": {"type": "text" }
                ,
#                "id": { "type": "keyword"}
#                ,
                "text": { "type": "text" }
                ,
                "description": {"type": "text"}
                ,
                "keywords": {"type": "keyword"}
                ,
                "classification":{"type": "text"}
                }
            }
        }
    }
}
SETTINGS;

  return preg_replace( '~
    (" (?:[^"\\\\] | \\\\\\\\ | \\\\")*+ ") | \# [^\v]*+ | // [^\v]*+ | /\* .*? \*/
  ~xs', '$1', $settings );
}


?>