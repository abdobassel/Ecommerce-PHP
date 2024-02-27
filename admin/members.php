<?php

session_start();
include 'init.php';

$pageTitle = 'Members';


  

  

    $page = isset($_GET['page']) ? $_GET['page'] : "Manage";
    if($page=="Manage"){
        echo "manage";
    }
    elseif($page == 'Edit'){ 

    //start edit page coding...?>

            
           <h1 class='text-center'>Edit Member</h1>
           <div class="container">
        <form action="" method="post" >
            <div class="form-group form-group-lg">
                <label class="col-sm2 control-label">Username</label>
                <div class="col-sm-10">
                        <input type="text" value="" class="form-control" name="username" autocomplete="off" >
            </div>
            <!-- end username -->
            <div class="form-group form-group-lg">
                <label class="col-sm2 control-label">Password</label>
                <div class="col-sm-10">
                        <input type="password" value="" class="form-control" name="password" autocomplete="new-password">
            </div>
 <!-- end pass -->
            <div class="form-group form-group-lg">
                <label class="col-sm2 control-label">Email</label>
                <div class="col-sm-10">
                        <input type="email" value="" class="form-control" name="email" >
            </div>
             <!-- end email -->

            <div class="form-group form-group-lg">
                <label class="col-sm2 control-label">Fullname</label>
                <div class="col-sm-10">
                        <input type="text" value="" class="form-control" name="full" >
            </div>
                 <!-- end fullname -->

            <div class="form-group">
                <div class="col-sm-offset-2 col-sm-10">
                        <input type="submit" value="Save" class="btn btn-primary" >
            </div>
            </div>
        </form>

           </div>


           <?php  }elseif($page == 'add'){
    
            echo "<h1>add<h1/> ";
        }
        elseif($page == 'delete'){
    
            echo "<h1>delete<h1/> ";
        }
        elseif($page == 'logout'){
    
            header('Location: logout.php');
            exit();
        }    
        else{
            echo "Error not found page";
        }
    include $tpl .'footer.php';

