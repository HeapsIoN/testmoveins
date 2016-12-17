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


$('body').on('click', '.delete-img', function(){
	
	if($('#dialog').length > 0)
		{
		$('#dialog').html('<p>Are you sure that you want to remove the image for the unit?</p>');	
		}
	else
		{
		$('body').append('<div id="dialog"><p>Are you sure that you want to remove the image for the unit?</p></div>');
		}
	
	$('#dialog').dialog({
			resizable: false,
			height:200,
			width:400,
			modal: true,
			dialogClass: 'myDialog',
			title: 'Confirm Unit Image Delete',
			buttons: 
				{
				'Yes Delete': function() {
					$('#dialog').dialog('close');
					$('#loading').show();				
					$.ajax({
						type: 'POST',
						url: '/ajax/unit/removeimg',
						data: {unid:$('#index').val()},
					}).done(function(data){
						
						if(data.success)
							{
							$('#img-row, #del-img-row').slideUp(350);
							displayResponse(data.success, 'success');
							}
						else if(data.error)
							{
							displayResponse(data.error, 'error');	
							}
						else
							{
							displayResponse('Unknown error', 'unknown');		
							}
						
						});	
				},
				"Cancel": function() {
					$('#dialog').dialog("close");
				}
			}});
	
	});


function mediaUploadPost(data)
	{
	if(data.result.success)
		{
		displayResponse(data.result.success, 'success');
		
		if(data.result.path)
			{
			$('#unit-image').fadeOut(250,0,function(){
				$('#unit-image').attr('src', data.result.path).fadeIn(250);
				$('#img-row, #del-img-row').slideDown(350);
				});	
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