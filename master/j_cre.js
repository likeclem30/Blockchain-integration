$(document).ready( function () 
{

	$(document).on('change','#txtmsisdncre', function() {
		var wphonecre_id = $(this).val();
		if(wphonecre_id != "") {
			$.ajax({
				url:"c_cre.php",
				type:'POST',
				data:{wphonecre_id:wphonecre_id},
				success:function(response) {
					//var resp = $.trim(response);
					if(response != '') {
						$("#txtoaddresscre").removeAttr('disabled','disabled').html(response);
						
					} else {
						$("#txtoaddresscre").attr('disabled','disabled').html("<option value=''>----- Select ---</option>");
					}
				}
			});
		} else {
			$("#txtoaddresscre").attr('disabled','disabled').html("<option value=''>----- Select ------</option>");
		}
    });
    
    $(document).on('change','#txtoaddresscre', function() {
		var b_addresscre = $(this).val();
		if(b_addresscre != "") {
			$.ajax({
				url:"c_cre.php",
				type:'POST',
				data:{b_addresscre:b_addresscre},
				success:function(response) {
					//var resp = $.trim(response);
					if(response != '') {
						$("#txtoreceiptcre").removeAttr('disabled','disabled').html(response);
						
					} else {
						$("#txtoreceiptcre").attr('disabled','disabled').html("<option value=''>----- Select ---</option>");
					}
				}
			});
		} else {
			$("#txtoreceiptcre").attr('disabled','disabled').html("<option value=''>----- Select ------</option>");
		}
	});


    $(document).on('change','#certxtmsisdncre', function() {
		var cerwphonecre_id = $(this).val();
		if(cerwphonecre_id != "") {
			$.ajax({
				url:"c_cre.php",
				type:'POST',
				data:{cerwphonecre_id:cerwphonecre_id},
				success:function(response) {
					//var resp = $.trim(response);
					if(response != '') {
						$("#certxtaddresscre").removeAttr('disabled','disabled').html(response);
						
					} else {
						$("#certxtaddresscre").attr('disabled','disabled').html("<option value=''>----- Select ---</option>");
					}
				}
			});
		} else {
			$("#certxtaddresscre").attr('disabled','disabled').html("<option value=''>----- Select ------</option>");
		}
    });







	money();
	decimal();
	var value = {
		method : "getdata"
	};

	var t_type = $("#divid").val();

	$('#table_cre').DataTable({
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
			"url": "c_cre.php",
			"type": "POST",
			"data":value,
		},
		"columns": [
		{ "data": "urutan" },
		{ "data": "id_cre" },
		{ "data": "cre_name" },
		{ "data": "tran_type" },
		{ "data": "msisdncre" },
		{ "data": "cermsisdncre" },	
		{ "data": "outcre" },
		{ "data": "date_created" },
		{ "data": "button" },
		]
	});
	$("#table_cre_filter").addClass("pull-right");
});

