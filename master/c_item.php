<?php
session_start();
require_once ("../model/dbconn.php");
require_once ("../model/pos.php");

include('db.php');

if( isset( $_SERVER['HTTP_X_REQUESTED_WITH'] ) && ( $_SERVER['HTTP_X_REQUESTED_WITH'] == 'XMLHttpRequest' ) )


{
	$pos = new pos();
	$method=$_POST['method'];
	if($method == 'get_detail_item')
	{
		$id_item=$_POST['id_item'];
		$pos = new pos();
		$data = $pos->getItem($id_item);
		$array['data'] = $data[1];
		$array['result'] = $data[0];
		echo json_encode($array);
	}
	if($method == 'save_item')
	{
		$iditem = $_POST['id_item'];
		$nameitem = $_POST['item_name'];
		$loci = str_replace(' ',"",$_POST['loci']);
		$unit= $_POST['unit'];
		$stock = $_POST['stock']*1000000000000000000;
		$terms = $_POST['terms'];
		$price = $_POST['price']*1000000000000000000;
		$fprice = $_POST['fprice']*1000000000000000000;
		$note = $_POST['note'];
		$crud=$_POST['crud'];
		$pos = new pos();
		if($_POST['crud'] == 'N')
		{

			  $tpos = new pos();
             $block = $tpos->getblockadd($_SESSION['pos_username']);
             $walletno = $block[1]['wphone'];
             $wallet_address = $block[1]['b_address'];
             $b_token = $block[1]['b_token'];

   /** 

			 $curl = curl_init();

			 curl_setopt_array($curl, array(
			   CURLOPT_URL => "https://www.agrikore.net/location/vw/{%22op%22:%22getlocindex%22,%20%22name%22:%22$loci%22}",
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
			 //echo "<br> Reciept :".$loci2."<br>";
 

			  $curl = curl_init();
 
			  curl_setopt_array($curl, array(
				CURLOPT_URL => 'https://www.agrikore.net/commodity/unsafe/ad/{"'."op".'":"'.'addcomm",'.'"admin'.'":"'.'0x2d2d8721fcacb58c7f5f2946bdcc487629da2d64",'.'"adminpwd'.'":"'.'agrikore",'.'"name'.'":"'.$nameitem.'",'.'"unit'.'":"'.$unit.'",'.'"price'.'":"'.$price.'",'.'"wareprice'.'":"'.$stock.'",'.'"farmprice'.'":"'.$fprice.'",'.'"term'.'":"'.$terms.'",'.'"loc'.'":"'.$loci.'"}',
				//"https://www.agrikore.net/commodity/unsafe/ad/{%22op%22:%22addcomm%22,%22admin%22:%220x2d2d8721fcacb58c7f5f2946bdcc487629da2d64%22,%22adminpwd%22:%22agrikore%22,%22name%22:%22$nameitem%22,%22unit%22:%22$unit%22,%22price%22:%22$price%22,%22wareprice%22:%22$stock%22,%22farmprice%22:%22$fprice%22,%22term%22:%22$terms%22,%20%22loc%22:%22$loci%22}",
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
				echo "<br>".$echo = "cURL Error #:" . $err;
			  } else {



echo "<br>".$loci;
*/


				$curl = curl_init();

				curl_setopt_array($curl, array(
				  CURLOPT_URL => 'https://www.agrikore.net/commodity/unsafe/ad/{"'."op".'":"'.'addcomm",'.'"admin'.'":"'.'0x2d2d8721fcacb58c7f5f2946bdcc487629da2d64",'.'"adminpwd'.'":"'.'agrikore",'.'"name'.'":"'.$nameitem.'",'.'"unit'.'":"'.$unit.'",'.'"price'.'":"'.$price.'",'.'"wareprice'.'":"'.$stock.'",'.'"farmprice'.'":"'.$fprice.'",'.'"term'.'":"'.$terms.'",'.'"loc'.'":"'.$loci.'"}',
				  //"https://www.agrikore.net/commodity/unsafe/ad/{%22op%22:%22addcomm%22,%22admin%22:%220x2d2d8721fcacb58c7f5f2946bdcc487629da2d64%22,%22adminpwd%22:%22agrikore%22,%22name%22:%22Fish%22,%22unit%22:%22kg%22,%22price%22:%2220000000000000000000%22,%22wareprice%22:%2218000000000000000000%22,%22farmprice%22:%2217000000000000000000%22,%22term%22:%2290%22,%20%22loc%22:%22$loci%22}",
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
				  $echo = "cURL Error #:" . $err;
				} else {
				 
				//echo $response2;
				 $receipt2 = str_replace('"',"",$response2);
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

					   if (strpos($out, 'Success') !== false) {

					   $curl = curl_init();
	
					   curl_setopt_array($curl, array(
						 CURLOPT_URL => 'https://www.agrikore.net/commodity/vw/{"'."op".'":"'.'getcommindex",'.'"name'.'":"'.$nameitem.'"}',
						 CURLOPT_RETURNTRANSFER => true,
						 CURLOPT_ENCODING => "",
						 CURLOPT_MAXREDIRS => 10,
						 CURLOPT_TIMEOUT => 700,
						 CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
						 CURLOPT_CUSTOMREQUEST => "GET",
						 //CURLOPT_HTTPHEADER => array(
						 //  "Cache-Control: no-cache"
						 //),
					   ));
					   
					   $responsec = curl_exec($curl);
					   $err = curl_error($curl);
					   
					   //curl_close($curl);
					   
					   if ($err) {
						 $echo = "cURL Error #:" . $err;
					   } else {
						   //echo $response;
						   $commindex = str_replace('"'," ",$responsec);
					   //	$commindex = str_replace('"',"",$responsec);
						   //echo "<br> commodity :".$commodity."<br>"; 
						   //echo "<br> commodity index :".$commindex."<br>"; 
					   }
					}else{
						$commindex = 0;	
					}
					   //echo "<br> Status query :".$out."<br>";
					   $array = $pos->saveItem($nameitem,$loci,$unit,$stock,$terms,$price,$fprice,$note,$out,$commindex);
			 }else{
		   
			   //echo "<br> Everything failed<br>";
			   $array = false;
			 }
	 
 
			
			if($array[0] == true)
			{
				$result['id_item'] = $array[2];
			}
			
		}
		else
		{
			$array = $pos->updateItem($iditem,$nameitem,$loci,$unit,$stock,$terms,$price,$fprice,$note);
		}
		$result['result'] = $array[0];
		$result['error'] = $array[1];
		$result['crud'] = $_POST['crud'];
		echo json_encode($result);
	}
	
	if($method == 'getdata'){
		$pos = new pos();
		$array = $pos->getListItem();
		$data = $array[1];
		$i=0;
		foreach ($data as $key) {
			$button = '<button  type="submit" id_item="'.$key['id_item'].'"  title="Tombol edit barang" class="btn btn-sm btn-primary btnedititem "  id="btnedititem'.$key['id_item'].'"  ><i class="fa fa-edit"></i></button> <button  type="submit" id_item="'.$key['id_item'].'"  title="Tombol hapus barang" class="btn btn-danger btn-sm btndeleteitem "  id="btndeleteitem'.$key['id_item'].'"  ><i class="fa fa-trash"></i></button>';

			$data[$i]['price'] =  number_format($data[$i]['price']);
			//$data[$i]['fprice'] =  number_format($data[$i]['fprice']);
			$data[$i]['DT_RowId']= $data[$i]['id_item'];
			$data[$i]['stock']= number_format($data[$i]['stock']);
			//$data[$i]['terms']= number_format($data[$i]['terms']);
			$data[$i]['button'] = $button;
			$i++;
		}
		$datax = array('data' => $data);
		echo json_encode($datax);
	}
	if($method == 'delete_item'){
		$id_item=$_POST['id_item'];
		$pos = new pos();
		$array = $pos->deleteItem($id_item);
		$data['result'] = $array[0];
		$data['error'] = $array[1];
		echo json_encode($data);
	}
	
} else {
	exit('No direct access allowed.');
}