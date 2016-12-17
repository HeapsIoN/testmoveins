<div class="col-xs-12 col-sm-9 col-sm-offset-3 col-md-10 col-md-offset-2 pad-none form-tabs bg-2 bdr-t-s-1 bdr-3" id="form-tabs">
	<?php
	$tabs = array(	'main' 			=> 'Facility Info',
					'contact' 		=> 'Contact',
					'address' 		=> 'Address',
					'charges' 		=> 'Settings and Fees',
					'ezidebit' 		=> 'StorPay / EziDebit',
					'images' 		=> 'Images and Logo',
					'encryption' 	=> 'Encryption',
					'completed' 	=> 'Messages and Errors',
					);
	
	foreach($tabs as $k => $l)
		{
		$cls = $k=='main' ? ' bg-1' : '';
		?>
        <button type="button" class="form-tab cur-pnt pull-left pad-lr-md lh-50<?php echo $cls; ?>" sm-tab="<?php echo $k; ?>"><?php echo $l; ?></button>
        <?php	
		}
	?>
</div>
<div class="col-xs-12 col-sm-9 col-sm-offset-3 col-md-10 col-md-offset-2 pad-none">
	<form id="form" smp-process="facility" smp-action="save">
	<?php 
	$this->page->fields->text('', 'fcid', 'index', '', '', 'hidden');
	$this->page->fields->text('', 'coid', 'coid', '', '', 'hidden'); 
	?>
    
    <div class="col-xs-12 pad-none group" id="main">
        <h1 class="col-xs-12"><?php $this->page->heading('pagetitle'); ?></h1>
        <div class="col-xs-12 form-group">
            <p>Welcome to the facility manager.</p>	
            <p>Here you can setup individual facilities for the system.</p>
            <p>If you create a new facility, this will generate a password and email it to the email address for the facility.</p>
            <p>This will allow them to log in and start editing their facility profile and units.</p>
        </div>
        <div class="col-xs-12 form-group">
			<?php
			$this->page->fields->toggle('Active', 'facilityactive', 'facilityactive');
			?>
		</div>
        <div class="col-xs-12 form-group">
            <?php
            $this->page->fields->text('Facility Name', 'facilityname', 'facilityname', 'Enter the facility name', 'bdr-3 txt-lg txt-4', '', '', '', true);
            ?>
        </div>
        <div class="col-xs-12 form-group">
            <?php
            $this->page->fields->text('Company', 'companyname', 'companyname', 'Search for a company, if applicable', 'bdr-3 txt-lg txt-4');
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
            $this->page->fields->button('Save Facility', '', 'form', 'bg-4 bg-5-hover txt-1 lh-60');
            ?>
        </div>
        <div class="col-xs-12 form-group">
            <p>The system will automatically pull down unit types when a facility manager is logged in however as a system administrator, the system will not try and pull down every single facility when you go to the unit types section.</p>
            <p>You can however trigger a manual copy of the unit types for a facility by clicking on the button below.</p>
            <p>This will connect to StorMan, and copy across updated information for the unit types for that facility and if no local record exists for that unit type, then a new unit type will be added to the website.</p>
            <p>The system will always connect directly to StorMan when searching for unit types, this interface purely allows the facility to manage the image, title and web description for the unit type.</p>
        </div>
        <div class="col-xs-12 form-group">
            <?php
            $this->page->fields->button('Copy Units', 'copy-units', 'form', 'bg-3 bg-5-hover txt-uc txt-1 lh-60', 'button', 'copy-units');
            ?>
        </div>
	</div>
    
    <div class="col-xs-12 pad-none group group-hdn" id="contact">
        <h2 class="col-xs-12">Contact Info</h2>
        <div class="col-xs-12 form-group">
        	<p>This information is pulled out of StorMan. This is included here to show you what information is included on the portals.</p>
            <p>To update this, simply log into StorMan and modify the facility information from 'Maintenance' - 'System Setup'.</p>
        </div>
        <div class="col-xs-12 form-group">
            <?php
            $this->page->fields->text('Facility Contact', 'facilitycontact', 'facilitycontact', 'Enter the contact name for the facility', 'bdr-3 txt-lg txt-4 col-xs-12 col-md-3');
            ?>
        </div>
		<div class="col-xs-12 form-group">
            <?php
            $this->page->fields->text('Facility Email', 'facilityemail', 'facilityemail', 'Enter the contact email for the facility', 'bdr-3 txt-lg txt-4 col-xs-12 col-md-3', '', '', '', true);
            ?> 
        </div>
        <div class="col-xs-12 form-group">
            <?php
            $this->page->fields->text('Facility Phone', 'facilityphone', 'facilityphone', 'Enter the contact phone for the facility', 'bdr-3 txt-lg txt-4 col-xs-12 col-md-3', '', '', '', true);
            ?>
        </div>
        <div class="col-xs-12 form-group">
            <?php
            $this->page->fields->button('Save Facility', '', 'form', 'bg-4 bg-5-hover txt-1 lh-60');
            ?>
        </div>
	</div>
            
    <?php
	$cls = !isset($this->page->record['fcid']) || $this->page->record['fcid']=='' ? ' needs-id' : '';
	?>
    <div class="col-xs-12 pad-none group group-hdn" id="address">
        <h2 class="col-xs-12">Facility Address</h2>
        <div class="col-xs-12 form-group">
        	<p>This information is pulled out of StorMan. This is included here to show you what information is included on the portals.</p>
            <p>To update this, simply log into StorMan and modify the facility information from 'Maintenance' - 'System Setup'.</p>
        </div>
        <div class="col-xs-12 form-group">
            <?php
            $this->page->fields->text('Address', 'facilityaddressa', 'facilityaddressa', 'Enter the facility address', 'bdr-3 txt-lg txt-4', '', '', '', true);
            ?>
        </div>
        <div class="col-xs-12 form-group">
            <?php
            $this->page->fields->text('', 'facilitysuburb', 'facilitysuburb', 'Suburb / Town', 'col-sm-offset-3 col-md-offset-2 bdr-3 txt-lg txt-4', '', '', '', true);
            ?>
        </div>
        <div class="col-xs-12 form-group">
            <?php
            $this->page->fields->text('', 'facilitystate', 'facilitystate', 'State, if applicable (3 letters only)', 'col-xs-12 col-sm-6 col-md-3 col-sm-offset-3 col-md-offset-2 bdr-3 txt-lg txt-4', '', '', '', true);
            ?>
        </div>
        <div class="col-xs-12 form-group">
            <?php
            $this->page->fields->text('', 'facilitypostcode', 'facilitypostcode', 'Post / Zip Code', 'col-xs-12 col-sm-6 col-md-2 col-sm-offset-3 col-md-offset-2 bdr-3 txt-lg txt-4', '', '', '', true);
            ?>
        </div>
        <div class="col-xs-12 form-group">
            <?php
            $this->page->fields->button('Save Facility', '', 'form', 'bg-4 bg-5-hover txt-1 lh-60');
            ?>
        </div>
    </div>
    
    <div class="col-xs-12 pad-none group group-hdn" id="charges">
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
							'5' => 'Unit Category, Then Size Category, Then Unit Type'							
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
            $this->page->fields->toggle('Require Alt Contact', 'facilityrequirealt', 'facilityrequirealt');
            ?>
            <span class="pull-left lh-50 pad-lr-md">You can use this to specify if the alternate contact is required for the paperless move-ins.</span>
        </div>
        <div class="col-xs-12 form-group">
            <p>Please add the analysis code for your deposit fee, cleaning fee, late fee, and admin fees, if applicable.</p>
            <p>If left blank, these will not be included on your storage agreement.</p>
        </div>
        <div class="col-xs-12 form-group">
            <?php
            $this->page->fields->text('Deposit Code', 'facilitydeposit', 'facilitydeposit', 'Deposit analysis code', 'col-xs-12 col-sm-6 col-md-2 bdr-3 txt-lg txt-4');
            ?>
        </div>
        <div class="col-xs-12 form-group">
            <?php
            $this->page->fields->text('Cleaning Code', 'facilitycleaningfee', 'facilitycleaningfee', 'Cleaning fee analysis code', 'col-xs-12 col-sm-6 col-md-2 bdr-3 txt-lg txt-4');
            ?>
        </div>
        <div class="col-xs-12 form-group">
            <?php
            $this->page->fields->text('Admin Code', 'facilityadminfee', 'facilityadminfee', 'Admin fee analysis code', 'col-xs-12 col-sm-6 col-md-2 bdr-3 txt-lg txt-4 col-');
            ?>
        </div>
        <div class="col-xs-12 form-group">
            <?php
            $this->page->fields->text('Cheque Bounce Code', 'facilitychequefee', 'facilitychequefee', 'Bad cheque analysis code', 'col-xs-12 col-sm-6 col-md-2 bdr-3 txt-lg txt-4 col-');
            ?>
        </div>
        <div class="col-xs-12 form-group">
            <?php
            $this->page->fields->text('Late Fee Code', 'facilitylatefee', 'facilitylatefee', 'Late fee analysis code', 'col-xs-12 col-sm-6 col-md-2 bdr-3 txt-lg txt-4');
            ?>
        </div>
        <div class="col-xs-12 form-group">
            <p>Please enter the days late at which the fee is applied and the move out notice as actual numbers.</p>
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
            $this->page->fields->button('Save Facility', '', 'form', 'bg-4 bg-5-hover txt-1 lh-60');
            ?>
        </div>
    </div>
    
    <div class="col-xs-12 pad-none group group-hdn" id="ezidebit">
        <h2 class="col-xs-12">Facility EziDebit Config</h2>
        <div class="col-xs-12 form-group">
            <p>If you are using EziDebit or are registered with EziDebit you can accept your payments directly on this website.</p>
            <p>To accept payments via EziDebit from the website the system will need you EziDebit Public Key and the Analysis Code in StorMan for recording the payment.</p>
            <p>To add a new analysis code in StorMan simply go into 'Maintenance - Analysis Codes'. Switch the view to 'Receipts' and click 'Add New Code'.</p>
            <p>The input the Code for your payments, add a description and assign it to a 'Banking Analysis'. Normally you would use CCARD as the Banking Analysis code.</p> 
        </div>
        <div class="col-xs-12 form-group">
            <?php
            $this->page->fields->text('EziDebit Public Key', 'facilityedpubkey', 'facilityedpubkey', 'EziDebit Public Key', 'bdr-3 txt-lg txt-4');
            ?>
        </div>
        <div class="col-xs-12 form-group">
            <?php
            $this->page->fields->text('EziDebit Analysis Code', 'facilityezicardcode', 'facilityezicardcode', 'EziDebit analysis code', 'col-xs-12 col-sm-6 col-md-2 bdr-3 txt-lg txt-4');
            ?>
        </div>
        <div class="col-xs-12 form-group">
            <?php
            $this->page->fields->button('Save Facility', '', 'form', 'bg-4 bg-5-hover txt-1 lh-60');
            ?>
        </div>
    </div>
    
    
    <div class="col-xs-12 pad-none group group-hdn" id="images">
        <h2 class="col-xs-12<?php echo $cls; ?>">Facility Logo</h2>
        <div class="col-xs-12 form-group<?php echo $cls; ?>">
            <p>You can upload a company logo by dragging and dropping the logo into the space below.</p>
            <p>It is recommended that use a PNG file on a transparent background.</p>
            <p>The recommended size of the logo is 250px wide by 80px tall.</p>	
        </div>
        <div class="col-xs-12 col-sm-9 col-md-10 col-sm-offset-3 col-md-offset-2 pad-none form-group" id="logo-row">
        	<?php
			if(isset($this->page->record['facilitylogo']) && $this->page->record['facilitylogo']!='')
				{
			?>
            <img src="/_med/facilities/<?php echo $this->page->record['facilitylogo']; ?>" alt="" title="Facility Logo" class="facility-img" />
            <?php	
				}
			?>	
        </div>
        <div class="col-xs-12 col-sm-9 col-md-10 col-sm-offset-3 col-md-offset-2 pad-none form-group<?php echo $cls; ?>">
            <div class="col-xs-12 col-sm-6 col-md-4 pad-none form-group pad-lr-md">
            <?php
            $this->page->fields->filedrop('facilitylogo', 'facilitylogo');
            ?>
            </div>
        </div>
        <h2 class="col-xs-12<?php echo $cls; ?>">Email Header</h2>
        <div class="col-xs-12 form-group<?php echo $cls; ?>">
            <p>You can upload your own email header image.</p>
            <p>This is used in the email template when sending an email to customers with a copy of the agreement or the confirmation of payment if they are using on site payments via EziDebit.</p>
            <p>The image must be 800px wide by 150px tall.</p>
        </div>
		<div class="col-xs-12 col-sm-9 col-md-10 col-sm-offset-3 col-md-offset-2 pad-none form-group" id="eheader-row">
         	<?php
			if(isset($this->page->record['facilityemailheader']) && $this->page->record['facilityemailheader']!='')
				{
			?>
            <img src="/_med/facilities/header/<?php echo $this->page->record['facilityemailheader']; ?>" alt="" title="Facility Email Header" class="facility-img" />
            <?php	
				}
			?>	
        </div>
        <div class="col-xs-12 col-sm-9 col-md-10 col-sm-offset-3 col-md-offset-2 pad-none form-group<?php echo $cls; ?>">
            <div class="col-xs-12 col-sm-6 col-md-4 pad-none form-group pad-lr-md">
            <?php
            $this->page->fields->filedrop('facilityheader', 'facilityheader');
            ?>
            </div>
        </div>
        <h2 class="col-xs-12<?php echo $cls; ?>">Email Footer</h2>
        <div class="col-xs-12 form-group<?php echo $cls; ?>">
            <p>You can upload your own email header image.</p>
            <p>This is used in the email template when sending an email to customers with a copy of the agreement or the confirmation of payment if they are using on site payments via EziDebit.</p>
            <p>The image must be 210px wide by 60px tall.</p>	
        </div>
        <div class="col-xs-12 col-sm-9 col-md-10 col-sm-offset-3 col-md-offset-2 pad-none form-group" id="efooter-row">
         	<?php
			if(isset($this->page->record['facilityemailfooter']) && $this->page->record['facilityemailfooter']!='')
				{
			?>
            <img src="/_med/facilities/footer/<?php echo $this->page->record['facilityemailfooter']; ?>" alt="" title="Facility Email Footer" class="facility-img" />
            <?php	
				}
			?>	
        </div>
        <div class="col-xs-12 col-sm-9 col-md-10 col-sm-offset-3 col-md-offset-2 pad-none form-group<?php echo $cls; ?>">
            <div class="col-xs-12 col-sm-6 col-md-4 pad-none form-group pad-lr-md">
            <?php
            $this->page->fields->filedrop('facilityfooter', 'facilityfooter');
            ?>
            </div>
        </div>
	</div>
    
    <div class="col-xs-12 pad-none group group-hdn" id="encryption">
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
        <div class="col-xs-12 form-group<?php echo $cls; ?>">
            <?php
            $this->page->fields->button('Save Facility', '', 'form', 'bg-4 bg-5-hover txt-1 lh-60');
            ?>
        </div>
	</div>
    
    
    
    <div class="col-xs-12 pad-none group group-hdn" id="completed">
        <h2 class="col-xs-12">Completed Message Page</h2>
        <div class="col-xs-12 form-group">
            <p>If the connection to your server running StorMan goes down the system can include a button on the page allowing the customer to click through to a URL of your choosing.</p>
            <p>This might be an online contact form on your website or some other system that you have which can allow the customer to contact you directly.</p>
            <p>If this is left blank, no link will be included.</p>
        </div>
        <div class="col-xs-12 form-group">
            <?php
            $this->page->fields->text('Offline URL', 'facilityofflineurl', 'facilityofflineurl', 'Enter the URL to be used on the offline message page.', 'bdr-3 txt-lg txt-4');
            ?>
        </div>
        <div class="col-xs-12 form-group">
            <p>You can set a custom message on the completed page that is displayed after a successful order and payment.</p>
        </div>
        <div class="col-xs-12 form-group">
            <?php
            $this->page->fields->textarea('Completed Message', 'facilitycompletedmessage', 'facilitycompletedmessage', '', '');
            ?>
        </div>
        <div class="col-xs-12 form-group<?php echo $cls; ?>">
            <?php
            $this->page->fields->button('Save Facility', '', 'form', 'bg-4 bg-5-hover txt-1 lh-60');
            ?>
        </div>
	</div>
    
    </form>
</div>