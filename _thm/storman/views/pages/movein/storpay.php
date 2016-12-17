<h1><?php $this->page->heading('pagetitle'); ?></h1>
<form action="<?php echo $this->moveins->facinfo['facilitystorpayurl']; ?>" method="post" name="PayNow" id="form">
<input type="hidden" name="vtloginpassword" value="<?php echo $this->moveins->customer['pass']; ?>">
<input type="hidden" name="vtloginusername" value="<?php echo $this->moveins->customer['customercode']; ?>">
<input type="hidden" name="vtFacilityID" value="<?php echo $this->moveins->facinfo['facilitynumber']; ?>">
<input type="hidden" name="vtIsReservation" value="false">
<input type="hidden" name="vtReference" value="Deposit">

<div class="col-xs-12 pad-none">
	<div class="col-xs-12 col-md-6 col-md-offset-3 pad-none">
    	<div class="col-xs-12 pad-none mrg-b-md">
        	<p>Thanks for your order.</p>
            <p>You will be redirected to the payment portal momentarily.</p>
        </div>
    </div>
</div>
</form>
<script type="text/javascript">
$('body').delay(5000, function(){$('#form').submit()});
</script>
