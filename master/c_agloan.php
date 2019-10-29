<?php
session_start();
require_once ("../model/dbconn.php");
require_once ("../model/pos.php");
include('db.php');
	
	if( isset( $_SERVER['HTTP_X_REQUESTED_WITH'] ) && ( $_SERVER['HTTP_X_REQUESTED_WITH'] == 'XMLHttpRequest' ) )
{
	
	
    if (isset($_POST['lonwphoneagloan_id'])) {

        $xlonwphoneagloan_id = $_POST['lonwphoneagloan_id'];
        
        
	
		$qry = "select b_address as lonb_addressagloan from m_user where wphone= $xlonwphoneagloan_id";
		$res = mysqli_query($con, $qry);
		if(mysqli_num_rows($res) > 0) {
			echo '<option value="">------- Select -------</option>';
			while($row = mysqli_fetch_object($res)) {
				echo '<option value="'.$row->lonb_addressagloan.'">'.$row->lonb_addressagloan.'</option>';
			}
		} else {
			echo '<option value="">No Record</option>';
		}
	
    } 


	if (isset($_POST['benwphoneagloan_id'])) {

        $xbenwphoneagloan_id = $_POST['benwphoneagloan_id'];
        
        
	
		$qry = "select b_address as benb_addressagloan from m_user where wphone= $xbenwphoneagloan_id";
		$res = mysqli_query($con, $qry);
		if(mysqli_num_rows($res) > 0) {
			echo '<option value="">------- Select -------</option>';
			while($row = mysqli_fetch_object($res)) {
				echo '<option value="'.$row->benb_addressagloan.'">'.$row->benb_addressagloan.'</option>';
			}
		} else {
			echo '<option value="">No Record</option>';
		}
	
    } 





	
	
	
	
	
	
	
	$pos = new pos();
	$method=$_POST['method'];
	if($method == 'get_detail_agloan')
	{
		$id_agloan=$_POST['id_agloan'];
		$pos = new pos();
		$data = $pos->getagloan($id_agloan);
		$array['data'] = $data[1];
		$array['result'] = $data[0];
		echo json_encode($array);
	}
	if($method == 'save_agloan')
	{

		//echo "<br> id:".
		$idagloan = $_POST['id_agloan'];
		//echo "<br> ag:".
		$agloan_name = $_POST['agloan_name'];
		//echo "<br> id:".
		$transaction_type = $_POST['transaction_type'];
		//echo "<br> id:".
		$principal = $_POST['principal']*1000000000000000000;
		//echo "<br> id:".
		$principal_limit = $_POST['principal_limit']*1000000000000000000;
		//echo "<br> id:".
		$expenses = str_replace(" ","",$_POST['expenses']);
		//echo "<br> id:".
		$term = $_POST['term'];
		//echo "<br> id:".
		$moratorium = $_POST['moratorium'];
		//echo "<br> id:".
		$irate = $_POST['irate']*1000000000000000000;
		//echo "<br> id:".
		$late_pen = $_POST['late_pen']*1000000000000000000;
		//echo "<br> id:".
		$autopay = $_POST['autopay'];
		//echo "<br> id:".
		$payday = $_POST['payday'];
		$description = $_POST['description'];
	
		$lonmsisdnagloan = str_replace(" ","",$_POST['lonmsisdnagloan']);
		//echo "<br> la:".
		$laddr = $_POST['lonaddressagloan'];
	  $benmsisdnagloan = $_POST['benmsisdnagloan'];
		//echo "<br> beneaddr:".
		$baddr = $_POST['benaddressagloan'];
		$passagloan = md5($_POST['passagloan']);
	
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
$block1 = $t1pos->getblockpass($lonmsisdnagloan);
//$walletno1 = $block1[1]['wphone'];
//$wallet_address1 = $block1[1]['b_address'];
//$b_token1 = $block1[1]['b_token'];
$u_pass1 = $block1[1]['pass'];




$curl = curl_init();

curl_setopt_array($curl, array(
	CURLOPT_URL => "https://www.agrikore.net/mula/vw/{%22op%22:%22getbal%22,%22addr%22:%22$laddr%22}",
	//'https://www.agrikore.net/mula/vw/{"'."op".'":"'.'getbal",'.'"addr'.'":"'.$lonaddressagloan.'"}',
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
  echo  "cURL Error #:" . $err;
} else {
  //echo $response;
//	echo "<br> bal:".
	$bal = str_replace('"'," ",$responsebal);
}





if(($transaction_type =='addagloan')&&($passagloan == $u_pass1 )&&($bal > $principal || $bal == $principal)){ 

    


//	if (($u_pass1 == $passagloan)&&($bal > $principal || $bal == $principal)){
		//	$response = null;
	//system("ping -c 1 google.com", $response);
	//if($response == 0)
	//{

	//	if ($transaction_type = 'addagloan'){
	
			$curl = curl_init();
			curl_setopt_array($curl, array(
				CURLOPT_URL => "https://www.agrikore.net/keystore/{%22op%22:%22createkeyadv%22,%20%22pwd%22:%22$u_pass1%22}",
				CURLOPT_RETURNTRANSFER => true,
				CURLOPT_ENCODING => "",
				CURLOPT_MAXREDIRS => 10,
				CURLOPT_TIMEOUT => 30,
				CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
				CURLOPT_CUSTOMREQUEST => "POST",
				CURLOPT_HTTPHEADER => array(
				   "x-access-token: $b_token"
				),
			  ));
			  
			  $response3 = curl_exec($curl);
			  $err = curl_error($curl);
			  
			  //curl_close($curl);
			  
			  if ($err) {
				//echo "cURL Error #:" . $err;
				$errorMSG = "Block Account Creation Failed.Check your Internet connection ".$err;
			  } else {
				
				$result3 = json_decode($response3, true);
				// -----------Publickey,Privatekey,Address----------------
				$address2 = ($result3['address']);
			
			  }
	
			 // $curl = curl_init();
			 $esprice = 0;
			 $ebprice = 0;
	//echo "<br> curl :"."https://www.agrikore.net/agloan/unsafe/tx/{%22op%22:%22addloan%22,%22loaner%22:%22$laddre%22,%22loanerpwd%22:%22$u_pass1%22,%22loan%22:%22$address2%22,%22benef%22:%22$benaddressagloan%22,%22prin%22:%22$principal%22,%22prinlmt%22:%22$principal_limit%22,%22term%22:%22$term%22,%22morat%22:%22$moratorium%22,%22expense%22:%22$expenses%22}";
	
	curl_setopt_array($curl, array(
		CURLOPT_URL => //"https://www.agrikore.net/agloan/unsafe/tx/{%22op%22:%22addloan%22,%22loaner%22:%220x18dd97512471a7f5780dc7d1f14d3a1f107e3d75%22,%22loanerpwd%22:%22f8bf9e5b72e3d4e017d483787baa3d4b%22,%22loan%22:%220x493648f12f4c3bdfb0bbd38cb8827ee1f4005b40%22,%22benef%22:%220xa092456e77f681f9b4899915942627d37d184dec%22,%22prin%22:%2250000000000000000000000000%22,%22prinlmt%22:%2280000000000000000000000000%22,%22term%22:%2230%22,%22morat%22:%220%22,%22expense%22:%221%22}",
	 'https://www.agrikore.net/agloan/unsafe/tx/{"'."op".'":"'.'addloan",'.'"loaner'.'":"'.$laddr.'",'.'"loanerpwd'.'":"'.$u_pass1.'",'.'"loan'.'":"'.$address2.'",'.'"benef'.'":"'.$baddr.'",'.'"prin'.'":"'.$principal.'",'.'"prinlmt'.'":"'.$principal_limit.'",'.'"term'.'":"'.$term.'",'.'"morat'.'":"'.$moratorium.'",'.'"expense'.'":"'.$expenses.'"}',
		CURLOPT_RETURNTRANSFER => true,
	  CURLOPT_ENCODING => "",
	  CURLOPT_MAXREDIRS => 10,
	  CURLOPT_TIMEOUT => 30,
	  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
	  CURLOPT_CUSTOMREQUEST => "POST",
	  CURLOPT_HTTPHEADER => array(
		"x-access-token: $b_token"
	  ),
	));
	
	$response2 = curl_exec($curl);
	$err = curl_error($curl);
	
	curl_close($curl);
	
	if ($err) {
	  echo "cURL Error #:" . $err;
	} else {
	//  echo $response;
	//echo "<br> commodity index :".$commindex."<br>"; 
	
	//echo "<br> addloan:".	
	$receipt2 = str_replace('"',"",$response2);
				//echo "<br> commodity index :".$receipt2."<br>"; 
			}
		   
	// sleep for 10 seconds
	sleep(8);

				 if($receipt2 != '' || $receipt2 != Null){ 
	
			  $ctr = 1;
	
			  while($ctr++ < 105){//while loop
	
		   $curl = curl_init();
			curl_setopt_array($curl, array(
			  
				CURLOPT_URL => 'https://www.agrikore.net/transactionreceipts/'.$receipt2.'/',
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
			//	echo "<br> recept: ".
				$response3;
			}
			//$ctr++;
			if ($response3 != "Cannot find the transaction or it's receipt" || $response3 == "") {
			  break;    /* You could also write 'break 1;' here. */
		  }
			
		  }//while loop off
			
		 //echo "<br> Reciept query :".$response3."<br>";
	
			$json_o = json_decode($response3,true);
	
					$result = array();
					$out = "Status :";
	
					foreach ($json_o['events'] as $theentity) {
						$result[] = $theentity['args']['errorCode'];
						$a = $theentity['args']['errorCode'];
						$c = $theentity['contract'];
						$d = "no";
	
	
					if ($a != 100){
						//echo "Successful";
						$d = $a;
						 $out .=$c."-".$a."-Error,";
					}else{
					  $out .=$c."-".$a."-Success,"; 
					}
					//echo "<br> addloan-status: ".
					$out;
					}
					//$array = $pos->saveOff($nameoff,$loc_name,$receipt_limit,$addressoff,$msisdnoff,$out);
				  } 
				  /** */
				  //else{
		
			 //add gorderdetails
			 
			 $true = "true";
		   
		   $curl = curl_init();
	
		   curl_setopt_array($curl, array(
			 CURLOPT_URL => 'https://www.agrikore.net/agloan/unsafe/tx/{"'."op".'":"'.'addloandetails",'.'"loaner'.'":"'.$laddr.'",'.'"loanerpwd'.'":"'.$u_pass1.'",'.'"loan'.'":"'.$address2.'",'.'"prin'.'":"'.$principal.'",'.'"prinlmt'.'":"'.$principal_limit.'",'.'"term'.'":"'.$term.'",'.'"morat'.'":"'.$moratorium.'",'.'"intrate'.'":"'.$irate.'",'.'"latepen'.'":"'.$late_pen.'",'.'"autopay'.'":"'.$autopay.'",'.'"payday'.'":"'.$payday.'"}', 
			 //'https://www.agrikore.net/gorder/unsafe/tx/{"'."op".'":"'.'addgorderdetails",'.'"buyer'.'":"'.$addressreq.'",'.'"buyerpwd'.'":"'.$u_pass1.'",'.'"order'.'":"'.$address2.'",'.'"price'.'":"'.$price.'",'.'"quantity'.'":"'.$stock.'",'.'"coveredval'.'":"'.$cover_value.'",'.'"bondedval'.'":"'.$bond_value.'",'.'"creditpercent'.'":"'.$allowed_credit.'",'.'"handle'.'":"'.$handling_type.'",'.'"allowindependentofftaker'.'":"'.$true.'",'.'"isofftakerfunded'.'":"'.$true.'"}',
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
		   
		   $responsegd = curl_exec($curl);
		   $err = curl_error($curl);
		   
		   curl_close($curl);
		   
		   if ($err) {
			 $echo = "cURL Error #:" . $err;
		   } else {
		   //  echo $response;
		   
			 //echo "<br> details: ". 
			 $receiptgd = str_replace('"',"",$responsegd);
				   }
				  
		   // sleep for 10 seconds
				sleep(6);

				   if($receiptgd != '' || $receiptgd != Null){ 
		   
					 $ctr = 1;
		   
					 while($ctr++ < 15){//while loop
		   
				  $curl = curl_init();
				   curl_setopt_array($curl, array(
					 
					 CURLOPT_URL => 'https://www.agrikore.net/transactionreceipts/'.$receiptgd.'/',
					 
					 CURLOPT_RETURNTRANSFER => true,
					 CURLOPT_ENCODING => "",
					 CURLOPT_MAXREDIRS => 10,
					 CURLOPT_TIMEOUT => 700,
					 CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
					 CURLOPT_CUSTOMREQUEST => "GET",
					 CURLOPT_HTTPHEADER => array(
					   "x-acess-token: $b_token"
					 ),
				   ));
				   
				   $responsegdr = curl_exec($curl);
				   $err = curl_error($curl);
				   
				   curl_close($curl);
				 
				   if ($err) {
					 echo "cURL Error #:" . $err;
				   } else {
					$echo = $responsegdr;
				   }
				   //$ctr++;
				   if ($responsegdr != "Cannot find the transaction or it's receipt" || $responsegdr == "") {
					 break;    /* You could also write 'break 1;' here. */
				 }
				   
				 }//while loop off
				   
				//echo "<br> Reciept query :".$responsegdr."<br>";
		   
				   $json_o = json_decode($responsegdr,true);
		   
						   $result = array();
						   $outgdr = "Status :";
		   
						   foreach ($json_o['events'] as $theentity) {
							   $result[] = $theentity['args']['errorCode'];
							   $agdr = $theentity['args']['errorCode'];
							   $cgdr = $theentity['contract'];
							   $dgdr = "no";
		   
		   
						   if ($agdr != 100){
							   //echo "Successful";
							   $dgdr = $agdr;
							   $outgdr .=$cgdr."-".$agdr."-Error,";
						   }else{
							  $outgdr .=$cgdr."-".$agdr."-Success,"; 
						   }
						  // echo $dgdr."-d-Error,"; 
						   }
						   //$array = $pos->saveOff($nameoff,$loc_name,$receipt_limit,$addressoff,$msisdnoff,$out);
						 } 
					 
	
	
	//add gorderaccounting


   
		   
	$curl = curl_init();
	
	curl_setopt_array($curl, array(
		CURLOPT_URL => 'https://www.agrikore.net/agloan/unsafe/tx/{"'."op".'":"'.'addloanaccountings",'.'"loaner'.'":"'.$laddr.'",'.'"loanerpwd'.'":"'.$u_pass1.'",'.'"loan'.'":"'.$address2.'"}',
		//'https://www.agrikore.net/gorder/unsafe/tx/{"'."op".'":"'.'addgorderaccountings",'.'"buyer'.'":"'.$addressreq.'",'.'"buyerpwd'.'":"'.$u_pass1.'",'.'"order'.'":"'.$address2.'",'.'"interestrate'.'":"'.$interest_rate.'"}',
	  CURLOPT_RETURNTRANSFER => true,
	  CURLOPT_ENCODING => "",
	  CURLOPT_MAXREDIRS => 10,
	  CURLOPT_TIMEOUT => 30,
	  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
	  CURLOPT_CUSTOMREQUEST => "POST",
	  CURLOPT_HTTPHEADER => array(
		"x-access-token: $b_token"
	  ),
	));
	
	$responsegac = curl_exec($curl);
	$err = curl_error($curl);
	
	curl_close($curl);
	
	if ($err) {
	  $echo = "cURL Error #:" . $err;
	} else {
	//  echo $response;
	
	//echo "<br> acct:".
	$receiptgac = str_replace('"',"",$responsegac);
			}
		   
	// sleep for 10 seconds
	sleep(5);

			if($receiptgac != '' || $receiptgac != Null){ 
	
			  $ctr = 1;
	
			  while($ctr++ < 105){//while loop
	
		   $curl = curl_init();
			curl_setopt_array($curl, array(
			  
			  CURLOPT_URL => 'https://www.agrikore.net/transactionreceipts/'.$receiptgac.'/',
			  
			  CURLOPT_RETURNTRANSFER => true,
			  CURLOPT_ENCODING => "",
			  CURLOPT_MAXREDIRS => 10,
			  CURLOPT_TIMEOUT => 30,
			  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
			  CURLOPT_CUSTOMREQUEST => "GET",
			  CURLOPT_HTTPHEADER => array(
				"x-acess-token: $b_token"
			  ),
			));
			
			$responsegac = curl_exec($curl);
			$err = curl_error($curl);
			
			curl_close($curl);
		  
			if ($err) {
			  $echo = "cURL Error #:" . $err;
			} else {
			 $echo = $responsegac;
			}
			//$ctr++;
			if ($responsegac != "Cannot find the transaction or it's receipt" || $responsegac == "") {
			  break;    /* You could also write 'break 1;' here. */
		  }
			
		  }//while loop off
			
		 //echo "<br> Reciept query :".$responsegac."<br>";
	
			$json_o = json_decode($responsegac,true);
	
					$result = array();
					$outgac = "Status :";
	
					foreach ($json_o['events'] as $theentity) {
						$result[] = $theentity['args']['errorCode'];
						$agac = $theentity['args']['errorCode'];
						$cgac = $theentity['contract'];
						$dgac = "no";
	
	
					if ($agac != 100){
						//echo "Successful";
						$dgac = $agac;
						 $outgac .=$cgac."-".$agac."-Error,";
					}else{
					   $outgac .=$cgac."-".$agac."-Success,"; 
					}
					//echo $dgac."-d-Error,"; 
					}
					//$array = $pos->saveOff($nameoff,$loc_name,$receipt_limit,$addressoff,$msisdnoff,$out);
					//echo "<br> gorder           :".$out."<br>";
					//echo "<br> gorderdetails    :".$outgdr."<br>";
					//echo "<br> gorderaccounting :".$outgac."<br>";
					//echo "<br> gorderaccounting :".$address2."<br>";
					} 
					
	

					$curl = curl_init();
	
	curl_setopt_array($curl, array(
		CURLOPT_URL => 'https://www.agrikore.net/agloan/unsafe/tx/{"'."op".'":"'.'addloandescript",'.'"loaner'.'":"'.$laddr.'",'.'"loanerpwd'.'":"'.$u_pass1.'",'.'"loan'.'":"'.$address2.'",'.'"descript'.'":"'.$description.'"}',
		//'https://www.agrikore.net/gorder/unsafe/tx/{"'."op".'":"'.'addgorderaccountings",'.'"buyer'.'":"'.$addressreq.'",'.'"buyerpwd'.'":"'.$u_pass1.'",'.'"order'.'":"'.$address2.'",'.'"interestrate'.'":"'.$interest_rate.'"}',
	  CURLOPT_RETURNTRANSFER => true,
	  CURLOPT_ENCODING => "",
	  CURLOPT_MAXREDIRS => 10,
	  CURLOPT_TIMEOUT => 30,
	  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
	  CURLOPT_CUSTOMREQUEST => "POST",
	  CURLOPT_HTTPHEADER => array(
		"x-access-token: $b_token"
	  ),
	));
	
	$responsedesc = curl_exec($curl);
	$err = curl_error($curl);
	
	curl_close($curl);
	
	if ($err) {
	  $echo = "cURL Error #:" . $err;
	} else {
	//  echo $response;
	
	//echo "<br> desc:".
	$receiptdesc = str_replace('"',"",$responsedesc);
			}
		   
	// sleep for 10 seconds
	sleep(5);

			if($receiptdesc != '' || $receiptdesc != Null){ 
	
			  $ctr = 1;
	
			  while($ctr++ < 105){//while loop
	
		   $curl = curl_init();
			curl_setopt_array($curl, array(
			  
			  CURLOPT_URL => 'https://www.agrikore.net/transactionreceipts/'.$receiptdesc.'/',
			  
			  CURLOPT_RETURNTRANSFER => true,
			  CURLOPT_ENCODING => "",
			  CURLOPT_MAXREDIRS => 10,
			  CURLOPT_TIMEOUT => 30,
			  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
			  CURLOPT_CUSTOMREQUEST => "GET",
			  CURLOPT_HTTPHEADER => array(
				"x-acess-token: $b_token"
			  ),
			));
			
			$responsedescrpt = curl_exec($curl);
			$err = curl_error($curl);
			
			curl_close($curl);
		  
			if ($err) {
			  $echo = "cURL Error #:" . $err;
			} else {
			 $echo = $responsedescrpt;
			}
			//$ctr++;
			if ($responsedescrpt != "Cannot find the transaction or it's receipt" || $responsedescrpt == "") {
			  break;    /* You could also write 'break 1;' here. */
		  }
			
		  }//while loop off
			
		 //echo "<br> Reciept query :".$responsedescrpt."<br>";
	
			$json_o = json_decode($responsedescrpt,true);
	
					$result = array();
					$outdesc = "Status :";
	
					foreach ($json_o['events'] as $theentity) {
						$result[] = $theentity['args']['errorCode'];
						$adesc = $theentity['args']['errorCode'];
						$cgac = $theentity['contract'];
						$ddesc = "no";
	
	
					if ($adesc != 100){
						//echo "Successful";
						$ddesc = $adesc;
						 $outdesc .=$cgac."-".$adesc."-Error,";
					}else{
					   $outdesc .=$cgac."-".$adesc."-Success,"; 
					}
					//echo $ddesc."-d-Error,"; 
					}
					
				  } 
	
			  
				 //echo "<br>".$array= "ok";

				 if (strpos( $outdesc, 'Success') !== false) {
				 $curl = curl_init();

				 curl_setopt_array($curl, array(
				   CURLOPT_URL => 'https://www.agrikore.net/mula/unsafe/ad/{"'."op".'":"'.'admintransfernofee",'.'"admin'.'":"'.'0x2d2d8721fcacb58c7f5f2946bdcc487629da2d64",'.'"adminpwd'.'":"'.'agrikore",'.'"from'.'":"'.$laddr.'",'.'"to'.'":"'.$address2.'",'.'"val'.'":"'.$principal.'"}',
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
				  $receipttran = str_replace('"',"",$response8);
				 }
	
		  // sleep for 10 seconds
		  sleep(5);
		
		  if($receipttran != '' || $receipttran != Null){ 
	
			$ctr = 1;
  
			while($ctr++ < 105){//while loop
  
		 $curl = curl_init();
		  curl_setopt_array($curl, array(
			
			CURLOPT_URL => 'https://www.agrikore.net/transactionreceipts/'.$receipttran.'/',
			
			CURLOPT_RETURNTRANSFER => true,
			CURLOPT_ENCODING => "",
			CURLOPT_MAXREDIRS => 10,
			CURLOPT_TIMEOUT => 30,
			CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
			CURLOPT_CUSTOMREQUEST => "GET",
			CURLOPT_HTTPHEADER => array(
			  "x-acess-token: $b_token"
			),
		  ));
		  
		  $responsetran = curl_exec($curl);
		  $err = curl_error($curl);
		  
		  curl_close($curl);
		
		  if ($err) {
			$echo = "cURL Error #:" . $err;
		  } else {
		   $echo = $responsegac;
		  }
		  //$ctr++;
		  if ($responsetran != "Cannot find the transaction or it's receipt" || $responsetran == "") {
			break;    /* You could also write 'break 1;' here. */
		}
		  
		}//while loop off
		  
	   //echo "<br> Reciept query :".$responsegac."<br>";
  
		  $json_o = json_decode($responsetran,true);
  
				  $result = array();
				  $outtran = "Status :";
  
				  foreach ($json_o['events'] as $theentity) {
					  $result[] = $theentity['args']['errorCode'];
					  $atran = $theentity['args']['errorCode'];
					  $ctran = $theentity['contract'];
					  $dtran = "no";
  
  
				  if ($atran != 100){
					  //echo "Successful";
					  $dtran = $atran;
					   $outtran .=$ctran."-".$atran."-Error,";
				  }else{
					 $outtran .=$ctran."-".$atran."-Success,"; 
				  }
				  //echo $dgac."-d-Error,"; 
				  }
				} 
       	}//Transfer mula if order created	  
			else{
			$array = false;
		}
	//	$outtran = 'loan creation failed.No transfer done';
		$principal = $_POST['principal'];
		$principal_limit = $_POST['principal_limit'];
		$irate = $_POST['irate'];
		$late_pen = $_POST['late_pen'];
			
 //$array = $pos->saveAgloan("1","2","3","4","5","6","7","8","9","10","11","12","13","14","15","16","17","18","19","20","21");
 $array = $pos->saveAgloan($agloan_name,$transaction_type,$principal,$principal_limit,$term,$moratorium,$expenses,$irate,$late_pen,$autopay,$payday,$lonmsisdnagloan,$laddr,$benmsisdnagloan,$baddr,$out,$outgdr,$outgac,$outdesc,$outtran,$address2);

	}//password
	elseif(($transaction_type =='addmuloan')&&($passagloan == $u_pass1 )&&($bal > $principal || $bal == $principal)){ 


		$curl = curl_init();
		curl_setopt_array($curl, array(
			CURLOPT_URL => "https://www.agrikore.net/keystore/{%22op%22:%22createkeyadv%22,%20%22pwd%22:%22$u_pass1%22}",
			CURLOPT_RETURNTRANSFER => true,
			CURLOPT_ENCODING => "",
			CURLOPT_MAXREDIRS => 10,
			CURLOPT_TIMEOUT => 30,
			CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
			CURLOPT_CUSTOMREQUEST => "POST",
			CURLOPT_HTTPHEADER => array(
				 "x-access-token: $b_token"
			),
			));
			
			$response3 = curl_exec($curl);
			$err = curl_error($curl);
			
			//curl_close($curl);
			
			if ($err) {
			//echo "cURL Error #:" . $err;
			$errorMSG = "Block Account Creation Failed.Check your Internet connection ".$err;
			} else {
			
			$result3 = json_decode($response3, true);
			// -----------Publickey,Privatekey,Address----------------
			$address2 = ($result3['address']);
		
			}

		 // $curl = curl_init();
		 $esprice = 0;
		 $ebprice = 0;
//echo "<br> curl :"."https://www.agrikore.net/agloan/unsafe/tx/{%22op%22:%22addloan%22,%22loaner%22:%22$laddre%22,%22loanerpwd%22:%22$u_pass1%22,%22loan%22:%22$address2%22,%22benef%22:%22$benaddressagloan%22,%22prin%22:%22$principal%22,%22prinlmt%22:%22$principal_limit%22,%22term%22:%22$term%22,%22morat%22:%22$moratorium%22,%22expense%22:%22$expenses%22}";

curl_setopt_array($curl, array(
	CURLOPT_URL => //"https://www.agrikore.net/agloan/unsafe/tx/{%22op%22:%22addloan%22,%22loaner%22:%220x18dd97512471a7f5780dc7d1f14d3a1f107e3d75%22,%22loanerpwd%22:%22f8bf9e5b72e3d4e017d483787baa3d4b%22,%22loan%22:%220x493648f12f4c3bdfb0bbd38cb8827ee1f4005b40%22,%22benef%22:%220xa092456e77f681f9b4899915942627d37d184dec%22,%22prin%22:%2250000000000000000000000000%22,%22prinlmt%22:%2280000000000000000000000000%22,%22term%22:%2230%22,%22morat%22:%220%22,%22expense%22:%221%22}",
 'https://www.agrikore.net/muloan/unsafe/tx/{"'."op".'":"'.'addloan",'.'"loaner'.'":"'.$laddr.'",'.'"loanerpwd'.'":"'.$u_pass1.'",'.'"loan'.'":"'.$address2.'",'.'"benef'.'":"'.$baddr.'",'.'"prin'.'":"'.$principal.'",'.'"prinlmt'.'":"'.$principal_limit.'",'.'"term'.'":"'.$term.'",'.'"morat'.'":"'.$moratorium.'"}',
	CURLOPT_RETURNTRANSFER => true,
	CURLOPT_ENCODING => "",
	CURLOPT_MAXREDIRS => 10,
	CURLOPT_TIMEOUT => 30,
	CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
	CURLOPT_CUSTOMREQUEST => "POST",
	CURLOPT_HTTPHEADER => array(
	"x-access-token: $b_token"
	),
));

$response2 = curl_exec($curl);
$err = curl_error($curl);

curl_close($curl);

if ($err) {
	echo "cURL Error #:" . $err;
} else {
//  echo $response;
//echo "<br> commodity index :".$commindex."<br>"; 

//echo "<br> addloan:".	
$receipt2 = str_replace('"',"",$response2);
			//echo "<br> commodity index :".$receipt2."<br>"; 
		}
		 
// sleep for 10 seconds
sleep(8);

			 if($receipt2 != '' || $receipt2 != Null){ 

			$ctr = 1;

			while($ctr++ < 105){//while loop

		 $curl = curl_init();
		curl_setopt_array($curl, array(
			
			CURLOPT_URL => 'https://www.agrikore.net/transactionreceipts/'.$receipt2.'/',
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
		//	echo "<br> recept: ".
			$response3;
		}
		//$ctr++;
		if ($response3 != "Cannot find the transaction or it's receipt" || $response3 == "") {
			break;    /* You could also write 'break 1;' here. */
		}
		
		}//while loop off
		
	 //echo "<br> Reciept query :".$response3."<br>";

		$json_o = json_decode($response3,true);

				$result = array();
				$out = "Status :";

				foreach ($json_o['events'] as $theentity) {
					$result[] = $theentity['args']['errorCode'];
					$a = $theentity['args']['errorCode'];
					$c = $theentity['contract'];
					$d = "no";


				if ($a != 100){
					//echo "Successful";
					$d = $a;
					 $out .=$c."-".$a."-Error,";
				}else{
					$out .=$c."-".$a."-Success,"; 
				}
				//echo "<br> addloan-status: ".
				$out;
				}
				//$array = $pos->saveOff($nameoff,$loc_name,$receipt_limit,$addressoff,$msisdnoff,$out);
				} 
				/** */
				//else{
	
		 //add gorderdetails
		 
		 $true = "true";
		 
		 $curl = curl_init();

		 curl_setopt_array($curl, array(
		 CURLOPT_URL => 'https://www.agrikore.net/muloan/unsafe/tx/{"'."op".'":"'.'addloandetails",'.'"loaner'.'":"'.$laddr.'",'.'"loanerpwd'.'":"'.$u_pass1.'",'.'"loan'.'":"'.$address2.'",'.'"prin'.'":"'.$principal.'",'.'"prinlmt'.'":"'.$principal_limit.'",'.'"term'.'":"'.$term.'",'.'"morat'.'":"'.$moratorium.'",'.'"intrate'.'":"'.$irate.'",'.'"latepen'.'":"'.$late_pen.'",'.'"autopay'.'":"'.$autopay.'",'.'"payday'.'":"'.$payday.'"}', 
		 //'https://www.agrikore.net/gorder/unsafe/tx/{"'."op".'":"'.'addgorderdetails",'.'"buyer'.'":"'.$addressreq.'",'.'"buyerpwd'.'":"'.$u_pass1.'",'.'"order'.'":"'.$address2.'",'.'"price'.'":"'.$price.'",'.'"quantity'.'":"'.$stock.'",'.'"coveredval'.'":"'.$cover_value.'",'.'"bondedval'.'":"'.$bond_value.'",'.'"creditpercent'.'":"'.$allowed_credit.'",'.'"handle'.'":"'.$handling_type.'",'.'"allowindependentofftaker'.'":"'.$true.'",'.'"isofftakerfunded'.'":"'.$true.'"}',
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
		 
		 $responsegd = curl_exec($curl);
		 $err = curl_error($curl);
		 
		 curl_close($curl);
		 
		 if ($err) {
		 $echo = "cURL Error #:" . $err;
		 } else {
		 //  echo $response;
		 
		 //echo "<br> details: ". 
		 $receiptgd = str_replace('"',"",$responsegd);
				 }
				
		 // sleep for 10 seconds
			sleep(7);

				 if($receiptgd != '' || $receiptgd != Null){ 
		 
				 $ctr = 1;
		 
				 while($ctr++ < 15){//while loop
		 
				$curl = curl_init();
				 curl_setopt_array($curl, array(
				 
				 CURLOPT_URL => 'https://www.agrikore.net/transactionreceipts/'.$receiptgd.'/',
				 
				 CURLOPT_RETURNTRANSFER => true,
				 CURLOPT_ENCODING => "",
				 CURLOPT_MAXREDIRS => 10,
				 CURLOPT_TIMEOUT => 700,
				 CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
				 CURLOPT_CUSTOMREQUEST => "GET",
				 CURLOPT_HTTPHEADER => array(
					 "x-acess-token: $b_token"
				 ),
				 ));
				 
				 $responsegdr = curl_exec($curl);
				 $err = curl_error($curl);
				 
				 curl_close($curl);
			 
				 if ($err) {
				 echo "cURL Error #:" . $err;
				 } else {
				$echo = $responsegdr;
				 }
				 //$ctr++;
				 if ($responsegdr != "Cannot find the transaction or it's receipt" || $responsegdr == "") {
				 break;    /* You could also write 'break 1;' here. */
			 }
				 
			 }//while loop off
				 
			//echo "<br> Reciept query :".$responsegdr."<br>";
		 
				 $json_o = json_decode($responsegdr,true);
		 
						 $result = array();
						 $outgdr = "Status :";
		 
						 foreach ($json_o['events'] as $theentity) {
							 $result[] = $theentity['args']['errorCode'];
							 $agdr = $theentity['args']['errorCode'];
							 $cgdr = $theentity['contract'];
							 $dgdr = "no";
		 
		 
						 if ($agdr != 100){
							 //echo "Successful";
							 $dgdr = $agdr;
							 $outgdr .=$cgdr."-".$agdr."-Error,";
						 }else{
							$outgdr .=$cgdr."-".$agdr."-Success,"; 
						 }
						 
						 }
						
					 } 
				 


//add gorderaccounting


 
		 
$curl = curl_init();

curl_setopt_array($curl, array(
	CURLOPT_URL => 'https://www.agrikore.net/muloan/unsafe/tx/{"'."op".'":"'.'addloanaccountings",'.'"loaner'.'":"'.$laddr.'",'.'"loanerpwd'.'":"'.$u_pass1.'",'.'"loan'.'":"'.$address2.'"}',
	//'https://www.agrikore.net/gorder/unsafe/tx/{"'."op".'":"'.'addgorderaccountings",'.'"buyer'.'":"'.$addressreq.'",'.'"buyerpwd'.'":"'.$u_pass1.'",'.'"order'.'":"'.$address2.'",'.'"interestrate'.'":"'.$interest_rate.'"}',
	CURLOPT_RETURNTRANSFER => true,
	CURLOPT_ENCODING => "",
	CURLOPT_MAXREDIRS => 10,
	CURLOPT_TIMEOUT => 30,
	CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
	CURLOPT_CUSTOMREQUEST => "POST",
	CURLOPT_HTTPHEADER => array(
	"x-access-token: $b_token"
	),
));

$responsegac = curl_exec($curl);
$err = curl_error($curl);

curl_close($curl);

if ($err) {
	$echo = "cURL Error #:" . $err;
} else {
//  echo $response;

//echo "<br> acct:".
$receiptgac = str_replace('"',"",$responsegac);
		}
		 
// sleep for 10 seconds
sleep(7);

		if($receiptgac != '' || $receiptgac != Null){ 

			$ctr = 1;

			while($ctr++ < 105){//while loop

		 $curl = curl_init();
		curl_setopt_array($curl, array(
			
			CURLOPT_URL => 'https://www.agrikore.net/transactionreceipts/'.$receiptgac.'/',
			
			CURLOPT_RETURNTRANSFER => true,
			CURLOPT_ENCODING => "",
			CURLOPT_MAXREDIRS => 10,
			CURLOPT_TIMEOUT => 30,
			CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
			CURLOPT_CUSTOMREQUEST => "GET",
			CURLOPT_HTTPHEADER => array(
			"x-acess-token: $b_token"
			),
		));
		
		$responsegac = curl_exec($curl);
		$err = curl_error($curl);
		
		curl_close($curl);
		
		if ($err) {
			$echo = "cURL Error #:" . $err;
		} else {
		 $echo = $responsegac;
		}
		//$ctr++;
		if ($responsegac != "Cannot find the transaction or it's receipt" || $responsegac == "") {
			break;    /* You could also write 'break 1;' here. */
		}
		
		}//while loop off
		
	 //echo "<br> Reciept query :".$responsegac."<br>";

		$json_o = json_decode($responsegac,true);

				$result = array();
				$outgac = "Status :";

				foreach ($json_o['events'] as $theentity) {
					$result[] = $theentity['args']['errorCode'];
					$agac = $theentity['args']['errorCode'];
					$cgac = $theentity['contract'];
					$dgac = "no";


				if ($agac != 100){
					//echo "Successful";
					$dgac = $agac;
					 $outgac .=$cgac."-".$agac."-Error,";
				}else{
					 $outgac .=$cgac."-".$agac."-Success,"; 
				}
				//echo $dgac."-d-Error,"; 
				}
				//$array = $pos->saveOff($nameoff,$loc_name,$receipt_limit,$addressoff,$msisdnoff,$out);
				//echo "<br> gorder           :".$out."<br>";
				//echo "<br> gorderdetails    :".$outgdr."<br>";
				//echo "<br> gorderaccounting :".$outgac."<br>";
				//echo "<br> gorderaccounting :".$address2."<br>";
				} 
				


				$curl = curl_init();

curl_setopt_array($curl, array(
	CURLOPT_URL => 'https://www.agrikore.net/muloan/unsafe/tx/{"'."op".'":"'.'addloandescript",'.'"loaner'.'":"'.$laddr.'",'.'"loanerpwd'.'":"'.$u_pass1.'",'.'"loan'.'":"'.$address2.'",'.'"descript'.'":"'.$description.'"}',
	//'https://www.agrikore.net/gorder/unsafe/tx/{"'."op".'":"'.'addgorderaccountings",'.'"buyer'.'":"'.$addressreq.'",'.'"buyerpwd'.'":"'.$u_pass1.'",'.'"order'.'":"'.$address2.'",'.'"interestrate'.'":"'.$interest_rate.'"}',
	CURLOPT_RETURNTRANSFER => true,
	CURLOPT_ENCODING => "",
	CURLOPT_MAXREDIRS => 10,
	CURLOPT_TIMEOUT => 30,
	CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
	CURLOPT_CUSTOMREQUEST => "POST",
	CURLOPT_HTTPHEADER => array(
	"x-access-token: $b_token"
	),
));

$responsedesc = curl_exec($curl);
$err = curl_error($curl);

curl_close($curl);

if ($err) {
	$echo = "cURL Error #:" . $err;
} else {
//  echo $response;

//echo "<br> desc:".
$receiptdesc = str_replace('"',"",$responsedesc);
		}
		 
// sleep for 10 seconds
sleep(7);

		if($receiptdesc != '' || $receiptdesc != Null){ 

			$ctr = 1;

			while($ctr++ < 105){//while loop

		 $curl = curl_init();
		curl_setopt_array($curl, array(
			
			CURLOPT_URL => 'https://www.agrikore.net/transactionreceipts/'.$receiptdesc.'/',
			
			CURLOPT_RETURNTRANSFER => true,
			CURLOPT_ENCODING => "",
			CURLOPT_MAXREDIRS => 10,
			CURLOPT_TIMEOUT => 30,
			CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
			CURLOPT_CUSTOMREQUEST => "GET",
			CURLOPT_HTTPHEADER => array(
			"x-acess-token: $b_token"
			),
		));
		
		$responsedescrpt = curl_exec($curl);
		$err = curl_error($curl);
		
		curl_close($curl);
		
		if ($err) {
			$echo = "cURL Error #:" . $err;
		} else {
		 $echo = $responsedescrpt;
		}
		//$ctr++;
		if ($responsedescrpt != "Cannot find the transaction or it's receipt" || $responsedescrpt == "") {
			break;    /* You could also write 'break 1;' here. */
		}
		
		}//while loop off
		
	 //echo "<br> Reciept query :".$responsedescrpt."<br>";

		$json_o = json_decode($responsedescrpt,true);

				$result = array();
				$outdesc = "Status :";

				foreach ($json_o['events'] as $theentity) {
					$result[] = $theentity['args']['errorCode'];
					$adesc = $theentity['args']['errorCode'];
					$cgac = $theentity['contract'];
					$ddesc = "no";


				if ($adesc != 100){
					//echo "Successful";
					$ddesc = $adesc;
					 $outdesc .=$cgac."-".$adesc."-Error,";
				}else{
					 $outdesc .=$cgac."-".$adesc."-Success,"; 
				}
				//echo $ddesc."-d-Error,"; 
				}
				
				} 

			
			 //echo "<br>".$array= "ok";

			 if (strpos( $outdesc, 'Success') !== false) {
			 $curl = curl_init();

			 curl_setopt_array($curl, array(
				 CURLOPT_URL => 'https://www.agrikore.net/mula/unsafe/ad/{"'."op".'":"'.'admintransfernofee",'.'"admin'.'":"'.'0x2d2d8721fcacb58c7f5f2946bdcc487629da2d64",'.'"adminpwd'.'":"'.'agrikore",'.'"from'.'":"'.$laddr.'",'.'"to'.'":"'.$address2.'",'.'"val'.'":"'.$principal.'"}',
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
				$receipttran = str_replace('"',"",$response8);
			 }

		// sleep for 10 seconds
		sleep(7);
	
		if($receipttran != '' || $receipttran != Null){ 

		$ctr = 1;

		while($ctr++ < 105){//while loop

	 $curl = curl_init();
		curl_setopt_array($curl, array(
		
		CURLOPT_URL => 'https://www.agrikore.net/transactionreceipts/'.$receipttran.'/',
		
		CURLOPT_RETURNTRANSFER => true,
		CURLOPT_ENCODING => "",
		CURLOPT_MAXREDIRS => 10,
		CURLOPT_TIMEOUT => 30,
		CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
		CURLOPT_CUSTOMREQUEST => "GET",
		CURLOPT_HTTPHEADER => array(
			"x-acess-token: $b_token"
		),
		));
		
		$responsetran = curl_exec($curl);
		$err = curl_error($curl);
		
		curl_close($curl);
	
		if ($err) {
		$echo = "cURL Error #:" . $err;
		} else {
		 $echo = $responsegac;
		}
		//$ctr++;
		if ($responsetran != "Cannot find the transaction or it's receipt" || $responsetran == "") {
		break;    /* You could also write 'break 1;' here. */
	}
		
	}//while loop off
		
	 //echo "<br> Reciept query :".$responsegac."<br>";

		$json_o = json_decode($responsetran,true);

				$result = array();
				$outtran = "Status :";

				foreach ($json_o['events'] as $theentity) {
					$result[] = $theentity['args']['errorCode'];
					$atran = $theentity['args']['errorCode'];
					$ctran = $theentity['contract'];
					$dtran = "no";


				if ($atran != 100){
					//echo "Successful";
					$dtran = $atran;
					 $outtran .=$ctran."-".$atran."-Error,";
				}else{
				 $outtran .=$ctran."-".$atran."-Success,"; 
				}
				//echo $dgac."-d-Error,"; 
				}
			} 
			 }//Transfer mula if order created	  
		else{
		$array = false;
	}
//	$outtran = 'loan creation failed.No transfer done';
	$principal = $_POST['principal'];
	$principal_limit = $_POST['principal_limit'];
	$irate = $_POST['irate'];
	$late_pen = $_POST['late_pen'];
	$expenses = 0;

	
 //$array = $pos->saveAgloan("1","2","3","4","5","6","7","8","9","10","11","12","13","14","15","16","17","18","19","20","21");
 $array = $pos->saveAgloan($agloan_name,$transaction_type,$principal,$principal_limit,$term,$moratorium,$expenses,$irate,$late_pen,$autopay,$payday,$lonmsisdnagloan,$laddr,$benmsisdnagloan,$baddr,$out,$outgdr,$outgac,$outdesc,$outtran,$address2);
	
	}else{
    
        //echo "<br> Everything failed<br>";
        $array = false;
    }
		

	
			if($array[0] == true)
			{
				$result['id_agloan'] = $array[2];
			}
			
		}
		else
		{
			$array = $pos->updateAgloan($idagloan,$agloan_name,$transaction_type,$principal,$principal_limit,$term,$moratorium,$expenses,$irate,$late_pen,$autopay,$payday,$lonmsisdnagloan,$laddr,$benmsisdnagloan,$baddr);
		}
		$result['result'] = $array[0];
		$result['error'] = $array[1];
		$result['crud'] = $_POST['crud'];
		echo json_encode($result);
	}
	
	if($method == 'getdata'){
		$pos = new pos();
		$array = $pos->getListagloan();
		$data = $array[1];
		$i=0;
		foreach ($data as $key) {
			$button = '<button  type="submit" id_agloan="'.$key['id_agloan'].'"  title="Tombol edit barang" class="btn btn-sm btn-primary btneditagloan "  id="btneditagloan'.$key['id_agloan'].'"  ><i class="fa fa-edit"></i></button> <button  type="submit" id_agloan="'.$key['id_agloan'].'"  title="Tombol hapus barang" class="btn btn-danger btn-sm btndeleteagloan "  id="btndeleteagloan'.$key['id_agloan'].'"  ><i class="fa fa-trash"></i></button>';

			
			$data[$i]['principal'] =  number_format($data[$i]['principal']);
			$data[$i]['DT_RowId']= $data[$i]['id_agloan'];
			$data[$i]['principal_limit']= number_format($data[$i]['principal_limit']);
			$data[$i]['button'] = $button;
			$i++;
		}
		$datax = array('data' => $data);
		echo json_encode($datax);
	}
	if($method == 'delete_agloan'){
		$id_agloan=$_POST['id_agloan'];
		$pos = new pos();
		$array = $pos->deleteagloan($id_agloan);
		$data['result'] = $array[0];
		$data['error'] = $array[1];
		echo json_encode($data);
	}
	
} else {
	exit('No direct access allowed.');
}