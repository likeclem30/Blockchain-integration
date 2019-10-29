<?php
session_start();
require_once ("../model/dbconn.php");
require_once ("../model/pos.php");
include('db.php');



if( isset( $_SERVER['HTTP_X_REQUESTED_WITH'] ) && ( $_SERVER['HTTP_X_REQUESTED_WITH'] == 'XMLHttpRequest' ) )
{
	if (isset($_POST['wphone1_id2'])) {
	
	$qry = "select * from m_user where wphone=".mysqli_real_escape_string($con,$_POST['wphone1_id2'])." order by username";
	$res = mysqli_query($con, $qry);
	if(mysqli_num_rows($res) > 0) {
		echo '<option value="">------- Select -------</option>';
		while($row = mysqli_fetch_object($res)) {
			echo '<option value="'.$row->b_address.'">'.$row->b_address.'</option>';
		}
	} else {
		echo '<option value="">No Record</option>';
	}

} 
	$pos = new pos();
	$method=$_POST['method'];
	if($method == 'get_detail_cur')
	{
		$id_cur=$_POST['id_cur'];
		$pos = new pos();
		$data = $pos->getCur($id_cur);
		$array['data'] = $data[1];
		$array['result'] = $data[0];
		echo json_encode($array);
	}
	if($method == 'save_cur')
	{
		$idcur = $_POST['id_cur'];
		$cur_name = $_POST['cur_name'];
		$transaction_type = $_POST['transaction_type'];
		$currency_type = $_POST['currency_type'];
		$amount = $_POST['amount']*1000000000000000000;
		$addresscur = $_POST['addresscur'];
		$msisdncur = $_POST['msisdncur'];
		$frompwcur = md5($_POST['frompwcur']);
		$crud=$_POST['crud'];
		$pos = new pos();
		if($_POST['crud'] == 'N')
		{

			//--------------------Block import------

$tpos = new pos();
$block = $tpos->getblockadd($_SESSION['pos_username']);
$walletno = $block[1]['wphone'];
$wallet_address = $block[1]['b_address'];
$b_token = $block[1]['b_token'];

//---------------------Block begins------------------------
$t1pos = new pos();
$block1 = $t1pos->getblockpass($msisdncur);
//$walletno1 = $block1[1]['wphone'];
//$wallet_address1 = $block1[1]['b_address'];
//$b_token1 = $block1[1]['b_token'];
$u_pass1 = $block1[1]['pass'];





if($transaction_type =='addmulaaccount' || $transaction_type =='removemulaaccount'){ 

	$curl = curl_init();
	
	curl_setopt_array($curl, array(
	  CURLOPT_URL => 'https://www.agrikore.net/mula/unsafe/ad/{"'."op".'":"'.$transaction_type.'",'.'"admin'.'":"'.'0x2d2d8721fcacb58c7f5f2946bdcc487629da2d64",'.'"adminpwd'.'":"'.'agrikore",'.'"addr'.'":"'.$addresscur.'"}',
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
	
	$responseimp = curl_exec($curl);
	$err = curl_error($curl);
	
	curl_close($curl);
	
	
	if ($err) {
	  //$receipt2 = "Connection Error:" . $err;
	  $receiptimp = "Connection Error";
	} else {
	
	  $newresponseimp = str_replace('"',"",$responseimp);
		$receiptimp = str_replace('{}',"",$newresponseimp);
	
		//echo "<br> tran_id2 -".$tran_id2;
	//	echo "<br> response2 1-".$receipt2;
		//echo "<br> response2 1-".$receiptx;
		
	}
	
	
	// sleep for 10 seconds
	sleep(10);
	
	if($receiptimp != '' || $receiptimp != Null || $receiptimp != 'Connection Error'){ 
	
		$ctr = 1;
	
		while($ctr++ < 305){//while loop
	
	 $curl = curl_init();
		curl_setopt_array($curl, array(
		
		CURLOPT_URL => 'https://www.agrikore.net/transactionreceipts/'.$receiptimp,
		
		CURLOPT_RETURNTRANSFER => true,
		CURLOPT_ENCODING => "",
		CURLOPT_MAXREDIRS => 10,
		CURLOPT_TIMEOUT => 30,
		CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
		CURLOPT_CUSTOMREQUEST => "GET",
		CURLOPT_HTTPHEADER => array(
			"Cache-Control: no-cache",
			"x-access-token: $b_token"
		),
		));
		
		
		$responseimp = curl_exec($curl);
		$err = curl_error($curl);
		
		curl_close($curl);
	
		if ($err) {
		echo "cURL Error #:" . $err;
		$errorimp = "Empty reply from server";
		} else {
		 $echo = $responseimp;
		}
	
		//echo "<br> response3 :".$response3;
		//$ctr++;
		if ($responseimp != "Cannot find the transaction or it's receipt" || $responseimp != "" || $errorimp != "Empty reply from server" || substr($responseimp,0,33) != "Cannot find the transaction or it") {
		break;    /* You could also write 'break 1;' here. */
	}
		
	}//while loop off
		//echo "<br> response3-out :".$responseimp;
	 // echo "<br> Reciept query :".$response3."<br>";
		$json_o = json_decode($responseimp,true);
	
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
				$array = $pos->saveCur($cur_name,$currency_type,$amount,$addresscur,$msisdncur,$out,$transaction_type);
				
			}else{
	
		//echo "<br> Everything failed<br>";
		$array = false;
	}
	
	}
	





if($transaction_type =='buymula' || $transaction_type =='sellmula'){ 

	$curl = curl_init();

curl_setopt_array($curl, array(
  CURLOPT_URL => 'https://www.agrikore.net/'.$currency_type.'/unsafe/tx/{"'."op".'":"'.$transaction_type.'",'.'"from'.'":"'.$addresscur.'",'.'"frompwd'.'":"'.$frompwcur.'",'.'"val'.'":"'.$amount.'"}',
  CURLOPT_RETURNTRANSFER => true,
  CURLOPT_ENCODING => "",
  CURLOPT_MAXREDIRS => 10,
  CURLOPT_TIMEOUT => 30,
  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
  CURLOPT_CUSTOMREQUEST => "POST",
  CURLOPT_HTTPHEADER => array(
    "Cache-Control: no-cache"
  ),
));

$response2 = curl_exec($curl);
$err = curl_error($curl);

curl_close($curl);

if ($err) {
  //$receipt2 = "Connection Error:" . $err;
  $receipt2 = "Connection Error";
} else {

  $newresponse = str_replace('"',"",$response2);
	$receipt2 = str_replace('{}',"",$newresponse);

	//echo "<br> tran_id2 -".$tran_id2;
	//echo "<br> response2 1-".$receipt2;
	//echo "<br> response2 1-".$receiptx;
	
}

// sleep for 10 seconds
sleep(10);

if($receipt2 != '' || $receipt2 != Null || $receipt2 != 'Connection Error'){ 

	$ctr = 1;

	while($ctr++ < 305){//while loop

 $curl = curl_init();
	curl_setopt_array($curl, array(
	CURLOPT_URL => 'https://www.agrikore.net/transactionreceipts/'.$receipt2,
	CURLOPT_RETURNTRANSFER => true,
	CURLOPT_ENCODING => "",
	CURLOPT_MAXREDIRS => 10,
	CURLOPT_TIMEOUT => 30,
	CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
	CURLOPT_CUSTOMREQUEST => "GET",
	CURLOPT_HTTPHEADER => array(
		"Cache-Control: no-cache",
		"x-access-token: $b_token"
	),
	));
	
	$response3 = curl_exec($curl);
	$err = curl_error($curl);
	
	curl_close($curl);

	if ($err) {
	//echo "cURL Error #:" . $err;
	$error3 = "Empty reply from server";
	} else {
	 $echo = $response3;
	}

	//echo "<br> response3 :".$response3;
	//$ctr++;
	if ($response3 != "Cannot find the transaction or it's receipt" || $response3 != "" || $error3 != "Empty reply from server" || substr($response3,0,33) != "Cannot find the transaction or it") {
	break;    /* You could also write 'break 1;' here. */
}
	
}//while loop off
//	echo "<br> response3-out :".$response3;
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
			$array = $pos->saveCur($cur_name,$currency_type,$amount,$addresscur,$msisdncur,$out,$transaction_type);
			
		}else{

	//echo "<br> Everything failed<br>";
	$array = false;
}

}




if($transaction_type =='importtoken'){ 

$curl = curl_init();

curl_setopt_array($curl, array(
  CURLOPT_URL => 'https://www.agrikore.net/'.$currency_type.'/unsafe/ad/{"'."op".'":"'.'importtoken",'.'"admin'.'":"'.'0x2d2d8721fcacb58c7f5f2946bdcc487629da2d64",'.'"adminpwd'.'":"'.'agrikore",'.'"to'.'":"'.$addresscur.'",'.'"val'.'":"'.$amount.'"}',
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

$responseimp = curl_exec($curl);
$err = curl_error($curl);

curl_close($curl);


if ($err) {
  //$receipt2 = "Connection Error:" . $err;
  $receiptimp = "Connection Error";
} else {

  $newresponseimp = str_replace('"',"",$responseimp);
	$receiptimp = str_replace('{}',"",$newresponseimp);

	//echo "<br> tran_id2 -".$tran_id2;
//	echo "<br> response2 1-".$receipt2;
	//echo "<br> response2 1-".$receiptx;
	
}


// sleep for 10 seconds
sleep(10);

if($receiptimp != '' || $receiptimp != Null || $receiptimp != 'Connection Error'){ 

	$ctr = 1;

	while($ctr++ < 305){//while loop

 $curl = curl_init();
	curl_setopt_array($curl, array(
	
	CURLOPT_URL => 'https://www.agrikore.net/transactionreceipts/'.$receiptimp,
	
	CURLOPT_RETURNTRANSFER => true,
	CURLOPT_ENCODING => "",
	CURLOPT_MAXREDIRS => 10,
	CURLOPT_TIMEOUT => 30,
	CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
	CURLOPT_CUSTOMREQUEST => "GET",
	CURLOPT_HTTPHEADER => array(
		"Cache-Control: no-cache",
		"x-access-token: $b_token"
	),
	));
	
	
	$responseimp = curl_exec($curl);
	$err = curl_error($curl);
	
	curl_close($curl);

	if ($err) {
	echo "cURL Error #:" . $err;
	$errorimp = "Empty reply from server";
	} else {
	 $echo = $responseimp;
	}

	//echo "<br> response3 :".$response3;
	//$ctr++;
	if ($responseimp != "Cannot find the transaction or it's receipt" || $responseimp != "" || $errorimp != "Empty reply from server" || substr($responseimp,0,33) != "Cannot find the transaction or it") {
	break;    /* You could also write 'break 1;' here. */
}
	
}//while loop off
	//echo "<br> response3-out :".$responseimp;
 // echo "<br> Reciept query :".$response3."<br>";
	$json_o = json_decode($responseimp,true);

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
			$array = $pos->saveCur($cur_name,$currency_type,$amount,$addresscur,$msisdncur,$out,$transaction_type);
			
		}else{

	//echo "<br> Everything failed<br>";
	$array = false;
}

}

			
			if($transaction_type =='exporttoken'){ 

				$curl = curl_init();
				
				curl_setopt_array($curl, array(
				  CURLOPT_URL => 'https://www.agrikore.net/'.$currency_type.'/unsafe/ad/{"'."op".'":"'.'exporttoken",'.'"admin'.'":"'.'0x2d2d8721fcacb58c7f5f2946bdcc487629da2d64",'.'"adminpwd'.'":"'.'agrikore",'.'"from'.'":"'.$addresscur.'",'.'"val'.'":"'.$amount.'"}',
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
				
				$responseexp = curl_exec($curl);
				$err = curl_error($curl);
				
	//			curl_close($curl);
				
			
if ($err) {
  //$receipt2 = "Connection Error:" . $err;
  $receiptexp = "Connection Error";
} else {

  $newresponseexp = str_replace('"',"",$responseexp);
	$receiptexp = str_replace('{}',"",$newresponseexp);

	//echo "<br> tran_id2 -".$tran_id2;
//	echo "<br> response2 1-".$receipt2;
	//echo "<br> response2 1-".$receiptx;
	
}

// sleep for 10 seconds
sleep(10);

if($receiptexp != '' || $receiptexp != Null || $receiptexp != 'Connection Error'){ 

	$ctr = 1;

	while($ctr++ < 305){//while loop

 //$curl = curl_init();
	curl_setopt_array($curl, array(
	
	CURLOPT_URL => 'https://www.agrikore.net/transactionreceipts/'.$receiptexp,
	
	CURLOPT_RETURNTRANSFER => true,
	CURLOPT_ENCODING => "",
	CURLOPT_MAXREDIRS => 10,
	CURLOPT_TIMEOUT => 30,
	CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
	CURLOPT_CUSTOMREQUEST => "GET",
	CURLOPT_HTTPHEADER => array(
		"Cache-Control: no-cache",
		"x-access-token: $b_token"
	),
	));
	
	
	$responseexp = curl_exec($curl);
	$err = curl_error($curl);
	
	curl_close($curl);

	if ($err) {
	//echo "cURL Error #:" . $err;
	$errorexp = "Empty reply from server";
	} else {
	 $echo = $responseexp;
	}

	//echo "<br> response3 :".$response3;
	//$ctr++;
	if ($responseexp != "Cannot find the transaction or it's receipt" || $responseexp != "" || $errorexp != "Empty reply from server" || substr($responseexp,0,33) != "Cannot find the transaction or it") {
	break;    /* You could also write 'break 1;' here. */
}
	
}//while loop off
	//echo "<br> response3-out :".$responseexp;
 // echo "<br> Reciept query :".$response3."<br>";
	$json_o = json_decode($responseexp,true);

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
			$array = $pos->saveCur($cur_name,$currency_type,$amount,$addresscur,$msisdncur,$out,$transaction_type);
			
		}else{

	//echo "<br> Everything failed<br>";
	$array = false;
}

}


		      if($transaction_type =='transfertoreserve'){ 

								$curl = curl_init();
								
								curl_setopt_array($curl, array(
								  CURLOPT_URL => "https://www.agrikore.net/$currency_type/unsafe/ad/{%22op%22:%22transfertoreserve%22,%22admin%22:%220x2d2d8721fcacb58c7f5f2946bdcc487629da2d64%22,%20%22adminpwd%22:%22agrikore%22,%22from%22:%22$addresscur%22,%22val%22:%22$amount%22}",
								  //'https://www.agrikore.net/'.$currency_type.'/unsafe/ad/{"'."op".'":"'.'transfertoreserve",'.'"admin'.'":"'.'0x2d2d8721fcacb58c7f5f2946bdcc487629da2d64",'.'"adminpwd'.'":"'.'agrikore",'.'"from'.'":"'.$addresscur.'",'.'"val'.'":"'.$amount.'"}',
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
								
								$responsettr = curl_exec($curl);
								$err = curl_error($curl);
								
								curl_close($curl);
								
								if ($err) {
								  $oecho = "cURL Error #:" . $err;
								} else {
								

									$newresponsettr = str_replace('"',"",$responsettr);
									$receiptttr = str_replace('{}',"",$newresponsettr);

									
								}
								
								// sleep for 5 seconds
								sleep(10);
								
								if($receiptttr != '' || $receiptttr != Null || $receiptttr != 'Connection Error'){ 
								
									$ctrttr = 1;
								
									while($ctrttr++ < 105){//while loop
								
								 $curl = curl_init();
									curl_setopt_array($curl, array(
									
									CURLOPT_URL => 'https://www.agrikore.net/transactionreceipts/'.$receiptttr,
									
									CURLOPT_RETURNTRANSFER => true,
									CURLOPT_ENCODING => "",
									CURLOPT_MAXREDIRS => 10,
									CURLOPT_TIMEOUT => 30,
									CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
									CURLOPT_CUSTOMREQUEST => "GET",
									CURLOPT_HTTPHEADER => array(
										"Cache-Control: no-cache",
										"x-access-token: $b_token"
									),
									));
									
									
									$responsettr = curl_exec($curl);
									$err = curl_error($curl);
									
									curl_close($curl);
								
									if ($err) {
									//echo "cURL Error #:" . $err;
									$errorttr = "Empty reply from server";
									} else {
									 $echo = $responsettr;
									}
								
									//echo "<br> response3 :".$response3;
									//$ctrttr++;
									if ($responsettr != "Cannot find the transaction or it's receipt" || $responsettr != "" || $errorttr != "Empty reply from server" || substr($responsettr,0,33) != "Cannot find the transaction or it") {
									break;    /* You could also write 'break 1;' here. */
								}
									
								}//while loop off
								//	echo "<br> response3-out :".$responsettr;
								 // echo "<br> Reciept query :".$response3."<br>";
									$json_o = json_decode($responsettr,true);
								
											$result = array();
											$outttr = "Status :";
								
											foreach ($json_o['events'] as $theentity) {
												$result[] = $theentity['args']['errorCode'];
												$attr = $theentity['args']['errorCode'];
												$cttr = $theentity['contract'];
								
											if ($attr != 100){
												//echo "Successful";
												$outttr .=$cttr."-".$attr."-Error,";
											}else{
												$outttr .=$cttr."-".$attr."-Success,"; 
											}
								
											}
											$array = $pos->saveCur($cur_name,$currency_type,$amount,$addresscur,$msisdncur,$outttr,$transaction_type);
											
										}else{
								
									//echo "<br> Everything failed<br>";
									$array = false;
								}
								
								}
								
			

		      if($transaction_type =='transferfromreserve'){ 

								$curl = curl_init();
								
								curl_setopt_array($curl, array(
								  CURLOPT_URL => 'https://www.agrikore.net/'.$currency_type.'/unsafe/ad/{"'."op".'":"'.'transferfromreserve",'.'"admin'.'":"'.'0x2d2d8721fcacb58c7f5f2946bdcc487629da2d64",'.'"adminpwd'.'":"'.'agrikore",'.'"to'.'":"'.$addresscur.'",'.'"val'.'":"'.$amount.'"}',
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
								
								$responseftr = curl_exec($curl);
								$err = curl_error($curl);
								
								//curl_close($curl);
								
								if ($err) {
								  $oecho = "cURL Error #:" . $err;
								} else {
								
									$newresponseftr = str_replace('"',"",$responseftr);
									$receiptftr = str_replace('{}',"",$newresponseftr);
								
									
								}
								
								// sleep for 10 seconds
								sleep(10);
								
								if($receiptftr != '' || $receiptftr != Null || $receiptftr != 'Connection Error'){ 
								
									$ctrftr = 1;
								
									while($ctrftr++ < 105){//while loop
								
								 //$curl = curl_init();
									curl_setopt_array($curl, array(
									
									CURLOPT_URL => 'https://www.agrikore.net/transactionreceipts/'.$receiptftr,
									
									CURLOPT_RETURNTRANSFER => true,
									CURLOPT_ENCODING => "",
									CURLOPT_MAXREDIRS => 10,
									CURLOPT_TIMEOUT => 30,
									CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
									CURLOPT_CUSTOMREQUEST => "GET",
									CURLOPT_HTTPHEADER => array(
										"Cache-Control: no-cache",
										"x-access-token: $b_token"
									),
									));
									
									
									$responseftr = curl_exec($curl);
									$err = curl_error($curl);
									
									curl_close($curl);
								
									if ($err) {
									//echo "cURL Error #:" . $err;
									$errorftr = "Empty reply from server";
									} else {
									 $echo = $responseftr;
									}
								
									//echo "<br> response3 :".$response3;
									//$ctrftr++;
									if ($responseftr != "Cannot find the transaction or it's receipt" || $responseftr != "" || $errorftr != "Empty reply from server" || substr($responseftr,0,33) != "Cannot find the transaction or it") {
									break;    /* You could also write 'break 1;' here. */
								}
									
								}//while loop off
								//	echo "<br> response3-out :".$responseftr;
								 // echo "<br> Reciept query :".$response3."<br>";
									$json_o = json_decode($responseftr,true);
								
											$result = array();
											$outftr = "Status :";
								
											foreach ($json_o['events'] as $theentity) {
												$result[] = $theentity['args']['errorCode'];
												$aftr = $theentity['args']['errorCode'];
												$cftr = $theentity['contract'];
								
											if ($aftr != 100){
												//echo "Successful";
												$outftr .=$cftr."-".$aftr."-Error,";
											}else{
												$outftr .=$cftr."-".$aftr."-Success,"; 
											}
								
											}
											$array = $pos->saveCur($cur_name,$currency_type,$amount,$addresscur,$msisdncur,$outftr,$transaction_type);
											
										}else{
								
									//echo "<br> Everything failed<br>";
									$array = false;
								}
								
								}
								
									
			

								if($transaction_type =='setcommissionaddress' || $transaction_type =='setcommaddr'){

									$curl = curl_init();
									
									curl_setopt_array($curl, array(
									  CURLOPT_URL => 'https://www.agrikore.net/'.$currency_type.'/unsafe/ad/{"'."op".'":"'.$transaction_type.'",'.'"admin'.'":"'.'0x2d2d8721fcacb58c7f5f2946bdcc487629da2d64",'.'"adminpwd'.'":"'.'agrikore",'.'"commaddr'.'":"'.$addresscur.'"}',
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
										echo "<br> ".$oecho = "cURL Error #:" . $err;
									} else {
									
									  //echo "<br> ". $oecho = $response;
									  $tran_id6 = str_replace('"',"",$response);
									}
									

										// sleep for 10 seconds
								sleep(10);
								 //-----------------Block Import end--------------------------
								 if ($tran_id6 != null || $tran_id6 != ""){
								
									$ctrftr = 1;
								
									while($ctrftr++ < 10){//while loop
								
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
											
									
									$responseftr = curl_exec($curl);
									$err = curl_error($curl);
									
									curl_close($curl);
								
									if ($err) {
									//echo "cURL Error #:" . $err;
									echo "<br> ".$errorftr = "Empty reply from server";
									} else {
										$echo = $responseftr;
									}
								
									//echo "<br> response3 :".$response3;
									//$ctrftr++;
									if ($responseftr != "Cannot find the transaction or it's receipt" || $responseftr != "" || $errorftr != "Empty reply from server" || substr($responseftr,0,33) != "Cannot find the transaction or it") {
									break;    /* You could also write 'break 1;' here. */
								}
									
								}//while loop off
								//	echo "<br> response3-out :".$responseftr;
								 // echo "<br> Reciept query :".$response3."<br>";
									$json_o = json_decode($responseftr,true);
								
											$result = array();
											$outftr = "Status :";
								
											foreach ($json_o['events'] as $theentity) {
												$result[] = $theentity['args']['errorCode'];
												$aftr = $theentity['args']['errorCode'];
												$cftr = $theentity['contract'];
								
											if ($aftr != 100){
												//echo "Successful";
												$outftr .=$cftr."-".$aftr."-Error,";
											}else{
												$outftr .=$cftr."-".$aftr."-Success,"; 
											}
								
											}
											$array = $pos->saveCur($cur_name,$currency_type,$amount,$addresscur,$msisdncur,$outftr,$transaction_type);
											
										}else{
								
									//echo "<br> Everything failed<br>";
									$array = false;
								}
								
								}



								if($transaction_type =='redeemloan' || $currency_type =='agloan' ){ 

									$curl = curl_init();
								
								curl_setopt_array($curl, array(
								  CURLOPT_PORT => "8547",
								  CURLOPT_URL => 'http://41.73.252.237:8547/'.$currency_type.'/unsafe/tx/{"'."op".'":"'.$transaction_type.'",'.'"dealer'.'":"'.$addresscur.'",'.'"dealerpwd'.'":"'.$frompwcur.'",'.'"val'.'":"'.$amount.'"}',
								  CURLOPT_RETURNTRANSFER => true,
								  CURLOPT_ENCODING => "",
								  CURLOPT_MAXREDIRS => 10,
								  CURLOPT_TIMEOUT => 30,
								  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
								  CURLOPT_CUSTOMREQUEST => "POST",
								  CURLOPT_POSTFIELDS => "",
								  CURLOPT_HTTPHEADER => array(
									"x-access-token: $b_token"
								  ),
								));
								
								$response = curl_exec($curl);
								$err = curl_error($curl);
								
								curl_close($curl);
								
								if ($err) {
								  echo "cURL Error #:" . $err;
								} else {
									$response = str_replace('"',"",$response);
								}
								
								sleep(10);
								
								$curl = curl_init();
								
								curl_setopt_array($curl, array(
								  CURLOPT_PORT => "8547",
								  CURLOPT_URL => "http://41.73.252.237:8547/transactionreceipts/$response",
								  CURLOPT_RETURNTRANSFER => true,
								  CURLOPT_ENCODING => "",
								  CURLOPT_MAXREDIRS => 10,
								  CURLOPT_TIMEOUT => 30,
								  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
								  CURLOPT_CUSTOMREQUEST => "GET",
								  CURLOPT_HTTPHEADER => array(
									"Postman-Token: 1fe2eeea-3fea-4d16-981b-8508345a71e2",
									"cache-control: no-cache",
									"x-acess-token: $b_token"
								  ),
								));
								
								$response = curl_exec($curl);
								$err = curl_error($curl);
								
								curl_close($curl);
								
								if ($err) {
								  echo "cURL Error #:" . $err;
								} else {
								   $response;
								}
								
								$json_o = json_decode($response,true);
								
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
									//echo "<br>".$out;
									$array = $pos->saveCur($cur_name,$currency_type,$amount,$addresscur,$msisdncur,$out,$transaction_type);
											
									}	
	





								
								if($transaction_type =='sellmulafor'){ 

									$curl = curl_init();
								
								curl_setopt_array($curl, array(
								  CURLOPT_PORT => "8547",
								  CURLOPT_URL => 'http://41.73.252.237:8547/'.$currency_type.'/unsafe/ad/{"'."op".'":"'.$transaction_type.'",'.'"admin'.'":"'.'0x2d2d8721fcacb58c7f5f2946bdcc487629da2d64",'.'"adminpwd'.'":"'.'agrikore",'.'"addr'.'":"'.$addresscur.'",'.'"val'.'":"'.$amount.'"}',
								  CURLOPT_RETURNTRANSFER => true,
								  CURLOPT_ENCODING => "",
								  CURLOPT_MAXREDIRS => 10,
								  CURLOPT_TIMEOUT => 30,
								  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
								  CURLOPT_CUSTOMREQUEST => "POST",
								  CURLOPT_POSTFIELDS => "",
								  CURLOPT_HTTPHEADER => array(
									"x-access-token: $b_token"
								  ),
								));
								
								$response = curl_exec($curl);
								$err = curl_error($curl);
								
								curl_close($curl);
								
								if ($err) {
								  echo "cURL Error #:" . $err;
								} else {
									$response = str_replace('"',"",$response);
								}
								
								sleep(10);
								
								$curl = curl_init();
								
								curl_setopt_array($curl, array(
								  CURLOPT_PORT => "8547",
								  CURLOPT_URL => "http://41.73.252.237:8547/transactionreceipts/$response",
								  CURLOPT_RETURNTRANSFER => true,
								  CURLOPT_ENCODING => "",
								  CURLOPT_MAXREDIRS => 10,
								  CURLOPT_TIMEOUT => 30,
								  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
								  CURLOPT_CUSTOMREQUEST => "GET",
								  CURLOPT_HTTPHEADER => array(
									"Postman-Token: 1fe2eeea-3fea-4d16-981b-8508345a71e2",
									"cache-control: no-cache",
									"x-acess-token: $b_token"
								  ),
								));
								
								$response = curl_exec($curl);
								$err = curl_error($curl);
								
								curl_close($curl);
								
								if ($err) {
								  echo "cURL Error #:" . $err;
								} else {
								   $response;
								}
								
								$json_o = json_decode($response,true);
								
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
									//echo "<br>".$out;
									$array = $pos->saveCur($cur_name,$currency_type,$amount,$addresscur,$msisdncur,$out,$transaction_type);
											
									}	
	
if($transaction_type =='buymulafor'){ 

	$curl = curl_init();

curl_setopt_array($curl, array(
	CURLOPT_PORT => "8547",
  CURLOPT_URL => 'http://41.73.252.237:8547/'.$currency_type.'/unsafe/ad/{"'."op".'":"'.$transaction_type.'",'.'"admin'.'":"'.'0x2d2d8721fcacb58c7f5f2946bdcc487629da2d64",'.'"adminpwd'.'":"'.'agrikore",'.'"addr'.'":"'.$addresscur.'",'.'"val'.'":"'.$amount.'"}',
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

$responsem4 = curl_exec($curl);
$err = curl_error($curl);

curl_close($curl);

if ($err) {
  //$receipt2 = "Connection Error:" . $err;
  $receiptm4 = "Connection Error";
} else {

  $newresponsem4 = str_replace('"',"",$responsem4);
	//echo "<br> ".
	$receiptm4 = str_replace('{}',"",$newresponsem4);

	//echo "<br> tran_id2 -".$tran_id2;
	//echo "<br> response2 1-".$receipt2;
	//echo "<br> response2 1-".$receiptx;
	
}

// sleep for 10 seconds
sleep(20);

if($receiptm4 != '' || $receiptm4 != Null || $receiptm4 != 'Connection Error'){ 

	$ctr = 1;

	while($ctr++ < 25){//while loop

 $curl = curl_init();
	curl_setopt_array($curl, array(
	
	CURLOPT_URL => 'https://www.agrikore.net/transactionreceipts/'.$receiptm4,
	//CURLOPT_URL => 'https://www.agrikore.net/transactionreceipts/'.$receiptm4.'/',
	CURLOPT_RETURNTRANSFER => true,
	CURLOPT_ENCODING => "",
	CURLOPT_MAXREDIRS => 10,
	CURLOPT_TIMEOUT => 30,
	CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
	CURLOPT_CUSTOMREQUEST => "GET",
	CURLOPT_HTTPHEADER => array(
		"Cache-Control: no-cache",
		"x-access-token: $b_token"
	),
	));
	
	
	$responsem4 = curl_exec($curl);
	$err = curl_error($curl);
	
	curl_close($curl);

	if ($err) {
	//echo "cURL Error #:" . $err;
	$errorm4 = "Empty reply from server";
	} else {
		//echo "<br> ". 
		$echo = $responsem4;
	}

	//echo "<br> response3 :".$response3;
	//$ctr++;
	if ($responsem4 != "Cannot find the transaction or it's receipt" || $responsem4 != "" || $errorm4 != "Empty reply from server" || substr($responsem4,0,33) != "Cannot find the transaction or it") {
	break;    /* You could also write 'break 1;' here. */
}
	
}//while loop off
//	echo "<br> response3-out :".$responsem4;
 // echo "<br> Reciept query :".$response3."<br>";
	$json_o = json_decode($responsem4,true);

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
			$array = $pos->saveCur($cur_name,$currency_type,$amount,$addresscur,$msisdncur,$out,$transaction_type);
			
		}else{

	//echo "<br> Everything failed<br>";
	$array = false;
}

}


			if($array[0] == true)

			{

							$result['id_cur'] = $array[2];
			}
		}
		
	
		else
		{
			$array = $pos->updateCur($idcur,$cur_name,$currency_type,$amount,$addresscur,$msisdncur);
		}
		$result['result'] = $array[0];
		$result['error'] = $array[1];
		$result['crud'] = $_POST['crud'];
		echo json_encode($result);
	}
	
	if($method == 'getdata'){
		$pos = new pos();
		$array = $pos->getListCur();
		$data = $array[1];
		$i=0;
		foreach ($data as $key) {
			$button = '<button  type="submit" id_cur="'.$key['id_cur'].'"  title="Tombol edit barang" class="btn btn-sm btn-primary btneditcur "  id="btneditcur'.$key['id_cur'].'"  ><i class="fa fa-edit"></i></button> <button  type="submit" id_cur="'.$key['id_cur'].'"  title="Tombol hapus barang" class="btn btn-danger btn-sm btndeletecur "  id="btndeletecur'.$key['id_cur'].'"  ><i class="fa fa-trash"></i></button>';

			$data[$i]['cur_name'] =  $data[$i]['cur_name'];
			//$data[$i]['fprice'] =  number_format($data[$i]['fprice']);
			$data[$i]['DT_RowId']= $data[$i]['id_cur'];
			$data[$i]['currency_type']= $data[$i]['currency_type'];
			//$data[$i]['terms']= number_format($data[$i]['terms']);
			$data[$i]['button'] = $button;
			$i++;
		}
		$datax = array('data' => $data);
		echo json_encode($datax);
	}
	if($method == 'delete_cur'){
		$id_cur=$_POST['id_cur'];
		$pos = new pos();
		$array = $pos->deletecur($id_cur);
		$data['result'] = $array[0];
		$data['error'] = $array[1];
		echo json_encode($data);
	}
	
} else {
	exit('No direct access allowed.');
}
