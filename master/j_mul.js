


$(document).ready( function () 

{
	

	
	$(document).on('change','#txtmsisdnmul', function() {
		var wphone1_id = $(this).val();
		if(wphone1_id != "") {
			$.ajax({
				url:"c_mul.php",
				type:'POST',
				data:{wphone1_id:wphone1_id},
				success:function(response) {
					//var resp = $.trim(response);
					if(response != '') {
						$("#txtaddressmul").removeAttr('disabled','disabled').html(response);
						$("#txtmsisdnmuldes").attr('disabled','disabled').html("<option value=''>------- Select --------</option>");
					} else {
						$("#txtaddressmul, #txtmsisdnmuldes, #txtaddressmuldes").attr('disabled','disabled').html("<option value=''>------- Select --------</option>");
					}
				}
			});
		} else {
			$("#txtaddressmul, #txtmsisdnmuldes, #txtaddressmuldes").attr('disabled','disabled').html("<option value=''>------- Select --------</option>");
		}
	});


	
	//generate dropdown options for txtmsisdnmuldes dropdown
	$(document).on('change','#txtaddressmul', function() {
		var address1_id = $(this).val();
		if(address1_id != "") {
			$.ajax({
				url:"c_mul.php",
				type:'POST',
				data:{address1_id:address1_id},
				success:function(response) {
					//var resp = $.trim(response);
					if(response != '') $("#txtmsisdnmuldes").removeAttr('disabled','disabled').html(response);
					else $("#txtmsisdnmuldes, #txtaddressmuldes").attr('disabled','disabled').html("<option value=''>------- Select --------</option>");
				}
			});
		} else {
			$("#txtmsisdnmuldes, #txtaddressmuldes").attr('disabled','disabled').html("<option value=''>------- Select --------</option>");
		}
	});



	//Change in txtmsisdnmuldes dropdown list will trigger this function and
	//generate dropdown options for txtaddressmuldes dropdown
	$(document).on('change','#txtmsisdnmuldes', function() {
		var wphone2_id = $(this).val();
		if(wphone2_id != "") {
			$.ajax({
				url:"c_mul.php",
				type:'POST',
				data:{wphone2_id:wphone2_id},
				success:function(response) {
					if(response != '') $("#txtaddressmuldes").removeAttr('disabled','disabled').html(response);
					else $("#txtaddressmuldes").attr('disabled','disabled').html("<option value=''>------- Select --------</option>");
				}
			});
		} else {
			$("#txtaddressmuldes").attr('disabled','disabled').html("<option value=''>------- Select --------</option>");
		}
	});


	
	
	money();
	decimal();
	var value = {
		method : "getdata"
	};

	var t_type = $("#divid").val();

	$('#table_mul').DataTable({
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
			"url": "c_mul.php",
			"type": "POST",
			"data":value,
		},
		"columns": [
		{ "data": "urutan" },
		{ "data": "id_mul" },
		{ "data": "mul_name" },
		{ "data": "currency_type" },
		{ "data": "exchanged_currency" },
		{ "data": "amount" },
        
		{ "data": "msisdnmul" },
		
		{ "data": "msisdnmuldes" },
		{ "data": "transaction_id" },
		{ "data": "button" },
		]
	});
	$("#table_mul_filter").addClass("pull-right");
	
});

