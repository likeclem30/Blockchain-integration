<?php
session_start();
require_once ("../model/dbconn.php");
require_once ("../model/pos.php");
include('db.php');

if( isset( $_SERVER['HTTP_X_REQUESTED_WITH'] ) && ( $_SERVER['HTTP_X_REQUESTED_WITH'] == 'XMLHttpRequest' ) )
{
	$pos = new pos();
	$method=$_POST['method'];
	if($method == 'get_detail_loc')
	{
		$id_loc=$_POST['id_loc'];
		$pos = new pos();
		$data = $pos->getLoc($id_loc);
		$array['data'] = $data[1];
		$array['result'] = $data[0];
		echo json_encode($array);
	}
	if($method == 'save_loc')
	{
		$idloc = $_POST['id_loc'];
		$nameloc = str_replace(" ","%20",$_POST['loc_name']);
		$cood = $_POST['cood'];
		$postal= $_POST['postal'];
		$locality = str_replace(" ","%20",$_POST['locality']);
		$state = str_replace(" ","%20",$_POST['state']);
		$country = $_POST['country'];
		$crud=$_POST['crud'];
		$pos = new pos();
		if($_POST['crud'] == 'N')
		{


//--------------------Block location------

$tpos = new pos();
$block = $tpos->getblockadd($_SESSION['pos_username']);
$walletno = $block[1]['wphone'];
$wallet_address = $block[1]['b_address'];
$b_token = $block[1]['b_token'];



$curl = curl_init();

curl_setopt_array($curl, array(
  CURLOPT_URL => 'https://www.agrikore.net/location/unsafe/ad/{"'."op".'":"'.'addloc",'.'"admin'.'":"'.'0x2d2d8721fcacb58c7f5f2946bdcc487629da2d64",'.'"adminpwd'.'":"'.'agrikore",'.'"name'.'":"'.$nameloc.'",'.'"coord'.'":"'.$cood.'",'.'"country'.'":"'.$country.'",'.'"state'.'":"'.$state.'",'.'"locality'.'":"'.$locality.'",'.'"postal'.'":"'.$postal.'"}',
  CURLOPT_RETURNTRANSFER => true,
  CURLOPT_ENCODING => "",
  CURLOPT_MAXREDIRS => 50,
  CURLOPT_TIMEOUT => 1000,
  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
  CURLOPT_CUSTOMREQUEST => "POST",
  CURLOPT_HTTPHEADER => array(
    "Cache-Control: no-cache",
    "x-access-token: $b_token"
  ),
));

$response = curl_exec($curl);
//$response2 = "4";
$err = curl_error($curl);

curl_close($curl);

if ($err) {
  $oecho = "cURL Error #:" . $err;
} else {
  $oecho = $response;
  $receipt2 = str_replace('"',"",$response);
}

// sleep for 10 seconds
sleep(5);

// $receipt2 = "0x534567808560cdaed18d93025f7dbe0b002f8564a3cc6457bcdced2f63e69cad";
if($receipt2 != '' || $receipt2 != Null){ 
 
	$ctr = 1;

	while($ctr++ < 105){//while loop

 $curl = curl_init();
  curl_setopt_array($curl, array(
	
	CURLOPT_URL => 'https://www.agrikore.net/transactionreceipts/'.$receipt2.'/',
	
	CURLOPT_RETURNTRANSFER => true,
	CURLOPT_ENCODING => "",
	CURLOPT_MAXREDIRS => 10,
	CURLOPT_TIMEOUT => 3000,
	CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
	CURLOPT_CUSTOMREQUEST => "GET",
	CURLOPT_HTTPHEADER => array(
	  "Cache-Control: no-cache",
	  "x-acess-token: $b_token"
	),
  ));
  
  $response3 = curl_exec($curl);
  $err = curl_error($curl);
  
  curl_close($curl);

  if ($err) {
	echo "cURL Error #:" . $err;
  } else {
   $echo = $response3;
  }
  //$ctr++;
  if ($response3 != "Cannot find the transaction or it's receipt" || $response3 == "") {
	break;    /* You could also write 'break 1;' here. */
}
  
}//while loop off
  
 // echo "<br> Reciept query :".$response3."<br>";

  $json_o = json_decode($response3,true);

		  $result = array();
		  $out = "Status :";

		  foreach ($json_o['events'] as $theentity) {
			  $result[] = $theentity['args']['errorCode'];
			  $a = $theentity['args']['errorCode'];
			  $c = $theentity['contract'];

		  if ($a != 100){
			  //echo "Successful";
			  $out .=$c."-".$a."-Error,";
		  }else{
			  $out .=$c."-".$a."-Success,"; 
		  }

		  }
		  //echo "<br> Status query :".$out."<br>";

		  $curl = curl_init();

			curl_setopt_array($curl, array(
			  CURLOPT_URL => "https://www.agrikore.net/location/vw/{%22op%22:%22getlocindex%22,%20%22name%22:%22$nameloc%22}",
			  CURLOPT_RETURNTRANSFER => true,
			  CURLOPT_ENCODING => "",
			  CURLOPT_MAXREDIRS => 10,
			  CURLOPT_TIMEOUT => 30,
			  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
			  CURLOPT_CUSTOMREQUEST => "GET",
			  CURLOPT_HTTPHEADER => array(
				"Cache-Control: no-cache"
			  ),
			));
			
			$response = curl_exec($curl);
			$err = curl_error($curl);
			
			//curl_close($curl);
			
			if ($err) {
			  $echo = "cURL Error #:" . $err;
			} else {
			  //echo $response;
			  $loci2 = str_replace('"'," ",$response);
			}
		  //$res2 = "nill";
		  $nameloc = $_POST['loc_name'];
		$locality = $_POST['locality'];
		$state =    $_POST['state'];
			$array = $pos->saveLoc($nameloc,$cood,$postal,$locality,$state,$country,$out, $loci2);

}else{

  //echo "<br> Everything failed<br>";
  $array = false;
}





			if($array[0] == true)
			{
				
                $result['id_loc'] = $array[2];
			}
		}
		
		else
		{
			$array = $pos->updateLoc($idloc,$nameloc,$cood,$postal,$locality,$state,$country);
		}
		$result['result'] = $array[0];
		$result['error'] = $array[1];
		$result['crud'] = $_POST['crud'];
		echo json_encode($result);
	}
	
	if($method == 'getdata'){
		$pos = new pos();
		$array = $pos->getListLoc();
		$data = $array[1];
		$i=0;
		foreach ($data as $key) {
			$button = '<button  type="submit" id_loc="'.$key['id_loc'].'"  title="Tombol edit barang" class="btn btn-sm btn-primary btneditloc "  id="btneditloc'.$key['id_loc'].'"  ><i class="fa fa-edit"></i></button> <button  type="submit" id_loc="'.$key['id_loc'].'"  title="Tombol hapus barang" class="btn btn-danger btn-sm btndeleteloc "  id="btndeleteloc'.$key['id_loc'].'"  ><i class="fa fa-trash"></i></button>';

			$data[$i]['cood'] =  $data[$i]['cood'];
			//$data[$i]['fprice'] =  number_format($data[$i]['fprice']);
			$data[$i]['DT_RowId']= $data[$i]['id_loc'];
			$data[$i]['postal']= $data[$i]['postal'];
			//$data[$i]['terms']= number_format($data[$i]['terms']);
			$data[$i]['button'] = $button;
			$i++;
		}
		$datax = array('data' => $data);
		echo json_encode($datax);
	}
	if($method == 'delete_loc'){
		$id_loc=$_POST['id_loc'];
		$pos = new pos();
		$array = $pos->deleteLoc($id_loc);
		$data['result'] = $array[0];
		$data['error'] = $array[1];
		echo json_encode($data);
	}
	
} else {
	exit('No direct access allowed.');
}