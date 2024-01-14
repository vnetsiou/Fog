<?php 

session_start();


include("functions.php");
$userid = $_SESSION["userid"];
$orders = GetOrders($userid);


$myuserid = $_SESSION['userid'];
$myuserirole = $_SESSION['role'];
if($myuserid == "" || $myuserirole != "customer"){
  header("Location: index.php");
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
      <h3>Orders</h3>
    </div>
    <div class="accordion" id="orders">
  <?php 
  if($orders){
    foreach($orders as $order){
      $resultArray = json_decode($order["Products"], true);
?>
      
        <div class="accordion-item">
          <h2 class="accordion-header" id="heading<?=$order["ID"]?>">
            <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapseOne<?=$order["ID"]?>" aria-expanded="true" aria-controls="collapseOne">
              Order #<?=$order["ID"]?>
            </button>
          </h2>
          <div id="collapseOne<?=$order["ID"]?>" class="accordion-collapse collapse " aria-labelledby="headingOne" data-bs-parent="#accordionExample<?=$order["ID"]?>">
            <div class="accordion-body">
                  <div class="row align-items-center text-center  justify-content-between">
                    <div class="col-md-1">
                    </div>
                    <div class="col-md-4">
                      <strong>Title</strong>
                    </div>
                    <div class="col-md-2">
                      <strong>Quantity</strong>
                    </div>
                    <div class="col-md-2">
                      <strong>Price</strong>
                    </div>
                  </div>
              <?php 
              if($resultArray){
                foreach($resultArray as $pitem){
                  $prid = $pitem["pid"];
                  $products = GetProduct($prid);
                  if($products){

                    $product = $products[0];
                    ?>
                      <div class="row align-items-center text-center justify-content-between">
                        <div class="col-md-1">
                          <img style="width:100%" src="uploads/<?=$product["Img"]?>"/>
                        </div>
                        <div class="col-md-4">
                          <?=$pitem["title"]?>
                        </div>
                        <div class="col-md-2">
                          <?=$pitem["amount"]?>
                        </div>
                        <div class="col-md-2">
                         <?=$product["Price"]?>€
                        </div>
                      </div>
                    <?php 
                  }else{
                    ?>
                    <div class="row align-items-center text-center justify-content-between">
                        <div class="col-md-1">
                        ID: #<?=$pitem["pid"]?>
                        </div>
                        <div class="col-md-4">
                          <?=$pitem["title"]?>
                        </div>
                        <div class="col-md-2">
                          <?=$pitem["amount"]?>
                        </div>
                        <div class="col-md-2">
                          no longer available!

                        </div>
                      </div>
                      
                    <?php
                  }

                }
              }
              ?>

                <div class="row align-items-center text-center gray-box justify-content-between">
                    <div class="col-md-2">
                      Total Price
                    </div>
                    <div class="col-md-2">
                      <strong><?=$order["Total_price"]?>€</strong>
                    </div>
                    
                  </div>
                  <div class="row align-items-center text-center gray-box justify-content-between">
               
                    <div class="col-md-2">
                      Status
                    </div>
                    <div class="col-md-2">
                      <strong><?=$order["Status"]?></strong>
                    </div>
                  </div>

            </div>
          </div>
        </div>
<?php 
    }
  }else{
    ?>
    <p>There are no orders yet</p>
    <?php
  }
  
  ?>

    </div>
    
    <script src="https://code.jquery.com/jquery-3.7.1.min.js" integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.min.js" integrity="sha384-BBtl+eGJRgqQAUMxJ7pMwbEyER4l1g+O15P+16Ep7Q9Q+zqX6gSbd85u4mG4QzX+" crossorigin="anonymous"></script>
    <script src="./js/main.js"></script>
  </body>
</html>

<script>

</script>