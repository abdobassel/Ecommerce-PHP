<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="<?php echo $css; ?>bootstrap.min.css">
    <link rel="stylesheet" href="<?php echo $css; ?>font-awesome.min.css">
    <link rel="stylesheet" href="<?php echo $css; ?>backend.css">



    <title><?php echo getTitle() ?></title>
</head>

<body>
    <div class="upper-bar navbar-fixed-top">Upper bar</div>
    <nav class="navbar navbar-inverse" role="navigation">
        <div class="container">
            <div class="navbar-header navbar-right">
                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#app-nav">
                    <span class="sr-only">Toggle nav</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <a class="navbar-brand pop" href="index.php"><?php echo lang('Brand') ?></a>
            </div>

            <!--End navbar-header-->
            <div class="collapse navbar-collapse" id="app-nav">
                <ul class="nav navbar-nav navbar-left">
                    <li><a href="index.php">Home</a></li>
                    <?php foreach (getCategories() as $cat) : ?>
                        <li><a href="categories.php?catid=<?php echo $cat['Id']; ?>&pagename=<?php echo str_replace(' ', '-', $cat['Name']);
                                                                                                ?>">
                                <?php echo $cat['Name']; ?></a></li>
                    <?php endforeach; ?>
                </ul>
            </div>
        </div>
        <!--End navbar-collapse-->


        <!--End container-->
    </nav>
    <!-- endnav -->
</body>

</html>