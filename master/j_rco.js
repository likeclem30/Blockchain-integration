


$(document).ready( function () 
{
	$(document).on('change','#txtmsisdnrco', function() {
		var wphone1_id2 = $(this).val();
		if(wphone1_id2 != "") {
			$.ajax({
				url:"c_rco.php",
				type:'POST',
				data:{wphone1_id2:wphone1_id2},
				success:function(response) {
					//var resp = $.trim(response);
					if(response != '') {
						$("#txtaddressrco").removeAttr('disabled','disabled').html(response);
						
					} else {
						$("#txtaddressrco").attr('disabled','disabled').html("<option value=''>----- Select ---</option>");
					}
				}
			});
		} else {
			$("#txtaddressrco").attr('disabled','disabled').html("<option value=''>----- Select ------</option>");
		}
	});
	
	
	money();
	decimal();
	var value = {
		method : "getdata"
	};
	$('#table_rco').DataTable({
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
			"url": "c_rco.php",
			"type": "POST",
			"data":value,
		},
		"columns": [
		{ "data": "urutan" },
		
		{ "data": "rco_name" },
		{ "data": "commission" },
		{ "data": "redemption" },
        { "data": "fixedredemption" },
		{ "data": "msisdnrco" },
        { "data": "outaddress" },
        { "data": "outcom" },
        { "data": "outred" },
		{ "data": "button" },
		]
	});
	$("#table_rco_filter").addClass("pull-right");
	
});

