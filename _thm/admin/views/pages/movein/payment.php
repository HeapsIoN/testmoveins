<p>&nbsp;</p>
<h2><?php $this->page->heading('pagetitle'); ?></h2>
<p>&nbsp;</p>
<p>Please start by selecting the card type that you wish to use for payment.</p>
<p>&nbsp;</p>

<div class="col-xs-12 well">
<form class="form-horizontal mrg-t-lrg" id="payment-result">
<fieldset>
<input type="hidden" id="facilitycode" 	name="facilitycode" 	readonly="readonly"	value="<?php echo $this->moveins->faccode; ?>"  />
<input type="hidden" id="customercode" 	name="customercode" 	readonly="readonly" value="<?php $this->moveins->custdata('customercode'); ?>" />
<input type="hidden" id="paymenttype" 	name="paymenttype" 		readonly="readonly" value="<?php $this->moveins->custdata('paymenttype'); ?>" />
<input type="hidden" id="paymentid"		name="paymentid" 		readonly="readonly" value="<?php echo uniqid();//$this->moveins->custdata('customercode');$this->moveins->orderdata('agreement'); ?>" />
<input type="hidden" id="facilityezi" 	name="facilityezi" 		readonly="readonly" value="<?php echo $this->moveins->facinfo['facilityedpubkey']; ?>" />
<input type="hidden" id="paymentamount" name="paymentamount" 	readonly="readonly" value="<?php echo number_format($this->moveins->order['duetoday'], 2,'.',','); ?>" />
<input type="hidden" id="amountcharged" name="amountcharged" 	readonly="readonly" value="<?php echo number_format($this->moveins->order['grandtotal'], 2,'.',','); ?>" />
<input type="hidden" id="feescharged" 	name="feescharged" 		readonly="readonly" value="<?php echo number_format($this->moveins->order['feespayable'], 2,'.',','); ?>" />
<input type="hidden" id="receiptid" 	name="receiptid" 		readonly="readonly" />
<input type="hidden" id="exchangeid" 	name="exchangeid" 		readonly="readonly" />
<input type="hidden" id="paymentresult" name="paymentresult" 	readonly="readonly" />
<input type="hidden" id="paymentcode" 	name="paymentcode" 		readonly="readonly" />
<input type="hidden" id="paymenttext" 	name="paymenttext" 		readonly="readonly" />
<input type="hidden" id="paymentuuid" 	name="paymentuuid" 		readonly="readonly" />
<input type="hidden" id="cardcode" 		name="cardcode" 		readonly="readonly" value="<?php echo $this->moveins->facinfo['facilityezicardvisa']; ?>" />

