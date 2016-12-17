// Facility Selection


$('#facility').autocomplete({
	source: function(request, response) {
		$.ajax({
			url: '/ajax/movein/finder',
			dataType: "json",
			data: {term : request.term},
			success: function(data) {response(data);}
		});
	},
	minLength: 2,
	select: function( event, ui ) {
			$('#facilitycode').val(ui.item.id);
			$('#facility').val(ui.item.label);
			$('#facility-continue').slideDown(350);
			return false;
	},
	open: function(event, ui) {
        $('.ui-autocomplete').off('menufocus hover mouseover mouseenter');
    }});

$('body').on('change', '#facility', function(){
	if($(this).val()==null || $(this).val()==''){$('#facilitycode').val('');$('#facility-continue').slideUp(350);}
	});

////////////////////////////////////////////
// AJAX Form Processing
$('body').on('click', '#setfacility', function(){
	////////////////////////////////////////////
	showLoader();
	////////////////////////////////////////////
	$('#loading').show();
	////////////////////////////////////////////
	var linkout 	= $('#form').attr('action'),
		postdata 	= $('#form').serializeArray();
	////////////////////////////////////////////
	$.ajax({
		type: 'POST',
		url: '/ajax/movein/facility',
		data: postdata,
		}).done(function(data){
		if(data.success)
			{
			window.location.replace(linkout);
			}
		else if(data.error)
			{
			displayResponse(data.error, 'error');	
			}
		else
			{
			displayResponse('An unknown error occurred.', 'unknown');	
			}
			
		});
	////////////////////////////////////////////	
	});