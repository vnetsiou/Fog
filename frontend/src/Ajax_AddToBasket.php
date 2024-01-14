<?php 
session_start();
include("functions.php");
if(!isset($_SESSION["Basket"]))$_SESSION["Basket"]=array();

$myuserid = $_SESSION["userid"];
$myuserirole = $_SESSION["role"];

if($myuserid == "" || $myuserirole != "customer"){
  exit;
}



$pid = $_GET["pid"];
$quan = $_GET["quan"];
$remove = $_GET["remove"];

if($pid==0) exit;
$product = GetProduct($pid);
if($product){
    $product = $product[0];
}else{
    exit;
}


$basket = $_SESSION["Basket"];
$stock = $product["Quantity"];
$title = $product["Title"];

$matchfound = 0;
if($quan>$stock)$quan=$stock;


foreach($basket as $key => $basketitem){
    if($basketitem["ProductID"]==$pid){
        if($remove==1){
            array_splice($basket,$key,1);
            #unset($basket[$key]); 
            $_SESSION['Basket'] = $basket;
            echo "removed";
            exit;
        }
        $matchfound = 1;
        if($remove==2){
            $newquan = $quan;
        }else{

            $newquan = $basketitem["Quantity"] + $quan;
        }
        if($newquan>$stock){
            echo "Αυτή τη στιγμή υπάρχει απόθεμα $stock για αυτό το προϊόν ενώ έχετε ζητήσει $newquan. <br> Σας προσθέσαμε $stock τεμάχια";
            $newquan = $stock;
        }else{
            echo "Το προϊόν προστέθηκε στο καλάθι";
        }
        $basketitem["Quantity"] =  $newquan;
        $basket[$key] = $basketitem;
    }

}
if($matchfound==0){
    $basketitem = array(
        "ProductID"=> $pid, 
        "Quantity" => $quan,
        "Title" => $title
    );
    array_push($basket, $basketitem);

    echo "Το προϊόν προστέθηκε στο καλάθι";
}

$_SESSION["Basket"] = $basket;
?>