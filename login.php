<?php
session_start();
$pageTitle = 'Login';
if (isset($_SESSION['user'])) {
    header("Location: index.php");
}
include "init.php";


if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];
    $hashedPass = sha1($password);



    //  echo 'Welcome ' . $username . " hash pass " . $hashedPass."<br>";
    //$_SESSION['Username'] = $username; // مؤقتا حتى تشغيل ال mysql لاانه فيه مشكلة ومفيش نت لحلها

    // Admin Login
    //check user if in database or not
    // con => in config file
    // استعلام عن طريق prepare عن المستخدم 
    // select = usernme and password from db => users table => for check it
    // for admins only =>> = 1 means he is admin ;
    $stmt = $con->prepare("SELECT Username, Password FROM users WHERE Username = ? AND Password = ?");
    $stmt->execute(array($username, $hashedPass)); // search in db
    $count = $stmt->rowCount();

    if ($count > 0) {
        $_SESSION['user'] = $username;


        header("Location: index.php");
        exit();
    }
}
?>
<div class="container">
    <h2 class="text-center"><span class="signin"> Log In </span>| <span class="singup">sign Up</span></h2>
    <form class='login' action="<?php echo $_SERVER['PHP_SELF'] ?>" method="post">

        <input class="form-control" type="text" name="username" placeholder="UserName" autocomplete="off">
        <input class="form-control" type="password" name="password" placeholder="password" autocomplete="new-password">
        <input class="btn btn-primary btn-block" type="submit" value="login">

    </form>

    <form class='signup' action="<?php echo $_SERVER['PHP_SELF'] ?>" method="post">

        <input class="form-control" type="text" name="username" placeholder="UserName" autocomplete="off">

        <input class="form-control" type="email" name="email" placeholder="Email" autocomplete="off">
        <input class="form-control" type="password" name="password" placeholder="password" autocomplete="new-password">
        <input class="form-control" type="password" name="password2" placeholder="type password again" autocomplete="new-password">
        <input class="btn btn-success btn-block" type="submit" value="signup">

    </form>
</div>
<?php
include $tpl . "footer.php";
