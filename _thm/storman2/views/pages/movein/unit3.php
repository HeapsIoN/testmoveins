
<?php

if(!empty($this->moveins->unittypes) && !empty($this->moveins->units))
    {
?>
<div class="form-group mrg-b-md" id="unit-sizes">
    <label class="col-lg-2 control-label" for="unit-size">Unit size</label>
	<div class="col-lg-4">
	<select id="unit-size" class="form-control">
    	<option value="">[ Select Unit Size ]</option>
	<?php
	foreach($this->moveins->unittypes as $siz => $size)
		{
		$sel = isset($this->moveins->order['unitsizes']) && $this->moveins->order['unitsizes']==$siz ? ' selected="selected"' : '';
	?>
		<option value="<?php echo $siz; ?>"<?php echo $sel; ?>><?php echo $size; ?></option>	
	<?php		
		}
	?>
    </select>
    </div>
</div>
<div class="form-group mrg-b-md">
	<label class="col-lg-2 control-label">Select a unit</label>
	<div class="col-lg-10 pad-none mrg-b-md">
    <?php
    
    foreach($this->moveins->units as $code => $unit)
        {
        $us = strtolower(str_replace(' ', '', $unit['unitsizecat']));
        
        $ucls 	= isset($this->moveins->order['unitcode']) && $this->moveins->order['unitcode']==$code ? 'bg-7' : 'bg-2';
        $hdn 	= isset($this->moveins->order['unitsizes']) && $this->moveins->order['unitsizes']==$us ? '' : ' hdn';
        
    ?>
    <div class="col-xs-12 col-md-4 mrg-b-lg <?php echo $hdn; ?> unit unit-type-<?php echo $us; ?>">
        <button type="button" class="inl-button col-xs-12 pad-none <?php echo $ucls; ?> txt-black bg-3-hover pad-b-md bdr-a-s-1 bdr-mid-grey cur-pnt unit-option" storman-code="<?php echo $code; ?>" storman-rate="<?php echo $unit['unitrate']; ?>">
            <?php
            if($unit['unitimage']!='')
                {
            ?>
            <div class="col-xs-12 pad-none"><img src="/_med/units/<?php echo $unit['unitimage']; ?>" alt="<?php echo $unit['unitname']; ?> Image" class="col-xs-12 pad-none" /></div>
            <?php
                }
            ?>
            <div class="col-xs-12 lh-40 txt-bl">Name: <?php echo $unit['unitname']; ?></div>
            <div class="col-xs-12">Category: <?php echo $unit['unitcategory']; ?></div>
            <div class="col-xs-12">Size: <?php echo $unit['unitwidth'].' x '.$unit['unitdepth']; ?></div>
            <div class="col-xs-12">Cost: <?php $this->regioning->currency();echo number_format($unit['unitrate'],2,'.',','); ?>/month</div>
            <?php
            if($unit['unitwebdesc']!='')
                {
            ?>
            <div class="col-xs-12 txt-sm lh-30 mrg-t-md"><?php echo $unit['unitwebdesc']; ?></div>
            <?php
                }
            ?>
        </button>
    </div>
    <?php        
        }
?>
	</div>
</div>
<div class="col-xs-12 mrg-b-md alert-error alg-ctr lh-50 hdn" id="unit-unmatched">
    No units match your criteria. Try a different combination.
</div>
<?php
    }
else
    {
?>
<div class="col-xs-12 mrg-b-md alert-error alg-ctr lh-50">
    <?php if($this->moveins->novacancy!=''){echo $this->moveins->novacancy;}else{echo 'No vacant units for this facility.';} ?>
</div>
<?php	
    }
?>    