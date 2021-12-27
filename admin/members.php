<?php
session_start();

$pageTitle = "Members";

if (isset($_SESSION['username'])) {

    include "init.php";

    $do = isset($_GET['do']) ? $do = $_GET['do'] : $do = 'Manage';

#===============Manage===============#

    if ($do == 'Manage') { // Manage Member Page 
    
        $stmt = $con->prepare(" SELECT * FROM `users` ");
        $stmt->execute();
        $rows = $stmt->fetchAll();
    
    ?>

        <h1 class="text-center">Manage Member</h1>
        <div class="container">
            <div class="table-responsive">
                <table class="main-table table text-center table-bordered table-hover">
                    <tr>
                        <td>#ID</td>
                        <td>Username</td>
                        <td>Email</td>
                        <td>Full Name</td>
                        <td>Registerd Date</td>
                        <td>Control</td>
                    </tr>
                    <?php foreach ($rows as $row):
                    echo "<tr>
                        <td>$row[user_id]</td>
                        <td>$row[user_name]</td>
                        <td>$row[email]</td>
                        <td>$row[full_name]</td>
                        <td></td>
                        <td>
                            <a href='members.php?do=Edit&id=$row[user_id]' class='btn btn-success'>Edit <i class='fa fa-edit'></i></a>
                            <a href='members.php?do=Delete&id=$row[user_id]' class='btn btn-danger confirm'>Delete <i class='fas fa-times'></i></a>
                        </td>
                    </tr>";
                    endforeach ?>
                </table>
            </div>
            <a href="members.php?do=Add" class="btn btn-primary">Add Page <i class="fa fa-plus"></i></a>
        </div>
<?php

#===============Add===============#

    } elseif ($do == 'Add') { // Add Page ?>

        <h1 class="text-center">Add Member</h1>
        <div class="container">
            <form class="form-horizontal" action="?do=Insert" method="post">
                <!-- Start Username field -->
                <div class="form-group">
                    <label for="username" class="col-sm-2 control-label">Username</label>
                    <div class="col-sm-8">
                        <input type="text" name="username" id="username" class="form-control" required placeholder="Username">
                    </div>
                </div>
                <!-- End Username field -->
                <!-- Start password field -->
                <div class="form-group">
                    <label for="password" class="col-sm-2 control-label">password</label>
                    <div class="col-sm-8">
                        <input type="password" name="password" id="password" class="form-control" required placeholder="Password">
                    </div>
                </div>
                <!-- End password field -->
                <!-- Start Email field -->
                <div class="form-group">
                    <label for="Email" class="col-sm-2 control-label">Email</label>
                    <div class="col-sm-8">
                        <input type="email" name="Email" id="Email" class="form-control" required placeholder="Email">
                    </div>
                </div>
                <!-- End Email field -->
                <!-- Start Full field -->
                <div class="form-group">
                    <label for="Full" class="col-sm-2 control-label">Full Name</label>
                    <div class="col-sm-8">
                        <input type="text" name="Full" id="Full" class="form-control" required placeholder="Full Name">
                    </div>
                </div>
                <!-- End Full field -->
                <!-- Start submit field -->
                <div class="form-group">
                    <div class="col-sm-offset-2 col-sm-8">
                        <input type="submit" value="Add Member" class="btn btn-primary">
                    </div>
                </div><!-- End submit field -->
            </form>
        </div>
<?php 

#===============Insert===============#

    } elseif ($do == 'Insert') {    // Insert Member Page

        if ($_SERVER['REQUEST_METHOD'] == 'POST') {

            echo "<h1 class='text-center'>Insert Member</h1>";
            echo "<div class='container'>";

            $username   = $_POST['username'];
            $password   = SHA1($_POST['password']);
            $Email      = $_POST['Email'];
            $Full       = $_POST['Full'];

            // Validate The Form

            $formErrors = [];
            if (empty($_POST['username'])) {
                $formErrors[] = "Username Cant Be <strong>Empty</strong>";
            }
            if (empty($_POST['Email'])) {
                $formErrors []= "Email Cant Be <strong>Empty</strong>";
            }
            if (empty($_POST['Full'])) {
                $formErrors[] = "Full Name Cant Be <strong>Empty</strong>";
            }

            foreach ($formErrors as $Error) {
                echo "<div class='alert alert-danger'>" . $Error ."</div>";
            }

            // Check If There's No Error Proceed The Uptate Operation

            if (empty($formErrors)) {

                //  Insert The Database With Tith Info 

                $stmt = $con->prepare("INSERT INTO `users`(`user_name`,`password`,`email`,`full_name`) VALUES (:username,:password,:Email,:Full)");
                $stmt->execute([
                    'username'  => $username,
                    'password'  => $password,
                    'Email'     => $Email,
                    'Full'      => $Full
                ]);

                // Echo Success Message 

                echo "<div class='alert alert-success'>" . $stmt->rowCount() . " ' Record Insert</div>";
                header("refresh:2;url=members.php?do=Add");

            }else {
            
            echo "<div class='alert alert-success'>Sorry You Cant Browse This Page</div>";
            
            }   
        } else {
            
            $errorMsg = "Sorry You Cant Browse This Page Directly";
            redirectHome($errorMsg,5);
        
        }
        echo "</div>";
        
#===============Edit===============#

    } elseif ($do == 'Edit') {  // Edit Member Page 

        if (isset($_GET["id"]) && is_numeric($_GET["id"])) {

            $stmt = $con->prepare(" SELECT * FROM `users` WHERE  `user_id` = ? LIMIT 1 ");
            $stmt->execute([intval($_GET['id'])]);
            $row = $stmt->fetch();
            $count = $stmt->rowCount();
        }

        if ($count > 0) { ?>

            <h1 class="text-center">Edit Member</h1>
            <div class="container">
                <form class="form-horizontal" action="?do=Update" method="post">
                    <input type="hidden" name="userid" value="<?php echo $_GET['id']; ?>">
                    <!-- Start Username field -->
                    <div class="form-group">
                        <label for="username" class="col-sm-2 control-label">Username</label>
                        <div class="col-sm-8">
                            <input type="text" name="username" value="<?php echo $row['user_name']; ?>" id="username" class="form-control" >
                        </div>
                    </div>
                    <!-- End Username field -->
                    <!-- Start password field -->
                    <div class="form-group">
                        <label for="password" class="col-sm-2 control-label">password</label>
                        <div class="col-sm-8">
                            <input type="hidden" name="oldpassword" value="<?php echo $row['password']; ?>">
                            <input type="password" name="password" id="password" class="form-control">
                        </div>
                    </div>
                    <!-- End password field -->
                    <!-- Start Email field -->
                    <div class="form-group">
                        <label for="Email" class="col-sm-2 control-label">Email</label>
                        <div class="col-sm-8">
                            <input type="email" name="Email" value="<?php echo $row['email']; ?>" id="Email" class="form-control" required>
                        </div>
                    </div>
                    <!-- End Email field -->
                    <!-- Start Full field -->
                    <div class="form-group">
                        <label for="Full" class="col-sm-2 control-label">Full Name</label>
                        <div class="col-sm-8">
                            <input type="text" name="Full" value="<?php echo $row['full_name']; ?>" id="Full" class="form-control" required>
                        </div>
                    </div>
                    <!-- End Full field -->
                    <!-- Start submit field -->
                    <div class="form-group">
                        <div class="col-sm-offset-2 col-sm-8">
                            <input type="submit" value="Save" class="btn btn-primary">
                        </div>
                    </div>
                    <!-- End submit field -->
                </form>
            </div>
<?php   }

#===============Update===============#

    } elseif ($do == 'Update') {    // Update Member Page

        if ($_SERVER["REQUEST_METHOD"] == 'POST') {
            
            echo "<h1 class='text-center'>Update Member</h1>";
            echo "<div class='container'>";

            $userid     = $_POST['userid'];
            $username   = $_POST["username"];
            $Email      = $_POST['Email'];
            $Full       = $_POST["Full"];
            $pas = "";

            $pas = (empty($_POST['password'])) ? $_POST["oldpassword"] : sha1($_POST['password']) ;

            // if (empty($_POST['password'])) { $pas = $_POST['oldpassword']; } else { $pas = sha1($_POST['password']); }

            $formErrors = [];
            if (empty($_POST['username'])) {
                $formErrors[] = "Username Cant Be <strong>Empty</strong>";
            }
            if (empty($_POST['Email'])) {
                $formErrors []= "Email Cant Be <strong>Empty</strong>";
            }
            if (empty($_POST['Full'])) {
                $formErrors[] = "Full Name Cant Be <strong>Empty</strong>";
            }
            foreach ($formErrors as $Error) {
                echo "<div class='alert alert-danger'>" . $Error ."</div>";
            }

            // Check If There's No Error Proceed The Uptate Operation

            if (empty($formErrors)) {

                //  Uptate The Database With Tith Info 

                $stmt = $con->prepare("UPDATE `users` SET `user_name`= ? , `password` = ?, email = ? , full_name = ? WHERE `user_id` = ?");
                $stmt->execute([$username,$pas,$Email,$Full,$userid]);

                // Echo Success Message 

                echo "<div class='alert alert-success'>" . $stmt->rowCount() . " ' Record Update</div>";
                header("refresh:2;url=members.php?do=Edit&id=$_SESSION[ID]");

            } else {
            
            echo "<div class='alert alert-success'>Sorry You Cant Browse This Page</div>";
            
            }
        } echo "</div>";

#===============Delete===============#

    } elseif ($do == "Delete") {

        echo "<h1 class='text-center'>Delete Member</h1>";
        echo"<div class='container'>";
        if (isset($_GET["id"]) && is_numeric($_GET["id"])) {

            $stmt = $con->prepare(" SELECT * FROM `users` WHERE  `user_id` = ? LIMIT 1 ");
            $stmt->execute([intval($_GET["id"])]);
            $row = $stmt->fetch();
            $count = $stmt->rowCount();
        }

        if ($count > 0) {

            $stmt = $con->prepare(" DELETE FROM `users` WHERE  `user_id` = :ahmed ");
            $stmt->bindParam(":ahmed",intval($_GET["id"]));
            $stmt->execute();
            echo "<div class='alert alert-success'>Sorry You Cant Browse This Page</div>";

        }
        echo "</div>";
    }

    include $tbl . 'footer.php';
} else {
    header('location:index.php');
}