$(document).on( "click","#btnaddmul", function() {
	$(".contentharga").remove();
	$("#modalmastermul").modal('show');
	newmul();
});
function newmul()
{
	$("#txtidmul").val("*New");
	$("#txtmulname").val("");
	$("#txtmultcty").val("");
	$("#txtmulfcty").val("");
	$("#txtmulcval").val(0);
    $("#txtaddressmul").val("");
	$("#txtmsisdnmul").val("");
	$("#txtpassmul").val("");
	$("#txtaddressmuldes").val("");
    $("#txtmsisdnmuldes").val("");
	$("#inputcrud").val("N");
	set_focus("#txtmulname");

	
}
$(document).on( "click",".btneditmul", function() {
	var id_mul = $(this).attr("id_mul");
	var value = {
		id_mul: id_mul,
		method : "get_detail_mul"
	};
	$.ajax(
	{
		url : "c_mul.php",
		type: "POST",
		data : value,
		success: function(data, textStatus, jqXHR)
		{
			var hasil = jQuery.parseJSON(data);
			data = hasil.data;
			$("#inputcrud").val("E");
			$("#txtidmul").val(data.id_mul);
			$("#txtmulname").val(data.mul_name);
			$("#txtmultcty").val(data.currency_type);
			$("#txtmulfcty").val(data.exchanged_currency);
			$("#txtmulcval").val(addCommas(data.amount));
            $("#txtaddressmul").val(data.addressmul);
			$("#txtmsisdnmul").val(data.msisdnmul);
            $("#txtpassmul").val(data.frompw);
			$("#txtaddressmuldes").val(data.addressmuldes);
            $("#txtmsisdnmuldes").val(data.msisdnmuldes);
			$("#modalmastermul").modal('show');
			set_focus("#txtmulname");
		},
		error: function(jqXHR, textStatus, errorThrown)
		{
		}
	});
});
$(document).on( "click","#btnsavemul", function() {
	var id_mul = $("#txtidmul").val();
	var mul_name = $("#txtmulname").val();
	var currency_type = $("#txtmultcty").val();
	var exchanged_currency = $("#txtmulfcty").val();
	var amount = cleanString($("#txtmulcval").val());
    var addressmul = $("#txtaddressmul").val();
	var msisdnmul = $("#txtmsisdnmul").val();
	var addressmuldes = $("#txtaddressmuldes").val();
	var msisdnmuldes = $("#txtmsisdnmuldes").val();
	var frompw = $("#txtpassmul").val();
	var crud=$("#inputcrud").val();
	if(crud == 'E'){
		if(id_mul == '' || id_mul== null ){
			$.notify({
				message: "Buying Id invalid"
			},{
				type: 'warning',
				delay: 4000,
			});		
			$("#txtidmul").focus();
			return;
		}	
	}
	if(mul_name == '' || mul_name== null ){
		$.notify({
			message: "Please fill out the Tran Title name"
		},{
			type: 'warning',
			delay: 4000,
		});		
		$("#txtmulname").focus();
		return;
	}

	if(currency_type == '' || currency_type== null ){
		$.notify({
			message: "Please fill out Transaction type"
		},{
			type: 'warning',
			delay: 4000,
		});		
		$("#txtmultcty").focus();
		return;
	}

	if(exchanged_currency == '' || exchanged_currency== null ){
		$.notify({
			message: "Please fill out exchanged currency"
		},{
			type: 'warning',
			delay: 4000,
		});		
		$("#txtmulfcty").focus();
		return;
	}

	

	if((amount == '' || amount== null )&&(currency_type != 'closemulaselfaddaccount')){
		$.notify({
			message: "Please fill out amount "
		},{
			type: 'warning',
			delay: 4000,
		});		
		$("#txtmulcval").focus();
		return;
	}

	if((msisdnmul == '' || msisdnmul== null ) && (currency_type == 'transfer' || currency_type== 'transfernofee')){
		$.notify({
			message: "Please fill wallet number "
		},{
			type: 'warning',
			delay: 4000,
		});		
		$("#txtmsisdnmul").focus();
		return;
	}

   if((addressmul == '' || addressmul== null ) && (currency_type == 'transfer' || currency_type == 'transfernofee' )){
	   //&& (currency_type == 'transfer' || currency_type == 'transfernofee' )
		$.notify({
			message: "Please fill out block address "
		},{
			type: 'warning',
			delay: 4000,
		});		
		$("#txtaddressmul").focus();
		return;
	}

	
	if((frompw == '' || frompw== null ) && (currency_type == 'transfer' || currency_type == 'transfernofee' )){
		// && (currency_type == 'transfer' || currency_type == 'transfernofee' )
		$.notify({
			message: "Please fill out password "
		},{
			type: 'warning',
			delay: 4000,
		});		
		$("#txtpassmul").focus();
		return;
	}
/** 
	var resp = [];
         
	$.ajax({
	   type:"POST",
	   url:"api.php",
	   data:{addressmul:addressmul},
	   async: false,
	   success:function(data){
		  $("#content").html(data);
		  resp.push(data);
	   }
   });

   var pass = resp;

	if(frompw != pass ){
		// && (currency_type == 'transfer' || currency_type == 'transfernofee' )
		$.notify({
			message: "Wrong password. "+pass
		},{
			type: 'warning',
			delay: 4000,
		});		
		$("#txtpassmul").focus();
		return;
	}
*/
    if((msisdnmuldes == '' || msisdnmuldes== null ) && (currency_type == 'transfer' || currency_type== 'transfernofee')){
		$.notify({
			message: "Please fill wallet number "
		},{
			type: 'warning',
			delay: 4000,
		});		
		$("#txtmsisdnmul").focus();
		return;
	}

   if((addressmuldes == '' || addressmuldes == null )&&(currency_type == 'transfer' || currency_type == 'transfernofee' )){
		$.notify({
			message: "Please fill out block address "
		},{
			type: 'warning',
			delay: 4000,
		});		
		$("#txtaddressmul").focus();
		return;
	}
	

	var value = {
		       id_mul: id_mul,
		     mul_name: mul_name,
		currency_type:currency_type,
	exchanged_currency:exchanged_currency,
		    amount:amount,
	   addressmul:addressmul,
		msisdnmul: msisdnmul,
		addressmuldes:addressmuldes,
		msisdnmuldes:msisdnmuldes,
		frompw:frompw,
		crud:crud,
		method : "save_mul"
	};
	$(this).prop('disabled', true);
	proccess_waiting("#infoproses");
	$.ajax(
	{
		url : "c_mul.php",
		type: "POST",
		data : value,
		success: function(data, textStatus, jqXHR)
		{
			$("#btnsavemul").prop('disabled', false);
			$("#infoproses").html("");
			var data = jQuery.parseJSON(data);
			if(data.ceksat == 0){
				$.notify(data.error);
			}else{
				if(data.crud == 'N'){
					if(data.result == 1){
						$.notify('Save Transaction successfuly');
						var table = $('#table_mul').DataTable(); 
						table.ajax.reload( null, false );
						newmul();				
					}else{
						$.notify({
							message: "Error save Transaction, error :"+data.error
						},{
							type: 'danger',
							delay: 4000,
						});
						set_focus("#txtidmul");
					}
				}else if(data.crud == 'E'){
					if(data.result == 1){
						$.notify('Update Transaction successfuly');
						var table = $('#table_mul').DataTable(); 
						table.ajax.reload( null, false );
						$("#modalmastermul").modal("hide");
					}else{
						$.notify({
							message: "Error Transaction, error :"+data.error
						},{
							type: 'danger',
							delay: 4000,
						});					
						set_focus("#txtidmul");
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
			$("#btnsavemul").prop('disabled', false);
		}
	});
});
$(document).on( "click",".btndeletemul", function() {
	var id_mul = $(this).attr("id_mul");
	swal({   
		title: "Delete",   
		text: "Delete Transaction with id : "+id_mul+" ?",   
		type: "warning",   
		showCancelButton: true,   
		confirmButtonColor: "#DD6B55",   
		confirmButtonText: "Delete",   
		closeOnConfirm: true }, 
		function(){   
			var value = {
				id_mul: id_mul,
				method : "delete_mul"
			};
			$.ajax(
			{
				url : "c_mul.php",
				type: "POST",
				data : value,
				success: function(data, textStatus, jqXHR)
				{
					var data = jQuery.parseJSON(data);
					if(data.result ==1){
						$.notify('Delete Transaction successfuly');
						var table = $('#table_mul').DataTable(); 
						table.ajax.reload( null, false );
					}else{
						$.notify({
							message: "Error delete Transaction, error :"+data.error
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

