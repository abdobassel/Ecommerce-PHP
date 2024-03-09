<?php

// main index front not admins
session_start();
$pageTitle = 'Profile';
include "init.php";
if (isset($_GET['itemid'])) {

    $itemid = isset($_GET['itemid']) && is_numeric($_GET['itemid']) ? intval($_GET['itemid']) : 0;



    $stmt = $con->prepare("SELECT * FROM items WHERE Item_Id = ? ORDER BY Item_Id DESC");


    $stmt->execute(array($itemid));

    $item = $stmt->fetch();
    //user name for this item
    $stmtuser = $con->prepare("SELECT * FROM users WHERE UserID = ?");

    if (isset($item['Mem_ID'])) {
        // يجب تحديد Mem_ID قبل تنفيذ الاستعلام الثاني
        $stmtuser->execute(array($item['Mem_ID']));
        $userInfo = $stmtuser->fetch();
    }
    $count = $stmt->rowCount();
    if ($count > 0) { ?>
        <h1 class="text-center"> <?php echo  $item['Name']; ?></span></h1>

        <div class="information-block information">
            <div class="container">
                <div class="panel panel-primary">
                    <div class="panel-heading">Items & ads</div>


                    <div class="row">
                        <div class="col-md-3">
                            <img class="img-responsive img-thumbnail center-block" src="1.jpg" alt="">
                        </div>
                        <div class="col-md-9">
                            <h2>
                                <?php echo $item['Name']; ?>
                            </h2>
                            <p><?php echo $item['Description']; ?></p>
                            <ul class="list-unstyled">
                                <li>
                                    <span><i class="fa fa-user"></i> Username : </span> <a href="profile.php?userid=<?php echo $userInfo['UserID']; ?>">
                                        <?php echo $userInfo['Username']; ?>
                                    </a>
                                </li>
                                <li>
                                    <span><i class="fa fa-money"></i> Price : </span> <?php echo $item['Price']; ?>
                                </li>
                                <li>
                                    <span><i class="fa fa-calendar"></i> Date : </span> <?php echo $item['Add_Date']; ?>
                                </li>
                                <li><?php
                                    $getCat = $con->prepare("SELECT items.*, categories.Name As cat_name
                                    FROM items 
                                    INNER JOIN categories ON categories.Id = items.Cat_Id WHERE Item_Id = ?");

                                    $getCat->execute(array($itemid));
                                    $cat = $getCat->fetch();
                                    ?>
                                    <span><i class="fa fa-user"></i> Category : </span> <a href="categories.php?catid=<?php echo $cat['Cat_Id']; ?>">
                                        <?php echo $cat['cat_name']; ?>
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </div>

                    <a href='newad.php' class='btn btn-success'>Create A New Ad</a>





                    <?php



                    ?>



                </div>
            </div>
        </div>
        <div class="information-block">
            <div class="container">
                <div class="panel panel-primary">
                    <div class="panel-heading">The Comments</div>
                    <?php
                    $stmt3 = $con->prepare("SELECT comments.*, users.Username as uname FROM comments INNER JOIN users ON users.UserID = comments.user_id WHERE item_id = ? ORDER BY comment_id DESC");
                    $stmt3->execute(array($itemid));

                    $comments = $stmt3->fetchAll();



                    ?>
                    <div class="panel-body">
                        <div class="row">



                            <?php
                            if (empty($comments)) {
                                echo '<div class="alert alert-danger"><h3 class="text-center">There is No Comments yet...</h3> </div>' . '<br>';
                            } else {
                                foreach ($comments as $comment) { ?>
                                    <div class="col-sm-6 col-md-12">
                                        <h3> <?php echo
                                                '<a href="profile.php">' . $comment['uname'] . '</a>';
                                                // will change link for other users
                                                ?> commented... </h3>


                                        <div class="caption">
                                            <h3><?php echo
                                                $comment['body'];
                                                ?></h3>

                                            <p><?php
                                                echo  $comment['date'];
                                                ?></p>


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
        echo '<h1 class="text-center"> No Such Id</h1>';
    }
} else {
    echo '<h1 class="text-center"> There Is No Items Or Ads To Sho ...</h1>';
}





?>

<?php include $tpl . "footer.php";
