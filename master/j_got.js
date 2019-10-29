$(document).ready( function () 
{
	
	$(document).on('change','#txtmsisdngot', function() {
		var wphonegot_id = $(this).val();
		if(wphonegot_id != "") {
			$.ajax({
				url:"c_got.php",
				type:'POST',
				data:{wphonegot_id:wphonegot_id},
				success:function(response) {
					//var resp = $.trim(response);
					if(response != '') {
						$("#txtaddressgot").removeAttr('disabled','disabled').html(response);
						
					} else {
						$("#txtaddressgot").attr('disabled','disabled').html("<option value=''>----- Select ---</option>");
					}
				}
			});
		} else {
			$("#txtaddressgot").attr('disabled','disabled').html("<option value=''>----- Select ------</option>");
		}
    });
    
    $(document).on('change','#txtaddressgot', function() {
		var b_addressgot = $(this).val();
		if(b_addressgot != "") {
			$.ajax({
				url:"c_got.php",
				type:'POST',
				data:{b_addressgot:b_addressgot},
				success:function(response) {
					//var resp = $.trim(response);
					if(response != '') {
						$("#txtoaddressgot").removeAttr('disabled','disabled').html(response);
						
					} else {
						$("#txtoaddressgot").attr('disabled','disabled').html("<option value=''>----- Select ---</option>");
					}
				}
			});
		} else {
			$("#txtoaddressgot").attr('disabled','disabled').html("<option value=''>----- Select ------</option>");
		}
	});






    $(document).on('change','#offtxtmsisdngot', function() {
		var offwphonegot_id = $(this).val();
		if(offwphonegot_id != "") {
			$.ajax({
				url:"c_got.php",
				type:'POST',
				data:{offwphonegot_id:offwphonegot_id},
				success:function(response) {
					//var resp = $.trim(response);
					if(response != '') {
						$("#offtxtaddressgot").removeAttr('disabled','disabled').html(response);
						
					} else {
						$("#offtxtaddressgot").attr('disabled','disabled').html("<option value=''>----- Select ---</option>");
					}
				}
			});
		} else {
			$("#offtxtaddressgot").attr('disabled','disabled').html("<option value=''>----- Select ------</option>");
		}
    });








	money();
	decimal();
	var value = {
		method : "getdata"
	};
	
	var t_type = $("#divid").val();

	$('#table_got').DataTable({
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
			"url": "c_got.php",
			"type": "POST",
			"data":value,
		},
		"columns": [
		{ "data": "urutan" },
		{ "data": "id_got" },
		{ "data": "transaction_type" },
		{ "data": "got_name" },
		{ "data": "offmsisdngot" },
		{ "data": "msisdngot" },
		{ "data": "tran_status" },
		{ "data": "button" },
		]
	});
	$("#table_got_filter").addClass("pull-right");
	
});

