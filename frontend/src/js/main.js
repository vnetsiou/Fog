//declare url where I want to send data
const url = "http://localhost:3310/products";

async function Logout(e){
  e.preventDefault()
  try {
    var myHeaders = new Headers();
    myHeaders.append("Content-Type", "application/x-www-form-urlencoded");

    var urlencoded = new URLSearchParams();
    urlencoded.append("refresh_token", localStorage.getItem("refresh_token"));
    urlencoded.append("client_id", "frontend-app");
    urlencoded.append("client_secret", "YjQNvYXpWoPwEGQH84twDegZupqKXp1l");

    var requestOptions = {
      method: 'POST',
      headers: myHeaders,
      body: urlencoded,
      redirect: 'follow'
    };

    const response = await fetch("http://localhost:8182/auth/realms/e-shop/protocol/openid-connect/logout", requestOptions)
    if(response.ok){
       localStorage.clear()
       SetUserSessionId(0,0, "");
       setTimeout(()=>{
        window.location.href = "http://localhost:8080/login.html"
      },2000)

    }else{
      const err = await response.json()
      console.log(err) 
    }

  } catch (error) {
    console.log(error)
  }
  return false
}


function CheckLogin(){
  var user_id = localStorage.getItem("user_id");
  var userRole =  localStorage.getItem("role");
  var currentUrl = window.location.href;

  if(user_id == "" || user_id == undefined){
    window.location.href = "http://localhost:8080/login.html"
  }

  if(userRole == "customer"){
    if(currentUrl.indexOf("myproducts.php")>=0)window.location.href = "http://localhost:8080/";

  }else{


  }

  //if(userRole == )
}

function SetUserSessionId(user_id, set, role){
  $.ajax({
      type: 'GET',
      url: 'Ajax_SetSessionId.php?sid=' + user_id + "&set=" + set + "&role=" + role, 
      dataType: 'html',
      contentType: 'application/json',
      success: function(response) {
      },
      error: function(error) {
      }
  });

}



function GetProducts(username){
 
  $.ajax({
      type: 'GET',
      url: 'ajax_getproducts.php?username=' + username, 
      dataType: 'html',
      contentType: 'application/json',
      success: function(response) {
          $("#cards").html(response);
          LoadProductScripts();
      },
      error: function(error) {
          console.error('Error:', error);
      }
  });
  
}
function LoadProductScripts(){

      $(".delete-product").click(function(){
        var dataid = $(this).attr("data-id");
        if(dataid != ""){
          $.ajax({
              type: 'GET',
              url: 'ajax_deleteproduct.php?dataid=' + dataid, 
              dataType: 'html',
              contentType: 'application/json',
              success: function(response) {
                  setTimeout(()=>{location.reload();},1000)
                  
              },
              error: function(error) {
                  console.error('Error:', error);
              }
          });

        }

      });

      $(".add-to-basket").click(function(){
        var dataid = $(this).attr("data-id");
        var quan = 1;
        var remove = 0;

        if(dataid != ""){
          $.ajax({
              type: 'GET',
              url: 'Ajax_AddToBasket.php?pid=' + dataid + "&quan=" + quan + "&remove=" + remove, 
              dataType: 'html',
              contentType: 'application/json',
              success: function(response) {
                  $("#basketmessage").html(response);
                  $("#exampleModal").addClass("show");
                  $("#exampleModal").show();
                  setTimeout(()=>{
                    $("#exampleModal").hide();
                  },2000)
                  
              },
              error: function(error) {
                  console.error('Error:', error);
              }
          });

        }
      });

      $(".editproduct").click(function(){
          var productid = $(this).attr("data-id");

          var title = $("#edittitle" + productid).val(); 
          var img = $("#editimg" + productid).attr("data-img"); 
          var price = $("#editprice" + productid).val(); 
          var quantity = $("#editquantity" + productid).val(); 
          var username = $("#edituser" + productid).val(); 

          AddProduct(title, img, price, quantity, username, productid);
      })

      $("#search").on("keyup",function(){
        var searchterm = $(this).val();  
        var searchby = $("#searchby").val();
        if(searchterm!=""){
          $(".product-item").each(function(){
            var dataname = $(this).attr("data-name");
            var dataid = $(this).attr("data-id");
            var dataseller = $(this).attr("data-seller");

            var hasmatch = 0;

            if(dataid.indexOf(searchterm)>=0 && searchby == 1)hasmatch = 1;
            if(dataname.indexOf(searchterm)>=0 && searchby == 2)hasmatch = 1;
            if(dataseller.indexOf(searchterm)>=0 && searchby == 3)hasmatch = 1;
            if(searchby == 4){
              if(dataid.indexOf(searchterm)>=0)hasmatch = 1;
              if(dataname.indexOf(searchterm)>=0)hasmatch = 1;
              if(dataseller.indexOf(searchterm)>=0)hasmatch = 1; 
            }
            if(hasmatch == 1){
                $(this).show();
            }else{
              $(this).hide();
            }

          });
        }else{
          $(".product-item").each(function(){

            $(this).show();
          })
        }
        
      })
    

}

function AddProduct(title, img, price, quantity, username, edit){

  var formok = 1;
  var formerror = "";

  if(title == ""){
    formok = 0;
    formerror += "<br>You have to enter a title";
  }
  if(price <= 0){
    formok = 0;
    formerror += "<br>You have to enter a valid price";
  }
  if(quantity <= 0){
    formok = 0;
    formerror += "<br>You have to enter a valid quantity";
  }
  
  if(formok == 0){
    $("#formerror2").html(formerror);
    return;
  }
  else{
    $("#formerror2").html("");

    $.ajax({
        type: 'GET',
        url: 'ajax_addproduct.php?title='+ title +'&imgname='+ img +'&price='+ price +'&quantity='+ quantity +'&username=' + username + "&edit="+edit, 
        dataType: 'html',
        contentType: 'application/json',
        success: function(response) {
            $("#formerror2").html(response);
            setTimeout(()=>{location.reload();},2000)
        },
        error: function(error) {
            console.error('Error:', error);
        }
    });
  }



 
  
}

function AddToBasket(dataid,quan,remove){
  $.ajax({
      type: 'GET',
      url: 'Ajax_AddToBasket.php?pid=' + dataid + "&quan=" + quan + "&remove=" + remove, 
      dataType: 'html',
      contentType: 'application/json',
      success: function(response) {
        setTimeout(()=>{location.reload();},1000)
      },
      error: function(error) {
          console.error('Error:', error);
      }
  });

}

$(function(){
  CheckLogin();
  $("#topbarusername").html(localStorage.getItem("username"));


  $(".delete-item").click(function(){
    var dataid = $(this).attr("data-id");
    var quan = $(this).attr("data-quan");
    var remove = 1;

    if(dataid != ""){
      AddToBasket(dataid,quan,remove);
    }
  });     


  $(".quan-btn.plus").click(function(){
      var dataid = $(this).attr("data-id");
      var max = $(this).attr("data-max");
      var current = $(this).attr("data-quan-now");

      if(current==max){
        return;
      }

      AddToBasket(dataid,current*1+1,2);
  })

  $(".quan-btn.minus").click(function(){
    var dataid = $(this).attr("data-id");
    var min = 0;
    var current = $(this).attr("data-quan-now");

    if(current<=1){
      return;
    }

    AddToBasket(dataid,current*1-1,2);
})

})