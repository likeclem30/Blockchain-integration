<?php 
$titlepage="Master Item";
$idsmenu=1; 
include "../../library/config.php";
require_once("../model/dbconn.php");
require_once("../model/pos.php");
include "../layout/top-header.php";
include "../../library/check_login.php";
include "../../library/check_access.php";
include "../layout/header.php"; ?>

<?php 
    include("configx.php");
    $select_country = "SELECT country_id,country_name from Country";
	$result_country = mysqli_query($con,$select_country);
	

	//$db = new dblocal;
	//$stmt = $db->prepare("select a.* from m_certifier a ");
     
     //$stmt->execute();
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


<section class="content">
	<div class="box box-success">
		<div class="box-header with-border">
			<h3 class="box-title">Available Commodity</h3>
		</div>
		<!--./ box header-->
		<div class="box-body">
			<div class="row">
				<div class="col-md-6">
					<button type="submit" class="btn btn-primary " id="btnadd" name=""><i class="fa fa-plus"></i> Add Item</button>
					<br>
				</div>
			</div>
			<div class="box-body table-responsive no-padding" style="max-width:2024px;">
				<table id="table_item" class="table  table-bordered table-hover ">
					<thead>
						<tr class="tableheader">
							<th style="width:40px">#</th>
							<th style="width:60px">Id</th>
							<th style="width:100px">Item</th>
							<th style="width:100px">location</th>
							<th style="width:120px">Ware-H Price</th>
							<th style="width:120px">Farm Price</th>
							<th style="width:60px">Stock</th>
							<th style="width:60px">term</th>
							<th style="width:100px">note</th>
							<th></th>
						</tr>
					</thead>
					<tbody></tbody>
				</table>
			</div>		
		</div>
	</div><!-- /.box -->

</section><!-- /.content -->

