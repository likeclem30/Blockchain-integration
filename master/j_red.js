$(document).ready( function () 
{

	$(document).on('change','#txtmsisdnred', function() {
		var wphonered_id = $(this).val();
		if(wphonered_id != "") {
			$.ajax({
				url:"c_red.php",
				type:'POST',
				data:{wphonered_id:wphonered_id},
				success:function(response) {
					//var resp = $.trim(response);
					if(response != '') {
						$("#txtoaddressred").removeAttr('disabled','disabled').html(response);
						
					} else {
						$("#txtoaddressred").attr('disabled','disabled').html("<option value=''>----- Select ---</option>");
					}
				}
			});
		} else {
			$("#txtoaddressred").attr('disabled','disabled').html("<option value=''>----- Select ------</option>");
		}
    });
    
    $(document).on('change','#txtoaddressred', function() {
		var b_addressred = $(this).val();
		if(b_addressred != "") {
			$.ajax({
				url:"c_red.php",
				type:'POST',
				data:{b_addressred:b_addressred},
				success:function(response) {
					//var resp = $.trim(response);
					if(response != '') {
						$("#txtoreceiptred").removeAttr('disabled','disabled').html(response);
						
					} else {
						$("#txtoreceiptred").attr('disabled','disabled').html("<option value=''>----- Select ---</option>");
					}
				}
			});
		} else {
			$("#txtoreceiptred").attr('disabled','disabled').html("<option value=''>----- Select ------</option>");
		}
	});


    $(document).on('change','#fartxtmsisdnred', function() {
		var farwphonered_id = $(this).val();
		if(farwphonered_id != "") {
			$.ajax({
				url:"c_red.php",
				type:'POST',
				data:{farwphonered_id:farwphonered_id},
				success:function(response) {
					//var resp = $.trim(response);
					if(response != '') {
						$("#fartxtaddressred").removeAttr('disabled','disabled').html(response);
						
					} else {
						$("#fartxtaddressred").attr('disabled','disabled').html("<option value=''>----- Select ---</option>");
					}
				}
			});
		} else {
			$("#fartxtaddressred").attr('disabled','disabled').html("<option value=''>----- Select ------</option>");
		}
    });







	money();
	decimal();
	var value = {
		method : "getdata"
	};
	$('#table_red').DataTable({
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
			"url": "c_red.php",
			"type": "POST",
			"data":value,
		},
		"columns": [
		{ "data": "urutan" },
		{ "data": "id_red" },
		{ "data": "red_name" },
		{ "data": "msisdnred" },
		{ "data": "farmsisdnred" },	
		{ "data": "outred" },
		{ "data": "date_created" },
		{ "data": "button" },
		]
	});
	$("#table_red_filter").addClass("pull-right");
});

