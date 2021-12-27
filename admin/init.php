<?php
    // Routes

include "connect.php";

$tbl    = "includes/templates/";    // template Directory
$lang   = "includes/languages/";    // languages Directory
$func   = "includes/function/";     // function Directory
$css    = "layout/css/";            // CSS Directory
$js     = "layout/js/";             // Js Directory

    // INclude The Important Files

include $func   . 'function.php';
include $lang   . 'english.php';
include $tbl    . 'header.php';

// INclude Navbar On All Pages Expect On With $noNavbar vairable 

if (!isset($noNavbar)) { include $tbl . "navbar.php"; }