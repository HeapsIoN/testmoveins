<div class="col-xs-12 pad-none mrg-t-lg mrg-b-lg lh-40 alg-ctr bdr-b-s-1 bdr-lgt-grey">
	<?php
	$c = count($this->page->steps);
	
	foreach($this->page->steps as $k => $step)
		{
		$i = $k+1==$c ? '' : ' <i class="fa fa-chevron-right lh-40 pull-right pad-lr-md"></i>';
		
		if($this->page->step==$k)
			{
		?>
        <div class="pull-left txt-5"><?php echo $step['name'].$i; ?></div>
        <?php
			}
		elseif($this->page->step >= $step['lockedfrom'])
			{
		?>
        <div class="pull-left txt-4"><?php echo $step['name'].$i; ?></div>
        <?php		
			}
		elseif($this->page->step > $k && $this->page->step < $step['lockedfrom'])
			{
			$u = $this->uri->segment(1)=='reservation' ? 'reservation/'.$step['url'] : $step['url'];
		?>
        <a href="/<?php echo $u; ?>" class="pull-left txt-3 txt-4-hover"><?php echo $step['name'].$i; ?></a>
        <?php		
			}
		else
			{
		?>
        <div class="pull-left txt-2"><?php echo $step['name'].$i; ?></div>
        <?php		
			}
		}
	?>
</div>