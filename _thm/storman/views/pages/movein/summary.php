<h1><?php $this->page->heading('pagetitle'); ?></h1>
<form id="form">
<div class="col-xs-12 pad-none">
	<div class="col-xs-12 col-md-6 pad-none">
    	<label class="lbl col-xs-12 alg-lft txt-sm lh-30">Storage Facility</label>
        <span class="col-xs-12 txt-lg txt-4 lh-50"><?php echo $this->moveins->facinfo['facilityfullname']; ?></span>	
    </div>
    <div class="col-xs-12 col-md-6 pad-none">
    	<label class="lbl col-xs-12 alg-lft txt-sm lh-30">Agreement Number</label>
        <span class="col-xs-12 txt-lg txt-4 lh-50"><?php $this->moveins->orderdata('agreement', 'Unknown'); ?></span>	
    </div>
    <div class="col-xs-12 col-md-6 pad-none">
    	<label class="lbl col-xs-12 alg-lft txt-sm lh-30">Unit Type</label>
        <span class="col-xs-12 txt-lg txt-4 lh-50"><?php $this->moveins->orderdata('unitcode'); ?></span>	
    </div>
    <div class="col-xs-12 col-md-6 pad-none">
    	<label class="lbl col-xs-12 alg-lft txt-sm lh-30">Unit Number</label>
        <span class="col-xs-12 txt-lg txt-4 lh-50"><?php $this->moveins->orderdata('unitnums', 'Unknown'); ?></span>	
    </div>
    <div class="col-xs-12 col-md-6 pad-none">
    	<label class="lbl col-xs-12 alg-lft txt-sm lh-30">Storage From</label>
        <span class="col-xs-12 txt-lg txt-4 lh-50"><?php if(isset($this->moveins->order['unitfrom'])){echo date('jS M, Y', strtotime($this->moveins->order['unitfrom']));} ?></span>	
    </div>
    <div class="col-xs-12 col-md-6 pad-none">
    	<label class="lbl col-xs-12 alg-lft txt-sm lh-30">Storage To</label>
        <span class="col-xs-12 txt-lg txt-4 lh-50"><?php if(isset($this->moveins->order['unitto'])){echo date('jS M, Y', strtotime($this->moveins->order['unitto']));} ?></span>	
    </div>
    <div class="col-xs-12 col-md-6 pad-none">
    	<label class="lbl col-xs-12 alg-lft txt-sm lh-30">Unit Monthly Rate</label>
        <span class="col-xs-12 txt-lg txt-4 lh-50">$<?php if(isset($this->moveins->order['unitrate'])){echo number_format($this->moveins->order['unitrate'],2,'.',',');} ?> / month</span>	
    </div>
    <?php
	if(isset($this->moveins->order['insurrate']) && $this->moveins->order['insurrate']!='' && $this->moveins->order['insurrate']!='0')
		{
	?>
    <div class="col-xs-12 col-md-6 pad-none">
    	<label class="lbl col-xs-12 alg-lft txt-sm lh-30">Insurance Monthly Rate</label>
        <span class="col-xs-12 txt-lg txt-4 lh-50">$<?php echo number_format($this->moveins->order['insurrate'],2,'.',','); ?> / month</span>	
    </div>
    
    <?php		
		}
	
	if(isset($this->moveins->facinfo['fees']['deposit']) && $this->moveins->facinfo['fees']['deposit']!='' && $this->moveins->facinfo['fees']['deposit']!='0')
		{
	?>
    <div class="col-xs-12 col-md-6 pad-none">
    	<label class="lbl col-xs-12 alg-lft txt-sm lh-30">Deposit Fee</label>
        <span class="col-xs-12 txt-lg txt-4 lh-50">$<?php echo $this->moveins->facinfo['fees']['deposit']; ?></span>	
    </div>
    <?php	
		}
	?>
    <div class="col-xs-12 col-md-6 pad-none">
    	<label class="lbl col-xs-12 alg-lft txt-sm lh-30">Monthly Total</label>
        <span class="col-xs-12 txt-lg txt-4 lh-50">$<?php echo number_format($this->moveins->order['total'],2,'.',','); ?> / month</span>	
    </div>
    <div class="col-xs-12 col-md-6 pad-none">
    	<label class="lbl col-xs-12 alg-lft txt-sm lh-30">Amount Due Today</label>
        <span class="col-xs-12 txt-lg txt-4 lh-50">$<?php echo number_format($this->moveins->order['duetoday'],2,'.',','); ?> + Processing Fees</span>	
    </div>
    <div class="col-xs-12 pad-none mrg-b-md">
        <a href="/payment" class="btn col-xs-12 bg-3 txt-1 bg-4-hover txt-uc">Continue &raquo;</a>
    </div>
</div>
</form>