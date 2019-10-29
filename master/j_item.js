

$(document).ready( function () 
{
	

	money();
	decimal();
	var value = {
		method : "getdata"
	};
	$('#table_item').DataTable({
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
			"url": "c_item.php",
			"type": "POST",
			"data":value,
		},
		"columns": [
		{ "data": "urutan" },
		{ "data": "id_item" },
		{ "data": "item_name" },
		
		{ "data": "price" },
		{ "data": "fprice" },
		{ "data": "stock" },
		{ "data": "terms" },
		{ "data": "transaction_id" },
		{ "data": "button" },
		]
	});
	$("#table_item_filter").addClass("pull-right");
	
});

$(document).on( "click","#btnadditem", function() {
	$(".contentharga").remove();
	$("#modalmasteritem").modal('show');
	newitem();
});
function newitem()
{
	$("#txtiditem").val("*New");
	$("#txtname").val("");
	$("#txtindexloc").val("");
	$("#txtunit").change();
	$("#txtstock").val(0);
	$("#txtterms").val(0);
	$("#txtprice").val(0);
	$("#txtfprice").val(0);
	$("#txtnote").val("");
	$("#inputcrud").val("N");
	set_focus("#txtname");
}
$(document).on( "click",".btnedititem", function() {
	var id_item = $(this).attr("id_item");
	var value = {
		id_item: id_item,
		method : "get_detail_item"
	};
	$.ajax(
	{
		url : "c_item.php",
		type: "POST",
		data : value,
		success: function(data, textStatus, jqXHR)
		{
			var hasil = jQuery.parseJSON(data);
			data = hasil.data;
			$("#inputcrud").val("E");
			$("#txtiditem").val(data.id_item);
			$("#txtname").val($.trim(data.item_name));
			$("#txtindexloc").val($.trim(data.loci));
			$("#txtunit").val($.trim(data.unit));
			$("#txtstock").val(data.stock);
			$("#txtterms").val(data.terms);
			$("#txtprice").val(addCommas(data.price));
			$("#txtfprice").val(addCommas(data.fprice));
			$("#txtnote").val($.trim(data.note));
			$("#modalmasteritem").modal('show');
			set_focus("#txtname");
		},
		error: function(jqXHR, textStatus, errorThrown)
		{
		}
	});
});
$(document).on( "click","#btnsaveitem", function() {
	var id_item = $("#txtiditem").val();
	var item_name = $("#txtname").val();
	var loci = $("#txtindexloc").val();
	var unit = $("#txtunit").val();
	var stock = cleanString($("#txtstock").val());
	var terms = cleanString($("#txtterms").val());
	var price = cleanString($("#txtprice").val());
	var fprice = cleanString($("#txtfprice").val());
	var note = $("#txtnote").val();
	var crud=$("#inputcrud").val();
	if(crud == 'E'){
		if(id_item == '' || id_item== null ){
			$.notify({
				message: "Item Id invalid"
			},{
				type: 'warning',
				delay: 4000,
			});		
			$("#txtiditem").focus();
			return;
		}	
	}
	if(item_name == '' || item_name== null ){
		$.notify({
			message: "Please fill out the item name"
		},{
			type: 'warning',
			delay: 4000,
		});		
		$("#txtname").focus();
		return;
	}
if(loci == '' || loci== null ){
		$.notify({
			message: "Please fill out location index"
		},{
			type: 'warning',
			delay: 4000,
		});		
		$("#txtindexloc").focus();
		return;
	}

	if(stock == '' || stock== 0 ){
		$.notify({
			message: "Please fill out item Stock"
		},{
			type: 'warning',
			delay: 4000,
		});		
		$("#txtstock").focus();
		return;
	}

	if(unit == '' || unit== null ){
		$.notify({
			message: "Please fill out item unit of Measurement"
		},{
			type: 'warning',
			delay: 4000,
		});		
		$("#txtunit").focus();
		return;
	}

	

	if(terms == '' || terms== 0 ){
		$.notify({
			message: "Please fill out item terms"
		},{
			type: 'warning',
			delay: 4000,
		});		
		$("#txtterms").focus();
		return;
	}

	if(price == '' || price== 0 ){
		$.notify({
			message: "Please fill out item Ware house price"
		},{
			type: 'warning',
			delay: 4000,
		});		
		$("#txtprice").focus();
		return;
	}

	if(fprice == '' || fprice== 0 ){
		$.notify({
			message: "Please fill out item Farm price"
		},{
			type: 'warning',
			delay: 4000,
		});		
		$("#txtfprice").focus();
		return;
	}

	var value = {
		id_item: id_item,
		item_name: item_name,
		loci:loci,
		unit:unit,
		stock:stock,
		terms:terms,
		price:price,
		fprice:fprice,
		note:note,
		crud:crud,
		method : "save_item"
	};
	$(this).prop('disabled', true);
	proccess_waiting("#infoprosescom");
	$.ajax(
	{
		url : "c_item.php",
		type: "POST",
		data : value,
		success: function(data, textStatus, jqXHR)
		{
			$("#btnsaveitem").prop('disabled', false);
			$("#infoprosescom").html("");
			var data = jQuery.parseJSON(data);
			if(data.ceksat == 0){
				$.notify(data.error);
			}else{
				if(data.crud == 'N'){
					if(data.result == 1){
						$.notify('Save item successfuly');
						var table = $('#table_item').DataTable(); 
						table.ajax.reload( null, false );
						newitem();				
					}else{
						$.notify({
							message: "Error save item, error :"+data.error
						},{
							type: 'danger',
							delay: 8000,
						});
						set_focus("#txtiditem");
					}
				}else if(data.crud == 'E'){
					if(data.result == 1){
						$.notify('Update item successfuly');
						var table = $('#table_item').DataTable(); 
						table.ajax.reload( null, false );
						$("#modalmasteritem").modal("hide");
					}else{
						$.notify({
							message: "Error update item, error :"+data.error
						},{
							type: 'danger',
							delay: 8000,
						});					
						set_focus("#txtiditem");
					}
				}else{
					$.notify({
						message: "Invalid request"
					},{
						type: 'danger',
						delay: 8000,
					});	
				}
			}
		},
		error: function(jqXHR, textStatus, errorThrown)
		{
			$("#btnsaveitem").prop('disabled', false);
		}
	});
});
$(document).on( "click",".btndeleteitem", function() {
	var id_item = $(this).attr("id_item");
	swal({   
		title: "Delete",   
		text: "Delete Produce item with id : "+id_item+" ?",   
		type: "warning",   
		showCancelButton: true,   
		confirmButtonColor: "#DD6B55",   
		confirmButtonText: "Delete",   
		closeOnConfirm: true }, 
		function(){   
			var value = {
				id_item: id_item,
				method : "delete_item"
			};
			$.ajax(
			{
				url : "c_item.php",
				type: "POST",
				data : value,
				success: function(data, textStatus, jqXHR)
				{
					var data = jQuery.parseJSON(data);
					if(data.result ==1){
						$.notify('Delete item successfuly');
						var table = $('#table_item').DataTable(); 
						table.ajax.reload( null, false );
					}else{
						$.notify({
							message: "Error delete item, error :"+data.error
						},{
							type: 'eror',
							delay: 8000,
						});	
					}
				},
				error: function(jqXHR, textStatus, errorThrown)
				{
				}
			});
		});
});

