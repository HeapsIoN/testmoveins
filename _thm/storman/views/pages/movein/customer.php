<h1><?php $this->page->heading('pagetitle'); ?></h1>
<div class="col-xs-12">
	<div class="col-xs-12">
    	<div class="col-xs-12 col-md-6 col-md-offset-3 pad-none mrg-b-md">
        	<a href="/unit" class="btn col-xs-12 bg-3 bg-4-hover txt-1 txt-1-hover txt-uc">&laquo; Back to Unit Selection</a>
        </div>
		<?php
		if(isset($this->moveins->customer['customercode']) && $this->moveins->customer['customercode']!='')
			{
			$dis = ' storman-hdn';
		?>
        <div class="col-xs-12 mrg-b-md">
			<p class="bg-8 txt-white lh-40 pad-all-md mrg-b-md"><i class="ion-alert txt-lg pad-lr-md"></i>Hi <?php echo $this->moveins->customer['customerfirstname']; ?>, We have noticed that you are already logged in so you can just use that account for your order.</p>
        	<p>If you would like to log in as a different user or register a new account, simply logout using the tools in the top menu. This will also clear your order.</p>
            <p>All fields with an asterisk (*) are required fields.</p>
        </div>
		<?php	
            }
		else
			{
			$dis = '';
		?>
        <div class="col-xs-12 mrg-b-md" id="can-login">
        	<p>If you are an existing customer with <?php echo $this->moveins->facinfo['facilityfullname']; ?>, you can log into your account below using your customer code and password.</p>
            <p>Otherwise, you can create your account now.</p>
            <p>All fields with an asterisk (*) are required fields.</p>
        </div>
        
        <?php	
			}
		?>
        
        
        <form id="login" class="col-xs-12 col-md-6 mrg-b-md bdr-r-s-1 bdr-2<?php echo $dis; ?>">
      	<div class="col-xs-12 mrg-b-md">
        	<label for="customerexistingcode" class="lbl col-xs-12 alg-lft txt-md">Email Address / Customer Code</label>
            <input type="text" class="input col-xs-12 bdr-3 txt-lg txt-4 login-input" id="customerexistingcode" name="customerexistingcode" placeholder="Enter your customer code" />
        </div>
        <div class="col-xs-12 mrg-b-md">
        	<label for="customerexistingpass" class="lbl col-xs-12 alg-lft txt-md">Password</label>
            <input type="password" class="input col-xs-12 bdr-3 txt-lg txt-4 login-input" id="customerexistingpass" name="customerexistingpass" placeholder="Enter your password" />
        </div>
        <div class="col-xs-12 mrg-b-md">
        	<button type="button" class="btn col-xs-12 bg-3 bg-4-hover txt-1 txt-1-hover txt-uc" id="logincustomer">Login &raquo;</button>
        </div>
        <div class="col-xs-12 mrg-b-md">
        	<button type="button" class="btn col-xs-12 bg-orange bg-4-hover txt-1 txt-1-hover txt-uc" id="reset-loader">Password Reset &raquo;</button>
        </div>
        </form>
        
        <div id="newcomer" class="col-xs-12 col-md-6 mrg-b-md<?php echo $dis; ?>">
            <div class="col-xs-12 mrg-b-md">
                <h2 class="col-xs-12 alg-ctr lh-60 pad-t-lg pad-b-lg">Or...</h2>
                <button type="button" class="btn col-xs-12 bg-3 bg-4-hover txt-1 txt-1-hover txt-uc" id="register-btn">New Customer Register &raquo;</button>
            </div>
        </div>
        
        <?php
		$cls = $res = $bus = ' storman-hdn';
		$con = ' continue-row';
		$rds = $bds = '';
		
		if(isset($this->moveins->user['customercode']) && $this->moveins->user['customercode']!='')
			{
			$cls = '';
			$con = '';
			$res = isset($this->moveins->customer['isbusiness']) && $this->moveins->customer['isbusiness']!='1' ? '' : ' storman-hdn';
			$bus = isset($this->moveins->customer['isbusiness']) && $this->moveins->customer['isbusiness']=='1' ? '' : ' storman-hdn';
			
			$rds = $res=='' ? '' : 'disabled="disabled"';
			$bds = $bus=='' ? '' : 'disabled="disabled"';
			
			}
		?>
        <form id="profile" class="col-xs-12 mrg-b-md<?php echo $cls; ?>" data-toggle="validator" role="form">
      	<input type="hidden" name="customercode" id="customercode" value="<?php $this->moveins->userdata('customercode'); ?>" />
        <input type="hidden" name="isbusiness" id="isbusiness" value="<?php $this->moveins->custdata('isbusiness'); ?>" />
        <div class="col-xs-12 pad-none mrg-b-md<?php echo $con; ?>">
        	<p>You can review your account details below or you can simply continue with your order.</p>
		</div>
        <div class="col-xs-12 col-md-6 col-md-offset-3 pad-none mrg-b-md<?php echo $con; ?>">
            <button type="button" class="btn col-xs-12 bg-3 bg-4-hover txt-1 txt-1-hover txt-uc save-customer" id="save-top">Continue to Contract &raquo;</button>
        </div>
        
        <h2 class="col-xs-12 bdr-b-s-1 bdr-2 lh-60 mrg-b-md txt-xl txt-4">Account Information</h2>
        <div class="col-xs-12 mrg-b-md storman-hdn" id="account-type">
        	<div class="col-xs-12">
            	<p>Please start by telling us if you are a Residential or Business customer.</p>
            </div>
            <button type="button" class="btn col-xs-6 bg-3 bg-4-hover txt-1 txt-1-hover txt-uc tgl-type<?php if(isset($this->moveins->customer['isbusiness']) && $this->moveins->customer['isbusiness']!='1'){echo ' bg-4';} ?>" storman-type="0" storman-flds="residential" id="tgl-residential">Residential Customer</button>
            <button type="button" class="btn col-xs-6 bg-3 bg-4-hover txt-1 txt-1-hover txt-uc tgl-type<?php if(isset($this->moveins->customer['isbusiness']) && $this->moveins->customer['isbusiness']=='1'){echo ' bg-4';} ?>" storman-type="1" storman-flds="business" id="tgl-business">Business Customer</button>
        </div>
        
        <h3 class="col-xs-12 mrg-b-md  mrg-t-xl txt-lg txt-4 residential<?php echo $res; ?>">Personal Information</h3>
        <h3 class="col-xs-12 mrg-b-md  mrg-t-xl txt-lg txt-4 business<?php echo $bus; ?>">Contact Person Information</h3>
        
        
        <div class="col-xs-12 mrg-b-md residential<?php echo $res; ?>">
        	<?php
			//$this->page->fields->checkbox('dualaccount', 'This agreement is being signed jointly and we will enter the secondary customer details below', '1');
			$this->page->fields->radio('Is this a dual account?', 'dualaccount', 'dualaccount', array('1' => 'Yes', '2' => 'No'), '', 'pull-left alg-rgt pad-lr-md lh-50', 'pull-left');
			?>		
        </div>
        <div class="col-xs-12 col-md-2 mrg-b-md residential<?php echo $res; ?>">
        	<label for="customertitle" class="lbl col-xs-12 alg-lft txt-md">Title</label>
            <select class="input col-xs-12 bdr-3 txt-lg txt-4 res-only" name="customertitle" id="customertitle" required data-invalid="You must select your title"<?php echo $rds; ?>>
            	<option value="">[ Select ]</option>
				<?php
				$opts = array('Mr', 'Mrs', 'Ms', 'Dr');
				
				foreach($opts as $opt)
					{
					$sel = isset($this->moveins->customer['customertitle'])	&& $this->moveins->customer['customertitle']==$opt ? ' selected="selected"' : '';
					
					echo '<option value="'.$opt.'"'.$sel.'>'.$opt.'</option>';
					}
				?>                
            </select>
        </div>
        <div class="col-xs-12 col-md-5 mrg-b-md residential business<?php echo $cls; ?>">
        	<label for="customerfirstname" class="lbl col-xs-12 alg-lft txt-md residential business" res-lbl="First Name*" bus-lbl="Company Name*">First Name</label>
            <input type="text" class="input col-xs-12 bdr-3 txt-lg txt-4" id="customerfirstname" name="customerfirstname" placeholder="Enter your first name*" value="<?php $this->moveins->custdata('customerfirstname'); ?>" required data-invalid="You must enter your first name" res-ph="Enter your first name*" bus-ph="Enter the company name*" />
        </div>
        <div class="col-xs-12 col-md-5 mrg-b-md residential business<?php echo $cls; ?>">
        	<label for="customersurname" class="lbl col-xs-12 alg-lft txt-md residential business" res-lbl="Surname*" bus-lbl="Contact Name*">Surname</label>
            <input type="text" class="input col-xs-12 bdr-3 txt-lg txt-4" id="customersurname" name="customersurname" placeholder="Enter your surname*" value="<?php $this->moveins->custdata('customersurname'); ?>" required data-invalid="You must enter your surname" res-ph="Enter your surname*" bus-ph="Enter the contact person name" res-err="You must enter your surname" bus-err="You must enter the contact name / manager for the business" />
        </div>
        <div class="col-xs-12 col-md-4 mrg-b-md business<?php echo $bus; ?>">
        	<label for="companynumber" class="lbl col-xs-12 alg-lft txt-md">Company ABN / GST Number*</label>
            <input type="text" class="input col-xs-12 bdr-3 txt-lg txt-4 bus-only" id="companynumber" name="companynumber" placeholder="Enter the business ABN / GST number*" value="<?php $this->moveins->custdata('companynumber'); ?>" required="required"<?php echo $bds; ?> data-invalid="You must enter the ABN / ACN / GST / TAX number for your business" />
        </div>
        <div class="col-xs-12 mrg-b-md pad-none residential<?php echo $res; ?>">
        	<label for="customerdobday" class="lbl col-xs-12 alg-lft txt-md">Date of Birth*</label>
            <div class="col-xs-12 col-md-4 mrg-b-md">
            <select class="input col-xs-12 bdr-3 txt-lg txt-4 res-only" name="customerdobday" id="customerdobday" required data-invalid="You must select your date of birth"<?php echo $rds; ?>>
            	<option value="">[ Day ]</option>
				<?php
				$days = range(1, 31);
				
				foreach($days as $day)
					{
					$lbl = $day;
					$day = str_pad($day, 2, '0', STR_PAD_LEFT);
					
					$sel = isset($this->moveins->customer['customerdobday'])	&& $this->moveins->customer['customerdobday']==$day ? ' selected="selected"' : '';
					
					echo '<option value="'.$day.'"'.$sel.'>'.$lbl.'</option>';
					}
				?>                
            </select>
            </div>
            <div class="col-xs-12 col-md-4 mrg-b-md">
            <select class="input col-xs-12 bdr-3 txt-lg txt-4 res-only" name="customerdobmonth" id="customerdobmonth" required data-invalid="You must select the month of your birth"<?php echo $rds; ?>>
            	<option value="">[ Month ]</option>
				<?php
				$months = array('01' => 'Jan', '02' => 'Feb', '03' => 'Mar', '04' => 'Apr', '05' => 'May', '06' => 'Jun', '07' => 'Jul', '08' => 'Aug', '09' => 'Sep', '10' => 'Oct', '11' => 'Nov', '12' => 'Dec');
								
				foreach($months as $k => $month)
					{
					$sel = isset($this->moveins->customer['customerdobmonth'])	&& $this->moveins->customer['customerdobmonth']==$k ? ' selected="selected"' : '';
					
					echo '<option value="'.$k.'"'.$sel.'>'.$month.'</option>';
					}
				?>                
            </select>
            </div>
            <div class="col-xs-12 col-md-4 mrg-b-md">
            <select class="input col-xs-12 bdr-3 txt-lg txt-4 res-only" name="customerdobyear" id="customerdobyear" required data-invalid="You must select the year of your birth"<?php echo $rds; ?>>
            	<option value="">[ Year ]</option>
				<?php
				$years = range((date('Y')-18),1900);
				
				foreach($years as $year)
					{
					$sel = isset($this->moveins->customer['customerdobyear'])	&& $this->moveins->customer['customerdobyear']==$year ? ' selected="selected"' : '';
					
					echo '<option value="'.$year.'"'.$sel.'>'.$year.'</option>';
					}
				?>                
            </select>
            </div>
        </div>
        
        <h3 class="col-xs-12 mrg-b-md  mrg-t-xl txt-lg txt-4 residential<?php echo $res; ?>">Contact Information</h3>
        <h3 class="col-xs-12 mrg-b-md  mrg-t-xl txt-lg txt-4 business<?php echo $bus; ?>">Business Contact Information</h3>
        <div class="col-xs-12 col-md-4 mrg-b-md residential<?php echo $res; ?>">
        	<label for="customerhomephone" class="lbl col-xs-12 alg-lft txt-md">Home Phone</label>
            <input type="tel" class="input col-xs-12 bdr-3 txt-lg txt-4" id="customerhomephone" name="customerhomephone" placeholder="Enter your home phone number, inc. area code" value="<?php $this->moveins->custdata('customerhomephone'); ?>" filter="phone_au" data-invalid="The home phone is invalid. Try formatting it as +61X XXXX XXXX or entering NA" />
        </div>
        <div class="col-xs-12 col-md-4 mrg-b-md residential business<?php echo $cls; ?>">
        	<label for="customerworkphone" class="lbl col-xs-12 alg-lft txt-md residential business" res-lbl="Work Phone" bus-lbl="Office Phone*">Work Phone</label>
            <input type="tel" class="input col-xs-12 bdr-3 txt-lg txt-4" id="customerworkphone" name="customerworkphone" placeholder="Enter your work phone number, inc. area code" res-ph="Enter your work phone number, inc. area code" bus-ph="Enter the office / work phone number" res-err="The office / work phone is invalid. Try formatting it as +61X XXXX XXXX or entering NA" bus-err="The office phone is invalid. Try formatting it as +61X XXXX XXXX or entering NA" value="<?php $this->moveins->custdata('customerworkphone'); ?>" filter="phone_au" data-invalid="The office / work phone is invalid. Try formatting it as +61X XXXX XXXX or entering NA" />
        </div>
        <div class="col-xs-12 col-md-4 mrg-b-md residential business<?php echo $cls; ?>">
        	<label for="customermobilephone" class="lbl col-xs-12 alg-lft txt-md">Mobile Phone</label>
            <input type="tel" class="input col-xs-12 bdr-3 txt-lg txt-4" id="customermobilephone" name="customermobilephone" placeholder="Enter your mobile phone*" value="<?php $this->moveins->custdata('customermobilephone'); ?>" required filter="mobile_au" data-invalid="Mobile number is invalid. Try formatting it as +61 XXX XXX XXX" />
        </div>
        <div class="col-xs-12 col-md-6 mrg-b-md residential business<?php echo $cls; ?>" id="email-row">
        	<label for="customeremail" class="lbl col-xs-12 alg-lft txt-md">Email Address</label>
			<input type="email" class="input col-xs-12 bdr-3 txt-lg txt-4 bg-lgt-grey" id="customeremail" name="customeremail" placeholder="Enter your email address" value="<?php $this->moveins->custdata('customeremail'); ?>" required filter="email" data-invalid="The email address appears to be invalid" readonly="readonly" />
        </div>
        <?php
		if(!isset($this->moveins->user['customercode']) || $this->moveins->user['customercode']=='')
			{
		?>
        <div class="col-xs-12 col-md-6 mrg-b-md residential business<?php echo $cls; ?>" id="confirm-email-row">
        	<label for="customeremailc" class="lbl col-xs-12 alg-lft txt-md">Confirm Email</label>
			<input type="email" class="input col-xs-12 bdr-3 txt-lg txt-4 register-only" id="customeremailc" name="customeremailc" placeholder="Confirm your email address" required filter="email|matches:customeremail" data-invalid="The email address is invalid or it is not the same" />
        </div>
        <?php
			}
		?>
        
        
        <?php
		$preq = !isset($this->moveins->customer['customercode']) || $this->moveins->customer['customercode']=='' ? '*' : '';
		$prat = $preq=='*' ? ' required="required"' : '';
		if(!isset($this->moveins->customer['customercode']) || $this->moveins->customer['customercode']=='')
			{
			$preq = '*';
			$prat = ' required="required"';
		?>
       	<h3 class="col-xs-12 mrg-b-md  mrg-t-xl txt-lg txt-4 pass-row residential business<?php echo $cls; ?>">Account Password</h3>
        <div class="col-xs-12 col-md-6 mrg-b-md pass-row residential business<?php echo $cls; ?>">
        	<label for="customerpassword" class="lbl col-xs-12 alg-lft txt-md">Password</label>
            <input type="password" filter="min_length:6" class="input col-xs-12 bdr-3 txt-lg txt-4 register-only" id="customerpassword" name="customerpassword" placeholder="Enter a password for your account<?php echo $preq; ?>"<?php echo $prat; ?> data-invalid="Your password must be at least 6 characters long" />
        </div>
        <div class="col-xs-12 col-md-6 mrg-b-md pass-row residential business<?php echo $cls; ?>">
        	<label for="confirmpassword" class="lbl col-xs-12 alg-lft txt-md">Confirm Password</label>
            <input type="password" filter="min_length:6|matches:customerpassword" class="input col-xs-12 bdr-3 txt-lg txt-4 register-only" id="confirmpassword" name="confirmpassword" data-match="customerpassword" data-match-error="The passwords don't match" placeholder="Confirm the password for your account<?php echo $preq; ?>"<?php echo $prat; ?> data-invalid="The passwords are not the same" />
        </div>
        <?php
			}
		else
			{
		?>
        <input type="hidden" id="customerpassword" name="customerpassword" value="" autocomplete="off" />
        <input type="hidden" id="confirmpassword" name="confirmpassword" value="" autocomplete="off" />
        <?php	
			}
		?>
        <h3 class="col-xs-12 mrg-b-md  mrg-t-xl txt-lg txt-4 residential<?php echo $res; ?>">Address Details</h3>
        <h3 class="col-xs-12 mrg-b-md  mrg-t-xl txt-lg txt-4 business<?php echo $bus; ?>">Business Address and Postage Details</h3>
        <div class="col-xs-12 pad-none mrg-b-md residential business<?php echo $cls; ?>">
        	<div class="col-xs-12">
            <label for="customeraddress" class="lbl col-xs-12 alg-lft txt-md residential business" res-lbl="Address*" bus-lbl="Business Address*">Address</label>
            <input type="text" class="input col-xs-12 bdr-3 txt-lg txt-4 mrg-b-sm" id="customeraddress" name="customeraddress" placeholder="Enter your street address*" value="<?php $this->moveins->custdata('customeraddress'); ?>" required data-invalid="You must enter your address" res-ph="Enter your street address*" bus-ph="Enter the business address*" res-err="You must enter your address" bus-err="You must enter the address for the business" />
			</div>            
            <div class="col-xs-12 col-md-6">
            <input type="text" class="input col-xs-12 pad-none bdr-3 txt-lg txt-4 mrg-b-sm suburb-finder" ac-tag="customer" id="customersuburb" name="customersuburb" placeholder="Enter your suburb / city*" value="<?php $this->moveins->custdata('customersuburb'); ?>" required data-invalid="You must enter your suburb" res-ph="Search via Suburb" bus-ph="Search via Suburb" res-err="You must enter your suburb" bus-err="You must enter the business suburb" />
            </div>
            <div class="col-xs-12 col-md-3">
            <select class="input col-xs-12 bdr-3 mrg-b-sm txt-lg txt-4" name="customerstate" id="customerstate" required data-invalid="You must select your state" res-ph="" bus-ph="" res-err="You must select your state" bus-err="You must select the business state">
            	<option value="">[ State ]</option>
				<?php
				foreach($this->moveins->region['states'] as $v => $l)
					{
					$sel = isset($this->moveins->customer['customerstate'])	&& $this->moveins->customer['customerstate']==$v ? ' selected="selected"' : '';
					
					echo '<option value="'.$v.'"'.$sel.'>'.$l.'</option>';
					}
				?>
                <option value="Other">Other</option>             
            </select>
            </div>
            <div class="col-xs-12 col-md-3">
            <input type="text" class="input col-xs-12 bdr-3 txt-lg txt-4 mrg-b-sm suburb-finder" ac-tag="customer" id="customerpostcode" name="customerpostcode" placeholder="Enter your postcode*" value="<?php $this->moveins->custdata('customerpostcode'); ?>" required data-invalid="You must enter your postcode" res-ph="Enter your postcode*" bus-ph="Enter your postcode*" res-err="You must enter your postcode" bus-err="You must enter the business postcode" />
            </div>
        </div>
        <div class="col-xs-12 mrg-b-md residential business<?php echo $cls; ?>">
        	<?php
			$this->page->fields->checkbox('mailingsame', 'My mailing address is the same as my street address', '1');
			?>
        </div>
        <div class="col-xs-12 pad-none mrg-b-md residential business<?php echo $cls; ?>">
        	<div class="col-xs-12">
            <label for="customermailaddress" class="lbl col-xs-12 alg-lft txt-md">Mailing Address</label>
            <input type="text" class="input col-xs-12 bdr-3 txt-lg txt-4 mrg-b-sm suburb-finder" id="customermailaddress" name="customermailaddress" placeholder="Enter your mailing address" value="<?php $this->moveins->custdata('customermailaddress'); ?>" required data-invalid="You must enter your mailing address" res-ph="Enter your mailing address" bus-ph="Enter the business mailing address" res-err="You must enter your mailing address" bus-err="You must enter the business mailing address" />
            </div>
            <div class="col-xs-12 col-md-6">
            <input type="text" class="input col-xs-12 bdr-3 txt-lg txt-4 mrg-b-sm suburb-finder" ac-tag="customermail" id="customermailsuburb" name="customermailsuburb" placeholder="Enter your mailing suburb / city" value="<?php $this->moveins->custdata('customermailsuburb'); ?>" required data-invalid="You must enter your mailing suburb" res-ph="Search for your mailing suburb" bus-ph="Search via suburb" res-err="You must enter your mailing suburb" bus-err="You must enter the mailing address suburb" />
            </div>
            <div class="col-xs-12 col-md-3">
            <select class="input col-xs-12 bdr-3 mrg-b-sm txt-lg txt-4" name="customermailstate" id="customermailstate" required data-invalid="You must enter your mailing state" res-ph="" bus-ph="" res-err="You must select your mailing state" bus-err="You must select the business mailing state">
            	<option value="">[ State ]</option>
				<?php
				foreach($this->moveins->region['states'] as $v => $l)
					{
					$sel = isset($this->moveins->customer['customermailstate'])	&& $this->moveins->customer['customermailstate']==$v ? ' selected="selected"' : '';
					
					echo '<option value="'.$v.'"'.$sel.'>'.$l.'</option>';
					}
				?>
                <option value="Other">Other</option>               
            </select>
            </div>
            <div class="col-xs-12 col-md-3">
            <input type="text" class="input col-xs-12 bdr-3 txt-lg txt-4 mrg-b-sm suburb-finder" ac-tag="customermail" id="customermailpostcode" name="customermailpostcode" placeholder="Enter your mailing postcode" value="<?php $this->moveins->custdata('customermailpostcode'); ?>" required data-invalid="You must enter your mailing postcode" res-ph="Enter your mailing postcode" bus-ph="Enter the business mailing postcode" res-err="You must enter your mailing postcode" bus-err="You must enter the business mailing postcode" />
            </div>
        </div>
        
        
        <h3 class="col-xs-12 mrg-b-md  mrg-t-xl  mrg-t-xl txt-lg txt-4 residential<?php echo $res; ?>">License and Vehicle Information</h3>
        <div class="col-xs-12 col-md-6 mrg-b-md residential<?php echo $res; ?>">
        	<label for="customerlicenseissued" class="lbl col-xs-12 alg-lft txt-md">License Issued By</label>            
            <select class="input col-xs-12 bdr-3 txt-lg txt-4 res-only" name="customerlicenseissued" id="customerlicenseissued" required data-invalid="You must select the issuer of your license"<?php echo $rds; ?>>
            	<option value="">[ State ]</option>
				<?php
				foreach($this->moveins->region['states'] as $v => $l)
					{
					$sel = isset($this->moveins->customer['customermailstate'])	&& $this->moveins->customer['customermailstate']==$v ? ' selected="selected"' : '';
					
					echo '<option value="'.$v.'"'.$sel.'>'.$l.'</option>';
					}
				?>
                <option value="Other">Other</option>               
            </select>
        </div>
        <div class="col-xs-12 col-md-6 mrg-b-md residential<?php echo $res; ?>">
        	<label for="customerlicense" class="lbl col-xs-12 alg-lft txt-md">License Number</label>
            <input type="text" class="input col-xs-12 bdr-3 txt-lg txt-4 res-only" id="customerlicense" name="customerlicense" placeholder="Enter your license number*" value="<?php $this->moveins->custdata('customerlicense'); ?>" required filter="max_length:12" data-invalid="You must enter your license number (max 12 numbers and letters)"<?php echo $rds; ?> />
        </div>        
        <div class="col-xs-12 col-md-6 mrg-b-md residential<?php echo $res; ?>">
        	<label for="customercartype" class="lbl col-xs-12 alg-lft txt-md">Vehicle Make and Model</label>
            <input type="text" class="input col-xs-12 bdr-3 txt-lg txt-4 res-only" id="customercartype" name="customercartype" placeholder="Enter your car make and model*" value="<?php $this->moveins->custdata('customercartype'); ?>" required data-invalid="You must enter your vehicle make and model. Enter NA if not applicable."<?php echo $rds; ?> />
        </div>
        <div class="col-xs-12 col-md-6 mrg-b-md residential<?php echo $res; ?>">
        	<label for="customercarrego" class="lbl col-xs-12 alg-lft txt-md">Car Rego / License Plate</label>
            <input type="text" class="input col-xs-12 bdr-3 txt-lg txt-4 res-only" id="customercarrego" name="customercarrego" placeholder="Enter your vehicle rego / license plate (Max. 7)*" value="<?php $this->moveins->custdata('customercarrego'); ?>" required filter="vehicle|max_length:7" data-invalid="You must enter your vehicle registration number. Enter NA if not applicable"<?php echo $rds; ?> />
        </div>
        
        
        <?php
		$req = $this->moveins->facinfo['facilityrequirealt']=='1' ? '*' : '';
		$rat = $req=='*' ? ' required' : '';
		?>
        
        <h2 class="col-xs-12 mrg-b-md txt-xl bdr-b-s-1 bdr-2 lh-60 txt-4 dual-contact residential<?php echo $res; ?>" alt-txt="Alternate Personal Information" dual-txt="Secondary Personal Information">Alternate Personal Information</h2>
        <h2 class="col-xs-12 mrg-b-md txt-xl bdr-b-s-1 bdr-2 lh-60 txt-4 business<?php echo $bus; ?>">Business Owner Personal Information</h2>
        
        
        <div class="col-xs-12 col-md-2 mrg-b-md residential business<?php echo $cls; ?>">
        	<label for="customeralttitle" class="lbl col-xs-12 alg-lft txt-md" title="Title" res-lbl="Title" bus-lbl="Owner Title*">Title</label>
            <select class="input col-xs-12 bdr-3 txt-lg txt-4 dual-contact" name="customeralttitle" id="customeralttitle"<?php echo $rat; ?> data-invalid="You must select the title for the secondary contact / owner" res-ph="" bus-ph="" res-err="You must select the title for the secondary contact" bus-err="You must select the title for the owner">
            	<option value="">[ Select ]</option>
				<?php
				$opts = array('Mr', 'Mrs', 'Ms', 'Dr');
				
				foreach($opts as $opt)
					{
					$sel = isset($this->moveins->customer['customeralttitle'])	&& $this->moveins->customer['customeralttitle']==$opt ? ' selected="selected"' : '';
					
					echo '<option value="'.$opt.'"'.$sel.'>'.$opt.'</option>';
					}
				?>                
            </select>
        </div>
        <div class="col-xs-12 col-md-5 mrg-b-md residential business<?php echo $cls; ?>">
        	<label for="customeraltname" class="lbl col-xs-12 alg-lft txt-md residential business" res-lbl="Contact First Name<?php echo $req; ?>" bus-lbl="Owners First Name*">Contact First Name</label>
            <input type="text" class="input col-xs-12 bdr-3 txt-lg txt-4 dual-contact" id="customeraltfirstname" name="customeraltfirstname" alt-txt="Enter the alternate contact first name<?php echo $req; ?>" dual-txt="Enter the secondary contact name<?php echo $req; ?>" data-invalid="You must enter the first name of the secondary contact / owner" placeholder="Enter the alternate contact name<?php echo $req; ?>" value="<?php $this->moveins->custdata('customeraltfirstname'); ?>"<?php echo $rat; ?> res-ph="Enter the alternate contact name<?php echo $req; ?>" bus-ph="Enter the business owners first name*" res-err="You must enter the alternate / secondary contact name" bus-err="You must enter the business owners first name" />
        </div>
        <div class="col-xs-12 col-md-5 mrg-b-md residential business<?php echo $cls; ?>">
        	<label for="customeraltlastname" class="lbl col-xs-12 alg-lft txt-md residential business" res-lbl="Contact Last Name<?php echo $req; ?>" bus-lbl="Owners Last Name*">Contact Last Name</label>
            <input type="text" class="input col-xs-12 bdr-3 txt-lg txt-4 dual-contact" id="customeraltlastname" name="customeraltlastname" alt-txt="Enter the alternate contact last name<?php echo $req; ?>" dual-txt="Enter the secondary contact name<?php echo $req; ?>" data-invalid="You must enter the last name for the secondary contact / owner" placeholder="Enter the alternate contact name<?php echo $req; ?>" value="<?php $this->moveins->custdata('customeraltlastname'); ?>"<?php echo $rat; ?> res-ph="Enter the alternate contact surname<?php echo $req; ?>" bus-ph="Enter the business owners surname*" res-err="You must enter the last name for the secondary contact" bus-err="You must enter the last name for the owner" />
        </div>
        
		<h3 class="col-xs-12 mrg-b-md  mrg-t-xl txt-lg txt-4 residential<?php echo $res; ?>">Alternate Contact Information</h3>
        <h3 class="col-xs-12 mrg-b-md  mrg-t-xl txt-lg txt-4 business<?php echo $bus; ?>">Business Owner Contact Information</h3>
        <div class="col-xs-12 col-md-6 mrg-b-md residential business<?php echo $cls; ?>">
        	<label for="customermobilephone" class="lbl col-xs-12 alg-lft txt-md">Mobile Phone</label>
            <input type="tel" class="input col-xs-12 bdr-3 txt-lg txt-4 dual-contact" id="customeraltmobile" name="customeraltmobile" alt-txt="Enter the alternate contact mobile phone<?php echo $req; ?>" dual-txt="Enter the secondary contact mobile phone<?php echo $req; ?>" filter="mobile" data-invalid="Alt. contact mobile number is invalid. Try formatting it as +61 XXX XXX XXX" placeholder="Enter the alternate contact mobile phone<?php echo $req; ?>" value="<?php $this->moveins->custdata('customeraltmobile'); ?>"<?php echo $rat; ?> res-ph="Enter the mobile phone for the secondary contact<?php echo $req; ?>" bus-ph="Enter the mobile phone for the business owner*" res-err="Alt. contact mobile number is invalid. Try formatting it as +61 XXX XXX XXX" bus-err="Business owner mobile number is invalid. Try formatting it as +61 XXX XXX XXX" />
        </div>
        <div class="col-xs-12 col-md-6 mrg-b-md residential business<?php echo $cls; ?>">
        	<label for="customeremail" class="lbl col-xs-12 alg-lft txt-md">Email Address</label>
            <input type="email" class="input col-xs-12 bdr-3 txt-lg txt-4 dual-contact" id="customeraltemail" name="customeraltemail" alt-txt="Enter the alternate contact email address<?php echo $req; ?>" dual-txt="Enter the secondary contact email address<?php echo $req; ?>" placeholder="Enter the alternate contact email address<?php echo $req; ?>" value="<?php $this->moveins->custdata('customeraltemail'); ?>"<?php echo $rat; ?> filter="email" data-invalid="The secondary contact email address appears to be invalid" res-ph="Enter the alternate contact email address<?php echo $req; ?>" bus-ph="Enter the alternate contact email address*" res-err="The secondary contact email address appears to be invalid" bus-err="The business owners email address appears to be invalid" />
        </div>
        
        <h3 class="col-xs-12 mrg-b-md  mrg-t-xl txt-lg txt-4 residential<?php echo $res; ?>" alt-txt="">Alternate Contact Address</h3>
        <h3 class="col-xs-12 mrg-b-md  mrg-t-xl txt-lg txt-4 business<?php echo $bus; ?>">Business Owner Address</h3>
        <div class="col-xs-12 pad-lr-xl mrg-b-md residential<?php echo $res; ?>">
        	<?php
			$this->page->fields->checkbox('secondarysame', 'My address is the same as the primary contact address', '1');
			?>
        </div>
        <div class="col-xs-12 pad-none mrg-b-md residential business<?php echo $cls; ?>">
        	<div class="col-xs-12">
            <label for="customeraltaddress" class="lbl col-xs-12 alg-lft txt-md" res-lbl="Address<?php echo $req; ?>" bus-lbl="Owners Address*">Address<?php echo $req; ?></label>
            <input type="text" class="input col-xs-12 bdr-3 txt-lg txt-4 mrg-b-sm dual-contact" id="customeraltaddress" name="customeraltaddress" alt-txt="Enter the alternate contact street address<?php echo $req; ?>" dual-txt="Enter the secondary contact street address<?php echo $req; ?>" placeholder="Enter the alternate contact street address<?php echo $req; ?>" value="<?php $this->moveins->custdata('customeraltaddress'); ?>"<?php echo $rat; ?> data-invalid="You must enter the address for the secondary contact" res-ph="Enter the alternate contact street address<?php echo $req; ?>" bus-ph="Enter the business owners street address" res-err="You must enter the address for the secondary contact" bus-err="You must enter the address for the bsuiness owner" />
            </div>
            <div class="col-xs-12 col-md-6">
            <input type="text" class="input col-xs-12 bdr-3 txt-lg txt-4 mrg-b-sm dual-contact suburb-finder" ac-tag="customeralt" id="customeraltsuburb" name="customeraltsuburb" alt-txt="Enter the alternate contact suburb / city<?php echo $req; ?>" dual-txt="Enter the secondary contact suburb / city<?php echo $req; ?>" placeholder="Enter the alternate contact suburb / city<?php echo $req; ?>" value="<?php $this->moveins->custdata('customeraltsuburb'); ?>"<?php echo $rat; ?> data-invalid="You must enter the suburb for the secondary contact." res-ph="Enter the secondary contact suburb / city<?php echo $req; ?>" bus-ph="Enter the business owners suburb / city*" res-err="You must enter the suburb for the secondary / alternate contact" bus-err="You must enter the suburb for the business owner" />
            </div>
            <div class="col-xs-12 col-md-3">
            <select class="input col-xs-12 bdr-3 mrg-b-sm txt-lg txt-4" name="customeraltstate" id="customeraltstate" <?php echo $rat; ?> data-invalid="You must select the state for the secondary contact." res-ph="" bus-ph="" res-err="You must select the secondary / alternate contact state" bus-err="You must select the business owners state">
            	<option value="">[ State ]</option>
				<?php
				foreach($this->moveins->region['states'] as $v => $l)
					{
					$sel = isset($this->moveins->customer['customeraltstate'])	&& $this->moveins->customer['customeraltstate']==$v ? ' selected="selected"' : '';
					
					echo '<option value="'.$v.'"'.$sel.'>'.$l.'</option>';
					}
				?>
                <option value="Other">Other</option>             
            </select>
            </div>
            <div class="col-xs-12 col-md-3">
            <input type="text" class="input col-xs-12 bdr-3 txt-lg txt-4 mrg-b-sm dual-contact suburb-finder" ac-tag="customeralt" id="customeraltpostcode" name="customeraltpostcode" alt-txt="Enter the alternate contact postcode<?php echo $req; ?>" dual-txt="Enter the secondary contact postcode<?php echo $req; ?>" placeholder="Enter the alternate contact postcode<?php echo $req; ?>" value="<?php $this->moveins->custdata('customeraltpostcode'); ?>"<?php echo $rat; ?> data-invalid="You must enter the postcode for the secondary contact." res-ph="Enter the alternate contact postcode<?php echo $req; ?>" bus-ph="Enter the business owners postcode*" res-err="You must enter the postcode for the secondary contact" bus-err="You must enter the postcode for the business owner" />
            </div>
        </div>
        
        <div class="col-xs-12 col-md-6 col-md-offset-3 mrg-b-md residential business<?php echo $cls; ?>">
        	<button type="button" class="btn col-xs-12 bg-3 bg-4-hover txt-1 txt-1-hover txt-uc save-customer" id="save">Save Profile &raquo;</button>
        </div>
        <div class="col-xs-12 col-md-6 col-md-offset-3 mrg-b-md">
        	<a href="/unit" class="btn col-xs-12 bg-7 bg-4-hover txt-1 txt-1-hover txt-uc">&laquo; Back to Unit Selection</a>
        </div>
        </form>
    </div>
</div>