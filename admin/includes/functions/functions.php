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


// v1.0 redirecthome 
/*
function redirectHome($errorMsg, $second = 3)
{
    echo "<div class='alert alert-danger'> $errorMsg  </div>";

    echo "<div class='alert alert-info'> You will be redirect to home page after $second seconds.</div>";
    header("refresh:$second;url=index.php");
    exit();
}
*/
// v2.0

function redirectHome($Msg, $url = null, $second = 3)
{
    if ($url === null) {
        $url = 'index.php';
        $link = 'homePage';
    } else {
        $url = isset($_SERVER['HTTP_REFERER']) && $_SERVER['HTTP_REFERER'] !== '' ? $_SERVER['HTTP_REFERER'] : 'index.php';
        $link = 'previous page';
    }
    echo $Msg;


    echo "<div class='alert alert-info'> You will be redirect to $link after $second seconds.</div>";
    header("refresh:$second;url=$url");
    exit();
}

// function check item in database before insert for example
// v 1.0 

function checkItem($select, $from, $value)
{
    global $con;
    $stmt = $con->prepare("SELECT $select FROM $from WHERE $select = ?");
    $stmt->execute(array($value));
    $count = $stmt->rowCount();

    return $count;
}
