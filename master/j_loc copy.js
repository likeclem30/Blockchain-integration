$(document).ready( function () 
{
	money();
	decimal();
	var value = {
		method : "getdata"
	};
	$('#table_loc').DataTable({
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
			"url": "c_loc.php",
			"type": "POST",
			"data":value,
		},
		"columns": [
		{ "data": "urutan" },
		{ "data": "id_loc" },
		{ "data": "loc_name" },
		{ "data": "cood" },
		{ "data": "postal" },
		{ "data": "locality" },
		{ "data": "state" },
		{ "data": "country" },
		{ "data": "button" },
		]
	});
	$("#table_loc_filter").addClass("pull-right");
	
});

$(document).on( "click","#btnaddloc", function() {
	$(".contentharga").remove();
	$("#modalmasterloc").modal('show');
	newloc();
});
function newloc()
{
	$("#txtidloc").val("*New");
	$("#txtlocname").val("");
	$("#txtcood").val("");
	$("#txtpostal").change();
	$("#txtlocality").val("");
	$("#txtstate").val("");
	$("#txtcountry").val("");
	$("#inputcrud").val("N");
	set_focus("#txtlocname");
}
$(document).on( "click",".btneditloc", function() {
	var id_loc = $(this).attr("id_loc");
	var value = {
		id_loc: id_loc,
		method : "get_detail_loc"
	};
	$.ajax(
	{
		url : "c_loc.php",
		type: "POST",
		data : value,
		success: function(data, textStatus, jqXHR)
		{
			var hasil = jQuery.parseJSON(data);
			data = hasil.data;
			$("#inputcrud").val("E");
			$("#txtidloc").val(data.id_loc);
			$("#txtlocname").val($.trim(data.loc_name));
			$("#txtcood").val($.trim(data.cood));
			$("#txtpostal").val($.trim(data.postal));
			$("#txtlocality").val(data.locality);
			$("#txtstate").val(data.state);
			$("#txtcountry").val(data.country);
			$("#modalmasterloc").modal('show');
			set_focus("#txtlocname");
		},
		error: function(jqXHR, textStatus, errorThrown)
		{
		}
	});
});
$(document).on( "click","#btnsaveloc", function() {
	var id_loc = $("#txtidloc").val();
	var loc_name = $("#txtlocname").val();
	var cood = $("#txtcood").val();
	var postal = $("#txtpostal").val();
	var locality = $("#txtlocality").val();
	var state = $("#txtstate").val();
	var country = $("#txtcountry").val();
	var crud=$("#inputcrud").val();
	if(crud == 'E'){
		if(id_loc == '' || id_loc== null ){
			$.notify({
				message: "loc Id invalid"
			},{
				type: 'warning',
				delay: 4000,
			});		
			$("#txtidloc").focus();
			return;
		}	
	}
	if(loc_name == '' || loc_name== null ){
		$.notify({
			message: "Please fill out the loc name"
		},{
			type: 'warning',
			delay: 4000,
		});		
		$("#txtlocname").focus();
		return;
	}

	if(cood == '' || cood== null ){
		$.notify({
			message: "Please fill out location name"
		},{
			type: 'warning',
			delay: 4000,
		});		
		$("#txtcood").focus();
		return;
	}

	if(postal == '' || postal== null ){
		$.notify({
			message: "Please fill out location postal code "
		},{
			type: 'warning',
			delay: 4000,
		});		
		$("#txtpostal").focus();
		return;
	}

	if(locality == '' || locality == null ){
		$.notify({
			message: "Please fill out locality"
		},{
			type: 'warning',
			delay: 4000,
		});		
		$("#txtlocality").focus();
		return;
	}

	if(state == '' || state == null ){
		$.notify({
			message: "Please fill out state"
		},{
			type: 'warning',
			delay: 4000,
		});		
		$("#txtstate").focus();
		return;
	}

	if(country == '' || country== null ){
		$.notify({
			message: "Please fill out country"
		},{
			type: 'warning',
			delay: 4000,
		});		
		$("#txtcountry").focus();
		return;
	}

	

	var value = {
		id_loc: id_loc,
		loc_name:loc_name,
		cood    :cood,
		postal  :postal,
		locality:locality,
		state   :state,
		country :country,
		crud:crud,
		method : "save_loc"
	};
	$(this).prop('disabled', true);
	proccess_waiting("#infoproses");
	$.ajax(
	{
		url : "c_loc.php",
		type: "POST",
		data : value,
		success: function(data, textStatus, jqXHR)
		{
			$("#btnsaveloc").prop('disabled', false);
			$("#infoproses").html("");
			var data = jQuery.parseJSON(data);
			if(data.ceksat == 0){
				$.notify(data.error);
			}else{
				if(data.crud == 'N'){
					if(data.result == 1){
						$.notify('Save location successfuly');
						var table = $('#table_loc').DataTable(); 
						table.ajax.reload( null, false );
						newloc();				
					}else{
						$.notify({
							message: "Error save location, error :"+data.error
						},{
							type: 'danger',
							delay: 4000,
						});
						set_focus("#txtidloc");
					}
				}else if(data.crud == 'E'){
					if(data.result == 1){
						$.notify('Update location successfuly');
						var table = $('#table_loc').DataTable(); 
						table.ajax.reload( null, false );
						$("#modalmasterloc").modal("hide");
					}else{
						$.notify({
							message: "Error update location, error :"+data.error
						},{
							type: 'danger',
							delay: 4000,
						});					
						set_focus("#txtidloc");
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
			$("#btnsaveloc").prop('disabled', false);
		}
	});
});
$(document).on( "click",".btndeleteloc", function() {
	var id_loc = $(this).attr("id_loc");
	swal({   
		title: "Delete",   
		text: "Delete Produce location with id : "+id_loc+" ?",   
		type: "warning",   
		showCancelButton: true,   
		confirmButtonColor: "#DD6B55",   
		confirmButtonText: "Delete",   
		closeOnConfirm: true }, 
		function(){   
			var value = {
				id_loc: id_loc,
				method : "delete_loc"
			};
			$.ajax(
			{
				url : "c_loc.php",
				type: "POST",
				data : value,
				success: function(data, textStatus, jqXHR)
				{
					var data = jQuery.parseJSON(data);
					if(data.result ==1){
						$.notify('Delete location successfuly');
						var table = $('#table_loc').DataTable(); 
						table.ajax.reload( null, false );
					}else{
						$.notify({
							message: "Error delete location, error :"+data.error
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

