<?php

// main index front not admins
session_start();
$pageTitle = 'Profile';
include "init.php";
if (isset($_SESSION['user'])) {
    echo $_SESSION['user'];
    $stmt = $con->prepare("SELECT * FROM users WHERE Username = ?");
    $stmt->execute(array($userSession));

    $userInfo = $stmt->fetch();
?>
    <h1 class="text-center">My Profile</h1>
    <div class="information-block">
        <div class="container">
            <div class="panel panel-primary">
                <div class="panel-heading">My Info</div>
                <div class="panel-body">Full Name : <?php echo $userInfo['Fullname'] ?> </div>
                <div class="panel-body">Username : <?php echo $userInfo['Username'] ?> </div>
                <div class="panel-body">Email : <?php echo $userInfo['Email'] ?> </div>
                <div class="panel-body">Date : <?php echo $userInfo['Date'] ?> </div>

            </div>
        </div>
    </div>
    <div class="information-block">
        <div class="container">
            <div class="panel panel-primary">
                <div class="panel-heading">My Ads</div>
                <?php
                $stmt2 = $con->prepare("SELECT * FROM items WHERE Mem_ID = ?");
                $stmt2->execute(array($userInfo['UserID']));

                $items = $stmt2->fetchAll();
                if (!empty($items)) {
                    foreach ($items as $item) {
                ?>
                        <div class="panel-body"> Item : <?php echo $item['Name'] . ' In [ ' . $item['Add_Date'] . ' ]' ?> </div>
                    <?php }
                } else { ?>
                    <div class="panel-body"> There is no Items Here Now... Add Items if you like.. </div>
                <?php

                }

                ?>



            </div>
        </div>
    </div>
    <div class="information-block">
        <div class="container">
            <div class="panel panel-primary">
                <div class="panel-heading">My Comments</div>
                <div class="panel-body">Name : <?php if (isset($_SESSION['user'])) {
                                                    echo $_SESSION['user'];
                                                } ?> </div>
            </div>
        </div>
    </div>

<?php

} else {
    header("Location: login.php");
    exit();
}
?>

<?php include $tpl . "footer.php";
