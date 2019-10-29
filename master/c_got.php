<?php
session_start();
require_once ("../model/dbconn.php");
require_once ("../model/pos.php");
include('db.php');
if( isset( $_SERVER['HTTP_X_REQUESTED_WITH'] ) && ( $_SERVER['HTTP_X_REQUESTED_WITH'] == 'XMLHttpRequest' ) )
{

	if (isset($_POST['wphonegot_id'])) {

		$xphonegot_id = $_POST['wphonegot_id'];
	
		$qry = "select b_address as b_addressgot from m_user where wphone= $xphonegot_id";
		$res = mysqli_query($con, $qry);
		if(mysqli_num_rows($res) > 0) {
			echo '<option value="">------- Select -------</option>';
			while($row = mysqli_fetch_object($res)) {
				echo '<option value="'.$row->b_addressgot.'">'.$row->b_addressgot.'</option>';
			}
		} else {
			echo '<option value="">No Record</option>';
		}
	
    } 
    
    if (isset($_POST['b_addressgot'])) {

        $xphonegot_idx = $_POST['b_addressgot'];
        
        //$qry = "select order_address as b_addressgotx from m_request where addressreq = '$xphonegot_idx'";


        $qry = "select order_address as b_addressgotx,concat(concat(concat(concat(request_name,'-'),order_address),'-'),date_created) as b_addressgotx_tit 
               from m_request where addressreq = '$xphonegot_idx' 
                UNION
                select a.loanaddr as b_addressgotx,concat(concat(concat(concat(a.transaction_type,'-'),a.loanaddr),'-'),a.date_created) as b_addressgotx_tit 
                from m_agloan a,m_got t
                where a.loanaddr = t.order_address
                and t.transaction_type = 'approveloan'
                and t.tran_status like '%mula-100-Success,agroloan-100-Success,agroloan-100-Success,agroloan-100-Success,agroloanproc-100-Success%'
                and lonaddress = '$xphonegot_idx'  
                and tran_script like '%farmer-100-Success,loaner-100-Success%' 
                and transfer like '%mula-100-Success,mula-100-Success%'
                UNION
                select loanaddr as b_addressgotx,concat(concat(concat(concat(transaction_type,'-'),loanaddr),'-'),date_created) as b_addressgotx_tit
                 from m_agloan where lonaddress = '$xphonegot_idx' 
                and tran_acct like '%mulaloan-100-Success%'
                and transfer like '%mula-100-Success,mula-100-Success%'";
	
		//$qry = "select b_address as b_addressgotx from m_user where b_address = '$xphonegot_idx'";
		$res = mysqli_query($con, $qry);
		if(mysqli_num_rows($res) > 0) {
			echo '<option value="">------- Select -------</option>';
			while($row = mysqli_fetch_object($res)) {
				echo '<option value="'.$row->b_addressgotx.'">'.$row->b_addressgotx_tit.'</option>';
			}
		} else {
			echo '<option value="">No Record</option>';
		}
	
	} 


    if (isset($_POST['offwphonegot_id'])) {

        $xoffwphonegot_id = $_POST['offwphonegot_id'];
        
        
	
		$qry = "select b_address as offb_addressgot from m_user where wphone= $xoffwphonegot_id";
		$res = mysqli_query($con, $qry);
		if(mysqli_num_rows($res) > 0) {
			echo '<option value="">------- Select -------</option>';
			while($row = mysqli_fetch_object($res)) {
				echo '<option value="'.$row->offb_addressgot.'">'.$row->offb_addressgot.'</option>';
			}
		} else {
			echo '<option value="">No Record</option>';
		}
	
    } 




	$pos = new pos();
	$method=$_POST['method'];
	if($method == 'get_detail_got')
	{
		$id_got=$_POST['id_got'];
		$pos = new pos();
		$data = $pos->getgot($id_got);
		$array['data'] = $data[1];
		$array['result'] = $data[0];
		echo json_encode($array);
	}
	if($method == 'save_got')
	{
		$idgot = $_POST['id_got'];
        $namegot = $_POST['got_name'];
        $transaction_type = $_POST['transaction_type'];
        $passgot = md5($_POST['passgot']);
        $amount = $_POST['amount']*1000000000000000000;
        $order_address = $_POST['order_address'];
		$addressgot = $_POST['addressgot'];
		$msisdngot = $_POST['msisdngot'];
        $offaddressgot = $_POST['offaddressgot'];
		$offmsisdngot = $_POST['offmsisdngot'];
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
    $block1 = $t1pos->getblockpass($msisdngot);
    //$walletno1 = $block1[1]['wphone'];
    //$wallet_address1 = $block1[1]['b_address'];
    //$b_token1 = $block1[1]['b_token'];
    $u_pass1 = $block1[1]['pass'];
    
    $transaction_type = str_replace("1","",$transaction_type);

  
    if(($transaction_type =='admintransfernofee')&&($passgot == $u_pass1 )){ 
    
        $curl = curl_init();

        curl_setopt_array($curl, array(
          CURLOPT_URL => 'https://www.agrikore.net/mula/unsafe/ad/{"'."op".'":"'.'admintransfernofee",'.'"admin'.'":"'.'0x2d2d8721fcacb58c7f5f2946bdcc487629da2d64",'.'"adminpwd'.'":"'.'agrikore",'.'"from'.'":"'.$addressgot.'",'.'"to'.'":"'.$order_address.'",'.'"val'.'":"'.$amount.'"}',
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
        
        $responseadf = curl_exec($curl);
        $err = curl_error($curl);
        
        curl_close($curl);
    
    if ($err) {
      //$receipt2 = "Connection Error:" . $err;
      $receiptadf = "Connection Error";
    } else {
    
      $newresponseadf = str_replace('"',"",$responseadf);
        $receiptadf = str_replace('{}',"",$newresponseadf);
    
        //echo "<br> tran_id2 -".$tran_id2;
        //echo "<br> response2 1-".$receipt2;
        //echo "<br> response2 1-".$receiptx;
        
    }
    
    // sleep for 10 seconds
    sleep(10);
    
    if($receiptadf != '' || $receiptadf != Null || $receiptadf != 'Connection Error'){ 
    
        $ctr = 1;
    
        while($ctr++ < 305){//while loop
    
     $curl = curl_init();
        curl_setopt_array($curl, array(
        CURLOPT_URL => 'https://www.agrikore.net/transactionreceipts/'.$receiptadf,
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
        
        $responseadf = curl_exec($curl);
        $err = curl_error($curl);
        
        curl_close($curl);
    
        if ($err) {
        //echo "cURL Error #:" . $err;
        $erroradf = "Empty reply from server";
        } else {
         $echo = $responseadf;
        }
    
        //echo "<br> response3 :".$response3;
        //$ctr++;
        if ($responseadf != "Cannot find the transaction or it's receipt" || $responseadf != "" || $erroradf != "Empty reply from server" || substr($responseadf,0,33) != "Cannot find the transaction or it") {
        break;    /* You could also write 'break 1;' here. */
    }
        
    }//while loop off
    //	echo "<br> response3-out :".$response3;
     // echo "<br> Reciept query :".$response3."<br>";
        $json_o = json_decode($responseadf,true);
    
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
                $array = $pos->saveGot($namegot,$transaction_type,$msisdngot,$addressgot,$amount,$passgot,$order_address,$offmsisdngot,$offaddressgot,$out);
                
            }else{
    
        //echo "<br> Everything failed<br>";
        $array = false;
    }
    
    }


    
    if(($transaction_type =='addfunds')&&($passgot == $u_pass1 )){ 
    
        $curl = curl_init();

        curl_setopt_array($curl, array(
          CURLOPT_URL => 'https://www.agrikore.net/gorder/unsafe/tx/{"'."op".'":"'.'addfunds",'.'"buyer'.'":"'.$addressgot.'",'.'"buyerpwd'.'":"'.$passgot.'",'.'"order'.'":"'.$order_address.'",'.'"amount'.'":"'.$amount.'"}',
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
        
        $responseadf = curl_exec($curl);
        $err = curl_error($curl);
        
        curl_close($curl);
    
    if ($err) {
      //$receipt2 = "Connection Error:" . $err;
      $receiptadf = "Connection Error";
    } else {
    
      $newresponseadf = str_replace('"',"",$responseadf);
        $receiptadf = str_replace('{}',"",$newresponseadf);
    
        //echo "<br> tran_id2 -".$tran_id2;
        //echo "<br> response2 1-".$receipt2;
        //echo "<br> response2 1-".$receiptx;
        
    }
    
    // sleep for 10 seconds
    sleep(10);
    
    if($receiptadf != '' || $receiptadf != Null || $receiptadf != 'Connection Error'){ 
    
        $ctr = 1;
    
        while($ctr++ < 305){//while loop
    
     $curl = curl_init();
        curl_setopt_array($curl, array(
        CURLOPT_URL => 'https://www.agrikore.net/transactionreceipts/'.$receiptadf,
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
        
        $responseadf = curl_exec($curl);
        $err = curl_error($curl);
        
        curl_close($curl);
    
        if ($err) {
        //echo "cURL Error #:" . $err;
        $erroradf = "Empty reply from server";
        } else {
         $echo = $responseadf;
        }
    
        //echo "<br> response3 :".$response3;
        //$ctr++;
        if ($responseadf != "Cannot find the transaction or it's receipt" || $responseadf != "" || $erroradf != "Empty reply from server" || substr($responseadf,0,33) != "Cannot find the transaction or it") {
        break;    /* You could also write 'break 1;' here. */
    }
        
    }//while loop off
    //	echo "<br> response3-out :".$response3;
     // echo "<br> Reciept query :".$response3."<br>";
        $json_o = json_decode($responseadf,true);
    
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
                $array = $pos->saveGot($namegot,$transaction_type,$msisdngot,$addressgot,$amount,$passgot,$order_address,$offmsisdngot,$offaddressgot,$out);
                
            }else{
    
        //echo "<br> Everything failed<br>";
        $array = false;
    }
    
    }

    
    if(($transaction_type =='payloan')&&($passgot == $u_pass1 )){ 
    
        $curl = curl_init();

        curl_setopt_array($curl, array(
          CURLOPT_URL => 'https://www.agrikore.net/agloan/unsafe/tx/{"'."op".'":"'.'payloan",'.'"farmer'.'":"'.$addressgot.'",'.'"farmerpwd'.'":"'.$passgot.'",'.'"loan'.'":"'.$order_address.'",'.'"val'.'":"'.$amount.'"}',
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
        
        $responseadf = curl_exec($curl);
        $err = curl_error($curl);
        
        curl_close($curl);
    
    if ($err) {
      //$receipt2 = "Connection Error:" . $err;
      $receiptadf = "Connection Error";
    } else {
    
      $newresponseadf = str_replace('"',"",$responseadf);
        $receiptadf = str_replace('{}',"",$newresponseadf);
    
        //echo "<br> tran_id2 -".$tran_id2;
        //echo "<br> response2 1-".$receipt2;
        //echo "<br> response2 1-".$receiptx;
        
    }
    
    // sleep for 10 seconds
    sleep(10);
    
    if($receiptadf != '' || $receiptadf != Null || $receiptadf != 'Connection Error'){ 
    
        $ctr = 1;
    
        while($ctr++ < 305){//while loop
    
     $curl = curl_init();
        curl_setopt_array($curl, array(
        CURLOPT_URL => 'https://www.agrikore.net/transactionreceipts/'.$receiptadf,
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
        
        $responseadf = curl_exec($curl);
        $err = curl_error($curl);
        
        curl_close($curl);
    
        if ($err) {
        //echo "cURL Error #:" . $err;
        $erroradf = "Empty reply from server";
        } else {
         $echo = $responseadf;
        }
    
        //echo "<br> response3 :".$response3;
        //$ctr++;
        if ($responseadf != "Cannot find the transaction or it's receipt" || $responseadf != "" || $erroradf != "Empty reply from server" || substr($responseadf,0,33) != "Cannot find the transaction or it") {
        break;    /* You could also write 'break 1;' here. */
    }
        
    }//while loop off
    //	echo "<br> response3-out :".$response3;
     // echo "<br> Reciept query :".$response3."<br>";
        $json_o = json_decode($responseadf,true);
    
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
                $array = $pos->saveGot($namegot,$transaction_type,$msisdngot,$addressgot,$amount,$passgot,$order_address,$offmsisdngot,$offaddressgot,$out);
                
            }else{
    
        //echo "<br> Everything failed<br>";
        $array = false;
    }
    
    }

   
    if(($transaction_type =='spendloan')&&($passgot == $u_pass1 )){ 
    
        $curl = curl_init();

        curl_setopt_array($curl, array(
          CURLOPT_URL => 'https://www.agrikore.net/agloan/unsafe/tx/{"'."op".'":"'.'spendloan",'.'"farmer'.'":"'.$addressgot.'",'.'"farmerpwd'.'":"'.$passgot.'",'.'"loan'.'":"'.$order_address.'",'.'"dealer'.'":"'.$offaddressgot.'",'.'"val'.'":"'.$amount.'"}',
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
        
        $responseadf = curl_exec($curl);
        $err = curl_error($curl);
        
        curl_close($curl);
    
    if ($err) {
      //$receipt2 = "Connection Error:" . $err;
      $receiptadf = "Connection Error";
    } else {
    
      $newresponseadf = str_replace('"',"",$responseadf);
        $receiptadf = str_replace('{}',"",$newresponseadf);
    
        //echo "<br> tran_id2 -".$tran_id2;
        //echo "<br> response2 1-".$receipt2;
        //echo "<br> response2 1-".$receiptx;
        
    }
    
    // sleep for 10 seconds
    sleep(10);
    
    if($receiptadf != '' || $receiptadf != Null || $receiptadf != 'Connection Error'){ 
    
        $ctr = 1;
    
        while($ctr++ < 305){//while loop
    
     $curl = curl_init();
        curl_setopt_array($curl, array(
        CURLOPT_URL => 'https://www.agrikore.net/transactionreceipts/'.$receiptadf,
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
        
        $responseadf = curl_exec($curl);
        $err = curl_error($curl);
        
        curl_close($curl);
    
        if ($err) {
        //echo "cURL Error #:" . $err;
        $erroradf = "Empty reply from server";
        } else {
         $echo = $responseadf;
        }
    
        //echo "<br> response3 :".$response3;
        //$ctr++;
        if ($responseadf != "Cannot find the transaction or it's receipt" || $responseadf != "" || $erroradf != "Empty reply from server" || substr($responseadf,0,33) != "Cannot find the transaction or it") {
        break;    /* You could also write 'break 1;' here. */
    }
        
    }//while loop off
    //	echo "<br> response3-out :".$response3;
     // echo "<br> Reciept query :".$response3."<br>";
        $json_o = json_decode($responseadf,true);
    
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
                $array = $pos->saveGot($namegot,$transaction_type,$msisdngot,$addressgot,$amount,$passgot,$order_address,$offmsisdngot,$offaddressgot,$out);
                
            }else{
    
        //echo "<br> Everything failed<br>";
        $array = false;
    }
    
    }

   





    if($transaction_type =='addofftaker' || $transaction_type =='removeofftaker'){ 



        $curl = curl_init();

curl_setopt_array($curl, array(
  CURLOPT_URL => 'https://www.agrikore.net/gorder/unsafe/tx/{"'."op".'":"'.$transaction_type.'",'.'"buyer'.'":"'.$addressgot.'",'.'"buyerpwd'.'":"'.$passgot.'",'.'"order'.'":"'.$order_address.'",'.'"offtaker'.'":"'.$offaddressgot.'"}',
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

$responseoff = curl_exec($curl);
$err = curl_error($curl);

curl_close($curl);

if ($err) {
  echo "cURL Error #:" . $err;
} else {
  //echo $response;
  $receiptoff = str_replace('"',"",$responseoff);
}
 
/**
        $curl = curl_init();

        curl_setopt_array($curl, array(
          CURLOPT_URL => 'https://www.agrikore.net/gorder/unsafe/tx/{"'."op".'":"'.'addofftaker",'.'"buyer'.'":"'.$addressgot.'",'.'"buyerpwd'.'":"'.$passgot.'",'.'"order'.'":"'.$order_address.'",'.'"offtaker'.'":"'.$offaddressgot.'"}',
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
        
        $responseoff = curl_exec($curl);
        $err = curl_error($curl);
        
        curl_close($curl);
        
    if ($err) {
      //$receipt2 = "Connection Error:" . $err;
      $receiptoff = "Connection Error";
    } else {
    
      $newresponseoff = str_replace('"',"",$responseoff);
        $receiptoff = str_replace('{}',"",$newresponseoff);
    
        //echo "<br> tran_id2 -".$tran_id2;
        //echo "<br> response2 1-".$receipt2;
        echo "<br> Receipt 1-".$receiptoff;
        
    }
     */
    // sleep for 10 seconds
    sleep(10);
    
    if($receiptoff != '' || $receiptoff != Null || $receiptoff != 'Connection Error'){ 
    
        $ctr = 1;
    
        while($ctr++ < 305){//while loop
    
     $curl = curl_init();
        curl_setopt_array($curl, array(
        CURLOPT_URL => 'https://www.agrikore.net/transactionreceipts/'.$receiptoff,
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
        
        $responseoff = curl_exec($curl);
        $err = curl_error($curl);
        
        curl_close($curl);
    
        if ($err) {
        //echo "cURL Error #:" . $err;
        $erroroff = "Empty reply from server";
        } else {
         $echo = $responseoff;
        }
    
        //echo "<br> response3 :".$response3;
        //$ctr++;
        if ($responseoff != "Cannot find the transaction or it's receipt" || $responseoff != "" || $erroroff != "Empty reply from server" || substr($responseoff,0,33) != "Cannot find the transaction or it") {
        break;    /* You could also write 'break 1;' here. */
    }
        
    }//while loop off
    	//echo "<br> Receipt-out :".$responseoff;
     // echo "<br> Reciept query :".$response3."<br>";
        $json_oa = json_decode($responseoff,true);
    
                $result = array();
                $out = "Status :";
    
                foreach ($json_oa['events'] as $theentity) {
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
                $array = $pos->saveGot($namegot,$transaction_type,$msisdngot,$addressgot,$amount,$passgot,$order_address,$offmsisdngot,$offaddressgot,$out);
                
            }else{
    
        //echo "<br> Everything failed<br>";
        $array = false;
    }
    
    }
    
    if($transaction_type =='addgenericrole' || $transaction_type =='removegenericrole'){ 



        $curl = curl_init();

curl_setopt_array($curl, array(
  CURLOPT_URL => 'https://www.agrikore.net/preceipt/unsafe/ad/{"'."op".'":"'.$transaction_type.'",'.'"buyer'.'":"'.$addressgot.'",'.'"buyerpwd'.'":"'.$passgot.'",'.'"order'.'":"'.$order_address.'",'.'"offtaker'.'":"'.$offaddressgot.'"}',
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

$responseoff = curl_exec($curl);
$err = curl_error($curl);

curl_close($curl);

if ($err) {
  echo "cURL Error #:" . $err;
} else {
  //echo $response;
  $receiptoff = str_replace('"',"",$responseoff);
}
 
/**
        $curl = curl_init();

        curl_setopt_array($curl, array(
          CURLOPT_URL => 'https://www.agrikore.net/gorder/unsafe/tx/{"'."op".'":"'.'addofftaker",'.'"buyer'.'":"'.$addressgot.'",'.'"buyerpwd'.'":"'.$passgot.'",'.'"order'.'":"'.$order_address.'",'.'"offtaker'.'":"'.$offaddressgot.'"}',
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
        
        $responseoff = curl_exec($curl);
        $err = curl_error($curl);
        
        curl_close($curl);
        
    if ($err) {
      //$receipt2 = "Connection Error:" . $err;
      $receiptoff = "Connection Error";
    } else {
    
      $newresponseoff = str_replace('"',"",$responseoff);
        $receiptoff = str_replace('{}',"",$newresponseoff);
    
        //echo "<br> tran_id2 -".$tran_id2;
        //echo "<br> response2 1-".$receipt2;
        echo "<br> Receipt 1-".$receiptoff;
        
    }
     */
    // sleep for 10 seconds
    sleep(10);
    
    if($receiptoff != '' || $receiptoff != Null || $receiptoff != 'Connection Error'){ 
    
        $ctr = 1;
    
        while($ctr++ < 305){//while loop
    
     $curl = curl_init();
        curl_setopt_array($curl, array(
        CURLOPT_URL => 'https://www.agrikore.net/transactionreceipts/'.$receiptoff,
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
        
        $responseoff = curl_exec($curl);
        $err = curl_error($curl);
        
        curl_close($curl);
    
        if ($err) {
        //echo "cURL Error #:" . $err;
        $erroroff = "Empty reply from server";
        } else {
         $echo = $responseoff;
        }
    
        //echo "<br> response3 :".$response3;
        //$ctr++;
        if ($responseoff != "Cannot find the transaction or it's receipt" || $responseoff != "" || $erroroff != "Empty reply from server" || substr($responseoff,0,33) != "Cannot find the transaction or it") {
        break;    /* You could also write 'break 1;' here. */
    }
        
    }//while loop off
    	//echo "<br> Receipt-out :".$responseoff;
     // echo "<br> Reciept query :".$response3."<br>";
        $json_oa = json_decode($responseoff,true);
    
                $result = array();
                $out = "Status :";
    
                foreach ($json_oa['events'] as $theentity) {
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
                $array = $pos->saveGot($namegot,$transaction_type,$msisdngot,$addressgot,$amount,$passgot,$order_address,$offmsisdngot,$offaddressgot,$out);
                
            }else{
    
        //echo "<br> Everything failed<br>";
        $array = false;
    }
    
    }
   

    if(($transaction_type =='approve')&&($passgot == $u_pass1 )){ 
    
        $curl = curl_init();

        curl_setopt_array($curl, array(
          CURLOPT_URL => 'https://www.agrikore.net/gorder/unsafe/tx/{"'."op".'":"'.$transaction_type.'",'.'"buyer'.'":"'.$addressgot.'",'.'"buyerpwd'.'":"'.$passgot.'",'.'"order'.'":"'.$order_address.'"}',
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
        
        $responseapp = curl_exec($curl);
        $err = curl_error($curl);
        
        curl_close($curl);
    
    if ($err) {
      //$receipt2 = "Connection Error:" . $err;
      $receiptapp = "Connection Error";
    } else {
    
      $newresponseapp = str_replace('"',"",$responseapp);
     $receiptapp = str_replace('{}',"",$newresponseapp);
    
        //echo "<br> tran_id2 -".$tran_id2;
        //echo "<br> response2 1-".$receipt2;
        //echo "<br> b_token".$b_token;
        //echo "<br> receiptapp".$receiptapp;
        //echo "<br> transaction_type".$transaction_type;
        //echo "<br> addressgot".$addressgot;
        //echo "<br> passgot".$passgot;
        //echo "<br> order_address".$order_address;
        
    }
    
    // sleep for 10 seconds
    sleep(10);
    
    if($receiptapp != '' || $receiptapp != Null || $receiptapp != 'Connection Error'){ 
    
        $ctr = 1;
    
        while($ctr++ < 305){//while loop
    
     $curl = curl_init();
        curl_setopt_array($curl, array(
        CURLOPT_URL => 'https://www.agrikore.net/transactionreceipts/'.$receiptapp,
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
        
        $responseapp = curl_exec($curl);
        $err = curl_error($curl);
        
        curl_close($curl);
    
        if ($err) {
        //echo "cURL Error #:" . $err;
        $errorapp = "Empty reply from server";
        } else {
         $echo = $responseapp;
        }
    
        //echo "<br> response3 :".$response3;
        //$ctr++;
        if ($responseapp != "Cannot find the transaction or it's receipt" || $responseapp != "" || $errorapp != "Empty reply from server" || substr($responseapp,0,33) != "Cannot find the transaction or it") {
        break;    /* You could also write 'break 1;' here. */
    }
        
    }//while loop off
    //	echo "<br> response3-out :".$response3;
      //echo "<br> Reciept query :".$responseapp."<br>";
        $json_o = json_decode($responseapp,true);
    
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
                $array = $pos->saveGot($namegot,$transaction_type,$msisdngot,$addressgot,$amount,$passgot,$order_address,$offmsisdngot,$offaddressgot,$out);
                
            }else{
    
        //echo "<br> Everything failed<br>";
        $array = false;
    }
    
    }


    if(($transaction_type =='approveloan')&&($passgot == $u_pass1 )){ 
    
        $curl = curl_init();

        curl_setopt_array($curl, array(
          CURLOPT_URL => 'https://www.agrikore.net/agloan/unsafe/tx/{"'."op".'":"'.$transaction_type.'",'.'"loaner'.'":"'.$addressgot.'",'.'"loanerpwd'.'":"'.$passgot.'",'.'"loan'.'":"'.$order_address.'"}',
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
        
        $responseapp = curl_exec($curl);
        $err = curl_error($curl);
        
        curl_close($curl);
    
    if ($err) {
      //$receipt2 = "Connection Error:" . $err;
      $receiptapp = "Connection Error";
    } else {
    
      $newresponseapp = str_replace('"',"",$responseapp);
     $receiptapp = str_replace('{}',"",$newresponseapp);
    
        //echo "<br> tran_id2 -".$tran_id2;
        //echo "<br> response2 1-".$receipt2;
        //echo "<br> b_token".$b_token;
        //echo "<br> receiptapp".$receiptapp;
        //echo "<br> transaction_type".$transaction_type;
        //echo "<br> addressgot".$addressgot;
        //echo "<br> passgot".$passgot;
        //echo "<br> order_address".$order_address;
        
    }
    
    // sleep for 10 seconds
    sleep(10);
    
    if($receiptapp != '' || $receiptapp != Null || $receiptapp != 'Connection Error'){ 
    
        $ctr = 1;
    
        while($ctr++ < 305){//while loop
    
     $curl = curl_init();
        curl_setopt_array($curl, array(
        CURLOPT_URL => 'https://www.agrikore.net/transactionreceipts/'.$receiptapp,
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
        
        $responseapp = curl_exec($curl);
        $err = curl_error($curl);
        
        curl_close($curl);
    
        if ($err) {
        //echo "cURL Error #:" . $err;
        $errorapp = "Empty reply from server";
        } else {
         $echo = $responseapp;
        }
    
        //echo "<br> response3 :".$response3;
        //$ctr++;
        if ($responseapp != "Cannot find the transaction or it's receipt" || $responseapp != "" || $errorapp != "Empty reply from server" || substr($responseapp,0,33) != "Cannot find the transaction or it") {
        break;    /* You could also write 'break 1;' here. */
    }
        
    }//while loop off
    //	echo "<br> response3-out :".$response3;
      //echo "<br> Reciept query :".$responseapp."<br>";
        $json_o = json_decode($responseapp,true);
    
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
                $array = $pos->saveGot($namegot,$transaction_type,$msisdngot,$addressgot,$amount,$passgot,$order_address,$offmsisdngot,$offaddressgot,$out);
                
            }else{
    
        //echo "<br> Everything failed<br>";
        $array = false;
    }
    
    }

    if(($transaction_type =='approveloanmula')&&($passgot == $u_pass1 )){ 
    
        $curl = curl_init();

        curl_setopt_array($curl, array(
          CURLOPT_URL => 'https://www.agrikore.net/muloan/unsafe/tx/{"'."op".'":"'.'approveloan",'.'"loaner'.'":"'.$addressgot.'",'.'"loanerpwd'.'":"'.$passgot.'",'.'"loan'.'":"'.$order_address.'"}',
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
        
        $responseapp = curl_exec($curl);
        $err = curl_error($curl);
        
        curl_close($curl);
    
    if ($err) {
      //$receipt2 = "Connection Error:" . $err;
      $receiptapp = "Connection Error";
    } else {
    
      $newresponseapp = str_replace('"',"",$responseapp);
     $receiptapp = str_replace('{}',"",$newresponseapp);
    
        //echo "<br> tran_id2 -".$tran_id2;
        //echo "<br> response2 1-".$receipt2;
        //echo "<br> b_token".$b_token;
        //echo "<br> receiptapp".$receiptapp;
        //echo "<br> transaction_type".$transaction_type;
        //echo "<br> addressgot".$addressgot;
        //echo "<br> passgot".$passgot;
        //echo "<br> order_address".$order_address;
        
    }
    
    // sleep for 10 seconds
    sleep(10);
    
    if($receiptapp != '' || $receiptapp != Null || $receiptapp != 'Connection Error'){ 
    
        $ctr = 1;
    
        while($ctr++ < 305){//while loop
    
     $curl = curl_init();
        curl_setopt_array($curl, array(
        CURLOPT_URL => 'https://www.agrikore.net/transactionreceipts/'.$receiptapp,
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
        
        $responseapp = curl_exec($curl);
        $err = curl_error($curl);
        
        curl_close($curl);
    
        if ($err) {
        //echo "cURL Error #:" . $err;
        $errorapp = "Empty reply from server";
        } else {
         $echo = $responseapp;
        }
    
        //echo "<br> response3 :".$response3;
        //$ctr++;
        if ($responseapp != "Cannot find the transaction or it's receipt" || $responseapp != "" || $errorapp != "Empty reply from server" || substr($responseapp,0,33) != "Cannot find the transaction or it") {
        break;    /* You could also write 'break 1;' here. */
    }
        
    }//while loop off
    //	echo "<br> response3-out :".$response3;
      //echo "<br> Reciept query :".$responseapp."<br>";
        $json_o = json_decode($responseapp,true);
    
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
                $array = $pos->saveGot($namegot,$transaction_type,$msisdngot,$addressgot,$amount,$passgot,$order_address,$offmsisdngot,$offaddressgot,$out);
                
            }else{
    
        //echo "<br> Everything failed<br>";
        $array = false;
    }
    
    }


    if(($transaction_type =='addloandisbursemula')&&($passgot == $u_pass1 )){ 
    
        $curl = curl_init();

        curl_setopt_array($curl, array(
          CURLOPT_URL => 'https://www.agrikore.net/muloan/unsafe/tx/{"'."op".'":"'.'addloandisburse",'.'"loaner'.'":"'.$addressgot.'",'.'"loanerpwd'.'":"'.$passgot.'",'.'"loan'.'":"'.$order_address.'",'.'"val'.'":"'.$amount.'"}',
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
        
        $responseapp = curl_exec($curl);
        $err = curl_error($curl);
        
        curl_close($curl);
    
    if ($err) {
      //$receipt2 = "Connection Error:" . $err;
      $receiptapp = "Connection Error";
    } else {
    
      $newresponseapp = str_replace('"',"",$responseapp);
     $receiptapp = str_replace('{}',"",$newresponseapp);
    
        //echo "<br> tran_id2 -".$tran_id2;
        //echo "<br> response2 1-".$receipt2;
        //echo "<br> b_token".$b_token;
        //echo "<br> receiptapp".$receiptapp;
        //echo "<br> transaction_type".$transaction_type;
        //echo "<br> addressgot".$addressgot;
        //echo "<br> passgot".$passgot;
        //echo "<br> order_address".$order_address;
        
    }
    
    // sleep for 10 seconds
    sleep(10);
    
    if($receiptapp != '' || $receiptapp != Null || $receiptapp != 'Connection Error'){ 
    
        $ctr = 1;
    
        while($ctr++ < 305){//while loop
    
     $curl = curl_init();
        curl_setopt_array($curl, array(
        CURLOPT_URL => 'https://www.agrikore.net/transactionreceipts/'.$receiptapp,
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
        
        $responseapp = curl_exec($curl);
        $err = curl_error($curl);
        
        curl_close($curl);
    
        if ($err) {
        //echo "cURL Error #:" . $err;
        $errorapp = "Empty reply from server";
        } else {
         $echo = $responseapp;
        }
    
        //echo "<br> response3 :".$response3;
        //$ctr++;
        if ($responseapp != "Cannot find the transaction or it's receipt" || $responseapp != "" || $errorapp != "Empty reply from server" || substr($responseapp,0,33) != "Cannot find the transaction or it") {
        break;    /* You could also write 'break 1;' here. */
    }
        
    }//while loop off
    //	echo "<br> response3-out :".$response3;
      //echo "<br> Reciept query :".$responseapp."<br>";
        $json_o = json_decode($responseapp,true);
    
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
                $array = $pos->saveGot($namegot,$transaction_type,$msisdngot,$addressgot,$amount,$passgot,$order_address,$offmsisdngot,$offaddressgot,$out);
                
            }else{
    
        //echo "<br> Everything failed<br>";
        $array = false;
    }
    
    }



    if(($transaction_type =='addloandisburse')&&($passgot == $u_pass1 )){ 
    
        $curl = curl_init();

        curl_setopt_array($curl, array(
          CURLOPT_URL => 'https://www.agrikore.net/agloan/unsafe/tx/{"'."op".'":"'.'addloandisburse",'.'"loaner'.'":"'.$addressgot.'",'.'"loanerpwd'.'":"'.$passgot.'",'.'"loan'.'":"'.$order_address.'",'.'"val'.'":"'.$amount.'"}',
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
        
        $responseapp = curl_exec($curl);
        $err = curl_error($curl);
        
        curl_close($curl);
    
    if ($err) {
      //$receipt2 = "Connection Error:" . $err;
      $receiptapp = "Connection Error";
    } else {
    
      $newresponseapp = str_replace('"',"",$responseapp);
     $receiptapp = str_replace('{}',"",$newresponseapp);
    
        //echo "<br> tran_id2 -".$tran_id2;
        //echo "<br> response2 1-".$receipt2;
        //echo "<br> b_token".$b_token;
        //echo "<br> receiptapp".$receiptapp;
        //echo "<br> transaction_type".$transaction_type;
        //echo "<br> addressgot".$addressgot;
        //echo "<br> passgot".$passgot;
        //echo "<br> order_address".$order_address;
        
    }
    
    // sleep for 10 seconds
    sleep(10);
    
    if($receiptapp != '' || $receiptapp != Null || $receiptapp != 'Connection Error'){ 
    
        $ctr = 1;
    
        while($ctr++ < 305){//while loop
    
     $curl = curl_init();
        curl_setopt_array($curl, array(
        CURLOPT_URL => 'https://www.agrikore.net/transactionreceipts/'.$receiptapp,
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
        
        $responseapp = curl_exec($curl);
        $err = curl_error($curl);
        
        curl_close($curl);
    
        if ($err) {
        //echo "cURL Error #:" . $err;
        $errorapp = "Empty reply from server";
        } else {
         $echo = $responseapp;
        }
    
        //echo "<br> response3 :".$response3;
        //$ctr++;
        if ($responseapp != "Cannot find the transaction or it's receipt" || $responseapp != "" || $errorapp != "Empty reply from server" || substr($responseapp,0,33) != "Cannot find the transaction or it") {
        break;    /* You could also write 'break 1;' here. */
    }
        
    }//while loop off
    //	echo "<br> response3-out :".$response3;
      //echo "<br> Reciept query :".$responseapp."<br>";
        $json_o = json_decode($responseapp,true);
    
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
                $array = $pos->saveGot($namegot,$transaction_type,$msisdngot,$addressgot,$amount,$passgot,$order_address,$offmsisdngot,$offaddressgot,$out);
                
            }else{
    
        //echo "<br> Everything failed<br>";
        $array = false;
    }
    
    }











    if(($transaction_type =='expireandrefund' || $transaction_type =='suspend' || $transaction_type =='unsuspend' || $transaction_type =='expire' || $transaction_type =='revoke')&&($passgot == $u_pass1 )){ 
    /** 
        $curl = curl_init();

        curl_setopt_array($curl, array(
          CURLOPT_URL => 'https://www.agrikore.net/gorder/unsafe/ad/{"'."op".'":"'.$transaction_type.'",'.'"admin'.'":"'.'0x2d2d8721fcacb58c7f5f2946bdcc487629da2d64",'.'"adminpwd'.'":"'.'agrikore",'.'"order'.'":"'.$order_address.'"}',
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
        
        $responseapp = curl_exec($curl);
        $err = curl_error($curl);
        
        curl_close($curl);
    
    if ($err) {
      //$receipt2 = "Connection Error:" . $err;
      $receiptapp = "Connection Error";
    } else {
    
      $newresponseapp = str_replace('"',"",$responseapp);
      echo "<br> response2 1-".$receiptapp = str_replace('{}',"",$newresponseapp);
    
        //echo "<br> tran_id2 -".$tran_id2;
        //echo "<br> response2 1-".$receipt2;
        //echo "<br> b_token".$b_token;
        //echo "<br> receiptapp".$receiptapp;
        //echo "<br> transaction_type".$transaction_type;
        //echo "<br> addressgot".$addressgot;
        //echo "<br> passgot".$passgot;
        //echo "<br> order_address".$order_address;
        
    }
    */
    $curl = curl_init();

    curl_setopt_array($curl, array(
      CURLOPT_PORT => "8547",
      CURLOPT_URL => "http://41.73.252.237:8547/gorder/unsafe/ad/{%22op%22:%22$transaction_type%22,%22admin%22:%220x2d2d8721fcacb58c7f5f2946bdcc487629da2d64%22,%22adminpwd%22:%22agrikore%22,%22order%22:%22$order_address%22}",
      CURLOPT_RETURNTRANSFER => true,
      CURLOPT_ENCODING => "",
      CURLOPT_MAXREDIRS => 10,
      CURLOPT_TIMEOUT => 30,
      CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
      CURLOPT_CUSTOMREQUEST => "POST",
      CURLOPT_POSTFIELDS => "",
      CURLOPT_HTTPHEADER => array(
        "Cache-Control: no-cache",
        "x-access-token: $b_token"
      ),
    ));
    
    $response = curl_exec($curl);
    $err = curl_error($curl);
    
    curl_close($curl);
    
    if ($err) {
      echo "cURL Error #:" . $err;
    } else {
         $receiptapp = str_replace('"',"",$response);
    }
    // sleep for 10 seconds
    sleep(10);
    
    if($receiptapp != '' || $receiptapp != Null || $receiptapp != 'Connection Error'){ 
    
        $ctr = 1;
    
        while($ctr++ < 305){//while loop
    
     $curl = curl_init();
        curl_setopt_array($curl, array(
        CURLOPT_URL => 'https://www.agrikore.net/transactionreceipts/'.$receiptapp,
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => "",
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 300,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => "GET",
        CURLOPT_HTTPHEADER => array(
            "Cache-Control: no-cache",
            "x-access-token: $b_token"
        ),
        ));
        
        $responseapp = curl_exec($curl);
        $err = curl_error($curl);
        
        curl_close($curl);
    
        if ($err) {
        //echo "cURL Error #:" . $err;
       echo $errorapp = "Empty reply from server";
        } else {
          $echo = $responseapp;
        }
    
        //echo "<br> response3 :".$response3;
        //$ctr++;
        if ($responseapp != "Cannot find the transaction or it's receipt" || $responseapp != "" || $errorapp != "Empty reply from server" || substr($responseapp,0,33) != "Cannot find the transaction or it") {
        break;    /* You could also write 'break 1;' here. */
    }
        
    }//while loop off
    //	echo "<br> response3-out :".$response3;
      //echo "<br> Reciept query :".$responseapp."<br>";
        $json_o = json_decode($responseapp,true);
    
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
                $array = $pos->saveGot($namegot,$transaction_type,$msisdngot,$addressgot,$amount,$passgot,$order_address,$offmsisdngot,$offaddressgot,$out);
                
            }else{
    
        //echo "<br> Everything failed<br>";
        $array = false;
    }
    
    }


    



    		if($array[0] == true)
			{
				$result['id_got'] = $array[2];
			}
			
		}
		else
		{
			$array = $pos->updateGot($idgot,$namegot,$transaction_type,$msisdngot,$addressgot,$amount,$passgot,$order_address,$offmsisdngot,$offaddressgot);
		}
		$result['result'] = $array[0];
		$result['error'] = $array[1];
		$result['crud'] = $_POST['crud'];
		echo json_encode($result);
	}
	
	if($method == 'getdata'){
		$pos = new pos();
		$array = $pos->getListgot();
		$data = $array[1];
		$i=0;
		foreach ($data as $key) {
			$button = '<button  type="submit" id_got="'.$key['id_got'].'"  title="Tombol edit barang" class="btn btn-sm btn-primary btneditgot "  id="btneditgot'.$key['id_got'].'"  ><i class="fa fa-edit"></i></button> <button  type="submit" id_got="'.$key['id_got'].'"  title="Tombol hapus barang" class="btn btn-danger btn-sm btndeletegot "  id="btndeletegot'.$key['id_got'].'"  ><i class="fa fa-trash"></i></button>';

			$data[$i]['got_name'] =  $data[$i]['got_name'];
			//$data[$i]['fprice'] =  number_format($data[$i]['fprice']);
			$data[$i]['DT_RowId']= $data[$i]['id_got'];
			$data[$i]['transaction_type']= $data[$i]['transaction_type'];
			//$data[$i]['terms']= number_format($data[$i]['terms']);
			$data[$i]['button'] = $button;
			$i++;
		}
		$datax = array('data' => $data);
		echo json_encode($datax);
	}
	if($method == 'delete_got'){
		$id_got=$_POST['id_got'];
		$pos = new pos();
		$array = $pos->deletegot($id_got);
		$data['result'] = $array[0];
		$data['error'] = $array[1];
		echo json_encode($data);
	}
	
} else {
	exit('No direct access allowed.');
}