$(document).on( "click","#btnaddcre", function() {
	$(".contentharga").remove();
	$("#modalmastercre").modal('show');
	newcre();
});
function newcre()
{
	$("#txtidcre").val("*New");
	$("#txtcrename").val("");
	$("#txttctycre").val("");
	$("#txtmsisdncre").val("");
	$("#txtoaddresscre").val("");
	$("#txtoreceiptcre").val("");
	$("#certxtmsisdncre").val("");
	$("#certxtaddresscre").val("");
	$("#txtpasscre").val("");
	
	$("#inputcrud").val("N");
	set_focus("#txtcrename");
}
$(document).on( "click",".btneditcre", function() {
	var id_cre = $(this).attr("id_cre");
	var value = {
		id_cre: id_cre,
		method : "get_detail_cre"
	};
	$.ajax(
	{
		url : "c_cre.php",
		type: "POST",
		data : value,
		success: function(data, textStatus, jqXHR)
		{
			var hasil = jQuery.parseJSON(data);
			data = hasil.data;
			$("#inputcrud").val("E");
			$("#txtidcre").val(data.id_cre);
			$("#txtcrename").val(data.cre_name);
			$("#txttctycre").val(data.transaction_type);
			$("#txtmsisdncre").val(data.msisdncre);
			$("#txtoaddresscre").val(data.oaddresscre);
			$("#certxtmsisdncre").val(data.cermsisdncre);
			$("#certxtaddresscre").val(data.ceraddresscre);
			$("#txtoreceiptcre").val(data.oreceiptcre);
			$("#txtpasscre").val(data.passcre);
			$("#modalmastercre").modal('show');
			set_focus("#txtcrename");
		},
		error: function(jqXHR, textStatus, errorThrown)
		{
		}
	});
});
$(document).on( "click","#btnsavecre", function() {
	var id_cre = $("#txtidcre").val();
	var cre_name = $("#txtcrename").val();
	var transaction_type = $("#txttctycre").val();
	var msisdncre = $("#txtmsisdncre").val();
	var oaddresscre = $("#txtoaddresscre").val();
	var cermsisdncre = $("#certxtmsisdncre").val();
	var ceraddresscre = $("#certxtaddresscre").val();
	var passcre = $("#txtpasscre").val();
	var oreceiptcre = $("#txtoreceiptcre").val();
	
	
	var crud=$("#inputcrud").val();
	if(crud == 'E'){
		if(id_cre == '' || id_cre== null ){
			$.notify({
				message: "receipt  Id invalid"
			},{
				type: 'warning',
				delay: 4000,
			});		
			$("#txtidcre").focus();
			return;
		}	
	}
	if(cre_name == '' || cre_name== null ){
		$.notify({
			message: "Please fill out the Receipts Certification Title"
		},{
			type: 'warning',
			delay: 4000,
		});		
		$("#txtcrename").focus();
		return;
	}
	if(transaction_type == '' || transaction_type== null){
		$.notify({
			message: "Please fill out the Transaction type"
		},{
			type: 'warning',
			delay: 4000,
		});		
		$("#txttctycre").focus();
		return;
	}
	if(msisdncre == '' || msisdncre== null ){
		$.notify({
			message: "Please fill out the CCB/Buyer MSISDN"
		},{
			type: 'warning',
			delay: 4000,
		});		
		$("#txtmsisdncre").focus();
		return;
	}
	if(oaddresscre == '' || oaddresscre== null ){
		$.notify({
			message: "Please fill out the CCB/Buyer Order Address"
		},{
			type: 'warning',
			delay: 4000,
		});		
		$("#txtoaddresscre").focus();
		return;
	}

	if(oreceiptcre == '' || oreceiptcre== null ){
		$.notify({
			message: "Please fill out the CCB/Buyer Order Receipt"
		},{
			type: 'warning',
			delay: 4000,
		});		
		$("#txtoreceiptcre").focus();
		return;
	}

	
	if(cermsisdncre == '' || cermsisdncre== null ){
		$.notify({
			message: "Please fill out the cerTaker MSISDN"
		},{
			type: 'warning',
			delay: 4000,
		});		
		$("#certxtmsisdncre").focus();
		return;
	}
	if(ceraddresscre == '' || ceraddresscre== null ){
		$.notify({
			message: "Please fill out the cerTaker Address"
		},{
			type: 'warning',
			delay: 4000,
		});		
		$("#certxtaddresscre").focus();
		return;
	}

	if(passcre == '' || passcre== null ){
		$.notify({
			message: "Please fill out the cerTaker Password"
		},{
			type: 'warning',
			delay: 4000,
		});		
		$("#txtpasscre").focus();
		return;
	}
	
	
	
	

	var value = {

	id_cre         :id_cre ,
	cre_name        :cre_name,
	transaction_type:transaction_type,
	msisdncre      :msisdncre,
	oaddresscre    :oaddresscre,
	cermsisdncre   :cermsisdncre,
	ceraddresscre  :ceraddresscre,
	passcre        :passcre,
	oreceiptcre       :oreceiptcre,
			
		crud:crud,
		method : "save_cre"
	};
	$(this).prop('disabled', true);
	proccess_waiting("#infoprosescre");
	$.ajax(
	{
		url : "c_cre.php",
		type: "POST",
		data : value,
		success: function(data, textStatus, jqXHR)
		{
			$("#btnsavecre").prop('disabled', false);
			$("#infoprosescre").html("");
			var data = jQuery.parseJSON(data);
			if(data.ceksat == 0){
				$.notify(data.error);
			}else{
				if(data.crud == 'N'){
					if(data.result == 1){
						$.notify('Save Receipt successfuly');
						var table = $('#table_cre').DataTable(); 
						table.ajax.reload( null, false );
						newcre();				
					}else{
						$.notify({
							message: "Error save Receipt, error :"+data.error
						},{
							type: 'danger',
							delay: 4000,
						});
						set_focus("#txtidcre");
					}
				}else if(data.crud == 'E'){
					if(data.result == 1){
						$.notify('Update Receipt successfuly');
						var table = $('#table_cre').DataTable(); 
						table.ajax.reload( null, false );
						$("#modalmastercre").modal("hide");
					}else{
						$.notify({
							message: "Error update Receipt, error :"+data.error
						},{
							type: 'danger',
							delay: 4000,
						});					
						set_focus("#txtidcre");
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
			$("#btnsavecre").prop('disabled', false);
		}
	});
});
$(document).on( "click",".btndeletecre", function() {
	var id_cre = $(this).attr("id_cre");
	swal({   
		title: "Delete",   
		text: "Delete Receipt with id : "+id_cre+" ?",   
		type: "warning",   
		showCancelButton: true,   
		confirmButtonColor: "#DD6B55",   
		confirmButtonText: "Delete",   
		closeOnConfirm: true }, 
		function(){   
			var value = {
				id_cre: id_cre,
				method : "delete_cre"
			};
			$.ajax(
			{
				url : "c_cre.php",
				type: "POST",
				data : value,
				success: function(data, textStatus, jqXHR)
				{
					var data = jQuery.parseJSON(data);
					if(data.result ==1){
						$.notify('Delete Receipt successfuly');
						var table = $('#table_cre').DataTable(); 
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

