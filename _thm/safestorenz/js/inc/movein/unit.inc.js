// JavaScript Document


$('.unit-msg').show();	


$('body').on('click', '.unit-option', function(){
	var ucode = $(this).attr('storman-code'),
		urate = $(this).attr('storman-rate'),
		udpst = $(this).attr('storman-deposit');
	$('#unitcode').val(ucode);
	$('#unitrate').val(urate);
	$('#unitdeposit').val(udpst);
	$('.storman-hdn').slideDown(350);
	$('.unit-option').removeClass('bg-7');
	$('.unit-data').removeClass('txt-1').addClass('txt-4');
	$(this).addClass('bg-7');	
	$(this).children('.unit-data').removeClass('txt-4').addClass('txt-1');
	});


$('body').on('click', '#continue', function(){
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
		url: '/ajax/movein/unit',
		data: postdata,
		}).done(function(data){
		ajaxPostActions(data, linkout);	
		});
	////////////////////////////////////////////
	});



$('#unitselection').autocomplete({
	source: function(request, response) {
		$.ajax({
			url: '/ajax/movein/unitfinder',
			data: {unitselection: request.term, unitcode: $('#unitcode').val()},
			success: function(data) {console.log(data);response(data);}
		});
	},
	minLength: 1,
	select: function( event, ui ) {
			if(ui.item.value=='-1')
				{$('#unitselection').val('').attr('matched', 0)}
			else
				{$('#unitselection').val(ui.item.value).attr('matched', 1);}
			return false;
	},
	open: function(event, ui) {
        $('.ui-autocomplete').off('menufocus hover mouseover mouseenter');
    }});

$('body').on('blur', '#unitselection', function(){
	if($(this).attr('matched')!='1'){$(this).val('')}
	});