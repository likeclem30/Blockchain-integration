<?php 
$titlepage="Naira";
$idsmenu=4; 
include "../../library/config.php";
include "../model/db.php";
//require_once("../model/dbconn.php");
//require_once("../model/pos.php");
include "../layout/top-header.php";
//include "../../library/check_login.php";
//include "../../library/check_access.php";
//include "../layout/header.php";

 ?>

            <?php
				$pos = new pos();
				$block = $pos->getblockadd($_SESSION['pos_username']);
				$walletno = $block[1]['wphone'];
				$wallet_address = $block[1]['b_address'];
				
/**				

				$curl = curl_init();
				
				curl_setopt_array($curl, array(
				  CURLOPT_URL => "https://www.agrikore.net/mula/vw/{%22op%22:%22getbal%22,%22addr%22:%22$wallet_address%22}",
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
				
				curl_close($curl);
				
				if ($err) {
				  echo "cURL Error #:" . $err;
				} else {
				  $balance =  str_replace('"',"",$response);
				}

*/
	
	
	$select_location = "SELECT id_loc,loc_name from m_location";
	$select_currency = "SELECT id_currency,currency from m_currency";

	$result_location = mysqli_query($con,$select_location);
	$result_currency = mysqli_query($con,$select_currency);

	
?>



<section class="content">
	<div class="box box-success">
		<div class="box-header with-border">
			<h2 class="box-title">Corporate Commodity Buyer</h2>
		</div>
		<!--./ box header-->
		<div class="box-body">
			<div class="row">
				<div class="col-md-250">
					<center>
					
					<button type="submit" class="btn btn-primary " id="btnaddrequest" name=""><i class="fa fa-plus"></i> Request to Buy</button>
					<button type="submit" class="btn btn-primary " id="btnadd" name=""><i class="fa fa-plus"></i> Set Commission</button>
					<button type="submit" class="btn btn-primary " id="btnaddloc" name=""><i class="fa fa-plus"></i>Add Location</button>
					<button type="submit" class="btn btn-primary " id="btnaddoff" name=""><i class="fa fa-plus"></i>Add Offtaker</button>
					<button type="submit" class="btn btn-primary " id="btnaddcer" name=""><i class="fa fa-plus"></i> Add Certifier</button>
					<button type="submit" class="btn btn-primary " id="btnaddfar" name=""><i class="fa fa-plus"></i> Add Farmer</button>
				<button type="submit" class="btn btn-primary " id="btnadd" name=""><i class="fa fa-plus"></i> Confirm Order</button>
				<button type="submit" class="btn btn-primary " id="btnadd" name=""><i class="fa fa-plus"></i> Fund Account</button>
				<button type="submit" class="btn btn-primary " id="btnadd" name=""><i class="fa fa-plus"></i> Create Certifier</button>
				<button type="submit" class="btn btn-primary " id="btnadd" name=""><i class="fa fa-plus"></i> Confirm Certifier</button>
				<button type="submit" class="btn btn-primary " id="btnadd" name=""><i class="fa fa-plus"></i> Confirm Receipt</button>
				<button type="submit" class="btn btn-primary " id="btnadd" name=""><i class="fa fa-plus"></i> Produce Receipt</button>
				<button type="submit" class="btn btn-primary " id="btnadd" name=""><i class="fa fa-plus"></i> Add Produce</button>
				
					
					<br>
					<br>
					<br>
</center>
				</div>

			</div>
			
		</div>
	</div><!-- /.box -->

</section><!-- /.content -->












<!--
//******************************************************************************
 //   Block Chain Import Currency
 //   *******************************************************************************/
-->
<section class="content">
	<div class="box box-success">
		<div class="box-header with-border">
			<h3 class="box-title">Fund Wallet(Import Currency)</h3>
		</div>
		<!--./ box header-->
		<div class="box-body">
			<div class="row">
				<div class="col-md-6">
					<button type="submit" class="btn btn-primary " id="btnaddcur" name=""><i class="fa fa-plus"></i> Fund Wallet</button>
					<br>
				</div>
			</div>
			<div class="box-body table-responsive no-padding" style="max-width:1124px;">
				<table id="table_cur" class="table  table-bordered table-hover ">
					<thead>
					<tr class="tableheader">
							<th style="width:40px">#</th>
							<th style="width:60px">Id</th>
							<th style="width:60px">Transaction Title</th>
							<th style="width:60px">transaction_type </th>
							<th style="width:60px">Currency</th>
							<th style="width:60px">Value</th>
							<th style="width:60px">Address</th>
							<th style="width:60px">MSISDN</th>
							<th style="width:100px">Transaction Status</th> 
							<th></th>
						</tr>
					</thead>
					<tbody></tbody>
				</table>
			</div>		
		</div>
	</div><!-- /.box -->

</section><!-- /.content -->


