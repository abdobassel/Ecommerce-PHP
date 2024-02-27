<?php

session_start();

print_r($_SESSION);

$noNavbar = '';
$pageTitle = 'Login';
if (isset($_SESSION['Username'])) {
    header("Location: dashboard.php");
}
include "init.php";

//print_r($_SESSION);



// include $tpl ."header.php"; 
//include 'includes/languages/english.php';
//include 'includes/languages/arabic.php';


if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['user'];
    $password = $_POST['pass'];
    $hashedPass = sha1($password);



    //  echo 'Welcome ' . $username . " hash pass " . $hashedPass."<br>";
    //$_SESSION['Username'] = $username; // مؤقتا حتى تشغيل ال mysql لاانه فيه مشكلة ومفيش نت لحلها

    // Admin Login
    //check user if in database or not
    // con => in config file
    // استعلام عن طريق prepare عن المستخدم 
    // select = usernme and password from db => users table => for check it
    // for admins only =>> = 1 means he is admin ;
    $stmt = $con->prepare("SELECT UserID , Username, Password FROM users WHERE Username = ? AND Password = ?  AND GroupId = 1 LIMIT 1");
    $stmt->execute(array($username, $hashedPass)); // search in db
    $count = $stmt->rowCount();
    // number of records in db // if > 0 means user in exists in database
    $row = $stmt->fetch(); // result => array("username","password",etc...);
    print($count);
    if ($count > 0) {
        $_SESSION['Username'] = $username;
        $_SESSION['UserID'] = $row['UserID'];


        header("Location: dashboard.php");
        exit();
    }
}

?>

<form class='login' action="<?php echo $_SERVER['PHP_SELF'] ?>" method="post">
    <h2> Admin Log In</h2>
    <input class="form-control" type="text" name="user" placeholder="UserName" autocomplete="off">
    <input class="form-control" type="password" name="pass" placeholder="password" autocomplete="new-password">
    <input class="btn btn-primary btn-block" type="submit" value="login">

</form>


<?php include $tpl . "footer.php"; ?>