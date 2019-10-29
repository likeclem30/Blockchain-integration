$(document).ready( function () 
{
	$(document).on('change','#txtmsisdnrequest', function() {
		var wphonerequest_id = $(this).val();
		if(wphonerequest_id != "") {
			$.ajax({
				url:"c_request.php",
				type:'POST',
				data:{wphonerequest_id:wphonerequest_id},
				success:function(response) {
					//var resp = $.trim(response);
					if(response != '') {
						$("#txtaddressrequest").removeAttr('disabled','disabled').html(response);
						
					} else {
						$("#txtaddressrequest").attr('disabled','disabled').html("<option value=''>----- Select ---</option>");
					}
				}
			});
		} else {
			$("#txtaddressrequest").attr('disabled','disabled').html("<option value=''>----- Select ------</option>");
		}
	});

	money();
	decimal();
	var value = {
		method : "getdata"
	};
	
	$('#table_request').DataTable({
		"paging": true,
		"lengthChange": true,
		"searching": true,
		"ordering": true,
		"info": false,
		"responsive": true,
		"autoWidth": true,
		"pageLength": 3,
		"dom": '<"top"f>rtip',
		"ajax": {
			"url": "c_request.php",
			"type": "POST",
			"data":value,
		},
		"columns": [
		{ "data": "urutan" },
		{ "data": "request_name"},
		{ "data": "msisdnreq"},
		{ "data": "commodity"},
		{ "data": "stock" },
		
		{ "data": "price" },
		{ "data": "allowed_credit" },
		{ "data": "cover_value" },
		{ "data": "bond_value" },
		{ "data": "handling_type" },
		{ "data": "interest_rate" },
		
		{ "data": "gorder_status" }, 
		
		{ "data": "gorderaccounting_status" },
		{ "data": "transfer_status" },
		{ "data": "button" },
		]
	});
	$("#table_request_filter").addClass("pull-right");
});

