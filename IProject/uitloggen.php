<?php
include 'includes/header.php';


//if (isset($_SESSION['gebruikersnaam'])){

?>
<div class="container">
    <div class="offset-2 col-md-8 mt-4">
        <div class="alert bg-orange2" role="alert">
            <h4 class="alert-heading"></h4>
            <p>U wordt uitgelogd.</p>
            <p class="mb-2">U wordt terug gestuurd naar de homepage, Ogenblik geduld alstublieft.</p>
            <? php uitloggen();  
            header("Refresh:5; url=index.php");
            ?>
 
        </div>
    </div>
</div>
<?php
uitloggen();
//} else { include 'includes/404error.php';
//}
include 'includes/footer.php'
?>