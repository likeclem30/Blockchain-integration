$(document).ready( function () 
{

    $(document).on('change','#txtmsisdngof', function() {
		var wphonegof_id = $(this).val();
		if(wphonegof_id != "") {
			$.ajax({
				url:"c_gof.php",
				type:'POST',
				data:{wphonegof_id:wphonegof_id},
				success:function(response) {
					//var resp = $.trim(response);
					if(response != '') {
						$("#txtaddressgof").removeAttr('disabled','disabled').html(response);
						$("#txtordergof").attr('disabled','disabled').html("<option value=''>------- Select --------</option>");
					} else {
						$("#txtaddressgof, #txtordergof").attr('disabled','disabled').html("<option value=''>------- Select --------</option>");
					}
				}
			});
		} else {
			$("#txtaddressgof, #txtordergof").attr('disabled','disabled').html("<option value=''>------- Select --------</option>");
		}
	});


	
	//generate dropdown options for txtmsisdnmuldes dropdown
	$(document).on('change','#txtaddressgof', function() {
		var b_addressgof = $(this).val();
		if(b_addressgof != "") {
			$.ajax({
				url:"c_gof.php",
				type:'POST',
				data:{b_addressgof:b_addressgof},
				success:function(response) {
					//var resp = $.trim(response);
					if(response != '') $("#txtordergof").removeAttr('disabled','disabled').html(response);
					else $("#txtordergof").attr('disabled','disabled').html("<option value=''>------- Select --------</option>");
				}
			});
		} else {
			$("#txtordergof").attr('disabled','disabled').html("<option value=''>------- Select --------</option>");
		}
	});





































   


	


	money();
	decimal();
	var value = {
		method : "getdata"
	};
	$('#table_gof').DataTable({
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
			"url": "c_gof.php",
			"type": "POST",
			"data":value,
		},
		"columns": [
		{ "data": "urutan" },
		{ "data": "id_gof" },
		{ "data": "transaction_type"},
		{ "data": "gof_name" },
		{ "data": "off_msisdngof" },
		{ "data": "msisdngof" },
		{ "data": "button" },
		]
	});
	$("#table_gof_filter").addClass("pull-right");
	
});