<div id="modalmasteritem" class="modal fade ">
	<div class="modal-dialog modal-md">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal">×</button>
				<h4 class="modal-title">Add Commodity</h4>
			</div>
			<!--modal header-->
			<div class="modal-body">
				<div class="form-horizontal">
					<div class="box-body">


                          <div class="form-group item-required" id="selectcountryerror">
                          <label for="country">Country</label>
                          <select id="selectcountry" name="selectcountry" class="form-control input-value">
                            <option value="">Select Country</option>
                        <?php foreach ($result_country as $country) { ?>
                            <option value="<?php echo $country["country_id"]?>"><?php echo $country["country_name"]?></option>
                        <?php } ?>
                        </select>
                        </div>

                        


                        

						<div class="form-group"> <label class="col-sm-3  control-label">Id</label>
							<div class="col-sm-7"><input type="text" class="form-control " id="txtiditem" name="txtiditem" value="*New" placeholder="" disabled=""><input type="hidden" id="inputcrud" name="inputcrud" class="" value="N"> </div>
						</div>
						
						<div class="form-group"> <label class="col-sm-3  control-label">Item</label>
							<div class="col-sm-7">
							<select id="selectcountry" name="selectcountry" class="form-control input-value">
                            <option value="">Select Country</option>
                        <?php foreach ($result_country as $country) { ?>
                            <option value="<?php echo $country["country_id"]?>"><?php echo $country["country_name"]?></option>
                        <?php } ?>
                        </select>
							</div>
							
						</div>
					
						<div class="form-group"> <label class="col-sm-3  control-label">Item</label>
							<div class="col-sm-7"><input type="text" class="form-control " id="txtname" name="txtname" value="" placeholder=""> </div>
							
						</div>

                      
						<div class="form-group"> <label class="col-sm-3  control-label">location</label>
							<div class="col-sm-7"><input type="text" class="form-control " id="txtloc" name="txtloc" value="" placeholder="Please fill out Location name"> </div>
						</div>
						
						<br>
						<div class="form-group"> <label class="col-sm-3  control-label">Stock</label>
							<div class="col-sm-7"><input type="text" class="form-control decimal" id="txtstock" name="" value="0" placeholder=""> </div>
						</div>

						<div class="form-group"> <label class="col-sm-3  control-label">Terms</label>
							<div class="col-sm-7"><input type="text" class="form-control decimal" id="txtterms" name="" value="0" placeholder=""> </div>
						</div>
						<div class="form-group"> <label class="col-sm-3  control-label">Unit</label>
							<div class="col-sm-7"><input type="text" class="form-control " id="txtunit" name="" value="" placeholder="Please fill out unit name"> </div>
						</div>
						<div class="form-group"> <label class="col-sm-3  control-label">WareHouse Price</label>
							<div class="col-sm-7">
								<div class="input-group">
									<span class="input-group-addon">N.</span>
									<input type="text" class="form-control money" id="txtprice" name="" value="" placeholder=""></div>
								</div>
							</div>

							<div class="form-group"> <label class="col-sm-3  control-label">Farm Price</label>
							<div class="col-sm-7">
								<div class="input-group">
									<span class="input-group-addon">N.</span>
									<input type="text" class="form-control money" id="txtfprice" name="" value="" placeholder=""></div>
								</div>
							</div>

							<div class="form-group"> <label class="col-sm-3  control-label">Note</label>
								<div class="col-sm-7"><textarea class="form-control " rows="3" id="txtnote" name="" placeholder="Note"></textarea> </div>
							</div>
							<div class="form-group"> <label class="col-sm-3  control-label"></label>
								<div class="col-sm-7"><button type="submit" title="Save Button" class="btn btn-primary " id="btnsaveitem" name=""><i class="fa fa-save"></i> Save</button> <span id="infoproses"></span> </div>
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
	<section class="content">
	<div class="box box-success">
		<div class="box-header with-border">
			<h2 class="box-title">Guaranteed Order</h2>
		</div>
		<!--./ box header-->
		<div class="box-body">
			
			<div class="box-body table-responsive no-padding" style="max-width:1524px;">
				<table id="table_request" class="table  table-bordered table-hover ">
					<thead>
						<tr class="tableheader">
							<th style="width:20px">#</th>
							<th style="width:40px">Id</th>
							<th style="width:100px">Order Title</th>
							<th style="width:90px">Commodity &nbsp; &nbsp; &nbsp;  &nbsp;      </th>
							<th style="width:90px">Guaranteed QTY</th>
							<th style="width:90px">Unit &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</th>
							<th style="width:90px">Guaranteed Price</th>
							<th style="width:90px">Allowed C.%</th>
							<th style="width:90px">Cover Value</th>
							<th style="width:90px">Bond Value</th>
							<th style="width:90px">Handling Type</th>
							<th style="width:90px">Interest Rate</th>
							<th style="width:90px">Offtaker Rate</th>
							<th style="width:90px">Remark \n</th>
							
							<th></th>
						</tr>
					</thead>
					<tbody></tbody>
				</table>
			</div>		
		</div>
	</div><!-- /.box -->

</section><!-- /.content -->


<!--Request to buy-->
<!-- /.content -->

