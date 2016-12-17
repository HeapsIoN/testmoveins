// JavaScript Document

// Content Editor

mediaUpload('companylogo', 'company', '');

mediaUpload('companyheader', 'company', 'emailheader');

mediaUpload('companyfooter', 'company', 'emailfooter');

function mediaUploadPost(data)
	{
	if(data.result.success)
		{
		displayResponse(data.result.success, 'success');
		}
	else if(data.result.error)
		{
		displayResponse(data.result.error, 'error');
		}
	else
		{
		displayResponse('An unknown error occurred.', 'error');
		}
	
	if(data.result.logo){$('#logo-row').html(data.result.logo);$('#del-logo-row').slideDown(350)}
	if(data.result.header){$('#header-row').html(data.result.header);$('#del-header-row').slideDown(350)}
	if(data.result.footer){$('#footer-row').html(data.result.footer);$('#del-footer-row').slideDown(350)}
	}

removeMedia('company', '.delete-photo', 'Are you sure you want to remove this company photo? This cannot be undone', 'Confirm Company Logo Delete', '.photo');

function removeMediaPost(data, hideme)
	{
	if(data.error)
		{
		displayResponse(data.error, 'error');
		}
	else if(data.success)
		{
		$('.active-delete').parent('.photo').slideUp(350, 0, function(){
			$(this).remove();
			});
		displayResponse(data.success, 'success');
		}	
	}


$('body').on('click', '.delete-img', function(){
	
	var t = $(this).attr('smp-form');
	
	
	if($('#dialog').length > 0)
		{
		$('#dialog').html('<p>Are you sure that you want to remove the '+t+' for the company?</p>');	
		}
	else
		{
		$('body').append('<div id="dialog"><p>Are you sure that you want to remove the '+t+' for the company?</p></div>');
		}
	
	$('#dialog').dialog({
			resizable: false,
			height:200,
			width:400,
			modal: true,
			dialogClass: 'myDialog',
			title: 'Confirm Company Image Delete',
			buttons: 
				{
				'Yes Delete': function() {
					$('#dialog').dialog('close');
					$('#loading').show();				
					$.ajax({
						type: 'POST',
						url: '/ajax/company/removeimg',
						data: {coid:$('#index').val(),type:t},
					}).done(function(data){
						
						if(data.success)
							{
							$('#'+t+'-row, #del-'+t+'-row').slideUp(350);
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