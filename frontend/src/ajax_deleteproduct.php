<?php 
session_start();
include("functions.php");

$pid = $_GET['dataid'];


$myuserid = $_SESSION["userid"];
$myuserirole = $_SESSION["role"];
if($myuserid == "" || $myuserirole != "seller"){
 exit;
}


$products = DeleteProduct($pid);

if($products == 1){
  echo "Product Deleted!";
}else{
  echo "Failed to delete product";
}
?>
