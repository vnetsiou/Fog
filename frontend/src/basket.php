<?php 
//unset($_SESSION['Basket']);
//session_destroy();
session_start();

include("functions.php");
$basket = $_SESSION["Basket"];
$userid = $_SESSION["userid"];


$myuserid = $_SESSION['userid'];
$myuserirole = $_SESSION['role'];
if($myuserid == "" || $myuserirole != "customer"){
  header("Location: index.php");
}



$totalmoney = 0;
?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>E-Commerce</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" integrity="sha512-DTOQO9RWCH3ppGqcWaEA1BIZOC6xxalwEsw9c2QQeAIftl+Vegovlnee1c9QX4TctnWMn13TZye+giMm8e2LwA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="./css/style.css" />
  </head>
  <body>
  <?php include("UserMenu.php"); ?>
 
  <div class="container mt-5">
    <div class="row">
      <h3>Basket</h3>
    </div>
    <div class="row">

      <div class="col-md-8">
      <div id="basketmessage"></div>

  <?php
  if($basket){


    foreach($basket as $key => $basketitem){
      //var_dump($basketitem);
      $productid = $basketitem["ProductID"];
      $product = GetProduct($productid);
      if($product){
          $product = $product[0];
          $totalmoney = $totalmoney + ($product["Price"] * $basketitem["Quantity"])

    ?>
          <div class="row mt-2 align-items-center gray-box" >
            <div class="col-md-2">
              <img style="width:100%" src="uploads/<?=$product["Img"]?>"/>
            </div>
            <div class="col-md-4">
              <?=$product["Title"]?>
            </div>
            <div class="col-md-3">
              <button class="quan-btn minus" data-quan-now="<?=$basketitem["Quantity"]?>" data-id="<?=$productid?>" data-min="0">-</button>
              <span class="quan-text"><?=$basketitem["Quantity"]?></span>
              <button class="quan-btn plus" data-quan-now="<?=$basketitem["Quantity"]?>" data-id="<?=$productid?>" data-max="<?=$product["Quantity"]?>">+</button>
            </div>
            <div class="col-md-3 text-right">
                <i class="fas fa-trash delete-item" data-quan="<?=$basketitem["Quantity"]?>" data-id="<?=$productid?>"></i>
            </div>

          </div>
    <?php
      }

  }


  ?>
      </div>
      <div class="col-md-3 gray-box">
        
      <div class="row totals">
        <span>Total</span> 
        <span><strong><?=$totalmoney?>€</strong></span> 
        
      </div>
        <a href="order.php" id="placeorder" class="btn btn-secondary w-100">Complete Order</a>
      </div>
<?php 
}else{
?>
  <p>There are no basket items yet!</p>
<?php
}
      
?>
    </div>

    </div>
    
    <script src="https://code.jquery.com/jquery-3.7.1.min.js" integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.min.js" integrity="sha384-BBtl+eGJRgqQAUMxJ7pMwbEyER4l1g+O15P+16Ep7Q9Q+zqX6gSbd85u4mG4QzX+" crossorigin="anonymous"></script>
    <script src="./js/main.js"></script>
  </body>
</html>

<script>
  $(function(){


  })
</script>