/**
 ************************************************************
 ************************************************************
 * 	jQuery NiceFields Handler
 *
 * 	Author:		Luke Pelgrave (http://lukepelgrave.com.au)
 * 	Version: 	2.0
 * 	Date:		11th May, 2015
 * 	Usage:		Use the fields class to output the required field on the page.
 *	License:	Licensed under MIT
 *
 ************************************************************
 ************************************************************
 *
 * 	Issues:		B02 - z-index issue when multiple select fields used on same page.
 *
 *	Fixes:		B02 - move list to an attr for parent, dynamically create as fixed to page position [To test]
 *
 ************************************************************
 ************************************************************
 *
 *	Hey buddy,
 *	
 *	If you are reading this, chances are you are a developer that wants to see how the form fields are
 *	being handled. This is a custom series of form controls that I've written and I haven't released
 *	a public version yet but I will be soon.
 *
 *	The thing to keep in mind with this is that it is not a set of jQuery functions you drop in which
 *	then changes things after the page is loaded. I hate the lag and delays you get from changing content
 *	in that respect, especially for public websites.
 *
 *	The JS and CSS work with a set layout and that layout can easily be copied from my source but I am bundling
 *	with source samples so you can take the templates and use them as you want.
 *
 *	In short, this set of form controls isn't built for someone looking for a quick solution to their form styling.
 *	This would however be of great use to people who are willing to edit the source form and then drop in these functions and the stylesheet.
 *	The way I use it is in a PHP framework and I have a class setup specifically for outputting the fields.
 *	I have a function for each field type and just pass in the field name and any options for the field (if applicable) and
 *	there you have it. A fast loading, server side initialised layout, with client side functions. Not a server side layout
 *	which is sent to the client which then get initialised with client functions and then has to shuffle the page. BAD!!!
 *
 *	Enjoy!
 *	Luke :P
 *
 ************************************************************
 ************************************************************
 *	The MIT License (MIT)
 *	
 *	Copyright (c) 2011-2015 Luke Pelgrave
 *	
 *	Permission is hereby granted, free of charge, to any person obtaining a copy
 *	of this software and associated documentation files (the "Software"), to deal
 *	in the Software without restriction, including without limitation the rights
 * 	to use, copy, modify, merge, publish, distribute, sublicense, and/or sell
 *	copies of the Software, and to permit persons to whom the Software is
 *	furnished to do so, subject to the following conditions:
 *	
 *	The above copyright notice and this permission notice shall be included in
 *	all copies or substantial portions of the Software.
 *	
 *	THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
 *	IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
 *	FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
 *	AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
 *	LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
 *	OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN
 *	THE SOFTWARE.
 ************************************************************
 ************************************************************
 */

$(document).ready(function() {

niceSelect();

niceToggle();

niceRadio();

niceCheckbox();

niceFileInput();

});


