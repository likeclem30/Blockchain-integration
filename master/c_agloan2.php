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


		$outtran = 'loan creation failed.No transfer done';
		$principal = $_POST['principal'];
		$principal_limit = $_POST['principal_limit'];
		$irate = $_POST['irate'];
		$late_pen = $_POST['late_pen'];

		
		$curl = curl_init();

		curl_setopt_array($curl, array(
			CURLOPT_URL => 'https://www.agrikore.net/location/unsafe/ad/{"'."op".'":"'.'addloc",'.'"admin'.'":"'.'0x2d2d8721fcacb58c7f5f2946bdcc487629da2d64",'.'"adminpwd'.'":"'.'agrikore",'.'"name'.'":"'.$payday.'",'.'"coord'.'":"'.$payday.'",'.'"country'.'":"'.$payday.'",'.'"state'.'":"'.$payday.'",'.'"locality'.'":"'.$payday.'",'.'"postal'.'":"'.$payday.'"}',
			CURLOPT_RETURNTRANSFER => true,
			CURLOPT_ENCODING => "",
			CURLOPT_MAXREDIRS => 50,
			CURLOPT_TIMEOUT => 1000,
			CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
			CURLOPT_CUSTOMREQUEST => "POST",
			CURLOPT_HTTPHEADER => array(
				"Cache-Control: no-cache",
				"x-access-token: $b_token"
			),
		));
		
		$response = curl_exec($curl);
		//$response2 = "4";
		$err = curl_error($curl);
		
		curl_close($curl);
		
		if ($err) {
			$oecho = "cURL Error #:" . $err;
		} else {
			$oecho = $response;
			$receipt2 = str_replace('"',"",$response);
		}
		
		// sleep for 10 seconds
		sleep(5);
		
		// $receipt2 = "0x534567808560cdaed18d93025f7dbe0b002f8564a3cc6457bcdced2f63e69cad";
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
					//echo "<br> Status query :".$out."<br>";
		
					$curl = curl_init();
		
					curl_setopt_array($curl, array(
						CURLOPT_URL => "https://www.agrikore.net/location/vw/{%22op%22:%22getlocindex%22,%20%22name%22:%22$agloan_name%22}",
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
					
					$response = curl_exec($curl);
					$err = curl_error($curl);
					
					//curl_close($curl);
					
					if ($err) {
						$echo = "cURL Error #:" . $err;
					} else {
						//echo $response;
						$loci2 = str_replace('"'," ",$response);
					}
					
				
		$array = $pos->saveAgloan("1","2","3","4","5","6","7","8","9","10","11","12","13","14","15","16","17","18","19","20","21");
 //$array = $pos->saveAgloan($agloan_name,$transaction_type,$principal,$principal_limit,$term,$moratorium,$expenses,$irate,$late_pen,$autopay,$payday,$lonmsisdnagloan,$laddr,$benmsisdnagloan,$baddr,$out,$outgdr,$outgac,$outdesc,$outtran,$address2);

		
		}else{
		
			//echo "<br> Everything failed<br>";
			$array = false;
		}
		
		
		
		







		//$array = $pos->saveAgloan("1","2","3","4","5","6","7","8","9","10","11","12","13","14","15","16","17","18","19","20","21");
 //$array = $pos->saveAgloan($agloan_name,$transaction_type,$principal,$principal_limit,$term,$moratorium,$expenses,$irate,$late_pen,$autopay,$payday,$lonmsisdnagloan,$laddr,$benmsisdnagloan,$baddr,$out,$outgdr,$outgac,$outdesc,$outtran,$address2);

	


		

	
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