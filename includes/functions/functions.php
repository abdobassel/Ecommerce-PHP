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


// v1.0 check number of items or users example

function countItems($item, $table)
{
    global $con;






    $stm = $con->prepare("SELECT COUNT($item) FROM $table");
    $stm->execute();

    return $stm->fetchColumn();
}

// latest users
// gets latest users without admins 
function getLatest($select, $from, $order, $limit = 5)
{
    global $con;

    $stm = $con->prepare("SELECT $select FROM $from WHERE GroupId = 0 ORDER BY $order DESC LIMIT $limit");
    $stm->execute();

    $rows = $stm->fetchAll();
    return $rows;
}

function getLatestItems($select, $from, $order, $limit = 5)
{
    global $con;

    $stm = $con->prepare("SELECT $select FROM $from ORDER BY $order DESC LIMIT $limit");
    $stm->execute();

    $rows = $stm->fetchAll();
    return $rows;
}
function getCategories($limit = 8)
{
    global $con;

    $stm = $con->prepare("SELECT * FROM categories LIMIT $limit");
    $stm->execute();

    $rows = $stm->fetchAll();
    return $rows;
}

// get items front اعلانات وعلى حسب approve كمان النهاردة 11/3/2024
//v2.0 => $approve

function getItems($cat_id, $approve = NULL)
{
    global $con;
    $sql =  $approve == NULL ? 'AND Approve=1' : '';
    $stm = $con->prepare("SELECT * FROM items WHERE Cat_Id = ? $sql  ORDER BY Item_Id DESC");
    $stm->execute(array($cat_id));

    $rows = $stm->fetchAll();
    return $rows;
}
// check if user if acitvate or not 
function checkUsersActivatOrNot($user)
{
    global $con;
    $stmt = $con->prepare("SELECT Username ,RegStatus  FROM users WHERE Username= ? And RegStatus = 0");
    $stmt->execute(array($user));
    $status = $stmt->rowCount();

    return $status;
}
function getAll($feild, $table, $where = NULL, $order_by_field, $ordering = 'DESC')
{
    global $con;
    $getAll = $con->prepare("SELECT $feild FROM $table $where ORDER BY $order_by_field $ordering");
    $getAll->execute();

    $all = $getAll->fetchAll();
    return $all;
}
