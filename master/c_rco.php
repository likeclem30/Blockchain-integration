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
	if($method == 'get_detail_rco')
	{
		$id_rco=$_POST['id_rco'];
		$pos = new pos();
		$data = $pos->getrco($id_rco);
		$array['data'] = $data[1];
		$array['result'] = $data[0];
		echo json_encode($array);
	}
	if($method == 'save_rco')
	{
		$idrco = $_POST['id_rco'];
		$rco_name = $_POST['rco_name'];
		$currency_type = $_POST['currency_type'];
		$commission = $_POST['commission']*1000000000000000000;
		$redemption = $_POST['redemption']*1000000000000000000;
		$fixedredemption = $_POST['fixedredemption']*1000000000000000000;
		$addressrco = $_POST['addressrco'];
		$msisdnrco = $_POST['msisdnrco'];
		
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
$block1 = $t1pos->getblockpass($msisdnrco);
//$walletno1 = $block1[1]['wphone'];
//$wallet_address1 = $block1[1]['b_address'];
//$b_token1 = $block1[1]['b_token'];
$u_pass1 = $block1[1]['pass'];




if ($currency_type == 'agloan'){

	$curl = curl_init();
		
	curl_setopt_array($curl, array(
	CURLOPT_URL => 'https://www.agrikore.net/agloan/unsafe/ad/{"'."op".'":"'.'setcommaddr",'.'"admin'.'":"'.'0x2d2d8721fcacb58c7f5f2946bdcc487629da2d64",'.'"adminpwd'.'":"'.'agrikore",'.'"commaddr'.'":"'.$addressrco.'"}',
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
	
	$responseaddr = curl_exec($curl);
	$err = curl_error($curl);
	
	curl_close($curl);
	
	if ($err) {
	$echo = "cURL Error #:" . $err;
	} else {
	//  echo $response;
	
			 $receipt2addr = str_replace('"',"",$responseaddr);
			 
		}
	   
	
			 if($receipt2addr != '' || $receipt2addr != Null){ 
	
		  $ctr = 1;
	
		  while($ctr++ < 105){//while loop
	
	   $curl = curl_init();
		curl_setopt_array($curl, array(
		  
		  CURLOPT_URL => 'https://www.agrikore.net/transactionreceipts/'.$receipt2addr.'/',
		  
		  CURLOPT_RETURNTRANSFER => true,
		  CURLOPT_ENCODING => "",
		  CURLOPT_MAXREDIRS => 10,
		  CURLOPT_TIMEOUT => 700,
		  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
		  CURLOPT_CUSTOMREQUEST => "GET",
		  CURLOPT_HTTPHEADER => array(
			"Cache-Control: no-cache",
			"x-acess-token: $b_token"
		  ),
		));
		
		$responseaddr3 = curl_exec($curl);
		$err = curl_error($curl);
		
		curl_close($curl);
	  
		if ($err) {
		  $echo = "cURL Error #:" . $err;
		} else {
		 $echo = $responseaddr3;
		}
		//$ctr++;
		if ($responseaddr3 != "Cannot find the transaction or it's receipt" || $responseaddr3 == "") {
		  break;    /* You could also write 'break 1;' here. */
	  }
		
	  }//while loop off
		
	 //echo "<br> Reciept query :".$responseaddr3."<br>";
	
		$json_o = json_decode($responseaddr3,true);
	
				$result = array();
				$outaddresscomm = " ";
	
				foreach ($json_o['events'] as $theentity) {
					$result[] = $theentity['args']['errorCode'];
					$a = $theentity['args']['errorCode'];
					$c = $theentity['contract'];
					$d = "no";
	
	
				if ($a != 100){
					//echo "Successful";
					$d = $a;
					 $outaddresscomm .=$c."-".$a."-Error,";
				}else{
				   $outaddresscomm .=$c."-".$a."-Success,"; 
				}
				//echo $d."-d-Error,"; 
				}
				//$array = $out);
			  } 
			 
	
	
	   
	   $curl = curl_init();
	
	   curl_setopt_array($curl, array(
		 CURLOPT_URL => 'https://www.agrikore.net/agloan/unsafe/ad/{"'."op".'":"'.'setcommpercent",'.'"admin'.'":"'.'0x2d2d8721fcacb58c7f5f2946bdcc487629da2d64",'.'"adminpwd'.'":"'.'agrikore",'.'"commpercent'.'":"'.$commission.'"}',
		 CURLOPT_RETURNTRANSFER => true,
		 CURLOPT_ENCODING => "",
		 CURLOPT_MAXREDIRS => 10,
		 CURLOPT_TIMEOUT => 700,
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
			  
	   
			   if($receiptgd != '' || $receiptgd != Null){ 
	   
				 $ctr = 1;
	   
				 while($ctr++ < 105){//while loop
	   
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
				 $echo = "cURL Error #:" . $err;
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
					   $outcomm = "";
	   
					   foreach ($json_o['events'] as $theentity) {
						   $result[] = $theentity['args']['errorCode'];
						   $agdr = $theentity['args']['errorCode'];
						   $cgdr = $theentity['contract'];
						   $dgdr = "no";
	   
	   
					   if ($agdr != 100){
						   //echo "Successful";
						   $dgdr = $agdr;
						   $outcomm .=$cgdr."-".$agdr."-Error,";
					   }else{
						  $outcomm .=$cgdr."-".$agdr."-Success,"; 
					   }
					  // echo $dgdr."-d-Error,"; 
					   }
					  // $outred = 0;
				//$array = $pos->saveRco($rco_name,$commission,$redemption,$addressrco,$msisdnrco,$outaddress,$outcomm,$outred);
				
				
			  } 
		  
	
	
	
			
		$curl = curl_init();
		
		curl_setopt_array($curl, array(
		CURLOPT_URL => 'https://www.agrikore.net/agloan/unsafe/ad/{"'."op".'":"'.'setredemptcomm",'.'"admin'.'":"'.'0x2d2d8721fcacb58c7f5f2946bdcc487629da2d64",'.'"adminpwd'.'":"'.'agrikore",'.'"redemptcommaddr'.'":"'.$addressrco.'",'.'"redemptcommpercent'.'":"'.$redemption.'"}',
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
		$echo = "cURL Error #:" . $err;
		} else {
		//  echo $response;
		
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
			  CURLOPT_TIMEOUT => 700,
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
					$outaddress = " ";
		
					foreach ($json_o['events'] as $theentity) {
						$result[] = $theentity['args']['errorCode'];
						$a = $theentity['args']['errorCode'];
						$c = $theentity['contract'];
						$d = "no";
		
		
					if ($a != 100){
						//echo "Successful";
						$d = $a;
						 $outaddress .=$c."-".$a."-Error,";
					}else{
					   $outaddress .=$c."-".$a."-Success,"; 
					}
					//echo $d."-d-Error,"; 
					}
					//$outred = 0;
					$array = $pos->saveRco($rco_name,$commission,$redemption,$fixedredemption,$addressrco,$msisdnrco,$outaddresscomm,$outcomm,$outaddress,$currency_type);
					
				  } 
				}


if ($currency_type == 'gorder'){

$curl = curl_init();
	
curl_setopt_array($curl, array(
CURLOPT_URL => 'https://www.agrikore.net/preceipt/unsafe/ad/{"'."op".'":"'.'setcommaddress",'.'"admin'.'":"'.'0x2d2d8721fcacb58c7f5f2946bdcc487629da2d64",'.'"adminpwd'.'":"'.'agrikore",'.'"addr'.'":"'.$addressrco.'"}',
CURLOPT_RETURNTRANSFER => true,
CURLOPT_ENCODING => "",
CURLOPT_MAXREDIRS => 10,
CURLOPT_TIMEOUT => 70,
CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
CURLOPT_CUSTOMREQUEST => "POST",
CURLOPT_HTTPHEADER => array(
"x-access-token: $b_token"
),
));

$responseaddr = curl_exec($curl);
$err = curl_error($curl);

curl_close($curl);

if ($err) {
$echo = "cURL Error #:" . $err;
} else {
//  echo $response;

		 $receipt2addr = str_replace('"',"",$responseaddr);
		 
	}
   

		 if($receipt2addr != '' || $receipt2addr != Null){ 

	  $ctr = 1;

	  while($ctr++ < 105){//while loop

   $curl = curl_init();
	curl_setopt_array($curl, array(
	  
	  CURLOPT_URL => 'https://www.agrikore.net/transactionreceipts/'.$receipt2addr.'/',
	  
	  CURLOPT_RETURNTRANSFER => true,
	  CURLOPT_ENCODING => "",
	  CURLOPT_MAXREDIRS => 10,
	  CURLOPT_TIMEOUT => 700,
	  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
	  CURLOPT_CUSTOMREQUEST => "GET",
	  CURLOPT_HTTPHEADER => array(
		"Cache-Control: no-cache",
		"x-acess-token: $b_token"
	  ),
	));
	
	$responseaddr3 = curl_exec($curl);
	$err = curl_error($curl);
	
	curl_close($curl);
  
	if ($err) {
	  $echo = "cURL Error #:" . $err;
	} else {
	 $echo = $responseaddr3;
	}
	//$ctr++;
	if ($responseaddr3 != "Cannot find the transaction or it's receipt" || $responseaddr3 == "") {
	  break;    /* You could also write 'break 1;' here. */
  }
	
  }//while loop off
	
 //echo "<br> Reciept query :".$responseaddr3."<br>";

	$json_o = json_decode($responseaddr3,true);

			$result = array();
			$outaddresscomm = " ";

			foreach ($json_o['events'] as $theentity) {
				$result[] = $theentity['args']['errorCode'];
				$a = $theentity['args']['errorCode'];
				$c = $theentity['contract'];
				$d = "no";


			if ($a != 100){
				//echo "Successful";
				$d = $a;
				 $outaddresscomm .=$c."-".$a."-Error,";
			}else{
			   $outaddresscomm .=$c."-".$a."-Success,"; 
			}
			//echo $d."-d-Error,"; 
			}
			//$array = $out);
		  } 
		 


   
   $curl = curl_init();

   curl_setopt_array($curl, array(
	 CURLOPT_URL => 'https://www.agrikore.net/preceipt/unsafe/ad/{"'."op".'":"'.'setcommpercent",'.'"admin'.'":"'.'0x2d2d8721fcacb58c7f5f2946bdcc487629da2d64",'.'"adminpwd'.'":"'.'agrikore",'.'"percent'.'":"'.$commission.'"}',
	 CURLOPT_RETURNTRANSFER => true,
	 CURLOPT_ENCODING => "",
	 CURLOPT_MAXREDIRS => 10,
	 CURLOPT_TIMEOUT => 700,
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
		  
   
		   if($receiptgd != '' || $receiptgd != Null){ 
   
			 $ctr = 1;
   
			 while($ctr++ < 105){//while loop
   
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
			 $echo = "cURL Error #:" . $err;
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
				   $outcomm = "";
   
				   foreach ($json_o['events'] as $theentity) {
					   $result[] = $theentity['args']['errorCode'];
					   $agdr = $theentity['args']['errorCode'];
					   $cgdr = $theentity['contract'];
					   $dgdr = "no";
   
   
				   if ($agdr != 100){
					   //echo "Successful";
					   $dgdr = $agdr;
					   $outcomm .=$cgdr."-".$agdr."-Error,";
				   }else{
					  $outcomm .=$cgdr."-".$agdr."-Success,"; 
				   }
				  // echo $dgdr."-d-Error,"; 
				   }
				  // $outred = 0;
			//$array = $pos->saveRco($rco_name,$commission,$redemption,$addressrco,$msisdnrco,$outaddress,$outcomm,$outred);
			
			
		  } 
	  



		
	$curl = curl_init();
	
	curl_setopt_array($curl, array(
	CURLOPT_URL => 'https://www.agrikore.net/preceipt/unsafe/ad/{"'."op".'":"'.'setredemptcomm",'.'"admin'.'":"'.'0x2d2d8721fcacb58c7f5f2946bdcc487629da2d64",'.'"adminpwd'.'":"'.'agrikore",'.'"comm'.'":"'.$fixedredemption.'",'.'"percent'.'":"'.$redemption.'"}',
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
	$echo = "cURL Error #:" . $err;
	} else {
	//  echo $response;
	
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
		  CURLOPT_TIMEOUT => 700,
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
				$outaddress = " ";
	
				foreach ($json_o['events'] as $theentity) {
					$result[] = $theentity['args']['errorCode'];
					$a = $theentity['args']['errorCode'];
					$c = $theentity['contract'];
					$d = "no";
	
	
				if ($a != 100){
					//echo "Successful";
					$d = $a;
					 $outaddress .=$c."-".$a."-Error,";
				}else{
				   $outaddress .=$c."-".$a."-Success,"; 
				}
				//echo $d."-d-Error,"; 
				}
				//$outred = 0;
				$array = $pos->saveRco($rco_name,$commission,$redemption,$fixedredemption,$addressrco,$msisdnrco,$outaddresscomm,$outcomm,$outaddress,$currency_type);
				
			  } 
			}
	


			if($array[0] == true)

			{

							$result['id_rco'] = $array[2];
			}
		}
		
	
		else
		{
			$array = $pos->updateRco($idrco,$rco_name,$commission,$redemption,$addressrco,$msisdnrco,$currency_type);
		}
		$result['result'] = $array[0];
		$result['error'] = $array[1];
		$result['crud'] = $_POST['crud'];
		echo json_encode($result);
	}
	
	if($method == 'getdata'){
		$pos = new pos();
		$array = $pos->getListRco();
		$data = $array[1];
		$i=0;
		foreach ($data as $key) {
			$button = '<button  type="submit" id_rco="'.$key['id_rco'].'"  title="Tombol edit barang" class="btn btn-sm btn-primary btneditrco "  id="btneditrco'.$key['id_rco'].'"  ><i class="fa fa-edit"></i></button> <button  type="submit" id_rco="'.$key['id_rco'].'"  title="Tombol hapus barang" class="btn btn-danger btn-sm btndeleterco "  id="btndeleterco'.$key['id_rco'].'"  ><i class="fa fa-trash"></i></button>';

			$data[$i]['rco_name'] =  $data[$i]['rco_name'];
			//$data[$i]['fprice'] =  number_format($data[$i]['fprice']);
			$data[$i]['DT_RowId']= $data[$i]['id_rco'];
			//$data[$i]['currency_type']= $data[$i]['currency_type'];
			//$data[$i]['terms']= number_format($data[$i]['terms']);
			$data[$i]['button'] = $button;
			$i++;
		}
		$datax = array('data' => $data);
		echo json_encode($datax);
	}
	if($method == 'delete_rco'){
		$id_rco=$_POST['id_rco'];
		$pos = new pos();
		$array = $pos->deleterco($id_rco);
		$data['result'] = $array[0];
		$data['error'] = $array[1];
		echo json_encode($data);
	}
	
} else {
	exit('No direct access allowed.');
}
