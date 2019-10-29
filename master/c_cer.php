<?php
session_start();
require_once ("../model/dbconn.php");
require_once ("../model/pos.php");
include('db.php');
if( isset( $_SERVER['HTTP_X_REQUESTED_WITH'] ) && ( $_SERVER['HTTP_X_REQUESTED_WITH'] == 'XMLHttpRequest' ) )
{

	if (isset($_POST['wphonecer_id'])) {

		//$mul_name = $_POST['mul_name'];
		$wphonecer_id = $_POST['wphonecer_id'];
		
		$qry = "select b_address as addresscer_id,concat(username,'-',b_address) as addresscer  from m_user where wphone= '$wphonecer_id' ";
		$res = mysqli_query($con, $qry);
		if(mysqli_num_rows($res) > 0) {
			echo '<option value="">------- Select -------</option>';
			while($row = mysqli_fetch_object($res)) {
				echo '<option value="'.$row->addresscer_id.'">'.$row->addresscer.'</option>';
			}
		} else {
			echo '<option value="">No Record</option>';
		}
	
	}






	$pos = new pos();
	$method=$_POST['method'];
	if($method == 'get_detail_cer')
	{
		$id_cer=$_POST['id_cer'];
		$pos = new pos();
		$data = $pos->getCer($id_cer);
		$array['data'] = $data[1];
		$array['result'] = $data[0];
		echo json_encode($array);
	}
	if($method == 'save_cer')
	{
		$idcer = $_POST['id_cer'];
		$namecer = str_replace(" ","%20",$_POST['cer_name']);
		$loc_name = str_replace(" ","",$_POST['loc_name']);
		$commodity = str_replace(" ","",$_POST['commodity']);
		$msisdncer = $_POST['msisdncer'];
		$addresscer = $_POST['addresscer'];
		$prate = $_POST['prate']*1000000000000000000;
		$frate = $_POST['frate']*1000000000000000000;
		$crud=$_POST['crud'];
		$pos = new pos();
		if($_POST['crud'] == 'N')
		{



			$tpos = new pos();
			$block = $tpos->getblockadd($_SESSION['pos_username']);
			$walletno = $block[1]['wphone'];
			$wallet_address = $block[1]['b_address'];
			$b_token = $block[1]['b_token'];



			$curl = curl_init();

			  curl_setopt_array($curl, array(
				CURLOPT_URL => 'https://www.agrikore.net/certifier/unsafe/ad/{"'."op".'":"'.'addcertifier",'.'"admin'.'":"'.'0x2d2d8721fcacb58c7f5f2946bdcc487629da2d64",'.'"adminpwd'.'":"'.'agrikore",'.'"addr'.'":"'.$addresscer.'",'.'"name'.'":"'.$namecer.'",'.'"loc'.'":"'.$loc_name.'",'.'"comm'.'":"'.$commodity.'",'.'"fixrate'.'":"'.$frate.'",'.'"percentrate'.'":"'.$prate.'"}',
				//"https://www.agrikore.net/certifier/unsafe/ad/{%22op%22:%22addcertifier%22,%22admin%22:%220x2d2d8721fcacb58c7f5f2946bdcc487629da2d64%22,%22adminpwd%22:%22agrikore%22,%22addr%22:%220xbb9bc244d798123fde783fcc1c72d3bb8c189413%22,%22name%22:%22Lee%22,%22loc%22:%22$loc_name%22,%22comm%22:%22$commodity%22,%22fixrate%22:%22$frate%22,%22percentrate%22:%22$prate%22}",
				//
				//"https://www.agrikore.net/certifier/unsafe/ad/{%22op%22:%22addcertifier%22,%22admin%22:%220x2d2d8721fcacb58c7f5f2946bdcc487629da2d64%22,%22adminpwd%22:%22agrikore%22,%22addr%22:%22$addresscer%22,%22name%22:%22$namecer%22,%22loc%22:%22$loc_name%22,%22comm%22:%22$commodity%22,%22fixrate%22:%22$frate%22,%22percentrate%22:%22$prate%22}",
				//"https://www.agrikore.net/certifier/unsafe/ad/{%22op%22:%22addcertifier%22,%20%22admin%22:%220x2d2d8721fcacb58c7f5f2946bdcc487629da2d64%22,%22adminpwd%22:%22agrikore%22,%20%22addr%22:%22$addresscer%22,%20%22name%22:%22$namecer%22,%20%22loc%22:%22$loc_name%22,%20%22comm%22:%22$commodity%22,%20%22percentrate%22:%22$prate%22}",
				//"https://www.agrikore.net/certifier/unsafe/ad/{%22op%22:%22addcertifier%22,%20%22admin%22:%220x2d2d8721fcacb58c7f5f2946bdcc487629da2d64%22,%22adminpwd%22:%22agrikore%22,%20%22addr%22:%22$addresscer%22,%20%22name%22:%22$namecer%22,%20%22loc%22:%22$loc_name%22,%20%22comm%22:%22$commodity%22}",
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
				echo "cURL Error #:" . $err;
			  } else {
				$receipt2 = str_replace('"',"",$response2);
			  }


 // sleep for 10 seconds
 sleep(10);

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
					  $namecer = str_replace(" ","",$_POST['cer_name']);
					  $array = $pos->saveCer($namecer,$loc_name,$commodity,$prate,$frate,$msisdncer,$addresscer,$out);
					} 
					/** */
					else{
		  
			  //echo "<br> Everything failed<br>";
			  $array = false;
			}


			
			if($array[0] == true)
			{
				$result['id_cer'] = $array[2];
			}
			
		}
		else
		{
			$array = $pos->updateCer($idcer,$namecer,$loc_name,$commodity,$msisdncer,$addresscer);
		}
		$result['result'] = $array[0];
		$result['error'] = $array[1];
		$result['crud'] = $_POST['crud'];
		echo json_encode($result);
	}
	
	if($method == 'getdata'){
		$pos = new pos();
		$array = $pos->getListCer();
		$data = $array[1];
		$i=0;
		foreach ($data as $key) {
			$button = '<button  type="submit" id_cer="'.$key['id_cer'].'"  title="Tombol edit barang" class="btn btn-sm btn-primary btneditcer "  id="btneditcer'.$key['id_cer'].'"  ><i class="fa fa-edit"></i></button> <button  type="submit" id_cer="'.$key['id_cer'].'"  title="Tombol hapus barang" class="btn btn-danger btn-sm btndeletecer "  id="btndeletecer'.$key['id_cer'].'"  ><i class="fa fa-trash"></i></button>';

			
			$data[$i]['cer_name'] =  $data[$i]['cer_name'];
			$data[$i]['DT_RowId']= $data[$i]['id_cer'];
			$data[$i]['loc_name']= $data[$i]['loc_name'];
			$data[$i]['button'] = $button;
			$i++;
		}
		$datax = array('data' => $data);
		echo json_encode($datax);
	}
	if($method == 'delete_cer'){
		$id_cer=$_POST['id_cer'];
		$pos = new pos();
		$array = $pos->deleteCer($id_cer);
		$data['result'] = $array[0];
		$data['error'] = $array[1];
		echo json_encode($data);
	}
	
} else {
	exit('No direct access allowed.');
}