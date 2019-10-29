$(document).ready( function () 
{
	
	$(document).on('change','#txtmsisdnfar', function() {
		var wphonefar_id = $(this).val();
		if(wphonefar_id != "") {
			$.ajax({
				url:"c_far.php",
				type:'POST',
				data:{wphonefar_id:wphonefar_id},
				success:function(response) {
					//var resp = $.trim(response);
					if(response != '') {
						$("#txtaddressfar").removeAttr('disabled','disabled').html(response);
						
					} else {
						$("#txtaddressfar").attr('disabled','disabled').html("<option value=''>----- Select ---</option>");
					}
				}
			});
		} else {
			$("#txtaddressfar").attr('disabled','disabled').html("<option value=''>----- Select ------</option>");
		}
	});

	money();
	decimal();
	var value = {
		method : "getdata"
	};

	var t_type = $("#divid").val();

	$('#table_far').DataTable({
		"paging": true,
		"lengthChange": false,
		"oSearch": {'sSearch': t_type},
		"searching": true,
		"ordering": true,
		"info": false,
		"responsive": true,
		"autoWidth": false,
		"pageLength": 3,
		"dom": '<"top"f>rtip',
		"ajax": {
			"url": "c_far.php",
			"type": "POST",
			"data":value,
		},
		"columns": [
		{ "data": "urutan" },
		{ "data": "id_far" },
		{ "data": "transaction_type" },
		{ "data": "far_name" },
		{ "data": "loc_name" },
		
		{ "data": "msisdnfar" },
		{ "data": "tran_status" },
		{ "data": "button" },
		]
	});
	$("#table_far_filter").addClass("pull-right");
	
});

$(document).on( "click","#btnaddfar", function() {
	$(".contentharga").remove();
	$("#modalmasterfar").modal('show');
	newfar();
});
function newfar()
{
	$("#txtidfar").val("*New");
	$("#txtfarname").val("");
	$("#txtlocnamefar").val("");
	$("#txtaddressfar").val("");
	$("#txtmsisdnfar").val("");
	$("#txttctyfar").val("");
	$("#inputcrud").val("N");
	set_focus("#txtfarname");
}
$(document).on( "click",".btneditfar", function() {
	var id_far = $(this).attr("id_far");
	var value = {
		id_far: id_far,
		method : "get_detail_far"
	};
	$.ajax(
	{
		url : "c_far.php",
		type: "POST",
		data : value,
		success: function(data, textStatus, jqXHR)
		{
			var hasil = jQuery.parseJSON(data);
			data = hasil.data;
			$("#inputcrud").val("E");
			$("#txtidfar").val(data.id_far);
			$("#txtfarname").val($.trim(data.far_name));
			$("#txtlocnamefar").val($.trim(data.loc_name));
			$("#txtaddressfar").val($.trim(data.addressfar));
			$("#txtmsisdnfar").val(data.msisdnfar);
			$("#txttctyfar").val(data.transaction_type);
			$("#modalmasterfar").modal('show');
			set_focus("#txtfarname");
		},
		error: function(jqXHR, textStatus, errorThrown)
		{
		}
	});
});
$(document).on( "click","#btnsavefar", function() {
	var id_far = $("#txtidfar").val();
	var far_name = $("#txtfarname").val();
	var loc_name = $("#txtlocnamefar").val();
	var addressfar = $("#txtaddressfar").val();
	var msisdnfar = $("#txtmsisdnfar").val();
	var transaction_type = $("#txttctyfar").val();
	var crud=$("#inputcrud").val();
	if(crud == 'E'){
		if(id_far == '' || id_far== null ){
			$.notify({
				message: "far Id invalid"
			},{
				type: 'warning',
				delay: 4000,
			});		
			$("#txtidfar").focus();
			return;
		}	
	}
	if(far_name == '' || far_name== null ){
		$.notify({
			message: "Please fill out the farmer/buyer/dealer/loaner/grantor name"
		},{
			type: 'warning',
			delay: 4000,
		});		
		$("#txtfarname").focus();
		return;
	}

	if(transaction_type == '' || transaction_type == null ){
		$.notify({
			message: "Please fill out the transaction type"
		},{
			type: 'warning',
			delay: 4000,
		});		
		$("#txttctyfar").focus();
		return;
	}

	if((loc_name == '' || loc_name== null )&&(transaction_type != 'addgenericroletype')){
		$.notify({
			message: "Please fill out the location name"
		},{
			type: 'warning',
			delay: 4000,
		});		
		$("#txtlocnamefar").focus();
		return;
	}


	if((addressfar == '' || addressfar== null )&&(transaction_type != 'addgenericroletype')){
		$.notify({
			message: "Please fill out Address "
		},{
			type: 'warning',
			delay: 4000,
		});		
		$("#txtaddressfar").focus();
		return;
	}

	if((msisdnfar == '' || msisdnfar== 0 )&&(transaction_type != 'addgenericroletype')){
		$.notify({
			message: "Please fill out Msisdn"
		},{
			type: 'warning',
			delay: 4000,
		});		
		$("#txtmsisdnfar").focus();
		return;
	}

	

	var value = {
		id_far:       id_far,
		far_name:     far_name,
		loc_name:     loc_name,	
		addressfar:   addressfar,
		msisdnfar:    msisdnfar,
		transaction_type: transaction_type,
		crud:crud,
		method : "save_far"
	};
	$(this).prop('disabled', true);
	proccess_waiting("#infoprosesfar");
	$.ajax(
	{
		url : "c_far.php",
		type: "POST",
		data : value,
		success: function(data, textStatus, jqXHR)
		{
			$("#btnsavefar").prop('disabled', false);
			$("#infoprosesfar").html("");
			var data = jQuery.parseJSON(data);
			if(data.ceksat == 0){
				$.notify(data.error);
			}else{
				if(data.crud == 'N'){
					if(data.result == 1){
						$.notify('Save farmer successfuly');
						var table = $('#table_far').DataTable(); 
						table.ajax.reload( null, false );
						newfar();				
					}else{
						$.notify({
							message: "Error save farmer, error :"+data.error
						},{
							type: 'danger',
							delay: 4000,
						});
						set_focus("#txtidfar");
					}
				}else if(data.crud == 'E'){
					if(data.result == 1){
						$.notify('Update farmer successfuly');
						var table = $('#table_far').DataTable(); 
						table.ajax.reload( null, false );
						$("#modalmasterfar").modal("hide");
					}else{
						$.notify({
							message: "Error update record, error :"+data.error
						},{
							type: 'danger',
							delay: 4000,
						});					
						set_focus("#txtidfar");
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
			$("#btnsavefar").prop('disabled', false);
		}
	});
});
$(document).on( "click",".btndeletefar", function() {
	var id_far = $(this).attr("id_far");
	swal({   
		title: "Delete",   
		text: "Delete Produce farmer with id : "+id_far+" ?",   
		type: "warning",   
		showCancelButton: true,   
		confirmButtonColor: "#DD6B55",   
		confirmButtonText: "Delete",   
		closeOnConfirm: true }, 
		function(){   
			var value = {
				id_far: id_far,
				method : "delete_far"
			};
			$.ajax(
			{
				url : "c_far.php",
				type: "POST",
				data : value,
				success: function(data, textStatus, jqXHR)
				{
					var data = jQuery.parseJSON(data);
					if(data.result ==1){
						$.notify('Delete farmer successfuly');
						var table = $('#table_far').DataTable(); 
						table.ajax.reload( null, false );
					}else{
						$.notify({
							message: "Error delete record, error :"+data.error
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

