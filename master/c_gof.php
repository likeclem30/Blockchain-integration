<?php
session_start();
require_once ("../model/dbconn.php");
require_once ("../model/pos.php");
include('db.php');
if( isset( $_SERVER['HTTP_X_REQUESTED_WITH'] ) && ( $_SERVER['HTTP_X_REQUESTED_WITH'] == 'XMLHttpRequest' ) )
{

	if (isset($_POST['wphonegof_id'])) {

		$xphonegof_id = $_POST['wphonegof_id'];
	
		$qry = "select b_address as b_addressgof from m_user where wphone= '$xphonegof_id'";
		$res = mysqli_query($con, $qry);
		if(mysqli_num_rows($res) > 0) {
			echo '<option value="">------- Select -------</option>';
			while($row = mysqli_fetch_object($res)) {
				echo '<option value="'.$row->b_addressgof.'">'.$row->b_addressgof.'</option>';
			}
		} else {
			echo '<option value="">No Record</option>';
		}
	
	} else if(isset($_POST['b_addressgof'])) {

        $bx_addressgof = $_POST['b_addressgof'];
       
        $qry = "select order_address as order_addressgof_id from m_request where addressreq = '0xdea555657f063cb9fbceddb468fe055ac95b334e'";
       
       //$qry = "SELECT 
      //  concat(username,'-',DATE_FORMAT(date_created, '%b-%d-%y %T'),'-',order_address) as order_addressgof, wphone as order_addressgof_id FROM m_user t1	INNER JOIN	m_request t2 ON t1.wphone = t2.msisdnreq
     //   where b_address = '$b_addressgof'";
        $res = mysqli_query($con, $qry);
        if(mysqli_num_rows($res) > 0) {
            echo '<option value="">------- Select -------</option>';
            while($row = mysqli_fetch_object($res)) {
                echo '<option value="'.$row->order_addressgof_id.'">'.$row->order_addressgof_id.'</option>';
            }
        } else {
            echo '<option value="">No Record</option>';
        }
    
    } 





   
	$pos = new pos();
	$method=$_POST['method'];
	if($method == 'get_detail_gof')
	{
		$id_gof=$_POST['id_gof'];
		$pos = new pos();
		$data = $pos->getgof($id_gof);
		$array['data'] = $data[1];
		$array['result'] = $data[0];
		echo json_encode($array);
	}
	if($method == 'save_gof')
	{
		$idgof = $_POST['id_gof'];
        $namegof = $_POST['gof_name'];
        $transaction_type = $_POST['transaction_type'];
		$addressgof = $_POST['addressgof'];
        $msisdngof = $_POST['msisdngof'];
        $amount = $_POST['amount']*1000000000000000000;
        $passgof = md5($_POST['passgof']);
        $order_address = $_POST['order_address'];
        $off_addressgof = $_POST['addressgof_off'];
        $off_msisdngof = $_POST['msisdngof_off'];
		$crud=$_POST['crud'];
		$pos = new pos();
		if($_POST['crud'] == 'N')
		{

			$tpos = new pos();
			$block = $tpos->getblockadd($_SESSION['pos_username']);
			$walletno = $block[1]['wphone'];
			$wallet_address = $block[1]['b_address'];
            $b_token = $block[1]['b_token'];
            
            $t1pos = new pos();
			$block1 = $t1pos->getblockpass($msisdnreq);
			
            $u_pass1 = $block1[1]['pass'];
            
           
            if ($u_pass1 == $passgof){


    if ($transaction_type == 'addfunds'){	
        
        
        $curl = curl_init();

curl_setopt_array($curl, array(
  CURLOPT_URL => 'https://www.agrikore.net/gorder/unsafe/tx/{"'."op".'":"'.'addfunds",'.'"buyer'.'":"'.$addressgof.'",'.'"buyerpwd'.'":"'.$passgof.'",'.'"order'.'":"'.$order_address.'",'.'"amount'.'":"'.$amount.'"}',
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

$responseaf = curl_exec($curl);
$err = curl_error($curl);

curl_close($curl);

if ($err) {
  echo "cURL Error #:" . $err;
} else {
  
  $receipt2 = str_replace('"',"",$responseaf);
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
                     
					  	} 
					/** */
                    $array = $pos->saveGof($namegof,$transaction_type,$msisdngof,$addressgof,$amount,$passgof,$order_address,$off_msisdngof,$off_addressgof,$out);
 	

		}// checking transaction

    }//checking password
    else{	  
	 //password failed;
	 $array = false;
    }
    
			
			if($array[0] == true)
			{
				$result['id_gof'] = $array[2];
			}
			
		}
		else
		{
			$array = $pos->updategof($idgof,$gof_name,$transaction_type,$msisdngof,$addressgof,$amount,$passgof,$order_address,$off_msisdngof,$off_addressgof);
		}
		$result['result'] = $array[0];
		$result['error'] = $array[1];
		$result['crud'] = $_POST['crud'];
		echo json_encode($result);
	}
	
	if($method == 'getdata'){
		$pos = new pos();
		$array = $pos->getListgof();
		$data = $array[1];
		$i=0;
		foreach ($data as $key) {
			$button = '<button  type="submit" id_gof="'.$key['id_gof'].'"  title="Tombol edit barang" class="btn btn-sm btn-primary btneditgof "  id="btneditgof'.$key['id_gof'].'"  ><i class="fa fa-edit"></i></button> <button  type="submit" id_gof="'.$key['id_gof'].'"  title="Tombol hapus barang" class="btn btn-danger btn-sm btndeletegof "  id="btndeletegof'.$key['id_gof'].'"  ><i class="fa fa-trash"></i></button>';

			$data[$i]['gof_name'] =  $data[$i]['gof_name'];
			//$data[$i]['fprice'] =  number_format($data[$i]['fprice']);
			$data[$i]['DT_RowId']= $data[$i]['id_gof'];
			$data[$i]['loc_name']= $data[$i]['loc_name'];
			//$data[$i]['terms']= number_format($data[$i]['terms']);
			$data[$i]['button'] = $button;
			$i++;
		}
		$datax = array('data' => $data);
		echo json_encode($datax);
	}
	if($method == 'delete_gof'){
		$id_gof=$_POST['id_gof'];
		$pos = new pos();
		$array = $pos->deletegof($id_gof);
		$data['result'] = $array[0];
		$data['error'] = $array[1];
		echo json_encode($data);
	}
	
} else {
	exit('No direct access allowed.');
}