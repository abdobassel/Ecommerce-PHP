<?php
// comments Page Edit Delete 




session_start();


$pageTitle = 'Comments';



if (isset($_SESSION['Username'])) {
    include 'init.php';
    $page = isset($_GET['page']) ? $_GET['page'] : "Manage";




    if ($page == "Manage") {


        $stmt = $con->prepare(" SELECT comments.*, users.Username , items.Name AS item_name
        FROM comments 
        INNER JOIN users ON users.UserID = comments.user_id
        INNER JOIN items ON items.Item_Id = comments.item_id
        ");

        $stmt->execute();
        $rows = $stmt->fetchAll();

?>
        <h1 class="text-center">Manage Comments</h1>
        <div class="container">
            <div class="table-responsive">
                <table class="table table-bordered">
                    <tr>
                        <td>#ID</td>
                        <td>Comment</td>
                        <td>Username</td>
                        <td>Item Name</td>
                        <td>Comment Date</td>
                        <td>Control</td>
                    </tr>
                    <?php
                    foreach ($rows as $row) {
                        echo "<tr>";
                        echo "<td>" . $row["comment_id"] . "</td>";
                        echo "<td>" . $row["body"] . "</td>";
                        echo "<td>" . $row["Username"] . "</td>";
                        echo "<td>" . $row["item_name"] . "</td>";
                        echo "<td>" . $row["date"] . "</td>";
                        echo "<td>
					<a href='members.php?page=Edit&comid=" . $row['comment_id'] . "' class='btn btn-success'>Edit</a>
					<a href='members.php?page=Delete&comid=" . $row['comment_id'] . "'class='btn btn-danger'>Delete</a>";
                        if ($row['Approve'] == 0) {
                            echo "<a href='members.php?page=Approve&comid=" . $row['comment_id'] . "'class='btn btn-info'>Approve</a>";
                        }
                        echo "</td>";
                        echo "</tr>";
                    }



                    ?>

                </table>
            </div>

        </div>

        <?php


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
                            <input type="hidden" value="<?php echo $row['Password'];  ?>" name="old-password">
                            <div class="col-sm-10">
                                <input type="password" value="" class="form-control" name="new-password" autocomplete="new-password">
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
            // password change or old password
            $password = '';
            if (empty($_POST['new-password'])) {
                $password = $_POST['old-password'];
            } else {
                $password = sha1($_POST['new-password']);
            }
            $formError = array();

            if (empty($username) || empty($email) || strlen($username) > 20) {
                $formError[] = 'username no morethan 20 char and email => required ';
            }
            if (empty($fullname) || strlen($fullname) < 4) {
                $formError[] = 'fullname is required and more than 4 character ';
            }


            //   $check = checkItem('Username', 'users', $username);
            // if ($check == 1) {
            // $formError[] = 'Username is exists in database ...please change username and try again';
            //}
            foreach ($formError as $error) {
                echo '<br>';
                echo '<br>';
                echo '<div class="alert alert-danger">' . $error . ' </div>' . '<br>';
            }
            if (empty($formError)) {
                $stmt = $con->prepare("UPDATE users SET Username = ?, Email = ?, Fullname= ?, Password = ? WHERE UserID = ?");
                $stmt->execute(array($username, $email, $fullname, $password, $userid));
                $count = $stmt->rowCount();

                echo "<br>";
                echo "<br>";
                // echo '<div class="alert alert-success">' . 'record is ' . $count . '</div>' . '<br>';
                $msg = '<div class="alert alert-success">' . 'record is ' . $count . '</div>' . '<br>';
                redirectHome($msg, 'back'); // back ==> means $url is not null;
            } else {
                echo 'No update';
            }
        } else {
            echo "<br>";
            echo "<br>";
            echo "<br>";
            $msg =    "<div class='alert alert-danger'> Sorry you can't browse page update diectly </div>";
            redirectHome($msg);
        }
    } elseif ($page == 'Delete') {
        $userid = isset($_GET['userid']) && is_numeric($_GET['userid']) ? intval($_GET['userid']) : 0;

        $check = checkItem('userid', 'users', $userid); //


        $stmt = $con->prepare("SELECT * FROM users WHERE UserID = ? ");
        $stmt->execute(array($userid));

        $count = $stmt->rowCount();
        if ($count > 0 && $check > 0) {
            $stmt = $con->prepare("DELETE  FROM users WHERE UserID = :zuserid ");
            $stmt->bindParam("zuserid", $userid);
            $stmt->execute();

            echo '<div class="alert alert-success">' . 'deleted ' . $count . '</div>' . '<br>';
            $msg =   '<div class="alert alert-success">' . 'succsess deleted record is ' . $count . '  </div>' . '<br>';
            redirectHome($msg, 'back');
        } else {
            echo '<div class="alert alert-dange">' . 'deleted  not  </div>' . '<br>';
            $msg = '<div class="alert alert-danger">' . 'Failed Delete Error because no id exists </div>' . '<br>';
            redirectHome($msg, 'back');
        }
    } elseif ($page == "Approve") {
        $userid = isset($_GET['userid']) && is_numeric($_GET['userid']) ? intval($_GET['userid']) : 0;

        $check = checkItem('userid', 'users', $userid); //


        $stmt = $con->prepare("SELECT * FROM users WHERE UserID = ? ");
        $stmt->execute(array($userid));

        $count = $stmt->rowCount();
        if ($count > 0 && $check > 0) {
            $stmt = $con->prepare("UPDATE users SET RegStatus = 1  WHERE UserID = ?");

            $stmt->execute(array($userid));
            echo '<br>';
            echo '<br>';
            echo '<br>';
            $msg =   '<div class="alert alert-success">' . 'succsess Activate  </div>' . '<br>';
            redirectHome($msg, 'back');
        } else {
            echo '<div class="alert alert-dange">' . 'deleted  not  </div>' . '<br>';
            $msg = '<div class="alert alert-danger">' . 'Failed Delete Error because no id exists </div>' . '<br>';
            redirectHome($msg, 'back');
        }
    } else {
        echo "Error not found page";
    }
    include $tpl . 'footer.php';
}
