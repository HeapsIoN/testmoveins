// JavaScript Document

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
		content_css : "/_theme/_admin/css/editor.css?" + new Date().getTime(),
		plugins: [
			"advlist autolink lists link image charmap print preview hr anchor pagebreak",
			"searchreplace wordcount visualblocks visualchars code fullscreen",
			"insertdatetime media nonbreaking save table contextmenu directionality",
			"emoticons template paste textcolor colorpicker textpattern"
		],
		// Toolbar
		toolbar1: "undo redo removeformat | styleselect | bold italic underline | alignleft aligncenter alignright alignjustify bullist numlist | outdent indent | link | code",
		
		// Fonts / Styles
		fontsize_formats: "10px 12px 14px 16px 18px 22px",
		
		style_formats: [
			{title: "Text Colours", items: [
				
				{title: 'Black Text', inline: 'span', classes: 'txt-black'},
				
				{title: 'Theme Colour 1', inline: 'span', classes: 'txt-1'},
				{title: 'Theme Colour 2', inline: 'span', classes: 'txt-2'},
				{title: 'Theme Colour 3', inline: 'span', classes: 'txt-3'},
				{title: 'Theme Colour 4', inline: 'span', classes: 'txt-4'},
				{title: 'Theme Colour 5', inline: 'span', classes: 'txt-5'},
				{title: 'Theme Colour 6', inline: 'span', classes: 'txt-6'}				
			]},
			{title: "Text Hover Colours", items: [
				
				{title: 'Black Text', inline: 'span', classes: 'txt-black'},
				
				{title: 'Theme Colour 1', inline: 'span', classes: 'txt-1-hover'},
				{title: 'Theme Colour 2', inline: 'span', classes: 'txt-2-hover'},
				{title: 'Theme Colour 3', inline: 'span', classes: 'txt-3-hover'},
				{title: 'Theme Colour 4', inline: 'span', classes: 'txt-4-hover'},
				{title: 'Theme Colour 5', inline: 'span', classes: 'txt-5-hover'},
				{title: 'Theme Colour 6', inline: 'span', classes: 'txt-6-hover'}				
			]},
			
			{title: "Coloured Buttons", items: [
				
				{title: 'Theme Colour 1', inline: 'span', classes: 'bg-1'},
				{title: 'Theme Colour 2', inline: 'span', classes: 'bg-2'},
				{title: 'Theme Colour 3', inline: 'span', classes: 'bg-3'},
				{title: 'Theme Colour 4', inline: 'span', classes: 'bg-4'},
				{title: 'Theme Colour 5', inline: 'span', classes: 'bg-5'},
				{title: 'Theme Colour 6', inline: 'span', classes: 'bg-6'}
				
			]},
			
			{title: "Coloured Buttons Hover State", items: [
				
				{title: 'Theme Colour 1', inline: 'span', classes: 'bg-1-hover'},
				{title: 'Theme Colour 2', inline: 'span', classes: 'bg-2-hover'},
				{title: 'Theme Colour 3', inline: 'span', classes: 'bg-3-hover'},
				{title: 'Theme Colour 4', inline: 'span', classes: 'bg-4-hover'},
				{title: 'Theme Colour 5', inline: 'span', classes: 'bg-5-hover'},
				{title: 'Theme Colour 6', inline: 'span', classes: 'bg-6-hover'}
				
			]},
			
			{title: "Common HTML Headers", items: [
				{title: "Sub-Heading (H2)", format: "h2"},
				{title: "Small Heading (H3)", format: "h3"}
			]}			
		]
	});
	}