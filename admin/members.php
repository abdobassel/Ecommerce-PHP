<?php

session_start();


$pageTitle = 'Members';



if (isset($_SESSION['Username'])) {
    include 'init.php';
    $page = isset($_GET['page']) ? $_GET['page'] : "Manage";




    if ($page == "Manage") {
        $query = '';
        if (isset($_GET['page2']) &&  $_GET['page2'] == 'Pending') {
            $query = 'AND RegStatus = 0'; // في حالة بس نه الحالة تساوي صفر هيتم استدعاء فقط اعاء غير مفعلين

        }

        $stmt = $con->prepare("SELECT * FROM users WHERE GroupID != 1 $query ORDER BY UserID DESC");

        $stmt->execute();
        $rows = $stmt->fetchAll();

?>
        <h1 class="text-center">Manage Members</h1>
        <div class="container">
            <div class="table-responsive">
                <table class="table table-bordered">
                    <tr>
                        <td>#ID</td>
                        <td>Username</td>
                        <td>Email</td>
                        <td>Fullname</td>
                        <td>Registred Date</td>
                        <td>Control</td>
                    </tr>
                    <?php
                    foreach ($rows as $row) {
                        echo "<tr>";
                        echo "<td>" . $row["UserID"] . "</td>";
                        echo "<td>" . $row["Username"] . "</td>";
                        echo "<td>" . $row["Email"] . "</td>";
                        echo "<td>" . $row["Fullname"] . "</td>";
                        echo "<td>" . $row["Date"] . "</td>";
                        echo "<td>
					<a href='members.php?page=Edit&userid=" . $row['UserID'] . "' class='btn btn-success'>Edit</a>
					<a href='members.php?page=Delete&userid=" . $row['UserID'] . "'class='btn btn-danger'>Delete</a>";
                        if ($row['RegStatus'] == 0) {
                            echo "<a href='members.php?page=Activate&userid=" . $row['UserID'] . "'class='btn btn-info'>Activate</a>";
                        }
                        echo "</td>";
                        echo "</tr>";
                    }



                    ?>

                </table>
            </div>
            <a href='members.php?page=Add' class="btn btn-primary"><i class="fa fa-plus"></i>Add New Member</a>
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

            foreach ($formError as $error) {
                echo '<br>';
                echo '<br>';
                echo '<div class="alert alert-danger">' . $error . ' </div>' . '<br>';
            }
            if (empty($formError)) {

                $stm2 = $con->prepare("SELECT * FROM users WHERE Username =? AND UserID != ? ");
                $stm2->execute(array($username, $userid));
                $count = $stm2->rowCount();
                if ($count == 1) {
                    $msg = '<div class="alert alert-danger">Sorry Username Is Exists </div>' . '<br>';
                    redirectHome($msg, 'back'); // back ==> means $url is not null;
                } else {
                    $stmt = $con->prepare("UPDATE users SET Username = ?, Email = ?, Fullname= ?, Password = ? WHERE UserID = ?");
                    $stmt->execute(array($username, $email, $fullname, $password, $userid));


                    echo "<br>";
                    echo "<br>";
                    // echo '<div class="alert alert-success">' . 'record is ' . $count . '</div>' . '<br>';
                    $msg = '<div class="alert alert-success">Success Update Memeber</div>' . '<br>';
                    redirectHome($msg, 'back'); // back ==> means $url is not null;
                }
            } else {
                $msg =  '<div class="alert alert-danger">' . $error . ' </div>' . '<br>';
                redirectHome($msg);
            }
        } else {
            echo "<br>";
            echo "<br>";
            echo "<br>";
            $msg =    "<div class='alert alert-danger'> Sorry you can't browse page update diectly </div>";
            redirectHome($msg);
        }
    } elseif ($page == 'Add') { ?>
        <h1 class='text-center'>Add New Member</h1>
        <div class="container">
            <form action="?page=Insert" method="post" enctype="multipart/form-data">
                <div class="form-group row">

                    <label class="col-sm-2 control-label">Username</label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control" name="username" autocomplete="off">
                    </div>
                    <!-- end username -->
                    <div class="form-group form-group-lg">
                        <label class="col-sm-2 control-label">Password</label>

                        <div class="col-sm-10">
                            <input type="password" class="form-control" name="password" autocomplete="password">
                        </div>
                        <!-- end pass -->
                        <div class="form-group form-group-lg">
                            <label class="col-sm-2 control-label">Email</label>
                            <div class="col-sm-10">
                                <input type="email" class="form-control" name="email" autocomplete="off">
                            </div>
                            <!-- end email -->

                            <div class="form-group form-group-lg">
                                <label class="col-sm-2 control-label">Fullname</label>
                                <div class="col-sm-10">
                                    <input type="text" class="form-control" name="full" autocomplete="off">
                                </div>
                            </div>


                            <!-- end fullname -->
                            <div class="form-group form-group-lg">
                                <label class="col-sm-2 control-label">Avatar</label>
                                <div class="col-sm-10">
                                    <input type="file" class="form-control" name="avatar">
                                </div>
                            </div>
                            <!-- end avaatr -->
                            <div class="form-group">
                                <div class="col-sm-offset-2 col-sm-10">
                                    <input type="submit" value="Save" class="btn btn-primary">
                                </div>
                            </div>
            </form>

        </div>

<?php   } elseif ($page == 'Insert') {
        echo '<br>';
        echo '<br>';

        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            echo '<br>';
            echo '<br>';

            // تعريف المتغيرات باستخدام $_FILES
            $avatar = $_FILES['avatar'];
            print_r($avatar);

            $avatarSize = $avatar['size'];
            $avatarName = $avatar['name'];
            $templateName = $avatar['tmp_name']; // اسم الملف المؤق
            //   $templateName = $_POST['template_name']; // يفترض أنه تم إرساله عبر النموذج باستخدام POST
            $avatarType = pathinfo($avatar['name'], PATHINFO_EXTENSION);

            // تحديد أنواع الصور التي يمكن رفعها
            $allowedImageTypes = array("jpg", "jpeg", "png", "gif");
            $avatarErrors = array();
            // التحقق من أن الصورة من النوع المسموح به
            if ($avatarName > 4194304) {
                echo "image Size is larger than 4 MB ";
                $avatarErrors[] = 'image Size is larger than 4 MB ';
                exit;
            }
            if (!empty($avatarName) && !in_array($avatarType, $allowedImageTypes)) {
                echo "نوع الصورة غير مسموح به.";
                $avatarErrors[] = 'image type not allowed ';
                exit;
            }
            if (empty($avatarErrors)) {
                $finalAvatar = rand(0, 100000) . '_' . $avatarName;
                move_uploaded_file($templateName, "uploads\avatars\\" . $finalAvatar);
            }
            //end avatar

            $username = $_POST['username'];

            $email = $_POST['email'];
            $full = $_POST['full'];

            if (empty($_POST['password'])) {
                echo 'error pass is empty';
            } else {
                $chek = checkItem('Username', 'users', $username);

                $password = sha1($_POST['password']);
                if ($chek == 1) {
                    echo '<br>';
                    echo '<br>';
                    $msg = '<div class="alert alert-danger">' . 'username  is exists in database   </div>' . '<br>';
                    redirectHome($msg, 'back', 2);
                } else {
                    $stmt = $con->prepare("INSERT INTO users(Username,Password,Fullname,Email, RegStatus,Date,avatar)
                    VALUES(:zuser,:zpass,:zfull,:zmail ,1,now(),:zavatar)
                    ");
                    $stmt->execute(array(
                        'zuser' => $username,
                        'zpass' => $password,
                        'zfull' => $full,
                        'zmail' => $email,
                        'zavatar' => $finalAvatar,
                    ));
                    $count = $stmt->rowCount();

                    echo '<br>';
                    //echo '<div class="alert alert-success">' . 'succsess inserted record is ' . $count . '  </div>' . '<br>';
                    $msg = '<div class="alert alert-success">' . 'succsess inserted record is ' . $count . '  </div>' . '<br>';

                    redirectHome($msg, 'back');
                }
            }
        } else {
            echo '<br>';
            echo '<br>';
            $msg =    "<div class='alert alert-danger'> Sorry you can't browse page insert diectly </div>";
            redirectHome($msg, 'back');
        }
    } elseif ($page == 'Delete') {
        $userid = isset($_GET['userid']) && is_numeric($_GET['userid']) ? intval($_GET['userid']) : 0;

        $check = checkItem('UserID', 'users', $userid); //


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
    } elseif ($page == "Activate") {
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
