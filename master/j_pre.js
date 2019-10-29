$(document).ready( function () 
{

	$(document).on('change','#txtmsisdnpre', function() {
		var wphonepre_id = $(this).val();
		if(wphonepre_id != "") {
			$.ajax({
				url:"c_pre.php",
				type:'POST',
				data:{wphonepre_id:wphonepre_id},
				success:function(response) {
					//var resp = $.trim(response);
					if(response != '') {
						$("#txtaddresspre").removeAttr('disabled','disabled').html(response);
						
					} else {
						$("#txtaddresspre").attr('disabled','disabled').html("<option value=''>----- Select ---</option>");
					}
				}
			});
		} else {
			$("#txtaddresspre").attr('disabled','disabled').html("<option value=''>----- Select ------</option>");
		}
    });
    
    $(document).on('change','#txtaddresspre', function() {
		var b_addresspre = $(this).val();
		if(b_addresspre != "") {
			$.ajax({
				url:"c_pre.php",
				type:'POST',
				data:{b_addresspre:b_addresspre},
				success:function(response) {
					//var resp = $.trim(response);
					if(response != '') {
						$("#txtoaddresspre").removeAttr('disabled','disabled').html(response);
						
					} else {
						$("#txtoaddresspre").attr('disabled','disabled').html("<option value=''>----- Select ---</option>");
					}
				}
			});
		} else {
			$("#txtoaddresspre").attr('disabled','disabled').html("<option value=''>----- Select ------</option>");
		}
	});


    $(document).on('change','#offtxtmsisdnpre', function() {
		var offwphonepre_id = $(this).val();
		if(offwphonepre_id != "") {
			$.ajax({
				url:"c_pre.php",
				type:'POST',
				data:{offwphonepre_id:offwphonepre_id},
				success:function(response) {
					//var resp = $.trim(response);
					if(response != '') {
						$("#offtxtaddresspre").removeAttr('disabled','disabled').html(response);
						
					} else {
						$("#offtxtaddresspre").attr('disabled','disabled').html("<option value=''>----- Select ---</option>");
					}
				}
			});
		} else {
			$("#offtxtaddresspre").attr('disabled','disabled').html("<option value=''>----- Select ------</option>");
		}
    });



	$(document).on('change','#fartxtmsisdnpre', function() {
		var farwphonepre_id = $(this).val();
		if(farwphonepre_id != "") {
			$.ajax({
				url:"c_pre.php",
				type:'POST',
				data:{farwphonepre_id:farwphonepre_id},
				success:function(response) {
					//var resp = $.trim(response);
					if(response != '') {
						$("#fartxtaddresspre").removeAttr('disabled','disabled').html(response);
						
					} else {
						$("#fartxtaddresspre").attr('disabled','disabled').html("<option value=''>----- Select ---</option>");
					}
				}
			});
		} else {
			$("#fartxtaddresspre").attr('disabled','disabled').html("<option value=''>----- Select ------</option>");
		}
    });





	money();
	decimal();
	var value = {
		method : "getdata"
	};

	var t_type = $("#divid").val();

	$('#table_pre').DataTable({
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
			"url": "c_pre.php",
			"type": "POST",
			"data":value,
		},
		"columns": [
		{ "data": "urutan" },
		{ "data": "id_pre" },
		{ "data": "pre_name" },	
		{ "data": "tran_type" },
		{ "data": "msisdnpre" },
		{ "data": "offmsisdnpre" },
		{ "data": "farmsisdnpre" },
		{ "data": "terms" },
		{ "data": "quantity" },
		{ "data": "amount" },
		{ "data": "outpre" },
		{ "data": "date_created" },
		{ "data": "button" },
		]
	});
	$("#table_pre_filter").addClass("pull-right");
});

