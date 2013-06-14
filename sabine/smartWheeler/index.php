<?php
session_start();
ini_set('default_charset', 'UTF-8');

error_reporting(E_ALL);         //später löschen

require_once 'inc/mysqlDB.class.php';
$C = new mysqlDB('mysqlsvr30.world4you.com', 'webcreativesat', '6z77+my', 'webcreativesatdb2');

require_once 'inc/function.php';

//Mobile Seite
// require_once("inc/Mobile_Detect.php");
// $detect = new Mobile_Detect();

//Formularüberprüfungen
if (count($_POST) > 0) {
    require_once 'template/check_form.php';
}


// if ($detect->isMobile() /*|| $detect->isPre() */) {      //Mobile Seite
    // require_once 'mobile.php';
// } else { 
    require_once 'screen.php';
// }