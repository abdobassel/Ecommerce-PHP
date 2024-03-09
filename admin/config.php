<?php
// connect database
$dsn = 'mysql:host=localhost;dbname=shop_elzero';  // $dsn =>data source name
$user = 'root';
$pass = '';
$option = array(
    PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8',

);


try {
    //con => varible connection
    $con = new PDO($dsn, $user, $pass, $option);
    $con->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    //   echo "You are Connected to dbase";
} catch (PDOException $e) {
    echo "Failed Connect" . $e->getMessage();
}
