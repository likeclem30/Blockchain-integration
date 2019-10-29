<?php
session_start();
include "../../library/config.php";
require_once("../model/dbconn.php");
require_once("../model/pos.php");

$username = $_POST['username'];
$password = $_POST['password'];
$blockpassword = md5($password);

if (empty($username) && empty($password)) {
	header('location:login.php?error=1');
	//break;
} else if (empty($username)) {
	header('location:login.php?error=2');
	//break;
} else if (empty($password)) {
	header('location:login.php?error=3');
	//break;
}

//----------------block----------------

//$request1 = "name=block_x&password=Oracle_11g";
$request = "name=".$username."&password=".$blockpassword;

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
    $var1echo = 'Curl Error: ' . $err;
}else{
    
    //print_r($result);
    //header('content-type: application/json');
    $response = json_decode($result, true);
    //$token = ($response['response']['result']['token']);
    $token = ($response['token']);
}  
// -----------token----------------

if ($token != null || $token != ""){

$hostname='localhost';
$uname='root';
$pword='';

try {
    $conn = new PDO("mysql:host=$hostname;dbname=blockchain", $uname,$pword);
    // set the PDO error mode to exception
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $sql2 = "UPDATE m_user SET b_token=?,token_update=? WHERE username=?";

    // Prepare statement
    $stmt = $conn->prepare($sql2);
    $id = 33;
    $date = date('Y-m-d H:i:s');
    // execute the query
    $stmt->execute(array($token,$date,$username));

    // echo a message to say the UPDATE succeeded
    echo $stmt->rowCount() . " records UPDATED successfully";
    }
catch(PDOException $e)
    {
    $varecho = $sql2 . "<br>" . $e->getMessage();
    }

$conn = null;

   //------------------------
  
//-------------Login----------------
$sv = new pos();
$data = $sv->getLogin($username,$password);
if ($data[2] == 1) 
{
	$_SESSION['pos_username'] = $username;
	$_SESSION['pos_id'] = $data[1]['id_user'];
	$_SESSION['pos_h_menu'] = $data[1]['h_menu'];
	$_SESSION['pos_uniqid'] = uniqid();
	$_SESSION['name_shop'] = $data[1]['name_shop'];
	$iduser = $_SESSION['pos_id'];
	$sv->deleteTempSaleByUser($iduser);

   // header('location:../main/navigation.php');
    header('location:../main/index.php');

}
else
{
	header('location:login.php?error=4');
}
//-------login----------------
}else{
    header('location:login.php?error=4');
}

?>
