// JavaScript Document


var displaySubmitCallback = function (data) 
	{				  
	$('#receiptid').val(data['BankReceiptID']);
	$('#exchangeid').val(data['ExchangePaymentID']);
	$('#paymentresult').val(data['PaymentResult']);
	$('#paymentcode').val(data['PaymentResultCode']);
	$('#paymenttext').val(data['PaymentResultText']);
	
	var postdata 	= ($('#payment-result').serializeArray());
	
	console.log(postdata);
	////////////////////////////////////////////
	$.ajax({
		type: 'POST',
		url: '/ajax/movein/receipter',
		data: postdata,
		}).done(function(response){
		
		if(response.error)
			{
			displayResponse(response.error, 'error');	
			}
		else
			{
			displayResponse(response.success, 'success');	
			$(document).delay(4000, function(){window.location.replace('/completed')});
			}
		
		$('#storman-payment').slideUp(250);
		
		
		});
	}
  
var displaySubmitError = function (data) 
	{
	console.log(data);
	displayResponse(data+'<br />Please retry the payment.', 'error');
	$('.pi').attr('readonly', null);
	}

var endpoint = 'https://api.demo.ezidebit.com.au/V3-5/public-rest'; // Dev URL
//var endpoint 	= 'https://api.ezidebit.com.au/V3-5/public-rest'; // Live URL

var pubkey = $('#facilityezi').val(); // Live Key

$('#processpayment').on('click', function(){
	$('#loading').fadeIn(250);
	$('.pi').attr('readonly', 'readonly');	
	});

eziDebit.init(pubkey, 
	{
	submitAction: "ChargeCard",
	submitButton: "processpayment",
	submitCallback: displaySubmitCallback,
	submitError: displaySubmitError,
	nameOnCard: "cardname",
	cardNumber: "cardnumber",
	cardExpiryMonth: "cardmonth",
	cardExpiryYear: "cardyear",
	cardCCV: "cardcvv",
	paymentAmount: "paymentamount",
	paymentReference: "paymentid"
	}, 
	endpoint);


$('body').on('click', '.card-type', function(){
	
	$('.card-type').not($(this)).removeClass('bg-4');
	$(this).addClass('bg-4');
	$('#cardtype').val($(this).attr('card-code'));
	
	});