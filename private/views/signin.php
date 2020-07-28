<?php
// Page pour l'affichage de la connexion à l'espace membre.
include("/var/www/mbl/private/frags/fragHeader.php");
?>
    <article id="firstarticle">
        <div class="title">
            <img src="https://monboulangerlivreur.fr/public/imgs/lock.svg">
            <h3>Se connecter</h3>
        </div>
        <div class="signform" id="toreplaceform">
            <form method="post" action="https://monboulangerlivreur.fr/public/router.php?request=actionSignin">
                <?php
                if (preg_match("#special#", $status)) {
                    echo "<div class='errorpanel'>Une erreur est survenue, veuillez-réessayer.</div>";
                }
                if (preg_match("#badpasswd#", $status) || preg_match("#badusername#", $status)) {
                    echo "<div class='errorpanel'>Le mot de passe ou le nom d'utilisateur est incorrect.</div>";
                }
                if (preg_match("#notactive#", $status)) {
                    echo "<div class='errorpanel'>Le compte utilisateur n'est pas activé.</div>";
                }
                if (preg_match("#yesactive#", $status)) {
                    echo "<div class='yespanel'>Votre compte a bien été activé, vous pouvez vous connecter.</div>";
                }
                if (preg_match("#badtoken#", $status)) {
                    echo "<div class='errorpanel'>Votre compte n'a pas pu être activé, veuillez réessayer.</div>";
                }
                ?>
                <input name="username" type="text" placeholder="Nom d'utilisateur"><br>
                <input name="passwd" type="password" placeholder="Mot de passe"><br>
                <input id="submit" type="submit" value="Connexion">
            </form>
            <a class="bottomlink" href="https://monboulangerlivreur.fr/public/router.php?request=viewReset">Mot de passe
                oublié ?</a>
        </div>
    </article>
<?php include("/var/www/mbl/private/frags/fragFooter.php"); ?>