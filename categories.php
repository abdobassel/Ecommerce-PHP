<?php

// main index front not admins
session_start();
include "init.php";

$cat_id = $_GET['catid'];
//$pagename = str_replace('-', ' ', $_GET['pagename']);
$items = getItems($cat_id); ?>

<div class="container">
    <h1 class="text-center">Show Category Items
    </h1>
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

<?php include $tpl . "footer.php";