// Nice Select
function niceSelect()
	{
	$(document.body).on('click', function(){
		$('.nf-sel').each(function(){
			if($(this).attr('is-multi')!=1){$(this).children('.nf-sel-lst').slideUp(250);}
			});
		extraSelectChecks();
		});
		
	$('body').on('click', '.nf-sel-cur', function(e){
		
		$(this).parent('.nf-sel').children('.nf-sel-val').focus();
		
		if($(this).parent('.nf-sel').children('.nf-sel-lst').is(':visible'))
			{
			$(this).parent('.nf-sel').children('.nf-sel-lst').slideUp(250).after(function(){
				$(this).parent('.nf-sel').children('.nf-sel-val').focus();
				});
			}
		else
			{
			thisfield = $(this).parent('.nf-sel');
			$('.nf-sel-lst').not(this).parent('.nf-sel').children('.nf-sel-lst').slideUp(250);
			
			$(this).parent('.nf-sel').children('.nf-sel-val');
			$(this).parent('.nf-sel').children('.nf-sel-lst').slideDown(250).addClass('nf-sel-fcs');;
			e.stopPropagation();
			
			$('.nf-sel-opt').on('click', function(e){
				
				var thisopt = $(this);
				var newlbl = thisopt.attr('opt-lbl');
				var newval = thisopt.attr('opt-val');
				var thissel = thisopt.parent('.nf-sel-lst').parent('.nf-sel');
				
				if(thissel.hasClass('nf-sel-mlt') && e.ctrlKey)
					{
					thissel.attr('is-multi', 1);
					if(thisopt.hasClass('nf-sel-lbl'))
						{
						newval = newval.replace(','+newval, '');
						newlbl = newval.replace(','+newlbl, '');
						thisopt.removeClass('nf-sel-lbl');
						thissel.attr('is-multi', 1);
						thissel.attr('multi-val', newval);
						thissel.attr('multi-lbl', newlbl);	
						}
					else
						{
						thisopt.addClass('nf-sel-lbl');
						thissel.attr('is-multi', 1);
						thissel.attr('multi-val', thissel.attr('multi-val')+','+newval);
						thissel.attr('multi-lbl', thissel.attr('multi-lbl')+','+newlbl);
						}
					return true;
					}
				else
					{
					if(thissel.attr('is-multi')==1)
						{
						thisopt.addClass('nf-sel-lbl');
						newval = thissel.attr('multi-val')+','+newval;
						newlbl = '{ Multiple Selections }';
						}
					else
						{
						thisopt.parent('.nf-sel-lst').children('.nf-sel-opt').removeClass('nf-sel-lbl');
						thisopt.addClass('nf-sel-lbl');
						}
					
					thissel.attr('is-multi', null);
					
					thissel.children('.nf-sel-val').val(newval);
					thissel.children('.nf-sel-lst').slideUp(250).removeClass('nf-sel-fcs');
					thissel.children('.nf-sel-cur').html(newlbl+'<span class="nf-sel-arw fa fa-angle-down"></span>').after(function(){
							$(this).parent('.nf-sel').children('.nf-sel-val').focus();	
						});
					
					}
				
				
				});
			
			}
		extraSelectChecks();
		});
	
	
	$('.nf-sel-val').on('focus', function(){
		$(this).parent('.nf-sel').addClass('nf-fcs');
		});
	/*
	$('.nf-sel-val').on('blur', function(){
		$(this).parent('.nf-sel').removeClass('nf-fcs');
		$(this).parent('.nf-sel').children('.nf-sel-lst').slideUp(250).removeClass('nf-sel-fcs');
		if($(this).val()==null){$(this).val($(this).attr('my-val'));}
		});
	*/
	keyCommands();
	
	selectLoadingSelected();
	}

