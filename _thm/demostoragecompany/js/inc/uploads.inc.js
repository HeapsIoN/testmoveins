// JavaScript Document


// Quick loader for Drag and Drop Media Uploader
function mediaUpload(filefield, uploadtype, call)
	{
	call = call!='' ? call : 'upload';
	
	$('#'+filefield).fileupload({
		url: '/ajax/'+ uploadtype +'/'+ call,
		dataType: 'json',
		dropZone: $('#'+filefield+'Dropzone'),
		send: function (e, data) {
			$('#'+ filefield +'Dropzone').slideUp(250);
			$('#'+ filefield +'Progress').slideDown(250);
			$('#'+ filefield +', #'+ filefield +'Title').val(null);
		},
		done: function (e, data) {
		$('#'+ filefield +'Progress .niceProgressBar').css('width', '0px');
		$('#'+ filefield +'Dropzone').slideDown(250);
		$('#'+ filefield +'Progress').slideUp(250);
		mediaUploadPost(data);				
		},
		progressall: function (e, data) {
			var progress = parseInt(data.loaded / data.total * 100, 10);
			$('#'+ filefield +'Progress .niceProgressBar').css(
				'width',
				progress + '%'
			);
		}
	})
	.prop('disabled', !$.support.fileInput)
	.parent().addClass($.support.fileInput ? undefined : 'disabled');	
	}

function mediaUploadPost(data)
	{
	// This is a placeholder function that can be overwritten 
	// inside an individual include file to have additional functionality
	
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
	}

function removeMedia(type, button, message, title, rows)
	{
	$('body').on('click', button, function(){
	
		$('#dialog').html(message);
		
		$('#dialog').dialog({
			resizable: false,
			height:200,
			width:400,
			modal: true,
			dialogClass: 'myDialog',
			title: title,
			buttons: 
				{
				'Yes Delete': function() {
					$('#dialog').dialog('close');
					$('#loading').show();				
					var postdata = {'id':$('#index').val(), 'filename':$(button).attr('my-file')};
					
					$.ajax({
						type: 'POST',
						url: '/ajax/'+ type +'/remove',
						data: postdata,
					}).done(function(data){
						removeMediaPost(data, rows);
						});	
				},
				"Cancel": function() {
					$('#dialog').dialog("close");
				}
			}});
		});	
	}

function removeMediaPost(data, hideme)
	{
	if(data.error)
		{
		displayResponse(data.error, 'error');
		}
	else if(data.success)
		{
		$(hideme).slideUp(250,0, function(){
			$(hideme).addClass('row-hdn').attr('style', null);
			});
		displayResponse(data.success, 'success');
		}	
	}