<?php
session_start();

$pageTitle = "Members";

if (isset($_SESSION['username'])) {     /* index.php هذا الجرء الخاص ب تسجيل السيشن ان كانت موجودة كمل غيل كة حولني علي  */
    
    include "init.php";

                        // خاصة ب الريكوست الي عن طريقة هحدد هروح انهي صفحة if
    $do = isset($_GET['do']) ? $do = $_GET['do'] : $do = 'Manage';

/* وهيا الصفحة إلي بيتعرض فيها كل اليوزر Manage من هنا بداية الشغل واول صفحة وهيا */

    if ($do == 'Manage') { // Manage Member Page
    
        $page = "";
        if (isset($_GET["page"]) && $_GET["page"] == "Panding") {
            $page = "AND reg_status = 0 ";
        }

                            // الجزء الخاص ب استدعاء جميع اليوزر 
        $stmt = $con->prepare(" SELECT * FROM `users` WHERE `groub_id` != 1 $page");
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
    <?php   foreach ($rows as $row): /* هنا الجزء الخاص ب عرض الداتا عن طريق اللوب */
                echo "<tr>
                        <td>$row[user_id]</td>
                        <td>$row[user_name]</td>
                        <td>$row[email]</td>
                        <td>$row[full_name]</td>
                        <td>$row[Date]</td>
                        <td>
                            <a href='members.php?do=Edit&id=$row[user_id]' class='btn btn-success'>Edit <i class='fa fa-edit'></i></a>
                            <a href='members.php?do=Delete&id=$row[user_id]' class='btn btn-danger confirm'>Delete <i class='fas fa-times'></i></a>";
                            if ($row["reg_status"] == 0) {
                            echo "<a href='members.php?do=Activate&id=$row[user_id]' class='btn btn-info'>Activate <i class='fas fa-check-circle'></i></a>";
                            }
                        echo "</td>
                    </tr>";
            endforeach ?>
                </table>
            </div>
            <a href="members.php?do=Add" class="btn btn-primary">Add Page <i class="fa fa-plus"></i></a>
        </div>
<?php

/*  HTML Add هنا بقي الجزء الخاص بصفحة اضافة اعضاء جدد كود  */

    } elseif ($do == 'Add') { ?>

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
/* php Insert هنا بقي الجزء الخاص بصفحة اضافة اعضاء جدد */

    } elseif ($do == 'Insert') {

        echo "<h1 class='text-center'>Insert Member</h1>";
        echo "<div class='container'>";

        if ($_SERVER['REQUEST_METHOD'] == 'POST') {


            $username   = $_POST['username'];
            $password   = SHA1($_POST['password']);
            $Email      = $_POST['Email'];
            $Full       = $_POST['Full'];

            // هنا اقوم با التحقق من ان كل الحقول ليست فارغة

            $formErrors = [];
            if (empty($_POST['username'])) {
                $formErrors[] = "Username Cant Be <strong>Empty</strong>";
            } elseif (empty($_POST['Email'])) {
                $formErrors []= "Email Cant Be <strong>Empty</strong>";
            } elseif(empty($_POST['Full'])) {
                $formErrors[] = "Full Name Cant Be <strong>Empty</strong>" ;
            }

            foreach ($formErrors as $Error) {
                echo "<div class='alert alert-danger'>" . $Error ."</div>";
            }

                    // هنا يتم التحقق من ان مستودع الايرور فاضي لو فاضب هيكمل لو في ايرور هيطلع الايرور
            if (empty($formErrors)) {

                $check = checkItem("email","users",$Email);
                
                if ($check == 1) {
                
                    $theMsg = "<div class='alert alert-info text-center'>Sorry You Email Exist</div>";
                    redirectHome($theMsg ,"members.php");
                
                } else {
                                //  استكمال ادخال البيانات
                    $stmt = $con->prepare("INSERT INTO `users` (`user_name`, `password`, `email`, `full_name`, `reg_status` ,`Date`) 
                                                        VALUES (:username, :password, :Email, :Full, 1, now())");
                    
                    $stmt->execute([
                        'username'  => $username,
                        'password'  => $password,
                        'Email'     => $Email,
                        'Full'      => $Full
                    ]);

                                // Add طباعة رسالة نجاح وتحويل علي صفحة
                    $theMsg = "<div class='alert alert-success text-center'>" . $stmt->rowCount() . " ' Record Insert</div>";
                    redirectHome($theMsg ,"members.php");

                }
            }
            
        } else {
                $theMsg = "<div class='alert alert-danger text-center'>Sorry You Cant Browse This Page Directly</div>";
                redirectHome($theMsg , $_SERVER["HTTP_REFERER"]);
        }
    echo '</div>';

/* HTML Edit هنا بقي الجزء الخاص بصفحة تعديل الاعضاء */

    } elseif ($do == "Edit") {

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
<?php   } else {
            echo "<div class='container'>";
                $theMsg = "<div class='alert alert-danger text-center'>Theres No Such ID</div>";
                redirectHome($theMsg);
            echo "</div>";
        }

/* php Update هنا بقي الجزء الخاص بصفحة تعديل الاعضاء */

    } elseif ($do == "Update") {    

        echo "<h1 class='text-center'>Update Member</h1>";
        echo "<div class='container'>";

        if ($_SERVER["REQUEST_METHOD"] == 'POST') {
            
            $userid     = $_POST["userid"];
            $username   = $_POST["username"];
            $Email      = $_POST["Email"];
            $Full       = $_POST["Full"];
            $pas = "";

            $pas = (empty($_POST["password"])) ? $_POST["oldpassword"] : sha1($_POST["password"]) ;

            // if (empty($_POST["password"])) { $pas = $_POST["oldpassword"]; } else { $pas = sha1($_POST["password"]); }

            $formErrors = [];
            if (empty($_POST["username"])) {
                $formErrors[] = "Username Cant Be <strong>Empty</strong>";
            }
            if (empty($_POST["Email"])) {
                $formErrors []= "Email Cant Be <strong>Empty</strong>";
            }
            if (empty($_POST["Full"])) {
                $formErrors[] = "Full Name Cant Be <strong>Empty</strong>";
            }
            foreach ($formErrors as $Error) {
                echo "<div class='alert alert-danger'>" . $Error ."</div>";
            }

                    // هنا يتم التحقق من ان مستودع الايرور فاضي لو فاضب هيكمل لو في ايرور هيطلع الايرور
            if (empty($formErrors)) {

                                //  هنا اقوم بتحديث البيانات 
                $stmt = $con->prepare("UPDATE `users` SET `user_name`= ? , `password` = ?, `email` = ? , `full_name` = ? , `Date` = now() WHERE `user_id` = ?");
                $stmt->execute([$username,$pas,$Email,$Full,$userid]);

                                // Update طباعة رسالة نجاح وتحويل علي صفحة
                $theMsg = "<div class='alert alert-success text-center'>" . $stmt->rowCount() . " ' Record Update</div>";
                redirectHome($theMsg , $_SERVER['HTTP_REFERER']);
            }

        } else {
            
                $theMsg = "<div class='alert alert-danger text-center'>Sorry You Cant Browse This Page Directly</div>";
                redirectHome($theMsg);
            
            }
    echo "</div>";

/* Delete هنا بقي الجزء الخاص بصفحة حذف الاعضاء */

    } elseif ($do == "Delete") {

        echo "<h1 class='text-center'>Delete Member</h1>";
        echo"<div class='container'>";

    /*                    // الجزء دة خاص ب استدعاء الرو إلي عاوز يتحذف
        if ( isset($_GET["id"]) && is_numeric($_GET["id"])) {
            $stmt = $con->prepare(" SELECT * FROM `users` WHERE  `user_id` = ? LIMIT 1 ");
            $stmt->execute([intval($_GET["id"])]);
            $count = $stmt->rowCount();
        }
                                الجزء دة خاص ب استدعاء الرو إلي عاوز يتحذف
        $stmt = $con->prepare(" SELECT * FROM `users` WHERE  `user_id` = ? LIMIT 1 ");
        $stmt->execute([$id]);
        $count = $stmt->rowCount();
        $id = isset($_GET["id"]) && is_numeric($_GET["id"]) ? intval($_GET["id"]) : 0 ;
    */
        $id = isset($_GET["id"]) && is_numeric($_GET["id"]) ? intval($_GET["id"]) : 0 ;

        $count = checkItem("user_id","users",$id);
                                // التحقق ما إذا الرو موجود ولا لا لو موجود هينسحة
        if ($count > 0) {

            $stmt = $con->prepare(" DELETE FROM `users` WHERE  `user_id` = :ahmed ");
            $stmt->bindParam(":ahmed",$id);
            $stmt->execute();

                $theMsg = "<div class='alert alert-success text-center'>" . $stmt->rowCount() . " ' Record Insert</div>";
                redirectHome($theMsg,"members.php");
        } else {
            $theMsg = "<div class='alert alert-danger text-center'>Sorry You Cant Browse This Page</div>";
            redirectHome($theMsg);
        }
        echo "</div>";
    } elseif ($do == "Activate" ) {

        echo "<h1 class='text-center'>Activate Member</h1>";
        echo"<div class='container'>";
    
        $id = isset($_GET["id"]) && is_numeric($_GET["id"]) ? intval($_GET["id"]) : 0 ;

        $count = checkItem("user_id","users",$id);
                                // التحقق ما إذا الرو موجود ولا لا لو موجود هينسحة
        if ($count > 0) {

            $stmt = $con->prepare(" UPDATE `users` SET `reg_status` = 1 WHERE`user_id` = ? ");
            $stmt->execute([$id]);

                $theMsg = "<div class='alert alert-success text-center'>" . $stmt->rowCount() . " ' Record Insert</div>";
                redirectHome($theMsg,"members.php");

        } else {
            $theMsg = "<div class='alert alert-danger text-center'>Sorry You Cant Browse This Page</div>";
            redirectHome($theMsg);
        }
        echo "</div>";

    }

    include $tbl . 'footer.php';
} else {

    header('location:index.php');
    exit();

}
