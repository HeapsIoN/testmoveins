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
	
	if(data.result.logo){$('#logo-row').html(data.result.logo)}
	if(data.result.header){$('#eheader-row').html(data.result.header)}
	if(data.result.footer){$('#efooter-row').html(data.result.footer)}
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