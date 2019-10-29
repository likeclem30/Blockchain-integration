


$(document).ready( function () 
{
	$(document).on('change','#txtmsisdncur', function() {
		var wphone1_id2 = $(this).val();
		if(wphone1_id2 != "") {
			$.ajax({
				url:"c_cur.php",
				type:'POST',
				data:{wphone1_id2:wphone1_id2},
				success:function(response) {
					//var resp = $.trim(response);
					if(response != '') {
						$("#txtaddresscur").removeAttr('disabled','disabled').html(response);
						
					} else {
						$("#txtaddresscur").attr('disabled','disabled').html("<option value=''>----- Select ---</option>");
					}
				}
			});
		} else {
			$("#txtaddresscur").attr('disabled','disabled').html("<option value=''>----- Select ------</option>");
		}
	});
	
	
	money();
	decimal();
	var value = {
		method : "getdata"
	};
	
	var t_type = $("#divid").val();
    

	$('#table_cur').DataTable({

		"paging": true,
		"lengthChange": false,
		"oSearch": {'sSearch': t_type},
		"searching":true,
		"bFilter": true,

		"ordering": true,
		"info": true,
		"responsive": true,
		"autoWidth": true,
		"pageLength": 3,
		"dom": '<"top"f>rtip',
		"ajax": {
			"url": "c_cur.php",
			"type": "POST",
			"data":value,
		},
		"columns": [
		{ "data": "urutan" },
		{ "data": "id_cur" },
		{ "data": "cur_name" },
		{ "data": "transaction_type" },
		{ "data": "currency_type" },
		{ "data": "amount" },
       
		{ "data": "msisdncur" },
		{ "data": "transaction_id" },
		{ "data": "button" },
		]
	});
	$("#table_cur_filter").addClass("pull-right");
	
});

