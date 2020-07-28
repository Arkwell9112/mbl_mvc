<?php
// Page pour l'affichage de la demande de réinitialisation du mot de passe.

include("/var/www/mbl/private/frags/fragHeader.php");
?>
    <article id="firstarticle">
        <div class="title">
            <img src="https://monboulangerlivreur.fr/public/imgs/lock.svg">
            <h3>Réinitialiser votre mot de passe</h3>
        </div>
        <div class="signform" id="toreplaceform">
            <form method="post" action="https://monboulangerlivreur.fr/public/router.php?request=actionPreReset">
                <?php
                if (preg_match("#special#", $status)) {
                    echo "<div class='errorpanel'>Une erreur est survenue, veuillez-réessayer.</div>";
                }

                if (preg_match("#badmail#", $status)) {
                    echo "<div class='errorpanel'>Aucun compte ne correspond à cette adresse e-mail.</div>";
                }

                if (preg_match("#yes#", $status)) {
                    echo "<div class='yespanel'>Un mail vous a été envoyé. Cliquez sur le lien dans le mail pour réinitialiser votre mot de passe. N'oubliez pas de regarder dans vos courriers indésirables.</div>";
                }
                ?>
                <input name="mail" type="email" placeholder="Adresse e-mail"><br>
                <input type="submit" id="submit" value="Réinitialiser">
            </form>
        </div>
    </article>
<?php include("/var/www/mbl/private/frags/fragFooter.php"); ?>