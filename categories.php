<?php

// main index front not admins
include "init.php";

$cat_id = $_GET['catid'];
$pagename = str_replace('-', ' ', $_GET['pagename']);
$items = getItems($cat_id); ?>

<div class="container">
    <h1 class="text-center"><?php
                            echo $pagename;
                            ?>
    </h1>
    <div class="row">
        <?php
        if (empty($items)) {
            echo '<div class="alert alert-danger"><h3 class=" text-center">There is No items yet...</h3> </div>' . '<br>';
        } else {
            foreach ($items as $item) { ?>
                <div class="col-sm-6 col-md-3">
                    <div class="thumbnail">
                        <img class="img-responsive" src="1.jpg" alt="">
                        <div class="caption">
                            <h3><?php echo
                                $item['Name'];
                                ?></h3>
                            <p><?php
                                echo  $item['Description'];
                                ?></p>
                            <h4><?php
                                echo  $item['Price'];
                                ?></h4>
                        </div>
                    </div>

                </div>



        <?php  }
        }

        ?>
    </div>
</div>

<?php include $tpl . "footer.php";
