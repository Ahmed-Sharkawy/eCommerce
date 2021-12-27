<?php
// $servername = "localhost";
// $username = "root";
// $password = "";

// try {
//     $conn = new PDO("mysql:host=$servername;dbname=shop", $username, $password);
//     // set the PDO error mode to exception
//     $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
//     echo "Connected successfully";
// } catch (PDOException $e) {
//     echo "Connection failed: " . $e->getMessage();
// }
?>

<?php
$dsn = "mysql:host=localhost;dbname=shop";
$user = "root";
$pass = "";
$option = [
    PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8",
];

try {
    $con = new PDO($dsn, $user, $pass, $option);
    $con->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    echo 'No connectd : ' . $e->getMessage();
};
?>