$(document).on( "click","#btnaddcur", function() {
	$(".contentharga").remove();
	$("#modalmastercur").modal('show');
	newcur();
});
function newcur()
{
	$("#txtidcur").val("*New");
	$("#txtcurname").val("");
	$("#txttctycur").val("");
	$("#txtctycur").val("");
	$("#txtcvalcur").val(0);
    $("#txtaddresscur").val("");
	$("#txtmsisdncur").val("");
	$("#txtpasscur").val("");
	$("#inputcrud").val("N");
	set_focus("#txtcurname");

	
}
$(document).on( "click",".btneditcur", function() {
	var id_cur = $(this).attr("id_cur");
	var value = {
		id_cur: id_cur,
		method : "get_detail_cur"
	};
	$.ajax(
	{
		url : "c_cur.php",
		type: "POST",
		data : value,
		success: function(data, textStatus, jqXHR)
		{
			var hasil = jQuery.parseJSON(data);
			data = hasil.data;
			$("#inputcrud").val("E");
			$("#txtidcur").val(data.id_cur);
			$("#txtcurname").val(data.cur_name);
			$("#txttctycur").val(data.transaction_type);
            $("#txtctycur").val(data.currency_type);
			$("#txtcvalcur").val(addCommas(data.amount));
			$("#txtmsisdncur").val(data.msisdncur);
            $("#txtaddresscur").val(data.addresscur);
            $("#txtpasscur").val(data.frowpwcur);
			$("#modalmastercur").modal('show');
			set_focus("#txtcurname");
		},
		error: function(jqXHR, textStatus, errorThrown)
		{
		}
	});
});
$(document).on( "click","#btnsavecur", function() {
	var id_cur = $("#txtidcur").val();
	var cur_name = $("#txtcurname").val();
	var transaction_type = $("#txttctycur").val();
	var currency_type = $("#txtctycur").val();
	var amount = cleanString($("#txtcvalcur").val());
	var msisdncur = $("#txtmsisdncur").val();
    var addresscur = $("#txtaddresscur").val();
    var frompwcur = $("#txtpasscur").val();
	var crud=$("#inputcrud").val();
	if(crud == 'E'){
		if(id_cur == '' || id_cur== null ){
			$.notify({
				message: "Funding Id invalid"
			},{
				type: 'warning',
				delay: 4000,
			});		
			$("#txtidcur").focus();
			return;
		}	
	}
	if(cur_name == '' || cur_name== null ){
		$.notify({
			message: "Please fill out the Tran Title name"
		},{
			type: 'warning',
			delay: 4000,
		});		
		$("#txtcurname").focus();
		return;
	}

	if(transaction_type == '' || transaction_type == null ){
		$.notify({
			message: "Please fill out Transaction type"
		},{
			type: 'warning',
			delay: 4000,
		});		
		$("#txttctycur").focus();
		return;
	}

	if((currency_type == ' ' || currency_type == null )&&(transaction_type !=='addmulaaccount' || transaction_type !=='removemulaaccount')){
		$.notify({
			message: "Please fill out currency type"
		},{
			type: 'warning',
			delay: 4000,
		});		
		$("#txtctycur").focus();
		return;
	}

	if((transaction_type == 'buymula' || transaction_type == 'buymulafor' || transaction_type == 'sellmula' || transaction_type == 'sellmulafor' || transaction_type == 'importtoken' || transaction_type == 'exporttoken' ) && (currency_type == 'mula' )){
		$.notify({
			message: "You can not perform this Transaction type if the Currency is Mula,Change Currency to Naira/Dollar"
		},{
			type: 'warning',
			delay: 8000,
		});		
		$("#txttctycur").focus();
		return;
	}

	if((amount == ' ' || amount== null )&&(transaction_type !=='addmulaaccount' || transaction_type !=='removemulaaccount')){
		$.notify({
			message: "Please fill out amount "
		},{
			type: 'warning',
			delay: 4000,
		});		
		$("#txtcvalcur").focus();
		return;
	}
	if(msisdncur == '' || msisdncur== null ){
		$.notify({
			message: "Please fill wallet number "
		},{
			type: 'warning',
			delay: 4000,
		});		
		$("#txtmsisdncur").focus();
		return;
	}

   if(addresscur == '' || addresscur== null ){
		$.notify({
			message: "Please fill out block address "
		},{
			type: 'warning',
			delay: 4000,
		});		
		$("#txtaddresscur").focus();
		return;
	}

	if(frompwcur == '' || frompwcur== null ){
		$.notify({
			message: "Please fill out block password "
		},{
			type: 'warning',
			delay: 4000,
		});		
		$("#txtaddresscur").focus();
		return;
	}
	
    

	var value = {
		       id_cur: id_cur,
			 cur_name: cur_name,
		transaction_type:transaction_type,	 
		currency_type:currency_type,
		    amount:amount,
        addresscur:addresscur,
		msisdncur:msisdncur,
		frompwcur:frompwcur,
		crud:crud,
		method : "save_cur"
	};
	$(this).prop('disabled', true);
	proccess_waiting("#infoprosescur");
	$.ajax(
	{
		url : "c_cur.php",
		type: "POST",
		data : value,
		success: function(data, textStatus, jqXHR)
		{
			$("#btnsavecur").prop('disabled', false);
			$("#infoprosescur").html("");
			var data = jQuery.parseJSON(data);
			if(data.ceksat == 0){
				$.notify(data.error);
			}else{
				if(data.crud == 'N'){
					if(data.result == 1){
						$.notify('Save funding successfuly');
						var table = $('#table_cur').DataTable(); 
						table.ajax.reload( null, false );
						newcur();				
					}else{
						$.notify({
							message: "Error save funding, error :"+data.error
						},{
							type: 'danger',
							delay: 4000,
						});
						set_focus("#txtidcur");
					}
				}else if(data.crud == 'E'){
					if(data.result == 1){
						$.notify('Update funding successfuly');
						var table = $('#table_cur').DataTable(); 
						table.ajax.reload( null, false );
						$("#modalmastercur").modal("hide");
					}else{
						$.notify({
							message: "Error update funding, error :"+data.error
						},{
							type: 'danger',
							delay: 4000,
						});					
						set_focus("#txtidcur");
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
			$("#btnsavecur").prop('disabled', false);
		}
	});
});
$(document).on( "click",".btndeletecur", function() {
	var id_cur = $(this).attr("id_cur");
	swal({   
		title: "Delete",   
		text: "Delete funding with id : "+id_cur+" ?",   
		type: "warning",   
		showCancelButton: true,   
		confirmButtonColor: "#DD6B55",   
		confirmButtonText: "Delete",   
		closeOnConfirm: true }, 
		function(){   
			var value = {
				id_cur: id_cur,
				method : "delete_cur"
			};
			$.ajax(
			{
				url : "c_cur.php",
				type: "POST",
				data : value,
				success: function(data, textStatus, jqXHR)
				{
					var data = jQuery.parseJSON(data);
					if(data.result ==1){
						$.notify('Delete funding successfuly');
						var table = $('#table_cur').DataTable(); 
						table.ajax.reload( null, false );
					}else{
						$.notify({
							message: "Error delete funding, error :"+data.error
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

