<p>Votre carte de paiement:</p><br>
<h4>Numéro de carte:</h4>
<?php
$last = $method->card["last4"];
echo "XXXX-XXXX-XXXX-$last";
?>
<br><br>
<h4>Date d'expiration:</h4>
<?php
$date = $method->card["exp_month"] . "-" . $method->card["exp_year"];
echo $date;
?>
<br><br>
<form method="post" action="https://monboulangerlivreur.fr/public/router.php?request=viewAccount&status=editcard">
    <input class="editcardbutton" type="submit" value="Changer de carte"><br><br>
</form>
<form method="post" action="https://monboulangerlivreur.fr/public/router.php?request=actionDeletePayment">
    <input class="editcardbutton" type="submit" value="Supprimer la carte">
</form>
