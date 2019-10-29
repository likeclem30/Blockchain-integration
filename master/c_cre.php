<?php
session_start();
require_once ("../model/dbconn.php");
require_once ("../model/pos.php");
include('db.php');
if( isset( $_SERVER['HTTP_X_REQUESTED_WITH'] ) && ( $_SERVER['HTTP_X_REQUESTED_WITH'] == 'XMLHttpRequest' ) )
{
	

	if (isset($_POST['wphonecre_id'])) {

		$xphonecre_id = $_POST['wphonecre_id'];
	
		$qry = "select distinct order_address as b_addresscre from m_request where msisdnreq= $xphonecre_id";
		$res = mysqli_query($con, $qry);
		if(mysqli_num_rows($res) > 0) {
			echo '<option value="">------- Select -------</option>';
			while($row = mysqli_fetch_object($res)) {
				echo '<option value="'.$row->b_addresscre.'">'.$row->b_addresscre.'</option>';
			}
		} else {
			echo '<option value="">No Record</option>';
		}
	
    } 
    
    if (isset($_POST['b_addresscre'])) {

        $xphonecre_idx = $_POST['b_addresscre'];
        
        $qry = "select 	order_rpt_address as b_addresscrex from m_p_receipt where order_address = '$xphonecre_idx'";
	
		//$qry = "select b_address as b_addresscrex from m_user where b_address = '$xphonecre_idx'";
		$res = mysqli_query($con, $qry);
		if(mysqli_num_rows($res) > 0) {
			echo '<option value="">------- Select -------</option>';
			while($row = mysqli_fetch_object($res)) {
				echo '<option value="'.$row->b_addresscrex.'">'.$row->b_addresscrex.'</option>';
			}
		} else {
			echo '<option value="">No Record</option>';
		}
	
	} 


    if (isset($_POST['cerwphonecre_id'])) {

        $xcerwphonecre_id = $_POST['cerwphonecre_id'];
        
        
	
		$qry = "select b_address as cerb_addresscre from m_user where wphone= $xcerwphonecre_id";
		$res = mysqli_query($con, $qry);
		if(mysqli_num_rows($res) > 0) {
			echo '<option value="">------- Select -------</option>';
			while($row = mysqli_fetch_object($res)) {
				echo '<option value="'.$row->cerb_addresscre.'">'.$row->cerb_addresscre.'</option>';
			}
		} else {
			echo '<option value="">No Record</option>';
		}
	
    } 


	




	
	
	
	
	
	
	
	$pos = new pos();
	$method=$_POST['method'];
	if($method == 'get_detail_cre')
	{
		$id_cre=$_POST['id_cre'];
		$pos = new pos();
		$data = $pos->getcre($id_cre);
		$array['data'] = $data[1];
		$array['result'] = $data[0];
		echo json_encode($array);
	}
	if($method == 'save_cre')
	{

		$idcre = $_POST['id_cre'];
		$cre_name = $_POST['cre_name'];
		$transaction_type = $_POST['transaction_type'];
		$msisdncre = $_POST['msisdncre'];
		$oaddresscre = $_POST['oaddresscre'];
		$cermsisdncre = $_POST['cermsisdncre'];
		$ceraddresscre = $_POST['ceraddresscre'];
		$oreceipt = $_POST['oreceiptcre'];
		$passcre = md5($_POST['passcre']);
		$crud=$_POST['crud'];
		$pos = new pos();
		if($_POST['crud'] == 'N')
		{
			$order_rpt_address = 0;
			$outprt=0;
			$outprtd =0;

			$transaction_type = str_replace("1","",$transaction_type);

//--------------------Block import------

$tpos = new pos();
$block = $tpos->getblockadd($_SESSION['pos_username']);
$walletno = $block[1]['wphone'];
$wallet_address = $block[1]['b_address'];
$b_token = $block[1]['b_token'];

//---------------------Block begins------------------------
$t1pos = new pos();
$block1 = $t1pos->getblockpass($cermsisdncre);
//$walletno1 = $block1[1]['wphone'];
//$wallet_address1 = $block1[1]['b_address'];
//$b_token1 = $block1[1]['b_token'];
$u_pass1 = $block1[1]['pass'];







if(($passcre == $u_pass1)&&($transaction_type == 'certify')){

$curl = curl_init();

curl_setopt_array($curl, array(
  CURLOPT_URL => 'https://www.agrikore.net/preceipt/unsafe/tx/{"'."op".'":"'.'certify",'.'"order'.'":"'.$oaddresscre.'",'.'"receipt'.'":"'.$oreceipt.'",'.'"certifier'.'":"'.$ceraddresscre.'",'.'"certifierpwd'.'":"'.$passcre.'"}',
  //'https://www.agrikore.net/preceipt/unsafe/ad/{"'."op".'":"'.'certify",'.'"certifier'.'":"'.$ceraddresscre.'",'.'"certifierpwd'.'":"'.$passcre.'",'.'"order'.'":"'.$oaddresscre.'",'.'"receipt'.'":"'.$oreceipt.'"}', 
  CURLOPT_RETURNTRANSFER => true,
  CURLOPT_ENCODING => "",
  CURLOPT_MAXREDIRS => 10,
  CURLOPT_TIMEOUT => 300,
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
  sleep(30);
  
  if($receiptimp != '' || $receiptimp != Null || $receiptimp != 'Connection Error'){ 
  
    $ctr = 1;
  
    while($ctr++ < 105){//while loop
  
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
        $array = $pos->saveCre($cre_name,$transaction_type,$msisdncre,$oaddresscre,$oreceipt,$cermsisdncre,$ceraddresscre,$passcre,$out);

            
      }else{
  
    //echo "<br> Everything failed<br>";
    $array = false;
  }
  
}


if(($passcre == $u_pass1)&&($transaction_type == 'addgenericrole')){

	$curl = curl_init();
	
	curl_setopt_array($curl, array(
		CURLOPT_URL => 'https://www.agrikore.net/preceipt/unsafe/ad/{"'."op".'":"'.$transaction_type.'",'.'"admin'.'":"'.'0x2d2d8721fcacb58c7f5f2946bdcc487629da2d64",'.'"adminpwd'.'":"'.'agrikore",'.'"order'.'":"'.$oaddresscre.'",'.'"receipt'.'":"'.$oreceipt.'",'.'"genericrole'.'":"'.$ceraddresscre.'"}',
		//'https://www.agrikore.net/preceipt/unsafe/tx/{"'."op".'":"'.'addgenericrole",'.'"order'.'":"'.$oaddresscre.'",'.'"receipt'.'":"'.$oreceipt.'",'.'"certifier'.'":"'.$ceraddresscre.'",'.'"certifierpwd'.'":"'.$passcre.'"}',
		//'https://www.agrikore.net/preceipt/unsafe/ad/{"'."op".'":"'.'certify",'.'"certifier'.'":"'.$ceraddresscre.'",'.'"certifierpwd'.'":"'.$passcre.'",'.'"order'.'":"'.$oaddresscre.'",'.'"receipt'.'":"'.$oreceipt.'"}', 
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
		sleep(30);
		
		if($receiptimp != '' || $receiptimp != Null || $receiptimp != 'Connection Error'){ 
		
			$ctr = 1;
		
			while($ctr++ < 105){//while loop
		
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
					$array = $pos->saveCre($cre_name,$transaction_type,$msisdncre,$oaddresscre,$oreceipt,$cermsisdncre,$ceraddresscre,$passcre,$out);
	
							
				}else{
		
			//echo "<br> Everything failed<br>";
			$array = false;
		}
		
	}
	








if(($passcre == $u_pass1)&&($transaction_type == 'confirmdelivery')){

	$curl = curl_init();
	
	curl_setopt_array($curl, array(
	  CURLOPT_URL => 'https://www.agrikore.net/preceipt/unsafe/tx/{"'."op".'":"'.'confirmdelivery",'.'"buyer'.'":"'.$ceraddresscre.'",'.'"buyerpwd'.'":"'.$passcre.'",'.'"order'.'":"'.$oaddresscre.'",'.'"receipt'.'":"'.$oreceipt.'"}',
	  //'https://www.agrikore.net/preceipt/unsafe/tx/{"'."op".'":"'.'certify",'.'"order'.'":"'.$oaddresscre.'",'.'"receipt'.'":"'.$oreceipt.'",'.'"certifier'.'":"'.$ceraddresscre.'",'.'"certifierpwd'.'":"'.$passcre.'"}',
	  //'https://www.agrikore.net/preceipt/unsafe/ad/{"'."op".'":"'.'certify",'.'"certifier'.'":"'.$ceraddresscre.'",'.'"certifierpwd'.'":"'.$passcre.'",'.'"order'.'":"'.$oaddresscre.'",'.'"receipt'.'":"'.$oreceipt.'"}', 
	  CURLOPT_RETURNTRANSFER => true,
	  CURLOPT_ENCODING => "",
	  CURLOPT_MAXREDIRS => 10,
	  CURLOPT_TIMEOUT => 300,
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
	  sleep(30);
	  
	  if($receiptimp != '' || $receiptimp != Null || $receiptimp != 'Connection Error'){ 
	  
		$ctr = 1;
	  
		while($ctr++ < 105){//while loop
	  
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
			$array = $pos->saveCre($cre_name,$transaction_type,$msisdncre,$oaddresscre,$oreceipt,$cermsisdncre,$ceraddresscre,$passcre,$out);
	
				
		  }else{
	  
		//echo "<br> Everything failed<br>";
		$array = false;
	  }
	  
	}
	
	
			if($array[0] == true)
			{
				$result['id_cre'] = $array[2];
			}
			
		}
		else
		{
			$array = $pos->updateCre($idcre,$cre_name,$transaction_type,$msisdncre,$oaddresscre,$oreceipt,$cermsisdncre,$ceraddresscre,$passcre,$outcre);
		}
		$result['result'] = $array[0];
		$result['error'] = $array[1];
		$result['crud'] = $_POST['crud'];
		echo json_encode($result);
	}
	
	if($method == 'getdata'){
		$pos = new pos();
		$array = $pos->getListcre();
		$data = $array[1];
		$i=0;
		foreach ($data as $key) {
			$button = '<button  type="submit" id_cre="'.$key['id_cre'].'"  title="Tombol edit barang" class="btn btn-sm btn-primary btneditcre "  id="btneditcre'.$key['id_cre'].'"  ><i class="fa fa-edit"></i></button> <button  type="submit" id_cre="'.$key['id_cre'].'"  title="Tombol hapus barang" class="btn btn-danger btn-sm btndeletecre "  id="btndeletecre'.$key['id_cre'].'"  ><i class="fa fa-trash"></i></button>';

			
			//$data[$i]['am'] =  number_format($data[$i]['amount']);
			$data[$i]['DT_RowId']= $data[$i]['id_cre'];
			//$data[$i]['quantity']= number_format($data[$i]['quantity']);
			$data[$i]['button'] = $button;
			$i++;
		}
		$datax = array('data' => $data);
		echo json_encode($datax);
	}
	if($method == 'delete_cre'){
		$id_cre=$_POST['id_cre'];
		$pos = new pos();
		$array = $pos->deletecre($id_cre);
		$data['result'] = $array[0];
		$data['error'] = $array[1];
		echo json_encode($data);
	}
	
} else {
	exit('No direct access allowed.');
}