<?php
session_start();
require_once ("../model/dbconn.php");
require_once ("../model/pos.php");
include('db.php');
if( isset( $_SERVER['HTTP_X_REQUESTED_WITH'] ) && ( $_SERVER['HTTP_X_REQUESTED_WITH'] == 'XMLHttpRequest' ) )
{

	if (isset($_POST['wphonerequest_id'])) {

		$xphonerequest_id = $_POST['wphonerequest_id'];
	
		$qry = "select concat(username,'-',b_address) as b_addressrequest,b_address from m_user where wphone= $xphonerequest_id";
		$res = mysqli_query($con, $qry);
		if(mysqli_num_rows($res) > 0) {
			echo '<option value="">------- Select -------</option>';
			while($row = mysqli_fetch_object($res)) {
				echo '<option value="'.$row->b_address.'">'.$row->b_addressrequest.'</option>';
			}
		} else {
			echo '<option value="">No Record</option>';
		}
	
	} 


	

	$pos = new pos();
	$method=$_POST['method'];
	if($method == 'get_detail_request')
	{
		$id_request=$_POST['id_request'];
		$pos = new pos();
		$data = $pos->getRequest($id_request);
		$array['data'] = $data[1];
		$array['result'] = $data[0];
		echo json_encode($array);
	}
	if($method == 'save_request')

	{
		$pricex = $_POST['price'];
		$bond_valuex = $_POST['bond_value'];
		$cover_valuex = $_POST['cover_value'];
		
		$idrequest = $_POST['id_request'];
		$namerequest = $_POST['request_name'];
		//echo "<br>Comm :".
		$commodity = str_replace(" ","",str_replace('"',"",$_POST['commodity']));
		$ccbordertotal = $_POST['stock'];
		$unit= $_POST['unit'];
		$price = $_POST['price'];
		$allowed_credit = $_POST['allowed_credit']*1000000000000000000;
		$strikeprice = $_POST['bond_value'];
		$cover_value = $_POST['cover_value']*1000000000000000000;
		$handling_type = $_POST['handling_type'];
		$interest_rate = $_POST['interest_rate']*1000000000000000000;
		//$offtaker_rate = $_POST['offtaker_rate']*1000000000000000000;
		$duration = $_POST['duration'];
		$msisdnreq = $_POST['msisdnreq'];
		$addressreq = $_POST['addressreq'];
		$passreq = md5($_POST['passreq']);
		$crud=$_POST['crud'];

        

		
       // $u_pass1 = md5("test4");
		$pos = new pos();
		if($_POST['crud'] == 'N')
		{
			  //$hashpass = md5($passreq);
			  
			$tpos = new pos();
			$block = $tpos->getblockadd($_SESSION['pos_username']);

			//echo "<br> user id".$_SESSION['pos_username'];
			$walletno = $block[1]['wphone'];
			$wallet_address = $block[1]['b_address'];
			$b_token = $block[1]['b_token'];

			//---------------------Block begins------------------------
			$t1pos = new pos();
			$block1 = $t1pos->getblockpass($msisdnreq);
			//$walletno1 = $block1[1]['wphone'];
			//$wallet_address1 = $block1[1]['b_address'];
			//$b_token1 = $block1[1]['b_token'];
			$u_pass1 = $block1[1]['pass'];



			$curl = curl_init();

curl_setopt_array($curl, array(
  CURLOPT_URL => 'https://www.agrikore.net/mula/vw/{"'."op".'":"'.'getbal",'.'"addr'.'":"'.$addressreq.'"}',
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
  $echo = "cURL Error #:" . $err;
} else {
  //echo $response;
  $bal = str_replace('"'," ",$responsebal);
  
}

/**
 * When you approve an order, it requires the order has at least 
 * the mula balance: 
 * covered_value * (general_sell_price + extra_order_sell_price) / 1e18, 
 * only true if covered_value, general_sell_price, 
 * and extra_order_sell_price are all in bigNumber format
 * 
 */


$curl = curl_init();

curl_setopt_array($curl, array(
  CURLOPT_PORT => "8547",
  CURLOPT_URL => "http://41.73.252.237:8547/gorder",
  CURLOPT_RETURNTRANSFER => true,
  CURLOPT_ENCODING => "",
  CURLOPT_MAXREDIRS => 10,
  CURLOPT_TIMEOUT => 30,
  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
  CURLOPT_CUSTOMREQUEST => "GET",
  CURLOPT_HTTPHEADER => array(
    "Postman-Token: 9673954f-086c-42bf-a8fe-1eb2e9c0d1c8",
    "cache-control: no-cache"
  ),
));

$response = curl_exec($curl);
$err = curl_error($curl);

curl_close($curl);

if ($err) {
  echo "cURL Error #:" . $err;
} else {
  //echo $response;

  $result3 = json_decode($response, true);
				// -----------Publickey,Privatekey,Address----------------
								//echo "<br> mulaBSellbackPrice".
								$mulaBSellbackPrice = (($result3['mulaBSellbackPrice'])/1000000000000000000);

								//$mulaBSellbackPrice = ($result3['mulaBSellbackPrice']);
}





    //$pricex = $_POST['price'];
	//	$bond_valuex = $_POST['bond_value'];
	//	$cover_valuex = $_POST['cover_value'];

		

	//echo "<br> Total qty".
	$stock = $ccbordertotal/$price;
	//	echo "<br> extrall sell price".
	$bond_value = (($price/$strikeprice)-$mulaBSellbackPrice)*1000000000000000000;


//$order_transfer = ($cover_value*($mulaBSellbackPrice + $bond_value)/1000000000000000000);
    
	if (($u_pass1 == $passreq)&&($bal > $cover_value || $bal == $cover_value)){

		//echo "<br>price inside password :".$price = $_POST['price']*1000000000000000000;
		//	$response = null;
	//system("ping -c 1 google.com", $response);
	//if($response == 0)
	//{
		$price = $_POST['price']*1000000000000000000;
	
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
				//echo "<br>Address order: ".
				$address2 = ($result3['address']);
				//$publicKey = ($result3['publicKey']);
				//$privateKey = ($result3['privateKey']);
				//echo "<br> order address :".$address2."<br>";
			
			  }
	
			  //add gorder
		   
			 // $curl = curl_init();
			 $esprice = 0;
			 $ebprice = 0;
			//echo "<br> url".'https://www.agrikore.net/gorder/unsafe/tx/{"'."op".'":"'.'addgorder",'.'"buyer'.'":"'.$addressreq.'",'.'"buyerpwd'.'":"'.$u_pass1.'",'.'"order'.'":"'.$address2.'",'.'"duration'.'":"'.$duration.'",'.'"comm'.'":"'.$commodity.'",'.'"price'.'":"'.$price.'",'.'"quantity'.'":"'.$stock.'",'.'"coveredval'.'":"'.$cover_value.'",'.'"bondedval'.'":"'.$esprice.'",'.'"extrasellprice'.'":"'.$bond_value.'",'.'"extrabuyprice'.'":"'.$ebprice.'",'.'"operator'.'":"'.$wallet_address.'"}';
	curl_setopt_array($curl, array(
	  CURLOPT_URL => 'https://www.agrikore.net/gorder/unsafe/tx/{"'."op".'":"'.'addgorder",'.'"buyer'.'":"'.$addressreq.'",'.'"buyerpwd'.'":"'.$u_pass1.'",'.'"order'.'":"'.$address2.'",'.'"duration'.'":"'.$duration.'",'.'"comm'.'":"'.$commodity.'",'.'"price'.'":"'.$price.'",'.'"quantity'.'":"'.$stock.'",'.'"coveredval'.'":"'.$cover_value.'",'.'"bondedval'.'":"'.$esprice.'",'.'"extrasellprice'.'":"'.$bond_value.'",'.'"extrabuyprice'.'":"'.$ebprice.'",'.'"operator'.'":"'.$wallet_address.'"}',
	  CURLOPT_RETURNTRANSFER => true,
	  CURLOPT_ENCODING => "",
	  CURLOPT_MAXREDIRS => 10,
	  CURLOPT_TIMEOUT => 700,
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
	
	//echo "<br>addgorde rpt: ".$receipt2 = str_replace('"',"",$response2);
				//echo "<br> commodity index :".$receipt2."<br>"; 
			}
		   
	// sleep for 10 seconds
	sleep(6);

				 if($receipt2 != '' || $receipt2 != Null){ 
	
			  $ctr = 1;
	
			  while($ctr++ < 105){//while loop
	
		   $curl = curl_init();
			curl_setopt_array($curl, array(
			  
			  CURLOPT_URL => 'https://www.agrikore.net/transactionreceipts/'.$receipt2.'/',
			  
			  CURLOPT_RETURNTRANSFER => true,
			  CURLOPT_ENCODING => "",
			  CURLOPT_MAXREDIRS => 10,
			  CURLOPT_TIMEOUT => 70,
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
					//echo $d."-d-Error,"; 
					}
					//$array = $pos->saveOff($nameoff,$loc_name,$receipt_limit,$addressoff,$msisdnoff,$out);
				  } 
				  /** */
				  //else{
					//echo "<br>addgorde rpt status: ".$out;
			 //add gorderdetails
			 
			 $true = "true";
		   
		   $curl = curl_init();
	
		   curl_setopt_array($curl, array(
			 CURLOPT_URL => 'https://www.agrikore.net/gorder/unsafe/tx/{"'."op".'":"'.'addgorderdetails",'.'"buyer'.'":"'.$addressreq.'",'.'"buyerpwd'.'":"'.$u_pass1.'",'.'"order'.'":"'.$address2.'",'.'"price'.'":"'.$price.'",'.'"quantity'.'":"'.$stock.'",'.'"coveredval'.'":"'.$cover_value.'",'.'"bondedval'.'":"'.$esprice.'",'.'"creditpercent'.'":"'.$allowed_credit.'",'.'"handle'.'":"'.$handling_type.'",'.'"allowindependentofftaker'.'":"'.$true.'",'.'"isofftakerfunded'.'":"'.$true.'",'.'"paycommasderivative'.'":"'.$true.'"}',
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
					 
						// echo "<br>addgordetails rpt status: ".$outgdr;
	
	//add gorderaccounting


   
		   
	$curl = curl_init();
	
	curl_setopt_array($curl, array(
	  CURLOPT_URL => 'https://www.agrikore.net/gorder/unsafe/tx/{"'."op".'":"'.'addgorderaccountings",'.'"buyer'.'":"'.$addressreq.'",'.'"buyerpwd'.'":"'.$u_pass1.'",'.'"order'.'":"'.$address2.'",'.'"interestrate'.'":"'.$interest_rate.'"}',
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
			  
				 //echo "<br>".$array= "ok";

				 if (strpos($outgac, 'Success') !== false) {
				 $curl = curl_init();

				 curl_setopt_array($curl, array(
				   CURLOPT_URL => 'https://www.agrikore.net/mula/unsafe/ad/{"'."op".'":"'.'admintransfernofee",'.'"admin'.'":"'.'0x2d2d8721fcacb58c7f5f2946bdcc487629da2d64",'.'"adminpwd'.'":"'.'agrikore",'.'"from'.'":"'.$addressreq.'",'.'"to'.'":"'.$address2.'",'.'"val'.'":"'.$cover_value.'"}',
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

				$price = $_POST['price'];
		$allowed_credit = $_POST['allowed_credit'];
		$bond_value = $_POST['bond_value'];
		$cover_value = $_POST['cover_value'];
		$handling_type = $_POST['handling_type'];
		$interest_rate = $_POST['interest_rate'];
				$offtaker_rate = 0;
		 $array = $pos->saveRequest($namerequest,$commodity,$stock,$unit,$price,$allowed_credit,$cover_value,$bond_value,$handling_type,$interest_rate,$offtaker_rate,$duration,$msisdnreq,$addressreq,$u_pass1,$address2,$out,$outgdr,$outgac,$outtran);
			}//Transfer mula if order created	  
			else{
			$array = false;
		}
		}//if password is users
        else{
		  
			//echo "<br> Everything failed<br>";
			$array = false;
		  }



			if($array[0] == true)
			{
				$result['id_request'] = $array[2];
			}
			
		}
		else
		{
			$array = $pos->updateRequest($idrequest,$namerequest,$commodity,$stock,$unit,$price,$allowed_credit,$cover_value,$bond_value,$handling_type,$interest_rate,$offtaker_rate,$duration,$msisdnreq,$addressreq,$passreq);
		}
		$result['result'] = $array[0];
		$result['error'] = $array[1];
		$result['crud'] = $_POST['crud'];
		echo json_encode($result);
	}
	
	if($method == 'getdata'){
		$pos = new pos();
		$array = $pos->getListRequest();
		$data = $array[1];
		$i=0;
		foreach ($data as $key) {
			$button = '<button  type="submit" id_request="'.$key['id_request'].'"  title="Tombol edit barang" class="btn btn-sm btn-primary btneditrequest "  id="btneditrequest'.$key['id_request'].'"  ><i class="fa fa-edit"></i></button> <button  type="submit" id_request="'.$key['id_request'].'"  title="Tombol hapus barang" class="btn btn-danger btn-sm btndeleterequest "  id="btndeleterequest'.$key['id_request'].'"  ><i class="fa fa-trash"></i></button>';

			$data[$i]['price'] =  number_format($data[$i]['price']);
			$data[$i]['bond_value'] =  number_format($data[$i]['bond_value']);
			$data[$i]['cover_value'] =  number_format($data[$i]['cover_value']);
			$data[$i]['DT_RowId']= $data[$i]['id_request'];
			$data[$i]['stock']= number_format($data[$i]['stock']);
			$data[$i]['handling_type']= number_format($data[$i]['handling_type']);
			$data[$i]['interest_rate']= number_format($data[$i]['interest_rate']);
			$data[$i]['offtaker_rate']= number_format($data[$i]['offtaker_rate']);
			$data[$i]['button'] = $button;
			$i++;
		}
		$datax = array('data' => $data);
		echo json_encode($datax);
	}
	if($method == 'delete_request'){
		$id_request=$_POST['id_request'];
		$pos = new pos();
		$array = $pos->deleteRequest($id_request);
		$data['result'] = $array[0];
		$data['error'] = $array[1];
		echo json_encode($data);
	}
	
} else {
	exit('No direct access allowed.');
}