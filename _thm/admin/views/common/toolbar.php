<?php
if(!empty($this->page->toolbar))
	{
?>
<div class="col-xs-12 bg-2 lh-50" id="toolbar">
	<?php
	foreach($this->page->toolbar as $tool)
		{
		$cls = isset($tool['style']) && $tool['style']!='' ? ' '.$tool['style'] : '';
		
		switch($tool['type'])
			{
			case 'save'
			?>
            <button type="button" id="tb-btn-<?php echo $tool['id']; ?>" class="tb-tool tb-save pull-left bg-clear txt-4 txt-5-hover pad-lr-md mrg-r-md<?php echo $cls; ?>">
            	<i class="pull-left fa fa-<?php echo $tool['icon']; ?> txt-lg lh-50"></i>
                <?php echo $tool['lbl']; ?>
            </button>
            <?php
			break;
			case 'link' :
			?>
            <a href="<?php echo $tool['link']; ?>" id="tb-link-<?php echo $tool['id']; ?>" class="tb-tool tb-link pull-left txt-4 txt-5-hover pad-lr-md mrg-r-md<?php echo $cls; ?>">
            	<i class="pull-left fa fa-<?php echo $tool['icon']; ?> txt-lg lh-50"></i>
                <?php echo $tool['lbl']; ?>
            </a>
            <?php
			break;
			case 'button' :
			?>
            <button type="button" id="tb-btn-<?php echo $tool['id']; ?>" class="tb-tool tb-btn pull-left bg-clear txt-4 txt-5-hover pad-lr-md mrg-r-md<?php echo $cls; ?>">
            	<i class="pull-left fa fa-<?php echo $tool['icon']; ?> txt-lg lh-50"></i>
                <?php echo $tool['lbl']; ?>
            </button>
            <?php
			break;	
			}
		}
	?>
</div>
<?php
	}
?>