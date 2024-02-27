<?php


?>

<nav class="navbar navbar-inverse navbar-fixed-top" role="navigation">

  <div class="container">

    <div class="navbar-header navbar-right">
      <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#app-nav">
        <span class="sr-only">Tooggle nav</span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
      </button>

      <a class="navbar-brand pop" href="#"> <?php echo lang('Brand') ?>
      </a>
    </div> <!--End container nav-->

    <div class="collapse navbar-collapse" id="app-nav">

      <ul class="nav navbar-nav navbar-left">
        <li class="nav navbar-nav">
          <a href="#"><?php echo lang('Admin_Home') ?></a>
        </li>
        <li class="nav navbar-nav">
          <a href="#"><?php echo lang('Catego') ?></a>
        </li>

        <li class="nav navbar-nav">
          <a href="#"><?php echo lang('Statis') ?></a>
        </li>
        <li class="nav navbar-nav">
          <a href="#"><?php echo lang('Members') ?></a>
        </li>


        <li class="dropdown">
          <a class="dropdown-toggle" href="#" id="navbarDropdown" role="menu" data-toggle="dropdown">
            <?php echo lang('Edit') ?><span class="caret"></span>
          </a>
          <ul class="dropdown-menu" role="menu">
            <!--
        
            -->
            <li><a href="members.php?page=Edit&userid=<?php $_SESSION['UserID'] ?>">Edit Profile</a></li>
            <li><a href="#">Settings</a></li>
            <li><a href="logout.php">Logout</a></li>
            <li class="divider"></li>

          </ul>

        </li>

      </ul>


    </div>

  </div>

</nav> <!-- endnav -->