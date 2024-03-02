<?php
ob_start();
session_start();


$pageTitle = '';



if (isset($_SESSION['Username'])) {
    include 'init.php';

    $page = isset($_GET['page']) ? $_GET['page'] : "Manage";



    if ($page == "Manage") {
    } elseif ($page == 'Edit') {
    } elseif ($page == 'Update') {
    } elseif ($page == 'Add') {
    } elseif ($page == 'Delete') {
    } elseif ($page == 'Insert') {
    }
    include $tpl . 'footer.php';
} else {
    header('Location: index.php');
    exit();
}
ob_end_flush();
