<?php
include 'email.php';
include 'email2.php';

/* deleting verificatie code*/
function haalCodeOp($id){
    try {
        require('core/dbconnection.php');
        $sqlSelect = $dbh->prepare("select email, type from Verificatie where verificatiecode = :id");

        $sqlSelect->execute(
            array(
                ':id' => $id              
            ));
            $records = $sqlSelect->fetch(PDO::FETCH_ASSOC);
    
            return $records;

    } catch (PDOexception $e) {
        echo "er ging iets mis error: {$e->getMessage()}";
    }

}
/* update gebruiker naar geverifieerd */
function updateGebruikerVerificatie($input){
    try {
        require('core/dbconnection.php');
        $sqlSelect = $dbh->prepare("UPDATE Gebruiker SET verifieerd = 1
        WHERE gebruikersnaam = :gebruikersnaam");

        $sqlSelect->execute(
            array(
                ':gebruikersnaam' => $input['0']
            ));

    } catch (PDOexception $e) {
        echo "er ging iets mis error: {$e->getMessage()}";
    }

}

/* deleting verificatie code*/
function deleteVerificatieRij($email, $type){
    try {
        require('core/dbconnection.php');
        $sqlSelect = $dbh->prepare("delete from Verificatie where email = :email and type = :type");

        $sqlSelect->execute(
            array(
                ':email' => $email,
                ':type' => $type
            ));

    } catch (PDOexception $e) {
        echo "er ging iets mis error: {$e->getMessage()}";
    }

}

/* Ophalen van verficatie code */
function HaalGebruikerOp($gebruikersnaam){

    try {
        require('core/dbconnection.php');
        $sqlSelect = $dbh->prepare("select gebruikersnaam, wachtwoord, vraag, antwoordtekst from Gebruiker
      where gebruikersnaam = :gebruikersnaam");

        $sqlSelect->execute(
            array(
                ':gebruikersnaam' => $gebruikersnaam
            ));

        $records = $sqlSelect->fetch(PDO::FETCH_ASSOC);

        return $records;

    } catch (PDOexception $e) {
        echo "er ging iets mis error: {$e->getMessage()}";
    }
}

/* Ophalen van verficatie code */
function HaalVerficatiecodeOp($email, $type){

    try {
        require('core/dbconnection.php');
        $sqlSelect = $dbh->prepare("select verificatiecode, eindtijd from Verificatie where email = :email
      And type = :type ");

        $sqlSelect->execute(
            array(
                ':email' => $email,
                ':type' => $type
            ));

        $records = $sqlSelect->fetch(PDO::FETCH_ASSOC);

        return $records;

    } catch (PDOexception $e) {
        echo "er ging iets mis error: {$e->getMessage()}";
    }
}

/* Verificate code en eindtijd aanmaken*/
function VerificatieCodeProcedure($email, $type){
    try {
        require('core/dbconnection.php');
        $sqlSelect = $dbh->prepare("EXEC verificatie_toevoegen @mail = :email,
      @type = :type");

        $sqlSelect->execute(
            array(
                ':email' => $email,
                ':type' => $type
            )
        );
    } catch (PDOexception $e) {
        echo "er ging iets mis error: {$e->getMessage()}";
    }
}

/* Voeg gebruiker toe aan database */
function InsertGebruiker($input){
    $hashedWachtwoord = password_hash($input['4'], PASSWORD_DEFAULT);
    try {
        // SQL insert statement
        require('core/dbconnection.php');
        $sqlInsert = $dbh->prepare("INSERT INTO Gebruiker (
       gebruikersnaam, voornaam, achternaam, geslacht, adresregel1, adresregel2,
       postcode, plaatsnaam, land, geboortedatum, email,
       wachtwoord, vraag, antwoordtekst, verkoper)
      values (
        :rGebruikersnaam, :rVoornaam, :rAchternaam, :rGeslacht, :rAdresregel1, :rAdresregel2,
        :rPostcode, :rPlaatsnaam, :rLand, :rGeboortedatum, :rEmail,
        :rWachtwoord, :rVraag, :rAntwoordtekst, :rVerkoper)");

        $sqlInsert->execute(
            array(
                ':rGebruikersnaam' => $input['0'],
                ':rVoornaam' => $input['1'],
                ':rAchternaam' => $input['2'],
                ':rGeslacht' => $input['3'],
                ':rAdresregel1' => $input['5'],
                ':rAdresregel2' => $input['6'],
                ':rPostcode' => $input['7'],
                ':rPlaatsnaam' => $input['8'],
                ':rLand' => $input['9'],
                ':rGeboortedatum' => $input['10'],
                ':rEmail' => $input['11'],
                ':rWachtwoord' => $hashedWachtwoord,
                ':rVraag' => $input['12'],
                ':rAntwoordtekst' => $input['13'],
                ':rVerkoper' => $input['14'],

            ));
    }
    catch (PDOexception $e) {
        echo "er ging iets mis insert {$e->getMessage()}";
    }
}

/* Is er al een gebruiker aangemeld met hetzelfde gebruikersnaam */
function bestaatGebruikersnaam($gebruikersnaam)
{
    try {
        require('core/dbconnection.php');
        $sqlSelect = $dbh->prepare("select gebruikersnaam from Gebruiker where gebruikersnaam=:gebruikersnaam");

        $sqlSelect->execute(
            array(
                ':gebruikersnaam' => $gebruikersnaam
            )
        );
        $records = $sqlSelect->fetch(PDO::FETCH_ASSOC);
        return $records;

    }
    catch (PDOexception $e) {
        echo "er ging iets mis error: {$e->getMessage()}";
    }
}

/* Is er al een gebruiker aangemeld met hetzelfde emailadres */
function bestaatValidatie($email)
{
    try{
        require('core/dbconnection.php');
        $sqlSelect = $dbh->prepare("select email from Verificatie where email =:email");

        $sqlSelect->execute(
            array(
                ':email' => $email,
            ));
        $records = $sqlSelect->fetch(PDO::FETCH_ASSOC);
        return $records;

    }
    catch (PDOexception $e) {
        echo "er ging iets mis error19: {$e->getMessage()}";
    }
}

/* Is er al een gebruiker aangemeld met hetzelfde emailadres */
function bestaatEmailadres($email)
{
    try{
        require('core/dbconnection.php');
        $sqlSelect = $dbh->prepare("select email from Gebruiker where email=:email");

        $sqlSelect->execute(
            array(
                ':email' => $email,
            ));
        $records = $sqlSelect->fetch(PDO::FETCH_ASSOC);
        return $records;

    }
    catch (PDOexception $e) {
        echo "er ging iets mis error: {$e->getMessage()}";
    }
}

/*registeren vragen ophalen */
function resetVragen()
{
    try {
        require('core/dbconnection.php');
        $sqlSelect = $dbh->query("select vraagnr, vraag from Vragen");

        echo '<label for="inputGeheimeVraag">Geheime Vraag</label>';
        echo '<select name="rGeheimV" class="form-control" id="inputGeheimeVraag">'; // Open your drop down box

        // Loop through the query results, outputing the options one by one
        while ($row = $sqlSelect->fetch(PDO::FETCH_ASSOC)) {
            echo '<option value="'.$row['vraagnr'].'">'.$row['vraagnr'].'.&nbsp'.$row['vraag'].'</option>';
        }
        echo '</select>';// Close your drop down box

    } catch (PDOexception $e) {
        echo "er ging iets mis error: {$e->getMessage()}";
    }
}

function vragenOphalen() { // haalt alleen de veiligheidsvragen op
    try {
        require('core/dbconnection.php');
        $sqlvragenOphalen = $dbh -> prepare ("SELECT vraagnr, vraag FROM vragen");
        $sqlvragenOphalen -> execute();

        while ($info = $sqlvragenOphalen-> fetch(PDO::FETCH_ASSOC)){
            //var_dump($info);
            echo '<option value="'.$info['vraagnr'].'">'.$info['vraagnr'].'.&nbsp'.$info['vraag'].'</option>';
        }
    } catch (PDOexception $e) {
        echo 'error: vragen niet opgehaald';
    }// einde catch exeption $e
}// einde functie vragenOphalen

/* haal landen op */
function landen()
{
    try {
        require('core/dbconnection.php');
        $sqlSelect = $dbh-> prepare ("select Id, Name from Landen");
        $sqlSelect  -> execute();

        echo '<label for="inputLanden">Land</label>';
        echo '<select name="rLand" class="form-control" id="inputLanden">';
        // Open your drop down box

        // Loop through the query results, outputing the options one by one
        while ($row = $sqlSelect->fetch(PDO::FETCH_ASSOC)) {

            echo '<option value="'.$row['Id'].'">'.$row['Name'].'</option>';
        }
        echo '</select>';// Close your drop down box
    } catch (PDOexception $e) {
        echo "er ging iets mis error: {$e->getMessage()}";
    }
}

function StuurWachtwoordResetMailEmail($Email, $Code){


    ini_set( 'display_errors', 1 );
    error_reporting( E_ALL );
    $from = "no-reply@iconcepts.nl";
    $to = $Email;
    $subject = "Wachtwoord reset EenmaalAndermaal";
    $message = email2($Code);

    $headers = 'MIME-Version: 1.0' . "\r\n";
    $headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
    $headers .= "From:" .$from;

    mail($to,$subject,$message, $headers);

}

function StuurRegistreerEmail($Email, $Code){

    ini_set( 'display_errors', 1 );
    error_reporting( E_ALL );
    $from = "no-reply@iconcepts.nl";
    $to = $Email;
    $subject = "Validatie link account registreren";
    $message = email($Code);

    $headers = 'MIME-Version: 1.0' . "\r\n";
    $headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
    $headers .= "From:" .$from;

    mail($to,$subject,$message, $headers);

}

function WordtVerkoper() {
    $Gebruiker = $_SESSION["gebruikersnaam"];
    try{
        require('core/dbconnection.php');
        $sql = "EXEC dbo.verificatie_toevoegen @gebruiker = :Gebruiker @type = 'post'";
        $sqlSelect = $dbh->prepare($sql);

        $sqlSelect->execute(array(':Gebruiker' => $Gebruiker));

        MaakVerkoperBrief($Gebruiker);

    }
    catch (PDOexception $e) {
        echo "er ging iets mis error: {$e->getMessage()}";

    }
}

function MaakVerkoperBrief($Gebruiker){
    try{
        require('core/dbconnection.php');

        $sql = "SELECT voornaam, achternaam, geslacht, adresregel1, adresregel2, postcode, plaatsnaam, land, verificatiecode, eindtijd FROM Gebruiker INNER JOIN Verificatie ON Gebruiker.gebruikersnaam = Verificatie.gebruikersnaam WHERE type = 'post' AND Gebruiker.gebruikersnaam = :gebruiker";
        $sth = $dbh->prepare($sql);

        $parameters = array(':Gebruiker' => $Gebruiker);
        $sth->execute($parameters);

        $records = $sth->fetchall(PDO::FETCH_ASSOC);
        require('brief.php');
        Brief($records);
    }
    catch (PDOexception $e) {
        echo "er ging iets mis error: {$e->getMessage()}";
    }
}

function geslacht()
{

    try {
        require('core/dbconnection.php');
        $sqlSelect = $dbh-> prepare("select geslacht from Geslacht");
        $sqlSelect -> execute();
        echo '<label for="inputGeslacht">Geslacht</label>';
        echo '<select name="rGeslacht" class="form-control" id="inputGeslacht" required>';
        // Open your drop down box

        // Loop through the query results, outputing the options one by one
        while ($row = $sqlSelect->fetch(PDO::FETCH_ASSOC)) {
            echo '<option value="'.$row['geslacht'].'">'.$row['geslacht'].'</option>';
        }
        echo '</select>';// Close your drop down box

    } catch (PDOexception $e) {
        echo "er ging iets mis error: {$e->getMessage()}";
    }

}

/* stuur reset email naar gebruiker */
function emailResetWachtwoord($gebruikersnaam)
{
    try{
        require('core/dbconnection.php');
        $sqlSelect = $dbh->prepare("select email, voornaam from gebruikers where gebruikersnaam = :gebruikersnaam");

        $sqlSelect->execute(
            array(
                ':gebruikersnaam' => $gebruikersnaam,
            ));
        $records = $sqlSelect->fetch(PDO::FETCH_ASSOC);

        ini_set( 'display_errors', 1 );
        error_reporting( E_ALL );
        $from = "no-reply@iconcepts.nl";
        $to = $records['email'];
        $subject = "Validatie code account registreren";
        $message = '<h1> Hallo '.$records['voornaam'].'</h1>,
                  <br>
                  <br>
                  Bedankt voor het registreren. Hieronder staat de code die ingevoerd
                  moet worden om het registeren te voltooien:
                  <br>
                  <h1>'.rand(1000,9999).'
                  <br>
                  Als u dit niet bent, wijzig dan uw wachtwoord
                  en overweeg ook om uw e-mailwachtwoord te wijzigen om uw
                  accountbeveiliging te garanderen.';
        $headers = "From:" .$from;
        mail($to,$subject,$message, $headers);
        ;

    }
    catch (PDOexception $e) {
        echo "er ging iets mis error: {$e->getMessage()}";
    }
}

/* Reseten van wachtwoord */
function veranderWachtwoord($email,$wachtwoord)
{
    try{
        require('core/dbconnection.php');
        $sqlSelect = $dbh->prepare("update Gebruiker set wachtwoord = :wachtwoord
                                  where email = :email");

        $sqlSelect->execute(
            array(
                ':wachtwoord' => $wachtwoord,
                ':email' => $email,
            ));
    }
    catch (PDOexception $e) {
        echo "er ging iets mis error: {$e->getMessage()}";
    }
}

function controleVraag($vraag){
    try{
        require('core/dbconnection.php');
        $sqlSelect = $dbh->prepare("select gebruiker.vraag from gebruikers join vragen
        on gebruiker.vraag = vragen.vraagnr where gebruiker.email=:email");

        $sqlSelect->execute(
            array(
                ':email' => $email,
            ));
        $records = $sqlSelect->fetch(PDO::FETCH_ASSOC);
        return $records;

    }
    catch (PDOexception $e) {
        echo "er ging iets mis error: {$e->getMessage()}";
    }


}
/*
Komen de wachtwoorden overeen bij het registreren en wachtwoord reset
function controleerWachtwoord($rWachtwoord, $rHerhaalWachtwoord)
{
    if ($rWachtwoord == $rHerhaalWachtwoord) {
        return true;
    } else {
        return false;
    }
}


function haalPostsOp($rubriek)
{
    if (empty($rubriek) || $rubriek == 'Alle rubrieken') {
        $query = 'select * from posts order by unixtijd desc';
    } else {
        $query = "select * from posts where rubriek like '$rubriek' order by unixtijd desc";
    }
    try {
        require('connecting.php');

        $sqlSelect = $dbh->prepare("$query");

        $sqlSelect->execute();

        $records = $sqlSelect->fetchAll(PDO::FETCH_ASSOC);
        return $records;

    } catch (PDOexception $e) {
        echo "er ging iets mis error: {$e->getMessage()}";
    }
}


function plaatsPost($kopje, $tekst, $rubriek, $dbh, $unixtijd)
{

    if ($kopje == null || $tekst == null || $rubriek == null) {
        echo 'Één van de velden is niet ingevuld ';
        header("Refresh: 2; url=forum.php");
        die();
    } else {

        try {
            require('connecting.php');

            $insertQuery = $dbh->prepare("insert into posts (kopje, tekst, bezoeker, rubriek, unixtijd) values(:kopje, :tekst, :bezoeker, :rubriek, :unixtijd)");
            $insertQuery->execute(
                array(
                    ':kopje' => $kopje,
                    ':tekst' => $tekst,
                    ':bezoeker' => $_SESSION['loginnaam'],
                    ':rubriek' => $rubriek,
                    ':unixtijd' => $unixtijd
                )
            );
        } catch (PDOexception $e) {
            echo "er ging iets mis error: {$e->getMessage()}";
        }
    }
}


function geefVideoDetails($id)
{
    try {
        require('connecting.php');
        $sqlSelect = $dbh->prepare("select * from videos where id = $id");
        $sqlSelect->execute();
        $records = $sqlSelect->fetchAll(PDO::FETCH_ASSOC);
        return $records;

    } catch (PDOexception $e) {
        echo "er ging iets mis error: {$e->getMessage()}";
    }
}

function haalVideosOp($rubriek)
{
    if (empty($rubriek) || $rubriek == 'Alle rubrieken') {
        $query = 'select * from videos';
    } else {
        $query = "select * from videos where rubriek like '$rubriek'";
    }
    try {
        require('connecting.php');

        $sqlSelect = $dbh->prepare("$query");

        $sqlSelect->execute();

        $records = $sqlSelect->fetchAll(PDO::FETCH_ASSOC);
        return $records;

    } catch (PDOexception $e) {
        echo "er ging iets mis error: {$e->getMessage()}";
    }
}
*/

function gegevensIngevuld (){
    if(isset($_SESSION['gebruikersnaam'])){
        try {
            require('core/dbconnection.php');
            $sqlSelect = $dbh->prepare("SELECT gebruikersnaam FROM Verificatie
WHERE type = 'post' AND gebruikersnaam = :gebruikersnaam ");
            $sqlSelect->execute(
                array (
                    ':gebruikersnaam' => $_SESSION['gebruikersnaam'],
                ));

            $verkoperVerificatie = $sqlSelect->fetchAll(PDO::FETCH_ASSOC);

        } catch (PDOexception $e) {
            echo "er ging iets mis error: {$e->getMessage()}";
        }
    }   

    if ( empty( $verkoperVerificatie['gebruikersnaam']) == true){
        $antwoord = false;
    } else {
        $antwoord = true;
    }
        return $antwoord;
        }

?>
