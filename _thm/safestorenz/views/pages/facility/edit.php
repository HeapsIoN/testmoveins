<div class="col-xs-12 col-sm-9 col-sm-offset-3 col-md-10 col-md-offset-2 pad-none form-tabs bg-2 bdr-t-s-1 bdr-3" id="form-tabs">
	<?php
	$tabs = array(	'main' 			=> 'Facility Info',
					'contact' 		=> 'Contact',
					'address' 		=> 'Address',
					'charges' 		=> 'Settings and Fees',
					'ezidebit' 		=> 'StorPay / EziDebit',
					'images' 		=> 'Images, Logo and PDFs',
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
            <p>After you save the facility, the system will use the details for the connection and copy across other information about the facility.</p>
            <p>You can also copy across the unit types below once the facility is saved.</p>
            <p><i class="ion-alert txt-lg pad-r-md pull-left lh-40 txt-orange"></i><b>N.B.</b> You should go through all of the tabs on this page to ensure your facility is properly configured. Some settings such as inputting analysis codes, choosing the unit selection method for customers and choosing the payment method you want to use.</p>
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
        <?php
		if($this->page->user['group']=='admin')
			{
		?>
        <div class="col-xs-12 form-group">
            <?php
            $this->page->fields->text('Company', 'companyname', 'companyname', 'Search for a company, if applicable', 'bdr-3 txt-lg txt-4');
            ?>
        </div>
        <?php
			}
		?>
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
			$opts = array(	'AU' => 'Australia', 
							'NZ' => 'New Zealand',
							'CA' => 'Canada',
							'TH' => 'Thailand',
							'SA' => 'South Africa'
							);
			
            $this->page->fields->radio('Region', 'facilityregion', 'facilityregion', $opts, 'col-xs-12 col-sm-6 col-lg-4');
            ?>
            <span class="pull-left lh-50 pad-lr-md">Use this to select the unit selection method selected by customers.</span>
        </div>
        <div class="col-xs-12 form-group">
			<?php
            $this->page->fields->button('Save Facility', '', 'form', 'bg-4 bg-5-hover txt-1 lh-60');
            ?>
        </div>
        <h2 class="col-xs-12">Unit Copy</h2>
        <div class="col-xs-12 form-group">
            <p>You can copy across the units for the facility <u>AFTER</u> saving it by clicking on the button below IF you have put in the web service settings above.</p>
            <p>This will connect to Storman, and copy across updated information for the unit types for that facility by the unit type code.</p>
            <p>If no local record exists for that unit type, then a new unit type will be added to the local system.</p>
            <p>The system will always connect directly to Storman when searching checking unit types for customers when ordering, this interface purely allows the facility to manage the image, title and web description for the unit type.</p>
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
            <p>This section contains a range of settings for the facility including how users select units, if the secondary contact is required and setting the analysis codes for various fees as configured in Storman.</p>
            <p>
        </div>
        
        
        <h2 class="col-xs-12">Unit Selection Method</h2>
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
			
            $this->page->fields->radio('Unit Selection Process', 'facilityunitmethod', 'facilityunitmethod', $opts, 'col-xs-12 col-sm-6 col-lg-4');
            ?>
            <span class="pull-left lh-50 pad-lr-md">Use this to select the unit selection method selected by customers.</span>
        </div>
        
        
        <h2 class="col-xs-12">Payments</h2>
        <div class="col-xs-12 form-group">
            <p>You can use this to select if you want to take payment on the website or not.</p>
            <p>You would set this to NO if you want to provide customers with a tablet in store for the signup but then want to take payment over the counter.</p>
            <p>If you set this to NO, when the users reviews the contract, signs and continues, it will add the order to Storman and they will then be directed to the completed page.</p>
            <p>You can set your own message on the Completed page from the "Messages and Errors" section (last tab).</p>
        </div>
        <div class="col-xs-12 form-group">
            <?php
            $this->page->fields->toggle('Require Payment', 'facilityrequirepayment', 'facilityrequirepayment');
            ?>
            <span class="pull-left lh-50 pad-lr-md">Enable this option if you require payment for a new move-in.</span>
        </div>
        
        
        <h2 class="col-xs-12">Alternate Contact</h2>
        <div class="col-xs-12 form-group">
            <p>You can force the user to complete the secondary address contact. If they select a business account, this is automatically enforced.</p>
        </div>
        <div class="col-xs-12 form-group">
            <?php
            $this->page->fields->toggle('Require Alt Contact', 'facilityrequirealt', 'facilityrequirealt');
            ?>
            <span class="pull-left lh-50 pad-lr-md">You can use this to specify if the alternate contact is required for the paperless move-ins.</span>
        </div>
        
        <h2 class="col-xs-12">Storer Check</h2>
        <div class="col-xs-12 form-group">
            <p>You can select if you want the customer to have to accept the Storer Check before proceeding.</p>
            <p>If you DO NOT enable this, the customer will be able to accept the contract and submit the agreement into Storman without accepting the Storer Check.</p> 
        </div>
        <div class="col-xs-12 form-group">
            <?php
            $this->page->fields->toggle('Require Storer Check', 'facilityrequirestorer', 'facilityrequirestorer');
            ?>
            <span class="pull-left lh-50 pad-lr-md">You can use this to specify if the customer MUST agree to the Storer Check or not.</span>
        </div>
        
        
        
        <h2 class="col-xs-12">Fees and Charges</h2>
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
        <div class="col-xs-12 col-sm-9 col-md-10 col-sm-offset-3 col-md-offset-2 form-group">
            <p><i class="ion-alert txt-lg pad-r-md txt-orange"></i>Please enter the days late at which the fee is applied and the move out notice as actual numbers.</p>
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
            <span class="col-xs-12 col-sm-6 col-md-8 lh-50">(The number of days notice required for a move out.)</span>
        </div>
        <div class="col-xs-12 form-group">
            <?php
            $this->page->fields->button('Save Facility', '', 'form', 'bg-4 bg-5-hover txt-1 lh-60');
            ?>
        </div>
    </div>
    
    <div class="col-xs-12 pad-none group group-hdn" id="ezidebit">
        
        <h2 class="col-xs-12">Facility Deposit Settings</h2>
        <div class="col-xs-12 form-group">
            <p>You can select if you want to take the first months rent in addition to the deposit from the customer.</p>
            <p>If set to yes, then this will in fact include the first month rent when displaying the summary of the amount.</p>
            <p>If you are a StorPay user, and leave the below EziDebit Public Key blank, when the customer accepts the contract it will add the agreement to the system and then process the billing for that customer to add the next month to their balance.</p>
            <p>If you have set this to NO and both the global deposit and the unit type deposit set to $0.00, this will revert to YES to ensure that a payment is takent at the time of the order.</p>
            <p>Payment is required to complete the process and ensure the customer is emailed a copy of the agreement and any applicable PDFs, along with details of the payment.</p>
        </div>
        <div class="col-xs-12 form-group">
            <?php
            $this->page->fields->toggle('First Month Rent', 'facilityfirstmonth', 'facilityfirstmonth');
            ?>
            <span class="pull-left lh-50 pad-lr-md">Include first month rent in deposit</span>
        </div>
        
        <h2 class="col-xs-12">Facility StorPay Config</h2>
        <div class="col-xs-12 form-group">
            <p>If you are using StorPay, you can input the code for your login URL below.</p> 
            <p>If you leave this blank, the system will revert to the StorMan default.</p>
            <p>Your code is the "xxxxxx" part of the URL below.</p>
            <p>https://www.storpay.com/4DCGI/storpay/xxxxxx/login.shtml</p>
            <p>Simply input your code for StorPay.</p>
            <p>When the customer gets to the payment page, they will be redirected to the StorPay URL and the system will attempt to log them in.</p>
        </div>
        <div class="col-xs-12 form-group">
            <?php
            $this->page->fields->text('StorPay URL', 'facilitystorpayurl', 'facilitystorpayurl', 'StorPay URL', 'bdr-3 txt-lg txt-4');
            ?>
        </div>
        
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
        	<p>Please indicate the card types that you want to make available on the payment screen.</p>
            <p>You must select at least 1 card type.</p>
        </div>
        <div class="col-xs-12 form-group">
            <?php
            $this->page->fields->toggle('Visa', 'facilityezivisa', 'facilityezivisa');
            ?>
        </div>
        <div class="col-xs-12 form-group">
            <?php
            $this->page->fields->text('Visa Analysis Code', 'facilityezicardvisa', 'facilityezicardvisa', 'Visa analysis code', 'col-xs-12 col-sm-6 col-md-2 bdr-3 txt-lg txt-4');
            ?>
        </div>
        <div class="col-xs-12 form-group">
            <?php
            $this->page->fields->toggle('Mastercard', 'facilityezimastercard', 'facilityezimastercard');
            ?>
        </div>
        <div class="col-xs-12 form-group">
            <?php
            $this->page->fields->text('Mastercard Analysis Code', 'facilityezicardmaster', 'facilityezicardmaster', 'Mastercard analysis code', 'col-xs-12 col-sm-6 col-md-2 bdr-3 txt-lg txt-4');
            ?>
        </div>
        <div class="col-xs-12 form-group">
            <?php
            $this->page->fields->toggle('Amex', 'facilityeziamex', 'facilityeziamex');
            ?>
        </div>
        <div class="col-xs-12 form-group">
            <?php
            $this->page->fields->text('Amex Analysis Code', 'facilityezicardamex', 'facilityezicardamex', 'Amex analysis code', 'col-xs-12 col-sm-6 col-md-2 bdr-3 txt-lg txt-4');
            ?>
        </div>
        <div class="col-xs-12 form-group">
            <?php
            $this->page->fields->toggle('Diners', 'facilityezidiners', 'facilityezidiners');
            ?>
        </div>
        <div class="col-xs-12 form-group">
            <?php
            $this->page->fields->text('Diners Analysis Code', 'facilityezicarddiners', 'facilityezicarddiners', 'Diners analysis code', 'col-xs-12 col-sm-6 col-md-2 bdr-3 txt-lg txt-4');
            ?>
        </div>
		<?php
		/*
        <div class="col-xs-12 form-group">
            <?php
            $this->page->fields->text('EziDebit Analysis Code', 'facilityezicardcode', 'facilityezicardcode', 'EziDebit analysis code', 'col-xs-12 col-sm-6 col-md-2 bdr-3 txt-lg txt-4');
            ?>
        </div>
		*/
		?>
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
        <?php $lc = isset($this->page->record['facilitylogo']) && $this->page->record['facilitylogo']!='' ? '' : ' hdn'; ?>
        <div class="col-xs-12 pad-none form-group<?php echo $lc; ?>" id="del-logo-row">
			<?php
            $this->page->fields->button('Delete Logo', 'delete-logo', 'logo', 'bg-4 bg-5-hover txt-1 lh-60', 'button', 'delete-img');
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
		<div class="col-xs-12 col-sm-9 col-md-10 col-sm-offset-3 col-md-offset-2 pad-none form-group" id="header-row">
         	<?php
			if(isset($this->page->record['facilityemailheader']) && $this->page->record['facilityemailheader']!='')
				{
			?>
            <img src="/_med/facilities/header/<?php echo $this->page->record['facilityemailheader']; ?>" alt="" title="Facility Email Header" class="facility-img" />
            <?php	
				}
			?>
        </div>
        <?php $hc = isset($this->page->record['facilityemailheader']) && $this->page->record['facilityemailheader']!='' ? '' : ' hdn'; ?>
        <div class="col-xs-12 pad-none form-group<?php echo $hc; ?>" id="del-header-row">
			<?php
            $this->page->fields->button('Delete Header', 'delete-header', 'header', 'bg-4 bg-5-hover txt-1 lh-60', 'button', 'delete-img');
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
        <div class="col-xs-12 col-sm-9 col-md-10 col-sm-offset-3 col-md-offset-2 pad-none form-group" id="footer-row">
         	<?php
			if(isset($this->page->record['facilityemailfooter']) && $this->page->record['facilityemailfooter']!='')
				{
			?>
            <img src="/_med/facilities/footer/<?php echo $this->page->record['facilityemailfooter']; ?>" alt="" title="Facility Email Footer" class="facility-img" />
            <?php	
				}
			?>	
        </div>
        <?php $fc = isset($this->page->record['facilityemailfooter']) && $this->page->record['facilityemailfooter']!='' ? '' : ' hdn'; ?>
        <div class="col-xs-12 pad-none form-group<?php echo $fc; ?>" id="del-footer-row">
			<?php
            $this->page->fields->button('Delete Footer', 'delete-footer', 'footer', 'bg-4 bg-5-hover txt-1 lh-60', 'button', 'delete-img');
            ?>
        </div>
        <div class="col-xs-12 col-sm-9 col-md-10 col-sm-offset-3 col-md-offset-2 pad-none form-group<?php echo $cls; ?>">
            <div class="col-xs-12 col-sm-6 col-md-4 pad-none form-group pad-lr-md">
            <?php
            $this->page->fields->filedrop('facilityfooter', 'facilityfooter');
            ?>
            </div>
        </div>
        
        
        <h2 class="col-xs-12<?php echo $cls; ?>">Facility Privacy Disclosure Statement</h2>
        <div class="col-xs-12 form-group<?php echo $cls; ?>">
            <p>You can upload your own privacy disclosure statement for use on the site.</p>
            <p>The file MUST BE A PDF! The file upload is restricted to only allow pdf files.</p>
            <p>This is to ensure that the visitor can open it in their web browser or open it using free software if they are on a mobile.</p>	
        </div>
        <div class="col-xs-12 pad-none form-group" id="privacy-row">
        	<?php
			if(isset($this->page->record['facilityprivacypolicy']) && $this->page->record['facilityprivacypolicy']!='')
				{
			?>
            <a href="/_med/facilities/privacy/<?php echo $this->page->record['facilityprivacypolicy']; ?>" class="facility-pdf btn col-xs-12 col-sm-6 col-md-4 col-sm-offset-3 col-md-offset-2 bg-4 bg-5-hover txt-1 lh-60 alg-cr" target="_blank">Download Privacy Disclosure Statement</a>
            <?php	
				}
			?>	
        </div>
        <?php $pc = isset($this->page->record['facilityprivacypolicy']) && $this->page->record['facilityprivacypolicy']!='' ? '' : ' hdn'; ?>
        <div class="col-xs-12 pad-none form-group<?php echo $pc; ?>" id="del-privacy-row">
			<?php
            $this->page->fields->button('Delete Privacy Disclosure Statement', 'delete-privacy', 'privacy', 'bg-4 bg-5-hover txt-1 lh-60', 'button', 'delete-pdf');
            ?>
        </div>
        <div class="col-xs-12 col-sm-9 col-md-10 col-sm-offset-3 col-md-offset-2 pad-none form-group<?php echo $cls; ?>">
            <div class="col-xs-12 col-sm-6 col-md-4 pad-none form-group pad-lr-md">
            <?php
            $this->page->fields->filedrop('facilityprivacy', 'facilityprivacy');
            ?>
            </div>
        </div>
        
        
        
        <h2 class="col-xs-12<?php echo $cls; ?>">Facility Insurance Policy</h2>
        <div class="col-xs-12 form-group<?php echo $cls; ?>">
            <p>You can upload your own insurance policy for use on the site.</p>
            <p>The file MUST BE A PDF! The file upload is restricted to only allow pdf files.</p>
            <p>This is to ensure that the visitor can open it in their web browser or open it using free software if they are on a mobile.</p>	
        </div>
        <div class="col-xs-12 pad-none form-group" id="insurance-row">
        	<?php
			if(isset($this->page->record['facilityinsurancepolicy']) && $this->page->record['facilityinsurancepolicy']!='')
				{
			?>
            <a href="/_med/facilities/insurance/<?php echo $this->page->record['facilityinsurancepolicy']; ?>" class="facility-pdf btn col-xs-12 col-sm-6 col-md-4 col-sm-offset-3 col-md-offset-2 bg-4 bg-5-hover txt-1 lh-60 alg-cr" target="_blank">Download Insurance Policy</a>
            <?php	
				}
			?>	
        </div>
        <?php $ic = isset($this->page->record['facilityinsurancepolicy']) && $this->page->record['facilityinsurancepolicy']!='' ? '' : ' hdn'; ?>
        <div class="col-xs-12 pad-none form-group<?php echo $ic; ?>" id="del-insurance-row">
			<?php
            $this->page->fields->button('Delete Insurance Policy', 'delete-insurance', 'insurance', 'bg-4 bg-5-hover txt-1 lh-60', 'button', 'delete-pdf');
            ?>
        </div>
        <div class="col-xs-12 col-sm-9 col-md-10 col-sm-offset-3 col-md-offset-2 pad-none form-group<?php echo $cls; ?>">
            <div class="col-xs-12 col-sm-6 col-md-4 pad-none form-group pad-lr-md">
            <?php
            $this->page->fields->filedrop('facilityinsurance', 'facilityinsurance');
            ?>
            </div>
        </div>
        
        <h2 class="col-xs-12<?php echo $cls; ?>">Facility Email Attachment PDF</h2>
        <div class="col-xs-12 form-group<?php echo $cls; ?>">
            <p>You can upload your own PDF to be attached to the email that is sent to the customer when they complete an order.</p>
            <p>The file MUST BE A PDF! The file upload is restricted to only allow pdf files.</p>
            <p>This is to ensure that the visitor can open it in their web browser or open it using free software if they are on a mobile.</p>	
            <p>This can be an information sheet, sales brochure or welcome pack.</p>
        </div>
        <div class="col-xs-12 pad-none form-group" id="emailfile-row">
        	<?php
			if(isset($this->page->record['facilityemailfile']) && $this->page->record['facilityemailfile']!='')
				{
			?>
            <a href="/_med/facilities/emailfile/<?php echo $this->page->record['facilityemailfile']; ?>" class="facility-pdf btn col-xs-12 col-sm-6 col-md-4 col-sm-offset-3 col-md-offset-2 bg-4 bg-5-hover txt-1 lh-60 alg-cr" target="_blank">Download Email Attachment</a>
            <?php	
				}
			?>	
        </div>
        <?php $efc = isset($this->page->record['facilityemailfile']) && $this->page->record['facilityemailfile']!='' ? '' : ' hdn'; ?>
        <div class="col-xs-12 pad-none form-group<?php echo $efc; ?>" id="del-emailfile-row">
			<?php
            $this->page->fields->button('Delete Email Attachment', 'delete-emailfile', 'emailfile', 'bg-4 bg-5-hover txt-1 lh-60', 'button', 'delete-pdf');
            ?>
        </div>
        <div class="col-xs-12 col-sm-9 col-md-10 col-sm-offset-3 col-md-offset-2 pad-none form-group<?php echo $cls; ?>">
            <div class="col-xs-12 col-sm-6 col-md-4 pad-none form-group pad-lr-md">
            <?php
            $this->page->fields->filedrop('facilityattachment', 'facilityattachment');
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