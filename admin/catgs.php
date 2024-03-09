<?php
ob_start();
session_start();


$pageTitle = '';



if (isset($_SESSION['Username'])) {
    include 'init.php';

    $page = isset($_GET['page']) ? $_GET['page'] : "Manage";



    if ($page == "Manage") {

        $sort = 'ASC';

        $sorting = array('ASC', 'DESC');

        if (isset($_GET['sort']) && in_array($_GET['sort'], $sorting)) {
            $sort = $_GET['sort'];
        }


        $stmt = $con->prepare("SELECT * FROM categories ORDER BY Ordering  $sort");
        $stmt->execute();
        $cates =  $stmt->fetchAll();

?>

        <h1 class="text-center">Categories Manage</h1>
        <div class="container">
            <div class="latest">
                <div class="container">
                    <div class="row">
                        <div class="com-sm-6">
                            <div class="panel panel-default">
                                <div class="panel-heading">
                                    Categories Manage
                                    <div style="font-size:18px;font-weight:600" class="pull-right">
                                        Ordering :
                                        <a style="font-size:16;font-weight:600" href="?sort=ASC">Asc</a>

                                        <a style="font-size:16px;font-weight:600" href="?sort=DESC">Desc</a>

                                    </div>

                                </div>
                                <div class="panel-body">
                                    <ui class="list-unstyled latest-users">


                                        <?php
                                        foreach ($cates as $cat) {
                                            echo  "<li>";
                                            echo $cat['Name'];

                                            echo '<a href="catgs.php?page=Edit&catid=' . $cat['Id'] . '">';

                                            echo '<span class="btn btn-success pull-right">';

                                            echo  '<i class ="fa fa-edit"></i>Edit';
                                            echo "</span>";
                                            echo "</a>";

                                            echo '<a href="catgs.php?page=Delete&catid=' . $cat['Id'] . '">';

                                            echo '<span class="btn btn-danger pull-right">';

                                            echo  '<i class ="fa fa-delete"></i>Delete';
                                            echo "</span>";
                                            echo "</a>";
                                            if ($cat['Visibility'] == '1') {
                                                echo '<a href="catgs.php?page=' . $cat['Id'] . '">';

                                                echo '<span class="btn btn-primary pull-right">';

                                                echo  '<i class ="fa fa-delete"></i>Show';
                                                echo "</span>";
                                                echo "</a>";
                                            } else {
                                                echo '<a href="catgs.php?page=Edit&delete=' . $cat['Id'] . '">';

                                                echo '<span class="btn btn-warning pull-right">';

                                                echo  '<i class ="fa fa-delete"></i>Hide';
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
                <a href='catgs.php?page=Add' class="btn btn-danger"><i class="fa fa-plus"></i>Add New Category</a>
            </div>

        </div>
    <?php

    } elseif ($page == 'Add') {
        echo '<br>';
        echo '<br>';
        echo 'Welcome Add catgrs ';
        //start coding html    
    ?>

        <h1 class="text-center">Add New Category</h1>
        <div class="container">
            <form action="?page=Insert" method="post">
                <div class="form-group row">
                    <label class="col-sm-2 col-form-label">Category Name</label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control" name="name" autocomplete="off">
                    </div>
                </div>
                <!-- end cat name -->
                <div class="form-group row">
                    <label class="col-sm-2 col-form-label">Description</label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control" name="description">
                    </div>
                </div>
                <!-- end desc -->
                <div class="form-group row">
                    <label class="col-sm-2 col-form-label">Ordering</label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control" name="ordering" autocomplete="off">
                    </div>
                </div>
                <!-- end ordering -->
                <div class="form-group row">
                    <label class="col-sm-2 col-form-label">Visible</label>
                    <div class="col-sm-10">
                        <div class="form-check form-check-inline">
                            <input id="vis-yes" type="radio" name="visibility" class="form-check-input" value="0" checked>
                            <label class="form-check-label" for="vis-yes">Yes</label>
                        </div>
                        <div class="form-check form-check-inline">
                            <input id="vis-no" type="radio" name="visibility" class="form-check-input" value="1">
                            <label class="form-check-label" for="vis-no">No</label>
                        </div>
                    </div>
                </div>
                <!-- end visibility -->
                <div class="form-group row">
                    <label class="col-sm-2 col-form-label">Allow Commenting</label>
                    <div class="col-sm-10">
                        <div class="form-check form-check-inline">
                            <input id="com-yes" type="radio" name="commenting" class="form-check-input" value="0" checked>
                            <label class="form-check-label" for="com-yes">Yes</label>
                        </div>
                        <div class="form-check form-check-inline">
                            <input id="com-no" type="radio" name="commenting" class="form-check-input" value="1">
                            <label class="form-check-label" for="com-no">No</label>
                        </div>
                    </div>
                </div>
                <!-- end allow comment -->
                <div class="form-group row">
                    <label class="col-sm-2 col-form-label">Allow Ads</label>
                    <div class="col-sm-10">
                        <div class="form-check form-check-inline">
                            <input id="ads-yes" type="radio" name="ads" class="form-check-input" value="0" checked>
                            <label class="form-check-label" for="ads-yes">Yes</label>
                        </div>
                        <div class="form-check form-check-inline">
                            <input id="ads-no" type="radio" name="ads" class="form-check-input" value="1">
                            <label class="form-check-label" for="ads-no">No</label>
                        </div>
                    </div>
                </div>
                <!-- end allow ads -->
                <div class="form-group row">
                    <div class="col-sm-10 offset-sm-2">
                        <input type="submit" value="Save" class="btn btn-primary">
                    </div>
                </div>
            </form>
        </div>




        <?php

    } elseif ($page == 'Insert') {
        if ($_SERVER["REQUEST_METHOD"] == "POST") {

            $name = $_POST['name'];

            $description = $_POST['description'];
            $ordering = $_POST['ordering'];

            $commenting = $_POST['commenting'];

            $ads = $_POST['ads'];

            $visiblity = $_POST['visibility'];


            $chek = checkItem('Name', 'categories', $name);


            if ($chek == 1 || empty($_POST['name']) == true) {
                echo '<br>';
                echo '<br>';
                $msg = '<div class="alert alert-danger">' . 'category name  is empty or exists in database   </div>' . '<br>';
                redirectHome($msg, 'back', 2);
            } else {
                $stmt = $con->prepare("INSERT INTO categories(Name,	Description,Ordering,Visibility, Alow_Comment,Alow_ads)
                    VALUES(:zname,:zdesc,:zordering,:zvisible ,:zcomment,:zads)
                    ");
                $stmt->execute(array('zname' => $name, 'zdesc' => $description, 'zordering' => $ordering, 'zvisible' => $visiblity, 'zcomment' => $commenting, 'zads' => $ads));
                $count = $stmt->rowCount();

                echo '<br>';
                //echo '<div class="alert alert-success">' . 'succsess inserted record is ' . $count . '  </div>' . '<br>';
                $msg = '<div class="alert alert-success">' . 'succsess inserted category is ' . $count . '  </div>' . '<br>';

                redirectHome($msg, 'back');
            }
        } else {
            echo '<br>';
            echo '<br>';
            $msg =    "<div class='alert alert-danger'> Sorry you can't browse page insert diectly </div>";
            redirectHome($msg, 'back');
        }
    } elseif ($page == 'Edit') {
        $catid = isset($_GET['catid']) && is_numeric($_GET['catid']) ? intval($_GET['catid']) : 0;

        $stmt = $con->prepare("SELECT * FROM categories WHERE Id = ? ");
        $stmt->execute(array($catid));
        $row = $stmt->fetch(); // array of info db
        $count = $stmt->rowCount();



        if ($count > 0) {
            // form show ...
        ?>
            <h1 class='text-center'>Edit Category</h1>
            <div class="container">
                <form action="?page=Update" method="post">
                    <div class="form-group row">
                        <input type="hidden" value="<?php echo $catid; ?>" name="catid">
                        <label class="col-sm-2 col-form-label">Category Name</label>
                        <div class="col-sm-10">
                            <input type="text" value="<?php echo $row['Name']; ?>" class="form-control" name="name" autocomplete="off">
                        </div>
                    </div>

                    <div class="form-group row">
                        <label class="col-sm-2 col-form-label">Description</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" value="<?php echo $row['Description']; ?>" name="description">
                        </div>
                    </div>

                    <div class="form-group row">
                        <label class="col-sm-2 col-form-label">Ordering</label>
                        <div class="col-sm-10">
                            <input type="text" value="<?php echo $row['Ordering']; ?>" class="form-control" name="ordering">
                        </div>
                    </div>

                    <div class="form-group row">
                        <label class="col-sm-2 col-form-label">Visible</label>
                        <div class="col-sm-10">
                            <div class="form-check">
                                <input id="vis-yes" type="radio" name="visibility" class="form-check-input" value="0" <?php if ($row['Visibility'] == "0") {
                                                                                                                            echo 'checked';
                                                                                                                        } ?> />
                                <label class="form-check-label" for="vis-yes">Yes</label>
                            </div>
                            <div class="form-check">
                                <input id="vis-no" type="radio" name="visibility" class="form-check-input" value="1" <?php if ($row['Visibility'] == "1") {
                                                                                                                            echo 'checked';
                                                                                                                        } ?> />
                                <label class="form-check-label" for="vis-no">No</label>
                            </div>
                        </div>
                    </div>

                    <div class="form-group row">
                        <label class="col-sm-2 col-form-label">Allow Commenting</label>
                        <div class="col-sm-10">
                            <div class="form-check">
                                <input id="com-yes" type="radio" name="commenting" class="form-check-input" value="0" <?php if ($row['Alow_Comment'] == "0") {
                                                                                                                            echo 'checked';
                                                                                                                        } ?> />
                                <label class="form-check-label" for="com-yes">Yes</label>
                            </div>
                            <div class="form-check">
                                <input id="com-no" type="radio" name="commenting" class="form-check-input" value="1" <?php if ($row['Alow_Comment'] == "1") {
                                                                                                                            echo 'checked';
                                                                                                                        } ?> />
                                <label class="form-check-label" for="com-no">No</label>
                            </div>
                        </div>
                    </div>

                    <div class="form-group row">
                        <label class="col-sm-2 col-form-label">Allow Ads</label>
                        <div class="col-sm-10">
                            <div class="form-check">
                                <input id="ads-yes" type="radio" name="ads" class="form-check-input" value="0" <?php if ($row['Alow_ads'] == "0") {
                                                                                                                    echo 'checked';
                                                                                                                } ?> />
                                <label class="form-check-label" for="ads-yes">Yes</label>
                            </div>
                            <div class="form-check">
                                <input id="ads-no" type="radio" name="ads" class="form-check-input" value="1" <?php if ($row['Alow_ads'] == "1") {
                                                                                                                    echo 'checked';
                                                                                                                } ?> />
                                <label class="form-check-label" for="ads-no">No</label>
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="col-sm-offset-2 col-sm-10">
                            <input type="submit" value="Save" class="btn btn-primary">
                        </div>
                    </div>
                </form>
            </div>



<?php

        } else {
            $msg = '<div class="alert alert-danger"> Sorry Not Allowed Directly Browsing </div>' . '<br>';
            redirectHome($msg); // back ==> means $url is not null;
        }
    } elseif ($page == 'Delete') {
        $catid = isset($_GET['catid']) && is_numeric($_GET['catid']) ? intval($_GET['catid']) : 0;

        $check = checkItem('Id', 'categories', $catid); //





        if ($check > 0) {
            $stmt = $con->prepare("DELETE FROM categories WHERE Id = :zcatid");
            $stmt->bindParam(":zcatid", $catid);
            $stmt->execute();


            $msg =   '<div class="alert alert-success"> Category Is Deleted Success  </div>' . '<br>';
            redirectHome($msg, 'back');
        } else {
            echo '<div class="alert alert-dange">' . 'deleted  not  </div>' . '<br>';
            $msg = '<div class="alert alert-danger">' . 'Failed Delete Error because no id exists </div>' . '<br>';
            redirectHome($msg, 'back');
        }
    } elseif ($page == 'Update') {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $id = $_POST['catid'];
            $name = $_POST['name'];

            $description = $_POST['description'];
            $ordering = $_POST['ordering'];

            $commenting = $_POST['commenting'];

            $ads = $_POST['ads'];

            $visiblity = $_POST['visibility'];

            $chek = checkItem('Name', 'categories', $name);


            if (empty($_POST['name']) == true) {
                echo '<br>';
                echo '<br>';
                $msg = '<div class="alert alert-danger">' . 'category name is empty   </div>' . '<br>';
                redirectHome($msg, 'back', 2);
            } else {
                $stmt = $con->prepare("UPDATE categories SET Name = ?, Description = ?, Ordering= ?, Visibility = ?, Alow_Comment=?, Alow_ads = ? WHERE Id = ?");
                $stmt->execute(array($name, $description, $ordering, $visiblity, $commenting, $ads, $id));
                $count = $stmt->rowCount();

                echo "<br>";
                echo "<br>";
                // echo '<div class="alert alert-success">' . 'record is ' . $count . '</div>' . '<br>';
                $msg = '<div class="alert alert-success">' . 'Update is Successfuly and Record is ' . $count . '</div>' . '<br>';
                redirectHome($msg, 'back'); // back ==> means $url is not null;
            }
        } else {

            $msg =    "<div class='alert alert-danger'> Sorry you can't browse page update diectly </div>";
            redirectHome($msg);
        }
    }
    include $tpl . 'footer.php';
} else {
    header('Location: index.php');
    exit();
}
ob_end_flush();
