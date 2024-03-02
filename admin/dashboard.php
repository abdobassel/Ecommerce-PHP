<?php
ob_start();
session_start();




if (isset($_SESSION['Username'])) {
    $pageTitle = 'DashBoard';
    include 'init.php';

    //  $stm = $con->prepare("SELECT COUNT(UserID) FROM users");
    //$stm->execute();

    // latest users reg coding

    $latestUsers = getLatest('Fullname,UserID', 'users', 'UserID', 4); // i will do foreach


    //start dashboard page
?> <div class="home-stats">
        <div class="container  text-center">
            <h1>Dashboard</h1>
            <div class="row">
                <div class="col-md-3">
                    <div class="stat st-members">
                        Total Members

                        <span> <?php
                                echo checkItem("GroupId", "users", 0); // now count without admins
                                // with admins count echo countItems("UserID",'users');
                                ?></span>
                    </div>
                </div>

                <div class="col-md-3">
                    <div class="stat st-pending">
                        Pending Members
                        <span><a href="members.php?page=Manage&page2=Pending"><?php

                                                                                // number of users unactivate
                                                                                echo  checkItem('RegStatus', 'users', 0);
                                                                                ?></a></span>
                    </div>
                </div>

                <div class="col-md-3">
                    <div class="stat st-items">
                        Total Items
                        <span>1500</span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="latest">
        <div class="container">
            <div class="row">
                <div class="com-sm-6">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <i class="fa fa-users"></i>Latest users reg
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
                <div class="com-sm-6">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <i class="fa fa-tag"></i>Latest items
                        </div>
                        <div class="panel-body">
                            test
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