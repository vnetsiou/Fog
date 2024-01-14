<?php 
session_start();

$sid = $_GET["sid"];
$set = $_GET["set"];
$role = $_GET["role"];

if($set == 0){
    $_SESSION['userid'] = "";
    $_SESSION['role'] = "";
}
else{
    $_SESSION['userid'] = $sid;
    $_SESSION['role'] = $role;
    echo $_SESSION['userid'];
}

?>