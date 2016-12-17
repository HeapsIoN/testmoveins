<form class="form-horizontal mrg-t-lrg" id="payment-result">
<input type="hidden" id="facilitycode" 	name="facilitycode" 	readonly="readonly"	value="<?php echo $this->moveins->faccode; ?>"  />
<input type="hidden" id="customercode" 	name="customercode" 	readonly="readonly" value="<?php $this->moveins->custdata('customercode'); ?>" />
<input type="hidden" id="paymenttype" 	name="paymenttype" 		readonly="readonly" value="<?php $this->moveins->custdata('paymenttype'); ?>" />
<input type="hidden" id="paymentid"		name="paymentid" 		readonly="readonly" value="<?php $this->moveins->custdata('customercode');$this->moveins->orderdata('agreement'); ?>" />
<input type="hidden" id="facilityezi" 	name="facilityezi" 		readonly="readonly" value="<?php echo $this->moveins->facinfo['facilityedpubkey']; ?>" />
<input type="hidden" id="paymentamount" name="paymentamount" 	readonly="readonly" value="<?php echo number_format($this->moveins->order['total'], 2,'.',','); ?>" />
<input type="hidden" id="amountcharged" name="amountcharged" 	readonly="readonly" value="" />
<input type="hidden" id="receiptid" 	name="receiptid" 		readonly="readonly" />
<input type="hidden" id="exchangeid" 	name="exchangeid" 		readonly="readonly" />
<input type="hidden" id="paymentresult" name="paymentresult" 	readonly="readonly" />
<input type="hidden" id="paymentcode" 	name="paymentcode" 		readonly="readonly" />
<input type="hidden" id="paymenttext" 	name="paymenttext" 		readonly="readonly" />
<input type="hidden" id="cardcode" 		name="cardcode" 		readonly="readonly" />
</form>

<h1><?php $this->page->heading('pagetitle'); ?></h1>
<div class="col-xs-12 pad-none">
	<div class="col-xs-12 col-md-6 col-md-offset-3 pad-none mrg-b-md">
        <a href="/summary" class="btn col-xs-12 bg-3 bg-4-hover txt-1 txt-1-hover txt-uc">&laquo; Back to Payment Summary</a>
    </div>
    <div class="col-xs-12 col-md-6 col-md-offset-3 pad-none mrg-b-lg">
    	<input type="hidden" id="basefee" value="<?php echo $this->moveins->basefee; ?>" />
    	<?php
		$w = isset($this->moveins->fees) && !empty($this->moveins->fees) ? (12/count($this->moveins->fees)) : '4';
		
		if(isset($this->moveins->fees['visa']))
			{
		?>
        <span class="col-xs-12 col-md-<?php echo $w; ?>">
        <button type="button" class="cc-btn col-xs-12 pad-none lh-80 alg-ctr txt-1 bg-3 bg-4-hover cur-pnt txt-lg card-type" id="card-visa" card-rate="<?php if(isset($this->moveins->fees['visa'])){echo $this->moveins->fees['visa'];} ?>" card-code="EZD"><img class="cc-logo mrg-r-lg" src="/_med/images/cc-visa-logo.png" alt="" /></button>
        </span>
        <?php	
			}
		
		if(isset($this->moveins->fees['mastercard']))
			{
		?>
        <span class="col-xs-12 col-md-<?php echo $w; ?>">
        <button type="button" class="cc-btn col-xs-12 pad-none lh-80 alg-ctr txt-1 bg-3 bg-4-hover cur-pnt txt-lg card-type" id="card-mastercard" card-rate="<?php if(isset($this->moveins->fees['mastercard'])){echo $this->moveins->fees['mastercard'];} ?>" card-code="EZD"><img class="cc-logo mrg-r-lg" src="/_med/images/cc-mastercard-logo.png" alt="" /></button>
        </span>
        <?php	
			}
		
		if(isset($this->moveins->fees['amex']))
			{
		?>
        <span class="col-xs-12 col-md-<?php echo $w; ?>">
        <button type="button" class="cc-btn col-xs-12 pad-none  lh-80 alg-ctr txt-1 bg-3 bg-4-hover cur-pnt txt-lg card-type" id="card-amex" card-rate="<?php if(isset($this->moveins->fees['amex'])){echo $this->moveins->fees['amex'];} ?>" card-code="EZD"><img class="cc-logo mrg-r-lg" src="/_med/images/cc-amex-logo.png" alt="" /></button>
        </span>
        <?php	
			}
		
		?>
    </div>
    <div class="col-xs-12 col-md-6 col-md-offset-3 pad-none mrg-b-md">
		<label class="lbl col-xs-12 alg-lft txt-sm lh-30">Amount</label>
        <input type="text" class="input col-xs-12 bdr-3 txt-lg txt-4" id="paymentdisplay" value="$<?php echo number_format($this->moveins->order['total'], 2,'.',','); ?>" storman-amount="<?php echo number_format($this->moveins->order['total'], 2,'.',','); ?>" disabled="disabled" readonly="readonly" />
        
    </div>
    <div class="col-xs-12 col-md-6 col-md-offset-3 pad-none mrg-b-md">
		<label class="lbl col-xs-12 alg-lft txt-sm lh-30">Fees</label>
        <input type="text" class="input col-xs-12 bdr-3 txt-lg txt-4" id="paymentfees" value="" disabled="disabled" readonly="readonly" />
    </div>
    <div class="col-xs-12 col-md-6 col-md-offset-3 pad-none mrg-b-md">
		<label class="lbl col-xs-12 alg-lft txt-sm lh-30">Payable</label>
        <input type="text" class="input col-xs-12 bdr-3 txt-lg txt-4" id="paymenttotal" value="" disabled="disabled" readonly="readonly" />
    </div>
