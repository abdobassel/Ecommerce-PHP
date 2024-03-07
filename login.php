<?php
ob_start();
session_start();
$pageTitle = 'Login';

if (isset($_SESSION['user']) || isset($_SESSION['Username'])) {
    header("Location: index.php");
}
include "init.php";


if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['login'])) {


        $username = $_POST['username'];
        $password = $_POST['password'];
        $hashedPass = sha1($password);




        $stmt = $con->prepare("SELECT Username, Password FROM users WHERE Username = ? AND Password = ?");
        $stmt->execute(array($username, $hashedPass)); // search in db
        $count = $stmt->rowCount();

        if ($count > 0) {
            $_SESSION['user'] = $username;


            header("Location: index.php");
            exit();
        }
    } else { //signup code
        $formErrors = array();
        $username = $_POST['username'];
        $password = $_POST['password'];
        $password2 = $_POST['password2'];
        $email = $_POST['email'];



        if (isset($_POST['username'])) {
            //$users = $_POST['username']; // without filter =>no securety
            //echo $users;
            $filterUsername = filter_var($_POST['username'], FILTER_SANITIZE_FULL_SPECIAL_CHARS); //security
            echo $filterUsername;
        } else {
            $formErrors[] = 'Username Not Exists';
        }


        if (isset($_POST['email'])) {

            $filterEmail = filter_var($_POST['email'], FILTER_SANITIZE_EMAIL); //security
            if (!filter_var($filterEmail, FILTER_VALIDATE_EMAIL)) {
                $formErrors[] = '<div class="alert alert-danger">Email Is Not Valid </div>';
            }
        } else {
            $formErrors[] = 'Username Not Exists';
        }

        if (isset($_POST['password']) && isset($_POST['password2'])) {
            if (empty($_POST['password'])) {
                $formErrors[] = '<div class="alert alert-danger">Password IS Empty Don\'t Do That </div>';
            }
            $pass1 = sha1($_POST['password']);
            $pass2 = sha1($_POST['password2']);
            if ($pass1 !== $pass2) {
                $formErrors[] = '<div class="alert alert-danger">Password Doesn\'t match </div>';
            } else {
            }
        } else {
            $formErrors[] = '<div class="alert alert-danger">Password Is Empty</div>';
        }

        if (empty($formErrors)) {
            $check = checkItem('Username', 'users', $username);
            if ($check > 0) {
                $formErrors[] = '<div class="alert alert-danger">User Is Exists Change The Username Please...</div>';
            } else {
                $stmt = $con->prepare("INSERT INTO users(Username,Password,Email, RegStatus,Date)
                VALUES(:zuser,:zpass,:zmail ,0,now())
                ");
                $stmt->execute(array('zuser' => $username, 'zpass' => sha1($password), 'zmail' => $email));
                $count = $stmt->rowCount();
                if ($count > 0) {
                    echo '<div class="alert alert-success">Success Registerd Welcome </div>' . '<br>';
                }
            }
        }
    }
}
?>
<div class="container">
    <h2 class="text-center"><span class="signin"> Log In </span>| <span class="singup">sign Up</span></h2>
    <form class='login' action="<?php echo $_SERVER['PHP_SELF'] ?>" method="post">

        <input class="form-control" type="text" name="username" placeholder="UserName" autocomplete="off">
        <input class="form-control" type="password" name="password" placeholder="password" autocomplete="new-password">
        <input class="btn btn-primary btn-block" name="login" type="submit" value="login">

    </form>

    <form class='signup' action="<?php echo $_SERVER['PHP_SELF'] ?>" method="post">

        <input class="form-control" type="text" name="username" placeholder="UserName" autocomplete="off">

        <input class="form-control" type="email" name="email" placeholder="Email" autocomplete="off">
        <input class="form-control" type="password" name="password" placeholder="password" autocomplete="new-password">
        <input class="form-control" type="password" name="password2" placeholder="type password again" autocomplete="new-password">
        <input class="btn btn-success btn-block" name="signup" type="submit" value="signup">

    </form>
    <div class="text-center the-errors">
        <?php
        if (!empty($formErrors)) {
            foreach ($formErrors as  $e) {
                echo $e . "<br>";
            }
        }
        ?>
    </div>
</div>
<?php
include $tpl . "footer.php";
ob_end_flush();
?>