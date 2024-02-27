<?php

session_start();




if (isset($_SESSION['Username'])) {
    $pageTitle = 'DashBoard';
    include 'init.php';
    include $tpl . 'footer.php';
    print_r($_SESSION);
} else {
    header("Location: index.php");
    exit();
}
