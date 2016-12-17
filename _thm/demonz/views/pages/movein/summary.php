<p>&nbsp;</p>
<h2><?php $this->page->heading('pagetitle'); ?></h2>
<p>&nbsp;</p>
<p>Please review your payment details below, then click 'Continue'...</p>
<p>&nbsp;</p>
<div class="col-xs-12 well">
<form id="form" class="form-horizontal">
<fieldset>
	<h4>Facility &amp; Unit information</h4>
    <div class="form-group pad-t-lg">
        <div class="col-lg-12">
            <p class="label">Storage Facility</p>
            <p><?php echo $this->moveins->facinfo['facilityfullname']; ?></p>	
        </div>
        <div class="col-lg-4">
            <p class="label">Agreement Number</p>
            <p><?php $this->moveins->orderdata('agreement', 'Unknown'); ?></p>	
        </div>
        <div class="col-lg-4">
            <p class="label">Unit Type</p>
            <p><?php $this->moveins->orderdata('unitcode'); ?></p>	
        </div>
        <div class="col-lg-4">
            <p class="label">Unit Number</p>
            <p><?php $this->moveins->orderdata('unitnums', 'Unknown'); ?></p>	
        </div>
	</div>
    <hr />
    <h4>Payment information</h4>
    <div class="form-group pad-t-lg mrg-b-none">
        <div class="col-lg-4">
            <p class="label">Storage From</p>
            <p><?php if(isset($this->moveins->order['unitfrom'])){echo date('jS M, Y', strtotime($this->moveins->order['unitfrom']));} ?></p>	
        </div>
        <div class="col-lg-8">
            <p class="label">Storage To</p>
            <p><?php if(isset($this->moveins->order['unitto'])){echo date('jS M, Y', strtotime($this->moveins->order['unitto']));} ?></p>	
        </div>
        <div class="col-lg-4">
            <p class="label">Unit Monthly Rate</p>
            <p><?php $this->regioning->currency();if(isset($this->moveins->order['unitrate'])){echo number_format($this->moveins->order['unitrate'],2,'.',',');} ?> / month</p>	
        </div>
        <?php
        if(isset($this->moveins->order['insurrate']) && $this->moveins->order['insurrate']!='' && $this->moveins->order['insurrate']!='0')
            {
        ?>
        <div class="col-lg-4">
            <p class="label">Insurance Monthly Rate</p>
            <p><?php $this->regioning->currency();echo number_format($this->moveins->order['insurrate'],2,'.',','); ?> / month</p>	
        </div>
        
        <?php		
            }
        
        if(	isset($this->moveins->facinfo['fees']['deposit']) && $this->moveins->facinfo['fees']['deposit']!='' && $this->moveins->facinfo['fees']['deposit']!='0' ||
			isset($this->moveins->order['unitdeposit']) && $this->moveins->order['unitdeposit']!='' && $this->moveins->order['unitdeposit']!='0')
            {
			$t = isset($this->moveins->facinfo['fees']['deposit']) ? $this->moveins->facinfo['fees']['deposit'] + $this->moveins->order['unitdeposit'] : $this->moveins->order['unitdeposit'];
        ?>
        <div class="col-lg-4">
            <p class="label">Deposit Fee</p>
            <p><?php $this->regioning->currency();echo number_format($t,2,'.',','); ?></p>	
        </div>
        <?php	
            }
        ?>
    </div>
    <div class="form-group mrg-b-none">
        <div class="col-lg-4">
            <p class="label">Monthly Total</p>
            <p><?php $this->regioning->currency();echo number_format($this->moveins->order['total'],2,'.',','); ?> / month</p>	
        </div>
        <div class="col-lg-8">
            <p class="label">Amount Due Today</p>
            <p><?php $this->regioning->currency();echo number_format($this->moveins->order['duetoday'],2,'.',','); ?> + Processing Fees</p>	
        </div>
        <div class="col-xs-12">
            <a href="/payment" class="btn pull-right bg-3 txt-1 bg-4-hover txt-uc">Continue &raquo;</a>
        </div>
    </div>
</fieldset>
</form>
</div>