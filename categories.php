<?php

// main index front not admins
include "init.php";

$cat_id = $_GET['catid'];
$pagename = str_replace('-', ' ', $_GET['pagename']);
$itmes = getItems($cat_id); ?>

<div class="container">
    <h1 class="text-center"><?php
                            echo $pagename;
                            ?>
    </h1>
    <?php
    foreach ($itmes as $item) { ?>
        <ul>
            <li><?php echo
                $item['Name'];
                ?></li>

        </ul>
    <?php  }
    ?>

    <?php include $tpl . "footer.php";
