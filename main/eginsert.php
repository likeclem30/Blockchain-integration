<?php
session_start();
include "../../library/config.php";
require_once("../model/dbconn.php");
require_once("../model/pos.php");

$errorMSG = "";

// Wallet number
if (empty($_POST["wphone"])) {
    $errorMSG = "Sign-up Wallet number  is required ";
} else {
    $wphone = $_POST["wphone"];
}

// Wallet number
if (empty($_POST["fullname"])) {
    $errorMSG = "Sign-up full name  is required ";
} else {
    $fullname = $_POST["fullname"];
}

// NAME
if (empty($_POST["username"])) {
    $errorMSG = "Sign-up Email  is required ";
} else {
    $susername = $_POST["username"];
}

// EMAIL
if (empty($_POST["spassword"])) {
    $errorMSG .= "Password is required ";
} else {
    $spassword = md5($_POST["spassword"]);
}


//---------BlockChain--------------------------AES_ENCRYPT('$spassword','blockchain')



$request = "name=admin&password=agrikore";

$curl = curl_init();
curl_setopt($curl,CURLOPT_URL, 'https://www.agrikore.net/auth/login/');
curl_setopt($curl, CURLOPT_POST,true);
curl_setopt($curl,CURLOPT_HTTPHEADER, ['application/x-www-form-urlencoded']);

curl_setopt($curl, CURLOPT_POSTFIELDS, $request);
curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);

$result = curl_exec($curl);
$err = curl_error($curl);
curl_close($curl);

if($err){
   // echo 'Curl Error: ' . $err;
    $errorMSG .= "Initializing token failed.Check your Internet connect ".$err;
}else{
    
    $response = json_decode($result, true);
    //$token = ($response['response']['result']['token']);
    $token = ($response['token']);  
}
  
//----Checking token from first call---------------

if($token != null || $token != ""){

    $curl = curl_init();
    //$request1 = "name=block_xy&password=Oracle_11g";
    $request1 = "name=".$susername."&password=".$spassword;
       

    curl_setopt_array($curl, array(
      CURLOPT_URL => "https://www.agrikore.net/auth/register/",
      CURLOPT_RETURNTRANSFER => true,
      CURLOPT_ENCODING => "",
      CURLOPT_MAXREDIRS => 10,
      CURLOPT_TIMEOUT => 30,
      CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
      CURLOPT_CUSTOMREQUEST => "POST",
      CURLOPT_POSTFIELDS => $request1,
      CURLOPT_HTTPHEADER => array(
        "x-access-token: $token",
        "Content-Type: application/x-www-form-urlencoded",
        
      ),
    ));
    
    $result2 = curl_exec($curl);
    $err = curl_error($curl);
    curl_close($curl);
    
    
    if ($err) {
      //echo "cURL Error #:" . $err;
      $errorMSG .= "Initializing token failed.Check your Internet connect ".$err;
    } else {
      //echo $response;
      $response2 = json_decode($result2, true);
      $token2 = ($response2['token']);
   
    }
    

}else{
// Testing first 
$errorMSG .= "Initializing token failed.Check your Internet connect ".$err;
}

//-------Testing Registered account Token------------

if($token2 != null || $token != ""){

/** Third Call */

$curl = curl_init();

curl_setopt_array($curl, array(
  CURLOPT_URL => "https://www.agrikore.net/keystore/{%22op%22:%22createkeyadv%22,%20%22pwd%22:%22$spassword%22}",
  CURLOPT_RETURNTRANSFER => true,
  CURLOPT_ENCODING => "",
  CURLOPT_MAXREDIRS => 10,
  CURLOPT_TIMEOUT => 30,
  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
  CURLOPT_CUSTOMREQUEST => "POST",
  CURLOPT_HTTPHEADER => array(
    "Cache-Control: no-cache",
    "Postman-Token: 2c7679cb-eed1-4ce3-8255-375107270005",
    "x-access-token: $token2"
  ),
));

$response3 = curl_exec($curl);
$err = curl_error($curl);

curl_close($curl);

if ($err) {
  //echo "cURL Error #:" . $err;
  $errorMSG .= "Block Account Creation Failed.Check your Internet connection ".$err;
} else {
  
  $result3 = json_decode($response3, true);
  // -----------Publickey,Privatekey,Address----------------
  $address = ($result3['address']);
  $publicKey = ($result3['publicKey']);
  $privateKey = ($result3['privateKey']);
}

}

if($address != null || $address != ""){
    $hostname='localhost';
    $user='root';
    $pass='';
    
    try {
    $dbh = new PDO("mysql:host=$hostname;dbname=blockchain",$user,$pass);
    
    $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION); // <== add this line
    $sql = "INSERT INTO m_user(wphone,fullname,username, pass_user, h_menu,b_address,b_publickey,b_privatekey,b_token)
    VALUES ('".$_POST["wphone"]."','".$_POST["fullname"]."','".$_POST["username"]."',AES_ENCRYPT('$spassword','blockchain'),'1,2','$address','$publicKey','$privateKey','$token2')";
    if ($dbh->query($sql)) {
    //echo "New Record Inserted Successfully";
    

   header('location:../main/index.php');
}
    else{
    echo "Data not successfully Inserted.";
    header('location:login.php?error=4');
    }
    
    $dbh = null;
    } catch(PDOException $e)
    {
    echo $e->getMessage();
    }
    
   }

?>
