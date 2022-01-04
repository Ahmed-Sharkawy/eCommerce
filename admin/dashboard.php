<?php

session_start();

if (isset($_SESSION['username'])) {
    
    $pageTitle = "Dashboard";

    include "init.php";

?>

    <div class="container home-stat text-center">
        <h1 class="text-center">Dashboard</h1>
        <div class="row">
            <div class="col-md-3">
                <a href="members.php">
                    <div class="stat st-Members">
                        Total Members
                        <span><?= countItems("user_id","users"); ?></span>
                    </div>
                </a>
            </div>
            <div class="col-md-3">
                <a href="members.php?do=Manage&page=Panding">
                    <div class="stat st-Pending">
                        Pending Members
                        <span><?= checkItem("reg_status","users",0); ?></span>
                    </div>
                </a>
            </div>
            <div class="col-md-3">
                <div class="stat st-Items">
                    Total Items
                    <span>1500</span>
                </div>
            </div>
            <div class="col-md-3">
                <div class="stat st-Comments">
                    Total Comments
                    <span>3500</span>
                </div>
            </div>
        </div>
    </div>
    
    <div class="container latest">
        <div class="row">
            <div class="col-sm-6">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <i class="fa fa-users"></i> Latest Registerd Users
                    </div>
                    <div class="panel-body">
                    <?php
                        $list =  getLatest("*", "users", "user_id", 5);
                        echo "<ul>";
                        foreach ($list as $value) {
                                echo "<li>";
                                    echo $value["user_name"];
                                    echo "<a href='members.php?do=Edit&id=$value[user_id]' class='btn btn-success pull-right'>Edit <i class='fa fa-edit'></i></a>";
                                echo "</li>";
                            }
                        echo "</ul>";
                    ?>
                    </div>
                </div>
            </div>
            <div class="col-sm-6">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <i class="fa fa-tag"></i> Latest Items
                    </div>
                    <div class="panel-body">
                    test
                    </div>
                </div>
            </div>
        </div>
    </div>

<?php
    include $tbl . 'footer.php';

} else {

    header('location:index.php');

    exit();

}