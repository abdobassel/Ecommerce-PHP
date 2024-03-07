<?php

// main index front not admins
session_start();
$pageTitle = 'Profile';
include "init.php";
if (isset($_SESSION['user'])) {
    echo $_SESSION['user'];
}
?>
<h1 class="text-center">My Profile</h1>
<div class="information-block">
    <div class="container">
        <div class="panel panel-primary">
            <div class="panel-heading">My Info</div>
            <div class="panel-body">Name : <?php if (isset($_SESSION['user'])) {
                                                echo $_SESSION['user'];
                                            } ?> </div>
        </div>
    </div>
</div>
<div class="information-block">
    <div class="container">
        <div class="panel panel-primary">
            <div class="panel-heading">My Info</div>
            <div class="panel-body">Name : <?php if (isset($_SESSION['user'])) {
                                                echo $_SESSION['user'];
                                            } ?> </div>
        </div>
    </div>
</div>
<div class="information-block">
    <div class="container">
        <div class="panel panel-primary">
            <div class="panel-heading">My Info</div>
            <div class="panel-body">Name : <?php if (isset($_SESSION['user'])) {
                                                echo $_SESSION['user'];
                                            } ?> </div>
        </div>
    </div>
</div>
<?php include $tpl . "footer.php";
