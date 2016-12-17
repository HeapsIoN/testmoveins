// JavaScript Document

$(document).ready(function () {

	var displaySubmitCallback = function(data) {
		console.log(data);
	}
	
	var displaySubmitError = function (data) {
		console.log(data);
	}


	var endpoint = 'https://api.demo.ezidebit.com.au/V3-5/public-rest';
	
	eziDebit.init('4B598D04-3FCB-49B6-7998-72F3E88838A3', {
		  submitAction: "ChargeCard",
		  submitButton: "processpayment",
		  submitCallback: displaySubmitCallback,
		  submitError: displaySubmitError,
		  nameOnCard: "cardname",
		  cardNumber: "cardnumber",
		  cardExpiryMonth: "cardmonth",
		  cardExpiryYear: "cardyear",
		  cardCCV: "cardcvv",
		  paymentAmount: "amount",
		  paymentReference: "paymentid"
		}, 'https://api.demo.ezidebit.com.au/V3-5/public-rest');  
	  
	
});