<div id="modalmasterrequest" class="modal fade ">
	<div class="modal-dialog modal-md">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal">×</button>
				<h4 class="modal-title">Request to buy Produce Form</h4>
			</div>
			<!--modal header-->
			<div class="modal-body">
				<div class="form-horizontal">
					<div class="box-body">
						<div class="form-group"> <label class="col-sm-3  control-label">Id</label>
							<div class="col-sm-7"><input type="text" class="form-control " id="txtidrequest" name="txtidrequest" value="*New" placeholder="" disabled=""><input type="hidden" id="inputcrud" name="inputcrud" class="" value="N"> </div>
						</div>
						<div class="form-group"> <label class="col-sm-3  control-label">Title</label>
							<div class="col-sm-7"><input type="text" class="form-control " id="requesttxtname" name="requesttxtname" value="" placeholder="Please fill out request name"> </div>
						</div>
						<div class="form-group"> <label class="col-sm-3  control-label">Commodity</label>
							<div class="col-sm-7"><input type="text" class="form-control " id="requesttxtcommodity" name="rrequesttxtcommodity" value="" placeholder="Please fill out request name"> </div>
						</div>
						<div class="form-group"> <label class="col-sm-3  control-label">Guaranteed QTY</label>
							<div class="col-sm-7"><input type="text" class="form-control decimal" id="requesttxtstock" name="" value="0" placeholder=""> </div>
						</div>
						<div class="form-group"> <label class="col-sm-3  control-label">Unit</label>
							<div class="col-sm-7"><input type="text" class="form-control " id="requesttxtunit" name="" value="" placeholder="Please fill out unit name"> </div>
						</div>
						<div class="form-group"> <label class="col-sm-3  control-label">Guaranteed Price</label>
							<div class="col-sm-7">
								<div class="input-group">
									<span class="input-group-addon">N.</span>
									<input type="text" class="form-control money" id="requesttxtprice" name="" value="" placeholder=""></div>
								</div>
							</div>
							<div class="form-group"> <label class="col-sm-3  control-label">Cover.Value</label>
							<div class="col-sm-7">
								<div class="input-group">
									<span class="input-group-addon">N.</span>
									<input type="text" class="form-control money" id="requesttxtcvalue" name="" value="" placeholder=""></div>
								</div>
							</div>
							<div class="form-group"> <label class="col-sm-3  control-label">Bonded Value</label>
							<div class="col-sm-7">
								<div class="input-group">
									<span class="input-group-addon">N.</span>
									<input type="text" class="form-control money" id="requesttxtbvalue" name="" value="" placeholder=""></div>
								</div>
							</div>
							<div class="form-group"> <label class="col-sm-3  control-label">Handling Type</label>
							<div class="col-sm-7"><input type="text" class="form-control decimal" id="requesttxthtype" name="" value="0" placeholder=""> </div>
						</div>
						<div class="form-group"> <label class="col-sm-3  control-label">Allowed Credit Percentage (%)Y</label>
							<div class="col-sm-7"><input type="text" class="form-control decimal" id="requesttxtacpercentage" name="" value="0" placeholder=""> </div>
						</div>
						<div class="form-group"> <label class="col-sm-3  control-label">Interest Rate (%)</label>
							<div class="col-sm-7"><input type="text" class="form-control decimal" id="requesttxtirate" name="" value="0" placeholder=""> </div>
						</div>
						<div class="form-group"> <label class="col-sm-3  control-label">Offtaker Rate (%)</label>
							<div class="col-sm-7"><input type="text" class="form-control decimal" id="requesttxtorate" name="" value="0" placeholder=""> </div>
						</div>
							<div class="form-group"> <label class="col-sm-3  control-label">Note</label>
								<div class="col-sm-7"><textarea class="form-control " rows="3" id="requesttxtnote" name="" placeholder="Note"></textarea> </div>
							</div>
							<div class="form-group"> <label class="col-sm-1  control-label"></label>
								<div class="col-sm-11"><button type="submit" title="Save Button" class="btn btn-primary " id="btnsaverequest" name=""><i class="fa fa-save"></i> Submit Request</button> <span id="infoproses"></span> </div>
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








<!--location-->

<section class="content">
	<div class="box box-success">
		<div class="box-header with-border">
			<h2 class="box-title">Locations</h2>
		</div>
		<!--./ box header-->
		<div class="box-body">
			
			<div class="box-body table-responsive no-padding" style="max-width:1124px;">
				<table id="table_loc" class="table  table-bordered table-hover ">
					<thead>
						<tr class="tableheader">
							<th style="width:40px">#</th>
							<th style="width:60px">Id</th>
							<th style="width:60px">location</th>
							<th style="width:60px">coordinate</th>
							<th style="width:60px">postal</th>
							<th style="width:60px">locality</th>
							<th style="width:60px">State</th>
							<th style="width:60px">Country</th>
							<th></th>
						</tr>
					</thead>
					<tbody></tbody>
				</table>
			</div>		
		</div>
	</div><!-- /.box -->

