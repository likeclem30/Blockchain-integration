<?php
session_start();
require_once ("../model/dbconn.php");
require_once ("../model/pos.php");

$method=$_POST['method'];
if($method == 'check_password'){
	$pass=strtoupper($_POST['pass']);
		$kasir =  $_SESSION['pos_id'];

	$pos = new pos();
	$data = array();
	$array = $pos->checkPassword($kasir,$pass);
	if($array[0] == true){
		if($array[1] == 1)
		{
			$data['auth'] = true;
		}else{
			$data['auth'] = false;
		}
	}else{
		$data['auth'] = false;
	}
	
	echo json_encode($data);
}
