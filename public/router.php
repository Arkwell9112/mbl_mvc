<?php
require_once("/var/www/mbl/private/controllers/ControllerMain.php");

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
        ControllerMain::$request();
        break;
    default:
        ControllerMain::viewMain();
}