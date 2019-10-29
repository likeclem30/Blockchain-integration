$(document).ready( function () 
{

	$(document).on('change','#txtmsisdncer', function() {
		var wphonecer_id = $(this).val();
		if(wphonecer_id != "") {
			$.ajax({
				url:"c_cer.php",
				type:'POST',
				data:{wphonecer_id:wphonecer_id},
				success:function(response) {
					//var resp = $.trim(response);
					if(response != '') {
						$("#txtaddresscer").removeAttr('disabled','disabled').html(response);
						
					} else {
						$("#txtaddresscer").attr('disabled','disabled').html("<option value=''>----- Select ---</option>");
					}
				}
			});
		} else {
			$("#txtaddresscer").attr('disabled','disabled').html("<option value=''>----- Select ------</option>");
		}
	});


	money();
	decimal();
	var value = {
		method : "getdata"
	};
	$('#table_cer').DataTable({
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
			"url": "c_cer.php",
			"type": "POST",
			"data":value,
		},
		"columns": [
		{ "data": "urutan" },
		{ "data": "id_cer" },
		{ "data": "cer_name" },
		{ "data": "loc_name" },
		{ "data": "commodity" },
		{ "data": "tran_status" },
		{ "data": "button" },
		]
	});
	$("#table_cer_filter").addClass("pull-right");
	
});