$(document).on( "click","#btnaddred", function() {
	$(".contentharga").remove();
	$("#modalmasterred").modal('show');
	newred();
});
function newred()
{
	$("#txtidred").val("*New");
	$("#txtredname").val("");
	$("#txtmsisdnred").val("");
	$("#txtoaddressred").val("");
	$("#txtoreceiptred").val("");
	$("#fartxtmsisdnred").val("");
	$("#fartxtaddressred").val("");
	$("#txtpassred").val("");
	
	$("#inputcrud").val("N");
	set_focus("#txtredname");
}
$(document).on( "click",".btneditred", function() {
	var id_red = $(this).attr("id_red");
	var value = {
		id_red: id_red,
		method : "get_detail_red"
	};
	$.ajax(
	{
		url : "c_red.php",
		type: "POST",
		data : value,
		success: function(data, textStatus, jqXHR)
		{
			var hasil = jQuery.parseJSON(data);
			data = hasil.data;
			$("#inputcrud").val("E");
			$("#txtidred").val(data.id_red);
			$("#txtredname").val(data.red_name);
			$("#txtmsisdnred").val(data.msisdnred);
			$("#txtoaddressred").val(data.oaddressred);
			$("#fartxtmsisdnred").val(data.farmsisdnred);
			$("#fartxtaddressred").val(data.faraddressred);
			$("#txtoreceiptred").val(data.oreceiptred);
			$("#txtpassred").val(data.passred);
			$("#modalmasterred").modal('show');
			set_focus("#txtredname");
		},
		error: function(jqXHR, textStatus, errorThrown)
		{
		}
	});
});
$(document).on( "click","#btnsavered", function() {
	var id_red = $("#txtidred").val();
	var red_name = $("#txtredname").val();
	var msisdnred = $("#txtmsisdnred").val();
	var oaddressred = $("#txtoaddressred").val();
	var farmsisdnred = $("#fartxtmsisdnred").val();
	var faraddressred = $("#fartxtaddressred").val();
	var passred = $("#txtpassred").val();
	var oreceiptred = $("#txtoreceiptred").val();
	
	
	var crud=$("#inputcrud").val();
	if(crud == 'E'){
		if(id_red == '' || id_red== null ){
			$.notify({
				message: "receipt  Id invalid"
			},{
				type: 'warning',
				delay: 4000,
			});		
			$("#txtidred").focus();
			return;
		}	
	}
	if(red_name == '' || red_name== null ){
		$.notify({
			message: "Please fill out the Receipts fartification Title"
		},{
			type: 'warning',
			delay: 4000,
		});		
		$("#txtredname").focus();
		return;
	}
	if(msisdnred == '' || msisdnred== null ){
		$.notify({
			message: "Please fill out the CCB/Buyer MSISDN"
		},{
			type: 'warning',
			delay: 4000,
		});		
		$("#txtmsisdnred").focus();
		return;
	}
	if(oaddressred == '' || oaddressred== null ){
		$.notify({
			message: "Please fill out the CCB/Buyer Order Address"
		},{
			type: 'warning',
			delay: 4000,
		});		
		$("#txtoaddressred").focus();
		return;
	}

	if(oreceiptred == '' || oreceiptred== null ){
		$.notify({
			message: "Please fill out the CCB/Buyer Order Receipt"
		},{
			type: 'warning',
			delay: 4000,
		});		
		$("#txtoreceiptred").focus();
		return;
	}

	
	if(farmsisdnred == '' || farmsisdnred== null ){
		$.notify({
			message: "Please fill out the farTaker MSISDN"
		},{
			type: 'warning',
			delay: 4000,
		});		
		$("#fartxtmsisdnred").focus();
		return;
	}
	if(faraddressred == '' || faraddressred== null ){
		$.notify({
			message: "Please fill out the farTaker Address"
		},{
			type: 'warning',
			delay: 4000,
		});		
		$("#fartxtaddressred").focus();
		return;
	}

	if(passred == '' || passred== null ){
		$.notify({
			message: "Please fill out the farTaker Password"
		},{
			type: 'warning',
			delay: 4000,
		});		
		$("#txtpassred").focus();
		return;
	}
	
	
	
	

	var value = {

	id_red         :id_red ,
	red_name        :red_name,
	msisdnred      :msisdnred,
	oaddressred    :oaddressred,
	farmsisdnred   :farmsisdnred,
	faraddressred  :faraddressred,
	passred        :passred,
	oreceiptred       :oreceiptred,
			
		crud:crud,
		method : "save_red"
	};
	$(this).prop('disabled', true);
	proccess_waiting("#infoprosesred");
	$.ajax(
	{
		url : "c_red.php",
		type: "POST",
		data : value,
		success: function(data, textStatus, jqXHR)
		{
			$("#btnsavered").prop('disabled', false);
			$("#infoprosesred").html("");
			var data = jQuery.parseJSON(data);
			if(data.ceksat == 0){
				$.notify(data.error);
			}else{
				if(data.crud == 'N'){
					if(data.result == 1){
						$.notify('Save Receipt successfuly');
						var table = $('#table_red').DataTable(); 
						table.ajax.reload( null, false );
						newred();				
					}else{
						$.notify({
							message: "Error save Receipt, error :"+data.error
						},{
							type: 'danger',
							delay: 4000,
						});
						set_focus("#txtidred");
					}
				}else if(data.crud == 'E'){
					if(data.result == 1){
						$.notify('Update Receipt successfuly');
						var table = $('#table_red').DataTable(); 
						table.ajax.reload( null, false );
						$("#modalmasterred").modal("hide");
					}else{
						$.notify({
							message: "Error update Receipt, error :"+data.error
						},{
							type: 'danger',
							delay: 4000,
						});					
						set_focus("#txtidred");
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
			$("#btnsavered").prop('disabled', false);
		}
	});
});
$(document).on( "click",".btndeletered", function() {
	var id_red = $(this).attr("id_red");
	swal({   
		title: "Delete",   
		text: "Delete Receipt with id : "+id_red+" ?",   
		type: "warning",   
		showCancelButton: true,   
		confirmButtonColor: "#DD6B55",   
		confirmButtonText: "Delete",   
		closeOnConfirm: true }, 
		function(){   
			var value = {
				id_red: id_red,
				method : "delete_red"
			};
			$.ajax(
			{
				url : "c_red.php",
				type: "POST",
				data : value,
				success: function(data, textStatus, jqXHR)
				{
					var data = jQuery.parseJSON(data);
					if(data.result ==1){
						$.notify('Delete Receipt successfuly');
						var table = $('#table_red').DataTable(); 
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

