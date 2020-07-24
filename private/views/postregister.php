<?php
include("/var/www/mbl/private/frags/fragHeader.php");
// Après avoir mis le compte en cour de création on affiche la validation de l'adresse postale.
?>
    <article id="firstarticle">
        <div class="title">
            <img src="https://monboulangerlivreur.fr/public/imgs/datas.svg">
            <h3>S'inscrire</h3>
        </div>
        <div class="signform" id="toreplaceform">
            <form method="post" action="https://monboulangerlivreur.fr/public/router.php?request=actionRegister">
                <?php
                echo "<span class='tounderline'>$address</span><br><br>";
                ?>
                <span>Est-ce bien votre adresse ?</span><br><br>
                <select class="cityselect" name="validation">
                    <option value="yes">Oui</option>
                    <option value="no">Non</option>
                </select><br><br>
                <input type="submit" value="Valider">
            </form>
        </div>
    </article>
<?php
include("/var/www/mbl/private/frags/fragFooter.php");
?>