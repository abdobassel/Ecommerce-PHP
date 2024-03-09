<?php

// main index front not admins
session_start();
$pageTitle = 'Profile';
include "init.php";


$itemid = isset($_GET['itemid']) && is_numeric($_GET['itemid']) ? intval($_GET['itemid']) : 0;



$stmt = $con->prepare("SELECT * FROM items WHERE Item_Id = ? ORDER BY Item_Id DESC");


$stmt->execute(array($itemid));

$item = $stmt->fetch();
//user name for this item
$stmtuser = $con->prepare("SELECT * FROM users WHERE UserID = ?");
$stmtuser->execute(array($item['Mem_ID']));
$userInfo = $stmtuser->fetch();
$count = $stmt->rowCount();
?>
<h1 class="text-center"> <?php echo  $item['Name']; ?></span></h1>

<div class="information-block">
    <div class="container">
        <div class="panel panel-primary">
            <div class="panel-heading">Items & ads</div>

            <div class="panel-body">

                <div class="row">
                    <?php

                    ?>
                    <div class="col-sm-6 col-md-3">
                        <div class="thumbnail item-box">

                            <span class="price-tag"><?php
                                                    echo  $item['Price'];
                                                    ?></span>
                            <img class="img-responsive" src="1.jpg" alt="">
                            <div class="caption">
                                <h3><?php
                                    echo  $item['Name'];
                                    ?></h3>
                                <p><?php
                                    echo  $userInfo['Username'];
                                    ?></p>

                                <p><?php
                                    echo  $item['Description'];
                                    ?></p>

                                <p> Date : <?php
                                            echo  $item['Add_Date'];
                                            ?></p>

                            </div>
                        </div>

                    </div>



                    <?php


                    ?>
                </div>
                <a href='newad.php' class='btn btn-success'>Create A New Ad</a>


            </div>


            <?php



            ?>



        </div>
    </div>
</div>

<?php


?>

<?php include $tpl . "footer.php";
