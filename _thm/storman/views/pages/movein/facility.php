<?php
$cls = isset($this->moveins->user['facilitycode']) && $this->moveins->user['facilitycode']!='' ? '' : ' storman-hdn';
?>
<h1><?php $this->page->heading('pagetitle'); ?></h1>
<form id="form" action="/unit">
<input type="hidden" name="facilitycode" id="facilitycode" value="<?php $this->moveins->userdata('facilitycode'); ?>" />
<div class="col-xs-12 pad-none">
	<div class="col-xs-12 col-md-6 col-md-offset-3 pad-none">
    	<?php
		if($cls=='')
			{
		?>
        <div class="col-xs-12 mrg-b-md">
        	<p>Your current facility is <?php echo $this->moveins->facinfo['facilityfullname']; ?>.</p>
            <p>You can search for another facility that is part of the StorMan network or click 'Continue' to order and move into a unit.</p>
        </div>
        <?php	
			}
		?>
        <div class="col-xs-12 pad-none mrg-b-md">
        	<label for="facility" class="lbl col-xs-12 alg-lft txt-md">Find a Facility</label>
            <input type="text" class="input col-xs-12 bdr-3 txt-lg txt-4" id="facility" placeholder="Search for a facility" />
        </div>
        <div class="col-xs-12 pad-none mrg-b-md<?php echo $cls; ?>" id="facility-continue">
        	<button type="button" class="btn col-xs-12 bg-3 bg-4-hover txt-1 txt-1-hover txt-uc" id="setfacility">Continue &raquo;</button>
        </div>
    </div>
</div>
</form>