$(document).on( "click","#btnaddgot", function() {
	$(".contentharga").remove();
	$("#modalmastergot").modal('show');
	newgot();
});
function newgot()
{
	$("#txtidgot").val("*New");
	$("#txtgotname").val("");
	$("#txtaddressgot").val("");
    $("#txtmsisdngot").val("");
    $("#txtoaddressgot").val("");
    $("#txtoamount").val("");
    $("#txtpassgot").val("");
    $("#offtxtaddressgot").val("");
    $("#offtxtmsisdngot").val("");
	$("#txttctygot").val("");
	$("#inputcrud").val("N");
	set_focus("#txtgotname");
}
$(document).on( "click",".btneditgot", function() {
	var id_got = $(this).attr("id_got");
	var value = {
		id_got: id_got,
		method : "get_detail_got"
	};
	$.ajax(
	{
		url : "c_got.php",
		type: "POST",
		data : value,
		success: function(data, textStatus, jqXHR)
		{
			var hasil = jQuery.parseJSON(data);
			data = hasil.data;
			$("#inputcrud").val("E");
			$("#txtidgot").val(data.id_got);
			$("#txtgotname").val(data.got_name);
			
			$("#txtaddressgot").val(data.addressgot);
            $("#txtmsisdngot").val(data.msisdngot);
            $("#txtoaddressgot").val(data.order_address);

            $("#txtpassgot").val(data.passgot);
            $("#txtoamount").val(addCommas(data.amount));
            
            $("#offtxtaddressgot").val(data.offaddressgot);
			$("#offtxtmsisdngot").val(data.offmsisdngot);
			$("#txttctygot").val(data.transaction_type);
			$("#modalmastergot").modal('show');
			set_focus("#txtgotname");
		},
		error: function(jqXHR, textStatus, errorThrown)
		{
		}
	});
});
$(document).on( "click","#btnsavegot", function() {
	var id_got = $("#txtidgot").val();
	var got_name = $("#txtgotname").val();
	var transaction_type = $("#txttctygot").val();
	var passgot = $("#txtpassgot").val();
	var addressgot = $("#txtaddressgot").val();
    var msisdngot = $("#txtmsisdngot").val();
    var order_address = $("#txtoaddressgot").val();
    var amount = cleanString($("#txtoamount").val()); 
    var offaddressgot = $("#offtxtaddressgot").val();
	var offmsisdngot = $("#offtxtmsisdngot").val();
	
	var crud=$("#inputcrud").val();
	if(crud == 'E'){
		if(id_got == '' || id_got== null ){
			$.notify({
				message: "got Id invalid"
			},{
				type: 'warning',
				delay: 4000,
			});		
			$("#txtidgot").focus();
			return;
		}	
	}
	if(got_name == '' || got_name== null ){
		$.notify({
			message: "Please fill out the transaction Title"
		},{
			type: 'warning',
			delay: 4000,
		});		
		$("#txtgotname").focus();
		return;
	}

	if(transaction_type == '' || transaction_type == null ){
		$.notify({
			message: "Please fill out the transaction type"
		},{
			type: 'warning',
			delay: 4000,
		});		
		$("#txttctygot").focus();
		return;
	}

	if(msisdngot == '' || msisdngot== null ){
		$.notify({
			message: "Please fill out the CCB Wallet No"
		},{
			type: 'warning',
			delay: 4000,
		});		
		$("#txtmsisdngot").focus();
		return;
	}


	if(addressgot == '' || addressgot== null ){
		$.notify({
			message: "Please fill out the CCB Wallet Address "
		},{
			type: 'warning',
			delay: 4000,
		});		
		$("#txtaddressgot").focus();
		return;
    }
    if(order_address == '' || order_address == null ){
		$.notify({
			message: "Please fill out the CCB Order Address "
		},{
			type: 'warning',
			delay: 4000,
		});		
		$("#txtoaddressgot").focus();
		return;
    }
    
    if((amount == '' || amount== null || amount == 0 )&&(transaction_type == 'addfunds')){
		$.notify({
			message: "Please fill out the CCB Wallet Transfer Amount "
		},{
			type: 'warning',
			delay: 4000,
		});		
		$("#txtoamount").focus();
		return;
    }
    
    if((passgot == '' || passgot == null )&&(transaction_type == 'addfunds' || transaction_type == 'approve' || transaction_type == 'addofftaker' || transaction_type == 'removeofftaker' )){
		$.notify({
			message: "Please fill out the CCB Wallet Password "
		},{
			type: 'warning',
			delay: 4000,
		});		
		$("#txtpassgot").focus();
		return;
    }

	if((offmsisdngot == '' || offmsisdngot == null)&&(transaction_type == 'addofftaker' || transaction_type == 'removeofftaker' )){
		$.notify({
			message: "Please fill out Offtaker Wallet No"
		},{
			type: 'warning',
			delay: 4000,
		});		
		$("#offtxtmsisdngot").focus();
		return;
    }
    
    if((offaddressgot == '' || offaddressgot== null )&&(transaction_type == 'addofftaker' || transaction_type == 'removeofftaker' )){
		$.notify({
			message: "Please fill out the Offtaker Wallet Address "
		},{
			type: 'warning',
			delay: 4000,
		});		
		$("#offtxtaddressgot").focus();
		return;
	}

	

	var value = {
		id_got:       id_got,
		got_name:     got_name,
		order_address:     order_address,	
		addressgot:   addressgot,
        msisdngot:    msisdngot,
        passgot  :       passgot,
        amount   :       amount,
        offaddressgot:   offaddressgot,
		offmsisdngot:    offmsisdngot,
		transaction_type: transaction_type,
		crud:crud,
		method : "save_got"
	};
	$(this).prop('disabled', true);
	proccess_waiting("#infoprosesgot");
	$.ajax(
	{
		url : "c_got.php",
		type: "POST",
		data : value,
		success: function(data, textStatus, jqXHR)
		{
			$("#btnsavegot").prop('disabled', false);
			$("#infoprosesgot").html("");
			var data = jQuery.parseJSON(data);
			if(data.ceksat == 0){
				$.notify(data.error);
			}else{
				if(data.crud == 'N'){
					if(data.result == 1){
						$.notify('Save Transaction successfuly');
						var table = $('#table_got').DataTable(); 
						table.ajax.reload( null, false );
						newgot();				
					}else{
						$.notify({
							message: "Error save Transaction, error :"+data.error
						},{
							type: 'danger',
							delay: 4000,
						});
						set_focus("#txtidgot");
					}
				}else if(data.crud == 'E'){
					if(data.result == 1){
						$.notify('Update Transaction successfuly');
						var table = $('#table_got').DataTable(); 
						table.ajax.reload( null, false );
						$("#modalmastergot").modal("hide");
					}else{
						$.notify({
							message: "Error update record, error :"+data.error
						},{
							type: 'danger',
							delay: 4000,
						});					
						set_focus("#txtidgot");
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
			$("#btnsavegot").prop('disabled', false);
		}
	});
});
$(document).on( "click",".btndeletegot", function() {
	var id_got = $(this).attr("id_got");
	swal({   
		title: "Delete",   
		text: "Delete Produce gotmer with id : "+id_got+" ?",   
		type: "warning",   
		showCancelButton: true,   
		confirmButtonColor: "#DD6B55",   
		confirmButtonText: "Delete",   
		closeOnConfirm: true }, 
		function(){   
			var value = {
				id_got: id_got,
				method : "delete_got"
			};
			$.ajax(
			{
				url : "c_got.php",
				type: "POST",
				data : value,
				success: function(data, textStatus, jqXHR)
				{
					var data = jQuery.parseJSON(data);
					if(data.result ==1){
						$.notify('Delete gotmer successfuly');
						var table = $('#table_got').DataTable(); 
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

