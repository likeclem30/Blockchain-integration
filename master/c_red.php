<?php
session_start();
require_once ("../model/dbconn.php");
require_once ("../model/pos.php");
include('db.php');
if( isset( $_SERVER['HTTP_X_REQUESTED_WITH'] ) && ( $_SERVER['HTTP_X_REQUESTED_WITH'] == 'XMLHttpRequest' ) )
{
	

	if (isset($_POST['wphonered_id'])) {

		$xphonered_id = $_POST['wphonered_id'];
	
		$qry = "select distinct oaddresscre as b_addressred from m_p_receipt_cer 
		where msisdncre= $xphonered_id 
		and tran_type = 'confirmdelivery' 
        and outcre like '%preceipt-100-Success,receiptpay-100-Success%';
		";
		$res = mysqli_query($con, $qry);
		if(mysqli_num_rows($res) > 0) {
			echo '<option value="">------- Select -------</option>';
			while($row = mysqli_fetch_object($res)) {
				echo '<option value="'.$row->b_addressred.'">'.$row->b_addressred.'</option>';
			}
		} else {
			echo '<option value="">No Record</option>';
		}
	
    } 
    
    if (isset($_POST['b_addressred'])) {

        $xphonered_idx = $_POST['b_addressred'];
        
		$qry = "select 	oreceipt as b_addressredx from m_p_receipt_cer 
		where oaddresscre = '$xphonered_idx' 
		and tran_type ='confirmdelivery' 
		and outcre like '%preceipt-100-Success,receiptpay-100-Success%'";
	
		//$qry = "select b_address as b_addressredx from m_user where b_address = '$xphonered_idx'";
		$res = mysqli_query($con, $qry);
		if(mysqli_num_rows($res) > 0) {
			echo '<option value="">------- Select -------</option>';
			while($row = mysqli_fetch_object($res)) {
				echo '<option value="'.$row->b_addressredx.'">'.$row->b_addressredx.'</option>';
			}
		} else {
			echo '<option value="">No Record</option>';
		}
	
	} 


    if (isset($_POST['farwphonered_id'])) {

        $xfarwphonered_id = $_POST['farwphonered_id'];
        
        
	
		$qry = "select b_address as farb_addressred from m_user where wphone= $xfarwphonered_id";
		$res = mysqli_query($con, $qry);
		if(mysqli_num_rows($res) > 0) {
			echo '<option value="">------- Select -------</option>';
			while($row = mysqli_fetch_object($res)) {
				echo '<option value="'.$row->farb_addressred.'">'.$row->farb_addressred.'</option>';
			}
		} else {
			echo '<option value="">No Record</option>';
		}
	
    } 


	




	
	
	
	
	
	
	
	$pos = new pos();
	$method=$_POST['method'];
	if($method == 'get_detail_red')
	{
		$id_red=$_POST['id_red'];
		$pos = new pos();
		$data = $pos->getred($id_red);
		$array['data'] = $data[1];
		$array['result'] = $data[0];
		echo json_encode($array);
	}
	if($method == 'save_red')
	{

		$idred = $_POST['id_red'];
		$red_name = $_POST['red_name'];
		$msisdnred = $_POST['msisdnred'];
		$oaddressred = $_POST['oaddressred'];
		$farmsisdnred = $_POST['farmsisdnred'];
		$faraddressred = $_POST['faraddressred'];
		$oreceipt = $_POST['oreceiptred'];
		$passred = md5($_POST['passred']);
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
$block1 = $t1pos->getblockpass($farmsisdnred);
//$walletno1 = $block1[1]['wphone'];
//$wallet_address1 = $block1[1]['b_address'];
//$b_token1 = $block1[1]['b_token'];
$u_pass1 = $block1[1]['pass'];


if($passred == $u_pass1 ){

$curl = curl_init();

curl_setopt_array($curl, array(
  CURLOPT_URL => 'https://www.agrikore.net/preceipt/unsafe/tx/{"'."op".'":"'.'redeem",'.'"farmer'.'":"'.$faraddressred.'",'.'"farmerpwd'.'":"'.$passred.'",'.'"order'.'":"'.$oaddressred.'",'.'"receipt'.'":"'.$oreceipt.'"}',
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
        $array = $pos->saveRed($red_name,$msisdnred,$oaddressred,$oreceipt,$farmsisdnred,$faraddressred,$passred,$out);
        
            
      }else{
  
    //echo "<br> Everything failed<br>";
    $array = false;
  }
}




/** 
$orderrptaddr = 30;
$outred = 12;
$outredd =23;

				$array = $pos->saveRed($red_name,$msisdnred,$oaddressred,$oreceipt,$farmsisdnred,$faraddressred,$passred,$outred);
*/
	
			if($array[0] == true)
			{
				$result['id_red'] = $array[2];
			}
			
		}
		else
		{
			$array = $pos->updateRed($idred,$red_name,$msisdnred,$oaddressred,$oreceipt,$farmsisdnred,$faraddressred,$passred,$outred);
		}
		$result['result'] = $array[0];
		$result['error'] = $array[1];
		$result['crud'] = $_POST['crud'];
		echo json_encode($result);
	}
	
	if($method == 'getdata'){
		$pos = new pos();
		$array = $pos->getListred();
		$data = $array[1];
		$i=0;
		foreach ($data as $key) {
			$button = '<button  type="submit" id_red="'.$key['id_red'].'"  title="Tombol edit barang" class="btn btn-sm btn-primary btneditred "  id="btneditred'.$key['id_red'].'"  ><i class="fa fa-edit"></i></button> <button  type="submit" id_red="'.$key['id_red'].'"  title="Tombol hapus barang" class="btn btn-danger btn-sm btndeletered "  id="btndeletered'.$key['id_red'].'"  ><i class="fa fa-trash"></i></button>';

			
			//$data[$i]['am'] =  number_format($data[$i]['amount']);
			$data[$i]['DT_RowId']= $data[$i]['id_red'];
			//$data[$i]['quantity']= number_format($data[$i]['quantity']);
			$data[$i]['button'] = $button;
			$i++;
		}
		$datax = array('data' => $data);
		echo json_encode($datax);
	}
	if($method == 'delete_red'){
		$id_red=$_POST['id_red'];
		$pos = new pos();
		$array = $pos->deletered($id_red);
		$data['result'] = $array[0];
		$data['error'] = $array[1];
		echo json_encode($data);
	}
	
} else {
	exit('No direct access allowed.');
}