<h3><?php print(nameByID($_GET['user']))?>s SØK</h3>
<?php $_SESSION['firstInScreen']=0?>
<!-- USE is_array to find if wrong password -->

<p>Velg ett av søkene nedenfor.<br/>
    Søk med <span class="red">Rød skrift</span>
    har du allerede sett på, men kanskje ikke avsluttet eller ønsker å se over igjen.</p>
<form action="sendQueryGetHits.php">
    <!--
    * CHOOSE QUERY FROm DROPDOWN. Queries you have handled are red. You can choose to review them, or pick a new one.
    * or click button to logout (kill session)
   -->

    <select name="fromDropDown">
        <option selected="selected">Velg søk</option>
        <?php print(getOptionsFromDB("queries")) ?>
    </select>
    <input type="submit" value="Gå til valgt søk"/>
</form>

