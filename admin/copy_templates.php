<?php

session_start();

$pageTitle = "";

if (isset($_SESSION['username'])) {     /* index.php هذا الجرء الخاص ب تسجيل السيشن ان كانت موجودة كمل غيل كة حولني علي  */

    include "init.php";

                        // خاصة ب الريكوست الي عن طريقة هحدد هروح انهي صفحة if
    $do = isset($_GET['aa']) ? $do = $_GET['aa'] : $do = 'Manage';

    if ($do == 'Manage') {

        echo "Welcomr ";

    } elseif ($do == 'Add') {

        echo "Welcomr";

    } elseif ($do == 'Insert') {


    } elseif ($do == "Edit") {


    } elseif ($do == "Update") {


    } elseif ($do == "Delete") {


    } elseif ($do == "Activate" ) {


    } 

    include $tbl . 'footer.php';

} else {
    header('location:index.php');
    exit();
}