<?php
include 'includes/header.php';

if(isset($_SESSION['gebruikersnaam'])){
  $verwijderen = false;

if(isset($_GET['status'])){
  if($_GET['status'] == 'verkopen'){
    $Veiling = VerkoopVeiling($_GET['id']);
    VerstuurVerkoopMail($Veiling, true);
    VerstuurVerkoopMail($Veiling, false);

  }
  if($_GET['status'] == 'verwijderen'){
    $Veiling = VerwijderVeiling($_GET['id'], $_SESSION['gebruikersnaam']);
    VerstuurVerwijderMail($Veiling, true);
    VerstuurVerwijderMail($Veiling, false);

    $verwijderen = true;
  }
}  


?>

<div class="container-fluid">
    <div class="col">
      <div class="row mt-2">    
        <?php if($verwijderen){
          $verwijderen = false;      
          // laat melding zien aan gebruiker
          echo '<div class="container">
                  <div class="h-100 row align-items-center">
                    <div class="col">
                              <div class="alert alert-success alert-dismissible fade show mt-3" role="alert">
                                <strong>Het voorwerp is verwijderd!</strong> U kunt op het kruisje klikken om deze melding te sluiten.
                                <button type="button" class="close pt-0" data-dismiss="alert" aria-label="Close">
                                  <span aria-hidden="true">&times;</span>
                                  </button>
                              </div>
                      </div>
                    </div>
                  </div>';
        }?>  
              <button type="button" class="btn btn-secondary btn-sm btn-block">Mijn advertenties</button>
                <?php 
                $advertenties = HaalMijnAdvertentieOp($_SESSION['gebruikersnaam']);
                
                if(!empty($advertenties)){ 
                foreach ($advertenties as $rij) {
                    $details = DetailAdvertentie($rij['voorwerpnr']);
                    $locatie = '../pics/';
                    if(substr($details['illustratieFile'] , 0 ,2 ) == 'ea'){
                        $locatie = 'upload/';
                    } 
                    if(strlen($details['titel']) >= 40){
                        $details['titel'] = substr($details['titel'],0,40);
                        $details['titel'] .= '...';
                    }
                    echo '
                    <div class="col-md-3 p-2">
                    <div class="card">
                    <div class="card-img-boven">
                      <img src="'.$locatie.$details['illustratieFile'].'" alt="Foto bestaat niet">
                    </div> 
                      <h5 class="card-header"><a href="advertentie.php?id='.$details['voorwerpnr'].'">'.$details['titel'].'</a></h5>
                        <div class="card-body">
                          <h4 class="card-text">€ '.number_format($details['startprijs'], 2, ',', '.').'</h4>
                          <p class="card-text"><a href="#">'.$details['verkoper'].'</a><br>
                          '.$details['land'].', '.$details['plaatsnaam'].'</p>
                          <a href="advertentie.php?id='.$details['voorwerpnr'].'" class="btn btn-block btn-primary py-2">Ga naar artikel</a>                                                                         
                          <a class="btn btn-block btn-success py-2" href="mijnadvertenties.php?id='.$details['voorwerpnr'].'&status=verkopen" >Verkopen</a>
                          <a class="btn btn-block btn-danger py-2"  href="mijnadvertenties.php?id='.$details['voorwerpnr'].'&status=verwijderen">Verwijderen</a>
                          
                        </div>
                    </div>
                    </div>';
        
                }
              }
              else{
                echo '
                <div class="container">
                 <div class="h-100 row align-items-center py-2">
                  <div class="col">
                    <div class="alert alert-success" role="alert">
                      <strong>U heeft nog geen advertenties geplaatst!</strong> Klik op veilen om een voorwerp te plaatsen.
                    </div>
                  </div>
                 </div>
                </div>';
              }
                ?>
            </div>         
    </div>
</div>

<?php 
}
else{
    include 'includes/404error.php';
}
include 'includes/footer.php';
?>