<?php
include("/var/www/mbl/private/frags/fragHeader.php");
?>
    <article id="firstarticle">
        <div class="title">
            <img src="https://monboulangerlivreur.fr/public/imgs/datas.svg">
            <h3>S'inscrire</h3>
        </div>
        <div class="signform" id="toreplaceform">
            <?php
            if (preg_match("#special#", $status)) {
                echo "<div class='errorpanel'>Une erreur est survenue, veuillez-réessayer.</div>";
            }
            if (preg_match("#yes#", $status)) {
                echo "<div class='yespanel'>L'inscription a réussi.<br>Vous allez recevoir un mail permettant l'activation de votre compte. N'oubliez pas de regarder dans vos courriers indésirables.</div>";
            }
            ?>
            <form method="post" action="https://monboulangerlivreur.fr/public/router.php?request=actionPreRegister">
                <?php
                if (preg_match("#badusername#", $status)) {
                    echo "<div class='errorpanel'>Le nom d'utilisateur doit contenir :<br>- Au moins 4 caractères.<br>- Uniquement des lettres ou chiffres.<br></div>";
                }
                if (preg_match("#usernameexists#", $status)) {
                    echo "<div class='infopanel'>Le nom d'utilisateur est déjà utilisé.</div>";
                }
                ?>
                <input value="<?php if (isset($_GET["username"])) echo $_GET["username"] ?>" type="text" name="username"
                       placeholder="Nom d'utilisateur"><br>
                <?php
                if (preg_match("#badpasswd#", $status)) {
                    echo "<div class='errorpanel'>Le mot de passe doit contenir :<br>- Au moins 8 caractères.<br>- Une lettre minuscule et une majuscule.<br>- Un chiffre.<br>- Un caractère spécial.<br></div>";
                }
                if (preg_match("#diffpasswd#", $status)) {
                    echo "<div class='infopanel'>Les mots de passe ne correspondent pas.</div>";
                }
                ?>
                <input type="password" name="passwd1" placeholder="Mot de passe"><br>
                <input type="password" name="passwd2" placeholder="Répétez le mot de passe"><br>
                <?php
                if (preg_match("#badmail#", $status)) {
                    echo "<div class='errorpanel'>L'adresse e-mail est incrorrecte.</div>";
                }
                if (preg_match("#mailexists#", $status)) {
                    echo "<div class='infopanel'>L'adresse e-mail est déjà utilisée.</div>";
                }
                ?>
                <input value="<?php if (isset($_GET["mail"])) echo $_GET["mail"] ?>" type="email" name="mail"
                       placeholder="Adresse e-mail"><br>
                <?php
                if (preg_match("#badphone#", $status)) {
                    echo "<div class='errorpanel'>Le numéro de téléphone est incorrect.</div>";
                }
                if (preg_match("#phoneexists#", $status)) {
                    echo "<div class='infopanel'>Le numéro de téléphone est déjà utilisé.</div>";
                }
                ?>
                <input value="<?php if (isset($_GET["phone"])) echo $_GET["phone"] ?>" type="tel" name="phone"
                       placeholder="Numéro de téléphone"><br>
                <?php
                if (preg_match("#badaddress#", $status)) {
                    echo "<div class='errorpanel'>L'adresse entrée n'a pu être trouvée dans le village choisi.</div>";
                }
                ?>
                <input value="<?php if (isset($_GET["address"])) echo $_GET["address"] ?>"
                       placeholder="N° et nom de rue"
                       type="text" name="address">
                <?php
                if (preg_match("#badcity#", $status)) {
                    echo "<div class='errorpanel'>La ville choisie est incorrecte.</div>";
                }
                ?>
                <select class="cityselect" name="city">
                    <option value="none">Sélectionnez votre village de résidence</option>
                    <?php
                    foreach ($cities as $city) {
                        $name = $city->getAttributes()["name"];
                        echo "<option value='$name'>$name</option>";
                    }
                    ?>
                </select><br>
                <input id="submit" type="submit" value="Inscription">
            </form>
            <a class="bottomlink" href="https://monboulangerlivreur.fr/public/router.php?request=viewSignin">Déjà
                inscrit ? Connectez-vous !</a>
        </div>
    </article>
<?php include("/var/www/mbl/private/frags/fragFooter.php") ?>