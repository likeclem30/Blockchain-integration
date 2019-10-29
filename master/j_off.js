$(document).ready( function () 
{

	$(document).on('change','#txtmsisdnoff', function() {
		var wphoneoff_id = $(this).val();
		if(wphoneoff_id != "") {
			$.ajax({
				url:"c_off.php",
				type:'POST',
				data:{wphoneoff_id:wphoneoff_id},
				success:function(response) {
					//var resp = $.trim(response);
					if(response != '') {
						$("#txtaddressoff").removeAttr('disabled','disabled').html(response);
						
					} else {
						$("#txtaddressoff").attr('disabled','disabled').html("<option value=''>----- Select ---</option>");
					}
				}
			});
		} else {
			$("#txtaddressoff").attr('disabled','disabled').html("<option value=''>----- Select ------</option>");
		}
	});






	money();
	decimal();
	var value = {
		method : "getdata"
	};
	var t_type = $("#divid").val();

	$('#table_off').DataTable({
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
			"url": "c_off.php",
			"type": "POST",
			"data":value,
		},
		"columns": [
		{ "data": "urutan" },
		{ "data": "id_off" },
		{ "data": "off_name" },
		{ "data": "msisdnoff" },
		{ "data": "receipt_limit" },
		{ "data": "frate" },
		{ "data": "prate" },
		{ "data": "tran_type" },
		{ "data": "tran_status" },
		{ "data": "button" },
		]
	});
	$("#table_off_filter").addClass("pull-right");
	
});

