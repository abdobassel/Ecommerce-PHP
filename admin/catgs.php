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

                                            echo '<a href="members.php?page=Edit&catid=' . $cat['Id'] . '">';

                                            echo '<span class="btn btn-success pull-right">';

                                            echo  '<i class ="fa fa-edit"></i>Edit';
                                            echo "</span>";
                                            echo "</a>";

                                            echo '<a href="members.php?page=Edit&delete=' . $cat['Id'] . '">';

                                            echo '<span class="btn btn-danger pull-right">';

                                            echo  '<i class ="fa fa-delete"></i>Delete';
                                            echo "</span>";
                                            echo "</a>";
                                            if ($cat['Visibility'] == '1') {
                                                echo '<a href="members.php?page=Edit&delete=' . $cat['Id'] . '">';

                                                echo '<span class="btn btn-primary pull-right">';

                                                echo  '<i class ="fa fa-delete"></i>Show';
                                                echo "</span>";
                                                echo "</a>";
                                            } else {
                                                echo '<a href="members.php?page=Edit&delete=' . $cat['Id'] . '">';

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
            echo '<br>';
            echo '<br>';
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
        echo '<br>';
        echo 'Welcome Edit catgrs ';
        echo '<br>';
        echo 'Welcome Edit catgrs ';
    } elseif ($page == 'Delete') {
        echo '<br>';
        echo 'WelcomeDELETE catgrs ';
        echo '<br>';
        echo 'Welcome ADD catgrs ';
    } elseif ($page == 'Update') {
        echo '<br>';
        echo 'Welcome Update catgrs ';
        echo '<br>';
        echo 'Welcome Update catgrs ';
    }
    include $tpl . 'footer.php';
} else {
    header('Location: index.php');
    exit();
}
ob_end_flush();
