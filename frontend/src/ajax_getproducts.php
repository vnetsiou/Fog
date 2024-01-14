<?php 
session_start();
include("functions.php");


$myuserid = $_SESSION["userid"];
if($myuserid == ""){
 exit;
}

$username = $_GET['username'];
$products = GetShopProducts($username);
if($products){
  foreach($products as $product){
   // echo $product["ID"];
?>
    <div class='col-6 col-md-3 gray-box product-item' data-name="<?=$product["Title"]?>" data-id="<?=$product["ID"]?>" data-seller="<?=$product["User_username"]?>">
        <img class="card-img-top" style="width:100%;" src="/uploads/<?=$product["Img"]?>"/>
        <div class="text-center mt-4">

          <h5 class="card-title"><?=$product["Title"]?></h5>
          <p class="product-price"><?=$product["Price"]?>€</p>

<?php 
          if($username != ""){
?>
          <p class="card-text">Quantity: <?=$product["Quantity"]?></p>

            <button class="btn btn-success"  type="button" data-bs-toggle="modal" data-bs-target="#modal<?=$product["ID"]?>">Edit</button>
            <button class="btn btn-danger delete-product" data-id="<?=$product["ID"]?>">Delete</button>
<?php

          }else{
?>
            <button class="blue-button add-to-basket" data-id="<?=$product["ID"]?>">Add to basket</button>
            <p id="basketmessage<?=$product["ID"]?>"></p>
<?php      
          }
?>
        </div>
    </div> 
    <?php 
          if($username != ""){
?>
           <div class="modal fade" id="modal<?=$product["ID"]?>" tabindex="-1" aria-labelledby="exampleModalLabel<?=$product["ID"]?>" aria-hidden="true">
                <div class="modal-dialog">
                  <div class="modal-content">
                    <div class="modal-header">
                      <h5 class="modal-title" id="exampleModalLabel<?=$product["ID"]?>">Edit Product</h5>
                      <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                      <form id="myform2" enctype="multipart/form-data">
                        <img style="width:50%;" id="editimg<?=$product["ID"]?>" data-img="<?=$product["Img"]?>" src="uploads/<?=$product["Img"]?>"/>
                        <input type="text" class="form-control my-2" disabled id="edittitle<?=$product["ID"]?>"  name="title" value="<?=$product["Title"]?>"/>
                        <input type="text" class="form-control my-2" placeholder="Price" id="editprice<?=$product["ID"]?>" name="price" value="<?=$product["Price"]?>"/>
                        <input type="number" class="form-control my-2" placeholder="Quantity" id="editquantity<?=$product["ID"]?>"  name="quantity" value="<?=$product["Quantity"]?>"/>

                      </form>
                    </div>
                    <div class="modal-footer">
                     
                      <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                      <button type="button" class="editproduct"  data-id="<?=$product["ID"]?>">Save changes</button>
                    </div>
                  </div>
                </div>
              </div>
<?php
          }
?> 
<?php
  }
}
?>
