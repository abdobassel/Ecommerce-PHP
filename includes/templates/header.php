<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="<?php echo $css; ?>bootstrap.min.css">
    <link rel="stylesheet" href="<?php echo $css; ?>font-awesome.min.css">
    <link rel="stylesheet" href="<?php echo $css; ?>frontend.css">



    <title><?php echo getTitle() ?></title>
</head>

<body>
    <div class="upper-bar">
        <div class="container">

            <?php
            if (isset($_SESSION['user'])) {
                echo 'Welcome ' . $userSession . ' | ';

                $status = checkUsersActivatOrNot($userSession);
                if ($status == 1) {
                    echo '<br>';
                    echo 'You Are Not Activate yet.. | ';
                }
                echo '<a href="profile.php">My Profile</a>' . ' | ';
                echo '<a href="logout.php">LogOut</a>' . ' ';
            } else { ?>
                <a href="login.php">
                    <span class="pull-right">
                        Login | Sin Up
                    </span>
                </a>
            <?php }
            ?>

        </div>
    </div>
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