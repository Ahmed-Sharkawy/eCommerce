<?php

function gitTitle() {
    
    global $pageTitle;

    if (isset($pageTitle)) {
    
        echo $pageTitle;
    
    } else {
        echo "Default";
    }
}


function redirectHome($erroe,$seconds = 3) {

    echo "<div class='alert alert-danger text-center'>$erroe</div>";
    echo "<div class='alert alert-info text-center'>You Will Be Redirected to Homepage After $seconds seconds</div>";
    header("refresh:$seconds;url=index.php");
    exit();
}