<?php
session_start();
require_once ("../model/dbconn.php");
require_once ("../model/pos.php");
include('db.php');
if( isset( $_SERVER['HTTP_X_REQUESTED_WITH'] ) && ( $_SERVER['HTTP_X_REQUESTED_WITH'] == 'XMLHttpRequest' ) )
{


	if (isset($_POST['wphonecpr_id'])) {

		$xphonecpr_id = $_POST['wphonecpr_id'];
	
		$qry = "select b_address as b_addresscpr from m_user where wphone= '$xphonecpr_id' ";
		$res = mysqli_query($con, $qry);
		if(mysqli_num_rows($res) > 0) {
			echo '<option value="">------- Select -------</option>';
			while($row = mysqli_fetch_object($res)) {
				echo '<option value="'.$row->b_addresscpr.'">'.$row->b_addresscpr.'</option>';
			}
		} else {
			echo '<option value="">No Record</option>';
		}
	
    } 
    
    if (isset($_POST['b_addresscpr'])) {

        $xphonecpr_idx = $_POST['b_addresscpr'];
        
        $qry = "select order_address,concat(request_name,'-',order_address) as order_address_name from m_request where addressreq = '$xphonecpr_idx'";
	
		//$qry = "select b_address as b_addresscprx from m_user where b_address = '$xphonecpr_idx'";
		$res = mysqli_query($con, $qry);
		if(mysqli_num_rows($res) > 0) {
			echo '<option value="">------- Select -------</option>';
			while($row = mysqli_fetch_object($res)) {
				echo '<option value="'.$row->order_address.'">'.$row->order_address_name.'</option>';
			}
		} else {
			echo '<option value="">No Record</option>';
		}
	
	} 


	if (isset($_POST['order_address'])) {

		$xorder_address = $_POST['order_address'];
		
        
        $qry = "select order_rpt_address as receipt_id,concat(order_rpt_address,'-',date_created) as receipt from m_p_receipt where order_address = '$xorder_address' limit 1";
	
		//$qry = "select b_address as b_addresscprx from m_user where b_address = '$xphonecpr_idx'";
		$res = mysqli_query($con, $qry);
		if(mysqli_num_rows($res) > 0) {
			echo '<option value="">------- Select -------</option>';
			while($row = mysqli_fetch_object($res)) {
				echo '<option value="'.$row->receipt_id.'">'.$row->receipt.'</option>';
			}
		} else {
			echo '<option value="">No Record</option>';
		}
	
	} 




    if (isset($_POST['cerwphonecpr_id'])) {

        $xcerwphonecpr_id = $_POST['cerwphonecpr_id'];
        
        
	
		$qry = "select b_address as cerb_addresscpr from m_user where wphone= $xcerwphonecpr_id";
		$res = mysqli_query($con, $qry);
		if(mysqli_num_rows($res) > 0) {
			echo '<option value="">------- Select -------</option>';
			while($row = mysqli_fetch_object($res)) {
				echo '<option value="'.$row->cerb_addresscpr.'">'.$row->cerb_addresscpr.'</option>';
			}
		} else {
			echo '<option value="">No Record</option>';
		}
	
    } 


	





	$pos = new pos();
	$method=$_POST['method'];
	if($method == 'get_detail_cpr')
	{
		$id_cpr=$_POST['id_cpr'];
		$pos = new pos();
		$data = $pos->getCpr($id_cpr);
		$array['data'] = $data[1];
		$array['result'] = $data[0];
		echo json_encode($array);
	}
	if($method == 'save_cpr')
	{
		$idcpr = $_POST['id_cpr'];
		$cpr_name = $_POST['cpr_name'];
		$msisdncpr = $_POST['msisdncpr'];
		$addresscpr = $_POST['addresscpr'];
		$order_address = $_POST['order_address'];
		$cermsisdncpr = $_POST['cermsisdncpr'];
		$ceraddresscpr = $_POST['ceraddresscpr'];
		$passcpr = md5($_POST['passcpr']);
		$oreceipt = $_POST['oreceipt'];
		$crud=$_POST['crud'];
		$pos = new pos();
		if($_POST['crud'] == 'N')
		{
			$outcpr = 10;
			$order_address = 10;
			$array = $pos->saveCpr($cpr_name,$msisdncpr,$addresscpr,$order_address,$cermsisdncpr,$ceraddresscpr,$passcpr,$oreceipt,$outcpr);
				
			if($array[0] == true)
			{
				$result['id_cpr'] = $array[2];
			}
			
		}
		else
		{
			$array = $pos->updateCpr($idcpr,$cpr_name,$msisdncpr,$addresscpr,$order_address,$cermsisdncpr,$ceraddresscpr,$passcpr,$oreceipt,$outcpr);
		}
		$result['result'] = $array[0];
		$result['error'] = $array[1];
		$result['crud'] = $_POST['crud'];
		echo json_encode($result);
	}
	
	if($method == 'getdata'){
		$pos = new pos();
		$array = $pos->getListCpr();
		$data = $array[1];
		$i=0;
		foreach ($data as $key) {
			$button = '<button  type="submit" id_cpr="'.$key['id_cpr'].'"  title="Tombol edit barang" class="btn btn-sm btn-primary btneditcpr "  id="btneditcpr'.$key['id_cpr'].'"  ><i class="fa fa-edit"></i></button> <button  type="submit" id_cpr="'.$key['id_cpr'].'"  title="Tombol hapus barang" class="btn btn-danger btn-sm btndeletecpr "  id="btndeletecpr'.$key['id_cpr'].'"  ><i class="fa fa-trash"></i></button>';

			$data[$i]['cpr_name'] =  $data[$i]['cpr_name'];
			//$data[$i]['fprice'] =  number_format($data[$i]['fprice']);
			$data[$i]['DT_RowId']= $data[$i]['id_cpr'];
			//$data[$i]['current_status']= $data[$i]['current_status'];
			//$data[$i]['terms']= number_format($data[$i]['terms']);
			$data[$i]['button'] = $button;
			$i++;
		}
		$datax = array('data' => $data);
		echo json_encode($datax);
	}
	if($method == 'delete_cpr'){
		$id_cpr=$_POST['id_cpr'];
		$pos = new pos();
		$array = $pos->deletecpr($id_cpr);
		$data['result'] = $array[0];
		$data['error'] = $array[1];
		echo json_encode($data);
	}
	
} else {
	exit('No direct access allowed.');
}