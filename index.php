<?php

// main index front not admins
ob_start();
session_start();
$pageTitle = 'Home';
include "init.php";
?>
<div class="container">
    <h1 class="text-center">ALL Our Products And Categories
    </h1>


    <div class="panel panel-primary">
        <div class="panel-heading">
            <h3 id="all-categories" class="panel-title">Categories</h3>
        </div>
        <div class="panel-body">
            <div class="row">
                <?php
                $categories = getAll('categories', 'Id');
                foreach ($categories as $category) { ?>
                    <div class="col-sm-6 col-md-3">
                        <div class="thumbnail item-box">
                            <a style="font-weight: 700;font-size:20px;" href="categories.php?catid=<?php echo $category['Id']; ?>">
                                <span class="category-name"><?php echo $category['Name']; ?></span>
                            </a>
                        </div>
                    </div>

                <?php } ?>
            </div>
        </div>
    </div>




    <div class="panel panel-primary">
        <div class="panel-heading">
            <h3 class="panel-title">Items</h3>
        </div>
        <div class="panel-body">
            <div class="row">
                <?php
                $items = getAll('items', 'Item_Id');
                foreach ($items as $item) { ?>
                    <div class="col-sm-6 col-md-3">
                        <div class="thumbnail item-box">
                            <span class="price-tag"><?php echo $item['Price']; ?></span>
                            <img class="img-responsive" src="1.jpg" alt="">
                            <div class="caption">
                                <h3><?php echo '<a href="items.php?itemid=' . $item["Item_Id"] . '">' . $item['Name'] . '</a>'; ?></h3>
                                <p><?php echo $item['Description']; ?></p>
                                <p>Date: <?php echo $item['Add_Date']; ?></p>
                            </div>
                        </div>
                    </div>
                <?php } ?>
            </div>
        </div>
    </div>

</div>
<?php
include $tpl . "footer.php";
ob_end_flush();
