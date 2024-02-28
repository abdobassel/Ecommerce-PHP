<?php

session_start();


$pageTitle = 'Members';
include 'init.php';





$page = isset($_GET['page']) ? $_GET['page'] : "Manage";
if ($page == "Manage") {
    echo "manage";
} elseif ($page == 'Edit') {

    //start edit page coding...
    // if (isset($_GET['userid']) && is_numeric($_GET['userid'])) {
    //   echo intval($_GET['userid']);
    //} else {
    //   echo 0;
    //}
    // chech if userid is number and get in val of it and select data user from userid from dbase
    // fetch data to form and => user can change it
    $userid = isset($_GET['userid']) && is_numeric($_GET['userid']) ? intval($_GET['userid']) : 0;

    $stmt = $con->prepare("SELECT * FROM users WHERE UserID = ? ");
    $stmt->execute(array($userid));
    $row = $stmt->fetch(); // array of info db
    $count = $stmt->rowCount();

    if ($count > 0) {
        // form show ...
?>
        <h1 class='text-center'>Edit Member</h1>
        <div class="container">
            <form action="?page=Update" method="post"> <!-- page=update => form update  -->
                <div class="form-group form-group-lg">
                    <input type="hidden" value="<?php
                                                echo $userid;
                                                ?>" name="userid">
                    <label class="col-sm2 control-label">Username</label>
                    <div class="col-sm-10">
                        <input type="text" value="<?php
                                                    echo $row['Username'];
                                                    ?>" class="form-control" name="username" autocomplete="off">
                    </div>
                    <!-- end username -->
                    <div class="form-group form-group-lg">
                        <label class="col-sm2 control-label">Password</label>
                        <div class="col-sm-10">
                            <input type="password" value="" class="form-control" name="password" autocomplete="new-password">
                        </div>
                        <!-- end pass -->
                        <div class="form-group form-group-lg">
                            <label class="col-sm2 control-label">Email</label>
                            <div class="col-sm-10">
                                <input type="email" value="<?php
                                                            echo $row['Email'];
                                                            ?>" class="form-control" name="email">
                            </div>
                            <!-- end email -->

                            <div class="form-group form-group-lg">
                                <label class="col-sm2 control-label">Fullname</label>
                                <div class="col-sm-10">
                                    <input type="text" value="
                                    <?php
                                    echo $row['Fullname'];
                                    ?>" class="form-control" name="full">
                                </div>
                                <!-- end fullname -->

                                <div class="form-group">
                                    <div class="col-sm-offset-2 col-sm-10">
                                        <input type="submit" value="Save" class="btn btn-primary">
                                    </div>
                                </div>
            </form>

        </div>


<?php

    } else {
        echo 'you are hacker ):';
    }
} elseif ($page == 'Update') {
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $userid = $_POST['userid'];
        $username = $_POST['username'];
        //$password = $_POST['password'];
        $email = $_POST['email'];
        $fullname = $_POST['full'];
        // update sql

        $stmt = $con->prepare("UPDATE users SET Username = ?, Email = ?, Fullname= ? WHERE UserID = ?");
        $stmt->execute(array($username, $email, $fullname, $userid));
        $count = $stmt->rowCount();

        echo ' record is ' . $count . '<br>';
    } else {
        echo 'no update';
    }
} elseif ($page == 'delete') {

    echo "<h1>delete<h1/> ";
} else {
    echo "Error not found page";
}
include $tpl . 'footer.php';
