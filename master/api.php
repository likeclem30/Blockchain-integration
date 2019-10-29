<?php
session_start();
require_once ("../model/dbconn.php");
require_once ("../model/pos.php");
include('db.php');


if( isset( $_SERVER['HTTP_X_REQUESTED_WITH'] ) && ( $_SERVER['HTTP_X_REQUESTED_WITH'] == 'XMLHttpRequest' ) )
{ 
	if(isset($_POST['address1_id'])) {

      $address1_id = $_POST['address1_id'];
$action=$_POST['addressmul'];
//if($action=="showroom"){
    $query="SELECT IFNULL(AES_DECRYPT(pass_user,'blockchain'), 'N/A') as pass FROM m_user where b_address = '$action'";
    $show=mysqli_query($con,$query) or die ("Error");
    while($row=mysqli_fetch_array($show)){
      echo $row['pass'];
   //}
}
}
}
?>