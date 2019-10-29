<?php
session_start();
require_once ("../model/dbconn.php");
require_once ("../model/pos.php");
include('db.php');
if( isset( $_SERVER['HTTP_X_REQUESTED_WITH'] ) && ( $_SERVER['HTTP_X_REQUESTED_WITH'] == 'XMLHttpRequest' ) )
{

	if (isset($_POST['wphonefar_id'])) {

		$xphonefar_id = $_POST['wphonefar_id'];
	
		$qry = "select b_address as b_addressfar from m_user where wphone= $xphonefar_id";
		$res = mysqli_query($con, $qry);
		if(mysqli_num_rows($res) > 0) {
			echo '<option value="">------- Select -------</option>';
			while($row = mysqli_fetch_object($res)) {
				echo '<option value="'.$row->b_addressfar.'">'.$row->b_addressfar.'</option>';
			}
		} else {
			echo '<option value="">No Record</option>';
		}
	
	} 


	$pos = new pos();
	$method=$_POST['method'];
	if($method == 'get_detail_far')
	{
		$id_far=$_POST['id_far'];
		$pos = new pos();
		$data = $pos->getFar($id_far);
		$array['data'] = $data[1];
		$array['result'] = $data[0];
		echo json_encode($array);
	}
	if($method == 'save_far')
	{
		$idfar = $_POST['id_far'];
		$namefar = $_POST['far_name'];
		$loc_name = str_replace(" ","",$_POST['loc_name']);
		$addressfar = $_POST['addressfar'];
		$msisdnfar = $_POST['msisdnfar'];
		$transaction_type = $_POST['transaction_type'];
		$crud=$_POST['crud'];
		$pos = new pos();
		if($_POST['crud'] == 'N')
		{

			$tpos = new pos();
			$block = $tpos->getblockadd($_SESSION['pos_username']);
			$walletno = $block[1]['wphone'];
			$wallet_address = $block[1]['b_address'];
			$b_token = $block[1]['b_token'];


			$response = null;
	//system("ping -c 1 google.com", $response);
	//if($response == 0)
//	{

	if ($transaction_type == 'addgenericroletype'){

		$typeidqry = "SELECT max(IFNULL(id_far,'FA0001')) as id FROM m_farmer";
		$typeidres = mysqli_query($con, $typeidqry);
		if(mysqli_num_rows($typeidres) > 0) {
		
			while($row = mysqli_fetch_object($typeidres)) {
			$typeid = $row->id;
			}
		} else {
	    $typeid = 'FA0001';
		}

	
	$typename1 = $namefar." ".$typeid;

	$typename = str_replace(" ","%20",$typename1);
	


	$curl = curl_init();

	curl_setopt_array($curl, array(
		CURLOPT_URL => 'https://www.agrikore.net/grole/unsafe/ad/{"'."op".'":"'.'addgenericroletype",'.'"admin'.'":"'.'0x2d2d8721fcacb58c7f5f2946bdcc487629da2d64",'.'"adminpwd'.'":"'.'agrikore",'.'"typeid'.'":"'.$typeid.'",'.'"typename'.'":"'.$typename.'"}',
		CURLOPT_RETURNTRANSFER => true,
		CURLOPT_ENCODING => "",
		CURLOPT_MAXREDIRS => 10,
		CURLOPT_TIMEOUT => 30,
		CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
		CURLOPT_CUSTOMREQUEST => "POST",
		CURLOPT_HTTPHEADER => array(
			"Cache-Control: no-cache",
			"x-access-token:$b_token"
		),
	));
	
	$responsegt = curl_exec($curl);
	$err = curl_error($curl);
	
	curl_close($curl);
	
	if ($err) {
		echo "cURL Error #:" . $err;
	} else {
	
	$receiptgt = str_replace('"',"",$responsegt);
}

// sleep for 10 seconds
sleep(10);

if(	$receiptgt != '' || 	$receiptgt != Null){ 

$ctr = 1;

while($ctr++ < 105){//while loop

$curl = curl_init();
curl_setopt_array($curl, array(

CURLOPT_URL => 'https://www.agrikore.net/transactionreceipts/'.	$receiptgt.'/',

CURLOPT_RETURNTRANSFER => true,
CURLOPT_ENCODING => "",
CURLOPT_MAXREDIRS => 10,
CURLOPT_TIMEOUT => 30,
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
		$array = $pos->saveFar($typename,$loc_name,$addressfar,$msisdnfar,$out,$transaction_type);
	} 
	/** */
	else{

//echo "<br> Everything failed<br>";
$array = false;
}
}elseif ($transaction_type == 'adddealerexpitem' ||$transaction_type == 'removedealerexpitem'){


$curl = curl_init();

curl_setopt_array($curl, array(
	CURLOPT_URL => 'https://www.agrikore.net/dealer/unsafe/ad/{"'."op".'":"'.$transaction_type.'",'.'"admin'.'":"'.'0x2d2d8721fcacb58c7f5f2946bdcc487629da2d64",'.'"adminpwd'.'":"'.'agrikore",'.'"addr'.'":"'.$addressfar.'",'.'"expindex'.'":"'.$loc_name.'"}',
	CURLOPT_RETURNTRANSFER => true,
	CURLOPT_ENCODING => "",
	CURLOPT_MAXREDIRS => 10,
	CURLOPT_TIMEOUT => 30,
	CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
	CURLOPT_CUSTOMREQUEST => "POST",
	CURLOPT_HTTPHEADER => array(
		"Cache-Control: no-cache",
		"x-access-token:$b_token"
	),
));

$responsegt = curl_exec($curl);
$err = curl_error($curl);

curl_close($curl);

if ($err) {
	echo "cURL Error #:" . $err;
} else {

$receiptgt = str_replace('"',"",$responsegt);
}

// sleep for 10 seconds
sleep(10);

if(	$receiptgt != '' || 	$receiptgt != Null){ 

$ctr = 1;

while($ctr++ < 105){//while loop

$curl = curl_init();
curl_setopt_array($curl, array(

CURLOPT_URL => 'https://www.agrikore.net/transactionreceipts/'.	$receiptgt.'/',

CURLOPT_RETURNTRANSFER => true,
CURLOPT_ENCODING => "",
CURLOPT_MAXREDIRS => 10,
CURLOPT_TIMEOUT => 30,
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
	$array = $pos->saveFar($namefar,$loc_name,$addressfar,$msisdnfar,$out,$transaction_type);
} 
/** */
else{

//echo "<br> Everything failed<br>";
$array = false;
}
}else{
			
			  
			 $curl = curl_init();
			 $tranname = str_replace('add',"",$transaction_type);
			 $namefar = str_replace(" ","%20",$namefar);

			 curl_setopt_array($curl, array(
				CURLOPT_URL => "https://www.agrikore.net/$tranname/unsafe/ad/{%22op%22:%22$transaction_type%22,%22admin%22:%220x2d2d8721fcacb58c7f5f2946bdcc487629da2d64%22,%22adminpwd%22:%22agrikore%22,%22addr%22:%22$addressfar%22,%20%22name%22:%22$namefar%22,%20%22loc%22:%22$loc_name%22}",
				CURLOPT_RETURNTRANSFER => true,
				CURLOPT_ENCODING => "",
				CURLOPT_MAXREDIRS => 10,
				CURLOPT_TIMEOUT => 30,
				CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
				CURLOPT_CUSTOMREQUEST => "POST",
				CURLOPT_HTTPHEADER => array(
				  "Cache-Control: no-cache",
				  "x-access-token: $b_token"
				),
			  ));
			  
			  $response2 = curl_exec($curl);
			  $err = curl_error($curl);
			  
			  curl_close($curl);
			  
			  if ($err) {
				echo  "cURL Error #:" . $err;
			  } else {
				//echo $response;
				$receipt2 = str_replace('"',"",$response2);
			  }
			
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
					  $array = $pos->saveFar($namefar,$loc_name,$addressfar,$msisdnfar,$out,$transaction_type);
					} 
					/** */
					else{
		  
			  //echo "<br> Everything failed<br>";
			  $array = false;
			}

	}//end if


			
			if($array[0] == true)
			{
				$result['id_far'] = $array[2];
			}
			
		}
		else
		{
			$array = $pos->updateFar($idfar,$namefar,$loc_name,$addressfar,$msisdnfar,$transaction_type);
		}
		$result['result'] = $array[0];
		$result['error'] = $array[1];
		$result['crud'] = $_POST['crud'];
		echo json_encode($result);
	}
	
	if($method == 'getdata'){
		$pos = new pos();
		$array = $pos->getListFar();
		$data = $array[1];
		$i=0;
		foreach ($data as $key) {
			$button = '<button  type="submit" id_far="'.$key['id_far'].'"  title="Tombol edit barang" class="btn btn-sm btn-primary btneditfar "  id="btneditfar'.$key['id_far'].'"  ><i class="fa fa-edit"></i></button> <button  type="submit" id_far="'.$key['id_far'].'"  title="Tombol hapus barang" class="btn btn-danger btn-sm btndeletefar "  id="btndeletefar'.$key['id_far'].'"  ><i class="fa fa-trash"></i></button>';

			$data[$i]['far_name'] =  $data[$i]['far_name'];
			//$data[$i]['fprice'] =  number_format($data[$i]['fprice']);
			$data[$i]['DT_RowId']= $data[$i]['id_far'];
			$data[$i]['loc_name']= $data[$i]['loc_name'];
			//$data[$i]['terms']= number_format($data[$i]['terms']);
			$data[$i]['button'] = $button;
			$i++;
		}
		$datax = array('data' => $data);
		echo json_encode($datax);
	}
	if($method == 'delete_far'){
		$id_far=$_POST['id_far'];
		$pos = new pos();
		$array = $pos->deleteFar($id_far);
		$data['result'] = $array[0];
		$data['error'] = $array[1];
		echo json_encode($data);
	}
	
} else {
	exit('No direct access allowed.');
}