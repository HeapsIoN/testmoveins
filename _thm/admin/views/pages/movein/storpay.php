<h1><?php $this->page->heading('pagetitle'); ?></h1>
<?php
$url = $this->moveins->facinfo['facilitystorpayurl']!='' ? 'https://www.storpay.com/4DCGI/storpay/'.$this->moveins->facinfo['facilitystorpayurl'].'/query.shtml' : 'https://www.storpay.com/4DCGI/storpay/query.shtml';
?>
<form action="<?php echo $url; ?>" method="post" name="PayNow" id="form">
<input type="hidden" name="vtLoginPassword" value="<?php if(isset($this->moveins->user['customerpass'])){echo $this->moveins->user['customerpass'];} ?>">
<input type="hidden" name="vtLoginUsername" value="<?php if(isset($this->moveins->order['agreement'])){echo $this->moveins->order['agreement'];} ?>">
<input type="hidden" name="vtFacilityID" value="<?php if(isset($this->moveins->facinfo['facilitynumber'])){echo $this->moveins->facinfo['facilitynumber'];} ?>">
<input type="hidden" name="vtIsReservation" value="false">
<input type="hidden" name="vtReference" value="">

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
$('body').delay(4000, function(){$('#form').submit()});
</script>
