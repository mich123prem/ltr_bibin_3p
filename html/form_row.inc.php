<?php
if (!isset($_SESSION))
	session_start();
include_once "head.html";
include_once "mysql.inc.php";
include_once "screen.php";

function getTableHead($currTblInScreen, $i){
    $displayed="undisplayed";
    $thd = " <tr>";
    if ($currTblInScreen == 0 )
        if ($i==0)
            $displayed="undisplayed";
        else
            $displayed="displayed";

    $thd .= <<<TBL
    <th class="nesteforrige $displayed">
    Forrige
    </th>
TBL;

    $thd .= <<<TBL
    
   <!-- <th>&nbsp;&nbsp;&nbsp;Søk&nbsp;&nbsp;&nbsp;</th>-->
    <th class="innhold">Omslagsbilde </th>
    <th class="innhold">Kilde-info</th>
    <th class="innhold">Din vurdering</th>
    <th class="nesteforrige">Neste</th>
 </tr>   
TBL;
     return $thd;

}
/*THIS IS ONE OF FOUR TABLES IN A SINGLE SCREEN*/

function func_row($i,/*Doc ordinal-number current qid (eks. 0-19 for 20 books pr. query)*/
				  $hit,
				  $qid,
                  $length, /* Actual number of hit obtained for current query. Could be a session-var*/
                  $judgment, /*"hidden" if no judgments yet*/
                  $warning,
                  $arrayOfChecked
				 )
{

    $n = $_SESSION['firstInScreen'] + $_SESSION['configs']['hitsPerScreen']; /*  == For turning on "previous" == */
    $p = $_SESSION['firstInScreen'] - $_SESSION['configs']['hitsPerScreen']; /*  ====== and "next" links ======= */
    $next = $n + 1;
    $previous = $p + 1;
    $relTableStyle = $vennligstVelgRelevansGrad = "";
    if ($warning != null) {
        $relTableStyle = " warning";
        $vennligstVelgRelevansGrad = '<div class="sentrer red">Vennligst velg relevansgrad</div>';
    }

    $user = $_SESSION["user"];

       /*var_dump($hit);
        die();*/

   /*
    *  METADATA TO BE PRESENTED
    */
    $description = "Ikke oppgitt";
    if (isset($hit->work->genres))
        $description = join(";", $hit->work->genres);

    $origTitle = "Ikke oppgitt";
    if (isset($hit->work->mainTitle))
        $origTitle= $hit->work->mainTitle;//join(";", $hit->work->mainTitle);

    $series = "Ikke oppgitt";
    if (isset($hit->series))
        $series= join(";", $hit->series);


    $title = "no title";
    if (isset($hit->fullTitle))
        $title = $hit->fullTitle;

    $author = "no author";
    if (isset($hit->author))
        $author = join(";", $hit->author);
    elseif (isset($hit->agents)){
        if (isset($hit->agents->contributors)){
            $val=$hit->agents->contributors[0];
            $author=$val;//explode("(", $val)[0];
        }
    } else{}
    $format = "Ikke oppgitt";
    if (isset($hit->mediaType))
        $format = $hit->mediaType;

    $audiences = "Ikke oppgitt";
    if (isset($hit->work->audiences))
        $audiences = join(";", $hit->work->audiences);

    $languages = "Ikke oppgitt";
    if (isset($hit->languages))
        $languages = join(";", $hit->languages);

    $publicationYear = "Ikke oppgitt";
    if (isset($hit->work->publicationYear))
        $publicationYear = $hit->work->publicationYear;

    $docid = $hit->work->id . $hit->mediaType;

    doc2db($docid, json_encode($hit));
    if (!$qid)
        $qid = $_SESSION['qid'];
    $query = qid2qry($qid);
    /* $radioName.='_'.$qid.'_'.$docid */
    /* $grade=SELECT grade from relevance WHERE doc= $docid and qid=$qid and assessor=$userid */
    //$checkedArray=array_fill(0,7, "");

    $grade = getGrade($qid, $docid, $user);
    /* == TODO: Test how "not relevant (0) behaves == */
    if (is_null($grade)) {//'0' alone will not fail
        /*The "0" value is interpreted as false, which is unfortunate*/
        $grade = "hidden";
    }
    $arrayOfChecked=createValuedCheckedArray($grade);
    $src = "test.png";
    if (isset($hit->coverImage))// && isset($hit->imagesByWith->{'150'}))
        $src = "https://deichman.no/api/images/resize/200" . $hit->coverImage;
    //print($src."<br/>");
    $image = <<<IMG
		<img src="$src" alt="book_cover"/>
IMG;
    $tbl="";

    if ($i == $_SESSION['firstInScreen']) {


        print <<<QUERY
        <h2>Hvor relevante er mediene nedenfor i forhold til søket <u>"$query"</u>?</h2>
QUERY;

        $tbl .= <<<TBL
            <form action="updateRelevance.php">
            <input type="hidden" name="user" value="$user"/>
        
        
TBL;
    }
    $currTblInScreen=$i - $_SESSION['firstInScreen'];
    $thead = getTableHead($currTblInScreen, $i);
    $tbl.=<<<TBL
    <table id="presentasjon">
    $thead    
    <tr>
TBL;
    $displayed = "undisplayed";
	if($currTblInScreen == 0
        &&
        $i > 0/*FIRST IN SCREEN, BUT NOT IN FIRST SCREEN*/
    )
        $displayed="displayed";


    $tbl.=<<<PRVBTN
        <td class="$displayed">
        <button class="$displayed" type="submit" name="previous" value="$p">forrige treff<br/> (nr. $previous)</button>
        </td>
PRVBTN;

	$tbl.=<<<TBL

	<!--<td style="padding:10px;white-space:nowrap">"$query"</td>-->
    <td class="innhold">$image</td>
	<td class="infocolumn innhold">
	    <span class="sterk">Tittel:</span> 
            $title<br/>
	    <hr/>
	    <span class="sterk">Forfatter:</span>
            $author<br/>
	    <hr/>
	    <span class="sterk">Sjanger</span>:
            $description
	    <hr/>    
	    <span class="sterk">Originaltittel</span>:
            $origTitle
	    <hr/>    
	    
	    <span class="sterk">Målgruppe</span>:
            $audiences
	    <br/>
	    <hr/>       
	    <span class="sterk">Språk</span>:
            $languages
	    <br/>
	    <hr/>
	    <span class="sterk">Format</span>:
            $format
	    <hr/>
	    <span class="sterk">utgitt</span>:
            $publicationYear
         <hr/>
	    <span class="sterk">Serie</span>:
            $series
	 
	 </td>
	 <td class="innhold"><!-- radioknapper -->
        <h5>Søk:"$query"</h5>
          <table class="sentrer$relTableStyle width100"  >
          <tr>
            <td class="lysegronn">
                <label  data-title="Godt samsvar mellom søketerm og kilde-info. Bør være blant de øverste resultatene">
              <input class="vurderingsradio" type="radio" name="rn_${qid}_${docid}_$user" value="2" id="id_2" {$arrayOfChecked[2]}/>
              <!-- highly_relevant --> Veldig relevant
                </label></td>
          </tr>
          
          <tr > 
            <td class="guloransje">
                <label data-title="Ville sett på den, \n men skal ikke blant de øverste resultatene" >
              <input  class="vurderingsradio" type="radio"  name="rn_${qid}_${docid}_$user" value="1" id="id_1" {$arrayOfChecked[1]}/>
              <!--non_relevant--> Delvis relevant
                </label>
            </td>
          </tr>
        
         <tr>
            <td class="ikkeroed">
            
              <label  data-title="Svarer definitivt ikke på søket">  
              <input class="vurderingsradio" type="radio"  name="rn_${qid}_${docid}_$user" value="0" id="id_nr_1_1" {$arrayOfChecked[0]}/>
              
              <!--non_relevant--> Ikke relevant
                </label>
               
            </td>
          </tr >
          
           <tr>
            <td class="vetikkegraa">
                <label>
              <input class="vurderingsradio" type="radio" name="rn_${qid}_${docid}_$user" value="-1" id="id_3" {$arrayOfChecked[3]}/>
              <!-- 
               --> Vet ikke
                </label>
            </td>
           </tr>
           <input class="skjul"
                   type="radio" name="rn_${qid}_${docid}_$user" value="hidden" id="id_4" 
            {$arrayOfChecked["hidden"]} 
            />
          </table> <!-- radioknapper for vurdering -->            

$vennligstVelgRelevansGrad
		</td>
TBL;
    /*== LAST IN SCREEN? == */
	if($i == count($_SESSION['hitHash']) - 1
        ) {
        $tbl .= <<<TBL
		<td><button type="submit" name="last" value="$n">siste treff <br/> tilbake til dine søk</button></td>
	<!--<td> <a href="index.php?qid=$qid&user={$_SESSION['user']}">Velg neste søk</a> </td>-->
TBL;
    }else{
        if ($currTblInScreen == $_SESSION['configs']['hitsPerScreen'] - 1
            &&
            $i < count($_SESSION['hitHash']) - 1) {
            $tbl .= <<<TBL

	        <td><button type="submit" name="next" value="$n">neste treff <br/> (nr. $next av $length)</button></td>
TBL;
        }else{

            $tbl .= <<<TBL

	        <td class="undisplayed">
	            <!--<button class="undisplayed" type="submit" name="next" value="$n">neste treff <br/> (nr. $next av $length)</button>-->
	        </td>
TBL;
        }

    }


        $tbl .= <<<TBL
	</tr>
	
	</table>
	
TBL;
        if ($i == count($_SESSION['hitHash']) - 1
            ||
            $i == $_SESSION['firstInScreen'] + $_SESSION['configs']['hitsPerScreen'] - 1
        ) {
            $tbl .= <<<TBL
        </form >
        <div class="inline storpadding venstre" > <a href="index.php?user={$_SESSION['user']}">Tilbake til dine søk</a>  </div>
TBL;

            $tbl .= <<<TBL
	</div>
		
TBL;
        }
        return $tbl;
}
?>