$(document).on( "click","#btnaddcer", function() {
	$(".contentharga").remove();
	$("#modalmastercer").modal('show');
	newcer();
});
function newcer()
{
	$("#txtidcer").val("*New");
	$("#txtcername").val("");
	$("#txtlocnamec").val(""); 
	$("#txtcommodityc").val("");
	$("#txtpratecer").val(0);
	$("#txtfratecer").val(0);
	$("#txtmsisdncer").val("");
	$("#txtaddresscer").val("");
	$("#inputcrud").val("N");
	set_focus("#txtcername");
}
$(document).on( "click",".btneditcer", function() {
	var id_cer = $(this).attr("id_cer");
	var value = {
		id_cer: id_cer,
		method : "get_detail_cer"
	};
	$.ajax(
	{
		url : "c_cer.php",
		type: "POST",
		data : value,
		success: function(data, textStatus, jqXHR)
		{
			var hasil = jQuery.parseJSON(data);
			data = hasil.data;
			$("#inputcrud").val("E");
			$("#txtidcer").val(data.id_cer);
			$("#txtcername").val(data.cer_name);
			$("#txtlocnamec").val(data.loc_name);
			$("#txtcommodityc").val(data.commodity);
			$("#txtpratecer").val(data.prate);
			$("#txtfratecer").val(data.frate);
			$("#txtmsisdncer").val(data.msisdncer);
			$("#txtaddresscer").val(data.addresscer);
			$("#modalmastercer").modal('show');
			set_focus("#txtcername");
		},
		error: function(jqXHR, textStatus, errorThrown)
		{
		}
	});
});
$(document).on( "click","#btnsavecer", function() {
	var id_cer = $("#txtidcer").val();
	var cer_name = $("#txtcername").val();
	var loc_name = $("#txtlocnamec").val();
	var commodity = $("#txtcommodityc").val();
	var prate = $("#txtpratecer").val();
	var frate = $("#txtfratecer").val();
	var msisdncer = $("#txtmsisdncer").val();
	var addresscer = $("#txtaddresscer").val();
	var crud=$("#inputcrud").val();
	if(crud == 'E'){
		if(id_cer == '' || id_cer== null ){
			$.notify({
				message: "certifier Id invalid"
			},{
				type: 'warning',
				delay: 4000,
			});		
			$("#txtidcer").focus();
			return;
		}	
	}
	if(cer_name == '' || cer_name== null ){
		$.notify({
			message: "Please fill out the cerfier name"
		},{
			type: 'warning',
			delay: 4000,
		});		
		$("#txtcername").focus();
		return;
	}

	if(loc_name == '' || loc_name== null ){
		$.notify({
			message: "Please fill out location name"
		},{
			type: 'warning',
			delay: 4000,
		});		
		$("#txtlocnamec").focus();
		return;
	}

	if(commodity == '' || commodity== null ){
		$.notify({
			message: "Please fill out commodity code "
		},{
			type: 'warning',
			delay: 4000,
		});		
		$("#txtcommodityc").focus();
		return;
	}
	if(prate == '' || prate== null ){
		$.notify({
			message: "Please fill out the Percentage rate "
		},{
			type: 'warning',
			delay: 4000,
		});		
		$("#txtpratecer").focus();
		return;
	}
	if(frate == '' || frate== null ){
		$.notify({
			message: "Please fill out the Fixed Commission Rate "
		},{
			type: 'warning',
			delay: 4000,
		});		
		$("#txtfratecer").focus();
		return;
	}


	if(msisdncer == '' || msisdncer== null ){
		$.notify({
			message: "Please fill out certifier Wallet no "
		},{
			type: 'warning',
			delay: 4000,
		});		
		$("#txtmsisdncer").focus();
		return;
	}

	if(addresscer == '' || addresscer== null ){
		$.notify({
			message: "Please fill out certifier Block Address "
		},{
			type: 'warning',
			delay: 4000,
		});		
		$("#txtaddresscer").focus();
		return;
	}

	

	var value = {
		id_cer: id_cer,
		cer_name: cer_name,
		loc_name:loc_name,
		commodity:commodity,
		prate:prate,
		frate:frate,
		addresscer:addresscer,
		msisdncer:msisdncer,

		crud:crud,
		method : "save_cer"
	};
	$(this).prop('disabled', true);
	proccess_waiting("#infoprosescer");
	$.ajax(
	{
		url : "c_cer.php",
		type: "POST",
		data : value,
		success: function(data, textStatus, jqXHR)
		{
			$("#btnsavecer").prop('disabled', false);
			$("#infoprosescer").html("");
			var data = jQuery.parseJSON(data);
			if(data.ceksat == 0){
				$.notify(data.error);
			}else{
				if(data.crud == 'N'){
					if(data.result == 1){
						$.notify('Save certifier successfuly');
						var table = $('#table_cer').DataTable(); 
						table.ajax.reload( null, false );
						newcer();				
					}else{
						$.notify({
							message: "Error save certifier, error :"+data.error
						},{
							type: 'danger',
							delay: 4000,
						});
						set_focus("#txtidcer");
					}
				}else if(data.crud == 'E'){
					if(data.result == 1){
						$.notify('Update certifier successfuly');
						var table = $('#table_cer').DataTable(); 
						table.ajax.reload( null, false );
						$("#modalmastercer").modal("hide");
					}else{
						$.notify({
							message: "Error update certifier, error :"+data.error
						},{
							type: 'danger',
							delay: 4000,
						});					
						set_focus("#txtidcer");
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
			$("#btnsavecer").prop('disabled', false);
		}
	});
});
$(document).on( "click",".btndeletecer", function() {
	var id_cer = $(this).attr("id_cer");
	swal({   
		title: "Delete",   
		text: "Delete Produce certifier with id : "+id_cer+" ?",   
		type: "warning",   
		showCancelButton: true,   
		confirmButtonColor: "#DD6B55",   
		confirmButtonText: "Delete",   
		closeOnConfirm: true }, 
		function(){   
			var value = {
				id_cer: id_cer,
				method : "delete_cer"
			};
			$.ajax(
			{
				url : "c_cer.php",
				type: "POST",
				data : value,
				success: function(data, textStatus, jqXHR)
				{
					var data = jQuery.parseJSON(data);
					if(data.result ==1){
						$.notify('Delete certifier successfuly');
						var table = $('#table_cer').DataTable(); 
						table.ajax.reload( null, false );
					}else{
						$.notify({
							message: "Error delete certifier, error :"+data.error
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

