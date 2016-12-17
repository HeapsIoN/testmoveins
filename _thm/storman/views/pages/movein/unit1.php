<div class="col-xs-12 pad-none">
	<?php
    
    if(!empty($this->moveins->units))
        {
    ?>
    <div class="col-xs-12 mrg-b-md">
        <p>Please select the unit you would like to rent from <?php echo $this->moveins->facinfo['facilityfullname']; ?>.</p>
    </div>
    <div class="col-xs-12 pad-none mrg-b-md">
        <?php
        
        foreach($this->moveins->units as $code => $unit)
            {
			$cls = isset($this->moveins->order['unitcode']) && $this->moveins->order['unitcode']==$code ? 'bg-7' : 'bg-2';
        ?>
        <div class="col-xs-12 col-md-4 mrg-b-lg unit unit-type">
            <button type="button" class="inl-button col-xs-12 pad-none <?php echo $cls; ?> bg-3-hover txt-1-hover pad-b-md cur-pnt unit-option" storman-code="<?php echo $code; ?>" storman-rate="<?php echo $unit['unitrate']; ?>">
                <h2 class="col-xs-12 mrg-none txt-xl lh-2x"><?php echo $unit['unitname']; ?></h2>
                <?php
                if($unit['unitimage']!='')
                    {
                ?>
                <div class="col-xs-12 pad-none bg-4"><img src="/_med/units/<?php echo $unit['unitimage']; ?>" alt="<?php echo $unit['unitname']; ?> Image" class="col-xs-12 pad-none" /></div>
                <?php
                    }
                ?>
                <div class="col-xs-12 alg-xs-lft pad-t-md col-md-4 alg-md-rgt txt-md txt-uc lh-50 unit-lbl">Size</div>
                <div class="col-xs-12 col-md-8 pad-none pad-t-md txt-lg txt-4 lh-50 unit-data"><?php echo $unit['unitwidth'].' x '.$unit['unitdepth']; ?></div>
                <div class="col-xs-12 alg-xs-lft col-md-4 alg-md-rgt txt-md txt-uc lh-50 unit-lbl">Rate</div>
                <div class="col-xs-12 col-md-8 pad-none txt-lg txt-4 lh-50 unit-data">$<?php echo number_format($unit['unitrate'],2,'.',','); ?>/month</div>
                <?php
                if($unit['unitwebdesc']!='')
                    {
                ?>
                <div class="col-xs-12 txt-md txt-4 lh-40"><?php echo $unit['unitwebdesc']; ?></div>
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
