<?php 
session_start();
include("functions.php");

$myuserid = $_SESSION["userid"];
$myuserirole = $_SESSION["role"];
if($myuserid == "" || $myuserirole != "customer"){
  header("Location: /index.php");
  exit;
}



$products = GetShopProducts("");

?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Products</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <link rel="stylesheet" href="./css/style.css" />
  </head>
  <body>
  <?php include("UserMenu.php"); ?>
 
  <div class="container mt-5">
    <div class="row">
        <select id="searchby" class="form-control col-md-2 w-auto" >
        <option value="4">Select...</option>
          <option value="4">Search by All</option>
          <option value="1">Search by ID</option>
          <option value="2">Search by Title</option>
          <option value="3">Search by Seller</option>
        </select>  

        <input type="text" name="Search" class="form-control col-md-3 w-auto" placeholder="Search here" id="search">
    </div>
    <div id="cards" class="row"></div>
    
  </div>

    <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
      <div class="modal-dialog">
        <div class="modal-content">
        
          <div class="modal-body">
            <p id="basketmessage"></p>
          </div>
         
        </div>
      </div>
    </div>



    <script src="https://code.jquery.com/jquery-3.7.1.min.js" integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.min.js" integrity="sha384-BBtl+eGJRgqQAUMxJ7pMwbEyER4l1g+O15P+16Ep7Q9Q+zqX6gSbd85u4mG4QzX+" crossorigin="anonymous"></script>
    <script src="./js/main.js"></script>
  </body>
</html>

<style>
  #exampleModal{
  text-align: center;
  margin-top: 200px;
}
</style>
<script>
  $(function(){

    GetProducts("");

  })
</script>