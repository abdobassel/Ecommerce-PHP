<?php

// main index front not admins
session_start();
$pageTitle = 'Create New Ad';
include "init.php";
if (isset($_SESSION['user'])) {

    $stmt = $con->prepare("SELECT * FROM users WHERE Username = ?");
    $stmt->execute(array($userSession));

    $userInfo = $stmt->fetch();

    if ($_SERVER["REQUEST_METHOD"] == "POST") {

        $name = filter_var($_POST['name'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);

        $description = filter_var($_POST['desc'], FILTER_SANITIZE_SPECIAL_CHARS);
        $status = filter_var($_POST['status'], FILTER_SANITIZE_NUMBER_INT);

        $price = filter_var($_POST['price'], FILTER_SANITIZE_NUMBER_FLOAT);

        $country = filter_var($_POST['country'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        $category = filter_var($_POST['category'], FILTER_SANITIZE_NUMBER_INT);

        if (empty($_POST['name']) == true || empty($_POST['price']) == true || empty($_POST['country']) == true) {
            echo '<br>';
            echo '<br>';
            $msg = '<div class="alert alert-danger">' . 'name or price or country made => empty </div>' . '<br>';
            redirectHome($msg, 'back', 2);
        } else {
            $stmt = $con->prepare("INSERT INTO items(Name, Description,Status,Price, Country_Made,Cat_Id, Mem_ID,Add_Date)
                    VALUES(:zname,:zdesc,:zstatus,:zprice ,:zmade,:zcat,:zmem, now())
                    ");
            $stmt->execute(array(
                'zname' => $name,
                'zdesc' => $description,
                'zstatus' => $status,
                'zprice' => $price,
                'zmade' => $country,
                'zcat' => $category,
                'zmem' => $userInfo['UserID'] // UserId for one user only in session;
            ));
            $count = $stmt->rowCount();
            if ($count > 0) {
                header('Location: newad.php');
            }
        }
    }

?>
    <h1 class="text-center">Create New Ad</h1>
    <div class="information block">
        <div class="container">
            <div class="panel panel-primary">
                <div class="panel-heading">Create New Ad</div>

                <div class="panel-body">
                    <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
                        <div class="form-group row">
                            <label class="col-sm-2 col-form-label">Item Name</label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control" name="name">
                            </div>
                        </div>
                        <!-- end Name item -->

                        <div class="form-group row">
                            <label class="col-sm-2 col-form-label">Description</label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control" name="desc">
                            </div>
                        </div>
                        <!-- end Description item -->
                        <div class="form-group row">
                            <label class="col-sm-2 col-form-label">Price </label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control" name="price">
                            </div>
                        </div>
                        <!-- end Price item -->
                        <div class="form-group row">
                            <label class="col-sm-2 col-form-label">Country Made</label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control" name="country">
                            </div>
                        </div>
                        <!-- end Country made item -->
                        <div class="form-group row">
                            <label class="col-sm-2 col-form-label">Status</label>
                            <div class="col-sm-10">
                                <select class="form-control" name="status">
                                    <option value="0">.....</option>
                                    <option value="1">New</option>
                                    <option value="2">Like New</option>

                                    <option value="3">Used</option>
                                </select>
                            </div>
                        </div>
                        <!-- end Status item -->
                        <div class="form-group row">
                            <label class="col-sm-2 col-form-label">Category</label>
                            <div class="col-sm-10">
                                <select class="form-control" name="category">
                                    <option value="0">.....</option>
                                    <?php
                                    $stms = $con->prepare("SELECT * FROM categories");
                                    $stms->execute();
                                    $catgs =   $stms->fetchAll();
                                    foreach ($catgs as $cat) {
                                        echo '<option value="' . $cat['Id']  . '">' . $cat['Name'] . '</option>';
                                    }

                                    ?>
                                </select>
                            </div>
                        </div>
                        <!-- end Category item -->






                        <div class="form-group row">
                            <div class="col-sm-10 offset-sm-2">
                                <input type="submit" value="Save" class="btn btn-primary">
                            </div>
                        </div>
                    </form>
                </div>

            </div>
        </div>
    </div>
    <div class="information-block">
        <div class="container">
            <div class="panel panel-primary">
                <div class="panel-heading">My Ads اعلاناتي</div>
                <?php
                $stmt2 = $con->prepare("SELECT * FROM items WHERE Mem_ID = ? ORDER BY Item_Id DESC");
                $stmt2->execute(array($userInfo['UserID']));

                $items = $stmt2->fetchAll();



                ?>
                <div class="panel-body">

                    <div class="row">
                        <?php
                        if (empty($items)) {
                            echo '<div class="alert alert-danger"><h3 class="text-center">There is No items yet...</h3> </div>' . '<br>';
                        } else {
                            foreach ($items as $item) { ?>
                                <div class="col-sm-6 col-md-3">
                                    <div class="thumbnail item-box">
                                        <span class="price-tag"><?php
                                                                echo  $item['Price'];
                                                                ?></span>
                                        <img class="img-responsive" src="1.jpg" alt="">
                                        <div class="caption">
                                            <h3><?php echo
                                                '<a href="items.php?itemid=' . $item["Item_Id"] . '">' . $item['Name'] . '</a>';
                                                ?></h3>
                                            <p><?php
                                                echo  $item['Description'];
                                                ?></p>
                                            <p> Date : <?php
                                                        echo  $item['Add_Date'];
                                                        ?></p>

                                        </div>
                                    </div>

                                </div>



                        <?php  }
                        }

                        ?>
                    </div>


                </div>


                <?php



                ?>



            </div>
        </div>
    </div>

<?php

} else {
    header("Location: login.php");
    exit();
}
?>

<?php include $tpl . "footer.php";
