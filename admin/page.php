<?php

$do = isset($_GET['do']) ? $do = $_GET['do'] : $do = 'Manage';


// echo $do;
// $do = "";
// if (isset($_GET['action'])) :

//     $do =  $_GET['action'];

// else :

//     $do = "Manage";

// endif;


if ($do == "Manage") {
    
    echo "Welcome You Manage";
    echo "<a href='page.php?action=Add'>Welcome You Manage";

} elseif ($do == "Add") {

    echo "Welcome You Add";

}
