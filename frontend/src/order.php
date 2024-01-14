<?php 
//unset($_SESSION['Basket']);
//session_destroy();
session_start();


$myuserid = $_SESSION["userid"];
$myuserirole = $_SESSION["role"];
if($myuserid == "" || $myuserirole != "customer"){
  header("Location: index.php");
}


include("functions.php");
$basket = $_SESSION['Basket'];
$userid = $_SESSION['userid'];
$totalmoney = 0;
$status = "Pending";


if($basket){

  $resultArray = array();

  foreach($basket as $key => $basketitem){
    $productid = $basketitem["ProductID"];
    $product = GetProduct($productid);

    if($product){
        $product = $product[0];
        $totalmoney = $totalmoney + ($product["Price"] * $basketitem["Quantity"]);
        
        $title = $basketitem["Title"];
        $amount = $basketitem["Quantity"];
        $pid = $basketitem["ProductID"];

        $itemArray = array(
              "title" => $title,
              "amount" => $amount,
              "pid" => $pid
          );
       
        $resultArray[] = $itemArray;

    }
  }
  $jsonBasketItems = json_encode($resultArray, JSON_UNESCAPED_UNICODE);

  $done = PlaceOrder($jsonBasketItems, $totalmoney, $status, $userid);
  if($done == 1 || $done == "1"){
    
  $_SESSION["Basket"] = null;
  unset($_SESSION['Basket']);
  //session_destroy();

}else{
    header("Location: basket.php");
    exit();
    // redirect to basket
  }
}else{
    header("Location: basket.php");
    exit();
    // redirect to basket
}
?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>E-Commerce</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <link rel="stylesheet" href="./css/style.css" />
  </head>
  <body>
  <?php include("UserMenu.php"); ?>
 

    <div class="container mt-5" >
        <div>
          <h3>Thank you for your order!</h3>
          <p>Return to <a href="/index.php">homepage to continue shopping!</a></p>
        </div>
    </div>

</body>

</html>
