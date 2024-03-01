<?php

session_start();




if (isset($_SESSION['Username'])) {
    $pageTitle = 'DashBoard';
    include 'init.php';

    //  $stm = $con->prepare("SELECT COUNT(UserID) FROM users");
    //$stm->execute();


    //start dashboard page
?> <div class="home-stats">
        <div class="container  text-center">
            <h1>Dashboard</h1>
            <div class="row">
                <div class="col-md-3">
                    <div class="stat st-members">
                        Total Members

                        <span> <?php
                                echo countItems("UserId", "users");
                                ?></span>
                    </div>
                </div>

                <div class="col-md-3">
                    <div class="stat st-pending">
                        Pending Members
                        <span><a href="members.php?page=Manage&page2=Pending"><?php
                                                                                //  countItems('','');
                                                                                ?></a>5</span>
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
                            test
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
    print_r($_SESSION);
} else {
    header("Location: index.php");
    exit();
}
