<p>&nbsp;</p>
<h2><?php $this->page->heading('pagetitle'); ?></h2>
<p>&nbsp;</p>
<form id="form" action="/customer" class="form-horizontal">
<input type="hidden" id="unitcode" name="unitcode" value="<?php if(isset($this->moveins->order['unitcode'])){echo $this->moveins->order['unitcode'];} ?>" />
<input type="hidden" id="unitrate" name="unitrate" value="<?php if(isset($this->moveins->order['unitrate'])){echo $this->moveins->order['unitrate'];} ?>" />
<input type="hidden" id="unitsizes" name="unitsizes" value="<?php if(isset($this->moveins->order['unitsizes'])){echo $this->moveins->order['unitsizes'];} ?>" />
<input type="hidden" id="unitcats" name="unitcats" value="<?php if(isset($this->moveins->order['unitcats'])){echo $this->moveins->order['unitcats'];} ?>" />
<div class="col-xs-12 pad-none">

   	
    <div class="col-xs-12 well">
		<legend>Unit Selection</legend>
        <p>You have selected <strong><?php echo $this->moveins->facinfo['facilityname']; ?></strong>. (Need to <a href="/facility" class="txt-3" style="text-decoration: underline;">choose a different facility</a>?)<br/>
        Please tell us when you need your unit &amp; what type / size of unit you require...</p>
<p>&nbsp;</p>
        <div class="form-group mrg-b-md">
            <label class="col-lg-2 control-label" for="dateselection">Date required</label>
            <div class="col-lg-2">
            <select class="form-control" name="ordermoveinday" id="ordermoveinday">
                <option value="">[ Day ]</option>
                <?php
                $days = range(1, 31);
                
                foreach($days as $day)
                    {
                    $lbl = $day;
                    $day = str_pad($day, 2, '0', STR_PAD_LEFT);
                    
                    $sel = isset($this->moveins->order['moveinday'])	&& $this->moveins->order['moveinday']==$day ? ' selected="selected"' : '';
                    
                    echo '<option value="'.$day.'"'.$sel.'>'.$lbl.'</option>';
                    }
                ?>                
            </select>
            </div>
            <div class="col-lg-2">
            <select class="form-control" name="ordermoveinmonth" id="ordermoveinmonth">
                <option value="">[ Month ]</option>
                <?php
                $months = array('01' => 'Jan', '02' => 'Feb', '03' => 'Mar', '04' => 'Apr', '05' => 'May', '06' => 'Jun', '07' => 'Jul', '08' => 'Aug', '09' => 'Sep', '10' => 'Oct', '11' => 'Nov', '12' => 'Dec');
                                
                foreach($months as $k => $month)
                    {
                    $sel = isset($this->moveins->order['moveinmonth'])	&& $this->moveins->order['moveinmonth']==$k ? ' selected="selected"' : '';
                    
                    echo '<option value="'.$k.'"'.$sel.'>'.$month.'</option>';
                    }
                ?>                
            </select>
            </div>
            <div class="col-lg-2">
            <select class="form-control" name="ordermoveinyear" id="ordermoveinyear">
                <option value="">[ Year ]</option>
                <?php
                $years = range(date('Y'),(date('Y')+1));
                
                foreach($years as $year)
                    {
                    $sel = isset($this->moveins->order['moveinyear'])	&& $this->moveins->order['moveinyear']==$year ? ' selected="selected"' : '';
                    
                    echo '<option value="'.$year.'"'.$sel.'>'.$year.'</option>';
                    }
                ?>                
            </select>
            </div>
		</div>
        <hr />
   	<?php
	
	$this->load->view('../../'.$this->page->theme.'/views/pages/movein/unit'.$this->moveins->facinfo['facilityunitmethod'], array());
	
	$hdn = isset($this->moveins->order['unitcode']) && isset($this->moveins->order['unitrate']) ? '' : ' storman-hdn';
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