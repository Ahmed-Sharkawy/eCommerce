<?php
function gitTitle() {
    
    global $pageTitle;

    if (isset($pageTitle)) {
    
        echo $pageTitle;
    
    } else {
        echo "Default";
    }
}

/* function redirectHome مسئولة عن طياعة رسالة وتحويل إلي الصفحة الرئيسية */

function redirectHome($themsg, $url = 'index.php' ,$seconds = 3) {

    echo $themsg;
    echo "<div class='alert alert-info text-center'>You Will Be Redirected to page After $seconds seconds</div>";
    header("refresh:$seconds;url=$url");
    exit();
}

/*  
    لي الداتا بتاخد 3 براميتر SELECT خاصة ب عمل function 
    اول واحد اسم الحقل 
    التاني اسم الجدول
    التالت الشرط
*/
function checkItem($select,$from,$value){

    global $con;
    $statement = $con->prepare(" SELECT `$select` FROM `$from` WHERE `$select` = ?");
    $statement->execute([$value]);
    return $statement->rowCount();
}


function countItems($item, $table) {
    
    global $con;
    $stmt = $con->prepare("SELECT COUNT(`$item`) FROM `$table`");
    $stmt->execute();
    return $stmt->fetchColumn();
}


/*
    لي الداتا بتاخد 4 براميتر SELECT خاصة ب عمل function 
    اول واحد اسم الحقل 
    التاني اسم الجدول
    الشرط الثالث يقوم بترتيب الجدول حسب الجدول إلي ادخلة
    الشرط الرابع ارجاع عدد الصفوف
*/
function getLatest($select, $from, $order, $limit = 5) {

    global $con;
    $getStmt = $con->prepare("SELECT $select FROM $from ORDER BY $order DESC LIMIT $limit");
    $getStmt->execute();
    return $getStmt->fetchAll();
}