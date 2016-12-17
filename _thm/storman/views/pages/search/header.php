<form id="search" class="col-xs-12 col-sm-9 col-sm-offset-3 col-md-10 col-md-offset-2 pad-none" my-process="<?php echo strtolower($this->search->process); ?>" method="post" action="/<?php echo $this->search->base; ?>">
<div class="col-xs-12 lh-50 mrg-t-md" id="list-form">
	<div class="col-xs-12 pad-none bg-3 txt-1">
    <label class="src-lbl col-xs-12 col-sm-auto lh-50 txt-1" for="lookin">Search By</label>
	<?php
	
	$this->page->record['lookin'] = $this->search->lookin;
	
	$this->page->fields->select('', 'lookin', $this->search->options, 'search-input bdr-3 txt-4 col-xs-12 col-sm-2 pad-none', 'lookin', 'bdr-3', '');
	?>
    <label class="src-lbl col-xs-12 col-sm-auto lh-50 txt-1" for="lookfor">Look For</label>
    <input type="text" name="lookfor" id="lookfor" class="input search-input col-xs-12 col-sm-2 bg-vlg-grey bdr-3 txt-4" value="<?php echo $this->search->lookfor; ?>" placeholder="Input your search" autofocus="autofocus" />
    <?php
	if(!empty($this->search->filters))
		{
		$lbl = $this->search->filterlbl!='' ? $this->search->filterlbl : 'Filter By'; 
	?>
    <label class="src-lbl col-xs-12 col-sm-auto lh-50 txt-1" for="filter"><?php echo $lbl; ?></label>
	<?php
	$this->page->record['filter'] = $this->search->filter;
	
	$this->page->fields->select('', 'filter', $this->search->filters, 'search-input bdr-3 txt-4 col-xs-12 col-sm-2 pad-none', 'filter', 'bdr-3', 'Show All');
        }
    ?>
    <input type="hidden" name="limit" id="limit" value="<?php echo $this->search->limit; ?>" />
	<input type="hidden" name="orderby" id="orderby" value="<?php echo $this->search->orderby; ?>" />
    <input type="hidden" name="ordering" id="ordering" value="<?php echo $this->search->ordering; ?>" /> 
    <button type="button" id="process" class="btn col-xs-6 col-sm-auto pad-lr-md alg-ctr bg-brg-green txt-black bg-lgt-blue-hover"><i class="pull-left mrg-r-md txt-lg lh-50 fa fa-search"></i>Search</button>
    <button type="button" id="reset" class="btn col-xs-6 col-sm-auto pad-lr-md pull-right mrg-lft alg-ctr bg-pink txt-white bg-orange-hover txt-black-hover"><i class="pull-left mrg-r-md txt-lg lh-50 fa fa-undo"></i>Reset (Esc)</button>
    </div>
</div>

<div class="col-xs-12 lh-50 mrg-t-md" id="list-head">
	<div class="col-xs-12 pad-none bg-lgt-grey">
	<?php
	foreach($this->search->columns as $column => $settings)
		{
		$icn = '<span class="fa fa-sort list-icn pad-lr lh-40"></span>';
		$cls = '';
		if($settings['type']!='image' && $settings['type']!='sysicon' && $settings['type']!='imgicn')
			{
		$icn = '<span class="fa fa-sort list-icn pad-lr lh-40"></span>';
		$cls = '';
		if($this->search->orderby==$column)
			{
			$cls = ' list-hdr-active bg-lgt-blue txt-white txt-black-hover op-70';
			$icn = strtolower($this->search->ordering)=='asc' ? '<span class="fa fa-sort-up list-icn pad-l-sm"></span>' : '<span class="fa fa-sort-down list-icn pad-l-sm"></span>';
			}
	?>
    <span class="list-hdr lh-50 alg-cr txt-drk-grey col-xs-12 col-sm-<?php echo $settings['width'].$cls; ?>" order-by="<?php echo $column; ?>"><span class="col-xs-12 pad-none pad-lr"><?php echo $settings['label'].$icn; ?></span></span>
    <?php
			}
		}
	?>
    </div>
</div>