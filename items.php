<?php

// main index front not admins
ob_start();
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


                    if (isset($_SESSION['user'])) {


                    ?> <div class="panel-body">
                            <div class="row">

                                <div class="col-md-offset-3">
                                    <h3>Add Comment</h3>
                                    <form action="<?php echo $_SERVER['PHP_SELF'] . '?itemid=' . $itemid ?>" method="post">
                                        <div class="form-group">
                                            <textarea class="form-control" name="comment"></textarea>
                                            <input class="btn btn-primary" type="submit" value="Post">
                                        </div>
                                </div>
                                </form>
                                <?php
                                if ($_SERVER['REQUEST_METHOD'] == 'POST') {
                                    $usercommented = $con->prepare("SELECT * from users where Username = ?");
                                    $usercommented->execute(array($_SESSION['user']));
                                    $usercommentid =  $usercommented->fetch();


                                    $comment = filter_var($_POST['comment'], FILTER_SANITIZE_SPECIAL_CHARS);
                                    $user_id = $usercommentid['UserID'];
                                    $item_id = $itemid;
                                    if (!empty($comment)) {
                                        $stmt3 = $con->prepare("INSERT INTO comments(body,date,user_id,item_id,Approve)
                                     VALUES(:zbody, now(), :zuserid, :zitemid, 0)");

                                        $stmt3->execute(array('zbody' => $comment, 'zuserid' => $user_id, 'zitemid' => $item_id));

                                        $comm_count = $stmt3->rowCount();

                                        if ($comm_count > 0) {
                                            header('Location: items.php?itemid=' . $item_id);
                                        }
                                    }
                                }
                                ?>


                            </div>


                        </div>
                    <?php   }

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
ob_end_flush();
