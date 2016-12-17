// JavaScript Document

tinyMCELoader('facilitycompletedmessage');

mediaUpload('facilitylogo', 'facility', '');

mediaUpload('facilityheader', 'facility', 'emailheader');

mediaUpload('facilityfooter', 'facility', 'emailfooter');


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
	
	if(data.result.logo){$('#logo-row').html(data.result.logo).slideDown(350);$('#del-logo-row').slideDown(350)}
	if(data.result.header){$('#header-row').html(data.result.header).slideDown(350);$('#del-header-row').slideDown(350)}
	if(data.result.footer){$('#footer-row').html(data.result.footer).slideDown(350);$('#del-footer-row').slideDown(350)}
	}


$('#companyname').autocomplete({
	source: function(request, response) {
		$.ajax({
			url: '/ajax/company/autocomplete',
			dataType: "json",
			data: {term : request.term},
			success: function(data) {response(data);}
		});
	},
	minLength: 2,
	select: function( event, ui ) {
			$(this).val(ui.item.value);
			$('#coid').val(ui.item.id);
			$('#companyname').val(ui.item.label);
			return false;
	},
	open: function(event, ui) {
        $('.ui-autocomplete').off('menufocus hover mouseover mouseenter');
    }});

$('body').on('change', '#companyname', function(){
	if($(this).val()==null || $(this).val()==''){$('#coid').val('')}
	});

$('body').on('click', '#tb-btn-facility-reset', function(){
	
	////////////////////////////////////////////
	showLoader();
	ajaxPreActions();
	var fcid = $('#index').val();
	////////////////////////////////////////////
	$.ajax({
		type: 'POST',
		url: '/ajax/facility/resetpass',
		data: {fcid:fcid},
		}).done(function(data){
		if(data.error)
			{
			displayResponse(data.error, 'error');	
			}
		else if(data.success)
			{
			displayResponse(data.success, 'success');	
			}
		});
	////////////////////////////////////////////
	
	});


$('body').on('click', '#copy-units', function(){
	////////////////////////////////////////////
	showLoader();
	ajaxPreActions();
	////////////////////////////////////////////
	if(hasmce==2){tinymce.triggerSave();}
	////////////////////////////////////////////
	$('#loading').show();
	////////////////////////////////////////////
	var fcid 	= $('#index').val();
	////////////////////////////////////////////
	$.ajax({
		type: 'POST',
		url: '/ajax/unit/copy',
		data: {fcid:fcid},
		}).done(function(data){
		if(data.error)
			{
			displayResponse(data.error, 'error');	
			}
		else if(data.success)
			{
			displayResponse(data.success, 'success');	
			}
		});
	////////////////////////////////////////////	
	});


$('body').on('click', '.delete-img', function(){
	
	var t = $(this).attr('smp-form');
	
	
	if($('#dialog').length > 0)
		{
		$('#dialog').html('<p>Are you sure that you want to remove the '+t+' for the facility?</p>');	
		}
	else
		{
		$('body').append('<div id="dialog"><p>Are you sure that you want to remove the '+t+' for the facility?</p></div>');
		}
	
	$('#dialog').dialog({
			resizable: false,
			height:200,
			width:400,
			modal: true,
			dialogClass: 'myDialog',
			title: 'Confirm Facility Image Delete',
			buttons: 
				{
				'Yes Delete': function() {
					$('#dialog').dialog('close');
					$('#loading').show();				
					$.ajax({
						type: 'POST',
						url: '/ajax/facility/removeimg',
						data: {fcid:$('#index').val(),type:t},
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





// Quick loader for TinyMCE
function tinyMCELoader(fieldid)
	{
	hasmce = 2;
	tinymce.init({
		mode : "textareas",
		selector: "#"+fieldid,
		menubar : false,
		theme: "modern",
		width:940,
		height:400,
		link_title: true,
		document_base_url:'/',
		hidden_input: false,
		convert_urls: false,
		relative_urls: false,
		content_css : "/_theme/storman/css/editor.css?" + new Date().getTime(),
		plugins: [
			"advlist autolink lists link image charmap print preview hr anchor pagebreak",
			"searchreplace wordcount visualblocks visualchars code fullscreen",
			"insertdatetime media nonbreaking save table contextmenu directionality",
			"emoticons template paste textcolor colorpicker textpattern"
		],
		// Toolbar
		toolbar1: "undo redo removeformat | styleselect | fontsizeselect | bold italic underline | alignleft aligncenter alignright alignjustify bullist numlist | outdent indent | code",
		
		// Fonts / Styles
		fontsize_formats: "10px 12px 14px 16px 18px 22px",
		
		style_formats: [
			{title: "Text Colours", items: [
				{title: 'Colour 1', inline: 'span', classes: 'txt-1'},
				{title: 'Colour 2', inline: 'span', classes: 'txt-2'},
				{title: 'Colour 3', inline: 'span', classes: 'txt-3'},
				{title: 'Colour 4', inline: 'span', classes: 'txt-4'},
				{title: 'Colour 5', inline: 'span', classes: 'txt-5'},
				{title: 'Colour 6', inline: 'span', classes: 'txt-6'},
				]},
			{title: "Text Hover Colours", items: [
				{title: 'Colour 1', inline: 'span', classes: 'txt-1-hover'},
				{title: 'Colour 2', inline: 'span', classes: 'txt-2-hover'},
				{title: 'Colour 3', inline: 'span', classes: 'txt-3-hover'},
				{title: 'Colour 4', inline: 'span', classes: 'txt-4-hover'},
				{title: 'Colour 5', inline: 'span', classes: 'txt-5-hover'},
				{title: 'Colour 6', inline: 'span', classes: 'txt-6-hover'},
				]},			
			{title: "Common HTML Headers", items: [
				{title: "Header 2 (18px)", format: "h2"},
				{title: "Header 3 (16px)", format: "h3"}
			]}			
		]
	});
	}


function formPostUpdate(result)
	{
	if(result.facility)
		{
		$.each(result.facility, function(i,e){
			$('#'+i).val(e);
			});	
		}
	}