</section><!-- /.content -->


<!--Request to buy-->
<!-- /.content -->



<div id="modalmasterloc" class="modal fade ">
	<div class="modal-dialog modal-md">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal">×</button>
				<h4 class="modal-title">Add Location Form</h4>
			</div>
			<!--modal header-->
			<div class="modal-body">
				<div class="form-horizontal">
					<div class="box-body">
						<div class="form-group"> <label class="col-sm-1  control-label">Id</label>
							<div class="col-sm-11"><input type="text" class="form-control " id="txtidloc" name="txtidloc" value="*New" placeholder="" disabled=""><input type="hidden" id="inputcrud" name="inputcrud" class="" value="N"> </div>
						</div>
						<div class="form-group"> <label class="col-sm-1  control-label">location</label>
							<div class="col-sm-11"><input type="text" class="form-control " id="txtlocname" name="ltxtlocname" value="" placeholder="Please fill out request name"> </div>
						</div>
						<div class="form-group"> <label class="col-sm-1  control-label">Coordinates</label>
							<div class="col-sm-11"><input type="text" class="form-control " id="txtcood" name="txtcood" value="" placeholder="Please fill out request name"> </div>
						</div>
						<div class="form-group"> <label class="col-sm-1  control-label">Postal</label>
							<div class="col-sm-11"><input type="text" class="form-control " id="txtpostal" name="txtpostal" value="" placeholder="Please fill out request name"> </div>
						</div>
						<div class="form-group"> <label class="col-sm-1  control-label">Locality</label>
							<div class="col-sm-11"><input type="text" class="form-control " id="txtlocality" name="txtlocality" value="" placeholder="Please fill out request name"> </div>
						</div>
						<div class="form-group"> <label class="col-sm-1  control-label">State</label>
							<div class="col-sm-11"><input type="text" class="form-control " id="txtstate" name="txtstate" value="" placeholder="Please fill out request name"> </div>
						</div>
						<div class="form-group"> <label class="col-sm-1  control-label">Country</label>
							<div class="col-sm-11"><input type="text" class="form-control " id="txtcountry" name="txtcountry" value="" placeholder="Please fill out request name"> </div>
						</div>
						
							<div class="form-group"> <label class="col-sm-1  control-label"></label>
								<div class="col-sm-11"><button type="submit" title="Save Button" class="btn btn-primary " id="btnsaveloc" name=""><i class="fa fa-save"></i> Submit</button> <span id="infoproses"></span> </div>
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




<!--location-->

<!--Offtaker-->

<section class="content">
	<div class="box box-success">
		<div class="box-header with-border">
			<h2 class="box-title">Offtaker</h2>
		</div>
		<!--./ box header-->
		<div class="box-body">
			
			<div class="box-body table-responsive no-padding" style="max-width:1124px;">
				<table id="table_off" class="table  table-bordered table-hover ">
					<thead>
						<tr class="tableheader">
							<th style="width:40px">#</th>
							<th style="width:60px">Id</th>
							<th style="width:60px">offtaker</th>
							<th style="width:60px">location</th>
							<th style="width:60px">Address</th>
							<th style="width:60px">Receipt Limit</th>
							<th style="width:60px">MSISDN</th>
							<th></th>
						</tr>
					</thead>
					<tbody></tbody>
				</table>
			</div>		
		</div>
	</div><!-- /.box -->

</section><!-- /.content -->


