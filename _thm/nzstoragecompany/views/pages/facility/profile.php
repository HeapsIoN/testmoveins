<div class="col-xs-12 col-sm-9 col-sm-offset-3 col-md-10 col-md-offset-2 pad-none">
	<form id="form" smp-process="facility" smp-action="save">
	<?php 
	$this->page->fields->text('', 'fcid', 'index', '', '', 'hidden');
	$this->page->fields->text('', 'coid', 'coid', '', '', 'hidden'); 
	?>
    <h1 class="col-xs-12"><?php $this->page->heading('pagetitle'); ?></h1>
    <div class="col-xs-12 form-group">
		<p>Welcome to the facility manager.</p>	
        <p>Here you can setup individual facilities for the system.</p>
        <p>If you create a new facility, this will generate a password and email it to the email address for the facility.</p>
        <p>This will allow them to log in and start editing their facility profile and units.</p>
    </div>
    <div class="col-xs-12 form-group">
		<?php
		$this->page->fields->text('Facility Name', 'facilityname', 'facilityname', 'Enter the facility name', 'bdr-3 txt-lg txt-4');
		?>
    </div>
    <div class="col-xs-12 form-group">
		<?php
		$this->page->fields->text('Facility Code', 'facilitycode', 'facilitycode', 'Enter the facility code', 'col-xs-12 col-sm-6 col-md-2 bdr-3 txt-lg txt-4');
		?>
    </div>
    <div class="col-xs-12 form-group">
		<?php
		$this->page->fields->text('Web Service URL', 'facilitywebserviceurl', 'facilitywebserviceurl', 'Enter the URL / IP for the StorMan installation', 'bdr-3 txt-lg txt-4');
		?>
    </div>
    <div class="col-xs-12 form-group">
		<?php
		$this->page->fields->text('Web Service Port', 'facilitywebserviceport', 'facilitywebserviceport', 'Enter the port number for the StorMan installation', 'col-xs-12 col-sm-6 col-md-2 bdr-3 txt-lg txt-4');
		?>
    </div>
    <div class="col-xs-12 form-group">
		<?php
		$this->page->fields->text('Web Service Password', 'facilitywebservicepass', 'facilitywebservicepass', 'Enter the facility web services password', 'col-xs-12 col-sm-6 col-md-2 bdr-3 txt-lg txt-4');
		?>
    </div>
    <div class="col-xs-12 form-group">
		<?php
		$this->page->fields->text('Facility Contact', 'facilitycontact', 'facilitycontact', 'Enter the contact name for the facility', 'bdr-3 txt-lg txt-4');
		?>
    </div>
    <div class="col-xs-12 form-group">
		<?php
		$this->page->fields->text('Facility Email', 'facilityemail', 'facilityemail', 'Enter the contact email for the facility', 'bdr-3 txt-lg txt-4');
		?>
    </div>
    <div class="col-xs-12 form-group">
		<?php
		$this->page->fields->text('Facility Phone', 'facilityphone', 'facilityphone', 'Enter the contact phone for the facility', 'bdr-3 txt-lg txt-4');
		?>
    </div>
    <div class="col-xs-12 form-group">
		<?php
		$this->page->fields->button('Save Profile', '', 'form', 'bg-4 bg-5-hover txt-1 lh-60');
		?>
    </div>
    
    <h2 class="col-xs-12">Update Password</h2>
    <div class="col-xs-12 form-group">
    	<p>You can change your password for the system from here.</p>
    </div>
    <div class="col-xs-12 form-group">
		<?php
		$this->page->fields->text('Update Password', 'pass', 'pass', 'Enter your new password', 'bdr-3 txt-lg txt-4', 'password');
		?>
    </div>
    <div class="col-xs-12 form-group">
		<?php
		$this->page->fields->text('Confirm Password', 'pasc', 'pasc', 'Confirm your new password', 'bdr-3 txt-lg txt-4', 'password');
		?>
    </div>
    
    <h2 class="col-xs-12">Facility Address</h2>
    <div class="col-xs-12 form-group">
    	<p>This information is pulled from StorMan and is only displayed for information purposes.</p>
        <p>If you want to update the address, simply log into StorMan and change your facility from "Maintenance - System Setup".</p>
    </div>
    <div class="col-xs-12 form-group">
		<?php
		$this->page->fields->text('Address', 'facilityaddressa', 'facilityaddressa', 'Enter the facility address', 'bdr-3 txt-lg txt-4', 'text', 'Data Missing', '', '1');
		?>
    </div>
    <div class="col-xs-12 form-group">
		<?php
		$this->page->fields->text('', 'facilityaddressb', 'facilityaddressb', 'Additional address field, if required', 'col-sm-offset-3 col-md-offset-2 bdr-3 txt-lg txt-4', 'text', 'Data Missing', '', '1');
		?>
    </div>
    <div class="col-xs-12 form-group">
		<?php
		$this->page->fields->text('', 'facilitysuburb', 'facilitysuburb', 'Suburb / Town', 'col-sm-offset-3 col-md-offset-2 bdr-3 txt-lg txt-4', 'text', 'Data Missing', '', '1');
		?>
    </div>
    <div class="col-xs-12 form-group">
		<?php
		$this->page->fields->text('', 'facilitystate', 'facilitystate', 'State, if applicable (3 letters only)', 'col-xs-12 col-sm-6 col-md-3 col-sm-offset-3 col-md-offset-2 bdr-3 txt-lg txt-4', 'text', 'Data Missing', '', '1');
		?>
    </div>
    <div class="col-xs-12 form-group">
		<?php
		$this->page->fields->text('', 'facilitypostcode', 'facilitypostcode', 'Post / Zip Code', 'col-xs-12 col-sm-6 col-md-2 col-sm-offset-3 col-md-offset-2 bdr-3 txt-lg txt-4', 'text', 'Data Missing', '', '1');
		?>
    </div>
    
    <h2 class="col-xs-12">Facility Config, Charges and Fees</h2>
    <div class="col-xs-12 form-group">
        <p>You can choose how the system will display the unit selection.</p>
        <p>This will use information from StorMan to display the different options for finding a unit.</p>
    </div>
    <div class="col-xs-12 form-group">
        <?php
        $opts = array(	'1' => 'Unit Types Only', 
                        '2' => 'Unit Category, Then Unit Type', 
                        '3' => 'Unit Size Category, Then Unit Type',
                        '4' => 'Unit Size Category, Then Unit Category, Then Unit Type',
                        '5' => 'Unit Unit Category, Then Size Category, Then Unit Type'							
                        );
        
        $this->page->fields->radio('Unit Selection Process', 'facilityunitmethod', 'facilityunitmethod', $opts);
        ?>
        <span class="pull-left lh-50 pad-lr-md">You can use this to specify if the alternate contact is required for the paperless move-ins.</span>
    </div>
    <div class="col-xs-12 form-group">
        <p>You can force the user to complete the secondary address contact. If they select a business account, this is automatically enforced.</p>
    </div>
    <div class="col-xs-12 form-group">
        <?php
        $this->page->fields->toggle('Require Alt Contact', 'facilityactive', 'facilityactive');
        ?>
        <span class="pull-left lh-50 pad-lr-md">You can use this to specify if the alternate contact is required for the paperless move-ins.</span>
    </div>
    <div class="col-xs-12 form-group">
        <p>Please add the analysis code for your deposit fee, cleaning fee, late fee, and admin fees, if applicable.</p>
        <p>If left blank, these will not be included on your storage agreement.</p>
    </div>
    <div class="col-xs-12 form-group">
		<?php
		$this->page->fields->toggle('Require Alt', 'facilityactive', 'facilityactive');
		?>
        <span class="pull-left lh-50 pad-lr-md">You can specify if the alternate address / contact is required for the online move-ins.</span>
    </div>
    <div class="col-xs-12 form-group">
		<?php
		$this->page->fields->text('Deposit Amount', 'facilitydeposit', 'facilitydeposit', 'Deposit analysis code', 'col-xs-12 col-sm-6 col-md-2 bdr-3 txt-lg txt-4');
		?>
    </div>
    <div class="col-xs-12 form-group">
		<?php
		$this->page->fields->text('Cleaning Fee', 'facilitycleaningfee', 'facilitycleaningfee', 'Cleaning fee analysis code', 'col-xs-12 col-sm-6 col-md-2 bdr-3 txt-lg txt-4');
		?>
    </div>
    <div class="col-xs-12 form-group">
		<?php
		$this->page->fields->text('Admin Fee', 'facilityadminfee', 'facilityadminfee', 'Admin fee analysis code', 'col-xs-12 col-sm-6 col-md-2 bdr-3 txt-lg txt-4 col-');
		?>
    </div>
    <div class="col-xs-12 form-group">
		<?php
		$this->page->fields->text('Cheque Bounce Fee', 'facilitychequefee', 'facilitychequefee', 'Bad cheque analysis code', 'col-xs-12 col-sm-6 col-md-2 bdr-3 txt-lg txt-4 col-');
		?>
    </div>
    <div class="col-xs-12 form-group">
    	<p>Please enter late fee amount, days late at which it is applied and the move out notice as actual numbers.</p>
    </div>
    <div class="col-xs-12 form-group">
		<?php
		$this->page->fields->text('Late Fee', 'facilitylatefee', 'facilitylatefee', 'Enter the late fee charge', 'col-xs-12 col-sm-6 col-md-2 bdr-3 txt-lg txt-4');
		?>
    </div>
    <div class="col-xs-12 form-group">
		<?php
		$this->page->fields->text('Days Late', 'facilitylatedays', 'facilitylatedays', 'Enter days', 'col-xs-12 col-sm-6 col-md-2 bdr-3 txt-lg txt-4');
		?>
        <span class="col-xs-12 col-sm-6 col-md-8 lh-50">(The number of days after the bill is due that the late fee is applied.)</span>
    </div>
    <div class="col-xs-12 form-group">
		<?php
		$this->page->fields->text('Move Out Notice', 'facilitymoveoutnotice', 'facilitymoveoutnotice', 'Enter days', 'col-xs-12 col-sm-6 col-md-2 bdr-3 txt-lg txt-4');
		?>
        <span class="col-xs-12 col-sm-6 col-md-8 lh-50">(The number of days days notice required for a move out.)</span>
    </div>
    <div class="col-xs-12 form-group">
		<?php
		$this->page->fields->button('Save Profile', '', 'form', 'bg-4 bg-5-hover txt-1 lh-60');
		?>
    </div>
    
    <h2 class="col-xs-12">Facility Logo</h2>
    <div class="col-xs-12 form-group">
		<p>You can upload a company logo by dragging and dropping the logo into the space below.</p>
        <p>It is recommended that use a PNG file on a transparent background.</p>
        <p>The recommended size of the logo is 250px wide by 80px tall.</p>	
    </div>
    <div class="col-xs-12 col-sm-9 col-md-10 col-sm-offset-3 col-md-offset-2 pad-none form-group">
		<div class="col-xs-12 col-sm-6 col-md-4 pad-none pad-lr-md">
		<?php
		$this->page->fields->filedrop('facilitylogo', 'facilitylogo');
		?>
        </div>
    </div>
    <div class="col-xs-12 form-group">
		<?php
		$this->page->fields->button('Save Profile', '', 'form', 'bg-4 bg-5-hover txt-1 lh-60');
		?>
    </div>
    
    <h2 class="col-xs-12">Client Password Encryption</h2>
    <div class="col-xs-12 form-group">
		<p>If you have a website that uses custom encryption for customer passwords, you can input the url that can be accessed to encrypt the password.</p>
        <p>The password will be encoded utilising CURL to connect to your URL and will submit a $_POST variable called smp_pass.</p>
        <p>Your website can then encrypt the password as needed and the system will look for a JSON response with a variable called 'encrypted'.</p>
    </div>
    <div class="col-xs-12 form-group">
		<?php
		$this->page->fields->text('Encryption URL', 'facilitycustomerencryption', 'facilitycustomerencryption', 'Enter the encryption sequence, if applicable', 'bdr-3 txt-lg txt-4');
		?>
    </div>
    <div class="col-xs-12 form-group">
		<?php
		$this->page->fields->button('Save Profile', '', 'form', 'bg-4 bg-5-hover txt-1 lh-60');
		?>
    </div>
    </form>
</div>