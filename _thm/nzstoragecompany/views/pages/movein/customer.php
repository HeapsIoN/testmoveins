<p>&nbsp;</p>
<h2><?php $this->page->heading('pagetitle'); ?></h2>
<p>&nbsp;</p>

 <p>Thank you for selecting your unit<strong>. </strong>(Need to <a href="/unit" class="txt-3" style="text-decoration: underline;">choose a different unit</a>?)</p>


<?php
if(isset($this->moveins->customer['customercode']) && $this->moveins->customer['customercode']!='')
	{
	$dis = ' storman-hdn';
?>
<div class="col-xs-12 mrg-b-md pad-none">
	<p class="bg-8 txt-white lh-40 pad-all-md mrg-b-md"><i class="ion-alert txt-lg pad-lr-md"></i>Hi <strong><?php echo $this->moveins->customer['customerfirstname']; ?></strong>, we noticed that you are already logged-in, so you can just use that account for your order.</p> 
	<p>If you would like to log in as a different user or register a new account, simply logout using the tools in the top menu. This will also clear your order.</p>
	<p>&nbsp;</p>
</div>
<?php	
	}
else
	{
	$dis = '';
?>
<div class="col-xs-12 mrg-b-md pad-none" id="can-login">
	<p>If you are an existing customer at <strong><?php echo $this->moveins->facinfo['facilityfullname']; ?></strong>, please log into your account below by using your Customer Code and Password (a reset password option is also available if you need it). Otherwise, you can create your account below...</p>
<p>&nbsp;</p>
</div>

<?php	
	}
?>
    
    
<div id="newcomer" class="col-xs-12 col-md-4 mrg-b-md<?php echo $dis; ?>">
    <div class="col-xs-12 mrg-b-md well">
        <legend>New User</legend>
        <button type="button" class="btn pull-right bg-3 bg-4-hover txt-1 txt-1-hover txt-uc" id="register-btn">Create an account</button>
    </div>
</div>


<form id="login" class="form-horizontal col-xs-12 col-md-8 mrg-b-md<?php echo $dis; ?>">
    <div class="col-xs-12 well">
        <legend>Existing User</legend>
        <div class="form-group col-xs-12 mrg-b-md">
            <label class="col-lg-5 control-label" for="customerexistingcode">Email address / customer code</label>
            <div class="col-lg-7">
                <input type="text" class="form-control login-input" id="customerexistingcode" name="customerexistingcode" placeholder="Your email or customer code" />
            </div>
        </div>
        <div class="form-group col-xs-12 mrg-b-md">
            <label class="col-lg-5 control-label" for="customerexistingpass">Password</label>
            <div class="col-lg-7">
                <input type="password" class="form-control login-input" id="customerexistingpass" name="customerexistingpass" placeholder="Your password" />
                <button type="button" class="bdr-none col-xs-12 pad-none txt-3 alg-lt lh-30" style="background-color: transparent;" id="reset-loader"><span class="txt-grey">Forgot your</span> password?</button>
            </div>        	
        </div>
        <div class="form-group col-xs-12">
            <button type="button" class="btn pull-right bg-3 bg-4-hover txt-1 txt-1-hover txt-uc" id="logincustomer">Login &raquo;</button>
        </div>
    </div>
</form>
    
    <p>&nbsp;</p>
    
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
	
	$rds = $res=='' ? '' : ' disabled="disabled"';
	$bds = $bus=='' ? '' : ' disabled="disabled"';
	
	}
?>
<form id="profile" class="form-horizontal col-xs-12 pad-none mrg-b-md<?php echo $cls; ?>" data-toggle="validator" role="form">
    <div class="col-xs-12 well">
        <input type="hidden" name="customercode" id="customercode" value="<?php $this->moveins->userdata('customercode'); ?>" />
        <div class="col-xs-12 pad-none mrg-b-md<?php echo $con; ?>">
            <button type="button" class="btn pull-right bg-3 bg-4-hover txt-1 txt-1-hover txt-uc save-customer" id="save-top">Continue to Contract &raquo;</button>
        </div>
        
        <legend id="form-title">Account Manager</legend>
        <div class="form-group">