function keyCommands()
	{
	var searchKeys = {};
	
	$('body').on('keydown', '.nf-sel-val, .nf-sel-cur', function(e){
		
		searchKeys[e.keyCode] = true;
		var keycode 	= e.keyCode;
		var myfield 	= $(this);
		var curval 		= $(this).attr('my-val');
		var mykeys 		= $(this).val();
		var thislist 	= $(this).parent('.nf-sel').children('.nf-sel-lst');
		var mysearch 	= '';
		
		var newoption 	= '';
		var newval 		= '';
		var newlbl 		= '';
		var newidx 		= '';
		
		var action 		= 'next';
		
		var numpad = ['96','97','98','99','100','101','102','103','104','105'];
		
		// If an up or down arrow...
		if(keycode==38 || keycode==40)
			{
			if(curval=='' || curval==null)
				{
				if(keycode==38)
					{
					newoption = thislist.children('.nf-sel-opt').last();	
					}
				else
					{
					newoption = thislist.children('.nf-sel-opt:not(.nf-sel-emp)').first();	
					}
				}
			else
				{
				thislist.children('.nf-sel-opt').not('.nf-sel-emp').each(function(index)
					{
					if($(this).attr('opt-val')==curval)
						{
						if(keycode==38)
							{
							if($(this).prev('.nf-sel-opt').length > 0)
								{
								newoption = $(this).prev('.nf-sel-opt');
								}
							else
								{
								newoption = thislist.children('.nf-sel-opt:hidden').last();
								}
							}
						else
							{
							if($(this).next('.nf-sel-opt').length > 0)
								{
								newoption = $(this).next('.nf-sel-opt');
								}
							else
								{
								newoption = thislist.children('.nf-sel-opt').first();
								}
							}
						return false;
						}
					});
				}
			}
		// Otherwise search for a match
		else
			{
			$.each(searchKeys, function(index){
				if(keycode >= 96 && keycode <= 105)
					{
					mysearch += String.fromCharCode(index-48);	
					}
				else
					{
					mysearch += String.fromCharCode(index);
					}				
				});
			
			mysearch = mysearch.toLowerCase();
			
			var rowval = '';
			
			thislist.children('.nf-sel-opt').each(function(index, element)
				{				
				rowval = $(this).attr('opt-lbl').toLowerCase();
				
				//console.log(rowval);
				
				if(mysearch.length==1){rowval = rowval.substring(0,1);}
				
				if(rowval.indexOf(mysearch) >=0)
					{
					newoption = $(this);
					return false;
					}
				});
			}
		
		if(newoption!='')
			{
			thislist.children('.nf-sel-lbl').removeClass('nf-sel-lbl').after(function(){
				newoption.addClass('nf-sel-lbl');		
				});
			}
		
		extraSelectChecks(e);
		}).on('keyup', function(e){
		
		delete searchKeys[e.keyCode];
		
		var myfield 	= $(this);
		var mysel 		= $(this);
		var newoption 	= $(this).parent('.nf-sel').children('.nf-sel-lst').children('.nf-sel-lbl');
		
		if(newoption.length > 0 )
			{
			newval = newoption.attr('opt-val');
			newlbl = newoption.attr('opt-lbl');
			myfield.attr('my-val', newval).val(newval);
			myfield.parent('.nf-sel').children('.nf-sel-cur').html(newlbl+'<span class="nf-sel-arw fa fa-angle-down"></span>');
			}
		});
	}

function selectLoadingSelected()
	{
	$(window).on('load', function(){
		$('.nf-sel').each(function(){
			var thisrow = $(this);
			var newval = null;
			if(thisrow.children('.nf-sel-val').val()!='' && thisrow.children('.nf-sel-val').val()!=null)
				{
				newval = thisrow.children('.nf-sel-val').val();
				thisrow.children('.nf-sel-cur').html(newval+'<span class="nf-sel-arw fa fa-angle-down"></span>');
				}
			var hl = 0;			
			
			thisrow.children('.nf-sel-lst').children('.nf-sel-opt').each(function(){
				if(hl==0 && newval!=null)
					{
					if($(this).attr('opt-val')==newval)
						{
						$(this).addClass('nf-sel-lbl');
						thisrow.children('.nf-sel-cur').html($(this).attr('opt-lbl')+'<span class="nf-sel-arw fa fa-angle-down"></span>');	
						}
					}
				});
			});
		});		
	}

function extraSelectChecks()
	{
	// Empty Placeholder	
	}


