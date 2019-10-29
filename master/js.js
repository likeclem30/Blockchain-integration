$(document).on(function() {


	//Change in continent dropdown list will trigger this function and
	//generate dropdown options for county dropdown
	$(document).on('change','#txtmsisdncur', function() {
		var wphone = $(this).val();
		if(wphone != "") {
			$.ajax({
				url:"get_data.php",
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


});