<div class="col-lg-12">

     <p>Please begin by selecting the type of storage agreement you wish to setup...</p>
     <p>&nbsp;</p>
                  
          </div>


            <div class="form-group mrg-b-md storman-hdn" id="account-type">
            
       

               <label for="isbusiness" class="col-lg-3 control-label">Customer type</label>
                <div class="col-lg-4">
                <select class="form-control" name="isbusiness" id="isbusiness">
                    <option value="">[ Account Type ]</option>
                    <?php
                    $opts = array('2' => 'Residential', '1' => 'Business');
                    
                    foreach($opts as $v => $l)
                        {
                        $s = isset($this->moveins->customer['isbusiness'])	&& $this->moveins->customer['isbusiness']==$v ? ' selected="selected"' : '';
                        
                        echo '<option value="'.$v.'"'.$s.' storman-flds="'.strtolower($l).'">'.$l.'</option>';
                        }
                    ?>                
                </select>
                </div>
            </div>
            <div class="form-group mrg-b-md residential<?php echo $res; ?>">
                <?php
                $this->page->record['dualaccount'] = isset($this->moveins->customer['dualaccount']) ? $this->moveins->customer['dualaccount'] : '';
                $this->page->fields->radio('Storage agreement type', 'dualaccount', 'dualaccount', array('2' => 'This agreement will be under a single name', '1' => 'This agreement will be under two names (ie. a joint agreement) '), 'col-xs-12', 'col-xs-12 col-lg-3 control-label', 'col-xs-12 col-lg-9');
                ?>
                <p class="txt-grey col-xs-12 col-lg-9 col-lg-offset-3">If selecting a joint agreement, both parties will need to be present at your computer to sign it (this is done online as part of the move-in process). Furthermore, both persons will need to be present at the time of move-in for ID verification.</p>
            </div>
        </div>
        <hr class="residential business<?php echo $cls; ?>" />
        <div class="form-group mrg-b-md residential business<?php echo $cls; ?>">
            <label for="customertitle" class="col-lg-3 control-label">Agreement name</label>
            
            <div class="form-col col-lg-2 mrg-b-md residential<?php echo $res; ?>">
                <select class="form-control res-only" name="customertitle" id="customertitle" required data-invalid="You must select your title"<?php echo $rds; ?>>
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
            <div class="form-col col-lg-3 mrg-b-md residential business<?php echo $cls; ?>">
                <input type="text" class="form-control" id="customerfirstname" name="customerfirstname" placeholder="Enter your first name*" value="<?php $this->moveins->custdata('customerfirstname'); ?>" required data-invalid="You must enter your first name" res-ph="Enter your first name*" bus-ph="Enter the company name*" />
            </div>
            <div class="form-col col-lg-4 mrg-b-md residential business<?php echo $cls; ?>">
                <input type="text" class="form-control" id="customersurname" name="customersurname" placeholder="Enter your surname*" value="<?php $this->moveins->custdata('customersurname'); ?>" required data-invalid="You must enter your surname" res-ph="Enter your surname*" bus-ph="Enter the contact person name" res-err="You must enter your surname" bus-err="You must enter the contact name / manager for the business" />
            </div>
        </div>
        
        <div class="form-group mrg-b-md residential business<?php echo $res; ?>">
            <label for="customerhomephone" class="col-lg-3 control-label">Contact Details*</label>
        
            <div class="form-col col-lg-3 mrg-b-md residential<?php echo $res; ?>">
                <input type="tel" class="form-control" id="customerhomephone" name="customerhomephone" placeholder="Home phone" value="<?php $this->moveins->custdata('customerhomephone'); ?>" filter="phone_nz" data-invalid="The home phone is invalid. Try formatting it as +61X XXXX XXXX or entering NA" />
            </div>
            <div class="form-col col-lg-3 mrg-b-md residential business<?php echo $cls; ?>">
                <input type="tel" class="form-control" id="customerworkphone" name="customerworkphone" placeholder="Work phone" res-ph="Enter your work phone number, inc. area code" bus-ph="Enter the office / work phone number" res-err="The office / work phone is invalid. Try formatting it as +61X XXXX XXXX or entering NA" bus-err="The office phone is invalid. Try formatting it as +61X XXXX XXXX or entering NA" value="<?php $this->moveins->custdata('customerworkphone'); ?>" filter="phone_nz" data-invalid="The office / work phone is invalid. Try formatting it as +61X XXXX XXXX or entering NA" />
            </div>
            <div class="form-col col-lg-3 mrg-b-md residential business<?php echo $cls; ?>">
                <input type="tel" class="form-control" id="customermobilephone" name="customermobilephone" placeholder="Mobile phone*" value="<?php $this->moveins->custdata('customermobilephone'); ?>" required filter="mobile_nz" data-invalid="Mobile number is invalid. Try formatting it as +61 XXX XXX XXX" />
            </div>
        </div>
        
        <div class="form-group mrg-b-md residential business<?php echo $cls; ?>">
            <label for="customeremail" class="col-lg-3 control-label">Email Address</label>
            <div class="col-lg-9 mrg-b-md residential business<?php echo $cls; ?>" id="email-row">
                <input type="email" class="form-control" id="customeremail" name="customeremail" placeholder="Enter your email address" value="<?php $this->moveins->custdata('customeremail'); ?>" required filter="email" data-invalid="The email address appears to be invalid" readonly />
            </div>
        </div>
        <?php
        if(!isset($this->moveins->user['customercode']) || $this->moveins->user['customercode']=='')
            {
        ?>
        <div class="form-group mrg-b-md register-only residential business<?php echo $cls; ?>" id="confirm-email-row">
            <label for="customeremailc" class="col-lg-3 control-label">Confirm email</label>
            <div class="col-lg-9 mrg-b-md residential business<?php echo $cls; ?>">
                <input type="email" class="form-control register-only" id="customeremailc" name="customeremailc" placeholder="Confirm your email address" required filter="email|matches:customeremail" data-invalid="The email address is invalid or it is not the same" />
            </div>
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
        <hr class="residential business<?php echo $cls; ?>" />
        <div class="form-group mrg-b-md register-only pass-row residential business<?php echo $cls; ?>">
            <label for="customerpassword" class="col-lg-3 control-label">Password</label>
            <div class="form-col col-lg-4 mrg-b-md residential business<?php echo $cls; ?>">
                <input type="password" filter="min_length:6" class="form-control register-only" id="customerpassword" name="customerpassword" placeholder="Enter a password for your account<?php echo $preq; ?>"<?php echo $prat; ?> data-invalid="Your password must be at least 6 characters long" />
            </div>
            <div class="form-col col-lg-4 mrg-b-md residential business<?php echo $cls; ?>">
                <input type="password" filter="min_length:6|matches:customerpassword" class="form-control register-only" id="confirmpassword" name="confirmpassword" data-match="customerpassword" data-match-error="The passwords don't match" placeholder="Confirm the password for your account<?php echo $preq; ?>"<?php echo $prat; ?> data-invalid="The passwords are not the same" />
            </div>
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
        
        
        <hr class="pass-row residential business<?php echo $cls; ?>" />
        <div class="form-group mrg-b-md business<?php echo $bus; ?>">
            <label for="companynumber" class="col-lg-3 control-label">Company GST Number</label>
            <div class="col-lg-4 mrg-b-md business<?php echo $bus; ?>">
                <input type="text" class="form-control bus-only" id="companynumber" name="companynumber" placeholder="Enter the business GST number*" value="<?php $this->moveins->custdata('companynumber'); ?>" required="required"<?php echo $bds; ?> filter="number|max_length:11" data-invalid="You must enter the ABN / ACN / GST / TAX number for your business (No spaces, max 11 numbers)" />
            </div>
        </div>
        <div class="form-group mrg-b-md residential<?php echo $res; ?>">
            <label for="customerdobday" class="col-lg-3 control-label">Date of Birth</label>
            <div class="form-col col-lg-2 mrg-b-md">
                <select class="form-control res-only" name="customerdobday" id="customerdobday" required data-invalid="You must select your date of birth"<?php echo $rds; ?>>
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
            <div class="form-col col-lg-2 mrg-b-md">
                <select class="form-control res-only" name="customerdobmonth" id="customerdobmonth" required data-invalid="You must select the month of your birth"<?php echo $rds; ?>>
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
            <div class="form-col col-lg-2 mrg-b-md">
                <select class="form-control res-only" name="customerdobyear" id="customerdobyear" required data-invalid="You must select the year of your birth"<?php echo $rds; ?>>
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
        <hr class="residential business<?php echo $cls; ?>" />
        <div class="form-group mrg-b-md residential business<?php echo $cls; ?>">
            <label for="customeraddress" class="col-lg-3 control-label residential business" res-lbl="Address*" bus-lbl="Business Address*">Address</label>
            <div class="form-col col-lg-9 mrg-b-md">
                <input type="text" class="form-control" id="customeraddress" name="customeraddress" placeholder="Enter your street address*" value="<?php $this->moveins->custdata('customeraddress'); ?>" required data-invalid="You must enter your address" res-ph="Enter your street address*" bus-ph="Enter the business address*" res-err="You must enter your address" bus-err="You must enter the address for the business" />
            </div>            
            <div class="form-col col-lg-5 col-lg-offset-3">
                <input type="text" class="form-control suburb-finder" ac-tag="customer" id="customersuburb" name="customersuburb" placeholder="Enter your suburb / city*" value="<?php $this->moveins->custdata('customersuburb'); ?>" required data-invalid="You must enter your suburb" res-ph="Search via Suburb" bus-ph="Search via Suburb" res-err="You must enter your suburb" bus-err="You must enter the business suburb" />
            </div>
            <div class="form-col col-lg-5 col-lg-offset-3">
                <input type="text" class="form-control suburb-finder" ac-tag="customer" id="customercity" name="customercity" placeholder="Enter your city*" value="<?php $this->moveins->custdata('customercity'); ?>" required data-invalid="You must enter your city" res-ph="Search via city" bus-ph="Search via city" res-err="You must enter your city" bus-err="You must enter the business city" />
            </div>
            <div class="form-col col-lg-2">
                <input type="text" class="form-control suburb-finder" ac-tag="customer" id="customerpostcode" name="customerpostcode" placeholder="Enter your postcode*" value="<?php $this->moveins->custdata('customerpostcode'); ?>" required data-invalid="You must enter your postcode" res-ph="Enter your postcode*" bus-ph="Enter your postcode*" res-err="You must enter your postcode" bus-err="You must enter the business postcode" />
            </div>
        </div>
        <div class="form-group mrg-b-md residential business<?php echo $cls; ?>">
            <div class="col-lg-9 col-lg-offset-3">
            <?php
            $this->page->fields->checkbox('mailingsame', 'My mailing address is the same as my street address', '1');
            ?>
            </div>
        </div>
        <div class="form-group mrg-b-md residential business<?php echo $cls; ?>">
            <label for="customermailaddress" class="col-lg-3 control-label residential business">Mailing Address</label>
            <div class="form-col col-lg-9 mrg-b-md">
                <input type="text" class="form-control" id="customermailaddress" name="customermailaddress" placeholder="Enter your mailing address" value="<?php $this->moveins->custdata('customermailaddress'); ?>" required data-invalid="You must enter your mailing address" res-ph="Enter your mailing address" bus-ph="Enter the business mailing address" res-err="You must enter your mailing address" bus-err="You must enter the business mailing address" />
            </div>
            <div class="form-col col-lg-5 col-lg-offset-3">
                <input type="text" class="form-control suburb-finder" ac-tag="customermail" id="customermailsuburb" name="customermailsuburb" placeholder="Enter your mailing suburb / city" value="<?php $this->moveins->custdata('customermailsuburb'); ?>" required data-invalid="You must enter your mailing suburb" res-ph="Search for your mailing suburb" bus-ph="Search via suburb" res-err="You must enter your mailing suburb" bus-err="You must enter the mailing address suburb" />
            </div>
            <div class="form-col col-lg-5 col-lg-offset-3">
                <input type="text" class="form-control suburb-finder" ac-tag="customermail" id="customermailcity" name="customermailcity" placeholder="Enter your mailing city" value="<?php $this->moveins->custdata('customermailcity'); ?>" required data-invalid="You must enter your mailing city" res-ph="Search for your mailing city" bus-ph="Search via city" res-err="You must enter your mailing city" bus-err="You must enter the mailing address city" />
            </div>
            <div class="form-col col-lg-2">
                <input type="text" class="form-control suburb-finder" ac-tag="customermail" id="customermailpostcode" name="customermailpostcode" placeholder="Enter your mailing postcode" value="<?php $this->moveins->custdata('customermailpostcode'); ?>" required data-invalid="You must enter your mailing postcode" res-ph="Enter your mailing postcode" bus-ph="Enter the business mailing postcode" res-err="You must enter your mailing postcode" bus-err="You must enter the business mailing postcode" />
            </div>
        </div>
        
     <hr class="residential <?php echo $res; ?>" />
        
        <div class="form-group mrg-b-md residential<?php echo $res; ?>">
            <label for="customerlicenseissued" class="col-lg-3 control-label">License details</label>            
                       <div class="form-col col-lg-5 mrg-b-md">
                <input type="text" class="form-control res-only" id="customerlicense" name="customerlicense" placeholder="Enter your license number*" value="<?php $this->moveins->custdata('customerlicense'); ?>" required filter="max_length:12" data-invalid="You must enter your license number (max 12 numbers and letters)"<?php echo $rds; ?> />
            </div>
        </div>        
        <div class="form-group mrg-b-md residential<?php echo $res; ?>">
            <label for="customercartype" class="col-lg-3 control-label">Vehicle information</label>
            <div class="form-col col-lg-4 mrg-b-md">
                <input type="text" class="form-control res-only" id="customercarrego" name="customercarrego" placeholder="Enter your vehicle rego / license plate (Max. 7)*" value="<?php $this->moveins->custdata('customercarrego'); ?>" required filter="vehicle|max_length:7" data-invalid="You must enter your vehicle registration number. Enter NA if not applicable"<?php echo $rds; ?> />
            </div>
            <div class="form-col col-lg-5 mrg-b-md">
                <input type="text" class="form-control res-only" id="customercartype" name="customercartype" placeholder="Enter your car make and model*" value="<?php $this->moveins->custdata('customercartype'); ?>" required data-invalid="You must enter your vehicle make and model. Enter NA if not applicable."<?php echo $rds; ?> />
            </div>
        </div>
        
        <hr class="residential business<?php echo $cls; ?>" />
        
        <?php
        $req = $this->moveins->facinfo['facilityrequirealt']=='1' ? '*' : '';
        $rat = $req=='*' ? ' required' : '';
        ?>
        
        <h4 class="dual-contact residential<?php echo $res; ?>" alt-txt="Alternate Personal Information" dual-txt="Secondary Personal Information">Alternate Personal Information</h4>
        <h4 class="business<?php echo $bus; ?>">Business Owner Personal Information</h4>
        
        
        <div class="form-group mrg-b-md residential business<?php echo $cls; ?>">
            <label for="customeralttitle" class="col-lg-3 control-label" title="Name" res-lbl="Name" bus-lbl="Owner Name*">Name</label>
            <div class="form-col col-lg-2 mrg-b-md">
                <select class="form-control dual-contact" name="customeralttitle" id="customeralttitle"<?php echo $rat; ?> data-invalid="You must select the title for the secondary contact / owner" res-ph="" bus-ph="" res-err="You must select the title for the secondary contact" bus-err="You must select the title for the owner">
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
            <div class="form-col col-lg-3 mrg-b-md">
                <input type="text" class="form-control dual-contact" id="customeraltfirstname" name="customeraltfirstname" alt-txt="Enter the alternate contact first name<?php echo $req; ?>" dual-txt="Enter the secondary contact name<?php echo $req; ?>" data-invalid="You must enter the first name of the secondary contact / owner" placeholder="Enter the alternate contact name<?php echo $req; ?>" value="<?php $this->moveins->custdata('customeraltfirstname'); ?>"<?php echo $rat; ?> res-ph="Enter the alternate contact name<?php echo $req; ?>" bus-ph="Enter the business owners first name*" res-err="You must enter the alternate / secondary contact name" bus-err="You must enter the business owners first name" />
            </div>
            <div class="form-col col-lg-4 mrg-b-md">
                <input type="text" class="form-control dual-contact" id="customeraltlastname" name="customeraltlastname" alt-txt="Enter the alternate contact last name<?php echo $req; ?>" dual-txt="Enter the secondary contact name<?php echo $req; ?>" data-invalid="You must enter the last name for the secondary contact / owner" placeholder="Enter the alternate contact name<?php echo $req; ?>" value="<?php $this->moveins->custdata('customeraltlastname'); ?>"<?php echo $rat; ?> res-ph="Enter the alternate contact surname<?php echo $req; ?>" bus-ph="Enter the business owners surname*" res-err="You must enter the last name for the secondary contact" bus-err="You must enter the last name for the owner" />
            </div>
        </div>
        
        <div class="form-group mrg-b-md residential business<?php echo $cls; ?>">
            <label for="customeraltmobile" class="col-lg-3 control-label">Contact Details</label>
            <div class="col-lg-4">
                <input type="tel" class="form-control dual-contact" id="customeraltmobile" name="customeraltmobile" alt-txt="Enter the alternate contact mobile phone<?php echo $req; ?>" dual-txt="Enter the secondary contact mobile phone<?php echo $req; ?>" filter="mobile_nz" data-invalid="Alt. contact mobile number is invalid. Try formatting it as +61 XXX XXX XXX" placeholder="Enter the alternate contact mobile phone<?php echo $req; ?>" value="<?php $this->moveins->custdata('customeraltmobile'); ?>"<?php echo $rat; ?> res-ph="Enter the mobile phone for the secondary contact<?php echo $req; ?>" bus-ph="Enter the mobile phone for the business owner*" res-err="Alt. contact mobile number is invalid. Try formatting it as +61 XXX XXX XXX" bus-err="Business owner mobile number is invalid. Try formatting it as +61 XXX XXX XXX" />
            </div>
        </div>
        <div class="form-group mrg-b-md residential business<?php echo $cls; ?>">
            <label for="customeraltemail" class="col-lg-3 control-label">Email Address</label>
            <div class="col-lg-9">
                <input type="email" class="form-control dual-contact" id="customeraltemail" name="customeraltemail" alt-txt="Enter the alternate contact email address<?php echo $req; ?>" dual-txt="Enter the secondary contact email address<?php echo $req; ?>" placeholder="Enter the alternate contact email address<?php echo $req; ?>" value="<?php $this->moveins->custdata('customeraltemail'); ?>"<?php echo $rat; ?> filter="email" data-invalid="The secondary contact email address appears to be invalid" res-ph="Enter the alternate contact email address<?php echo $req; ?>" bus-ph="Enter the alternate contact email address*" res-err="The secondary contact email address appears to be invalid" bus-err="The business owners email address appears to be invalid" />
            </div>
        </div>
        <div class="form-group mrg-b-md residential<?php echo $res; ?>">
            <div class="col-lg-9 col-lg-offset-3">
            <?php
            $this->page->fields->checkbox('secondarysame', 'My address is the same as the primary contact address', '1');
            ?>
            </div>
        </div>
        <div class="form-group mrg-b-md residential business<?php echo $cls; ?>">
            
            <label for="customeraltaddress" class="col-lg-3 control-label" res-lbl="Address<?php echo $req; ?>" bus-lbl="Owners Address*">Address</label>
            <div class="form-col col-lg-9 mrg-b-md">
                <input type="text" class="form-control dual-contact" id="customeraltaddress" name="customeraltaddress" alt-txt="Enter the alternate contact street address<?php echo $req; ?>" dual-txt="Enter the secondary contact street address<?php echo $req; ?>" placeholder="Enter the alternate contact street address<?php echo $req; ?>" value="<?php $this->moveins->custdata('customeraltaddress'); ?>"<?php echo $rat; ?> data-invalid="You must enter the address for the secondary contact" res-ph="Enter the alternate contact street address<?php echo $req; ?>" bus-ph="Enter the business owners street address" res-err="You must enter the address for the secondary contact" bus-err="You must enter the address for the bsuiness owner" />
            </div>
            <div class="form-col col-lg-5 col-lg-offset-3">
                <input type="text" class="form-control dual-contact suburb-finder" ac-tag="customeralt" id="customeraltsuburb" name="customeraltsuburb" alt-txt="Enter the alternate contact suburb<?php echo $req; ?>" dual-txt="Enter the secondary contact suburb<?php echo $req; ?>" placeholder="Enter the alternate contact suburb<?php echo $req; ?>" value="<?php $this->moveins->custdata('customeraltsuburb'); ?>"<?php echo $rat; ?> data-invalid="You must enter the suburb for the secondary contact." res-ph="Enter the secondary contact suburb<?php echo $req; ?>" bus-ph="Enter the business owners suburb*" res-err="You must enter the suburb for the secondary / alternate contact" bus-err="You must enter the suburb for the business owner" />
            </div>
            <div class="form-col col-lg-5 col-lg-offset-3">
                <input type="text" class="form-control dual-contact suburb-finder" ac-tag="customeralt" id="customeraltcity" name="customeraltcity" alt-txt="Enter the alternate contact city<?php echo $req; ?>" dual-txt="Enter the secondary contact city<?php echo $req; ?>" placeholder="Enter the alternate contact city<?php echo $req; ?>" value="<?php $this->moveins->custdata('customeraltcity'); ?>"<?php echo $rat; ?> data-invalid="You must enter the city for the secondary contact." res-ph="Enter the secondary contact city<?php echo $req; ?>" bus-ph="Enter the business owners city*" res-err="You must enter the city for the secondary / alternate contact" bus-err="You must enter the city for the business owner" />
            </div>
            <div class="form-col col-lg-2">
                <input type="text" class="form-control dual-contact suburb-finder" ac-tag="customeralt" id="customeraltpostcode" name="customeraltpostcode" alt-txt="Enter the alternate contact postcode<?php echo $req; ?>" dual-txt="Enter the secondary contact postcode<?php echo $req; ?>" placeholder="Enter the alternate contact postcode<?php echo $req; ?>" value="<?php $this->moveins->custdata('customeraltpostcode'); ?>"<?php echo $rat; ?> data-invalid="You must enter the postcode for the secondary contact." res-ph="Enter the alternate contact postcode<?php echo $req; ?>" bus-ph="Enter the business owners postcode*" res-err="You must enter the postcode for the secondary contact" bus-err="You must enter the postcode for the business owner" />
            </div>
        </div>
        
<p>&nbsp;</p>
        <div class="col-xs-12 pad-none residential business<?php echo $cls; ?>">
            <button type="button" class="btn pull-right bg-3 bg-4-hover txt-1 txt-1-hover txt-uc save-customer" id="save">Save Profile &raquo;</button>
        </div>
    </div>
</form>
