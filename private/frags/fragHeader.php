<!-- Fragment pour l'affiche du header dans tout le site. -->
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width,height=device-height,initial-scale=1">
    <link href="https://monboulangerlivreur.fr/public/imgs/bread.png" rel="icon">
    <link href="https://monboulangerlivreur.fr/public/styles/select2.min.css" rel="stylesheet">
    <link href="https://monboulangerlivreur.fr/public/styles/header.css" rel="stylesheet">
    <link href="https://monboulangerlivreur.fr/public/styles/main.css" rel="stylesheet">
    <link href="https://monboulangerlivreur.fr/public/styles/footer.css" rel="stylesheet">
    <script src="https://monboulangerlivreur.fr/public/scripts/jquery-3.5.1.min.js"></script>
    <script src="https://monboulangerlivreur.fr/public/scripts/footresp.js"></script>
    <script src="https://monboulangerlivreur.fr/public/scripts/select2.min.js"></script>
    <title><?php echo $title ?></title>
</head>
<body>
<header>
    <div>
        <h1>Mon boulanger livreur</h1>
        <div>
            <h5>Il me livre du pain chaud tous les jours !</h5>
        </div>
    </div>
    <img src="https://monboulangerlivreur.fr/public/imgs/leftback.svg" id="leftback">
    <img src="https://monboulangerlivreur.fr/public/imgs/rightback.svg" id="rightback">
    <nav>
        <div id="leftnav">
            <a href="<?php echo $firstref ?>"><?php echo $firstfield ?></a>
        </div>
        <div id="rightnav">
            <a href="<?php echo $secondref ?>"><?php echo $secondfield ?></a>
        </div>
    </nav>
</header>