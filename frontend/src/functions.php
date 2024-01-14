<?php 

function GetShopProducts($sellername){
  include("dbcon.php");

  $each_row = array();
  $query = sprintf("SELECT * FROM Products");
  if($sellername != "") $query = sprintf("SELECT * FROM Products WHERE User_username='$sellername'");

  $result = mysqli_query($mysqli, $query);
  //$res = $result->toArray();
  if($result){
    foreach ($result as $row) {
          array_push($each_row, $row);

      }  
  return $each_row;
  }
  return 0;


}
function GetProduct($pid){
  include("dbcon.php");

  $each_row = array();
  $query = sprintf("SELECT * FROM Products WHERE ID=$pid");

  $result = mysqli_query($mysqli, $query);
  //$res = $result->toArray();
  if($result){
      foreach ($result as $row) {
          array_push($each_row, $row);
      }  
  return $each_row;
  }
  return 0;


}

function GetOrders($uid){
  include("dbcon_orders.php");

  $each_row = array();
  $query = sprintf("SELECT * FROM orders WHERE userid='$uid'");
  $result = mysqli_query($mysqli, $query);
  //$res = $result->toArray();
  if($result){
      foreach ($result as $row) {
          array_push($each_row, $row);
      }  
  return $each_row;
  }
  return 0;


}


function PlaceOrder($jsonBasketItems, $totalmoney, $status, $userid){

  include("dbcon_orders.php");

  $query = "INSERT INTO orders(Products,Total_price,Status, userid) VALUES ('$jsonBasketItems',$totalmoney,'$status', '$userid')";
  
  $result = mysqli_query($mysqli, $query);
  if($result){
      return 1;
  }
  
  return 0;
}

function AddProduct($mytitle, $myimg, $price, $quantity, $susername){
  include("dbcon.php");

  $query = "INSERT INTO products(Title,Img,Price,Quantity,User_username) VALUES ('$mytitle','$myimg',$price,$quantity,'$susername')";
  $result = mysqli_query($mysqli, $query);
  if($result){
      return 1;
  }
  return 0;
}


function EditProduct($pid, $mytitle, $myimg, $price, $quantity, $susername){
  include("dbcon.php");

  $query = "UPDATE products SET Price=$price, Quantity=$quantity WHERE ID=$pid";
  echo $query;
  $result = mysqli_query($mysqli, $query);
  if($result){
      return 1;
  }
  return 0;
}


function DeleteProduct($pid){
  include("dbcon.php");

  $query = "DELETE FROM products WHERE ID=$pid";
  $result = mysqli_query($mysqli, $query);
  if($result){
      return 1;
  }
  return 0;
}
?>