$(document).on( "click","#btnaddgof", function() {
	$(".contentharga").remove();
	$("#modalmastergof").modal('show');
	newgof();
});
function newgof()
{
	$("#txtidgof").val("*New");
    $("#txtgofname").val("");
    $("#txttctygof").val("");
	$("#txtmsisdngof").val("");
    $("#txtaddressgof").val("");
    $("#txtamoutgof").val(0);
    //$("#txtwpassgof").val("");
    $("#txtopassgof").val("");
    $("#txtordergof").val("");
    $("#offtxtmsisdngof").val("");
	$("#offtxtaddressgof").val("");
	$("#inputcrud").val("N");
	set_focus("#txtgofname");
}
$(document).on( "click",".btneditgof", function() {
	var id_gof = $(this).attr("id_gof");
	var value = {
		id_gof: id_gof,
		method : "get_detail_gof"
	};
	$.ajax(
	{
		url : "c_gof.php",
		type: "POST",
		data : value,
		success: function(data, textStatus, jqXHR)
		{
			var hasil = jQuery.parseJSON(data);
			data = hasil.data;
			$("#inputcrud").val("E");
			$("#txtidgof").val(data.id_gof);
			$("#txtgofname").val(data.gof_name);
            $("#txttctygof").val(data.transaction_type);
            $("#txtmsisdngof").val(data.msisdngof);
            $("#txtaddressgof").val(data.addressgof);
            $("#txtamoutgof").val(addCommas(data.amount));
            $("#txtopassgof").val(data.passgof);
           // $("#txtwpassgof").val(data.passgof);
            $("#txtordergof").val(data.orderaddress);
            $("#offtxtmsisdngof").val(data.offmsisdngof);
            $("#offtxtaddressgof").val(data.offaddressgof);

			$("#modalmastergof").modal('show');
			set_focus("#txtgofname");
		},
		error: function(jqXHR, textStatus, errorThrown)
		{
		}
	});
});
$(document).on( "click","#btnsavegof", function() {

    var id_gof         = $("#txtidgof").val();
    var gof_name       = $("#txtgofname").val();
    var transaction_type = $("#txttctygof").val();
	var addressgof     = $("#txtaddressgof").val();
	var msisdngof      = $("#txtmsisdngof").val();
    var amount         = $("#txtamoutgof").val();
    var passgof        = $("#txtopassgof").val();
    var order_address  = $("#txtordergof").val();
    var offmsisdngof  = $("#offtxtmsisdngof").val();
	var offaddressgof = $("#offtxtaddressgof").val();

		
	var crud=$("#inputcrud").val();
	if(crud == 'E'){
		if(id_gof == '' || id_gof== null ){
			$.notify({
				message: "gof Id invalid"
			},{
				type: 'warning',
				delay: 4000,
			});		
			$("#txtidgof").focus();
			return;
		}	
	}
    
    if(gof_name == '' || gof_name== null ){
		$.notify({
			message: "Please fill out the Title"
		},{
			type: 'warning',
			delay: 4000,
		});		
		$("#txtgofname").focus();
		return;
	}

	if(transaction_type == '' || transaction_type == null ){
		$.notify({
			message: "Please fill out the transaction type"
		},{
			type: 'warning',
			delay: 4000,
		});		
		$("#txttctygof").focus();
		return;
	}

	if(msisdngof == '' || msisdngof == null ){
		$.notify({
			message: "Please fill out the Wallet Phone number"
		},{
			type: 'warning',
			delay: 4000,
		});		
		$("#txtmsisdngof").focus();
		return;
    }
    
    if(addressgof == '' || addressgof == null ){
		$.notify({
			message: "Please fill out the Wallet Phone number"
		},{
			type: 'warning',
			delay: 4000,
		});		
		$("#txtaddressgof").focus();
		return;
    }
    
    if(order_address == '' || order_address == null ){
		$.notify({
			message: "Please fill out the Wallet Phone number"
		},{
			type: 'warning',
			delay: 4000,
		});		
		$("#txtordergof").focus();
		return;
    }
    
    if(amount == '' || amount == null ){
		$.notify({
			message: "Please fill out the Wallet Phone number"
		},{
			type: 'warning',
			delay: 4000,
		});		
		$("#txtamoutgof").focus();
		return;
    }
    
    if(passgof == '' || passgof == null ){
		$.notify({
			message: "Please fill out the Wallet Phone number"
		},{
			type: 'warning',
			delay: 4000,
		});		
		$("#txtopassgof").focus();
		return;
    }
    
    if(offmsisdngof == '' || offmsisdngof == null ){
		$.notify({
			message: "Please fill out the Offtaker Wallet Phone number"
		},{
			type: 'warning',
			delay: 4000,
		});		
		$("#offtxtmsisdngof").focus();
		return;
    }
    
   

	//08167539088

	var value = {
        id_gof           : id_gof,
        gof_name         : gof_name,
        transaction_type :transaction_type,
	    addressgof       :addressgof,
	    msisdngof        :msisdngof,
        amount           :amount,
        passgof          :passgof,
        order_address    :order_address,
        offmsisdngof    :offmsisdngof,
	    offaddressgof   :offaddressgof,
		crud:crud,
		method : "save_gof"
    };
    
	$(this).prop('disabled', true);
	proccess_waiting("#infoprosesgof");
	$.ajax(
	{
		url : "c_gof.php",
		type: "POST",
		data : value,
		success: function(data, textStatus, jqXHR)
		{
			$("#btnsavegof").prop('disabled', false);
			$("#infoprosesgof").html("");
			var data = jQuery.parseJSON(data);
			if(data.ceksat == 0){
				$.notify(data.error);
			}else{
				if(data.crud == 'N'){
					if(data.result == 1){
						$.notify('Save gofmer successfuly');
						var table = $('#table_gof').DataTable(); 
						table.ajax.reload( null, false );
						newgof();				
					}else{
						$.notify({
							message: "Error save gofmer, error :"+data.error
						},{
							type: 'danger',
							delay: 4000,
						});
						set_focus("#txtidgof");
					}
				}else if(data.crud == 'E'){
					if(data.result == 1){
						$.notify('Update gofmer successfuly');
						var table = $('#table_gof').DataTable(); 
						table.ajax.reload( null, false );
						$("#modalmastergof").modal("hide");
					}else{
						$.notify({
							message: "Error update record, error :"+data.error
						},{
							type: 'danger',
							delay: 4000,
						});					
						set_focus("#txtidgof");
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
			$("#btnsavegof").prop('disabled', false);
		}
	});
});
$(document).on( "click",".btndeletegof", function() {
	var id_gof = $(this).attr("id_gof");
	swal({   
		title: "Delete",   
		text: "Delete Produce gofmer with id : "+id_gof+" ?",   
		type: "warning",   
		showCancelButton: true,   
		confirmButtonColor: "#DD6B55",   
		confirmButtonText: "Delete",   
		closeOnConfirm: true }, 
		function(){   
			var value = {
				id_gof: id_gof,
				method : "delete_gof"
			};
			$.ajax(
			{
				url : "c_gof.php",
				type: "POST",
				data : value,
				success: function(data, textStatus, jqXHR)
				{
					var data = jQuery.parseJSON(data);
					if(data.result ==1){
						$.notify('Delete gofmer successfuly');
						var table = $('#table_gof').DataTable(); 
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