</div>

<div class="col-xs-12 pad-none storman-hdn" id="storman-payment"> 
    <h2>Payment via Credit Card</h2>
    <div class="col-xs-12 col-md-6 col-md-offset-3 pad-none mrg-b-md">
		<label class="lbl col-xs-12 alg-lft txt-sm lh-30" for="cardname">Name on Card*</label>
        <input type="text" class="input col-xs-12 bdr-3 txt-lg txt-4 pi" id="cardname" name="cardname" placeholder="Enter the name as shown on your credit card" />						
    </div>
    <div class="col-xs-12 col-md-6 col-md-offset-3 pad-none mrg-b-md">
		<label class="lbl col-xs-12 alg-lft txt-sm lh-30" for="cardnumber">Card Number*</label>
        <input type="text" class="input col-xs-12 bdr-3 txt-lg txt-4 pi" id="cardnumber" name="cardnumber" placeholder="Enter your card number" />						
    </div>
    <div class="col-xs-12 col-md-6 col-md-offset-3 pad-none mrg-b-md">
		<label class="lbl col-xs-12 alg-lft txt-sm lh-30" for="cardmonth">Card Expiry*</label>
        <?php
		$ms = range(1, 12);
		$mths = array();
		foreach($ms as $m)
			{
			$v = $m < 10 ? '0'.$m : $m;
			$mths[$v] = $m;	
			}
		
		$yrs = range(date('Y'), date('Y')+10);
		?>
        <div class="col-xs-12 pad-none">
        <select class="select-input col-xs-5 bdr-3 txt-lg txt-4 pi" id="cardmonth" name="cardmonth">
        	<option>[ Select Month ]</option>
            <?php
			foreach($mths as $m => $l)
				{
			?>
            <option value="<?php echo $m; ?>"><?php echo $m; ?></option>
            <?php	
				}
			?>
        </select>
        <div class="col-xs-2 alg-ctr lh-50 txt-xl">/</div>
        <select class="select-input col-xs-5 bdr-3 txt-lg txt-4 pi" id="cardyear" name="cardyear">
        	<option>[ Select Year ]</option>
            <?php
			foreach($yrs as $y)
				{
			?>
            <option value="<?php echo $y; ?>"><?php echo $y; ?></option>
            <?php	
				}
			?>
        </select>
        </div>
    </div>
    <div class="col-xs-12 col-md-6 col-md-offset-3 pad-none mrg-b-md">
		<label class="lbl col-xs-12 alg-lft txt-sm lh-30" for="cardcvv">Card CVV*</label>
        <input type="text" class="input col-xs-12 bdr-3 txt-lg txt-4 pi" id="cardcvv" name="cardcvv" placeholder="Enter the CVV for your credit card" />						
    </div>
    <div class="col-xs-12 col-md-6 col-md-offset-3 mrg-t-md mrg-b-lg pad-none">
        <button type="button" class="btn col-xs-12 bg-3 txt-1 bg-4-hover txt-uc" id="processpayment">Process Payment</button>		
    </div>
    <div class="col-xs-12 col-md-6 col-md-offset-3 pad-none mrg-b-md">
        <a href="/summary" class="btn col-xs-12 bg-3 bg-4-hover txt-1 txt-1-hover txt-uc">&laquo; Back to Payment Summary</a>
    </div>
</div>


<div class="col-xs-12 pad-none storman-hdn" id="storman-processed"> 
    <h2>Payment Processed</h2>
    <div class="col-xs-12 col-md-6 col-md-offset-3 pad-none">
		<label class="lbl col-xs-12 alg-lft txt-sm lh-30" for="cardname">Receipt Number</label>
        <input type="text" class="input col-xs-12 bdr-3 txt-lg txt-4 pi" id="receiptnumber" readonly="readonly" />						
    </div>
    <div class="col-xs-12 pad-none">
    	<p>Thanks for your payment. You will be redirected momentarily.</p>	
    </div>
</div>

<script type="application/javascript" language="javascript" src="/_thm/storman/js/inc/ezi/ezidebt_2_0_0.min.js"></script>
<script type="text/javascript">

var displaySubmitCallback = function (data) 
	{				  
	$('#receiptid, #receiptnumber').val(data['BankReceiptID']);
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
		else if(response.success)
			{
			window.location.replace('/completed');
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
	
	var crate 	= $(this).attr('card-rate'),
		total 	= $('#paymentamount').val(),
		fees	= 0,
		fttl	= 0,
		grand	= 0;
	
	fees = parseFloat(total * crate);
	fttl = parseFloat($('#basefee').val()) + fees;
	
	grand = parseFloat($('#paymentamount').val()) + parseFloat($('#basefee').val()) + fees;
	fees = fees.toFixed(2);
	fttl = fttl.toFixed(2);
	grand = grand.toFixed(2);
	
	$('#paymentfees').val('$'+fttl);
	$('#paymenttotal').val('$'+grand);
	$('#amountcharged').val(grand);
	
	$('.card-type').not($(this)).removeClass('bg-4');
	$(this).addClass('bg-4');
	$('#cardtype').val($(this).attr('card-code'));
	$('#storman-payment').slideDown(350);
	});


</script>