$(document).on( "click","#btnaddpre", function() {
	$(".contentharga").remove();
	$("#modalmasterpre").modal('show');
	newpre();
});
function newpre()
{
	$("#txtidpre").val("*New");
	$("#txtprename").val("");
	$("#txttctypre").val("");
	$("#txtmsisdnpre").val("");
	$("#txtaddresspre").val("");
	$("#txtoaddresspre").val("");
	$("#txtamountpre").val(0);
	$("#offtxtmsisdnpre").val("");
	$("#offtxtaddresspre").val("");
	$("#txtpasspre").val("");
	$("#txtqtypre").val("");
	$("#txttermspre").val("");
	$("#fartxtmsisdnpre").val("");
	$("#fartxtaddresspre").val("");
	$("#inputcrud").val("N");
	set_focus("#txtprename");
}
$(document).on( "click",".btneditpre", function() {
	var id_pre = $(this).attr("id_pre");
	var value = {
		id_pre: id_pre,
		method : "get_detail_pre"
	};
	$.ajax(
	{
		url : "c_pre.php",
		type: "POST",
		data : value,
		success: function(data, textStatus, jqXHR)
		{
			var hasil = jQuery.parseJSON(data);
			data = hasil.data;
			$("#preinputcrud").val("E");
			$("#txtidpre").val(data.id_pre);
			$("#txtprename").val(data.pre_name);
			$("#txttctypre").val(data.transaction_type);
			$("#txtmsisdnpre").val(data.msisdnpre);
			$("#txtaddresspre").val(data.addresspre);
			$("#offtxtmsisdnpre").val(data.offmsisdnpre);
			$("#offtxtaddresspre").val(data.offaddresspre);
			$("#fartxtmsisdnpre").val(data.farmsisdnpre);
			$("#fartxtaddresspre").val(data.faraddresspre);
			$("#txtoaddresspre").val(data.order_address);
			$("#txtpasspre").val(data.passpre);
			$("#txtamountpre").val(addCommas(data.amount));
			$("#txttermspre").val(addCommas(data.terms));
			$("#txtqtypre").val(addCommas(data.quantity));
			$("#modalmasterpre").modal('show');
			set_focus("#txtprename");
		},
		error: function(jqXHR, textStatus, errorThrown)
		{
		}
	});
});
$(document).on( "click","#btnsavepre", function() {
	var id_pre = $("#txtidpre").val();
	var pre_name = $("#txtprename").val();
	var transaction_type = $("#txttctypre").val();
	var msisdnpre = $("#txtmsisdnpre").val();
	var addresspre = $("#txtaddresspre").val();
	var offmsisdnpre = $("#offtxtmsisdnpre").val();
	var offaddresspre = $("#offtxtaddresspre").val();
	var farmsisdnpre = $("#fartxtmsisdnpre").val();
	var faraddresspre = $("#fartxtaddresspre").val();
	var passpre = $("#txtpasspre").val();
	var order_address = $("#txtoaddresspre").val();
	var amount = cleanString($("#txtamountpre").val());
	var terms = cleanString($("#txttermspre").val());
	var quantity = cleanString($("#txtqtypre").val());
	
	var crud=$("#inputcrud").val();
	if(crud == 'E'){
		if(id_pre == '' || id_pre== null ){
			$.notify({
				message: "receipt  Id invalid"
			},{
				type: 'warning',
				delay: 4000,
			});		
			$("#txtidpre").focus();
			return;
		}	
	}
	if(pre_name == '' || pre_name== null ){
		$.notify({
			message: "Please fill out the Receipts Title"
		},{
			type: 'warning',
			delay: 4000,
		});		
		$("#txtprename").focus();
		return;
	}
	if(transaction_type == '' || transaction_type == null ){
		$.notify({
			message: "Please fill out Transaction type"
		},{
			type: 'warning',
			delay: 4000,
		});		
		$("#txttctypre").focus();
		return;
	}
	if(msisdnpre == '' || msisdnpre== null ){
		$.notify({
			message: "Please fill out the CCB/Buyer MSISDN"
		},{
			type: 'warning',
			delay: 4000,
		});		
		$("#txtmsisdnpre").focus();
		return;
	}
	if(addresspre == '' || addresspre== null ){
		$.notify({
			message: "Please fill out the CCB/Buyer Address"
		},{
			type: 'warning',
			delay: 4000,
		});		
		$("#txtaddresspre").focus();
		return;
	}

	if(order_address == '' || order_address== null ){
		$.notify({
			message: "Please fill out the CCB/Buyer Order Address"
		},{
			type: 'warning',
			delay: 4000,
		});		
		$("#txtoaddresspre").focus();
		return;
	}

	if(amount == '' || amount== null ){
		$.notify({
			message: "Please fill out the order Receipt value"
		},{
			type: 'warning',
			delay: 4000,
		});		
		$("#txtamountpre").focus();
		return;
	}

	if(offmsisdnpre == '' || offmsisdnpre== null ){
		$.notify({
			message: "Please fill out the OffTaker MSISDN"
		},{
			type: 'warning',
			delay: 4000,
		});		
		$("#offtxtmsisdnpre").focus();
		return;
	}
	if(offaddresspre == '' || offaddresspre== null ){
		$.notify({
			message: "Please fill out the OffTaker Address"
		},{
			type: 'warning',
			delay: 4000,
		});		
		$("#offtxtaddresspre").focus();
		return;
	}

	if(passpre == '' || passpre== null ){
		$.notify({
			message: "Please fill out the OffTaker Password"
		},{
			type: 'warning',
			delay: 4000,
		});		
		$("#txtpasspre").focus();
		return;
	}
	if(quantity == '' || quantity== null ){
		$.notify({
			message: "Please fill out the Receipt Quantity"
		},{
			type: 'warning',
			delay: 4000,
		});		
		$("#txtqtypre").focus();
		return;
	}
    
	if(terms == '' || terms== null ){
		$.notify({
			message: "Please fill out the Receipt term"
		},{
			type: 'warning',
			delay: 4000,
		});		
		$("#txttermspre").focus();
		return;
	}
	
	if(farmsisdnpre == '' || farmsisdnpre== null ){
		$.notify({
			message: "Please fill out the OffTaker MSISDN"
		},{
			type: 'warning',
			delay: 4000,
		});		
		$("#fartxtmsisdnpre").focus();
		return;
	}
	if(faraddresspre == '' || faraddresspre== null ){
		$.notify({
			message: "Please fill out the OffTaker Address"
		},{
			type: 'warning',
			delay: 4000,
		});		
		$("#fartxtaddresspre").focus();
		return;
	}

	
	

	var value = {

	id_pre         :id_pre ,
	pre_name        :pre_name,
	transaction_type:transaction_type,
	msisdnpre      :msisdnpre,
	addresspre     :addresspre,
	offmsisdnpre   :offmsisdnpre,
	offaddresspre  :offaddresspre,
	farmsisdnpre   :farmsisdnpre,
	faraddresspre  :faraddresspre ,
	passpre        :passpre ,
	order_address  :order_address ,
	amount         :amount,
	terms          :terms,
	quantity       :quantity,
		
		crud:crud,
		method : "save_pre"
	};
	$(this).prop('disabled', true);
	proccess_waiting("#infoprosespre");
	$.ajax(
	{
		url : "c_pre.php",
		type: "POST",
		data : value,
		success: function(data, textStatus, jqXHR)
		{
			$("#btnsavepre").prop('disabled', false);
			$("#infoprosespre").html("");
			var data = jQuery.parseJSON(data);
			if(data.ceksat == 0){
				$.notify(data.error);
			}else{
				if(data.crud == 'N'){
					if(data.result == 1){
						$.notify('Save Receipt successfuly');
						var table = $('#table_pre').DataTable(); 
						table.ajax.reload( null, false );
						newpre();				
					}else{
						$.notify({
							message: "Error save Receipt, error :"+data.error
						},{
							type: 'danger',
							delay: 4000,
						});
						set_focus("#txtidpre");
					}
				}else if(data.crud == 'E'){
					if(data.result == 1){
						$.notify('Update Receipt successfuly');
						var table = $('#table_pre').DataTable(); 
						table.ajax.reload( null, false );
						$("#modalmasterpre").modal("hide");
					}else{
						$.notify({
							message: "Error update Receipt, error :"+data.error
						},{
							type: 'danger',
							delay: 4000,
						});					
						set_focus("#txtidpre");
					}
				}else{
					$.notify({
						message: "Invalid Receipt"
					},{
						type: 'danger',
						delay: 4000,
					});	
				}
			}
		},
		error: function(jqXHR, textStatus, errorThrown)
		{
			$("#btnsavepre").prop('disabled', false);
		}
	});
});
$(document).on( "click",".btndeletepre", function() {
	var id_pre = $(this).attr("id_pre");
	swal({   
		title: "Delete",   
		text: "Delete Receipt with id : "+id_pre+" ?",   
		type: "warning",   
		showCancelButton: true,   
		confirmButtonColor: "#DD6B55",   
		confirmButtonText: "Delete",   
		closeOnConfirm: true }, 
		function(){   
			var value = {
				id_pre: id_pre,
				method : "delete_pre"
			};
			$.ajax(
			{
				url : "c_pre.php",
				type: "POST",
				data : value,
				success: function(data, textStatus, jqXHR)
				{
					var data = jQuery.parseJSON(data);
					if(data.result ==1){
						$.notify('Delete Receipt successfuly');
						var table = $('#table_pre').DataTable(); 
						table.ajax.reload( null, false );
					}else{
						$.notify({
							message: "Error delete Receipt, error :"+data.error
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

