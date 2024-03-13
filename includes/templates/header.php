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
            <ul class="nav navbar-nav navbar-right">
                <?php if (isset($_SESSION['user'])) : ?>
                    <?php
                    $status = checkUsersActivatOrNot($userSession);
                    if ($status == 1) {
                        echo '<li><span>You Are Not Activated Yet.. | </span></li>';
                    }
                    ?>
                    <li class="dropdown">
                        <a style="color: #7a8793;font-size:20px;" href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">
                            <?php echo $userSession; ?> <span class="caret"></span>
                        </a>
                        <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                            <li><a href="profile.php">My Profile</a></li>
                            <li><a href="logout.php">Logout</a></li>
                            <li><a href="profile.php#my-ads">My Ads</a></li>
                            <li><a href="newad.php">New Ad</a></li>
                        </ul>
                    </li>
                    <li><a href="index.php#all-categories">All Categories</a></li>
                <?php else : ?>
                    <li><a href="login.php"><span class="pull-right">Login | Sign Up</span></a></li>
                <?php endif; ?>
            </ul>
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
                        <li><a href="categories.php?catid=<?php echo $cat['Id']; ?>">
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