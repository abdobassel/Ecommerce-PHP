<?php
ob_start();
session_start();




if (isset($_SESSION['Username'])) {
    $pageTitle = 'DashBoard';
    include 'init.php';

    //  $stm = $con->prepare("SELECT COUNT(UserID) FROM users");
    //$stm->execute();

    // latest users reg coding

    $latestUsers = getLatest('Fullname,UserID', 'users', 'UserID', 5); // i will do foreach
    $latest_Items = getLatestItems('*', 'items', 'Item_Id', 6);


    //start dashboard page
?> <div class="home-stats">
        <div class="container  text-center">
            <h1>Dashboard</h1>
            <div class="row">
                <div class="col-md-3">
                    <div class="stat st-members">
                        Total Members

                        <span> <a href="members.php"><?php
                                                        echo checkItem("GroupId", "users", 0); // now count without admins
                                                        // with admins count echo countItems("UserID",'users');
                                                        ?></a></span>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="stat st-comments">
                        Total Comments

                        <span> <a href="comments.php"><?php
                                                        echo countItems("comment_id", "comments"); // now count without admins
                                                        // with admins count echo countItems("UserID",'users');
                                                        ?></a></span>
                    </div>
                </div>

                <div class="col-md-3">
                    <div class="stat st-pending">
                        Pending Members
                        <span><a href="members.php?page=Manage&page2=Pending"><?php
                                                                                // number of users unactivate
                                                                                echo  checkItem('RegStatus', 'users', 0); ?></a></span>
                    </div>
                </div>

                <div class="col-md-3">
                    <div class="stat st-items">
                        Total Items
                        <span><a href="items.php"><?php

                                                    // number of items unactivate
                                                    echo  countItems('Item_Id', 'items');
                                                    ?></a></span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    </div>

    <div class="latest">
        <div class="container">
            <div class="row">
                <div class="col-sm-6">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <i class="fa fa-users"></i> Latest users reg
                        </div>
                        <div class="panel-body">
                            <ui class="list-unstyled latest-users">


                                <?php
                                foreach ($latestUsers as $user) {
                                    echo  "<li>";
                                    echo $user['Fullname'];

                                    echo '<a href="members.php?page=Edit&userid=' . $user['UserID'] . '">';
                                    echo '<span class="btn btn-success pull-right">';

                                    echo  '<i class ="fa fa-edit"></i>Edit';
                                    echo "</span>";
                                    echo "</a>";
                                    echo  "</li>";
                                }
                                ?>
                            </ui>
                        </div>
                    </div>
                </div>
                <div class="col-sm-6">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <i class="fa fa-tag"></i> Latest items
                        </div>
                        <div class="panel-body">
                            <ui class="list-unstyled latest-users">


                                <?php
                                foreach ($latest_Items as $item) {
                                    echo  "<li>";
                                    echo $item['Name'];

                                    echo '<a href="items.php?page=Edit&itemid=' . $item['Item_Id'] . '">';
                                    echo '<span class="btn btn-success pull-right">';

                                    echo  '<i class ="fa fa-edit"></i>Edit';
                                    echo "</span>";
                                    echo "</a>";


                                    if ($item['Approve'] == '0') {
                                        echo '<a href="items.php?page=Approve&itemid=' . $item['Item_Id'] . '">';

                                        echo '<span class="btn btn-primary pull-right">';

                                        echo  '<i class ="fa fa-check"></i>Approve';
                                        echo "</span>";
                                        echo "</a>";
                                    }
                                    echo  "</li>";
                                }
                                ?>
                            </ui>
                        </div>
                    </div>
                </div>

            </div>
            <!-- start comments-->
            <div class="row">
                <div class="col-sm-6">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <i class="fa fa-comment"></i> Latest 3 Comments...
                        </div>
                        <div class="panel-body">
                            <ui class="list-unstyled latest-users">


                                <?php
                                $stmt = $con->prepare(" SELECT comments.*, users.Username , items.Name AS item_name
                                  FROM comments 
                                  INNER JOIN users ON users.UserID = comments.user_id
                                  INNER JOIN items ON items.Item_Id = comments.item_id
                                  ORDER BY comment_id DESC
                                  LIMIT 3
                                
                                  ");

                                $stmt->execute();
                                $comments = $stmt->fetchAll();
                                if (!empty($comments)) {
                                    foreach ($comments as $comment) {
                                        echo "<li>";

                                        echo  '[ <a  href="members.php?page=Edit&userid=' . $comment['user_id'] . '">'

                                            . $comment['Username'] . '</a>' . ' ] Commented On ' .

                                            ' [ ' . '<a href="items.php?page=Edit&itemid=' . $comment['item_id'] . '">'
                                            . $comment['item_name'];
                                        echo '</a>' . ' ]';
                                        echo '<br>';

                                        echo '<a style="color:green;" href="comments.php?page=Edit&comid=' . $comment['comment_id'] . '">';

                                        echo '<span>'  . $comment['body'] . '</span>';
                                        echo "</a>";
                                        echo "</li>";
                                    }
                                }
                                ?>
                            </ui>
                        </div>
                    </div>
                </div>
                <div class="col-sm-6">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <i class="fa fa-tag"></i> Latest items
                        </div>
                        <div class="panel-body">
                            <ui class="list-unstyled latest-users">


                                <?php
                                foreach ($latest_Items as $item) {
                                    echo  "<li>";
                                    echo $item['Name'];

                                    echo '<a href="items.php?page=Edit&itemid=' . $item['Item_Id'] . '">';
                                    echo '<span class="btn btn-success pull-right">';

                                    echo  '<i class ="fa fa-edit"></i>Edit';
                                    echo "</span>";
                                    echo "</a>";


                                    if ($item['Approve'] == '0') {
                                        echo '<a href="items.php?page=Approve&itemid=' . $item['Item_Id'] . '">';

                                        echo '<span class="btn btn-primary pull-right">';

                                        echo  '<i class ="fa fa-check"></i>Approve';
                                        echo "</span>";
                                        echo "</a>";
                                    }
                                    echo  "</li>";
                                }
                                ?>
                            </ui>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>






<?php
    //end dashboard page
    include $tpl . 'footer.php';
    // print_r($_SESSION);
} else {
    header("Location: index.php");
    exit();
}
ob_end_flush();
?>