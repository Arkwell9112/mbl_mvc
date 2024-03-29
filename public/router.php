<?php
require_once("/var/www/mbl/private/controllers/ControllerMain.php");
require_once("/var/www/mbl/private/controllers/ControllerAccount.php");

error_reporting(E_ALL);
ini_set("display_errors", 1);

date_default_timezone_set("Europe/Paris");

if (isset($_GET["request"])) {
    $request = $_GET["request"];
} else {
    $request = "";
}

switch ($request) {
    case "viewMain":
    case "viewRegister":
    case "viewSignin":
    case "actionPreRegister":
    case "viewPostRegister":
    case "actionRegister":
    case "actionSignin":
    case "actionActivate":
    case "viewReset":
    case "actionPreReset":
    case "viewPostReset":
    case "actionReset":
        ControllerMain::$request();
        break;

    case "viewAccount":
    case "actionAddProduct":
    case "actionDeleteProduct":
    case "actionDisconnect":
    case "actionEditProduct":
    case "actionAddPayment":
    case "actionRedirectIntent":
    case "endpointSetupIntent":
    case "actionDeletePayment":
        ControllerAccount::$request();
        break;

    default:
        ControllerMain::viewMain();
}