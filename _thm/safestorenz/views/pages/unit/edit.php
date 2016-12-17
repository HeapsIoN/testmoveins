<div class="col-xs-12 col-sm-9 col-sm-offset-3 col-md-10 col-md-offset-2 pad-none">
	<form id="form" smp-process="unit" smp-action="save">
	<?php 
	$this->page->fields->text('', 'unid', 'index', '', '', 'hidden'); 
	$this->page->fields->text('', 'fcid', 'fcid', '', '', 'hidden'); 
	?>
    <h1 class="col-xs-12"><?php $this->page->heading('pagetitle'); ?></h1>
    <div class="col-xs-12 form-group">
		<p>Welcome to the unit manager. You can use this to create and manage units.</p>
        <p>This includes some advanced options, such as uploading an image and setting a description.</p>
        <p>Even if a unit is active, it might not appear in your online booking process. This is because the system will automatically exclude unit types that have no units available in StorMan.</p>
    </div>
    <div class="col-xs-12 form-group">
		<?php
		$this->page->fields->text('Facility', 'facilityname', 'facilityname', 'Search for a facility', 'bdr-3 txt-lg txt-4');
		?>
    </div>
    <div class="col-xs-12 form-group">
		<?php
		$this->page->fields->text('Unit Name', 'unitwebname', 'unitwebname', 'Enter the unit name', 'bdr-3 txt-lg txt-4');
		?>
    </div>
    <div class="col-xs-12 form-group">
		<?php
		$this->page->fields->text('Unit Code', 'unitcode', 'unitcode', 'Unit code', 'bdr-3 txt-lg txt-4');
		?>
    </div>
    <div class="col-xs-12 form-group">
		<?php
		$this->page->fields->toggle('Active', 'unitactive', 'unitactive');
		?>
    </div>
    <div class="col-xs-12 form-group">
		<?php
		$this->page->fields->text('Unit Width', 'unitwidth', 'unitwidth', 'Enter the width of the unit', 'col-xs-12 col-sm-6 col-md-2 bdr-3 txt-lg txt-4', '', '', '1');
		?>
    </div>
    <div class="col-xs-12 form-group">
		<?php
		$this->page->fields->text('Unit Depth', 'unitdepth', 'unitdepth', 'Enter the depth of the unit', 'col-xs-12 col-sm-6 col-md-2 bdr-3 txt-lg txt-4', '', '', '1');
		?>
    </div>
    <div class="col-xs-12 form-group">
		<?php
		$this->page->fields->text('Unit Rate', 'unitrate', 'unitrate', 'Enter the monthly rate for the unit', 'col-xs-12 col-sm-6 col-md-2 bdr-3 txt-lg txt-4', '', '', '1');
		?>
    </div>
    <div class="col-xs-12 form-group">
            <?php
            $this->page->fields->textarea('Web Desc.', 'unitwebdesc', 'unitwebdesc', '', '');
            ?>
        </div>
    <div class="col-xs-12 form-group">
		<?php
		$this->page->fields->button('Save Unit', '', 'form', 'bg-4 bg-5-hover txt-1 lh-60');
		?>
    </div>
    <?php
	$cls = !isset($this->page->record['unid']) || $this->page->record['unid']=='' ? ' needs-id' : '';
	?>
    <h2 class="col-xs-12<?php echo $cls; ?>">Unit Image</h2>
    <div class="col-xs-12 form-group<?php echo $cls; ?>" id="img-row">
    	<?php
		$img = isset($this->page->record['unitimage']) && $this->page->record['unitimage']!='' ? $this->page->record['unitimage'] : 'coming-soon.jpg';
		?>
        <img src="/_med/units/<?php echo $img; ?>" title="Unit Image" class="col-xs-12 col-sm-4 col-md-3 col-lg-2 col-sm-offset-3 col-md-offset-2" alt="" id="unit-image" />
    </div>
    <?php $lc = isset($this->page->record['unitimage']) && $this->page->record['unitimage']!='' ? '' : ' hdn'; ?>
    <div class="col-xs-12 pad-none form-group<?php echo $lc; ?>" id="del-img-row">
        <?php
        $this->page->fields->button('Delete Image', 'delete-image', 'logo', 'bg-4 bg-5-hover txt-1 lh-60 txt-uc txt-lg', 'button', 'delete-img');
        ?>
    </div>
    <div class="col-xs-12 form-group<?php echo $cls; ?>">
		<p>You can upload a unit image by dragging and dropping the logo into the space below.</p>
        <p>It is recommended that use a PNG file on a transparent background however a JPG image on a white background is also suitable.</p>
        <p>The recommended size for a unit image is 500px wide by 300px tall.</p>	
    </div>
    <div class="col-xs-12 col-sm-9 col-md-10 col-sm-offset-3 pad-none col-md-offset-2 form-group<?php echo $cls; ?>">
		<div class="col-xs-12 col-sm-6 col-md-4 pad-none pad-lr-md">
		<?php
		$this->page->fields->filedrop('unitphoto', 'unitphoto');
		?>
        </div>
    </div>
    <div class="col-xs-12 form-group<?php echo $cls; ?>">
		<?php
		$this->page->fields->button('Save Unit', '', 'form', 'bg-4 bg-5-hover txt-1 lh-60');
		?>
    </div>
    </form>
</div>