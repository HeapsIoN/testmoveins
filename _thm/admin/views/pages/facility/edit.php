<div class="col-xs-12 col-sm-9 col-sm-offset-3 col-md-10 col-md-offset-2 pad-none form-tabs bg-2 bdr-t-s-1 bdr-3" id="form-tabs">
	<?php
	$tabs = array(	'main' 			=> 'Connection Details',
					'contact' 		=> 'Facility Details',
					'images' 		=> 'Images and Logos',
					'moveins' 		=> 'Move-In Config',
					'reservations'	=> 'Reservation Config',
					'payments'		=> 'Payments Config',
					//'encryption' 	=> 'Encryption'
					);
	
	foreach($tabs as $k => $l)
		{
		$cls = $k=='main' ? ' bg-1' : '';
		?>
        <button type="button" class="form-tab cur-pnt pull-left pad-lr-md lh-50<?php echo $cls; ?>" sm-tab="<?php echo $k; ?>"><?php echo $l; ?></button>
        <?php	
		}
	
	//echo '<pre>';print_r($this->page->record);echo '</pre>';
	
	$new = isset($this->page->record['fcid']) ? '' : ' needs-id storman-hdn';
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
			
            $this->page->fields->radio('Region', 'facilityregion', 'facilityregion', $opts, 'col-xs-12 col-sm-4 col-lg-3');
            ?>
        </div>
         <div class="col-xs-12 form-group">
            <?php
            $this->page->fields->button('Save Facility', '', 'form', 'bg-4 bg-5-hover txt-1 lh-60');
            ?>
        </div>
        <h2 class="col-xs-12">Offline URL</h2>
        <div class="col-xs-12 form-group">
            <p>Enter the URL a user will be sent to, in the event Storman cannot be contacted.
        </div>
        <div class="col-xs-12 form-group">
            <?php
            $this->page->fields->text('Offline URL', 'facilityofflineurl', 'facilityofflineurl', 'http://democompany.storman.com/sorry-down-for-maintenance', 'bdr-3 txt-lg txt-4');
            ?>
        </div>
       
        <h2 class="col-xs-12">Unit Copy</h2>
        <div class="col-xs-12 form-group">
            <p>You can copy across the units for the facility <u>AFTER</u> saving it by clicking on the button below IF you have put in the web service settings above.</p>
            <p>This will connect to Storman, and copy across updated information for the unit types for that facility by the unit type code.</p>
            <p>If no local record exists for that unit type, then a new unit type will be added to the local system.</p>
            <p>The system will always connect directly to Storman when searching checking unit types for customers when ordering, this interface purely allows the facility to manage the image, title and web description for the unit type.</p>
        </div>
        <div class="col-xs-12 form-group<?php echo $new; ?>">
            <?php
            $this->page->fields->button('Copy Unit Types', 'copy-units', 'form', 'bg-3 bg-5-hover txt-uc txt-1 lh-60', 'button', 'copy-units');
            ?>
        </div>
	</div>
    
    <div class="col-xs-12 pad-none group group-hdn" id="contact">
        <h2 class="col-xs-12">Facility Details</h2>
        <div class="col-xs-12 form-group">
        	<p>This information is pulled out of StorMan. This is included here to show you what information is included on the portals.</p>
            <p>To update this, simply log into StorMan and modify the facility information from 'Maintenance' - 'System Setup'.</p>
        </div>
        
        <h2 class="col-xs-12">Contact Info</h2>
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
            $this->page->fields->text('Facility Phone', 'facilityphone', 'facilityphone', 'Enter the contact phone for the facility', 'bdr-3 txt-lg txt-4 col-xs-12 col-md-3 col-lg-2', '', '', '', true);
            ?>
        </div>
		
        <h2 class="col-xs-12">Facility Address</h2>
        <div class="col-xs-12 form-group">
            <?php
            $this->page->fields->text('', 'facilityaddressa', 'facilityaddressa', 'Enter the facility address', 'col-sm-offset-3 col-md-offset-2 bdr-3 txt-lg txt-4 col-xs-12 col-md-3', '', '', '', true);
            ?>
        </div>
        <div class="col-xs-12 form-group">
            <?php
            $this->page->fields->text('', 'facilitysuburb', 'facilitysuburb', 'Suburb / Town', 'col-sm-offset-3 col-md-offset-2 bdr-3 txt-lg txt-4 col-xs-12 col-md-3', '', '', '', true);
            ?>
        </div>
        <div class="col-xs-12 form-group">
            <?php
            $this->page->fields->text('', 'facilitystate', 'facilitystate', 'State, if applicable (3 letters only)', 'col-sm-offset-3 col-md-offset-2 bdr-3 txt-lg txt-4 col-xs-12 col-md-2 col-lg-1', '', '', '', true);
            ?>
        </div>
        <div class="col-xs-12 form-group">
            <?php
            $this->page->fields->text('', 'facilitypostcode', 'facilitypostcode', 'Post / Zip Code', 'col-sm-offset-3 col-md-offset-2 bdr-3 txt-lg txt-4 col-xs-12 col-md-2 col-lg-1', '', '', '', true);
            ?>
        </div>
    </div>
    
    
    
    <div class="col-xs-12 pad-none group group-hdn" id="images">
        <h2 class="col-xs-12<?php echo $new; ?>"></h2>
        <div class="col-xs-12 form-group<?php echo $new; ?>">
			<p><b>Facility Logo</b></p>
            <p>Upload the logo of the facility, this will be printed on the Storage Contract.
            The recommended size and format is <b>250 x 80 pixels</b> and <b>.png</b></p>	
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
        <div class="col-xs-12 col-sm-9 col-md-10 col-sm-offset-3 col-md-offset-2 pad-none form-group<?php echo $new; ?>">
            <div class="col-xs-12 col-sm-6 col-md-4 pad-none form-group pad-lr-md">
            <?php
            $this->page->fields->filedrop('facilitylogo', 'facilitylogo');
            ?>
            </div>
        </div>
        <h2 class="col-xs-12<?php echo $cls; ?>"></h2>
        <div class="col-xs-12 form-group<?php echo $cls; ?>">
		<p><b>Email Header</b></p>
            <p>Upload an image that will be used as the header, in emails that are sent to customers when signing up.
			The recommended size and format is <b>800 x 150 pixels</b> and <b>.png</b></p>
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
        <div class="col-xs-12 col-sm-9 col-md-10 col-sm-offset-3 col-md-offset-2 pad-none form-group<?php echo $new; ?>">
            <div class="col-xs-12 col-sm-6 col-md-4 pad-none form-group pad-lr-md">
            <?php
            $this->page->fields->filedrop('facilityheader', 'facilityheader');
            ?>
            </div>
        </div>
        <h2 class="col-xs-12<?php echo $cls; ?>"></h2>
        <div class="col-xs-12 form-group<?php echo $cls; ?>">
		<p><b>Email Footer</b></p>
            <p>Upload an image that will be used as the footer, in emails that are sent to customers when signing up.
			The recommended size and format is <b>210 x 60 pixels</b> and <b>.png</b></p>
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
        <div class="col-xs-12 col-sm-9 col-md-10 col-sm-offset-3 col-md-offset-2 pad-none form-group<?php echo $new; ?>">
            <div class="col-xs-12 col-sm-6 col-md-4 pad-none form-group pad-lr-md">
            <?php
            $this->page->fields->filedrop('facilityfooter', 'facilityfooter');
            ?>
            </div>
        </div>
        
        
        
        
	</div>
    
    
    
    
    <div class="col-xs-12 pad-none group group-hdn" id="moveins">
        <h2 class="col-xs-12">Move-In Config</h2>
        <div class="col-xs-12 form-group">
            <p>You can control various settings for your Online Move-In's from here.</p>
            <p class="txt-red">The 'Unit Selection' method is also used for Online Reservations.</p>
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
        <div class="col-xs-12 form-group">
            <?php
            $this->page->fields->toggle('Allow Unit Selection', 'facilityunitselection', 'facilityunitselection');
            ?>
            <span class="pull-left lh-50 pad-lr-md">Enable this option to allow unit number selection during the move-in.</span>
        </div>
        
        <h2 class="col-xs-12"></h2>
        <div class="col-xs-12 form-group">
            <p>You can use this to select if you want to take payment on the website or not.</p>
            <p>You would set this to NO if you want to provide customers with a tablet in store for the signup but then want to take payment over the counter.</p>
            <p>If you set this to NO, when the users reviews the contract, signs and continues, it will add the order to Storman and they will then be directed to the completed page.</p>
            <p>You can set your own message on the Completed page from the "Messages and Errors" section (last tab).</p>
        </div>
        <div class="col-xs-12 form-group">
            <?php
            $this->page->fields->toggle('Require Payment for Move-In', 'facilityrequirepayment', 'facilityrequirepayment');
            ?>
            <span class="pull-left lh-50 pad-lr-md">Enable this option if you require payment for a new move-in.</span>
        </div>
        <?php
		$cls = isset($this->page->record['facilityrequirepayment']) && $this->page->record['facilityrequirepayment']=='1' ? '' : ' hdn';
		?>
        <div class="col-xs-12 form-group movein-payments<?php echo $cls; ?>">
            <?php
            $this->page->fields->toggle('In-Store Payments', 'facilityinstorepayments', 'facilityinstorepayments');
            ?>
            <span class="pull-left lh-50 pad-lr-md">Allow payments in-store</span>
        </div>
        <div class="col-xs-12 form-group movein-payments<?php echo $cls; ?>">
            <?php
            $this->page->fields->toggle('First Month Rent', 'facilityfirstmonth', 'facilityfirstmonth');
            ?>
            <span class="pull-left lh-50 pad-lr-md">Include first month rent in deposit</span>
        </div>
        
        
        
        <h2 class="col-xs-12">MoveIn Requirements</h2>
        <div class="col-xs-12 form-group">
 
        </div>
        <div class="col-xs-12 form-group">
            <?php
            $this->page->fields->toggle('Require Alternate Contact', 'facilityrequirealt', 'facilityrequirealt');
            ?>
            <span class="pull-left lh-50 pad-lr-md">If business account, this is enforced.</span>
        </div>
        

        <div class="col-xs-12 form-group">
            <?php
            $this->page->fields->toggle('Require Storer Check', 'facilityrequirestorer', 'facilityrequirestorer');
            ?>
            
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
        <div class="col-xs-12 col-sm-9 col-md-10 col-sm-offset-3 col-md-offset-2 pad-none form-group <?php echo $new; ?>">
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
        <div class="col-xs-12 col-sm-9 col-md-10 col-sm-offset-3 col-md-offset-2 pad-none form-group <?php echo $new; ?>">
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
        <div class="col-xs-12 col-sm-9 col-md-10 col-sm-offset-3 col-md-offset-2 pad-none form-group <?php echo $new; ?>">
            <div class="col-xs-12 col-sm-6 col-md-4 pad-none form-group pad-lr-md">
            <?php
            $this->page->fields->filedrop('facilityattachment', 'facilityattachment');
            ?>
            </div>
        </div>
        
        
        
        <h2 class="col-xs-12">Completed Message Page</h2>
        
        <div class="col-xs-12 form-group">
            <p>You can set a custom message on the completed page that is displayed after a successful order and payment.</p>
        </div>
        <div class="col-xs-12 form-group">
            <?php
            $this->page->fields->textarea('Completed Message', 'facilitycompletedmessage', 'facilitycompletedmessage', '', '');
            ?>
        </div>
        
        
        
    </div>
    
    
    
    <div class="col-xs-12 pad-none group group-hdn" id="reservations">
        <h2 class="col-xs-12">Reservations Config</h2>
        <div class="col-xs-12 form-group">
            <p>You can use this section to control the settings for the online reservations.</p>
            <p class="txt-red">YOU WILL NEED TO SET YOUR UNIT SELECTION METHOD FROM THE MOVE-INS CONFIG!</p>
        </div>
        
        
        <div class="col-xs-12 form-group">
           
        </div>
        <div class="col-xs-12 form-group">
            <?php
            $this->page->fields->toggle('Require Booking Fee', 'facilityresfee', 'facilityresfee');
            ?>
        </div>
        
        
        <div class="col-xs-12 form-group">
            
        </div>
        <div class="col-xs-12 form-group">
            <?php
            $this->page->fields->toggle('Hide Unit Type Prices', 'facilityresprices', 'facilityresprices');
            ?>
        </div>
        
        <h2 class="col-xs-12">Return URL</h2>
        <div class="col-xs-12 form-group">
            <p>Enter a URL to send the user to, after they have completed a Reservation.</p>
           
           
        </div>
        <div class="col-xs-12 form-group">
            <?php
            $this->page->fields->text('Return URL', 'facilityresreturn', 'facilityresreturn', 'http://democompany.storman.com/thank-you', 'bdr-3 txt-lg txt-4');
            ?>
        </div>
        
        
        
        <h2 class="col-xs-12<?php echo $cls; ?>">Reservation Email Attachment PDF</h2>
        <div class="col-xs-12 form-group<?php echo $cls; ?>">
            <p>You can upload your own PDF to be attached to the email that is sent to the customer when they complete a reservation.</p>
            <p>The file MUST BE A PDF! The file upload is restricted to only allow pdf files.</p>
            <p>This is to ensure that the visitor can open it in their web browser or open it using free software if they are on a mobile.</p>	
            <p>This can be an information sheet, sales brochure or welcome pack.</p>
        </div>
        <div class="col-xs-12 pad-none form-group" id="emailfile-row">
        	<?php
			if(isset($this->page->record['facilityresfile']) && $this->page->record['facilityresfile']!='')
				{
			?>
            <a href="/_med/facilities/resfile/<?php echo $this->page->record['facilityresfile']; ?>" class="facility-pdf btn col-xs-12 col-sm-6 col-md-4 col-sm-offset-3 col-md-offset-2 bg-4 bg-5-hover txt-1 lh-60 alg-cr" target="_blank">Download Reservation Email Attachment</a>
            <?php	
				}
			?>	
        </div>
        <?php $efc = isset($this->page->record['facilityresfile']) && $this->page->record['facilityresfile']!='' ? '' : ' hdn'; ?>
        <div class="col-xs-12 pad-none form-group<?php echo $efc; ?>" id="del-resfile-row">
			<?php
            $this->page->fields->button('Delete Email Attachment', 'delete-resfile', 'resfile', 'bg-4 bg-5-hover txt-1 lh-60', 'button', 'delete-pdf');
            ?>
        </div>
        <div class="col-xs-12 col-sm-9 col-md-10 col-sm-offset-3 col-md-offset-2 pad-none form-group needs-id<?php echo $new; ?>">
            <div class="col-xs-12 col-sm-6 col-md-4 pad-none form-group pad-lr-md">
            <?php
            $this->page->fields->filedrop('facilityresattach', 'facilityresattach');
            ?>
            </div>
        </div>
        
        
	</div>
    
    
    
    <div class="col-xs-12 pad-none group group-hdn" id="payments">
        
        
        
        
        <h2 class="col-xs-12">Payments Config</h2>
        <div class="col-xs-12 form-group">
            <p>Please enter the Analysis Codes for the following fees, as configured in Storman.</p>
        </div>
        <div class="col-xs-12 form-group">
            <?php
            $this->page->fields->text('Deposit', 'facilitydeposit', 'facilitydeposit', 'DP', 'col-xs-12 col-sm-6 col-md-2 bdr-3 txt-lg txt-4');
            ?>
        </div>
        <div class="col-xs-12 form-group">
            <?php
            $this->page->fields->text('Cleaning Fee', 'facilitycleaningfee', 'facilitycleaningfee', 'CF', 'col-xs-12 col-sm-6 col-md-2 bdr-3 txt-lg txt-4');
            ?>
        </div>
        <div class="col-xs-12 form-group">
            <?php
            $this->page->fields->text('Admin Fee', 'facilityadminfee', 'facilityadminfee', 'AF', 'col-xs-12 col-sm-6 col-md-2 bdr-3 txt-lg txt-4 col-');
            ?>
        </div>
        <div class="col-xs-12 form-group">
            <?php
            $this->page->fields->text('Cheque Bounce', 'facilitychequefee', 'facilitychequefee', 'BDC', 'col-xs-12 col-sm-6 col-md-2 bdr-3 txt-lg txt-4 col-');
            ?>
        </div>
        <div class="col-xs-12 form-group">
            <?php
            $this->page->fields->text('Late Fee', 'facilitylatefee', 'facilitylatefee', 'LF', 'col-xs-12 col-sm-6 col-md-2 bdr-3 txt-lg txt-4');
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
        
        
        <h2 class="col-xs-12">Payment Configuration</h2>
        
		<div class="col-xs-12 form-group">
            <?php
			$opts = array(	'1' => 'Ezidebit', 
							'2' => 'Storpay', 
							);
			
            $this->page->fields->radio('Payment Method', 'facilitypaymenttype', 'facilitypaymenttype', $opts, 'col-xs-12 col-sm-6 col-lg-4');
			
			$pbed = isset($this->page->record['facilitypaymenttype']) && $this->page->record['facilitypaymenttype']==1 ? '' : ' hdn';
			$pbsp = isset($this->page->record['facilitypaymenttype']) && $this->page->record['facilitypaymenttype']==2 ? '' : ' hdn';
            ?>
        </div>
        
        <h2 class="col-xs-12 payby-storpay<?php echo $pbsp; ?>"></h2>
        <div class="col-xs-12 form-group payby-storpay<?php echo $pbsp; ?>">
            <p>Enter the Storpay folder name below.</p> 
        </div>
        <div class="col-xs-12 form-group payby-storpay<?php echo $pbsp; ?>">
            <?php
            $this->page->fields->text('Storpay Folder', 'facilitystorpayurl', 'facilitystorpayurl', 'SSCTY', 'bdr-3 txt-lg txt-4');
            ?>
			 <span class="col-xs-12 col-sm-6 col-md-8 lh-50">eg: https://www.storpay.com/4DCGI/storpay/<b>SSCTY</b>/login.shtml</span>
        </div>
   
        <h2 class="col-xs-12 payby-ezi<?php echo $pbed; ?>"></h2>
        <div class="col-xs-12 form-group payby-ezi<?php echo $pbed; ?>">
            <p>Enter the Ezidebit Public Key for this Facility below.</p>
        </div>
        <div class="col-xs-12 form-group payby-ezi<?php echo $pbed; ?>">
            <?php
            $this->page->fields->text('Ezidebit Public Key', 'facilityedpubkey', 'facilityedpubkey', '443CEF02-76BD-49DC-0C31-BA02FE198149', 'bdr-3 txt-lg txt-4');
            ?>
        </div>
        <div class="col-xs-12 form-group payby-ezi<?php echo $pbed; ?>">
		<p></p>
        	<p>Select the credit card types that will be accepted, and their Analysis Codes as configured in Storman. You must select at least one. </p>
        </div>
        <div class="col-xs-12 form-group payby-ezi<?php echo $pbed; ?>">
            <?php
            $this->page->fields->toggle('Visa', 'facilityezivisa', 'facilityezivisa', '', '', '', '', '', 'pad-l-md pull-left');
            
			$cls = isset($this->page->record['facilityezivisa']) && $this->page->record['facilityezivisa']=='1' ? '' : ' hdn';
			
			$this->page->fields->text('Analysis Code', 'facilityezicardvisa', 'facilityezicardvisa', 'V', 'mrg-l-md col-xs-6 col-sm-4 col-md-3 col-lg-2 txt-4'.$cls);
            ?>
        </div>
        <div class="col-xs-12 form-group payby-ezi<?php echo $pbed; ?>">
            <?php
            $this->page->fields->toggle('Mastercard', 'facilityezimastercard', 'facilityezimastercard', '', '', '', '', '', 'pad-l-md pull-left');
            
			$cls = isset($this->page->record['facilityezimastercard']) && $this->page->record['facilityezimastercard']=='1' ? '' : ' hdn';
			
			$this->page->fields->text('Analysis Code', 'facilityezicardmaster', 'facilityezicardmaster', 'M', 'mrg-l-md col-xs-6 col-sm-4 col-md-3 col-lg-2 txt-4'.$cls);
            ?>
        </div>
        <div class="col-xs-12 form-group payby-ezi<?php echo $pbed; ?>">
            <?php
            $this->page->fields->toggle('Amex', 'facilityeziamex', 'facilityeziamex', '', '', '', '', '', 'pad-l-md pull-left');
            
			$cls = isset($this->page->record['facilityeziamex']) && $this->page->record['facilityeziamex']=='1' ? '' : ' hdn';
			
			$this->page->fields->text('Analysis Code', 'facilityezicardamex', 'facilityezicardamex', 'A', 'mrg-l-md col-xs-6 col-sm-4 col-md-3 col-lg-2 txt-4'.$cls);
            ?>
        </div>
        <div class="col-xs-12 form-group payby-ezi<?php echo $pbed; ?>">
            <?php
            $this->page->fields->toggle('Diners', 'facilityezidiners', 'facilityezidiners', '', '', '', '', '', 'pad-l-md pull-left');
            
			$cls = isset($this->page->record['facilityezidiners']) && $this->page->record['facilityezidiners']=='1' ? '' : ' hdn';
			
            $this->page->fields->text('Analysis Code', 'facilityezicarddiners', 'facilityezicarddiners', 'D', 'mrg-l-md col-xs-6 col-sm-4 col-md-3 col-lg-2 txt-4'.$cls);
            ?>
        </div>
		<?php
		/*
        <div class="col-xs-12 form-group">
            <?php
            $this->page->fields->text('Ezidebit Analysis Code', 'facilityezicardcode', 'facilityezicardcode', 'Ezidebit analysis code', 'col-xs-12 col-sm-6 col-md-2 bdr-3 txt-lg txt-4');
            ?>
        </div>
		*/
		?>
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
	</div>
    
    
    </form>
</div>