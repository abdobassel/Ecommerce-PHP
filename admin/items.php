<?php
ob_start();
session_start();


$pageTitle = '';



if (isset($_SESSION['Username'])) {
    include 'init.php';

    $page = isset($_GET['page']) ? $_GET['page'] : "Manage";



    if ($page == "Manage") {
        $stmt = $con->prepare("SELECT `items`.*,
         categories.Name AS cat_name ,users.Username FROM items 
         INNER JOIN categories ON categories.Id = items.Cat_Id 
         INNER JOIN users ON users.UserID = items.Mem_ID
         ORDER BY Item_Id DESC
        ");

        $stmt->execute();
        $items = $stmt->fetchAll();

?>
        <h1 class="text-center">Manage Items</h1>
        <div class="container">
            <div class="table-responsive">
                <table class="table table-bordered">
                    <tr>
                        <td>#ID</td>
                        <td>Name</td>
                        <td>Description</td>
                        <td>Price</td>
                        <td>Category</td>
                        <td>Username</td>
                        <td>Adding Date</td>
                        <td>Control</td>
                    </tr>
                    <?php
                    foreach ($items as $item) {
                        echo "<tr>";
                        echo "<td>" . $item["Item_Id"] . "</td>";
                        echo "<td>" . $item["Name"] . "</td>";
                        echo "<td>" . $item["Description"] . "</td>";
                        echo "<td>" . $item["Price"] . "</td>";
                        echo "<td>" . $item["cat_name"] . "</td>";
                        echo "<td>" . $item["Username"] . "</td>";
                        echo "<td>" . $item["Add_Date"] . "</td>";


                        echo "<td>
					<a href='items.php?page=Edit&itemid=" . $item['Item_Id'] . "' class='btn btn-success'>Edit</a>
					<a href='items.php?page=Delete&itemid=" . $item['Item_Id'] . "'class='btn btn-danger'>Delete</a>";

                        echo "</td>";
                        echo "</tr>";
                    }



                    ?>

                </table>
            </div>
            <a href='items.php?page=Add' class="btn btn-primary"><i class="fa fa-plus"></i>Add New Member</a>
        </div>

    <?php
    } elseif ($page == 'Add') { ?>
        <h1 class="text-center">Add New Item</h1>
        <div class="container">
            <form action="?page=Insert" method="post">
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
                    <label class="col-sm-2 col-form-label">Members</label>
                    <div class="col-sm-10">
                        <select class="form-control" name="member">
                            <option value="0">.....</option>
                            <?php
                            $stms = $con->prepare("SELECT * FROM users WHERE GroupId = 0"); // without admins
                            $stms->execute();
                            $users =   $stms->fetchAll();
                            foreach ($users as $user) {
                                echo '<option value="' . $user['UserID']  . '">' . $user['Username'] . '</option>';
                            }

                            ?>
                        </select>
                    </div>
                </div>
                <!-- end Members  -->




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

            $description = $_POST['desc'];
            $status = $_POST['status'];

            $price = $_POST['price'];

            $country = $_POST['country'];
            $category = $_POST['category'];

            $member = $_POST['member'];





            // Cat_Id //Mem_ID

            $chek = checkItem('Name', 'items', $name);
            if (empty($_POST['name']) == true || empty($_POST['price']) == true || empty($_POST['country']) == true) {
                echo '<br>';
                echo '<br>';
                $msg = '<div class="alert alert-danger">' . 'name or price or country made => empty </div>' . '<br>';
                redirectHome($msg, 'back', 2);
            } else {
                $stmt = $con->prepare("INSERT INTO items(Name,	Description,Status,Price, Country_Made,Cat_Id, Mem_ID,Add_Date)
                        VALUES(:zname,:zdesc,:zstatus,:zprice ,:zmade,:zcat,:zmem, now())
                        ");
                $stmt->execute(array(
                    'zname' => $name, 'zdesc' => $description, 'zstatus' => $status, 'zprice' => $price, 'zmade' => $country, 'zcat' => $category, 'zmem' => $member
                ));
                $count = $stmt->rowCount();

                echo '<br>';
                //echo '<div class="alert alert-success">' . 'succsess inserted record is ' . $count . '  </div>' . '<br>';
                $msg = '<div class="alert alert-success">' . 'succsessfuly inserted Item  </div>' . '<br>';

                redirectHome($msg, 'back');
            }
        } else {
            $msg =    "<div class='alert alert-danger'> Sorry you can't browse page insert diectly </div>";
            redirectHome($msg, 'back');
        }
    } elseif ($page == 'Edit') {

        $itemid = isset($_GET['itemid']) && is_numeric($_GET['itemid']) ? intval($_GET['itemid']) : 0;

        $stmt = $con->prepare("SELECT * FROM items WHERE Item_Id = ? ");
        $stmt->execute(array($itemid));
        $item = $stmt->fetch(); // array of info db
        $count = $stmt->rowCount();

        if ($count > 0) {
        ?>
            <h1 class="text-center">Edit Item</h1>
            <div class="container">
                <form action="?page=Update" method="post">
                    <div class="form-group row">
                        <input type="hidden" class="form-control" name="itemid" value="<?php echo $item['Item_Id'] ?>">
                        <label class="col-sm-2 col-form-label">Item Name</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" name="name" value="<?php echo $item['Name'] ?>">
                        </div>
                    </div>
                    <!-- end Name item -->

                    <div class="form-group row">
                        <label class="col-sm-2 col-form-label">Description</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" name="desc" value="<?php echo $item['Description'] ?>">

                        </div>
                    </div>
                    <!-- end Description item -->
                    <div class="form-group row">
                        <label class="col-sm-2 col-form-label">Price </label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" name="price" value="<?php echo $item['Price'] ?>">
                        </div>
                    </div>
                    <!-- end Price item -->
                    <div class="form-group row">
                        <label class="col-sm-2 col-form-label">Country Made</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" name="country" value="<?php echo $item['Country_Made'] ?>">
                        </div>
                    </div>
                    <!-- end Country made item -->
                    <div class="form-group row">
                        <label class="col-sm-2 col-form-label">Status</label>
                        <div class="col-sm-10">
                            <select class="form-control" name="status" value="<?php echo $item['Status'] ?>">

                                <option value="1" <?php if ($item['Status'] == '1') {
                                                        echo 'selected';
                                                    } ?>>New</option>
                                <option value="2" <?php if ($item['Status'] == '2') {
                                                        echo 'selected';
                                                    } ?>>Like New</option>

                                <option value="3" <?php if ($item['Status'] == '3') {
                                                        echo 'selected';
                                                    } ?>>Used</option>
                            </select>
                        </div>
                    </div>
                    <!-- end Status item -->
                    <div class="form-group row">
                        <label class="col-sm-2 col-form-label">Category</label>
                        <div class="col-sm-10">
                            <select class="form-control" name="category">

                                <?php
                                $stms = $con->prepare("SELECT * FROM categories");
                                $stms->execute();
                                $catgs =   $stms->fetchAll();
                                foreach ($catgs as $cat) {
                                    echo '<option value="' . $cat['Id']  . '"';
                                    if ($cat['Id'] == $item['Cat_Id']) {
                                        echo 'selected';
                                    }
                                    echo '>' . $cat['Name'] . '</option>';
                                }

                                ?>
                            </select>
                        </div>
                    </div>
                    <!-- end Category item -->
                    <div class="form-group row">
                        <label class="col-sm-2 col-form-label">Members</label>
                        <div class="col-sm-10">
                            <select class="form-control" name="member" value="<?php echo $item['Mem_ID'] ?>">

                                <?php
                                $stms = $con->prepare("SELECT * FROM users WHERE GroupId = 0"); // without admins
                                $stms->execute();
                                $users =   $stms->fetchAll();
                                foreach ($users as $user) {
                                    echo '<option value="' . $user['UserID']  . '"';
                                    if ($user['UserID'] == $item['Mem_ID']) {
                                        echo 'selected';
                                    }
                                    echo '>' . $user['Fullname'] . '</option>';
                                }

                                ?>
                            </select>
                        </div>
                    </div>
                    <!-- end Members  -->




                    <div class="form-group row">
                        <div class="col-sm-10 offset-sm-2">
                            <input type="submit" value="Save" class="btn btn-primary">
                        </div>
                    </div>
                </form>
                <?php // end Form Item Idet 
                // Statrt Comments => for this item only

                $stmt = $con->prepare("  SELECT comments.*, users.Username FROM comments 
                                            INNER JOIN users ON users.UserID = comments.user_id
                                            WHERE comments.item_id = ?");

                $stmt->execute(array($itemid));
                $rows = $stmt->fetchAll();
                if (!empty($rows)) {
                ?>




                    <h1 class="text-center">Manage [<span style="color: green;"> <?php echo $item['Name']; ?></span> ] Comments</h1>
                    <div class="container">
                        <div class="table-responsive">
                            <table class="table table-bordered">
                                <tr>

                                    <td>Comment</td>
                                    <td>Username</td>

                                    <td>Comment Date</td>
                                    <td>Control</td>
                                </tr>
                                <?php
                                foreach ($rows as $row) {
                                    echo "<tr>";

                                    echo "<td>" . $row["body"] . "</td>";
                                    echo "<td>" . $row["Username"] . "</td>";

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
                    <?php
                } else {
                    echo '<div class="container text-center"';
                    echo "<h1>No Comments</h1> ";
                    echo "</div>";
                }
                    ?>
                    </div>

            </div>




<?php

        }
    } elseif ($page == 'Update') {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $itemid = $_POST['itemid'];
            $name = $_POST['name'];

            $description = $_POST['desc'];
            $price = $_POST['price'];

            $country = $_POST['country'];

            $status = $_POST['status'];

            $category = $_POST['category'];
            $member = $_POST['member'];


            $chek = checkItem('Item_Id', 'items', $itemid);


            if (empty($_POST['name']) == true || empty($_POST['price']) == true || empty($_POST['country']) == true) {
                echo '<br>';
                echo '<br>';
                $msg = '<div class="alert alert-danger">' . 'Some Feilds can\'t be empty  </div>' . '<br>';
                redirectHome($msg, 'back', 2);
            } else {

                $stmt = $con->prepare("UPDATE items SET Name = ?, Description = ?, Price= ?, Country_Made = ?, Status=?, Mem_ID =?, Cat_Id = ? WHERE Item_Id = ?");
                $stmt->execute(array($name, $description, $price, $country, $status, $member, $category, $itemid));


                echo "<br>";
                echo "<br>";
                // echo '<div class="alert alert-success">' . 'record is ' . $count . '</div>' . '<br>';
                $msg = '<div class="alert alert-success">' . 'Update is Successfuly </div>' . '<br>';
                redirectHome($msg, 'back'); // back ==> means $url is not null;
            }
        } else {

            $msg =    "<div class='alert alert-danger'> Sorry you can't browse page update diectly </div>";
            redirectHome($msg);
        }
    } elseif ($page == 'Delete') {
    } elseif ($page == 'Approve') {
        $itemid = isset($_GET['itemid']) && is_numeric($_GET['itemid']) ? intval($_GET['itemid']) : 0;
        $check = checkItem('Item_Id', 'items', $itemid); //
        if ($check > 0) {
            $stmt = $con->prepare("UPDATE items SET Approve = 1  WHERE Item_Id = ?");

            $stmt->execute(array($itemid));

            $msg =   '<div class="alert alert-success">' . 'Item Is Approved  </div>' . '<br>';
            redirectHome($msg, 'back', 1);
        } else {
            echo '<div class="alert alert-dange">' . 'deleted  not  </div>' . '<br>';
            $msg = '<div class="alert alert-danger">' . 'Failed Approve Error because no id exists </div>' . '<br>';
            redirectHome($msg, 'back');
        }
    }
    include $tpl . 'footer.php';
} else {
    header('Location: index.php');
    exit();
}

ob_end_flush();
