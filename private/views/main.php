<?php
// Page d'accueil.
include("/var/www/mbl/private/frags/fragHeader.php");
?>
    <article id="firstarticle">
        <div class="title">
            <img src="https://monboulangerlivreur.fr/public/imgs/delivery.svg">
            <h3>Faites-vous livrer à domicile !</h3>
        </div>
        <ul>
            <li>Votre pain est livré directement chez vous !</li>
            <br>
            <li>Faites du bien à la planète en utilisant moins votre voiture !</li>
            <br>
            <li>Le pain arrive tout chaud directement dans votre panier !</li>
        </ul>
    </article>
    <article>
        <div class="title">
            <img src="https://monboulangerlivreur.fr/public/imgs/time.svg">
            <h3>Gagnez du temps !</h3>
        </div>
        <ul>
            <li>Plus besoin de se déplacer ! Le pain vient à vous !</li>
            <br>
            <li>Une tâche de moins à faire dans le journée c'est plus de repos à la fin !</li>
            <br>
            <li>Du pain chaud sans aucuns efforts !</li>
        </ul>
    </article>
    <article id="lastarticle">
        <div class="title">
            <img id="pay" src="https://monboulangerlivreur.fr/public/imgs/pay.svg">
            <h3>Rechargez votre compte en ligne !</h3>
        </div>
        <ul>
            <li>Remettez de l'argent sur votre compte pain sans vous déplacer !</li>
            <br>
            <li>Rechargez aussi votre solde en boutique !</li>
            <br>
            <li>Vous êtes avertis dès que votre solde s'approche de 0€ !</li>
        </ul>
    </article>
    <article id="beginbutton">
        <a href="https://monboulangerlivreur.fr/public/router.php?request=viewRegister">Commencer maintenant !</a>
    </article>
<?php include("/var/www/mbl/private/frags/fragFooter.php") ?>