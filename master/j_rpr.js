$(document).ready( function () 
{



	$(document).on('change','#txtmsisdnrpr', function() {
		var wphonerpr_id = $(this).val();
		if(wphonerpr_id != "") {
			$.ajax({
				url:"c_rpr.php",
				type:'POST',
				data:{wphonerpr_id:wphonerpr_id},
				success:function(response) {
					//var resp = $.trim(response);
					if(response != '') {
						$("#txtaddressrpr").removeAttr('disabled','disabled').html(response);
						
					} else {
						$("#txtaddressrpr").attr('disabled','disabled').html("<option value=''>----- Select ---</option>");
					}
				}
			});
		} else {
			$("#txtaddressrpr").attr('disabled','disabled').html("<option value=''>----- Select ------</option>");
		}
    });
    
    $(document).on('change','#txtaddressrpr', function() {
		var b_addressrpr = $(this).val();
		if(b_addressrpr != "") {
			$.ajax({
				url:"c_rpr.php",
				type:'POST',
				data:{b_addressrpr:b_addressrpr},
				success:function(response) {
					//var resp = $.trim(response);
					if(response != '') {
						$("#txtoaddressrpr").removeAttr('disabled','disabled').html(response);
						
					} else {
						$("#txtoaddressrpr").attr('disabled','disabled').html("<option value=''>----- Select ---</option>");
					}
				}
			});
		} else {
			$("#txtoaddressrpr").attr('disabled','disabled').html("<option value=''>----- Select ------</option>");
		}
	});


    $(document).on('change','#offtxtmsisdnrpr', function() {
		var offwphonerpr_id = $(this).val();
		if(offwphonerpr_id != "") {
			$.ajax({
				url:"c_rpr.php",
				type:'POST',
				data:{offwphonerpr_id:offwphonerpr_id},
				success:function(response) {
					//var resp = $.trim(response);
					if(response != '') {
						$("#offtxtaddressrpr").removeAttr('disabled','disabled').html(response);
						
					} else {
						$("#offtxtaddressrpr").attr('disabled','disabled').html("<option value=''>----- Select ---</option>");
					}
				}
			});
		} else {
			$("#offtxtaddressrpr").attr('disabled','disabled').html("<option value=''>----- Select ------</option>");
		}
    });



	$(document).on('change','#fartxtmsisdnrpr', function() {
		var farwphonerpr_id = $(this).val();
		if(farwphonerpr_id != "") {
			$.ajax({
				url:"c_rpr.php",
				type:'POST',
				data:{farwphonerpr_id:farwphonerpr_id},
				success:function(response) {
					//var resp = $.trim(response);
					if(response != '') {
						$("#fartxtaddressrpr").removeAttr('disabled','disabled').html(response);
						
					} else {
						$("#fartxtaddressrpr").attr('disabled','disabled').html("<option value=''>----- Select ---</option>");
					}
				}
			});
		} else {
			$("#fartxtaddressrpr").attr('disabled','disabled').html("<option value=''>----- Select ------</option>");
		}
    });







	money();
	decimal();
	var value = {
		method : "getdata"
	};
	$('#table_rpr').DataTable({
		"paging": true,
		"lengthChange": false,
		"searching": true,
		"ordering": true,
		"info": false,
		"responsive": true,
		"autoWidth": false,
		"pageLength": 3,
		"dom": '<"top"f>rtip',
		"ajax": {
			"url": "c_rpr.php",
			"type": "POST",
			"data":value,
		},
		"columns": [
		{ "data": "urutan" },
		{ "data": "id_rpr" },
		{ "data": "rpr_title" },
		{ "data": "guaranteed_order" },
		{ "data": "redeemed_receipt" },
		{ "data": "redeemed_address" },
		{ "data": "current_status" },
		{ "data": "button" },
		]
	});
	$("#table_rpr_filter").addClass("pull-right");
	
});

