<?php
session_start();

$noNavbar   = "";
$pageTitle  = "Login";
if (isset($_SESSION['username'])) {
    header('location:dashboard.php');
    exit();
}

include 'init.php';

// Check IF User Coming Form HTTP Post Request

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['user'];
    $pass = sha1($_POST['pass']);

    $formErrors = [];

    if ($pass < 1 || $username < 1){
        $formErrors[] = "A field cannot be left <strong>Username!</strong> blank" .
        "</br>" . "A field cannot be left <strong>Password!</strong> blank" ;
    } 

    // Check IF The User Exist In Database

    $stmt = $con->prepare(" SELECT 
                                `user_name`, `password`,`user_id` 
                            FROM 
                                `users`
                            WHERE  
                                `user_name` = ?
                            AND 
                                `password` = ?
                            AND
                                `groub_id` = 1
                            LIMIT 1");

    $stmt->execute([$username, $pass]);
    $row = $stmt->fetch();
    $count = $stmt->rowCount();

    if ($count > 0) {
        $_SESSION['username'] = $username;
        $_SESSION['ID'] = $row['user_id'];
        header('location:dashboard.php');
        exit();
    }
}
?>

<form class="login" action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
    <?php if (!empty($formErrors)) { ?>
        <div class="alert alert-warning alert-dismissible show" role="alert">
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
            <?php
            foreach ($formErrors as $Eroor) {
                echo $Eroor . "<br>";
            };
            ?>  
        </div>
    <?php } ?>
    <h2 class="text-center">Admin Login</h2>
    <input class="form-control" type="text" name="user" placeholder="username">
    <input class="form-control" type="password" name="pass" placeholder="password">
    <input class="btn btn-primary btn-block" type="submit" value="Login">
</form>


<?php
include $tbl . 'footer.php';
?>