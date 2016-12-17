// JavaScript Document




$('body').on('click', '.unit-option', function(){
	var ucode = $(this).attr('storman-code'),
		urate = $(this).attr('storman-rate');
	$('#unitcode').val(ucode);
	$('#unitrate').val(urate);
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