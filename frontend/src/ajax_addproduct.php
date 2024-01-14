<?php 
session_start();
include("functions.php");

$title = $_GET['title'];
$img = $_GET['imgname'];
$price = $_GET['price'];
$quantity = $_GET['quantity'];
$username = $_GET['username'];
$edit = $_GET['edit'];

$userid = $_SESSION["userid"];
$userrole = $_SESSION["role"];
if($userid == "" || $userrole != "seller"){
  exit;
}


if($edit == 0){
  $products = AddProduct($title, $img, $price, $quantity, $username);
  
  if($products == 1){
    echo "Product Added!";
  }else{
    echo "Failed to add product";
  }

}
else{
  $products = EditProduct($edit, $title, $img, $price, $quantity, $username);
  
  if($products == 1){
    echo "Product Modified!";
  }else{
    echo "Failed to modify product";
  }
}
?>