$(document).on( "click","#btnaddrco", function() {
	$(".contentharga").remove();
	$("#modalmasterrco").modal('show');
	newrco();
});
function newrco()
{
	$("#txtidrco").val("*New");
	$("#txtrconame").val("");
	$("#txtctyrco").val("");
	$("#txtcomrco").val(0);
	$("#txtredrco").val(0);
	$("#txtfredrco").val(0);
    $("#txtaddressrco").val("");
	$("#txtmsisdnrco").val("");
	$("#inputcrud").val("N");
	set_focus("#txtrconame");

	
}
$(document).on( "click",".btneditrco", function() {
	var id_rco = $(this).attr("id_rco");
	var value = {
		id_rco: id_rco,
		method : "get_detail_rco"
	};
	$.ajax(
	{
		url : "c_rco.php",
		type: "POST",
		data : value,
		success: function(data, textStatus, jqXHR)
		{
			var hasil = jQuery.parseJSON(data);
			data = hasil.data;
			$("#inputcrud").val("E");
			$("#txtidrco").val(data.id_rco);
			$("#txtrconame").val(data.rco_name);
			$("#txtctyrco").val(data.currency_type);
			$("#txtcomrco").val(data.commission);
			$("#txtredrco").val(data.redemption);
			$("#txtfredrco").val(data.fixedredemption);
			$("#txtmsisdnrco").val(data.msisdnrco);
            $("#txtaddressrco").val(data.addressrco);
            
			$("#modalmasterrco").modal('show');
			set_focus("#txtrconame");
		},
		error: function(jqXHR, textStatus, errorThrown)
		{
		}
	});
});
$(document).on( "click","#btnsaverco", function() {
	var id_rco = $("#txtidrco").val();
	var rco_name = $("#txtrconame").val();
	var currency_type = $("#txtctyrco").val();
	var commission = $("#txtcomrco").val();
	var redemption = $("#txtredrco").val();
	var fixedredemption = $("#txtfredrco").val();
	var msisdnrco = $("#txtmsisdnrco").val();
    var addressrco = $("#txtaddressrco").val();
    
	var crud=$("#inputcrud").val();
	if(crud == 'E'){
		if(id_rco == '' || id_rco== null ){
			$.notify({
				message: "Commission Id invalid"
			},{
				type: 'warning',
				delay: 4000,
			});		
			$("#txtidrco").focus();
			return;
		}	
	}
	if(rco_name == '' || rco_name== null ){
		$.notify({
			message: "Please fill out the Tran Title name"
		},{
			type: 'warning',
			delay: 4000,
		});		
		$("#txtrconame").focus();
		return;
	}
	if(currency_type == '' || currency_type== null ){
		$.notify({
			message: "Please fill out the Currency Type"
		},{
			type: 'warning',
			delay: 4000,
		});		
		$("#txtctyrco").focus();
		return;
	}

	if(commission == '' || commission == null ){
		$.notify({
			message: "Please fill out the Commission Percentage"
		},{
			type: 'warning',
			delay: 4000,
		});		
		$("#txtcomrco").focus();
		return;
	}

	if(redemption == '' || redemption == null ){
		$.notify({
			message: "Please fill out Redemption Commission Percentage"+redemption
		},{
			type: 'warning',
			delay: 4000,
		});		
		$("#txtredrco").focus();
		return;
	}

	if(fixedredemption == '' || fixedredemption == null ){
		$.notify({
			message: "Please fill out fixed value of the redemption commission"+fixedredemption
		},{
			type: 'warning',
			delay: 4000,
		});		
		$("#txtfredrco").focus();
		return;
	}

	
	if(msisdnrco == '' || msisdnrco== null ){
		$.notify({
			message: "Please fill wallet number "
		},{
			type: 'warning',
			delay: 4000,
		});		
		$("#txtmsisdnrco").focus();
		return;
	}

   if(addressrco == '' || addressrco== null ){
		$.notify({
			message: "Please fill out block address "
		},{
			type: 'warning',
			delay: 4000,
		});		
		$("#txtaddressrco").focus();
		return;
	}

	
    

	var value = {
		       id_rco: id_rco,
			 rco_name: rco_name,
			 currency_type: currency_type, 
		commission:commission,	 
		redemption:redemption,
		fixedredemption:fixedredemption,
        addressrco:addressrco,
		msisdnrco:msisdnrco,
		
		crud:crud,
		method : "save_rco"
	};
	$(this).prop('disabled', true);
	proccess_waiting("#infoprosesrco");
	$.ajax(
	{
		url : "c_rco.php",
		type: "POST",
		data : value,
		success: function(data, textStatus, jqXHR)
		{
			$("#btnsaverco").prop('disabled', false);
			$("#infoprosesrco").html("");
			var data = jQuery.parseJSON(data);
			if(data.ceksat == 0){
				$.notify(data.error);
			}else{
				if(data.crud == 'N'){
					if(data.result == 1){
						$.notify('Save Commission successfuly');
						var table = $('#table_rco').DataTable(); 
						table.ajax.reload( null, false );
						newrco();				
					}else{
						$.notify({
							message: "Error save Commission, error :"+data.error
						},{
							type: 'danger',
							delay: 4000,
						});
						set_focus("#txtidrco");
					}
				}else if(data.crud == 'E'){
					if(data.result == 1){
						$.notify('Update Commission successfuly');
						var table = $('#table_rco').DataTable(); 
						table.ajax.reload( null, false );
						$("#modalmasterrco").modal("hide");
					}else{
						$.notify({
							message: "Error update Commission, error :"+data.error
						},{
							type: 'danger',
							delay: 4000,
						});					
						set_focus("#txtidrco");
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
			$("#btnsaverco").prop('disabled', false);
		}
	});
});
$(document).on( "click",".btndeleterco", function() {
	var id_rco = $(this).attr("id_rco");
	swal({   
		title: "Delete",   
		text: "Delete funding with id : "+id_rco+" ?",   
		type: "warning",   
		showCancelButton: true,   
		confirmButtonColor: "#DD6B55",   
		confirmButtonText: "Delete",   
		closeOnConfirm: true }, 
		function(){   
			var value = {
				id_rco: id_rco,
				method : "delete_rco"
			};
			$.ajax(
			{
				url : "c_rco.php",
				type: "POST",
				data : value,
				success: function(data, textStatus, jqXHR)
				{
					var data = jQuery.parseJSON(data);
					if(data.result ==1){
						$.notify('Delete Commission successfuly');
						var table = $('#table_rco').DataTable(); 
						table.ajax.reload( null, false );
					}else{
						$.notify({
							message: "Error delete Commission, error :"+data.error
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

