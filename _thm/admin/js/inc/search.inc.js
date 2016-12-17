//////////////////////////////////////////////////////////////////////////////////////////////////
//////////////////////////////////////////////////////////////////////////////////////////////////
//////////////////////////////////////////////////////////////////////////////////////////////////
// Search List Handling

$(document).ready(function() {


//////////////////////////////////////////////////////////////////////////////////////////////////
// Header Column Ordering
$('.list-hdr').click(function(){
	var myhdr = $(this);
	var cls = '';
	var neworder = myhdr.attr('order-by');
	var curorder = $('#orderby').val();
	var curordering = $('#ordering').val().toUpperCase();
	var updated = 0;
	if(curorder==neworder)
		{
		var newordering = curordering=='ASC' ? 'DESC' : 'ASC';
		}
	else
		{
		var newordering = curordering;
		}
	
	cls = newordering=='ASC' ? 'fa-sort-up' : 'fa-sort-down';
	$('.list-icn').removeClass('fa-sort-up').removeClass('fa-sort-down').addClass('fa-sort');
	myhdr.children('span').children('.list-icn').addClass(cls);
	
	$('#orderby').val(neworder);
	$('#ordering').val(newordering);
	$('#search').submit();
	showLoader();
	});


//////////////////////////////////////////////////////////////////////////////////////////////////
// Submit
$('#process').on('click', function(){showLoader();$('#search').submit();});


////////////////////////////////////////////
// Form Submit on Enter
$('.search-input').bind('keydown', function(event){
	var keycode = (event.keyCode ? event.keyCode : (event.which ? event.which : event.charCode));
	if(keycode == 13){showLoader();$('#search').submit();return false;} 
	else{return true;};
	});


//////////////////////////////////////////////////////////////////////////////////////////////////
// Form Reset
$('#reset').on('click', function(){
	$('#lookfor').val('');
	$('#lookin').val($('#lookin').children('.nf-sel-lst').children('.nf-sel-opt:first').attr('opt-val'));
	$('#filter').val($('#filter').children('.nf-sel-lst').children('.nf-sel-opt:first').attr('opt-val'));
	$('#limit').val($('.rpp-opt:first').next('.rpp-opt').attr('my-rpp'));
	$('#search').submit();
	showLoader();
	});


//////////////////////////////////////////////////////////////////////////////////////////////////
// Escape to Reset Search
$(document).bind('keydown', function(event){
	var keycode = (event.keyCode ? event.keyCode : (event.which ? event.which : event.charCode));
	if(keycode == 27){$('#reset').click();return false;}		 
	else {return true;};
	});


//////////////////////////////////////////////////////////////////////////////////////////////////
// Rows Per Page
$('.rpp-opt').on('click', function(){
	showLoader();
	$('#limit').val($(this).attr('my-rpp'));
	$('#search').submit();	
	});

$('.paging-links').children('a').on('click', function(){
	showLoader();
	});

	
});



function submitSearch()
	{
	$('#loading').show();
	var process 	= $('#form').attr('my-process');
	var postdata 	= ($('#form').serializeArray());
	
	$.ajax({
		type: "POST",
		url: "/ajax/"+process+'/search',
		data: postdata,
		}).done(function(data){
		if(data.error)
			{
			displayResponse(data.error, 'error');	
			}
		else
			{
			$('#list-body').replaceWith(data.list);
			$('#list-foot').replaceWith(data.foot);
			$('#loading').delay(250).fadeOut(250);	
			}
		});	
	}