<p>&nbsp;</p>
<h2><?php $this->page->heading('pagetitle'); ?></h2>
<p>&nbsp;</p>
<form id="form" action="<?php if($this->uri->segment(1)=='reservation'){echo '/reservation';} ?>/customer" class="form-horizontal">
<input type="hidden" id="faccode" value="<?php if(isset($this->moveins->faccode)){echo $this->moveins->faccode;} ?>" />
<input type="hidden" id="unitcode" name="unitcode" value="<?php if(isset($this->moveins->order['unitcode'])){echo $this->moveins->order['unitcode'];} ?>" />
<input type="hidden" id="unitrate" name="unitrate" value="<?php if(isset($this->moveins->order['unitrate'])){echo $this->moveins->order['unitrate'];} ?>" />
<input type="hidden" id="unitdeposit" name="unitdeposit" value="<?php if(isset($this->moveins->order['unitdeposit'])){echo $this->moveins->order['unitdeposit'];} ?>" />
<input type="hidden" id="unitsizes" name="unitsizes" value="<?php if(isset($this->moveins->order['unitsizes'])){echo $this->moveins->order['unitsizes'];} ?>" />
<input type="hidden" id="unitcats" name="unitcats" value="<?php if(isset($this->moveins->order['unitcats'])){echo $this->moveins->order['unitcats'];} ?>" />
<div class="col-xs-12 pad-none">

   	
    <div class="col-xs-12 well">
		<legend>Space Selection</legend>
        <p>You have selected <strong><?php echo $this->moveins->facinfo['facilityname']; ?></strong>. (Need to <a href="<?php if($this->uri->segment(1)=='reservation'){echo '/reservation';} ?>/facility" class="txt-3" style="text-decoration: underline;">choose a different facility</a>?)
        <p>Reserving a Space is quick and easy, and you can change your space size at any time - even on move-in day!</p>
        
   	<?php
	
	$this->load->view('../../'.$this->page->theme.'/views/pages/movein/unit'.$this->moveins->facinfo['facilityunitmethod'], array());
	
	$hdn = isset($this->moveins->order['unitcode']) && isset($this->moveins->order['unitrate']) ? '' : ' storman-hdn';
	
	if($this->moveins->facinfo['facilityunitselection']=='1')
		{
	?>
    	<div class="col-xs-12 <?php echo $hdn; ?>">
            <label for="customeremail" class="col-lg-2 control-label">Unit Selection</label>
            <div class="col-lg-4 mrg-b-md">
                <input type="text" class="form-control" id="unitselection" name="unitselection" placeholder="Select a unit number" value="<?php if(isset($this->moveins->order['unitnumber'])){echo $this->moveins->order['unitnumber'];} ?>" />
            </div>
        </div>
	<?php
		}
	?>
        <div class="col-xs-12 <?php echo $hdn; ?>">
			<button type="button" class="btn bg-3 bg-4-hover txt-1 txt-1-hover txt-uc pad-lr-md pull-right" id="continue">Continue &raquo;</button>
        </div>
    
    </div>
</div>
<!--div class="col-xs-12 pad-none mrg-b-md">
    <a href="/facility" class="btn bg-3 bg-4-hover txt-1 txt-1-hover txt-uc mrg-b-md">&laquo; Back to Facility Selection</a>
</div-->
</form>