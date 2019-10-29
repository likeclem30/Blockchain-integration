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



$response = null;
system("ping -c 1 google.com", $response);
if($response == 0)
{
    

    
$request = "name=block_x&password=Oracle_11g";


$curl = curl_init();

curl_setopt_array($curl, array(
  CURLOPT_URL => "https://www.agrikore.net/auth/login/",
  CURLOPT_RETURNTRANSFER => true,
  CURLOPT_ENCODING => "",
  CURLOPT_MAXREDIRS => 10,
  CURLOPT_TIMEOUT => 30,
  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
  CURLOPT_CUSTOMREQUEST => "POST",
  CURLOPT_POSTFIELDS => $request,
  
));

$responsel = curl_exec($curl);
$err = curl_error($curl);

//curl_close($curl);

if ($err) {
  echo "cURL Error #:" . $err;
} else {
  echo $responsel."<br>";
  $responsex = json_decode($responsel, true);
  //$token = ($response['response']['result']['token']);
  $token = ($responsex['token']); 
}


//$curl = curl_init();

curl_setopt_array($curl, array(
  CURLOPT_URL => "https://www.agrikore.net/auth/register",
  CURLOPT_RETURNTRANSFER => true,
  CURLOPT_ENCODING => "",
  CURLOPT_MAXREDIRS => 10,
  CURLOPT_TIMEOUT => 30,
  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
  CURLOPT_CUSTOMREQUEST => "POST",
  CURLOPT_POSTFIELDS => "name=$susername&password=$spassword",
  CURLOPT_HTTPHEADER => array(
    "x-access-token: $token"
  ),
));

$responser = curl_exec($curl);
$err = curl_error($curl);

curl_close($curl);

if ($err) {
  echo "cURL Error #:" . $err;
} else {
  echo "<br> Register token :".$responser;
}



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
    "x-access-token: $token"
  ),
));

$responsec = curl_exec($curl);
$err = curl_error($curl);

curl_close($curl);

if ($err) {
  echo "cURL Error #:" . $err;
} else {
  echo $responsec;

  $result3 = json_decode($responsec, true);
  // -----------Publickey,Privatekey,Address----------------
  $address = ($result3['address']);
  $publicKey = ($result3['publicKey']);
  $privateKey = ($result3['privateKey']);
}

}else{
    echo "<br> no connection";  
}

if($address != null || $address != ""){
    $hostname='localhost';
    $user='root';
    $pass='';
    
    try {
    $dbh = new PDO("mysql:host=$hostname;dbname=blockchain",$user,$pass);
    
    $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION); // <== add this line
    $sql = "INSERT INTO m_user(wphone,fullname,username, pass_user, h_menu,b_address,b_publickey,b_privatekey,b_token)
    VALUES ('".$_POST["wphone"]."','".$_POST["fullname"]."','".$_POST["username"]."',AES_ENCRYPT('$spassword','blockchain'),'1,2','$address','$publicKey','$privateKey','$token')";
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
