<?php
ob_start();
session_start();


$pageTitle = '';



if (isset($_SESSION['Username'])) {
    include 'init.php';

    $page = isset($_GET['page']) ? $_GET['page'] : "Manage";



    if ($page == "Manage") {
        echo '<br>';
        echo 'Welcome catgrs ';
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

    } elseif ($page == 'Update') {
        echo '<br>';
        echo 'Welcome UPDATE catgrs ';
        echo '<br>';
        echo 'Welcome ADD catgrs ';
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
    } elseif ($page == 'Insert') {
        echo '<br>';
        echo 'Welcome INSERT catgrs ';
        echo '<br>';
        echo 'Welcome ADD catgrs ';
    }
    include $tpl . 'footer.php';
} else {
    header('Location: index.php');
    exit();
}
ob_end_flush();
