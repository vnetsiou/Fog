<?php 
session_start();

$myuserid = $_SESSION["userid"];
$myuserirole = $_SESSION["role"];

if($myuserirole == "seller")header("Location: myproducts.php");
if($myuserirole == "customer")header("Location: products.php");



?>
