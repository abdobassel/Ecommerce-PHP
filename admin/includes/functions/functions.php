<?php


// func getTilte => make $pagetitle is global variable and chech on it exist or no in pages to echo title 
function getTitle()
{
    // global pagetitle ==> to access from any where
    global $pageTitle;
    if (isset($pageTitle)) {
        echo $pageTitle;
    } else {
        echo 'Default';
    }
}



function redirectHome($errorMsg, $second = 3)
{
    echo "<div class='alert alert-danger'> $errorMsg  </div>";

    echo "<div class='alert alert-info'> You will be redirect to home page after $second seconds.</div>";
    header("refresh:$second;url=index.php");
    exit();
}