$(document).on( "click","#btnaddoff", function() {
	$(".contentharga").remove();
	$("#modalmasteroff").modal('show');
	newoff();
});
function newoff()
{
	$("#txtidoff").val("*New");
	$("#txtoffname").val(""); 
	$("#txtlocnameoff").val("");
	$("#txttctyoff").val("");
	$("#txtgenrtoff").val("");
	$("#txtlimitoff").val(0);
	$("#txtfrateoff").val(0);
	$("#txtprateoff").val(0);
	$("#txtaddressoff").val("");
	$("#txtmsisdnoff").val("");
	$("#inputcrud").val("N");
	set_focus("#txtoffname");
}
$(document).on( "click",".btneditoff", function() {
	var id_off = $(this).attr("id_off");
	var value = {
		id_off: id_off,
		method : "get_detail_off"
	};
	$.ajax(
	{
		url : "c_off.php",
		type: "POST",
		data : value,
		success: function(data, textStatus, jqXHR)
		{
			var hasil = jQuery.parseJSON(data);
			data = hasil.data;
			$("#inputcrud").val("E");
			$("#txtidoff").val(data.id_off);
			$("#txtoffname").val(data.off_name);
			$("#txttctyoff").val(data.transaction_type);
			$("#txtgenrtoff").val(data.generic_role_type);
			$("#txtlocnameoff").val($.trim(data.loc_name));
			$("#txtlimitoff").val(addCommas(data.receipt_limit));
			$("#txtfrateoff").val(addCommas(data.frate));
			$("#txtprateoff").val(addCommas(data.prate));

			$("#txtaddressoff").val(data.addressoff);
			$("#txtmsisdnoff").val(data.msisdnoff);
			$("#modalmasteroff").modal('show');
			set_focus("#txtoffname");
		},
		error: function(jqXHR, textStatus, errorThrown)
		{
		}
	});
});
$(document).on( "click","#btnsaveoff", function() {
	var id_off = $("#txtidoff").val();
	var off_name = $("#txtoffname").val();
	var transaction_type = $("#txttctyoff").val();
	var generic_role_type = $("#txtgenrtoff").val();
	var loc_name = $("#txtlocnameoff").val();
	var receipt_limit = cleanString($("#txtlimitoff").val()); 
	var frate = cleanString($("#txtfrateoff").val()); 
	var prate = cleanString($("#txtprateoff").val()); 
	var addressoff = $("#txtaddressoff").val();
	var msisdnoff = $("#txtmsisdnoff").val();
	var crud=$("#inputcrud").val();
	if(crud == 'E'){
		if(id_off == '' || id_off== null ){
			$.notify({
				message: "off Id invalid"
			},{
				type: 'warning',
				delay: 4000,
			});		
			$("#txtidoff").focus();
			return;
		}	
	}
	if(off_name == '' || off_name== null ){
		$.notify({
			message: "Please fill out the OffTaker name"
		},{
			type: 'warning',
			delay: 4000,
		});		
		$("#txtoffname").focus();
		return;
	}

	if(transaction_type == '' || transaction_type== null ){
		$.notify({
			message: "Please fill out the Transaction Type"
		},{
			type: 'warning',
			delay: 4000,
		});		
		$("#txttctyoff").focus();
		return;
	}

	if((generic_role_type == '' || generic_role_type== null )&&(transaction_type == 'addgenericrole')){
		$.notify({
			message: "Please fill out the Generic Role Type name"
		},{
			type: 'warning',
			delay: 4000,
		});		
		$("#txtgenrtoff").focus();
		return;
	}

	if((loc_name == '' || loc_name== null )&&(transaction_type != 'addgenericrole')){
		$.notify({
			message: "Please fill out the location name"
		},{
			type: 'warning',
			delay: 4000,
		});		
		$("#txtlocnameoff").focus();
		return;
	}

	if((receipt_limit == '' || receipt_limit== null )&&(transaction_type != 'addgenericrole')){
		$.notify({
			message: "Please fill out Receipt Limit"
		},{
			type: 'warning',
			delay: 4000,
		});		
		$("#txtlimitoff").focus();
		return;
	}
	if((frate == '' || frate== null )&&(transaction_type != 'addgenericrole')){
		$.notify({
			message: "Please fill out Fixed Rate Commission"
		},{
			type: 'warning',
			delay: 4000,
		});		
		$("#txtfrateoff").focus();
		return;
	}
	if((prate == '' || prate== null || prate >= 100)&&(transaction_type != 'addgenericrole')){
		$.notify({
			message: "Please fill out Percentage Rate Commission"
		},{
			type: 'warning',
			delay: 4000,
		});		
		$("#txtprateoff").focus();
		return;
	}

	if((addressoff == '' || addressoff== null )&&(transaction_type != 'addgenericrole')){
		$.notify({
			message: "Please fill out Address "
		},{
			type: 'warning',
			delay: 4000,
		});		
		$("#txtaddressoff").focus();
		return;
	}

	if((msisdnoff == '' || msisdnoff== null )&&(transaction_type != 'addgenericrole')){
		$.notify({
			message: "Please fill out Msisdn"
		},{
			type: 'warning',
			delay: 4000,
		});		
		$("#txtmsisdnoff").focus();
		return;
	}

	

	var value = {
		id_off:       id_off,
		off_name:     off_name,
		loc_name:     loc_name,
		transaction_type:transaction_type,
		generic_role_type:generic_role_type,
		receipt_limit:receipt_limit,
		frate:frate,
		prate:prate,
		addressoff:   addressoff,
		msisdnoff:    msisdnoff,
		crud:crud,
		method : "save_off"
	};
	$(this).prop('disabled', true);
	proccess_waiting("#infoprosesoff");
	$.ajax(
	{
		url : "c_off.php",
		type: "POST",
		data : value,
		success: function(data, textStatus, jqXHR)
		{
			$("#btnsaveoff").prop('disabled', false);
			$("#infoprosesoff").html("");
			var data = jQuery.parseJSON(data);
			if(data.ceksat == 0){
				$.notify(data.error);
			}else{
				if(data.crud == 'N'){
					if(data.result == 1){
						$.notify('Save OffTaker successfuly');
						var table = $('#table_off').DataTable(); 
						table.ajax.reload( null, false );
						newoff();				
					}else{
						$.notify({
							message: "Error save offtaker, error :"+data.error
						},{
							type: 'danger',
							delay: 4000,
						});
						set_focus("#txtidoff");
					}
				}else if(data.crud == 'E'){
					if(data.result == 1){
						$.notify('Update offtaker successfuly');
						var table = $('#table_off').DataTable(); 
						table.ajax.reload( null, false );
						$("#modalmasteroff").modal("hide");
					}else{
						$.notify({
							message: "Error update offtaker, error :"+data.error
						},{
							type: 'danger',
							delay: 4000,
						});					
						set_focus("#txtidoff");
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
			$("#btnsaveoff").prop('disabled', false);
		}
	});
});
$(document).on( "click",".btndeleteoff", function() {
	var id_off = $(this).attr("id_off");
	swal({   
		title: "Delete",   
		text: "Delete Produce Offtaker with id : "+id_off+" ?",   
		type: "warning",   
		showCancelButton: true,   
		confirmButtonColor: "#DD6B55",   
		confirmButtonText: "Delete",   
		closeOnConfirm: true }, 
		function(){   
			var value = {
				id_off: id_off,
				method : "delete_off"
			};
			$.ajax(
			{
				url : "c_off.php",
				type: "POST",
				data : value,
				success: function(data, textStatus, jqXHR)
				{
					var data = jQuery.parseJSON(data);
					if(data.result ==1){
						$.notify('Delete Offtaker successfuly');
						var table = $('#table_off').DataTable(); 
						table.ajax.reload( null, false );
					}else{
						$.notify({
							message: "Error delete Offtaker, error :"+data.error
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