<div id="modalmasteroff" class="modal fade ">
	<div class="modal-dialog modal-md">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal">×</button>
				<h4 class="modal-title">Add Offtaker Form</h4>
			</div>
			<!--modal header-->
			<div class="modal-body">
				<div class="form-horizontal">
					<div class="box-body">
						<div class="form-group"> <label class="col-sm-3  control-label">Id</label>
							<div class="col-sm-7"><input type="text" class="form-control " id="txtidoff" name="txtidoff" value="*New" placeholder="" disabled=""><input type="hidden" id="inputcrud" name="inputcrud" class="" value="N"> </div>
						</div>
						<div class="form-group"> <label class="col-sm-3  control-label">Offtaker</label>
							<div class="col-sm-7"><input type="text" class="form-control " id="txtoffname" name="txtoffname" value="" placeholder="Please fill out Certifier name"> </div>
						</div>
						<div class="form-group"> <label class="col-sm-3  control-label">Location</label>
							<div class="col-sm-7"><input type="text" class="form-control " id="txtlocnameoff" name="txtlocnameoff" value="" placeholder="Please fill out Certifier name"> </div>
						</div>
						<div class="form-group"> <label class="col-sm-3  control-label">Receipt Limit</label>
							<div class="col-sm-7"><input type="text" class="form-control " id="txtlimitoff" name="txtlimitoff" value="" placeholder="Please fill out Certifier Location"> </div>
						</div>
						<div class="form-group"> <label class="col-sm-3  control-label">Address</label>
							<div class="col-sm-7"><input type="text" class="form-control " id="txtaddressoff" name="txtaddressoff" value="" placeholder="Please fill out Commodity"> </div>
						</div>

						<div class="form-group"> <label class="col-sm-3  control-label">MSISDN</label>
							<div class="col-sm-7"><input type="text" class="form-control " id="txtmsisdnoff" name="txtmsisdnoff" value="" placeholder="Please fill out Commodity"> </div>
						</div>
						
							<div class="form-group"> <label class="col-sm-1  control-label"></label>
								<div class="col-sm-11"><button type="submit" title="Save Button" class="btn btn-primary " id="btnsaveoff" name=""><i class="fa fa-save"></i> Submit</button> <span id="infoproses"></span> </div>
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



<!--Offtaker-->


<!--Certifier-->

<section class="content">
	<div class="box box-success">
		<div class="box-header with-border">
			<h2 class="box-title">Certifier</h2>
		</div>
		<!--./ box header-->
		<div class="box-body">
			
			<div class="box-body table-responsive no-padding" style="max-width:1124px;">
				<table id="table_cer" class="table  table-bordered table-hover ">
					<thead>
						<tr class="tableheader">
							<th style="width:40px">#</th>
							<th style="width:60px">Id</th>
							<th style="width:60px">Certifier</th>
							<th style="width:60px">location</th>
							<th style="width:60px">Commodity</th>
							
							<th></th>
						</tr>
					</thead>
					<tbody></tbody>
				</table>
			</div>		
		</div>
	</div><!-- /.box -->

</section><!-- /.content -->
<!--Certifier-->
<!-- /.content -->

<div id="modalmastercer" class="modal fade ">
	<div class="modal-dialog modal-md">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal">×</button>
				<h4 class="modal-title">Add Certifier Form</h4>
			</div>
			<!--modal header-->
			<div class="modal-body">
				<div class="form-horizontal">
					<div class="box-body">
						<div class="form-group"> <label class="col-sm-3  control-label">Id</label>
							<div class="col-sm-7"><input type="text" class="form-control " id="txtidcer" name="txtidcer" value="*New" placeholder="" disabled=""><input type="hidden" id="inputcrud" name="inputcrud" class="" value="N"> </div>
						</div>
						<div class="form-group"> <label class="col-sm-3  control-label">Certifier</label>
							<div class="col-sm-7"><input type="text" class="form-control " id="txtcername" name="ltxtcername" value="" placeholder="Please fill out Certifier name"> </div>
						</div>
						<div class="form-group"> <label class="col-sm-3  control-label">location</label>
							<div class="col-sm-7"><input type="text" class="form-control " id="txtlocnamec" name="ltxtlocname" value="" placeholder="Please fill out Certifier Location"> </div>
						</div>
						<div class="form-group"> <label class="col-sm-3  control-label">Commodity</label>
							<div class="col-sm-7"><input type="text" class="form-control " id="txtcommodityc" name="txtcommodity" value="" placeholder="Please fill out Commodity"> </div>
						</div>
						
							<div class="form-group"> <label class="col-sm-1  control-label"></label>
								<div class="col-sm-11"><button type="submit" title="Save Button" class="btn btn-primary " id="btnsavecer" name=""><i class="fa fa-save"></i> Submit</button> <span id="infoproses"></span> </div>
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

