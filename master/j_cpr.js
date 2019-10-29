$(document).ready( function () 
{

	$(document).on('change','#txtmsisdncpr', function() {
		var wphonecpr_id = $(this).val();
		if(wphonecpr_id != "") {
			$.ajax({
				url:"c_cpr.php",
				type:'POST',
				data:{wphonecpr_id:wphonecpr_id},
				success:function(response) {
					//var resp = $.trim(response);
					if(response != '') {
						$("#txtaddresscpr").removeAttr('disabled','disabled').html(response);
						
					} else {
						$("#txtaddresscpr").attr('disabled','disabled').html("<option value=''>----- Select ---</option>");
					}
				}
			});
		} else {
			$("#txtaddresscpr").attr('disabled','disabled').html("<option value=''>----- Select ------</option>");
		}
    });
    
    $(document).on('change','#txtaddresscpr', function() {
		var b_addresscpr = $(this).val();
		if(b_addresscpr != "") {
			$.ajax({
				url:"c_cpr.php",
				type:'POST',
				data:{b_addresscpr:b_addresscpr},
				success:function(response) {
					//var resp = $.trim(response);
					if(response != '') {
						$("#txtoaddresscpr").removeAttr('disabled','disabled').html(response);
						
					} else {
						$("#txtoaddresscpr").attr('disabled','disabled').html("<option value=''>----- Select ---</option>");
					}
				}
			});
		} else {
			$("#txtoaddresscpr").attr('disabled','disabled').html("<option value=''>----- Select ------</option>");
		}
	});

	$(document).on('change','#txtoaddresscpr', function() {
		var order_address = $(this).val();
		if(order_address != "") {
			$.ajax({
				url:"c_cpr.php",
				type:'POST',
				data:{order_address:order_address},
				success:function(response) {
					//var resp = $.trim(response);
					if(response != '') {
						$("#txtoreceiptcpr").removeAttr('disabled','disabled').html(response);
						
					} else {
						$("#txtoreceiptcpr").attr('disabled','disabled').html("<option value=''>----- Select ---</option>");
					}
				}
			});
		} else {
			$("#txtoreceiptcpr").attr('disabled','disabled').html("<option value=''>----- Select ------</option>");
		}
	});


    $(document).on('change','#certxtmsisdncpr', function() {
		var cerwphonecpr_id = $(this).val();
		if(cerwphonecpr_id != "") {
			$.ajax({
				url:"c_cpr.php",
				type:'POST',
				data:{cerwphonecpr_id:cerwphonecpr_id},
				success:function(response) {
					//var resp = $.trim(response);
					if(response != '') {
						$("#certxtaddresscpr").removeAttr('disabled','disabled').html(response);
						
					} else {
						$("#certxtaddresscpr").attr('disabled','disabled').html("<option value=''>----- Select ---</option>");
					}
				}
			});
		} else {
			$("#certxtaddresscpr").attr('disabled','disabled').html("<option value=''>----- Select ------</option>");
		}
    });









	money();
	decimal();
	var value = {
		method : "getdata"
	};
	$('#table_cpr').DataTable({
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
			"url": "c_cpr.php",
			"type": "POST",
			"data":value,
		},
		"columns": [
		{ "data": "urutan" },
		{ "data": "id_cpr" },
		{ "data": "cpr_name" },
		{ "data": "msisdncpr" },
		{ "data": "cermsisdncpr" },
		{ "data": "transaction_status" },
		{ "data": "button" },
		]
	});
	$("#table_cpr_filter").addClass("pull-right");
	
});

