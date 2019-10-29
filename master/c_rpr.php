<?php
session_start();
require_once ("../model/dbconn.php");
require_once ("../model/pos.php");
include('db.php');
if( isset( $_SERVER['HTTP_X_REQUESTED_WITH'] ) && ( $_SERVER['HTTP_X_REQUESTED_WITH'] == 'XMLHttpRequest' ) )
{


	if (isset($_POST['wphonerpr_id'])) {

		$xphonerpr_id = $_POST['wphonerpr_id'];
	
		$qry = "select b_address as b_addressrpr from m_user where wphone= $xphonerpr_id";
		$res = mysqli_query($con, $qry);
		if(mysqli_num_rows($res) > 0) {
			echo '<option value="">------- Select -------</option>';
			while($row = mysqli_fetch_object($res)) {
				echo '<option value="'.$row->b_addressrpr.'">'.$row->b_addressrpr.'</option>';
			}
		} else {
			echo '<option value="">No Record</option>';
		}
	
    } 
    
    if (isset($_POST['b_addressrpr'])) {

        $xphonerpr_idx = $_POST['b_addressrpr'];
        
        $qry = "select order_address as b_addressrprx from m_request where addressreq = '$xphonerpr_idx'";
	
		//$qry = "select b_address as b_addressrprx from m_user where b_address = '$xphonerpr_idx'";
		$res = mysqli_query($con, $qry);
		if(mysqli_num_rows($res) > 0) {
			echo '<option value="">------- Select -------</option>';
			while($row = mysqli_fetch_object($res)) {
				echo '<option value="'.$row->b_addressrprx.'">'.$row->b_addressrprx.'</option>';
			}
		} else {
			echo '<option value="">No Record</option>';
		}
	
	} 


    if (isset($_POST['offwphonerpr_id'])) {

        $xoffwphonerpr_id = $_POST['offwphonerpr_id'];
        
        
	
		$qry = "select b_address as offb_addressrpr from m_user where wphone= $xoffwphonerpr_id";
		$res = mysqli_query($con, $qry);
		if(mysqli_num_rows($res) > 0) {
			echo '<option value="">------- Select -------</option>';
			while($row = mysqli_fetch_object($res)) {
				echo '<option value="'.$row->offb_addressrpr.'">'.$row->offb_addressrpr.'</option>';
			}
		} else {
			echo '<option value="">No Record</option>';
		}
	
    } 


	if (isset($_POST['farwphonerpr_id'])) {

        $xfarwphonerpr_id = $_POST['farwphonerpr_id'];
        
        
	
		$qry = "select b_address as farb_addressrpr from m_user where wphone= $xfarwphonerpr_id";
		$res = mysqli_query($con, $qry);
		if(mysqli_num_rows($res) > 0) {
			echo '<option value="">------- Select -------</option>';
			while($row = mysqli_fetch_object($res)) {
				echo '<option value="'.$row->farb_addressrpr.'">'.$row->farb_addressrpr.'</option>';
			}
		} else {
			echo '<option value="">No Record</option>';
		}
	
    } 










	$pos = new pos();
	$method=$_POST['method'];
	if($method == 'get_detail_rpr')
	{
		$id_rpr=$_POST['id_rpr'];
		$pos = new pos();
		$data = $pos->getRpr($id_rpr);
		$array['data'] = $data[1];
		$array['result'] = $data[0];
		echo json_encode($array);
	}
	if($method == 'save_rpr')
	{
		$idrpr = $_POST['id_rpr'];
		$rpr_title = $_POST['rpr_title'];
		$guaranteed_order = $_POST['guaranteed_order'];
		$redeemed_receipt = $_POST['redeemed_receipt'];
		$redeemed_address = $_POST['redeemed_receipt'];
		$current_status = $_POST['current_status'];

		$crud=$_POST['crud'];
		$pos = new pos();
		if($_POST['crud'] == 'N')
		{
			$array = $pos->saveRpr($rpr_title,$guaranteed_order,$redeemed_receipt,$redeemed_address,$current_status);
			if($array[0] == true)
			{
				$result['id_rpr'] = $array[2];
			}
			
		}
		else
		{
			$array = $pos->updateRpr($idrpr,$rpr_title,$guaranteed_order,$redeemed_receipt,$redeemed_address,$current_status);
		}
		$result['result'] = $array[0];
		$result['error'] = $array[1];
		$result['crud'] = $_POST['crud'];
		echo json_encode($result);
	}
	
	if($method == 'getdata'){
		$pos = new pos();
		$array = $pos->getListRpr();
		$data = $array[1];
		$i=0;
		foreach ($data as $key) {
			$button = '<button  type="submit" id_rpr="'.$key['id_rpr'].'"  title="Tombol edit barang" class="btn btn-sm btn-primary btneditrpr "  id="btneditrpr'.$key['id_rpr'].'"  ><i class="fa fa-edit"></i></button> <button  type="submit" id_rpr="'.$key['id_rpr'].'"  title="Tombol hapus barang" class="btn btn-danger btn-sm btndeleterpr "  id="btndeleterpr'.$key['id_rpr'].'"  ><i class="fa fa-trash"></i></button>';

			$data[$i]['rpr_title'] =  $data[$i]['rpr_title'];
			//$data[$i]['fprice'] =  number_format($data[$i]['fprice']);
			$data[$i]['DT_RowId']= $data[$i]['id_rpr'];
			$data[$i]['current_status']= $data[$i]['current_status'];
			//$data[$i]['terms']= number_format($data[$i]['terms']);
			$data[$i]['button'] = $button;
			$i++;
		}
		$datax = array('data' => $data);
		echo json_encode($datax);
	}
	if($method == 'delete_rpr'){
		$id_rpr=$_POST['id_rpr'];
		$pos = new pos();
		$array = $pos->deleteRpr($id_rpr);
		$data['result'] = $array[0];
		$data['error'] = $array[1];
		echo json_encode($data);
	}
	
} else {
	exit('No direct access allowed.');
}