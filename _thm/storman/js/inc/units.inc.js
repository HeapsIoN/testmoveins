// JavaScript Document

tinyMCELoader('unitwebdesc');

mediaUpload('unitphoto', 'unit', '');

$('#facilityname').autocomplete({
	source: function(request, response) {
		$.ajax({
			url: '/ajax/facility/autocomplete',
			dataType: "json",
			data: {term : request.term},
			success: function(data) {response(data);}
		});
	},
	minLength: 2,
	select: function( event, ui ) {
			$(this).val(ui.item.value);
			$('#fcid').val(ui.item.id);
			$('#facilityname').val(ui.item.label);
			return false;
	},
	open: function(event, ui) {
        $('.ui-autocomplete').off('menufocus hover mouseover mouseenter');
    }});

$('body').on('change', '#facilityname', function(){
	if($(this).val()==null || $(this).val()==''){$('#fcid').val('')}
	});

$('body').on('click', '#tb-btn-facility-reset', function(){
	
	////////////////////////////////////////////
	showLoader();
	ajaxPreActions();
	////////////////////////////////////////////
	if(hasmce==2){tinymce.triggerSave();}
	////////////////////////////////////////////
	var fcid = $('#index').val();
	////////////////////////////////////////////
	$.ajax({
		type: 'POST',
		url: '/ajax/facility/resetpass',
		data: {fcid:fcid},
		}).done(function(data){
		ajaxPostActions(data, '');	
		});
	////////////////////////////////////////////
	
	});


function mediaUploadPost(data)
	{
	if(data.result.success)
		{
		displayResponse(data.result.success, 'success');
		
		if(data.path)
			{
			$('#unit-image').fadeOut(250,0,function(){$('#unit-image').attr('src', data.path).fadeIn(250)});	
			}
		}
	else if(data.result.error)
		{
		displayResponse(data.result.error, 'error');
		}
	else
		{
		displayResponse('An unknown error occurred.', 'error');
		}
	}