$(document).on( "click","#btnaddcpr", function() {
	$(".contentharga").remove();
	$("#modalmastercpr").modal('show');
	newcpr();
});
function newcpr()
{
	
	$("#txtidcpr").val("*New");
	$("#txtcprname").val("");
	$("#txtmsisdncpr").val("");
	$("#txtaddresscpr").val("");
	$("#txtoaddresscpr").val("");
	$("#txtoreceiptcpr").val(0);
	$("#certxtmsisdncpr").val("");
	$("#certxtaddresscpr").val("");
	$("#txtpasscpr").val("");
	$("#inputcrud").val("N");
	set_focus("#txtcprname");
}
$(document).on( "click",".btneditcpr", function() {
	var id_cpr = $(this).attr("id_cpr");
	var value = {
		id_cpr: id_cpr,
		method : "get_detail_cpr"
	};
	$.ajax(
	{
		url : "c_cpr.php",
		type: "POST",
		data : value,
		success: function(data, textStatus, jqXHR)
		{
			var hasil = jQuery.parseJSON(data);
			data = hasil.data;
			$("#inputcrud").val("E");
			$("#txtidcpr").val(data.id_cpr);
			$("#txtcprname").val(data.cpr_name);
			$("#txtmsisdncpr").val(data.msisdncpr);
			$("#txtaddresscpr").val(data.addresscpr);
			$("#certxtmsisdncpr").val(data.cermsisdncpr);
			$("#certxtaddresscpr").val(data.ceraddresscpr);
			$("#txtoaddresscpr").val(data.order_address);
			$("#txtpasscpr").val(data.passcpr);
			$("#txtoreceiptcpr").val(data.oreceipt);
			$("#modalmastercpr").modal('show');
			set_focus("#txtcprname");
		},
		error: function(jqXHR, textStatus, errorThrown)
		{
		}
	});
});
$(document).on( "click","#btnsavecpr", function() {
	var id_cpr = $("#txtidcpr").val();
	var cpr_name = $("#txtcprname").val();
	var msisdncpr = $("#txtmsisdncpr").val();
	var addresscpr = $("#txtaddresscpr").val();
	var cermsisdncpr = $("#certxtmsisdncpr").val();
	var ceraddresscpr = $("#certxtaddresscpr").val();
	var passcpr = $("#txtpasscpr").val();
	var order_address = $("#txtoaddresscpr").val();
	var oreceipt = $("#txtoreceiptcpr").val();
	var crud=$("#inputcrud").val();
	if(crud == 'E'){
		if(id_cpr == '' || id_cpr== null ){
			$.notify({
				message: "cpr Id invalid"
			},{
				type: 'warning',
				delay: 4000,
			});		
			$("#txtidcpr").focus();
			return;
		}	
	}
	if(cpr_name == '' || cpr_name== null ){
		$.notify({
			message: "Please fill out the Receipts Title"
		},{
			type: 'warning',
			delay: 4000,
		});		
		$("#txtcprname").focus();
		return;
	}
	if(msisdncpr == '' || msisdncpr== null ){
		$.notify({
			message: "Please fill out the CCB/Buyer MSISDN"
		},{
			type: 'warning',
			delay: 4000,
		});		
		$("#txtmsisdncpr").focus();
		return;
	}
	if(addresscpr == '' || addresscpr== null ){
		$.notify({
			message: "Please fill out the CCB/Buyer Address"
		},{
			type: 'warning',
			delay: 4000,
		});		
		$("#txtaddresscpr").focus();
		return;
	}

	if(order_address == '' || order_address== null ){
		$.notify({
			message: "Please fill out the CCB/Buyer Order Address"
		},{
			type: 'warning',
			delay: 4000,
		});		
		$("#txtoaddresscpr").focus();
		return;
	}

	if(oreceipt == '' || oreceipt== null ){
		$.notify({
			message: "Please fill out the order Receipt identification"
		},{
			type: 'warning',
			delay: 4000,
		});		
		$("#txtamountcpr").focus();
		return;
	}

	if(cermsisdncpr == '' || cermsisdncpr== null ){
		$.notify({
			message: "Please fill out the Certifier MSISDN"
		},{
			type: 'warning',
			delay: 4000,
		});		
		$("#certxtmsisdncpr").focus();
		return;
	}
	if(ceraddresscpr == '' || ceraddresscpr== null ){
		$.notify({
			message: "Please fill out the Certifier Address"
		},{
			type: 'warning',
			delay: 4000,
		});		
		$("#certxtaddresscpr").focus();
		return;
	}

	if(passcpr == '' || passcpr== null ){
		$.notify({
			message: "Please fill out the OffTaker Password"
		},{
			type: 'warning',
			delay: 4000,
		});		
		$("#txtpasscpr").focus();
		return;
	}
	

	

	var value = {
	id_cpr          :id_cpr,
	cpr_name        :cpr_name,
	msisdncpr      :msisdncpr,
	addresscpr     :addresscpr,
	cermsisdncpr   :cermsisdncpr,
	ceraddresscpr  :ceraddresscpr,
	passcpr        :passcpr,
	order_address  :order_address ,
	oreceipt       :oreceipt,
			crud:crud,
		method : "save_cpr"
	};
	$(this).prop('disabled', true);
	proccess_waiting("#infoprosescpr");
	$.ajax(
	{
		url : "c_cpr.php",
		type: "POST",
		data : value,
		success: function(data, textStatus, jqXHR)
		{
			$("#btnsavecpr").prop('disabled', false);
			$("#infoprosescpr").html("");
			var data = jQuery.parseJSON(data);
			if(data.ceksat == 0){
				$.notify(data.error);
			}else{
				if(data.crud == 'N'){
					if(data.result == 1){
						$.notify('Save cpr successfuly');
						var table = $('#table_cpr').DataTable(); 
						table.ajax.reload( null, false );
						newcpr();				
					}else{
						$.notify({
							message: "Error save cpr, error :"+data.error
						},{
							type: 'danger',
							delay: 4000,
						});
						set_focus("#txtidcpr");
					}
				}else if(data.crud == 'E'){
					if(data.result == 1){
						$.notify('Update cpr successfuly');
						var table = $('#table_cpr').DataTable(); 
						table.ajax.reload( null, false );
						$("#modalmastercpr").modal("hide");
					}else{
						$.notify({
							message: "Error update cpr, error :"+data.error
						},{
							type: 'danger',
							delay: 4000,
						});					
						set_focus("#txtidcpr");
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
			$("#btnsavecpr").prop('disabled', false);
		}
	});
});
$(document).on( "click",".btndeletecpr", function() {
	var id_cpr = $(this).attr("id_cpr");
	swal({   
		title: "Delete",   
		text: "Delete Produce cpr with id : "+id_cpr+" ?",   
		type: "warning",   
		showCancelButton: true,   
		confirmButtonColor: "#DD6B55",   
		confirmButtonText: "Delete",   
		closeOnConfirm: true }, 
		function(){   
			var value = {
				id_cpr: id_cpr,
				method : "delete_cpr"
			};
			$.ajax(
			{
				url : "c_cpr.php",
				type: "POST",
				data : value,
				success: function(data, textStatus, jqXHR)
				{
					var data = jQuery.parseJSON(data);
					if(data.result ==1){
						$.notify('Delete cpr successfuly');
						var table = $('#table_cpr').DataTable(); 
						table.ajax.reload( null, false );
					}else{
						$.notify({
							message: "Error delete cpr, error :"+data.error
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

