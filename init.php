<?php
// init main website not admin
include 'admin/config.php'; // connect here becase inint in all php pages;
//routes 
$userSession = '';
if (isset($_SESSION['user'])) {
    $userSession = $_SESSION['user'];
}

$tpl = "includes/templates/";
$css = "layOut/css/";
$js = "layOut/js/";
$languages = "includes/languages/";
$functions = "includes/functions/";

// important files

include $languages . 'english.php';
include $languages . 'arabic.php';
include $functions . 'functions.php';
include $tpl . "header.php"; // and navbar also in file header => front changed not admin pages