$(document).on( "click","#btnaddrpr", function() {
	$(".contentharga").remove();
	$("#modalmasterrpr").modal('show');
	newrpr();
});
function newrpr()
{
	$("#txtidrpr").val("*New");
	$("#txtrprname").val("");
	$("#fartxtmsisdnrpr").val("");
	$("#fartxtaddressrpr").val("");
	$("#txtoaddressrpr").val("");
	$("#txtoreceiptrpr").val("");
	$("#txtpassrpr").val("");
	$("#inputcrud").val("N");
	set_focus("#txtrprname");
}
$(document).on( "click",".btneditrpr", function() {
	var id_rpr = $(this).attr("id_rpr");
	var value = {
		id_rpr: id_rpr,
		method : "get_detail_rpr"
	};
	$.ajax(
	{
		url : "c_rpr.php",
		type: "POST",
		data : value,
		success: function(data, textStatus, jqXHR)
		{
			var hasil = jQuery.parseJSON(data);
			data = hasil.data;
			$("#inputcrud").val("E");
			$("#txtidrpr").val(data.id_rpr);
	
			$("#txtrprname").val(data.rpr_name);
			$("#fartxtmsisdnrpr").val(data.farmsisdnrpr);
			$("#fartxtaddressrpr").val(data.faraddressrpr);
			$("#txtoaddressrpr").val(data.order_address);
			
			$("#txtareceiptrpr").val(data.oreceipt);
			$("#txtpassrpr").val(data.passrpr);
			$("#modalmasterrpr").modal('show');
			set_focus("#txtrprname");
		},
		error: function(jqXHR, textStatus, errorThrown)
		{
		}
	});
});
$(document).on( "click","#btnsaverpr", function() {
	var id_rpr = $("#txtidrpr").val();
	var rpr_name = $("#txtrprname").val();
	var farmsisdnrpr = $("#fartxtmsisdnrpr").val();
	var faraddressrpr = $("#fartxtaddressrpr").val();
	var passrpr = $("#txtpassrpr").val();
	var order_address = $("#txtoaddressrpr").val();
	var oreceipt = $("#txtoreceiptrpr").val();
	var crud=$("#inputcrud").val();
	if(crud == 'E'){
		if(id_rpr == '' || id_rpr== null ){
			$.notify({
				message: "rpr Id invalid"
			},{
				type: 'warning',
				delay: 4000,
			});		
			$("#txtidrpr").focus();
			return;
		}	
	}
	if(rpr_name == '' || rpr_name== null ){
		$.notify({
			message: "Please fill out the Receipts Title"
		},{
			type: 'warning',
			delay: 4000,
		});		
		$("#txtrprname").focus();
		return;
	}
	if(farmsisdnrpr == '' || farmsisdnrpr== null ){
		$.notify({
			message: "Please fill out the OffTaker MSISDN"
		},{
			type: 'warning',
			delay: 4000,
		});		
		$("#fartxtmsisdnrpr").focus();
		return;
	}
	if(faraddressrpr == '' || faraddressrpr== null ){
		$.notify({
			message: "Please fill out the OffTaker Address"
		},{
			type: 'warning',
			delay: 4000,
		});		
		$("#fartxtaddressrpr").focus();
		return;
	}
	
	if(order_address == '' || order_address== null ){
		$.notify({
			message: "Please fill out the CCB/Buyer Order Address"
		},{
			type: 'warning',
			delay: 4000,
		});		
		$("#txtoaddressrpr").focus();
		return;
	}

	if(oreceipt == '' || oreceipt== null ){
		$.notify({
			message: "Please fill out the order Receipt "
		},{
			type: 'warning',
			delay: 4000,
		});		
		$("#txtoreceiptrpr").focus();
		return;
	}

	if(passrpr == '' || passrpr== null ){
		$.notify({
			message: "Please fill out the OffTaker Password"
		},{
			type: 'warning',
			delay: 4000,
		});		
		$("#txtpassrpr").focus();
		return;
	}
	


	

	var value = {
		id_rpr     :id_rpr,
	rpr_name       :rpr_name,
	farmsisdnrpr   :farmsisdnrpr,
	faraddressrpr  :faraddressrpr ,
	passrpr        :passrpr ,
	order_address  :order_address ,
	oreceipt       :oreceipt,
	crud:crud,
		method : "save_rpr"
	};
	$(this).prop('disabled', true);
	proccess_waiting("#infoproses");
	$.ajax(
	{
		url : "c_rpr.php",
		type: "POST",
		data : value,
		success: function(data, textStatus, jqXHR)
		{
			$("#btnsaverpr").prop('disabled', false);
			$("#infoproses").html("");
			var data = jQuery.parseJSON(data);
			if(data.ceksat == 0){
				$.notify(data.error);
			}else{
				if(data.crud == 'N'){
					if(data.result == 1){
						$.notify('Save rpr successfuly');
						var table = $('#table_rpr').DataTable(); 
						table.ajax.reload( null, false );
						newrpr();				
					}else{
						$.notify({
							message: "Error save rpr, error :"+data.error
						},{
							type: 'danger',
							delay: 4000,
						});
						set_focus("#txtidrpr");
					}
				}else if(data.crud == 'E'){
					if(data.result == 1){
						$.notify('Update rpr successfuly');
						var table = $('#table_rpr').DataTable(); 
						table.ajax.reload( null, false );
						$("#modalmasterrpr").modal("hide");
					}else{
						$.notify({
							message: "Error update rpr, error :"+data.error
						},{
							type: 'danger',
							delay: 4000,
						});					
						set_focus("#txtidrpr");
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
			$("#btnsaverpr").prop('disabled', false);
		}
	});
});
$(document).on( "click",".btndeleterpr", function() {
	var id_rpr = $(this).attr("id_rpr");
	swal({   
		title: "Delete",   
		text: "Delete Produce rpr with id : "+id_rpr+" ?",   
		type: "warning",   
		showCancelButton: true,   
		confirmButtonColor: "#DD6B55",   
		confirmButtonText: "Delete",   
		closeOnConfirm: true }, 
		function(){   
			var value = {
				id_rpr: id_rpr,
				method : "delete_rpr"
			};
			$.ajax(
			{
				url : "c_rpr.php",
				type: "POST",
				data : value,
				success: function(data, textStatus, jqXHR)
				{
					var data = jQuery.parseJSON(data);
					if(data.result ==1){
						$.notify('Delete rpr successfuly');
						var table = $('#table_rpr').DataTable(); 
						table.ajax.reload( null, false );
					}else{
						$.notify({
							message: "Error delete rpr, error :"+data.error
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

