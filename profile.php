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
                <div class="panel-heading">My Ads اعلاناتي</div>
                <?php
                $stmt2 = $con->prepare("SELECT * FROM items WHERE Mem_ID = ? ORDER BY Item_Id DESC");
                $stmt2->execute(array($userInfo['UserID']));

                $items = $stmt2->fetchAll();



                ?>
                <div class="panel-body">

                    <div class="row">
                        <?php
                        if (empty($items)) {
                            echo '<div class="alert alert-danger"><h3 class="text-center">There is No items yet...</h3> </div>' . '<br>';
                        } else {
                            foreach ($items as $item) { ?>
                                <div class="col-sm-6 col-md-3">
                                    <div class="thumbnail item-box">
                                        <span class="price-tag"><?php
                                                                echo  $item['Price'];
                                                                ?></span>
                                        <img class="img-responsive" src="1.jpg" alt="">
                                        <div class="caption">
                                            <h3><?php echo
                                                $item['Name'];
                                                ?></h3>
                                            <p><?php
                                                echo  $item['Description'];
                                                ?></p>
                                            <p> Date : <?php
                                                        echo  $item['Add_Date'];
                                                        ?></p>

                                        </div>
                                    </div>

                                </div>



                        <?php  }
                        }

                        ?>
                    </div>


                </div>


                <?php



                ?>



            </div>
        </div>
    </div>
    <div class="information-block">
        <div class="container">
            <div class="panel panel-primary">
                <div class="panel-heading">My Comments</div>
                <?php
                $stmt3 = $con->prepare("SELECT body,date FROM comments WHERE user_id = ? ORDER BY comment_id DESC");
                $stmt3->execute(array($userInfo['UserID']));

                $comments = $stmt3->fetchAll();



                ?>
                <div class="panel-body">
                    <div class="row">



                        <?php
                        if (empty($comments)) {
                            echo '<div class="alert alert-danger"><h3 class="text-center">There is No Comments yet...</h3> </div>' . '<br>';
                        } else {
                            foreach ($comments as $comment) { ?>
                                <div class="col-sm-6 col-md-3">
                                    <div class="thumbnail item-box">


                                        <div class="caption">
                                            <h3><?php echo
                                                $comment['body'];
                                                ?></h3>
                                            <p><?php
                                                echo  $comment['date'];
                                                ?></p>


                                        </div>
                                    </div>

                                </div>



                        <?php  }
                        }

                        ?>
                    </div>


                </div>


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
