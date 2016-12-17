<p>&nbsp;</p>
<h2><?php $this->page->heading('pagetitle'); ?></h2>
<p>&nbsp;</p>

 <p>Thank you for selecting your unit<strong>. </strong>(Need to <a href="/reservation/unit" class="txt-3" style="text-decoration: underline;">choose a different unit</a>?)</p>


<?php

$cls = $res = $bus = ' ';
$con = ' continue-row';
$rds = $bds = '';

?>
<form id="profile" class="form-horizontal col-xs-12 pad-none mrg-b-md" data-toggle="validator" role="form" action="/reservation/payment">
    <div class="col-xs-12 well">
        <input type="hidden" name="customercode" id="customercode" value="<?php $this->moveins->userdata('customercode'); ?>" />
        <div class="form-group mrg-b-md">
		<?php
		
		if(isset($this->moveins->customer['customercode']) && $this->moveins->customer['customercode']!='')
			{
			$dis = ' storman-hdn';
		?>
		<div class="col-xs-12">
			<p class="bg-8 txt-white lh-40 pad-all-md mrg-b-md"><i class="ion-alert txt-lg pad-lr-md"></i>Welcome back <strong><?php echo $this->moveins->customer['customerfirstname']; ?>!</strong></p> 
			<p>Please ensure all of your details are correct below.</p>
			<p>&nbsp;</p>
		</div>
		<?php	
			}
		else
			{
			$dis = '';
		?>
		<div class="col-xs-12" id="can-login">
			<p>Reserving a Unit is quick and easy, and you can change your unit size at any time - even on move-in day!</p>
			<p class="txt-red">Already a customer? Log-in here <button type="button" class="btn mrg-l-md bg-3 bg-4-hover txt-1 txt-1-hover txt-uc" id="login-opn">Login &raquo;</button></p>
		</div>
		
		<?php	
			}
		
		
		?>
        </div>
        <hr class="residential business" />
        <div class="form-group mrg-b-md">
            <label for="customertitle" class="col-lg-3 control-label">Name</label>
            
            <div class="form-col col-lg-2 mrg-b-md">
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
            <div class="form-col col-lg-3 mrg-b-md">
                <input type="text" class="form-control" id="customerfirstname" name="customerfirstname" placeholder="Enter your first name*" value="<?php $this->moveins->custdata('customerfirstname'); ?>" required data-invalid="You must enter your first name" res-ph="Enter your first name*" bus-ph="Enter the company name*" />
            </div>
            <div class="form-col col-lg-4 mrg-b-md">
                <input type="text" class="form-control" id="customersurname" name="customersurname" placeholder="Enter your surname*" value="<?php $this->moveins->custdata('customersurname'); ?>" required data-invalid="You must enter your surname" res-ph="Enter your surname*" bus-ph="Enter the contact person name" res-err="You must enter your surname" bus-err="You must enter the contact name / manager for the business" />
            </div>
        </div>
        
        <div class="form-group mrg-b-md">
            <label for="customerhomephone" class="col-lg-3 control-label">Contact Details*</label>
        
            <div class="form-col col-lg-3 mrg-b-md">
                <input type="tel" class="form-control" id="customerhomephone" name="customerhomephone" placeholder="Home phone" value="<?php $this->moveins->custdata('customerhomephone'); ?>" filter="phone_nz" data-invalid="The home phone is invalid. Try formatting it as +64X XXX XXXX or entering NA" />
            </div>
            <div class="form-col col-lg-3 mrg-b-md">
                <input 	type="tel" 
                		class="form-control" 
                        id="customerworkphone" 
                        name="customerworkphone" 
                        placeholder="Work phone" 
                        res-ph="Enter your work phone number, inc. area code" 
                        bus-ph="Enter the office / work phone number" 
                        res-err="The office / work phone is invalid. Try formatting it as +64X XXX XXXX or entering NA" 
                        bus-err="The office phone is invalid. Try formatting it as +64X XXX XXXX or entering NA" 
                        value="<?php $this->moveins->custdata('customerworkphone'); ?>" 
                        filter="phone_nz" 
                        data-invalid="The office / work phone is invalid. Try formatting it as +64X XXX XXXX or entering NA"
                         />
            </div>
            <div class="form-col col-lg-3 mrg-b-md">
                <input type="tel" class="form-control" id="customermobilephone" name="customermobilephone" placeholder="Mobile phone*" value="<?php $this->moveins->custdata('customermobilephone'); ?>" required filter="mobile_nz" data-invalid="Mobile number is invalid. Formatting is 02 followed by 7 to 9 digits" />
            </div>
        </div>
        
        <div class="form-group mrg-b-md">
            <label for="customeremail" class="col-xs-12 col-lg-3 control-label alg-lft alg-lg-rgt">Email Address</label>
            <div class="col-xs-12 col-lg-4 mrg-b-md <?php echo $cls; ?>" id="email-row">
                <input type="email" class="form-control" id="customeremail" name="customeremail" placeholder="Enter your email address*" value="<?php $this->moveins->custdata('customeremail'); ?>" required filter="email" data-invalid="The email address appears to be invalid" readonly />
            </div>
            <?php
			if(!isset($this->moveins->user['customercode']) || $this->moveins->user['customercode']=='')
				{
			?>
				<label for="customeremailc" class="col-xs-12 col-lg-2 control-label alg-lft alg-lg-rgt register-only">Confirm email</label>
				<div class="col-xs-12 col-lg-3 mrg-b-md register-only<?php echo $cls; ?>">
					<input type="email" class="form-control register-only" id="customeremailc" name="customeremailc" placeholder="Confirm your email address*" required filter="email|matches:customeremail" data-invalid="The email address is invalid or it is not the same" />
				</div>
			<?php
				}
			?>
        </div>
        
        
         <?php
        $preq = !isset($this->moveins->customer['customercode']) || $this->moveins->customer['customercode']=='' ? '*' : '';
        $prat = $preq=='*' ? ' required="required"' : '';
        if(!isset($this->moveins->customer['customercode']) || $this->moveins->customer['customercode']=='')
            {
            $preq = '*';
            $prat = ' required="required"';
        ?>
        <hr class="" />
        <div class="form-group mrg-b-md register-only pass-row">
            <label for="customerpassword" class="col-xs-12 col-lg-3 control-label alg-lft alg-lg-rgt">Password</label>
            <div class="form-col col-xs-12 col-lg-4 mrg-b-md residential business<?php echo $cls; ?>">
                <input type="password" filter="min_length:6" class="form-control register-only" id="customerpassword" name="customerpassword" placeholder="Enter a password for your account*" required="required" data-invalid="Your password must be at least 6 characters long" />
            </div>
            <label for="confirmpassword" class="col-xs-12 col-lg-2 control-label alg-lft alg-lg-rgt">Confirm Password</label>
            <div class="form-col col-xs-12 col-lg-3 mrg-b-md residential business<?php echo $cls; ?>">
                <input type="password" filter="min_length:6|matches:customerpassword" class="form-control register-only" id="confirmpassword" name="confirmpassword" data-match="customerpassword" data-match-error="The passwords don't match" placeholder="Confirm the password*" required="required" data-invalid="The passwords are not the same" />
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
        
        
        <div class="col-xs-12 pad-none residential business<?php echo $cls; ?>">
            <button type="button" class="btn pull-right bg-3 bg-4-hover txt-1 txt-1-hover txt-uc save-customer" id="placeres">Reserve Space &raquo;</button>
        </div>
    </div>
</form>
