<?php
#phpinfo();
#die();
#print(get_include_path());
#die();
error_reporting(E_ERROR | E_WARNING | E_PARSE | E_NOTICE);
if (!isset($_SESSION))
	session_start();


#$_SESSION["user"]=1;
$_SESSION['configs']=include_once "admin/config.php";
include_once "html.inc.php";
include_once "elastic.inc.php";
include_once "memcache.inc.php";
include_once "mysql.inc.php";
if (!isset($_SESSION['dblink']) || gettype($_SESSION['dblink']) != "resource" )
    if (!database_connect())
	    die("<p>database failed</p>");
?>
<?php if (!isset($_GET)): ?>
<?php
#	$cfg=parse_ini_file("php.ini");
#	print_r($cfg);
    print("connecting to database");
	

	include_once "head.html";
	//print("entering<br/>");
	//print( closeIndex() );
	$settingData = getMainSettings();
	$curl = "http://localhost:9200/publication/_settings";
	$ch = curl_init();

	// set URL and other appropriate options
	//For å få resultatet i retur
	curl_setopt( $ch, CURLOPT_RETURNTRANSFER, 1 );
	curl_setopt( $ch, CURLOPT_CUSTOMREQUEST, "PUT" );
	curl_setopt( $ch, CURLOPT_POSTFIELDS, $settingData );
	curl_setopt( $ch, CURLOPT_HTTPHEADER, array( 'Content-Type: application/json' ) );
	curl_setopt( $ch, CURLOPT_URL, $curl );

	//Få resultatet i retur
	$out = curl_exec( $ch );
	//print( " opening index <br/>" );

?>
<?php endif ?>

<?php if (!isset($_GET['user'])): ?>

<h2>Relevansvurdering av utvalgte søk i Deichmanske Biblioteks katalog.</h2>
<p>Vennligst velg deg selv fra en liste med brukere</p>
<form >
	
  <select name="user" >
		<?php print(getOptionsFromDB("users")); ?>
  </select>
    <label>
        Passord
  <input type="text" name="pass">
    </label>
 <input type="submit" value="Velg"/>
</form>
<?php else: ?>
    <!--$_GET['user'] is set -->

    <?php if (isset($_GET['pass']) ): ?>
        <?php if ( $_GET['pass'] != passByID($_GET['user']) ): ?>
            (Ikke <?php print(nameByID($_GET['user'])) ?> eller feil passord? <a href="index.php">Prøv på nytt</a>)
        <?php else: ?>
            <?php
                if (isset($_GET['last'])){
                    foreach($_GET as $ky => $val){
                        if (strpos($ky, "rn")===0){
                            $rel=$val;
                            list($rn, $qid, $docid, $user) = explode("_", $ky);
                            setGrade($qid, $docid, $user, $rel);
                        }
                    }
                }
            ?>
            <?php $_SESSION["user"]=$_GET["user"]; ?>
            <p>Velkommen, <?php print(nameByID($_GET['user'])) ?>
                (Ikke <?php print(nameByID($_GET['user'])) ?>? <a href="index.php">Klikk her</a>)</p>
                <?php include "html/endform.php"?>
        <?php endif ?>

    <?php else: ?>
	    <?php $_SESSION["user"]=$_GET["user"]; ?>

        <?php include "html/endform.php"?>
    <?php endif ?>
<?php endif ?>

</body>
</html>