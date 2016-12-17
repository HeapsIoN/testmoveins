<div class="col-xs-12 col-sm-9 col-sm-offset-3 col-md-10 col-md-offset-2 pad-none">
	<form id="form" smp-process="user" smp-action="save">
	<?php 
	$this->page->fields->text('', 'usid', 'index', '', '', 'hidden'); 
	?>
    <h1 class="col-xs-12"><?php $this->page->heading('pagetitle'); ?></h1>
    <div class="col-xs-12 form-group">
		<?php
		$this->page->fields->toggle('Active', 'useractive', 'useractive');
		?>
    </div>
    <div class="col-xs-12 form-group">
		<?php
		$this->page->fields->toggle('Sys Admin', 'useradmin', 'useradmin');
		?>
    </div>
    <div class="col-xs-12 form-group">
		<?php
		$this->page->fields->text('User Name', 'username', 'username', 'Enter the username', 'bdr-3 txt-lg txt-4');
		?>
    </div>
    <div class="col-xs-12 form-group">
		<?php
		$this->page->fields->text('User Email', 'useremail', 'useremail', 'Enter the users email', 'bdr-3 txt-lg txt-4');
		?>
    </div>
    <h2 class="col-xs-12">Update Password</h1>
    <div class="col-xs-12 form-group">
		<?php
		$this->page->fields->text('Update Password', 'pass', 'pass', 'Enter your new password', 'bdr-3 txt-lg txt-4', 'password', '');
		?>
    </div>
    <div class="col-xs-12 form-group">
		<?php
		$this->page->fields->text('Confirm Password', 'pasc', 'pasc', 'Confirm your new password', 'bdr-3 txt-lg txt-4', 'password');
		?>
    </div>
    
    <div class="col-xs-12 form-group">
		<?php
		$this->page->fields->button('Save Profile', '', 'form', 'bg-4 bg-5-hover txt-1 lh-60');
		?>
    </div>
    </form>
</div>