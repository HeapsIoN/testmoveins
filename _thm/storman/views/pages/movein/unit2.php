<div class="col-xs-12 pad-none">
	<?php
    
    if(!empty($this->moveins->unitcats) && !empty($this->moveins->units))
        {
    ?>
    <div class="col-xs-12 mrg-b-md">
        <p>Please select the unit you would like to rent from <?php echo $this->moveins->facinfo['facilityfullname']; ?>.</p>
    </div>
    <div class="col-xs-12 pad-none mrg-b-md " id="unit-categories">
        <div class="col-xs-12 mrg-t-lg mrg-b-lg">Start by selecting the unit category you want to view available units for.</div>
        <?php
        foreach($this->moveins->unitcats as $cat => $category)
            {
			$ccls = isset($this->moveins->order['unitcats']) && $this->moveins->order['unitcats']==$cat ? 'bg-7' : 'bg-2';
        ?>
        <div class="col-xs-12 col-md-4">
        <button type="button" class="inl-button lh-50 <?php echo $ccls; ?> bg-4-hover col-xs-12 unit-category" unit-category="<?php echo $cat; ?>">
            <?php echo $category; ?>		
        </button>
        </div>
        <?php		
            }
        ?>
    </div>
    <?php
	
	?>
    <div class="col-xs-12 pad-none mrg-b-md">
        <div class="col-xs-12 hdn unit-type-msg">Great. Now you can select a unit that you would like to rent.</div>
        <?php
        
        foreach($this->moveins->units as $code => $unit)
            {
            $uc = strtolower(str_replace(' ', '', $unit['unitcategory']));
            
			$ucls 	= isset($this->moveins->order['unitcode']) && $this->moveins->order['unitcode']==$code ? 'bg-7' : 'bg-2';
			$hdn 	= isset($this->moveins->order['unitcats']) && $this->moveins->order['unitcats']==$uc ? '' : ' hdn';
        ?>
        <div class="col-xs-12 col-md-4 mrg-b-lg <?php echo $hdn; ?> unit unit-type-<?php echo $uc; ?>">
            <button type="button" class="inl-button col-xs-12 pad-none <?php echo $ucls; ?> bg-3-hover txt-1-hover pad-b-md cur-pnt unit-option" storman-code="<?php echo $code; ?>" storman-rate="<?php echo $unit['unitrate']; ?>">
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