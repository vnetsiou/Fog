<?php 
session_start();
include("functions.php");

$myuserid = $_SESSION["userid"];
$myuserirole = $_SESSION["role"];

if($myuserid == "" || $myuserirole != "seller"){
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
    <div class="row" id="topbar">
      <div class="left-side  col-md-4">
        <a href="/myproducts.php">My products</a> 
      </div>
      <div class="right-side text-right col-md-4">
          <span id="topbarusername"></span> 
          <button id="logout" onclick="Logout(event)">Logout</button> 
      </div>
    </div>
    <div class="container mt-3">
      <div class="row">
        <button  id="addproduct" type="button" data-bs-toggle="modal" data-bs-target="#exampleModal">Add Product</button>
        <div id="cards"></div>
      </div>
    </div>

<!-- Modal -->
<div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Add Product</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <form id="myform" enctype="multipart/form-data">
          <input type="file" class="form-control my-2" placeholder="Image" id="image" accept="image/*" name="image"/>
          <input type="text" class="form-control my-2" placeholder="Title" id="title" name="title"/>
          <input type="text" class="form-control my-2" placeholder="Price" id="price" name="price"/>
          <input type="number" class="form-control my-2" placeholder="Quantity" id="quantity" name="quantity"/>

        </form>
      </div>
      <div class="modal-footer">
        <p class="text-error w-100 text-left" id="formerror"></p>
        <p class="text-error w-100 text-left" id="formerror2"></p>
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
        <button type="button" id="submitproduct" >Save changes</button>
      </div>
    </div>
  </div>
</div>
    
    <script src="https://code.jquery.com/jquery-3.7.1.min.js" integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.min.js" integrity="sha384-BBtl+eGJRgqQAUMxJ7pMwbEyER4l1g+O15P+16Ep7Q9Q+zqX6gSbd85u4mG4QzX+" crossorigin="anonymous"></script>
    <script src="./js/main.js"></script>
  </body>

  
</html>

<script>



  $(function(){
    var username = localStorage.getItem('username');
    var role =  localStorage.getItem('role');
    if(role == "customer")username = "";
    
    // load products in page
    GetProducts(username);

    // add product on post submit
    $("#submitproduct").click(function(){

      

      var title = $("#title").val();
      var price = $("#price").val();
      var quantity = $("#quantity").val();

      var img = "";
      var fileInput = $("#image")[0];
      if (fileInput.files.length > 0) {
        img = fileInput.files[0].name;
      }
      
      var formData = new FormData($('#myform')[0]);
      $.ajax({
          url: 'upload.php',  // Replace with your server-side script URL
          type: 'POST',
          data: formData,
          processData: false,
          contentType: false,
          success: function(response) {
            if(response == "1"){
              $("#formerror").html("Image Uploaded");
            } 
            else{

              $("#formerror").html("Error on uploading image <br>" + response);

            } 
          },
          error: function(error) {
              $("#formerror").html("Error on uploading image<br>" + response);
          }
      });

      AddProduct(title, img, price, quantity, username, 0);  

     
    });
   

  })
</script>