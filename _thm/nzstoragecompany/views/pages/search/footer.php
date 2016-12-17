<div class="col-xs-12 mrg-t-md" id="list-foot">
	<div class="col-xs-12 pad-none bg-lgt-grey">
    <div class="paging-links col-xs-12 col-md-4 pad-none lh-50">
	<?php 
	if($this->pagination->create_links())
		{
		echo $this->pagination->create_links();
		}
	else
		{
		echo '&nbsp;';	
		}
	
	$lbl = $this->search->total > 1 ? 'Results' : 'Result';
	?>
    </div>
	<div class="paging-total col-xs-12 col-md-4 pad-none alg-cr txt-grey font-mini lh-50">
		<?php
		if($this->search->total==0)
			{
		?>
        No results found
        <?php
			}
		else
			{
		?>
        Total Of <?php echo number_format($this->search->total,0,'.', ',').' '.$lbl; ?>
        <?php	
			}
		?>
        
	</div>
    <div class="paging-rpps col-xs-12 col-md-4 alg-rt pad-none">
        <div class="pull-right alg-rt mrg-l-mdm">
        
        <?php
		$bgc = 'bg-3 txt-1';
		foreach($this->search->limits as $limit)
			{
			$act = $this->search->limit==$limit ? 'bg-2 txt-6' : $bgc;
		?>
		<button type="button" class="btn rpp-opt pull-left lh-50 pad-lr-md <?php echo $act; ?> bg-2-hover txt-6-hover" my-rpp="<?php echo $limit; ?>"><?php echo $limit; ?></button>
		<?php
			$bgc = $bgc=='bg-3 txt-1' ? 'bg-4 txt-1' : 'bg-3 txt-1';	
			}
		?>
        </div>
        <div class="pull-right src-lbl-foot lh-50 pad-r-md txt-grey" for="limit">Rows Per Page</div>
	</div>
    </div>
</div>
</form>