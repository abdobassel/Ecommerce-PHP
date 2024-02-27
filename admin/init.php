<?php 

include 'config.php'; // connect here becase inint in all php pages;
//routes 
$tpl = "includes/templates/";
$css = "layOut/css/";
$js = "layOut/js/";
$languages = "includes/languages/";
$functions = "includes/functions/";

// important files

include $languages .'english.php';
include $languages .'arabic.php';
include $functions . 'functions.php';
 include $tpl ."header.php"; 



 if(!isset($noNavbar)){  include $tpl ."navbar.php";  }
