<?php
session_start();
require_once ("../model/dbconn.php");
require_once ("../model/pos.php");
include('db.php');



if( isset( $_SERVER['HTTP_X_REQUESTED_WITH'] ) && ( $_SERVER['HTTP_X_REQUESTED_WITH'] == 'XMLHttpRequest' ) )
{ 
	

if (isset($_POST['wphone1_id'])) {

	//$mul_name = $_POST['mul_name'];
	$wphone1_id = $_POST['wphone1_id'];
	
	$qry = "select b_address as address1_id,concat(username,'-',b_address) as address1  from m_user where wphone= '$wphone1_id' ";
	$res = mysqli_query($con, $qry);
	if(mysqli_num_rows($res) > 0) {
		echo '<option value="">------- Select -------</option>';
		while($row = mysqli_fetch_object($res)) {
			echo '<option value="'.$row->address1_id.'">'.$row->address1.'</option>';
		}
	} else {
		echo '<option value="">No Record</option>';
	}

} else if(isset($_POST['address1_id'])) {

	$address1_id = $_POST['address1_id'];

	$qry = "select wphone as wphone2_id,concat(username,'-',wphone) as wphone2  from m_user where b_address <> '$address1_id'";
	$res = mysqli_query($con, $qry);
	if(mysqli_num_rows($res) > 0) {
		echo '<option value="">------- Select -------</option>';
		while($row = mysqli_fetch_object($res)) {
			echo '<option value="'.$row->wphone2_id.'">'.$row->wphone2.'</option>';
		}
	} else {
		echo '<option value="">No Record</option>';
	}

} else if(isset($_POST['wphone2_id'])) {

	$wphone2_id = $_POST['wphone2_id'];

	$qry = "select b_address as address2_id,concat(username,'-',b_address) as address2  from m_user where wphone=  '$wphone2_id'";
	$res = mysqli_query($con, $qry);
	if(mysqli_num_rows($res) > 0) {
		echo '<option value="">------- Select -------</option>';
		while($row = mysqli_fetch_object($res)) {
			echo '<option value="'.$row->address2_id.'">'.$row->address2.'</option>';
		}
	} else {
		echo '<option value="">No Record</option>';
	}
}






	$pos = new pos();
	$method=$_POST['method'];
	if($method == 'get_detail_mul')
	{
		$id_mul=$_POST['id_mul'];
		$pos = new pos();
		$data = $pos->getmul($id_mul);
		$array['data'] = $data[1];
		$array['result'] = $data[0];
		echo json_encode($array);
	}
	if($method == 'save_mul')
	{
		$idmul = $_POST['id_mul'];
		$mul_name = $_POST['mul_name'];
		$currency_type = $_POST['currency_type'];
		$exchanged_currency = $_POST['exchanged_currency'];
		$amount = $_POST['amount']*1000000000000000000;
		$addressmul = $_POST['addressmul'];
		$msisdnmul = $_POST['msisdnmul'];
		$addressmuldes = $_POST['addressmuldes'];
		$msisdnmuldes = $_POST['msisdnmuldes'];
		$frompw = $_POST['frompw'];
		$crud=$_POST['crud'];
		$pos = new pos();
		if($_POST['crud'] == 'N')
		{

			//---------------------Block begins------------------------
			$t2pos = new pos();
			$block = $t2pos->getblockadd($_SESSION['pos_username']);
			$walletno = $block[1]['wphone'];
			$wallet_address = $block[1]['b_address'];
			$b_token = $block[1]['b_token'];
//			$u_pass = $block[1]['pass'];

//---------------------Block begins------------------------
$t1pos = new pos();
$block1 = $t1pos->getblockpass($msisdnmul);
//$walletno1 = $block1[1]['wphone'];
//$wallet_address1 = $block1[1]['b_address'];
//$b_token1 = $block1[1]['b_token'];
$u_pass1 = $block1[1]['pass'];



if($currency_type =='openmulaselfaddaccount' || $currency_type == 'openexternalbuy' || $currency_type == 'openexternalsell' ){

	$curl = curl_init();
	
	curl_setopt_array($curl, array(
	CURLOPT_URL => 'https://www.agrikore.net/'.$exchanged_currency.'/unsafe/ad/{"'."op".'":"'.$currency_type.'",'.'"admin'.'":"'.'0x2d2d8721fcacb58c7f5f2946bdcc487629da2d64",'.'"adminpwd'.'":"'.'agrikore"}',
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
	
	$response = curl_exec($curl);
	$err = curl_error($curl);
	
	//curl_close($curl);
	
	if ($err) {
	$eecho = "cURL Error #:" . $err;
	} else {
	$tran_id = str_replace('"',"",$response);
	}
	
	sleep(5);
	if ($tran_id != null || $tran_id != ""){
	
		
	
			 $ctr = 1;
	
			 while($ctr++ < 15){//while loop
	
	//	  $curl = curl_init();
			 curl_setopt_array($curl, array(
			 
			 CURLOPT_URL => 'https://www.agrikore.net/transactionreceipts/'.$tran_id.'/',
			 
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
			 
			 $responserpt = curl_exec($curl);
			 $err = curl_error($curl);
			 
			 curl_close($curl);
		 
			 if ($err) {
			 $echo = "cURL Error #:" . $err;
			 } else {
			  $echo = $responserpt;
			 }
			 //$ctr++;
			 if ($responserpt != "Cannot find the transaction or it's receipt" || $responserpt == "") {
			 break;    /* You could also write 'break 1;' here. */
		 }
			 
		 }//while loop off
			 
		  
	
			 $json_o = json_decode($responserpt,true);
	
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
				 
					 $amount = $_POST['amount'];			
	$array = $pos->saveMul($mul_name,$currency_type,$exchanged_currency,$amount,$addressmul,$msisdnmul,$addressmuldes,$msisdnmuldes,$frompw,$out);
	
	
	
	
	
			}else{
				$tran_id = "";
				$array = false;
			
			}
	}

	if($currency_type =='closemulaselfaddaccount' || $currency_type =='closeexternalbuy' || $currency_type =='closeexternalsell'){

		$curl = curl_init();
		
		curl_setopt_array($curl, array(
		CURLOPT_URL => 'https://www.agrikore.net/'.$exchanged_currency.'/unsafe/ad/{"'."op".'":"'.$currency_type.'",'.'"admin'.'":"'.'0x2d2d8721fcacb58c7f5f2946bdcc487629da2d64",'.'"adminpwd'.'":"'.'agrikore"}',
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
		
		$response = curl_exec($curl);
		$err = curl_error($curl);
		
		curl_close($curl);
		
		if ($err) {
		$eecho = "cURL Error #:" . $err;
		} else {
		$tran_id = str_replace('"',"",$response);
		}
		
		sleep(5);
		if ($tran_id != null || $tran_id != ""){
		
			
		
				 $ctr = 1;
		
				 while($ctr++ < 15){//while loop
		
			  $curl = curl_init();
				 curl_setopt_array($curl, array(
				 
				 CURLOPT_URL => 'https://www.agrikore.net/transactionreceipts/'.$tran_id.'/',
				 
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
				 
				 $responserpt = curl_exec($curl);
				 $err = curl_error($curl);
				 
				 curl_close($curl);
			 
				 if ($err) {
				 $echo = "cURL Error #:" . $err;
				 } else {
				  $echo = $responserpt;
				 }
				 //$ctr++;
				 if ($responserpt != "Cannot find the transaction or it's receipt" || $responserpt == "") {
				 break;    /* You could also write 'break 1;' here. */
			 }
				 
			 }//while loop off
				 
			  
		
				 $json_o = json_decode($responserpt,true);
		
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
						 $amount = $_POST['amount']; 
						
		$array = $pos->saveMul($mul_name,$currency_type,$exchanged_currency,$amount,$addressmul,$msisdnmul,$addressmuldes,$msisdnmuldes,$frompw,$out);
		
		
		
		
		
				}else{
					$tran_id = "";
					$array = false;
				
				}
		}
	

if($currency_type =='setbuyprice'||$currency_type =='setsellprice'){

$curl = curl_init();

curl_setopt_array($curl, array(
CURLOPT_URL => 'https://www.agrikore.net/'.$exchanged_currency.'/unsafe/ad/{"'."op".'":"'.$currency_type.'",'.'"admin'.'":"'.'0x2d2d8721fcacb58c7f5f2946bdcc487629da2d64",'.'"adminpwd'.'":"'.'agrikore",'.'"price'.'":"'.$amount.'"}',
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

$response = curl_exec($curl);
$err = curl_error($curl);

curl_close($curl);

if ($err) {
$eecho = "cURL Error #:" . $err;
} else {
$tran_id = str_replace('"',"",$response);
}

sleep(5);
if ($tran_id != null || $tran_id != ""){

	

		 $ctr = 1;

		 while($ctr++ < 15){//while loop

	  $curl = curl_init();
		 curl_setopt_array($curl, array(
		 
		 CURLOPT_URL => 'https://www.agrikore.net/transactionreceipts/'.$tran_id.'/',
		 
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
		 
		 $responserpt = curl_exec($curl);
		 $err = curl_error($curl);
		 
		 curl_close($curl);
	 
		 if ($err) {
		 $echo = "cURL Error #:" . $err;
		 } else {
		  $echo = $responserpt;
		 }
		 //$ctr++;
		 if ($responserpt != "Cannot find the transaction or it's receipt" || $responserpt == "") {
		 break;    /* You could also write 'break 1;' here. */
	 }
		 
	 }//while loop off
		 
	  

		 $json_o = json_decode($responserpt,true);

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
				 $amount = $_POST['amount'];
				
$array = $pos->saveMul($mul_name,$currency_type,$exchanged_currency,$amount,$addressmul,$msisdnmul,$addressmuldes,$msisdnmuldes,$frompw,$out);





		}else{
			$tran_id = "";
			$array = false;
		
		}
}//mula buy and sell price set
//-----------------Block Import end--------------------------

if($currency_type =='settransactionfee'){

	$curl = curl_init();
	
	curl_setopt_array($curl, array(
	  CURLOPT_URL => 'https://www.agrikore.net/'.$exchanged_currency.'/unsafe/ad/{"'."op".'":"'.$currency_type.'",'.'"admin'.'":"'.'0x2d2d8721fcacb58c7f5f2946bdcc487629da2d64",'.'"adminpwd'.'":"'.'agrikore",'.'"fee'.'":"'.$amount.'"}',
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
	
	$response3 = curl_exec($curl);
	$err = curl_error($curl);
	
	curl_close($curl);
	
	if ($err) {
	  echo "cURL Error #:" . $err;
	} else {
	 // echo $response3;
	  $tran_id3 = str_replace('"',"",$response3);
	}

	sleep(5);
	if ($tran_id3 != null || $tran_id3 != ""){

		

		$ctr = 1;

		while($ctr++ < 15){//while loop

	 $curl = curl_init();
		curl_setopt_array($curl, array(
		
		CURLOPT_URL => 'https://www.agrikore.net/transactionreceipts/'.$tran_id3.'/',
		
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
		
		$responserpt = curl_exec($curl);
		$err = curl_error($curl);
		
		curl_close($curl);
	
		if ($err) {
		$echo = "cURL Error #:" . $err;
		} else {
		 $echo = $responserpt;
		}
		//$ctr++;
		if ($responserpt != "Cannot find the transaction or it's receipt" || $responserpt == "") {
		break;    /* You could also write 'break 1;' here. */
	}
		
	}//while loop off
		
	 

		$json_o = json_decode($responserpt,true);

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
			
				$amount = $_POST['amount'];
		$array = $pos->saveMul($mul_name,$currency_type,$exchanged_currency,$amount,$addressmul,$msisdnmul,$addressmuldes,$msisdnmuldes,$frompw,$out);
	}else{
		$tran_id3 = "";
		$array = false;
	
	}
	}
	
	if($currency_type =='settransactionfeefixed'){

		$curl = curl_init();
		
		curl_setopt_array($curl, array(
		  CURLOPT_URL => 'https://www.agrikore.net/'.$exchanged_currency.'/unsafe/ad/{"'."op".'":"'.$currency_type.'",'.'"admin'.'":"'.'0x2d2d8721fcacb58c7f5f2946bdcc487629da2d64",'.'"adminpwd'.'":"'.'agrikore",'.'"feefixed'.'":"'.$amount.'"}',
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
		
		$response3 = curl_exec($curl);
		$err = curl_error($curl);
		
		curl_close($curl);
		
		if ($err) {
		  echo "cURL Error #:" . $err;
		} else {
		 // echo $response3;
		  $tran_id3 = str_replace('"',"",$response3);
		}
	
		sleep(5);
		if ($tran_id3 != null || $tran_id3 != ""){
	
			
	
			$ctr = 1;
	
			while($ctr++ < 15){//while loop
	
		 $curl = curl_init();
			curl_setopt_array($curl, array(
			
			CURLOPT_URL => 'https://www.agrikore.net/transactionreceipts/'.$tran_id3.'/',
			
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
			
			$responserpt = curl_exec($curl);
			$err = curl_error($curl);
			
			curl_close($curl);
		
			if ($err) {
			$echo = "cURL Error #:" . $err;
			} else {
			 $echo = $responserpt;
			}
			//$ctr++;
			if ($responserpt != "Cannot find the transaction or it's receipt" || $responserpt == "") {
			break;    /* You could also write 'break 1;' here. */
		}
			
		}//while loop off
			
		 
	
			$json_o = json_decode($responserpt,true);
	
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
				
					$amount = $_POST['amount'];
			$array = $pos->saveMul($mul_name,$currency_type,$exchanged_currency,$amount,$addressmul,$msisdnmul,$addressmuldes,$msisdnmuldes,$frompw,$out);
		}else{
			$tran_id3 = "";
			$array = false;
		
		}
		}
		
		if($currency_type =='settransactionfeepercent'){

			$curl = curl_init();
			
			curl_setopt_array($curl, array(
			  CURLOPT_URL => 'https://www.agrikore.net/'.$exchanged_currency.'/unsafe/ad/{"'."op".'":"'.$currency_type.'",'.'"admin'.'":"'.'0x2d2d8721fcacb58c7f5f2946bdcc487629da2d64",'.'"adminpwd'.'":"'.'agrikore",'.'"feepercent'.'":"'.$amount.'"}',
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
			
			$response3 = curl_exec($curl);
			$err = curl_error($curl);
			
			curl_close($curl);
			
			if ($err) {
			  echo "cURL Error #:" . $err;
			} else {
			 // echo $response3;
			  $tran_id3 = str_replace('"',"",$response3);
			}
		
			sleep(5);
			if ($tran_id3 != null || $tran_id3 != ""){
		
				
		
				$ctr = 1;
		
				while($ctr++ < 15){//while loop
		
			 $curl = curl_init();
				curl_setopt_array($curl, array(
				
				CURLOPT_URL => 'https://www.agrikore.net/transactionreceipts/'.$tran_id3.'/',
				
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
				
				$responserpt = curl_exec($curl);
				$err = curl_error($curl);
				
				curl_close($curl);
			
				if ($err) {
				$echo = "cURL Error #:" . $err;
				} else {
				 $echo = $responserpt;
				}
				//$ctr++;
				if ($responserpt != "Cannot find the transaction or it's receipt" || $responserpt == "") {
				break;    /* You could also write 'break 1;' here. */
			}
				
			}//while loop off
				
			 
		
				$json_o = json_decode($responserpt,true);
		
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
					
						$amount = $_POST['amount'];
				$array = $pos->saveMul($mul_name,$currency_type,$exchanged_currency,$amount,$addressmul,$msisdnmul,$addressmuldes,$msisdnmuldes,$frompw,$out);
			}else{
				$tran_id3 = "";
				$array = false;
			
			}
			}
			
		


if($currency_type =='setminimumamount'){

	$curl = curl_init();
	
	curl_setopt_array($curl, array(
	  CURLOPT_URL => 'https://www.agrikore.net/'.$exchanged_currency.'/unsafe/ad/{"'."op".'":"'.$currency_type.'",'.'"admin'.'":"'.'0x2d2d8721fcacb58c7f5f2946bdcc487629da2d64",'.'"adminpwd'.'":"'.'agrikore",'.'"minamount'.'":"'.$amount.'"}',
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
	
	$response4 = curl_exec($curl);
	$err = curl_error($curl);
	
	curl_close($curl);
	
	if ($err) {
	  echo "cURL Error #:" . $err;
	} else {
	 // echo $response3;
	  $tran_id4 = str_replace('"',"",$response4);
	}

	sleep(5);
	if ($tran_id4 != null || $tran_id4 != ""){

		

		$ctr = 1;

		while($ctr++ < 15){//while loop

	 $curl = curl_init();
		curl_setopt_array($curl, array(
		
		CURLOPT_URL => 'https://www.agrikore.net/transactionreceipts/'.$tran_id4.'/',
		
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
		
		$responserpt = curl_exec($curl);
		$err = curl_error($curl);
		
		curl_close($curl);
	
		if ($err) {
		$echo = "cURL Error #:" . $err;
		} else {
		 $echo = $responserpt;
		}
		//$ctr++;
		if ($responserpt != "Cannot find the transaction or it's receipt" || $responserpt == "") {
		break;    /* You could also write 'break 1;' here. */
	}
		
	}//while loop off
		
	 

		$json_o = json_decode($responserpt,true);

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
				$amount = $_POST['amount'];

		$array = $pos->saveMul($mul_name,$currency_type,$exchanged_currency,$amount,$addressmul,$msisdnmul,$addressmuldes,$msisdnmuldes,$frompw,$out);
	}else{
			
		$array = false;
	}
	
	}

if($currency_type =='setmaximumamount'){

	$curl = curl_init();
	
	curl_setopt_array($curl, array(
	  CURLOPT_URL => 'https://www.agrikore.net/'.$exchanged_currency.'/unsafe/ad/{"'."op".'":"'.$currency_type.'",'.'"admin'.'":"'.'0x2d2d8721fcacb58c7f5f2946bdcc487629da2d64",'.'"adminpwd'.'":"'.'agrikore",'.'"maxamount'.'":"'.$amount.'"}',
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
	
	$response5 = curl_exec($curl);
	$err = curl_error($curl);
	
	curl_close($curl);
	
	if ($err) {
	  echo "cURL Error #:" . $err;
	} else {
	 // echo $response3;
	  $tran_id5 = str_replace('"',"",$response5);
	}

	sleep(5);
	if ($tran_id5 != null || $tran_id5 != ""){

		

		$ctr = 1;

		while($ctr++ < 15){//while loop

	 $curl = curl_init();
		curl_setopt_array($curl, array(
		
		CURLOPT_URL => 'https://www.agrikore.net/transactionreceipts/'.$tran_id5.'/',
		
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
		
		$responserpt = curl_exec($curl);
		$err = curl_error($curl);
		
		curl_close($curl);
	
		if ($err) {
		$echo = "cURL Error #:" . $err;
		} else {
		 $echo = $responserpt;
		}
		//$ctr++;
		if ($responserpt != "Cannot find the transaction or it's receipt" || $responserpt == "") {
		break;    /* You could also write 'break 1;' here. */
	}
		
	}//while loop off
		
	 

		$json_o = json_decode($responserpt,true);

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
			
				$amount = $_POST['amount'];
		$array = $pos->saveMul($mul_name,$currency_type,$exchanged_currency,$amount,$addressmul,$msisdnmul,$addressmuldes,$msisdnmuldes,$frompw,$out);
	}else{
			
		$array = false;
	}
	
	}


	if($currency_type =='setminamount' || $currency_type =='setmaxamount'){

		$curl = curl_init();
		
		curl_setopt_array($curl, array(
		  CURLOPT_URL => 'https://www.agrikore.net/'.$exchanged_currency.'/unsafe/ad/{"'."op".'":"'.$currency_type.'",'.'"admin'.'":"'.'0x2d2d8721fcacb58c7f5f2946bdcc487629da2d64",'.'"adminpwd'.'":"'.'agrikore",'.'"amount'.'":"'.$amount.'"}',
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
		
		$response4 = curl_exec($curl);
		$err = curl_error($curl);
		
		curl_close($curl);
		
		if ($err) {
		  echo "cURL Error #:" . $err;
		} else {
		 // echo $response3;
		 // echo "<br>".
		  $tran_id4 = str_replace('"',"",$response4);
		}
	
		sleep(10);
		if ($tran_id4 != null || $tran_id4 != ""){
	
			
	
			$ctr = 1;
	
			while($ctr++ < 55){//while loop
	
		   $curl = curl_init();
			curl_setopt_array($curl, array(
			
			CURLOPT_URL => 'https://www.agrikore.net/transactionreceipts/'.$tran_id4.'/',
			
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
			
			$responserpt = curl_exec($curl);
			$err = curl_error($curl);
			
			curl_close($curl);
		
			if ($err) {
			$echo = "cURL Error #:" . $err;
			} else {
			 $echo = $responserpt;
			}
			//$ctr++;
			if ($responserpt != "Cannot find the transaction or it's receipt" || $responserpt == "") {
			break;    /* You could also write 'break 1;' here. */
		}
			
		}//while loop off
			
		 
	
			$json_o = json_decode($responserpt,true);
	
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
				
					$amount = $_POST['amount'];
			$array = $pos->saveMul($mul_name,$currency_type,$exchanged_currency,$amount,$addressmul,$msisdnmul,$addressmuldes,$msisdnmuldes,$frompw,$out);
		}else{
				
			$array = false;
		}
		
		}
	

	if($currency_type =='setcommissionpercentage'){

		$curl = curl_init();
		
		curl_setopt_array($curl, array(
		  CURLOPT_URL => 'https://www.agrikore.net/'.$exchanged_currency.'/unsafe/ad/{"'."op".'":"'.$currency_type.'",'.'"admin'.'":"'.'0x2d2d8721fcacb58c7f5f2946bdcc487629da2d64",'.'"adminpwd'.'":"'.'agrikore",'.'"commpercent'.'":"'.$amount.'"}',
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
		
		$response6 = curl_exec($curl);
		$err = curl_error($curl);
		
		curl_close($curl);
		
		if ($err) {
		  echo "cURL Error #:" . $err;
		} else {
		 // echo $response3;
		  $tran_id6 = str_replace('"',"",$response6);
		}

		sleep(5);
		if ($tran_id6 != null || $tran_id6 != ""){

			

		$ctr = 1;

		while($ctr++ < 15){//while loop

	 $curl = curl_init();
		curl_setopt_array($curl, array(
		
		CURLOPT_URL => 'https://www.agrikore.net/transactionreceipts/'.$tran_id6.'/',
		
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
		
		$responserpt = curl_exec($curl);
		$err = curl_error($curl);
		
		curl_close($curl);
	
		if ($err) {
		$echo = "cURL Error #:" . $err;
		} else {
		 $echo = $responserpt;
		}
		//$ctr++;
		if ($responserpt != "Cannot find the transaction or it's receipt" || $responserpt == "") {
		break;    /* You could also write 'break 1;' here. */
	}
		
	}//while loop off
		
	 

		$json_o = json_decode($responserpt,true);

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
			

				$amount = $_POST['amount'];
			$array = $pos->saveMul($mul_name,$currency_type,$exchanged_currency,$amount,$addressmul,$msisdnmul,$addressmuldes,$msisdnmuldes,$frompw,$out);
		}else{
			
			$array = false;
		
		}
		}
	
		if($currency_type =='admintransfernofee'){
			$curl = curl_init();

			curl_setopt_array($curl, array(
			  CURLOPT_URL => 'https://www.agrikore.net/'.$exchanged_currency.'/unsafe/ad/{"'."op".'":"'.$currency_type.'",'.'"admin'.'":"'.'0x2d2d8721fcacb58c7f5f2946bdcc487629da2d64",'.'"adminpwd'.'":"'.'agrikore",'.'"from'.'":"'.$addressmul.'",'.'"to'.'":"'.$addressmuldes.'",'.'"val'.'":"'.$amount.'"}',
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
			
			$response7 = curl_exec($curl);
			$err = curl_error($curl);
			
			curl_close($curl);
			
			if ($err) {
			  echo "cURL Error #:" . $err;
			} else {
			 // echo $response7;
			  $tran_id7 = str_replace('"',"",$response7);
			}

			sleep(5);
			if ($tran_id7 != null || $tran_id7 != ""){
				

		$ctr = 1;

		while($ctr++ < 15){//while loop

	 $curl = curl_init();
		curl_setopt_array($curl, array(
		
		CURLOPT_URL => 'https://www.agrikore.net/transactionreceipts/'.$tran_id7.'/',
		
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
		
		$responserpt = curl_exec($curl);
		$err = curl_error($curl);
		
		curl_close($curl);
	
		if ($err) {
		$echo = "cURL Error #:" . $err;
		} else {
		 $echo = $responserpt;
		}
		//$ctr++;
		if ($responserpt != "Cannot find the transaction or it's receipt" || $responserpt == "") {
		break;    /* You could also write 'break 1;' here. */
	}
		
	}//while loop off
		
	 

		$json_o = json_decode($responserpt,true);

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
			
				$amount = $_POST['amount'];

				$array = $pos->saveMul($mul_name,$currency_type,$exchanged_currency,$amount,$addressmul,$msisdnmul,$addressmuldes,$msisdnmuldes,$frompw,$out);
			}else{
			
				$array = false;
		}
		
		}

		if($currency_type =='transfer' && md5($frompw) == $u_pass1){
			$curl = curl_init();

			curl_setopt_array($curl, array(
			  CURLOPT_URL => 'https://www.agrikore.net/'.$exchanged_currency.'/unsafe/tx/{"'."op".'":"'.$currency_type.'",'.'"frompwd'.'":"'.$u_pass1.'",'.'"from'.'":"'.$addressmul.'",'.'"to'.'":"'.$addressmuldes.'",'.'"val'.'":"'.$amount.'"}',
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
			
			$response8 = curl_exec($curl);
			$err = curl_error($curl);
			
			curl_close($curl);
			
			if ($err) {
			  echo "cURL Error #:" . $err;
			} else {
			 // echo $response7;
			  $tran_id8 = str_replace('"',"",$response8);
			}

			sleep(5);

			if ($tran_id8 != null || $tran_id8 != ""){

				

		$ctr = 1;

		while($ctr++ < 15){//while loop

	 $curl = curl_init();
		curl_setopt_array($curl, array(
		
		CURLOPT_URL => 'https://www.agrikore.net/transactionreceipts/'.$tran_id8.'/',
		
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
		
		$responserpt = curl_exec($curl);
		$err = curl_error($curl);
		
		curl_close($curl);
	
		if ($err) {
		$echo = "cURL Error #:" . $err;
		} else {
		 $echo = $responserpt;
		}
		//$ctr++;
		if ($responserpt != "Cannot find the transaction or it's receipt" || $responserpt == "") {
		break;    /* You could also write 'break 1;' here. */
	}
		
	}//while loop off
		
	 

		$json_o = json_decode($responserpt,true);

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
			
				$amount = $_POST['amount'];

				$array = $pos->saveMul($mul_name,$currency_type,$exchanged_currency,$amount,$addressmul,$msisdnmul,$addressmuldes,$msisdnmuldes,$frompw,$out);
			}else{
			
				$array = false;
		}
		
		}
		//	$tran_id = "0xxxxxxxxxxxexample";
		if($array[0] == true)

			{

							$result['id_mul'] = $array[2];
			}

		}
		
		else
		{
			$array = $pos->updateMul($idmul,$mul_name,$currency_type,$exchanged_currency,$amount,$addressmul,$msisdnmul,$addressmuldes,$msisdnmuldes,$frompw);
		}
		$result['result'] = $array[0];
		$result['error'] = $array[1];
		$result['crud'] = $_POST['crud'];
		echo json_encode($result);
	}
	
	if($method == 'getdata'){
		$pos = new pos();
		$array = $pos->getListMul();
		$data = $array[1];
		$i=0;
		foreach ($data as $key) {
			$button = '<button  type="submit" id_mul="'.$key['id_mul'].'"  title="Tombol edit barang" class="btn btn-sm btn-primary btneditmul "  id="btneditmul'.$key['id_mul'].'"  ><i class="fa fa-edit"></i></button> <button  type="submit" id_mul="'.$key['id_mul'].'"  title="Tombol hapus barang" class="btn btn-danger btn-sm btndeletemul "  id="btndeletemul'.$key['id_mul'].'"  ><i class="fa fa-trash"></i></button>';

			$data[$i]['mul_name'] =  $data[$i]['mul_name'];
			//$data[$i]['fprice'] =  number_format($data[$i]['fprice']);
			$data[$i]['DT_RowId']= $data[$i]['id_mul'];
			$data[$i]['currency_type']= $data[$i]['currency_type'];
			//$data[$i]['terms']= number_format($data[$i]['terms']);
			$data[$i]['button'] = $button;
			$i++;
		}
		$datax = array('data' => $data);
		echo json_encode($datax);
	}
	if($method == 'delete_mul'){
		$id_mul=$_POST['id_mul'];
		$pos = new pos();
		$array = $pos->deleteMul($id_mul);
		$data['result'] = $array[0];
		$data['error'] = $array[1];
		echo json_encode($data);
	}
	
} else {
	exit('No direct access allowed.');
}
