<?php
session_start();
require_once ("../model/dbconn.php");
require_once ("../model/pos.php");
include('db.php');
if( isset( $_SERVER['HTTP_X_REQUESTED_WITH'] ) && ( $_SERVER['HTTP_X_REQUESTED_WITH'] == 'XMLHttpRequest' ) )
{
	

	if (isset($_POST['wphonepre_id'])) {

		$xphonepre_id = $_POST['wphonepre_id'];
	
		$qry = "select b_address as b_addresspre from m_user where wphone= $xphonepre_id";
		$res = mysqli_query($con, $qry);
		if(mysqli_num_rows($res) > 0) {
			echo '<option value="">------- Select -------</option>';
			while($row = mysqli_fetch_object($res)) {
				echo '<option value="'.$row->b_addresspre.'">'.$row->b_addresspre.'</option>';
			}
		} else {
			echo '<option value="">No Record</option>';
		}
	
    } 
    
    if (isset($_POST['b_addresspre'])) {

        $xphonepre_idx = $_POST['b_addresspre'];
        
        $qry = "select order_address as b_addressprex from m_request where addressreq = '$xphonepre_idx'";
	
		//$qry = "select b_address as b_addressprex from m_user where b_address = '$xphonepre_idx'";
		$res = mysqli_query($con, $qry);
		if(mysqli_num_rows($res) > 0) {
			echo '<option value="">------- Select -------</option>';
			while($row = mysqli_fetch_object($res)) {
				echo '<option value="'.$row->b_addressprex.'">'.$row->b_addressprex.'</option>';
			}
		} else {
			echo '<option value="">No Record</option>';
		}
	
	} 


    if (isset($_POST['offwphonepre_id'])) {

        $xoffwphonepre_id = $_POST['offwphonepre_id'];
        
        
	
		$qry = "select b_address as offb_addresspre from m_user where wphone= $xoffwphonepre_id";
		$res = mysqli_query($con, $qry);
		if(mysqli_num_rows($res) > 0) {
			echo '<option value="">------- Select -------</option>';
			while($row = mysqli_fetch_object($res)) {
				echo '<option value="'.$row->offb_addresspre.'">'.$row->offb_addresspre.'</option>';
			}
		} else {
			echo '<option value="">No Record</option>';
		}
	
    } 


	if (isset($_POST['farwphonepre_id'])) {

        $xfarwphonepre_id = $_POST['farwphonepre_id'];
        
        
	
		$qry = "select b_address as farb_addresspre from m_user where wphone= $xfarwphonepre_id";
		$res = mysqli_query($con, $qry);
		if(mysqli_num_rows($res) > 0) {
			echo '<option value="">------- Select -------</option>';
			while($row = mysqli_fetch_object($res)) {
				echo '<option value="'.$row->farb_addresspre.'">'.$row->farb_addresspre.'</option>';
			}
		} else {
			echo '<option value="">No Record</option>';
		}
	
    } 





	
	
	
	
	
	
	
	$pos = new pos();
	$method=$_POST['method'];
	if($method == 'get_detail_pre')
	{
		$id_pre=$_POST['id_pre'];
		$pos = new pos();
		$data = $pos->getPre($id_pre);
		$array['data'] = $data[1];
		$array['result'] = $data[0];
		echo json_encode($array);
	}
	if($method == 'save_pre')
	{

		$idpre = $_POST['id_pre'];
		$pre_name = $_POST['pre_name'];
		$transaction_type = $_POST['transaction_type'];
		$msisdnpre = $_POST['msisdnpre'];
		$addresspre = $_POST['addresspre'];
		$offmsisdnpre = $_POST['offmsisdnpre'];
		$offaddresspre = $_POST['offaddresspre'];
		$farmsisdnpre = $_POST['farmsisdnpre'];
		$faraddresspre = $_POST['faraddresspre'];
		$order_address = $_POST['order_address'];
		$passpre = md5($_POST['passpre']);
		$terms = $_POST['terms'];
		$quantity = $_POST['quantity'];
		$amount = $_POST['amount']*1000000000000000000;
		$crud=$_POST['crud'];
		$pos = new pos();
		if($_POST['crud'] == 'N')
		{
			$order_rpt_address = 0;
			$outprt=0;
			$outprtd =0;

//--------------------Block import------

$tpos = new pos();
$block = $tpos->getblockadd($_SESSION['pos_username']);
$walletno = $block[1]['wphone'];
$wallet_address = $block[1]['b_address'];
$b_token = $block[1]['b_token'];

//---------------------Block begins------------------------
$t1pos = new pos();
$block1 = $t1pos->getblockpass($msisdnpre);
//$walletno1 = $block1[1]['wphone'];
//$wallet_address1 = $block1[1]['b_address'];
//$b_token1 = $block1[1]['b_token'];
$u_pass1 = $block1[1]['pass'];


if($transaction_type =='addpreceipt'){ 


$qry = "SELECT IFNULL(id_pre, 'RE000x') val FROM m_p_receipt order by id_pre DESC limit 1";
$res = mysqli_query($con, $qry);
if(mysqli_num_rows($res) > 0) {
	//echo '<option value="">------- Select -------</option>';
	while($row = mysqli_fetch_object($res)) {
		 
		$val1 = $row->val;
	}
} else {
	    $val1 = 'RE000x';
}



$bytes = random_bytes(15);

$debug = var_export(bin2hex($bytes), true);

$orderrptaddrx = str_replace("'","",$debug);

$orderrptaddr ="0x".$orderrptaddrx;






$curl = curl_init();

curl_setopt_array($curl, array(
  CURLOPT_URL => 'https://www.agrikore.net/mula/vw/{"'."op".'":"'.'getbal",'.'"addr'.'":"'.$offaddresspre.'"}',
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

$responsebal = curl_exec($curl);
$err = curl_error($curl);

curl_close($curl);

if ($err) {
  echo "cURL Error #:" . $err;
} else {
  //echo $response;
  $bal = str_replace('"'," ",$responsebal);
  //echo "<br> Form id ".$idpre;
}




//if($transaction_type =='addpreceipt'){ 

	$curl = curl_init();
	
	curl_setopt_array($curl, array(
	  CURLOPT_URL => 'https://www.agrikore.net/preceipt/unsafe/tx/{"'."op".'":"'.'addpreceipt",'.'"order'.'":"'.$order_address.'",'.'"receipt'.'":"'.$orderrptaddr.'",'.'"offtaker'.'":"'.$offaddresspre.'",'.'"offtakerpwd'.'":"'.$passpre.'",'.'"issuedto'.'":"'.$faraddresspre.'",'.'"value'.'":"'.$amount.'"}',
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
		CURLOPT_TIMEOUT => 200,
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
				$outpre = "Status :";
	
				foreach ($json_o['events'] as $theentity) {
					$result[] = $theentity['args']['errorCode'];
					$a = $theentity['args']['errorCode'];
					$c = $theentity['contract'];
	
				if ($a != 100){
					//echo "Successful";
					$outpre .=$c."-".$a."-Error,";
				}else{
					$outpre .=$c."-".$a."-Success,"; 
				}
	
				}
				//$outpred = 13;
				//$array = $pos->savePre($pre_name,$msisdnpre,$addresspre,$order_address,$offmsisdnpre,$offaddresspre,$farmsisdnpre,$faraddresspre,$passpre,$terms,$quantity,$amount,$orderrptaddr,$outpre,$outpred);
				
			}else{
	
		//echo "<br> Everything failed<br>";
		$array = false;
	}
	
	$curl = curl_init();
	
	curl_setopt_array($curl, array(
	  CURLOPT_URL => 'https://www.agrikore.net/preceipt/unsafe/tx/{"'."op".'":"'.'addpreceiptdetails",'.'"order'.'":"'.$order_address.'",'.'"receipt'.'":"'.$orderrptaddr.'",'.'"offtaker'.'":"'.$offaddresspre.'",'.'"offtakerpwd'.'":"'.$passpre.'",'.'"issuedto'.'":"'.$faraddresspre.'",'.'"value'.'":"'.$amount.'",'.'"quantity'.'":"'.$quantity.'",'.'"term'.'":"'.$terms.'"}',
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
	
	$responsepred = curl_exec($curl);
	$err = curl_error($curl);
	
	curl_close($curl);
	
	
	if ($err) {
	  //$receipt2 = "Connection Error:" . $err;
	  $receiptpred = "Connection Error";
	} else {
	
	  $newresponsepred = str_replace('"',"",$responsepred);
		$receiptpred = str_replace('{}',"",$newresponsepred);
	
		//echo "<br> tran_id2 -".$tran_id2;
	//	echo "<br> response2 1-".$receipt2;
		//echo "<br> response2 1-".$receiptx;
		
	}
	
	
	// sleep for 10 seconds
	sleep(10);
	
	if($receiptpred != '' || $receiptpred != Null || $receiptpred != 'Connection Error'){ 
	
		$ctr = 1;
	
		while($ctr++ < 305){//while loop
	
	 $curl = curl_init();
		curl_setopt_array($curl, array(
		
		CURLOPT_URL => 'https://www.agrikore.net/transactionreceipts/'.$receiptpred,
		
		CURLOPT_RETURNTRANSFER => true,
		CURLOPT_ENCODING => "",
		CURLOPT_MAXREDIRS => 10,
		CURLOPT_TIMEOUT => 200,
		CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
		CURLOPT_CUSTOMREQUEST => "GET",
		CURLOPT_HTTPHEADER => array(
			"Cache-Control: no-cache",
			"x-access-token: $b_token"
		),
		));
		
		
		$responsepred = curl_exec($curl);
		$err = curl_error($curl);
		
		curl_close($curl);
	
		if ($err) {
		echo "cURL Error #:" . $err;
		$errorpred = "Empty reply from server";
		} else {
		 $echo = $responsepred;
		}
	
		//echo "<br> response3 :".$response3;
		//$ctr++;
		if ($responsepred != "Cannot find the transaction or it's receipt" || $responsepred != "" || $errorpred != "Empty reply from server" || substr($responsepred,0,33) != "Cannot find the transaction or it") {
		break;    /* You could also write 'break 1;' here. */
	}
		
	}//while loop off
		//echo "<br> response3-out :".$responsepred;
	 // echo "<br> Reciept query :".$response3."<br>";
		$json_o = json_decode($responsepred,true);
	
				$result = array();
				$outpred = "Status :";
	
				foreach ($json_o['events'] as $theentity) {
					$result[] = $theentity['args']['errorCode'];
					$a = $theentity['args']['errorCode'];
					$c = $theentity['contract'];
	
				if ($a != 100){
					//echo "Successful";
					$outpred .=$c."-".$a."-Error,";
				}else{
					$outpred .=$c."-".$a."-Success,"; 
				}
	
				}
				
				$array = $pos->savePre($pre_name,$transaction_type,$msisdnpre,$addresspre,$order_address,$offmsisdnpre,$offaddresspre,$farmsisdnpre,$faraddresspre,$passpre,$terms,$quantity,$amount,$orderrptaddr,$outpre,$outpred);
				
			}else{
	
		//echo "<br> Everything failed<br>";
		$array = false;
	}
	
}



if($transaction_type =='addinsurer1' || $transaction_type =='removeinsurer'){ 

	$opkey = str_replace("1","",$transaction_type);

	$curl = curl_init();
	
	curl_setopt_array($curl, array(
	  CURLOPT_URL => 'http://41.73.252.237:8546/preceipt/unsafe/ad/{"'."op".'":"'.$opkey.'",'.'"admin'.'":"'.'0x2d2d8721fcacb58c7f5f2946bdcc487629da2d64",'.'"adminpwd'.'":"'.'agrikore",'.'"order'.'":"'.$order_address.'",'.'"receipt'.'":"'.$orderrptaddr.'",'.'"insurer'.'":"'.$faraddresspre.'"}',
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
		CURLOPT_TIMEOUT => 200,
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
                $outpred = "nill";
				$array = $pos->savePre($pre_name,$transaction_type,$msisdnpre,$addresspre,$order_address,$offmsisdnpre,$offaddresspre,$farmsisdnpre,$faraddresspre,$passpre,$terms,$quantity,$amount,$orderrptaddr,$out,$outpred);
				
			}else{
	
		//echo "<br> Everything failed<br>";
		$array = false;
	}
	
	}
	
	if($transaction_type =='addlogistics1' || $transaction_type =='removelogistics'){ 

		$opkey = str_replace("1","",$transaction_type);
	
		$curl = curl_init();
		
		curl_setopt_array($curl, array(
		  CURLOPT_URL => 'http://41.73.252.237:8546/preceipt/unsafe/ad/{"'."op".'":"'.$opkey.'",'.'"admin'.'":"'.'0x2d2d8721fcacb58c7f5f2946bdcc487629da2d64",'.'"adminpwd'.'":"'.'agrikore",'.'"order'.'":"'.$order_address.'",'.'"receipt'.'":"'.$orderrptaddr.'",'.'"logistics'.'":"'.$faraddresspre.'"}',
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
			CURLOPT_TIMEOUT => 200,
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
					$outpred = "nill";
					$array = $pos->savePre($pre_name,$transaction_type,$msisdnpre,$addresspre,$order_address,$offmsisdnpre,$offaddresspre,$farmsisdnpre,$faraddresspre,$passpre,$terms,$quantity,$amount,$orderrptaddr,$out,$outpred);
					
				}else{
		
			//echo "<br> Everything failed<br>";
			$array = false;
		}
		
		}
		
		if($transaction_type =='addgenericrole1' || $transaction_type =='removegenericrole'){ 

			$opkey = str_replace("1","",$transaction_type);
		
			$curl = curl_init();
			
			curl_setopt_array($curl, array(
			  CURLOPT_URL => 'http://41.73.252.237:8546/preceipt/unsafe/ad/{"'."op".'":"'.$opkey.'",'.'"admin'.'":"'.'0x2d2d8721fcacb58c7f5f2946bdcc487629da2d64",'.'"adminpwd'.'":"'.'agrikore",'.'"order'.'":"'.$order_address.'",'.'"receipt'.'":"'.$orderrptaddr.'",'.'"genericrole'.'":"'.$faraddresspre.'"}',
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
				CURLOPT_TIMEOUT => 200,
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
						$outpred = "nill";
						$array = $pos->savePre($pre_name,$transaction_type,$msisdnpre,$addresspre,$order_address,$offmsisdnpre,$offaddresspre,$farmsisdnpre,$faraddresspre,$passpre,$terms,$quantity,$amount,$orderrptaddr,$out,$outpred);
						
					}else{
			
				//echo "<br> Everything failed<br>";
				$array = false;
			}
			
			}
		
			if($transaction_type =='confirmdelivery'){ 

				$opkey = str_replace("1","",$transaction_type);
			
				$curl = curl_init();
				
				curl_setopt_array($curl, array(
				  CURLOPT_URL => 'http://41.73.252.237:8546/preceipt/unsafe/ad/{"'."op".'":"'.'confirmdelivery",'.'"buyer'.'":"'.$addresspre.'",'.'"buyerpwd'.'":"'.$u_pass1.'",'.'"order'.'":"'.$order_address.'",'.'"receipt'.'":"'.$orderrptaddr.'"}',
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
					CURLOPT_TIMEOUT => 200,
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
							$outpred = "nill";
							$array = $pos->savePre($pre_name,$transaction_type,$msisdnpre,$addresspre,$order_address,$offmsisdnpre,$offaddresspre,$farmsisdnpre,$faraddresspre,$passpre,$terms,$quantity,$amount,$orderrptaddr,$out,$outpred);
							
						}else{
				
					//echo "<br> Everything failed<br>";
					$array = false;
				}
				
				}
			
		

	
			if($array[0] == true)
			{
				$result['id_pre'] = $array[2];
			}
			
		}
		else
		{
			$array = $pos->updatePre($idpre,$pre_name,$transaction_type,$msisdnpre,$addresspre,$order_address,$offmsisdnpre,$offaddresspre,$farmsisdnpre,$faraddresspre,$passpre,$terms,$quantity,$amount);
		}
		$result['result'] = $array[0];
		$result['error'] = $array[1];
		$result['crud'] = $_POST['crud'];
		echo json_encode($result);
	}
	
	if($method == 'getdata'){
		$pos = new pos();
		$array = $pos->getListPre();
		$data = $array[1];
		$i=0;
		foreach ($data as $key) {
			$button = '<button  type="submit" id_pre="'.$key['id_pre'].'"  title="Tombol edit barang" class="btn btn-sm btn-primary btneditpre "  id="btneditpre'.$key['id_pre'].'"  ><i class="fa fa-edit"></i></button> <button  type="submit" id_pre="'.$key['id_pre'].'"  title="Tombol hapus barang" class="btn btn-danger btn-sm btndeletepre "  id="btndeletepre'.$key['id_pre'].'"  ><i class="fa fa-trash"></i></button>';

			
			$data[$i]['amount'] =  number_format($data[$i]['amount']);
			$data[$i]['DT_RowId']= $data[$i]['id_pre'];
			$data[$i]['quantity']= number_format($data[$i]['quantity']);
			$data[$i]['button'] = $button;
			$i++;
		}
		$datax = array('data' => $data);
		echo json_encode($datax);
	}
	if($method == 'delete_pre'){
		$id_pre=$_POST['id_pre'];
		$pos = new pos();
		$array = $pos->deletePre($id_pre);
		$data['result'] = $array[0];
		$data['error'] = $array[1];
		echo json_encode($data);
	}
	
} else {
	exit('No direct access allowed.');
}