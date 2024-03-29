<?php
include("/var/www/mbl/private/frags/fragHeader.php");

echo "<div style='display: none' class='products'>$products</div>";
echo "<script src='https://monboulangerlivreur.fr/public/scripts/usereditor.js'></script>";
echo "<script src='https://js.stripe.com/v3/'></script>";

if ($user->getAttributes()["pok"] == 0) {
    echo "<div class='infopanel'>Aucune méthode de paiement n'est activée sur votre compte, vous pouvez paramétrer vos commandes mais celles-ci ne seront pas prises en compte.</div>";
} elseif ($user->getAttributes()["pok"]) {
    echo "<div class='yespanel'>Une méthode de paiement est correctement configurée, vos commandes sont bien prises en compte.</div>";
} else {
    echo "<div class='errorpanel'>Votre compte est suspendu pour défaut de paiement.</div>";
}
?>
    <article id="firstarticle">
        <div class="title">
            <img src="https://monboulangerlivreur.fr/public/imgs/delivery.svg">
            <h3>Mes livraisons</h3>
        </div>
        <div id="tablecontainment" class="tablecontain">
            <?php
            if (preg_match("#badtime#", $status)) {
                echo "<div class='errorpanel'>Vous ne pouvez pas modifier votre commande si cela affecte votre commande pour le jour même.</div>";
            }
            ?>
            <table>
                <thead>
                <tr>
                    <th>Produit</th>
                    <th>Lundi</th>
                    <th>Mardi</th>
                    <th>Mercredi</th>
                    <th>Jeudi</th>
                    <th>Vendredi</th>
                    <th>Samedi</th>
                    <th>Dimanche</th>
                    <th>Action</th>
                </tr>
                </thead>
                <tbody>
                <?php
                foreach ($user->getCommand() as $name => $days) {
                    echo "<tr>";
                    $price = number_format(Product::getProductByName($name)->getAttributes()["price"], 2) . " €";
                    echo "<td>$name - $price</td>";
                    foreach ($days as $amount) {
                        if ($amount >= 0) {
                            echo "<td>$amount</td>";
                        } else {
                            echo "<td>Non livré.</td>";
                        }
                    }
                    echo "<td><span class='editbutton editorbutton'>Modifier </span><br><br><span class='editbutton deletebutton'>Supprimer </span></td>";
                    echo "</tr>";
                }
                ?>
                <tr>
                    <td id="addcell" colspan='9'><span id="addbutton">Ajouter un produit</span></td>
                </tr>
                </tbody>
            </table>
        </div>
    </article>
    <article>
        <div class="title">
            <img src="https://monboulangerlivreur.fr/public/imgs/deliverytime.svg">
            <h3>Les horaires de livraison dans mon village</h3>
        </div>
        <div class="tablecontain">
            <table>
                <thead>
                <tr>
                    <th>Lundi</th>
                    <th>Mardi</th>
                    <th>Mercredi</th>
                    <th>Jeudi</th>
                    <th>Vendredi</th>
                    <th>Samedi</th>
                    <th>Dimanche</th>
                </tr>
                </thead>
                <tbody>
                <tr>
                    <?php
                    foreach ($user->getCity()->getDeliveries() as $time) {
                        if ($time == 0) {
                            echo "<td>Non livré.</td>";
                        } else {
                            echo "<td>$time</td>";
                        }
                    }
                    ?>
                </tr>
                </tbody>
            </table>
        </div>
    </article>
    <article>
        <div class="title">
            <img id="wallet" src="https://monboulangerlivreur.fr/public/imgs/money.svg">
            <h3>Mon moyen de paiement</h3>
        </div>
        <div class="signform">
            <?php
            if (preg_match("#inprogress#", $status)) {
                echo "<div class='yespanel'>Votre méthode de paiement est en cour de vérification par l'autorité bancaire, veuillez raffraîchir la page dans quelques minutes. Si votre méthode de paiement n'a pas été ajoutée, veuillez réessayer.</div>";
            }

            if (preg_match("#baddatecard#", $status)) {
                echo "<div class='errorpanel'>La date d'expiration de votre carte est trop courte pour vous permettre d'utiliser ce service.</div>";
            }

            if (preg_match("#badcontextdel#", $status)) {
                echo "<div class='errorpanel'>Vous ne pouvez pas supprimer votre mode de paiement si vous devez encore de l'argent ou si la tournée en cour n'est pas terminée (la tournée finit tous les jours à 14H).</div>";
            }

            if (preg_match("#badcard#", $status)) {
                echo "<div class='errorpanel'>Votre carte a été refusée par l'autorité bancaire, veuillez réessayer.</div>";
            }

            $user->update();
            if ($user->getAttributes()["pmethod"] == "") {
                include("/var/www/mbl/private/frags/fragCard.html");
            } elseif (!preg_match("#editcard#", $status)) {
                $stripe = new \Stripe\StripeClient(Manager::getStripeKey());
                try {
                    $method = $stripe->paymentMethods->retrieve($user->getAttributes()["pmethod"]);
                    include("/var/www/mbl/private/frags/fragShowCard.php");
                } catch (Exception $e) {

                }
            } else {
                include("/var/www/mbl/private/frags/fragCard.html");
            }
            ?>
        </div>
    </article>
    <!-- Rappelle des données personnelles possédées par le site. -->
    <article>
        <div class="title">
            <img src="https://monboulangerlivreur.fr/public/imgs/datas.svg">
            <h3>Mes données personnelles</h3>
        </div>
        <div class="toalign">
            <p class="tobealigned">
                <span class="tounderline">Nom d'utilisateur</span> : <?php echo $user->getAttributes()["username"] ?>
                <br><br>
                <span class="tounderline">Adresse e-mail</span> : <?php echo $user->getAttributes()["mail"] ?><br><br>
                <span class="tounderline">Téléphone</span> : <?php echo $user->getAttributes()["phone"] ?><br><br>
                <span class="tounderline">Adresse</span> : <?php echo $user->getAttributes()["address"] ?><br><br>
                <span class="tounderline">Village de résidence</span> : <?php echo $user->getAttributes()["city"] ?>
            </p>
        </div>
    </article>
    <article>
        <div class="title">
            <img src="https://monboulangerlivreur.fr/public/imgs/operation.svg">
            <h3>Vos opérations</h3>
        </div>
        <div>
            <table>
                <thead>
                <tr>
                    <th>ID</th>
                    <th>Contenu</th>
                    <th>Date</th>
                </tr>
                </thead>
                <tbody>
                <?php

                ?>
                </tbody>
            </table>
        </div>
    </article>
<?php include("/var/www/mbl/private/frags/fragFooter.php") ?>