<!--Offtaker-->




<!--Farmer-->

<section class="content">
	<div class="box box-success">
		<div class="box-header with-border">
			<h2 class="box-title">Farmer</h2>
		</div>
		<!--./ box header-->
		<div class="box-body">
			
			<div class="box-body table-responsive no-padding" style="max-width:1124px;">
				<table id="table_far" class="table  table-bordered table-hover ">
					<thead>
						<tr class="tableheader">
							<th style="width:40px">#</th>
							<th style="width:60px">Id</th>
							<th style="width:60px">Farmer</th>
							<th style="width:60px">location</th>
							<th style="width:60px">Address</th>
							<th style="width:60px">MSISDN</th>
							<th></th>
						</tr>
					</thead>
					<tbody></tbody>
				</table>
			</div>		
		</div>
	</div><!-- /.box -->

</section><!-- /.content -->


<div id="modalmasterfar" class="modal fade ">
	<div class="modal-dialog modal-md">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal">×</button>
				<h4 class="modal-title">Add Farmer Form</h4>
			</div>
			<!--modal header-->
			<div class="modal-body">
				<div class="form-horizontal">
					<div class="box-body">
						<div class="form-group"> <label class="col-sm-3  control-label">Id</label>
							<div class="col-sm-7"><input type="text" class="form-control " id="txtidfar" name="txtidfar" value="*New" placeholder="" disabled=""><input type="hidden" id="inputcrud" name="inputcrud" class="" value="N"> </div>
						</div>
						<div class="form-group"> <label class="col-sm-3  control-label">Farmer</label>
							<div class="col-sm-7"><input type="text" class="form-control " id="txtfarname" name="txtfarname" value="" placeholder="Please fill out Certifier name"> </div>
						</div>
						<div class="form-group"> <label class="col-sm-3  control-label">Location</label>
							<div class="col-sm-7"><input type="text" class="form-control " id="txtlocnamefar" name="txtlocnamefar" value="" placeholder="Please fill out Certifier name"> </div>
						</div>
						
						<div class="form-group"> <label class="col-sm-3  control-label">Address</label>
							<div class="col-sm-7"><input type="text" class="form-control " id="txtaddressfar" name="txtaddressfar" value="" placeholder="Please fill out Commodity"> </div>
						</div>

						<div class="form-group"> <label class="col-sm-3  control-label">MSISDN</label>
							<div class="col-sm-7"><input type="text" class="form-control " id="txtmsisdnfar" name="txtmsisdnfar" value="" placeholder="Please fill out Commodity"> </div>
						</div>
						
							<div class="form-group"> <label class="col-sm-1  control-label"></label>
								<div class="col-sm-11"><button type="submit" title="Save Button" class="btn btn-primary " id="btnsavefar" name=""><i class="fa fa-save"></i> Submit</button> <span id="infoproses"></span> </div>
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
<!--farmer-->





	<?php include "../layout/footer.php"; //footer template ?> 
	<?php include "../layout/bottom-footer.php"; //footer template ?> 
	<script src="j_item.js"></script>
	<script src="j_request.js"></script>
	<script src="j_loc.js"></script>
	<script src="j_cer.js"></script>
	<script src="j_off.js"></script>
	<script src="j_far.js"></script>
	

</body>
</html>
