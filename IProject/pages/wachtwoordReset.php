<?php
require_once '../core/dbconnection.php';
include '../includes/header.php';
include '../includes/functies.php';
?>

<form action='wachtwoordReset.php' method ="post" role="form" >
    <div class="container">
        <div class="offset-md-3">
            <h1>Wachtwoord resetten <span class="h3 mb-3 font-weight-normal"></span></h1>
            <!-- hieronder wordt de tekst en invulveld voor de gebruikersnaam gemaakt -->
            <div class="form-row">
                <div class="form-group col-md-6">  
                    <label for="inputGebruikersnaam">Gebruikersnaam</label>
                    <input type="text" class="form-control" id="gebruikersnaam" placeholder="Gebruikersnaam">
                </div>
            </div>
            <!-- hieronder wordt de veiliheidsvraag geselecteerd -->
            <div class="form-row">
                <div class="form-group col-md-6">
                    <label for="selecteerVeiligheidsvraag">Selecteer je Veiligheidsvraag</label>
                    <select class="Veiliheidsvraag form-control">
                        <option selected>Selecteer</option> <!-- Standard in select menu -->
                        <?php vragenOphalen() ?>
                    </select>
                </div>
            </div>
            <!-- hieronder wordt de veiliheidsvraag beantwoord -->
            <div class="form-row">
                <div class="form-group col-md-6">
                    <label for="antwoordVeiligheidsvraag">Antwoord op veiligheidsvraag</label>
                    <input type="text" class="form-control" id="antwoordVeiligheidsvraag" placeholder="Antwoord">
                </div>
            </div>
            <!-- hieronder wordt het nieuwe wachtwoord gegeven (X2) -->
            <div class="form-row">
                <div class="form-group col-md-6">
                    <label for="antwoordVeiligheidsvraag">Nieuw wachtwoord</label>
                    <input type="password" class="form-control" id="nWachtwoord1" placeholder="Wachtwoord">
                </div>
            </div>
            <div class="form-row">
                <div class="form-group col-md-6">
                    <label for="antwoordVeiligheidsvraag">Herhaal nieuw wachtwoord</label>
                    <input type="password" class="form-control" id="nWachtwoord2" placeholder="Wachtwoord">
                </div>
            </div>
            <!-- hier wordt de reset button gemaakt. -->
            <div class="offset-md-2">
                <div class="form-row">
                    <button  type = "submit" value="wwReset "class="btn btn-primary">Reset Wachtwoord</button>
                </div>
            </div>
        </div>
    </div>
</form> 
<?php include '../includes/footer.php' ?>

<?php

    function vragenOphalen() {
    try {
        require('../core/dbconnection.php');
        $sqlSelect = $dbh->query("select vraagnr, vraag from vragen");

        while ($row = $sqlSelect->fetch(PDO::FETCH_ASSOC)) {
            echo '<option value="'.$row['vraagnr'].'">'.$row['vraagnr'].'.&nbsp'.$row['vraag'].'</option>';
        }
    } catch (PDOexception $e) {
        echo "er ging iets mis error: {$e->getMessage()}";
    }
}

                        if (isset($_POST['wwReset'])){
                            $gebruikersnaam = $_POST['gebruikersnaam'];
                            $veiligheidsvraag = $_POST['veiligheidsvraag'];
                            $veiligantwoord = $_POST ['veiligantwoord'];
                            $wachtwoord1 = $_POST ['wachtwoord1'];
                            $wachtwoord2 = $_POST['wachtwoord2'];
                        
                        if ()
                            
                        }// einde if isset

?>