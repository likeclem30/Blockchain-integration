


$(document).ready( function () 
{
	$(document).on('change','#txtmsisdncur', function() {
		var wphone = $(this).val();
		if(wphone != "") {
			$.ajax({
				url:"c_cur.php",
				type:'POST',
				data:{wphone:wphone},
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
	$('#table_cur').DataTable({
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
			"url": "c_cur.php",
			"type": "POST",
			"data":value,
		},
		"columns": [
		{ "data": "urutan" },
		{ "data": "id_cur" },
		{ "data": "cur_name" },
		{ "data": "currency_type" },
		{ "data": "amount" },
        { "data": "addresscur" },
        { "data": "msisdncur" },
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
	$("#txtcty").val("");
	$("#txtcval").val(0);
    $("#txtaddresscur").val("");
    $("#txtmsisdncur").val("");
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
            $("#txtcty").val(data.currency_type);
			$("#txtcval").val(addCommas(data.amount));
            $("#txtaddresscur").val(data.addresscur);
            $("#txtmsisdncur").val(data.msisdncur);
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
	var currency_type = $("#txtcty").val();
	var amount = cleanString($("#txtcval").val());
    var addresscur = $("#txtaddresscur").val();
    var msisdncur = $("#txtmsisdncur").val();
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

	if(currency_type == '' || currency_type== null ){
		$.notify({
			message: "Please fill out currency type"
		},{
			type: 'warning',
			delay: 4000,
		});		
		$("#txtcty").focus();
		return;
	}

	if(amount == '' || amount== 0 ){
		$.notify({
			message: "Please fill out amount "
		},{
			type: 'warning',
			delay: 4000,
		});		
		$("#txtcval").focus();
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

	var value = {
		       id_cur: id_cur,
		     cur_name: cur_name,
		currency_type:currency_type,
		    amount:amount,
        addresscur:addresscur,
        msisdncur:msisdncur,
		crud:crud,
		method : "save_cur"
	};
	$(this).prop('disabled', true);
	proccess_waiting("#infoproses");
	$.ajax(
	{
		url : "c_cur.php",
		type: "POST",
		data : value,
		success: function(data, textStatus, jqXHR)
		{
			$("#btnsavecur").prop('disabled', false);
			$("#infoproses").html("");
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

