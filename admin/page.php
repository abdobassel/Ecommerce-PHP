<?php 

$page = isset($_GET['page']) ? $_GET['page'] : "Manage";
if($page=="Manage"){
    echo "manage";
}
elseif($page == 'Update'){

        echo "<h1>update<h1/> ";
    }elseif($page == 'add'){

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
include 'init.php';