<div id="modalmastercur" class="modal fade ">
	<div class="modal-dialog modal-md">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal">×</button>
				<h4 class="modal-title">Fund Wallet(Import Currency) Form</h4>
			</div>
			<!--modal header-->
			<div class="modal-body">
				<div class="form-horizontal">
					<div class="box-body">
						<div class="form-group"> <label class="col-sm-3  control-label">Id</label>
							<div class="col-sm-7"><input type="text" class="form-control " id="txtidcur" name="txtidcur" value="*New" placeholder="" disabled=""><input type="hidden" id="inputcrud" name="inputcrud" class="" value="N"> </div>
						</div>
						<div class="form-group"> <label class="col-sm-3  control-label">Transaction Title</label>
							<div class="col-sm-7"><input type="text" class="form-control " id="txtcurname" name="txtcurname" value="" placeholder="Please fill out Tran. name"> 
							</div>
						</div>
                    

						<div class="form-group"> <label class="col-sm-3  control-label">Transaction Type</label>
							<div class="col-sm-7"><select name="txttctycur" class="form-control" id="txttctycur" >
					<option value=''>--- Select --</option>
					<?php 
					$sql = "select * from `m_transaction` where id_tran in ('sellmulafor','buymulafor','transferfromreserve','transfertoreserve','sellmula','buymula','importtoken','exporttoken','setcommissionaddress')";
					$res = mysqli_query($con, $sql);
					if(mysqli_num_rows($res) > 0) {
						while($row = mysqli_fetch_object($res)) {
							echo "<option value='".$row->id_tran."'>".$row->transaction."</option>";
						}
					}
					?>
				    </select></div>
					</div>
                        
						<div class="form-group"> <label class="col-sm-3  control-label">Currency Type</label>
							<div class="col-sm-7"><select name="txtctycur" class="form-control" id="txtctycur">
					<option value=''>--- Select --</option>
					<?php 
					$sql = "select * from `m_currency`";
					$res = mysqli_query($con, $sql);
					if(mysqli_num_rows($res) > 0) {
						while($row = mysqli_fetch_object($res)) {
							echo "<option value='".$row->id_currency."'>".$row->currency."</option>";
						}
					}
					?>
				    </select></div>
					</div>


							<div class="form-group"> <label class="col-sm-3  control-label">Amount</label>
							<div class="col-sm-7">
								<div class="input-group">
									<span class="input-group-addon">N/$.</span>
									<input type="text" class="form-control money" id="txtcvalcur" name="txtcvalcur" value="" placeholder=""></div>
								</div>
							</div>

						<div class="form-group"> <label class="col-sm-3  control-label">Wallet No:</label>
							<div class="col-sm-7"><select name="txtmsisdncur" class="form-control" id="txtmsisdncur">
					<option value=''>---- Select ---</option>
					<?php 
					$sql = "select concat(username,'-',wphone) as wphone2, wphone as wphone1_id2 from `m_user` where wphone is not null";
					$res = mysqli_query($con, $sql);
					if(mysqli_num_rows($res) > 0) {
						while($row = mysqli_fetch_object($res)) {
							echo "<option value='".$row->wphone1_id2."'>".$row->wphone2."</option>";
						}
					}
					?>
				    </select>
					</div>
					</div>	
						<div class="form-group"> <label class="col-sm-3  control-label">Account Address</label>
						<div class="col-sm-7"><select name="txtaddresscur" class="form-control" id="txtaddresscur" disabled="disabled"><option>------- Select --------</option></select>
						</div>
						</div>
						
						<div class="form-group"> <label class="col-sm-3  control-label">Password</label>
				
							<div class="col-sm-7">  <input type="password" class="form-control" name="txtpasscur" id="txtpasscur" value="" placeholder="Please Enter Your password for the Sender Wallet">
			         	</div>
					   </div>	

						
		
							<div class="form-group"> <label class="col-sm-1  control-label"></label>
								<div class="col-sm-11"><button type="submit" title="Save Button" class="btn btn-primary " id="btnsavecur" name=""><i class="fa fa-save"></i> Submit</button> <span id="infoproses"></span> </div>
							</div>
						</div>
					</div>
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
				</div>
				<!--modal footer-->
			</div>
			<!--modal-content-->
		</div>
		<!--modal-dialog modal-lg-->
		</div>


<!--
//******************************************************************************
 //   Block Chain fund wallet
 //   *******************************************************************************/

-->


	<?php include "../layout/footer.php"; //footer template ?> 
	<?php include "../layout/bottom-footer.php"; //footer template ?> 
	<script src="j_item.js"></script>
	<script src="j_request.js"></script>
	<script src="j_loc.js"></script>
	<script src="j_cer.js"></script>
	<script src="j_off.js"></script>
	<script src="j_far.js"></script>
	<script src="j_pre.js"></script>
	<script src="j_cre.js"></script>
	<script src="j_cpr.js"></script>
	<script src="j_rpr.js"></script>
	<script src="j_cur.js"></script>
	<script src="j_mul.js"></script>
	<script src="j_gof.js"></script>
	<script src="j_got.js"></script>
	<script src="j_red.js"></script>
	<script src="j_rco.js"></script>
	
	
</body>
</html>
