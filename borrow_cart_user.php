<?php
include_once 'config/database.php';
include_once 'objects/borrow_cart.php';
// get database connection
$database = new Database();
$db = $database->getConnection();

// pass connection to objects
$borrow_cart = new Borrow_cart($db);
$page_title = "Borrow Book";
ob_start();
include_once "layout_header.php";
if(isset($_GET['session']))
{
    $_SESSION['user_id']="";
    header("Location:search.php");
 }
if(isset($_GET['usertype'])){
  $usertype=$_GET['usertype'];
  $user_id=$_GET['user_id'];
  $_SESSION['usertype']=$usertype;
  $_SESSION['user_id']=$user_id;
  header("Location:search.php");
 }
if(isset($_GET['acc_no']))
 {
    if($_SESSION['user_id']=="")
    {
        echo "<div class='alert alert-danger'>You Cant Borrow without User_ID.</div>";
    }
    else {
        
     $usertype=$_SESSION['usertype'];
     $user_id=$_SESSION['user_id'];
     $acc_no=$_GET['acc_no'];
     echo "<form action=\" \" method=\"post\">";
     echo "<table class='table table-hover table-responsive table-bordered'>";
     echo "<tr>";
     echo "<td>User_ID:</td>";
     echo "<td><input type='text' name='user_id' value=\"".$user_id."\" class='form-control' readonly/></td>";
     echo "</tr>";
     echo "<tr>";
     echo "<td>User Type:</td>";
     echo "<td><input type='text' name='usertype_id' value=\"".$usertype."\" class='form-control' readonly/></td>";
     echo "</tr>";
     echo "<tr>";
     echo "<td>Acc No:</td>";
     echo "<td><input type='text' name='acc_no' value=\"".$acc_no."\" class='form-control' readonly/></td>";
     echo "</tr>";
     echo "<tr>";
     echo "<td>Borrow Date</td>";
     echo "<td><input type='date' name='borrow_date' class='form-control' /></td>";
     echo "</tr>";
     echo "<tr>";
     echo "<td>Remark</td>";
     echo "<td><input type='text' name='remark' class='form-control'></td>";
     echo "</tr>";
     echo "<tr>";
     echo "<td></td>";
     echo "<td>";
     echo "<button type=\"submit\" class=\"btn btn-primary\">ထည့်သွင်းမည်</button>";
     echo "</td>";
     echo "</tr>";
     echo "</table>";
     echo "</form>";

    }
 }
 if($_POST){
     
     // set product property values
     $borrow_cart->user_id = $_POST['user_id'];
     $borrow_cart->user_type = $_POST['usertype_id'];
     $borrow_cart->book_acc_no = $_POST['acc_no'];
     $borrow_cart->borrow_date = $_POST['borrow_date'];
     $borrow_cart->remark = $_POST['remark'];
     // create the product
     if($borrow_cart->borrow()){
         if($borrow_cart->update_book_data())
         {
            echo "<div class='alert alert-success'>Successfully added. <a href=\"search.php\">Borrow Next Book </a> | <a href=\"borrow_cart_user.php?session=destroy\"> Finished </a></div>";
         }
         else {
             echo "<div class='alert alert-danger'>Unable to Update Book Data.</div>";
         }
     }
     
     // if unable to create the product, tell the user
     else{
         echo "<div class='alert alert-danger'>Unable to create product.</div>";
     }
 }
// footer
include_once "layout_footer.php";
?>