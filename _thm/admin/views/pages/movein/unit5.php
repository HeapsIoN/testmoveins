<?php

if(!empty($this->moveins->unittypes) && !empty($this->moveins->unitcats) && !empty($this->moveins->units))
    {
?>
<div class="form-group mrg-b-md" id="unit-categories">
	<label class="col-lg-2 control-label" for="unit-category">Unit type</label>
	<div class="col-lg-4">
	<select id="unit-category" class="form-control">
		<option value="">[ Select Unit Type ]</option>
	<?php
	foreach($this->moveins->unitcats as $cat => $category)
		{
		$sel = isset($this->moveins->order['unitcats']) && $this->moveins->order['unitcats']==$cat ? ' selected="selected"' : '';
	?>
		<option value="<?php echo $cat; ?>" class="unit-cat unit-cat"<?php echo $sel; ?>><?php echo $category; ?></option>	
	<?php		
		}
	?>
	</select>
	</div>
</div>
<?php
$swcls =  isset($this->moveins->order['unitsizes']) ? '' : ' hdn';
?>
<div class="form-group mrg-b-md<?php echo $swcls; ?>" id="unit-sizes">
	<label class="col-lg-2 control-label" for="unit-size">Unit size</label>
	<div class="col-lg-4">
	<select id="unit-size" class="form-control">
		<option value="">[ Select Unit Size ]</option>
	<?php
	foreach($this->moveins->unittypes as $siz => $size)
		{
		$sel = isset($this->moveins->order['unitsizes']) && $this->moveins->order['unitsizes']==$siz ? ' selected="selected"' : '';
		$szs = ' unit-size-'.implode(' unit-size-', $size['cats']);
	?>
		<option value="<?php echo $siz; ?>" class="unit-size<?php echo $szs;?>"<?php echo $sel; ?>><?php echo $size['size']; ?></option>	
	<?php		
		}
	?>
	</select>
	</div>
</div>



<div class="form-group mrg-b-md" id="unit-types">
    <?php $mhdn = isset($this->moveins->order['unitcode']) ? '' : ' hdn'; ?>
    <label class="col-lg-2 control-label unit-type-msg<?php echo $mhdn; ?>">Select a unit</label>
	<div class="col-lg-10 pad-none mrg-b-md unit-type-msg<?php echo $mhdn; ?>">
    <?php
    
    foreach($this->moveins->units as $code => $unit)
        {
        $uc = strtolower(str_replace(' ', '', $unit['unitcategory']));
        $us = strtolower(str_replace(' ', '', $unit['unitsizecat']));
        $ucls = '';
		$hdn = ' hdn';
		
        if(isset($this->moveins->order['unitcode']) && $this->moveins->order['unitcode']==$code)
			{
			$ucls = 'bg-7';
			$hdn = '';	
			}
    ?>
    <div class="col-xs-12 col-md-4 mrg-b-lg <?php echo $hdn; ?> unit unit-type-<?php echo $uc.$us; ?>">
        <button type="button" class="inl-button col-xs-12 pad-none <?php echo $ucls; ?> txt-black bg-3-hover pad-b-md bdr-a-s-1 bdr-mid-grey cur-pnt unit-option" storman-code="<?php echo $code; ?>" storman-rate="<?php echo $unit['unitrate']; ?>" storman-deposit="<?php echo $unit['unitdeposit']; ?>">
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
            <div class="col-xs-12">Size: <?php echo $unit['unitwidth'].' x '.$unit['unitdepth']; ?>*</div>
            <div class="col-xs-12">Cost: <?php $this->regioning->currency();echo number_format($unit['unitrate'],2,'.',','); ?>/month</div>
            <?php
            if($unit['unitwebdesc']!='')
                {
            ?>
            <div class="col-xs-12 txt-sm lh-30 mrg-t-md"><?php echo $unit['unitwebdesc']; ?>*</div>
            <?php
                }
            ?>
        </button>
    </div>
    <?php        
        }
	?>
    </div>
    <div class="col-xs-12 txt-sm unit-msg">
    	* Please note that unit sizes are estimates only and the actual dimensions of your unit may vary<br />
		If you have specific dimensional requirements please contact the Facility to discuss.
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
    <?php echo $this->moveins->novacancy; ?>
</div>
<?php	
    }
?>    