$(document).on( "click","#btnaddrequest", function() {
	$(".contentharga").remove();
	$("#modalmasterrequest").modal('show');
	newrequest();
});
function newrequest()
{
	$("#txtidrequest").val("*New");
	$("#requesttxtname").val("");
	$("#requesttxtcommodity").val("");
	$("#requesttxtstock").val(0);
	$("#requesttxtunit").change();
	$("#requesttxtprice").val(0);
	$("#requesttxtacpercentage").val(0);
	$("#requesttxtcvalue").val(0);
	$("#requesttxtbvalue").val(0);
	$("#requesttxthtype").val(0);
	$("#requesttxtirate").val(0);
	
	$("#requesttxtduration").val(0);
	$("#requesttxtmsisdn").val("");
	$("#requesttxtaddress").val("");
	$("#requesttxtpass").val("");
	$("#inputcrud").val("N");
	set_focus("#requesttxtname");
}
$(document).on( "click",".btneditrequest", function() {
	var id_request = $(this).attr("id_request");
	var value = {
		id_request: id_request,
		method : "get_detail_request"
	};
	$.ajax(
	{
		url : "c_request.php",
		type: "POST",
		data : value,
		success: function(data, textStatus, jqXHR)
		{
			var hasil = jQuery.parseJSON(data);
			data = hasil.data;
			$("#requestinputcrud").val("E");
			$("#txtidrequest").val(data.id_request);
			$("#requesttxtname").val(data.request_name);
			$("#requesttxtcommodity").val(data.commodity);
			$("#requesttxtstock").val(addCommas(data.stock));
			$("#requesttxtunit").val(data.unit);
			$("#requesttxtprice").val(addCommas(data.price));
			$("#requesttxtacpercentage").val(data.allowed_credit);
			$("#requesttxtcvalue").val(addCommas(data.cover_value));
			$("#requesttxtbvalue").val(addCommas(data.bond_value));
			$("#requesttxthtype").val(addCommas(data.handling_type));
			$("#requesttxtirate").val(addCommas(data.interest_rate));
			
			$("#requesttxtduration").val($.trim(data.duration));
			$("#requesttxtmsisdn").val(data.msisdnreq);
			$("#requesttxtaddress").val(data.addressreq);
			$("#requesttxtpass").val(data.passreq);
			$("#modalmasterrequest").modal('show');
			set_focus("#requesttxtname");
		},
		error: function(jqXHR, textStatus, errorThrown)
		{
		}
	});
});
$(document).on( "click","#btnsaverequest", function() {
	var id_request = $("#txtidrequest").val();
	var request_name = $("#requesttxtname").val();
	var commodity = $("#requesttxtcommodity").val();
	var stock = cleanString($("#requesttxtstock").val());
	var unit = $("#requesttxtunit").val();
	var price = cleanString($("#requesttxtprice").val());
	var allowed_credit = cleanString($("#requesttxtacpercentage").val());
	var cover_value = cleanString($("#requesttxtcvalue").val());
	var bond_value = cleanString($("#requesttxtbvalue").val());
	var handling_type = cleanString($("#requesttxthtype").val());
	var interest_rate = cleanString($("#requesttxtirate").val());
	//var offtaker_rate = cleanString($("#requesttxtorate").val());
	var duration = cleanString($("#requesttxtduration").val());
	var msisdnreq = $("#txtmsisdnrequest").val();
	var addressreq = $("#txtaddressrequest").val();
	var passreq = $("#requesttxtpass").val();
	var crud=$("#inputcrud").val();
	if(crud == 'E'){
		if(id_request == '' || id_request== null ){
			$.notify({
				message: "request Id invalid"
			},{
				type: 'warning',
				delay: 4000,
			});		
			$("#txtidrequest").focus();
			return;
		}	
	}
	if(request_name == '' || request_name== null ){
		$.notify({
			message: "Please fill out request name"
		},{
			type: 'warning',
			delay: 4000,
		});		
		$("#requesttxtname").focus();
		return;
	}

	if(commodity == '' || commodity== null ){
		$.notify({
			message: "Please fill out Commodity name"
		},{
			type: 'warning',
			delay: 4000,
		});		
		$("#requesttxtcommodity").focus();
		return;
	}

	if(unit == '' || unit== null ){
		$.notify({
			message: "Please fill out the qty unit"
		},{
			type: 'warning',
			delay: 4000,
		});		
		$("#requesttxtunit").focus();
		return;
	}

	if(stock == '' || stock== 0 ){
		$.notify({
			message: "Please fill out the Guaranteed qty"
		},{
			type: 'warning',
			delay: 4000,
		});		
		$("#requesttxtstock").focus();
		return;
	}

	if(price == '' || price== 0 ){
		$.notify({
			message: "Please fill out the Guaranteed Price"
		},{
			type: 'warning',
			delay: 4000,
		});		
		$("#requesttxtprice").focus();
		return;
	}

	if(cover_value == '' || cover_value== 0 ){
		$.notify({
			message: "Please fill out the Cover Value"
		},{
			type: 'warning',
			delay: 4000,
		});		
		$("#requesttxtcvalue").focus();
		return;
	}
	
	if(bond_value == '' || bond_value == null ){
		$.notify({
			message: "Please fill out the Bond Value"
		},{
			type: 'warning',
			delay: 4000,
		});		
		$("#requesttxtbvalue").focus();
		return;
	}
/**
	var valueTotal = price * stock;
	var cb = cover_value + bond_value;

	if(cb > valueTotal){
		$.notify({
			message: "Total value of Order(Price * qty) cannot be less than Cover value plus bonded value"
		},{
			type: 'warning',
			delay: 4000,
		});		
		$("#requesttxtstock").focus();
		return;
	}
 */

	if(handling_type == '' || handling_type== null ){
		$.notify({
			message: "Please fill out the Handling Type"
		},{
			type: 'warning',
			delay: 4000,
		});		
		$("#requesttxthtype").focus();
		return;
	}

	if(allowed_credit == '' || allowed_credit== null ){
		$.notify({
			message: "Please fill out the Allow Credit Percentage"
		},{
			type: 'warning',
			delay: 4000,
		});		
		$("#requesttxtacpercentage").focus();
		return;
	}

	if(interest_rate == '' || interest_rate== null ){
		$.notify({
			message: "Please fill out the Interest Rate"
		},{
			type: 'warning',
			delay: 4000,
		});		
		$("#requesttxtirate").focus();
		return;
	}
/**
	if(offtaker_rate == '' || offtaker_rate== 0 ){
		$.notify({
			message: "Please fill out the offtaker Rate"
		},{
			type: 'warning',
			delay: 4000,
		});		
		$("#requesttxtorate").focus();
		return;
	}
 */
	if(duration == '' || duration== 0 ){
		$.notify({
			message: "Please fill out the order duration"
		},{
			type: 'warning',
			delay: 4000,
		});		
		$("#requesttxtduration").focus();
		return;
	}
	if(msisdnreq == '' || msisdnreq== 0 ){
		$.notify({
			message: "Please fill out the order Wallet no"
		},{
			type: 'warning',
			delay: 4000,
		});		
		$("#requesttxtmsisdn").focus();
		return;
	}
	if(addressreq == '' || addressreq== 0 ){
		$.notify({
			message: "Please fill out the buyer Block Address"
		},{
			type: 'warning',
			delay: 4000,
		});		
		$("#requesttxtaddress").focus();
		return;
	}
	if(passreq == '' || passreq== 0 ){
		$.notify({
			message: "Please fill out the buyer Block password"
		},{
			type: 'warning',
			delay: 4000,
		});		
		$("#requesttxtpass").focus();
		return;
	}

	var value = {
		id_request: id_request,
		request_name: request_name,
		commodity: commodity,
		stock:stock,
		unit:unit,
		price:price,
		allowed_credit:allowed_credit,
		cover_value:cover_value,
		bond_value:bond_value,
		handling_type:handling_type,
		interest_rate:interest_rate,
	//	offtaker_rate:offtaker_rate,
		duration:duration,
		msisdnreq:msisdnreq,
		addressreq:addressreq,
		passreq:passreq,
		crud:crud,
		method : "save_request"
	};
	$(this).prop('disabled', true);
	proccess_waiting("#infoprosesrequest");
	$.ajax(
	{
		url : "c_request.php",
		type: "POST",
		data : value,
		success: function(data, textStatus, jqXHR)
		{
			$("#btnsaverequest").prop('disabled', false);
			$("#infoprosesrequest").html("");
			var data = jQuery.parseJSON(data);
			if(data.ceksat == 0){
				$.notify(data.error);
			}else{
				if(data.crud == 'N'){
					if(data.result == 1){
						$.notify('Save request successfuly');
						var table = $('#table_request').DataTable(); 
						table.ajax.reload( null, false );
						newrequest();				
					}else{
						$.notify({
							message: "Error save request, error :"+data.error
						},{
							type: 'danger',
							delay: 4000,
						});
						set_focus("#txtidrequest");
					}
				}else if(data.crud == 'E'){
					if(data.result == 1){
						$.notify('Update request successfuly');
						var table = $('#table_request').DataTable(); 
						table.ajax.reload( null, false );
						$("#modalmasterrequest").modal("hide");
					}else{
						$.notify({
							message: "Error update request, error :"+data.error
						},{
							type: 'danger',
							delay: 4000,
						});					
						set_focus("#txtidrequest");
					}
				}else{
					$.notify({
						message: "Invalid request"
					},{
						type: 'danger',
						delay: 4000,
					});	
				}
			}
		},
		error: function(jqXHR, textStatus, errorThrown)
		{
			$("#btnsaverequest").prop('disabled', false);
		}
	});
});
$(document).on( "click",".btndeleterequest", function() {
	var id_request = $(this).attr("id_request");
	swal({   
		title: "Delete",   
		text: "Delete master request with id : "+id_request+" ?",   
		type: "warning",   
		showCancelButton: true,   
		confirmButtonColor: "#DD6B55",   
		confirmButtonText: "Delete",   
		closeOnConfirm: true }, 
		function(){   
			var value = {
				id_request: id_request,
				method : "delete_request"
			};
			$.ajax(
			{
				url : "c_request.php",
				type: "POST",
				data : value,
				success: function(data, textStatus, jqXHR)
				{
					var data = jQuery.parseJSON(data);
					if(data.result ==1){
						$.notify('Delete request successfuly');
						var table = $('#table_request').DataTable(); 
						table.ajax.reload( null, false );
					}else{
						$.notify({
							message: "Error delete request, error :"+data.error
						},{
							type: 'eror',
							delay: 4000,
						});	
					}
				},
				error: function(jqXHR, textStatus, errorThrown)
				{
				}
			});
		});
});

