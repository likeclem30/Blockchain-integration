<?php
session_start();
require_once ("../model/dbconn.php");
require_once ("../model/pos.php");
include('db.php');
if( isset( $_SERVER['HTTP_X_REQUESTED_WITH'] ) && ( $_SERVER['HTTP_X_REQUESTED_WITH'] == 'XMLHttpRequest' ) )
{


	if (isset($_POST['wphoneoff_id'])) {

		$xphoneoff_id = $_POST['wphoneoff_id'];
	
		$qry = "select b_address as b_addressoff from m_user where wphone= $xphoneoff_id";
		$res = mysqli_query($con, $qry);
		if(mysqli_num_rows($res) > 0) {
			echo '<option value="">------- Select -------</option>';
			while($row = mysqli_fetch_object($res)) {
				echo '<option value="'.$row->b_addressoff.'">'.$row->b_addressoff.'</option>';
			}
		} else {
			echo '<option value="">No Record</option>';
		}
	
	} 








	$pos = new pos();
	$method=$_POST['method'];
	if($method == 'get_detail_off')
	{
		$id_off=$_POST['id_off'];
		$pos = new pos();
		$data = $pos->getOff($id_off);
		$array['data'] = $data[1];
		$array['result'] = $data[0];
		echo json_encode($array);
	}
	if($method == 'save_off')
	{
		$idoff = $_POST['id_off'];
		$nameoff = str_replace(" ","%20",$_POST['off_name']);
		$loc_name = str_replace(" ","%20",$_POST['loc_name']); 
		$receipt_limit= preg_replace('/[^A-Za-z0-9\. -]/', '', ($_POST['receipt_limit'] * 1000000000000000000));
		//$receipt_limit= $_POST['receipt_limit'] * 1000000000000000000;
		$receipt_limitx = $_POST['receipt_limit'];
		$transaction_type = $_POST['transaction_type'];
		$generic_role_type = str_replace(" ","",$_POST['generic_role_type']); 
		$frate = $_POST['frate'] * 1000000000000000000;
		$prate = $_POST['prate'] * 1000000000000000000;
		$addressoff = $_POST['addressoff'];
		$msisdnoff = $_POST['msisdnoff'];
		$crud=$_POST['crud'];
		$pos = new pos();
		if($_POST['crud'] == 'N')
		{

		   
			$tpos = new pos();
			$block = $tpos->getblockadd($_SESSION['pos_username']);
			$walletno = $block[1]['wphone'];
			$wallet_address = $block[1]['b_address'];
			$b_token = $block[1]['b_token'];



			 
			if($transaction_type == 'addgenericrole'){

				echo "<br> gen type: ".$generic_role_type;


				$curl = curl_init();

curl_setopt_array($curl, array(
  CURLOPT_URL => "https://www.agrikore.net/grole/unsafe/ad/{%22op%22:%22addgenericrole%22,%22admin%22:%220x2d2d8721fcacb58c7f5f2946bdcc487629da2d64%22,%22adminpwd%22:%22agrikore%22,%22typeid%22:%22$generic_role_type%22,%22addr%22:%22$addressoff%22,%20%22name%22:%22%20$nameoff%20%22,%20%22loc%22:%22$loc_name%22,%20%22fixrate%22:%22$frate%22,%20%22percentrate%22:%22$prate%22}",
  CURLOPT_RETURNTRANSFER => true,
  CURLOPT_ENCODING => "",
  CURLOPT_MAXREDIRS => 10,
  CURLOPT_TIMEOUT => 30,
  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
  CURLOPT_CUSTOMREQUEST => "POST",
  CURLOPT_HTTPHEADER => array(
    "Cache-Control: no-cache",
    "Postman-Token: 9273152e-4590-43ef-83e9-1bcf28b66130"
  ),
));

$responsegenr = curl_exec($curl);
$err = curl_error($curl);

curl_close($curl);

if ($err) {
  echo "cURL Error #:" . $err;
} else {
 
					$receiptgenr = str_replace('"',"",$responsegenr);
					//echo "<br> addgenericrole receipt:".
				}
			   
				// sleep for 10 seconds
				   sleep(5);
				   
				 // if($receiptgenr != '' || $receiptgenr != Null){ 
  
					  $ctr = 1;
	  
					  while($ctr++ < 105){//while loop
	  
				   $curl = curl_init();
					  curl_setopt_array($curl, array(
					  
					  CURLOPT_URL => 'https://www.agrikore.net/transactionreceipts/'.$receiptgenr.'/',
					  
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
						  
							  $array = $pos->saveOff($nameoff,$loc_name,$receipt_limitx,$frate,$prate,$transaction_type,$generic_role_type,$addressoff,$msisdnoff,$out);
						 

			}
			
			
			if($transaction_type == 'addofftaker1'){

			$curl = curl_init();

			 curl_setopt_array($curl, array(
				CURLOPT_URL => "https://www.agrikore.net/offtaker/unsafe/ad/{%22op%22:%22addofftaker%22,%22admin%22:%220x2d2d8721fcacb58c7f5f2946bdcc487629da2d64%22,%22adminpwd%22:%22agrikore%22,%22addr%22:%22$addressoff%22,%22name%22:%22$nameoff%22,%22loc%22:%22$loc_name%22,%22rplmt%22:%22$receipt_limit%22,%22fixrate%22:%22$frate%22,%22percentrate%22:%22$prate%22}",
				//'https://www.agrikore.net/offtaker/unsafe/ad/{"'."op".'":"'.'addofftaker",'.'"admin'.'":"'.'0x2d2d8721fcacb58c7f5f2946bdcc487629da2d64",'.'"adminpwd'.'":"'.'agrikore",'.'"addr'.'":"'.$addressoff.'",'.'"name'.'":"'.$nameoff.'",'.'"loc'.'":"'.$loc_name.'",'.'"rplmt'.'":"'.$receipt_limit.'",'.'"fixrate'.'":"'.$frate.'",'.'"percentagerate'.'":"'.$prate.'"}',
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
				//echo "<br> addofftaker".
			  $echo = "cURL Error #:" . $err;
			 } else {
			   //echo $response2;
			   //echo "<br> addofftaker receipt".
			   $receipt2 = str_replace('"',"",$response2);
			  }
			 
			  // sleep for 10 seconds
			  sleep(10);

				//if($receipt2 != '' || $receipt2 != Null){ 

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
						$echo = "cURL Error #:" . $err;
						//echo "<br> receipt ".
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
						
							$array = $pos->saveOff($nameoff,$loc_name,$receipt_limitx,$frate,$prate,$transaction_type,$generic_role_type,$addressoff,$msisdnoff,$out);
						
			}


			if($transaction_type == 'addlogistics'){

				$curl = curl_init();
	
				 curl_setopt_array($curl, array(
					CURLOPT_URL => "https://www.agrikore.net/logistics/unsafe/ad/{%22op%22:%22addlogistics%22,%22admin%22:%220x2d2d8721fcacb58c7f5f2946bdcc487629da2d64%22,%22adminpwd%22:%22agrikore%22,%22addr%22:%22$addressoff%22,%20%22name%22:%22$nameoff%22,%20%22loc%22:%22$loc_name%22,%20%22fixrate%22:%22$frate%22,%20%22percentrate%22:%22$prate%22}",
					//"https://www.agrikore.net/logistics/unsafe/ad/{%22op%22:%22addlogistics%22,%22admin%22:%220x2d2d8721fcacb58c7f5f2946bdcc487629da2d64%22,%22adminpwd%22:%22agrikore%22,%22addr%22:%22$addressoff%22,%22name%22:%22$nameoff%22,%22loc%22:%22$loc_name%22,%22fixrate%22:%22$frate%22,%22percentrate%22:%22$prate%22}",
					//'https://www.agrikore.net/offtaker/unsafe/ad/{"'."op".'":"'.'addofftaker",'.'"admin'.'":"'.'0x2d2d8721fcacb58c7f5f2946bdcc487629da2d64",'.'"adminpwd'.'":"'.'agrikore",'.'"addr'.'":"'.$addressoff.'",'.'"name'.'":"'.$nameoff.'",'.'"loc'.'":"'.$loc_name.'",'.'"fixrate'.'":"'.$frate.'",'.'"percentagerate'.'":"'.$prate.'"}',
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
					//echo "<br> addofftaker".
				  $echo = "cURL Error #:" . $err;
				 } else {
				   //echo $response2;
				   //echo "<br> addofftaker receipt".
				   $receipt2 = str_replace('"',"",$response2);
				  }
				 
				  // sleep for 10 seconds
				  sleep(10);
	
					//if($receipt2 != '' || $receipt2 != Null){ 
	
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
							$echo = "cURL Error #:" . $err;
							//echo "<br> receipt ".
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
							
								$array = $pos->saveOff($nameoff,$loc_name,$receipt_limitx,$frate,$prate,$transaction_type,$generic_role_type,$addressoff,$msisdnoff,$out);
							
				}

				if($transaction_type == 'addinsurer'){

					$curl = curl_init();
		
					 curl_setopt_array($curl, array(
						CURLOPT_URL => "https://www.agrikore.net/insurer/unsafe/ad/{%22op%22:%22addinsurer%22,%22admin%22:%220x2d2d8721fcacb58c7f5f2946bdcc487629da2d64%22,%22adminpwd%22:%22agrikore%22,%22addr%22:%22$addressoff%22,%20%22name%22:%22$nameoff%22,%20%22loc%22:%22$loc_name%22,%20%22fixrate%22:%22$frate%22,%20%22percentrate%22:%22$prate%22}",
						//"https://www.agrikore.net/insurer/unsafe/ad/{%22op%22:%22addinsurer%22,%22admin%22:%220x2d2d8721fcacb58c7f5f2946bdcc487629da2d64%22,%22adminpwd%22:%22agrikore%22,%22addr%22:%22$addressoff%22,%20%22name%22:%22$nameoff%22,%20%22loc%22:%22$loc_name%22,%20%22fixrate%22:%22$frate%22,%20%22percentrate%22:%22$prate%22}",
						//"https://www.agrikore.net/logistics/unsafe/ad/{%22op%22:%22addlogistics%22,%22admin%22:%220x2d2d8721fcacb58c7f5f2946bdcc487629da2d64%22,%22adminpwd%22:%22agrikore%22,%22addr%22:%22$addressoff%22,%22name%22:%22$nameoff%22,%22loc%22:%22$loc_name%22,%22fixrate%22:%22$frate%22,%22percentrate%22:%22$prate%22}",
						//'https://www.agrikore.net/offtaker/unsafe/ad/{"'."op".'":"'.'addofftaker",'.'"admin'.'":"'.'0x2d2d8721fcacb58c7f5f2946bdcc487629da2d64",'.'"adminpwd'.'":"'.'agrikore",'.'"addr'.'":"'.$addressoff.'",'.'"name'.'":"'.$nameoff.'",'.'"loc'.'":"'.$loc_name.'",'.'"fixrate'.'":"'.$frate.'",'.'"percentagerate'.'":"'.$prate.'"}',
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
						//echo "<br> addofftaker".
					  $echo = "cURL Error #:" . $err;
					 } else {
					   //echo $response2;
					   //echo "<br> addofftaker receipt".
					   $receipt2 = str_replace('"',"",$response2);
					  }
					 
					  // sleep for 10 seconds
					  sleep(10);
		
						//if($receipt2 != '' || $receipt2 != Null){ 
		
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
								$echo = "cURL Error #:" . $err;
								//echo "<br> receipt ".
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
								
									$array = $pos->saveOff($nameoff,$loc_name,$receipt_limitx,$frate,$prate,$transaction_type,$generic_role_type,$addressoff,$msisdnoff,$out);
								
					}
				
					if($transaction_type == 'addoperator'){

						$curl = curl_init();
			
						 curl_setopt_array($curl, array(
							CURLOPT_URL => "https://www.agrikore.net/operator/unsafe/ad/{%22op%22:%22addoperator%22,%22admin%22:%220x2d2d8721fcacb58c7f5f2946bdcc487629da2d64%22,%22adminpwd%22:%22agrikore%22,%22addr%22:%22$addressoff%22,%20%22name%22:%22$nameoff%22,%20%22loc%22:%22$loc_name%22,%20%22fixrate%22:%22$frate%22,%20%22percentrate%22:%22$prate%22}",
							//"https://www.agrikore.net/insurer/unsafe/ad/{%22op%22:%22addinsurer%22,%22admin%22:%220x2d2d8721fcacb58c7f5f2946bdcc487629da2d64%22,%22adminpwd%22:%22agrikore%22,%22addr%22:%22$addressoff%22,%20%22name%22:%22$nameoff%22,%20%22loc%22:%22$loc_name%22,%20%22fixrate%22:%22$frate%22,%20%22percentrate%22:%22$prate%22}",
							//"https://www.agrikore.net/logistics/unsafe/ad/{%22op%22:%22addlogistics%22,%22admin%22:%220x2d2d8721fcacb58c7f5f2946bdcc487629da2d64%22,%22adminpwd%22:%22agrikore%22,%22addr%22:%22$addressoff%22,%22name%22:%22$nameoff%22,%22loc%22:%22$loc_name%22,%22fixrate%22:%22$frate%22,%22percentrate%22:%22$prate%22}",
							//'https://www.agrikore.net/offtaker/unsafe/ad/{"'."op".'":"'.'addofftaker",'.'"admin'.'":"'.'0x2d2d8721fcacb58c7f5f2946bdcc487629da2d64",'.'"adminpwd'.'":"'.'agrikore",'.'"addr'.'":"'.$addressoff.'",'.'"name'.'":"'.$nameoff.'",'.'"loc'.'":"'.$loc_name.'",'.'"fixrate'.'":"'.$frate.'",'.'"percentagerate'.'":"'.$prate.'"}',
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
							//echo "<br> addofftaker".
						  $echo = "cURL Error #:" . $err;
						 } else {
						   //echo $response2;
						   //echo "<br> addofftaker receipt".
						   $receipt2 = str_replace('"',"",$response2);
						  }
						 
						  // sleep for 10 seconds
						  sleep(10);
			
							//if($receipt2 != '' || $receipt2 != Null){ 
			
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
									$echo = "cURL Error #:" . $err;
									//echo "<br> receipt ".
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
									
										$array = $pos->saveOff($nameoff,$loc_name,$receipt_limitx,$frate,$prate,$transaction_type,$generic_role_type,$addressoff,$msisdnoff,$out);
									
						}
					
			
						if($array[0] == true)
			{
				$result['id_off'] = $array[2];
			}
			
		}
		else
		{
			$array = $pos->updateOff($idoff,$nameoff,$loc_name,$receipt_limitx,$frate,$prate,$transaction_type,$generic_role_type,$addressoff,$msisdnoff);
		}
		$result['result'] = $array[0];
		$result['error'] = $array[1];
		$result['crud'] = $_POST['crud'];
		echo json_encode($result);
	}
	
	if($method == 'getdata'){
		$pos = new pos();
		$array = $pos->getListOff();
		$data = $array[1];
		$i=0;
		foreach ($data as $key) {
			$button = '<button  type="submit" id_off="'.$key['id_off'].'"  title="Tombol edit barang" class="btn btn-sm btn-primary btneditoff "  id="btneditoff'.$key['id_off'].'"  ><i class="fa fa-edit"></i></button> <button  type="submit" id_off="'.$key['id_off'].'"  title="Tombol hapus barang" class="btn btn-danger btn-sm btndeleteoff "  id="btndeleteoff'.$key['id_off'].'"  ><i class="fa fa-trash"></i></button>';

			$data[$i]['off_name'] =  $data[$i]['off_name'];
			//$data[$i]['fprice'] =  number_format($data[$i]['fprice']);
			$data[$i]['DT_RowId']= $data[$i]['id_off'];
			$data[$i]['loc_name']= $data[$i]['loc_name'];
			//$data[$i]['terms']= number_format($data[$i]['terms']);
			$data[$i]['button'] = $button;
			$i++;
		}
		$datax = array('data' => $data);
		echo json_encode($datax);
	}
	if($method == 'delete_off'){
		$id_off=$_POST['id_off'];
		$pos = new pos();
		$array = $pos->deleteoff($id_off);
		$data['result'] = $array[0];
		$data['error'] = $array[1];
		echo json_encode($data);
	}
	
} else {
	exit('No direct access allowed.');
}