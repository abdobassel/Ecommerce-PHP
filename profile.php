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
    <div class="information block">
        <div class="container">
            <div class="panel panel-primary">
                <div class="panel-heading">My Info</div>
                <ul class="list-unstyled">
                    <li> <span> Name :</span> <?php echo $userInfo['Fullname'] ?> </li>
                    <li> <span> Useername :</span> <?php echo $userInfo['Username'] ?> </li>
                    <li> <span> Email :</span> <?php echo $userInfo['Email'] ?> </li>
                    <li> <span> Joined Date:</span> <?php echo $userInfo['Date'] ?> </li>
                </ul>



            </div>
        </div>
    </div>
    <div class="information-block">
        <div class="container">
            <div class="panel panel-primary">
                <div id="my-ads" class="panel-heading">My Ads اعلاناتي</div>
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
                            echo "<a href='newad.php'class='btn btn-success'>Create A New Ad</a>";
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
                                                '<a href="items.php?itemid=' . $item["Item_Id"] . '">' . $item['Name'] . '</a>';
                                                ?></h3>
                                            <p><?php
                                                echo  $item['Description'];
                                                ?></p>
                                            <p> Date : <?php
                                                        echo  $item['Add_Date'];
                                                        ?></p>
                                            <?php
                                            if ($item['Approve'] == 0) {
                                            ?>
                                                <p style="background-color: red;color:#eee;font-size:16px"> Waiting For Approve..
                                                </p>
                                            <?php     }
                                            ?>

                                        </div>
                                    </div>

                                </div>



                        <?php  }
                        }

                        ?>
                    </div>
                    <a href='newad.php' class='btn btn-success'>Create A New Ad</a>


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
                $stmt3 = $con->prepare("SELECT c.body, c.date, u.Username FROM comments c INNER JOIN users u ON c.user_id = u.UserID WHERE c.user_id = ? ORDER BY c.comment_id DESC");
                $stmt3->execute(array($userInfo['UserID']));
                $comments = $stmt3->fetchAll();
                ?>
                <div class="panel-body">
                    <?php if (empty($comments)) : ?>
                        <div class="alert alert-danger">
                            <h3 class="text-center">There is No Comments yet...</h3>
                        </div>
                    <?php else : ?>
                        <?php foreach ($comments as $comment) : ?>
                            <div class="media">
                                <div class="media-left">
                                    <!-- ارتبط الاسم بملف المستخدم أو أي صفحة أخرى -->
                                    <a href="profile.php?username=<?php echo $comment['Username']; ?>">
                                        <img class="media-object" src="1.jpg" alt="<?php echo $comment['Username']; ?>">
                                    </a>
                                </div>
                                <div class="media-body">
                                    <h4 class="media-heading">
                                        <!-- الاسم في رابط -->
                                        <a href="profile.php?username=<?php echo $comment['Username']; ?>">
                                            <?php echo $comment['Username']; ?>
                                        </a>
                                    </h4>
                                    <p><?php echo $comment['body']; ?></p>
                                    <p><?php echo $comment['date']; ?></p>
                                </div>
                            </div>

                        <?php endforeach; ?>
                    <?php endif; ?>
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
