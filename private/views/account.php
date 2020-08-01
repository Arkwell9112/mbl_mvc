<?php
include("/var/www/mbl/private/frags/fragHeader.php");

echo "<div style='display: none' class='products'>$products</div>";
echo "<script src='https://monboulangerlivreur.fr/public/scripts/usereditor.js'></script>";
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
        <p>

        </p>
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