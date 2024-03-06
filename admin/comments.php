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
        ORDER BY comment_id DESC
        
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
					<a href='comments.php?page=Edit&comid=" . $row['comment_id'] . "' class='btn btn-success'>Edit</a>
					<a href='comments.php?page=Delete&comid=" . $row['comment_id'] . "'class='btn btn-danger'>Delete</a>";
                        if ($row['Approve'] == 0) {
                            echo "<a href='comments.php?page=Approve&comid=" . $row['comment_id'] . "'class='btn btn-info'>Approve</a>";
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
        $comid = isset($_GET['comid']) && is_numeric($_GET['comid']) ? intval($_GET['comid']) : 0;

        $stmt = $con->prepare("SELECT * FROM comments WHERE comment_id = ? ");
        $stmt->execute(array($comid));
        $row = $stmt->fetch(); // array of info db
        $count = $stmt->rowCount();

        if ($count > 0) {
            // form show ...
        ?>
            <h1 class='text-center'>Edit Comment</h1>
            <div class="container">
                <form class="form-horizontal" action="comments.php?page=Update" method="post">
                    <!-- start comment body -->
                    <div class="form-group">
                        <input type="hidden" value="<?php echo $comid; ?>" name="comid">
                        <label class="col-sm-2 control-label">Comment</label>
                        <div class="col-sm-10">
                            <textarea class="form-control" name="comment"><?php echo $row['body']; ?></textarea>
                        </div>
                    </div>
                    <!-- end comment body -->

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
            $comid = $_POST['comid'];
            $body = $_POST['comment'];





            if (empty($body)) {
                $msg = '<div class="alert alert-success"> Not Update Comments is emtpy </div>';
                redirectHome($msg, 'back'); // back ==> means $url is not null;
                echo 'No update';
            } else {
                $stmt = $con->prepare("UPDATE comments SET body = ? WHERE comment_id = ?");
                $stmt->execute(array($body, $comid));


                echo "<br>";
                echo "<br>";
                // echo '<div class="alert alert-success">' . 'record is ' . $count . '</div>' . '<br>';
                $msg = '<div class="alert alert-success">' . 'Updated Comment' . '</div>' . '<br>';
                redirectHome($msg, 'back'); // back ==> means $url is not null;

            }
        } else {

            $msg =    "<div class='alert alert-danger'> Sorry you can't browse page update diectly </div>";
            redirectHome($msg);
        }
    } elseif ($page == 'Delete') {
        $comment_id = isset($_GET['comid']) && is_numeric($_GET['comid']) ? intval($_GET['comid']) : 0;

        $check = checkItem('comment_id', 'comments', $comment_id); //


        //  $stmt = $con->prepare("SELECT * FROM users WHERE UserID = ? ");
        //  $stmt->execute(array($userid));

        // $count = $stmt->rowCount();
        if ($check > 0) {
            $stmt = $con->prepare("DELETE FROM comments WHERE comment_id = :zcomid");
            $stmt->bindParam(":zcomid", $comment_id);
            $stmt->execute();


            // echo '<div class="alert alert-success">' . 'deleted Comments success</div>' . '<br>';
            $msg =   '<div class="alert alert-success">' . 'deleted Comments success</div>' . '<br>';
            redirectHome($msg, 'back');
        } else {
            echo '<div class="alert alert-dange">' . 'deleted  not  </div>' . '<br>';
            $msg = '<div class="alert alert-danger">' . 'Failed Delete Error because no id exists </div>' . '<br>';
            redirectHome($msg, 'back');
        }
    } elseif ($page == "Approve") {
        $comid = isset($_GET['comid']) && is_numeric($_GET['comid']) ? intval($_GET['comid']) : 0;

        $check = checkItem('comment_id', 'comments', $comid);

        if ($check > 0) {
            $stmt = $con->prepare("UPDATE comments SET Approve = 1  WHERE comment_id = ?");

            $stmt->execute(array($comid));

            $msg =   '<div class="alert alert-success">' . ' Comment is Public Now </div>' . '<br>';
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
