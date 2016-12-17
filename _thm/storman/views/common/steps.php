<div class="col-xs-12 bg-3 pad-none mrg-t-lg mrg-b-lg lh-50 alg-ctr">
	<?php
	$c = count($this->page->steps);
	
	foreach($this->page->steps as $k => $step)
		{
		$cls = $c==7 ? 'col-md-1_7' : 'col-md-2';
		
		if($this->page->step==$k)
			{
		?>
        <div class="col-xs-12 <?php echo $cls; ?> bg-2 txt-5"><?php echo $step['name']; ?></div>
        <?php
			}
		elseif($this->page->step >= $step['lockedfrom'])
			{
		?>
        <div class="col-xs-12 <?php echo $cls; ?> bg-5 txt-1"><?php echo $step['name']; ?></div>
        <?php		
			}
		elseif($this->page->step > $k && $this->page->step < $step['lockedfrom'])
			{
		?>
        <a href="/<?php echo $step['url']; ?>" class="col-xs-12 <?php echo $cls; ?> txt-1 bg-4-hover txt-1-hover"><?php echo $step['name']; ?></a>
        <?php		
			}
		else
			{
		?>
        <div class="col-xs-12 <?php echo $cls; ?> bg-5 txt-1"><?php echo $step['name']; ?></div>
        <?php		
			}
		}
	?>
</div>