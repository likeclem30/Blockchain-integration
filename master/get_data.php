<?php include('db.php');?>

<?php

if (isset($_POST['wphone'])) {
	
	$qry = "select * from m_user where wphone=".mysqli_real_escape_string($con,$_POST['wphone'])." order by username";
	$res = mysqli_query($con, $qry);
	if(mysqli_num_rows($res) > 0) {
		echo '<option value="">------- Select -------</option>';
		while($row = mysqli_fetch_object($res)) {
			echo '<option value="'.$row->b_address.'">'.$row->b_address.'</option>';
		}
	} else {
		echo '<option value="">No Record</option>';
	}

} 

?>