// Nice Toggle (2 Options)
function niceToggle()
	{
	/* Nice Checkbox Page Reload Check */
	$('.nf-tgl').each(function(){
		if($(this).attr('checked')=='checked')
			{
			var thisfld = $(this).parent('.nf-tgl-wrp').children('.nf-tgl-val');
			var fldid = $(this).attr('data-rel');
			var lblb = $(this).attr('data-optb');
			var valb = $(this).attr('data-valb');
			
			if(thisfld.val()==valb)
				{
				$(this).children('.nf-tgl-lbl').html(lblb).addClass('nf-tgl-swd');
				}
			}
		extraToggleChecks();	
		});
		
	$('body').on('click', '.nf-tgl', function(){
		
		$(this).parent('.nf-tgl-wrp').children('.nf-tgl-val').focus();
		var thisfld = $(this).parent('.nf-tgl-wrp').children('.nf-tgl-val');
		var fieldname = $(this).attr('data-rel');
		var opta = $(this).attr('data-vala');
		var optb = $(this).attr('data-valb');
		var optalbl = $(this).attr('data-opta');
		var optblbl = $(this).attr('data-optb');
		var curval = thisfld.val();
		
		if(curval==opta)
			{
			thisfld.val(optb);
			
			$(this).addClass('nf-tgl-off');
			$(this).children('.nf-tgl-lbl').removeClass('nf-tgl-swd').html(optblbl).animate({'margin-left':'40px'}, 250);
			}		
		else
			{
			thisfld.val(opta);
			
			$(this).removeClass('twoWayToggleOff');
			$(this).children('.nf-tgl-lbl').css({'margin-left':'40px'}).removeClass('nf-tgl-swd').html(optalbl).animate({'margin-left':'0px'}, 250);
			}
		
		extraToggleChecks();
		});
	
	$('.nf-tgl-val').on('focus', function(){
		$(this).parent('.nf-tgl-wrp').children('.nf-tgl').addClass('nf-fcs');
		});
	
	$('.nf-tgl-val').on('blur', function(){
		$(this).parent('.nf-tgl-wrp').children('.nf-tgl-').removeClass('nf-fcs');
		});
	
	$('.nf-tgl-val').on('keydown', function(event){
		var toggler = $(this).parent('.nf-tgl-wrp').children('.nf-tgl');
		var opta = toggler.attr('data-vala');
		var optb = toggler.attr('data-valb');
		var optalbl = toggler.attr('data-opta');
		var optblbl = toggler.attr('data-optb');
		var keycode = (event.keyCode ? event.keyCode : (event.which ? event.which : event.charCode));
		if(keycode == 37)
			{
			$(this).val(opta);
			toggler.removeClass('nf-tgl-off');
			toggler.children('.nf-tgl-lbl').css({'margin-left':'40px'}).removeClass('nf-tgl-swd').html(optalbl).animate({'margin-left':'0px'}, 250);
			extraToggleChecks();
			return false;
			}
		else if(keycode == 39)
			{
			$(this).val(optb);
			toggler.addClass('nf-tgl-off');
			toggler.children('.nf-tgl-lbl').removeClass('nf-tgl-swd').html(optblbl).animate({'margin-left':'40px'}, 250);
			extraToggleChecks();
			return false;
			} 
		else{return true;};
		});
	}

function extraToggleChecks()
	{
	// Empty Placeholder	
	}

function toggleLoadingSelected()
	{

		
	}


// Nice Radio (Multiple Options, only 1 selection)
function niceRadio()
	{
	/* Nice Radio Option Selector*/
	$('body').on('click', '.nf-rad-opt', function(){
		// Grab the variables
		var thisopt = $(this);
		var thisfld = $(this).parent('.nf-rad').children('.nf-rad-fld');
		var thisbox = $(this).children('.nf-rad-box');
		var fieldid = thisopt.attr('opt-fld');
		var optvalue = thisopt.attr('opt-val');
		
		// Clear the other options from the selected class
		thisopt.parent('.nf-rad').children('.nf-rad-opt').children('.nf-rad-box').html(null);
		// Add the selected class to our selected field
		thisbox.html('<span class="nf-rad-sel"></span>');
		// Now set the value for the field
		thisfld.val(optvalue);
		extraRadioChecks();
		});	
	
	$('.nf-rad-fld').on('focus', function(){
		$(this).parent('.nf-rad').addClass('nf-hgl');	
		});
	
	$('.nf-rad-fld').on('blur', function(){
		$('.nf-hgl').removeClass('nf-hgl');
		});
	
	$('.nf-rad-fld').on('keydown', function(event){
		
		// 37 = left, 39 = right
		var keycode 	= (event.keyCode ? event.keyCode : (event.which ? event.which : event.charCode));
		
		var myfield 	= $(this);
		var curval 		= $(this).val();
		var radioset 	= $(this).parent('.nf-rad');
		
		var nextopt		= '';
		var newval 		= '';
		var newlbl 		= '';
		var newidx 		= '';
		
		if(keycode==37 || keycode==39)
			{
			radioset.children('.nf-rad-opt').each(function(index) {
				
				if(curval=='')
					{
					if(keycode==37)
						{
						nextopt = radioset.children('.nf-rad-opt:first');
						}
					else
						{
						nextopt = radioset.children('.nf-rad-opt:last');
						}
					return false;
					}
				else if($(this).attr('opt-val')==curval)
					{
					if(keycode==37)
						{
						nextopt = $(this).prev('.nf-rad-opt');
						}
					else
						{
						nextopt = $(this).next('.nf-rad-opt');
						}
					return false;
					}
				});
			
			if(nextopt.length > 0)
				{
				radioset.children('.nf-rad-opt').children('.nf-rad-box').html('');
				myfield.val(nextopt.attr('opt-val'));
				nextopt.children('.nf-rad-box').html('<span class="nf-rad-sel"></span>');	
				extraRadioChecks();
				}
			}
		});
	
	radioLoadingSelected();
	}