<input type="hidden" id="basefee" 		value="<?php echo $this->moveins->basefees['visa']; ?>" />
	
    <div class="form-group">
    	<label class="col-lg-2 control-label">Select card type</label>
        <div class="col-lg-10 pad-none">
        	<?php
			if(isset($this->moveins->fees['visa']))
				{
			?>
			<button type="button" class="cc-btn pull-left card-type txt-orange-hover txt-7" id="card-visa" card-fee="<?php echo $this->moveins->basefees['visa']; ?>" card-rate="<?php echo $this->moveins->fees['visa']; ?>" card-code="<?php echo $this->moveins->facinfo['facilityezicardvisa']; ?>"><i class="fa fa-cc-visa txt-mg"></i></button>
			<?php	
				}
			
			if(isset($this->moveins->fees['mastercard']))
				{
			?>
			<button type="button" class="cc-btn pull-left card-type txt-orange-hover" id="card-mastercard" card-fee="<?php echo $this->moveins->basefees['mastercard']; ?>" card-rate="<?php echo $this->moveins->fees['mastercard']; ?>" card-code="<?php echo $this->moveins->facinfo['facilityezicardmaster']; ?>"><i class="fa fa-cc-mastercard txt-mg"></i></button>
			<?php	
				}
			
			if(isset($this->moveins->fees['amex']))
				{
			?>
			<button type="button" class="cc-btn pull-left card-type txt-orange-hover" id="card-amex" card-fee="<?php echo $this->moveins->basefees['amex']; ?>" card-rate="<?php echo $this->moveins->fees['amex']; ?>" card-code="<?php echo $this->moveins->facinfo['facilityezicardamex']; ?>"><i class="fa fa-cc-amex txt-mg"></i></button>
			<?php	
				}
			
			if(isset($this->moveins->fees['diners']))
				{
			?>
			<button type="button" class="cc-btn pull-left card-type txt-orange-hover" id="card-diners" card-fee="<?php echo $this->moveins->basefees['diners']; ?>" card-rate="<?php echo $this->moveins->fees['diners']; ?>" card-code="<?php echo $this->moveins->facinfo['facilityezicarddiners']; ?>"><i class="fa fa-cc-diners-club txt-mg"></i></button>
			<?php	
				}
			
			?>
        </div>
    </div>
    <div class="form-group">
		<label class="col-lg-2 control-label">Amt. to pay</label>
        <div class="input-group col-lg-3">
        	<span class="input-group-addon"><?php $this->regioning->currency(); ?></span>
            <input type="text" class="form-control" id="paymentdisplay" value="<?php echo number_format($this->moveins->order['duetoday'], 2,'.',','); ?>" storman-amount="<?php echo number_format($this->moveins->order['duetoday'], 2,'.',','); ?>" disabled="disabled" readonly />
        </div>
    </div>
    <div class="form-group">
		<label class="col-lg-2 control-label">Fees</label>
        <div class="input-group col-lg-3">
        	<span class="input-group-addon"><?php $this->regioning->currency(); ?></span>
        	<input type="text" class="form-control" id="paymentfees" value="<?php echo number_format($this->moveins->order['feespayable'], 2,'.',','); ?>" disabled="disabled" readonly />
		</div>
    </div>
    <div class="form-group mrg-b-none">
		<label class="col-lg-2 control-label">Payable</label>
        <div class="input-group col-lg-3">
        	<span class="input-group-addon"><?php $this->regioning->currency(); ?></span>
        	<input type="text" class="form-control" id="paymenttotal" value="<?php echo number_format($this->moveins->order['grandtotal'], 2,'.',','); ?>" disabled="disabled" readonly />
		</div>
    </div>
    <div class="col-xs-12 pad-none mrg-t-md" id="storman-payment"> 
        <hr />
        <h4>Payment via Credit Card</h4>
        <div class="form-group">
            
			<label class="col-lg-2 control-label" for="cardname">Name on card</label>
            <div class="col-lg-5">
                <input type="text" class="form-control pi" id="cardname" name="cardname" required placeholder="Enter the name as shown on your credit card" />						
            </div>
		</div>
        <div class="form-group">
        	<label class="col-lg-2 control-label" for="cardnumber">Card number</label>
            <div class="col-lg-5">
            	<input type="text" class="form-control pi" id="cardnumber" name="cardnumber" required filter="ccard" placeholder="Enter your card number" />						
        	</div>
        </div>
        <div class="form-group">
            <label class="col-lg-2 control-label" for="cardmonth">Expiry date</label>
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
            <div class="col-lg-2">
            <select class="form-control pi" id="cardmonth" name="cardmonth" required>
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
            </div>
            <div class="col-lg-2">
            <select class="form-control pi" id="cardyear" name="cardyear" required>
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
        <div class="form-group">
            <label class="col-lg-2 control-label" for="cardcvv">Card CCV</label>
            <div class="col-lg-2">
            	<input type="text" class="form-control pi" id="cardcvv" name="cardcvv" required filter="ccv" placeholder="CCV" />						
            </div>
        </div>
        <div class="form-group mrg-b-none">
            <div class="col-xs-12">
                <button type="button" class="btn pull-right bg-3 txt-1 bg-4-hover txt-uc" id="processpayment">Process Payment</button>		
            </div>
        </div>
    </div>
    <div class="col-xs-12 pad-none storman-hdn" id="storman-processed"> 
        <h2>Payment Processed</h2>
        <div class="form-group mrg-b-none">
            <label class="col-lg-3 control-label" for="cardname">Receipt Number</label>
            <div class="col-lg-9">
            <input type="text" class="input col-xs-12 bdr-3 txt-lg txt-4 pi" id="receiptnumber" readonly />						
            </div>
            <p>Thanks for your payment. You will be redirected momentarily.</p>	
        </div>
    </div>
</fieldset>  
</form>
</div>



<script type="application/javascript" language="javascript" src="/_thm/storman/js/inc/ezi/ezidebt_2_0_0.min.js"></script>
<script type="text/javascript">
$('#payment-result').valida({form_validate:'validate'});

var displaySubmitCallback = function (data) 
	{				  
	$('#receiptid, #receiptnumber').val(data['BankReceiptID']);
	$('#exchangeid').val(data['ExchangePaymentID']);
	$('#paymentresult').val(data['PaymentResult']);
	$('#paymentcode').val(data['PaymentResultCode']);
	$('#paymenttext').val(data['PaymentResultText']);
	$('#paymentuuid').val($('#paymentid').val());
	
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

//var endpoint = 'https://api.demo.ezidebit.com.au/V3-5/public-rest'; // Dev URL
var endpoint 	= 'https://api.ezidebit.com.au/V3-5/public-rest'; // Live URL

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
		bfee	= 0,
		fttl	= 0,
		grand	= 0;
	
	$('#basefee').val($(this).attr('card-fee'));
	
	fees = parseFloat(total * crate);
	if($(this).attr('card-fee')!='' && $(this).attr('card-fee')!='0')
		{
		bfee = $(this).attr('card-fee');
		fttl = parseFloat($(this).attr('card-fee')) + fees;		
		}
	else
		{
		fttl = fees;	
		}
	
	grand = parseFloat($('#paymentamount').val()) + parseFloat(bfee) + fees;
	fees = fees.toFixed(2);
	fttl = fttl.toFixed(2);
	grand = grand.toFixed(2);
	
	$('#paymentfees, #feescharged').val(fttl);
	$('#paymenttotal').val(grand);
	$('#amountcharged').val(grand);
	
	$('.card-type').not($(this)).removeClass('txt-7');
	$(this).addClass('txt-7');
	$('#cardcode').val($(this).attr('card-code'));
	$('#storman-payment').slideDown(350);
	});


</script>