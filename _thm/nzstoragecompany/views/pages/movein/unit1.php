<div class="form-group mrg-b-md">
	<?php
    
    if(!empty($this->moveins->units))
        {
    ?>
    <label class="col-lg-2 control-label" for="expirymonth">Select a unit</label>
    <div class="col-lg-10 pad-none mrg-b-md">
        <?php
        
        foreach($this->moveins->units as $code => $unit)
            {
			$cls = isset($this->moveins->order['unitcode']) && $this->moveins->order['unitcode']==$code ? 'bg-7' : '';
        ?>
        <div class="col-xs-12 col-md-4 mrg-b-lg unit unit-type">
            <button type="button" class="inl-button col-xs-12 pad-none <?php echo $cls; ?> txt-black bg-3-hover pad-b-md bdr-a-s-1 bdr-mid-grey cur-pnt unit-option" storman-code="<?php echo $code; ?>" storman-rate="<?php echo $unit['unitrate']; ?>">
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
</div>
