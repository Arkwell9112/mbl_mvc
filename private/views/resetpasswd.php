<?php
include("/var/www/mbl/private/frags/fragHeader.php");
?>
    <article id="firstarticle">
        <div class="title">
            <img src="https://monboulangerlivreur.fr/public/imgs/lock.svg">
            <h3>Réinitialiser votre mot de passe</h3>
        </div>
        <div class="signform" id="toreplaceform">
            <form method="post" action="https://monboulangerlivreur.fr/public/router.php?request=actionReset">
                <?php
                if (preg_match("#special#", $status)) {
                    echo "<div class='errorpanel'>Une erreur est survenue, veuillez-réessayer.</div>";
                }

                if (preg_match("#badpasswd#", $status)) {
                    echo "<div class='errorpanel'>Le mot de passe doit contenir :<br>- Au moins 8 caractères.<br>- Une lettre minuscule et une majuscule.<br>- Un chiffre.<br>- Un caractère spécial.<br></div>";
                }
                if (preg_match("#diffpasswd#", $status)) {
                    echo "<div class='infopanel'>Les mots de passe ne correspondent pas.</div>";
                }

                if (preg_match("#yes#", $status)) {
                    echo "<div class='yespanel'>Votre mot de passe a bien été réinitialisé, vous pouvez maintenant vous connecter.</div>";
                }
                ?>
                <input name="passwd1" type="password" placeholder="Nouveau mot de passe"><br>
                <input name="passwd2" type="password" placeholder="Répétez nouveau mot de passe"><br>
                <input type="submit" id="submit" value="Réinitialiser">
            </form>
        </div>
    </article>
<?php include("/var/www/mbl/private/frags/fragFooter.php");