function extraRadioChecks()
	{
	// Empty Placeholder	
	}

function radioLoadingSelected()
	{
	$('.nf-rad').each(function(){
		var myradio = $(this);
		var myval = $(this).children('input').val();
		if(myval!='' && myval!=null)
			{
			myradio.children('.nf-rad-opt').each(function(){
                if($(this).attr('opt-val')==myval)
					{
					$(this).children('.nf-rad-box').html('<span class="nf-rad-sel"></span>');
					}
            	});
			}
		});	
	}


// Nice Checkbox
function niceCheckbox()
	{
	/* Nice Checkbox Handler */
	$('body').on('click', '.nf-chk', function(){
		if($(this).attr('is-chkd')=='y')
			{
			$(this).attr('is-chkd', 'n');
			$(this).children('.nf-chk-fld').attr('checked', null).focus();
			$(this).children('.nf-chk-icn').removeClass('nf-chk-sel');
			}
		else
			{
			$(this).attr('is-chkd', 'y');
			$(this).children('.nf-chk-fld').attr('checked', 'checked').focus();
			$(this).children('.nf-chk-icn').addClass('nf-chk-sel');	
			}
		extraCheckboxChecks();
		});
	
	
	/* Nice Checkbox Page Reload Check */
	$('.nf-chk-fld').each(function(){
		if($(this).attr('checked')=='checked')
			{
			$(this).parent('.nf-chk').attr('is-chkd', 'y');
			$(this).parent('.nf-chk').children('.nf-chk-icn').addClass('nf-chk-sel');
			}
		extraCheckboxChecks();	
		});
	
	
	/* Focus Toggling */
	
	$('.nf-chk .nf-chk-fld').on('focusin', function(){
		$(this).parent('.nf-chk').children('.nf-chk-icn').addClass('nf-fcs');		
		});
	
	$('.nf-chk .nf-chk-fld').on('focusout', function(){
		$(this).parent('.nf-chk').children('.nf-chk-icn').removeClass('nf-fcs');	
		});
	
	$('.nf-chk-icn').on("keyup", function(event){
		
		var chkbox = $(this).parent('.nf-chk');	
		var keycode = (event.keyCode ? event.keyCode : (event.which ? event.which : event.charCode));
		
		if(keycode == 32)
			{
			if(chkbox.attr('is-chkd')=='y')
				{
				chkbox.attr('is-chkd', 'n');
				chkbox.children('.nf-chk-fld').attr('checked', null);
				chkbox.children('.nf-chk-icn').focus().removeClass('nf-chk-sel');
				}
			else
				{
				chkbox.attr('is-chkd', 'y');
				chkbox.children('.nf-chk-fld').attr('checked', 'checked');
				chkbox.children('.nf-chk-icn').focus().addClass('nf-chk-sel');	
				}
			} 
		extraCheckboxChecks();
		});
	
	}

function extraCheckboxChecks()
	{
	// Empty Placeholder	
	}


function niceFileInput()
	{
	$('.nf-fle-inp').on('change', function(){
		var filename = $(this).val();
		$(this).parent('.nf-fle-wrp').children('.nf-fle-ttl').val(filename);
		extraNiceFileChecks();
		});
	}

function extraNiceFileChecks()
	{
	}

