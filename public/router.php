<?php
require_once("../private/controllers/ControllerMain.php");

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
        ControllerMain::$request();
        break;
    default:
        ControllerMain::viewMain();
}