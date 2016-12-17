<h1><?php $this->page->heading('pagetitle'); ?></h1>
<form id="form">
<div class="col-xs-12 pad-none">
	<div class="col-xs-12 pad-none">
    	<div class="col-xs-12 col-md-6 col-md-offset-3 pad-none mrg-b-md">
        	<a href="/customer" class="btn col-xs-12 bg-3 bg-4-hover txt-1 txt-1-hover txt-uc">&laquo; Back to Login / Register</a>
        </div>
		<?php
		if($this->moveins->customer['isbusiness']=='1')
			{
		?>
        <h2 class="col-xs-12 mrg-b-md txt-lg bg-4 txt-1 lh-50">Company Details</h2>
        <div class="col-xs-12 pad-none mrg-b-md">
        	<label class="lbl col-xs-12 alg-lft txt-sm lh-30">Company Name</label>
            <span class="col-xs-12 txt-lg txt-4 lh-50"><?php $this->moveins->custdata('customerfirstname'); ?></span>
        </div>
        <div class="col-xs-12 pad-none mrg-b-md">
        	<label class="lbl col-xs-12 alg-lft txt-sm lh-30">Company ABN / GST Number</label>
            <span class="col-xs-12 txt-lg txt-4 lh-50"><?php $this->moveins->custdata('companynumber'); ?></span>
        </div>
        <div class="col-xs-12 pad-none mrg-b-md">
        	<label class="lbl col-xs-12 alg-lft txt-sm lh-30">Contact Name</label>
            <span class="col-xs-12 txt-lg txt-4 lh-50"><?php $this->moveins->custdata('customersurname'); ?></span>
        </div>
        <div class="col-xs-12 col-sm-6 pad-none mrg-b-md">
        	<label class="lbl col-xs-12 alg-lft txt-sm lh-30">Office Phone</label>
            <span class="col-xs-12 txt-lg txt-4 lh-50"><?php $this->moveins->custdata('customerworkphone'); ?></span>
        </div>
        <div class="col-xs-12 col-sm-6 pad-none mrg-b-md">
        	<label class="lbl col-xs-12 alg-lft txt-sm lh-30">Office Mobile</label>
            <span class="col-xs-12 txt-lg txt-4 lh-50"><?php $this->moveins->custdata('customermobilephone'); ?></span>
        </div>
        <div class="col-xs-12 pad-none mrg-b-md">
        	<label class="lbl col-xs-12 alg-lft txt-sm lh-30">Email</label>
            <span class="col-xs-12 txt-lg txt-4 lh-50"><?php $this->moveins->custdata('customeremail', 'Not Supplied'); ?></span>
        </div>
        
        <h2 class="col-xs-12 mrg-b-md txt-lg bg-4 txt-1 lh-50">Company Address Details</h2>
        <div class="col-xs-12 pad-none mrg-b-md">
        	<label class="lbl col-xs-12 alg-lft txt-sm lh-30">Business Address</label>
            <span class="col-xs-12 txt-lg txt-4 lh-50"><?php $this->moveins->custdata('customeraddress'); ?></span>
            <span class="col-xs-12 txt-lg txt-4 lh-50">
				<?php 
				if(in_array($this->moveins->facinfo['facilityregion'], array('CA', 'TH', 'SA')))
					{
					$this->moveins->custdata('customercity');
					echo ', ';
					$this->moveins->custdata('customerstate');
					echo ' ';
					$this->moveins->custdata('customerpostcode');	
					}
				else
					{
					$this->moveins->custdata('customersuburb');
					echo ', ';
					$this->moveins->custdata('customerstate');
					echo ' ';
					$this->moveins->custdata('customerpostcode'); 
					}
				
				?>
			</span>
        </div>
        <div class="col-xs-12 pad-none mrg-b-md">
        	<label class="lbl col-xs-12 alg-lft txt-sm lh-30">Postage Address</label>
            <span class="col-xs-12 txt-lg txt-4 lh-50"><?php $this->moveins->custdata('customermailaddress'); ?></span>
            <span class="col-xs-12 txt-lg txt-4 lh-50">
				<?php 
				if(in_array($this->moveins->facinfo['facilityregion'], array('CA', 'TH', 'SA')))
					{
					$this->moveins->custdata('customermailcity');
					echo ', ';
					$this->moveins->custdata('customermailstate');
					echo ' ';
					$this->moveins->custdata('customermailpostcode');	
					}
				else
					{
					$this->moveins->custdata('customermailsuburb');
					echo ', ';
					$this->moveins->custdata('customermailstate');
					echo ' ';
					$this->moveins->custdata('customermailpostcode'); 
					}
				
				?>
			</span>
        </div>
        
        <h2 class="col-xs-12 mrg-b-md txt-lg bg-4 txt-1 lh-50">Owner Details</h2>
        <div class="col-xs-12 pad-none mrg-b-md">
        	<label class="lbl col-xs-12 alg-lft txt-sm lh-30">Business Owner Name</label>
            <span class="col-xs-12 txt-lg txt-4 lh-50"><?php $this->moveins->custdata('customeralttitle'); ?> <?php $this->moveins->custdata('customeraltname'); ?></span>
        </div>
        <div class="col-xs-12 pad-none mrg-b-md">
        	<label class="lbl col-xs-12 alg-lft txt-sm lh-30">Owner Address</label>
            <span class="col-xs-12 txt-lg txt-4 lh-50"><?php $this->moveins->custdata('customeraltaddress'); ?></span>
            <span class="col-xs-12 txt-lg txt-4 lh-50">
				<?php $this->moveins->custdata('customeraltsuburb'); ?>, <?php $this->moveins->custdata('customeraltstate'); ?> <?php $this->moveins->custdata('customeraltpostcode'); ?>
			</span>
        </div>
        <?php		
			}
		else
			{
		?>
        <h2 class="col-xs-12 mrg-b-md txt-lg bg-4 txt-1 lh-50">Customer Details</h2>
        <div class="col-xs-12 pad-none mrg-b-md">
        	<label class="lbl col-xs-12 alg-lft txt-sm lh-30">Customer Name</label>
            <span class="col-xs-12 txt-lg txt-4 lh-50">
				<?php $this->moveins->custdata('customertitle'); ?> <?php $this->moveins->custdata('customerfirstname'); ?> <?php $this->moveins->custdata('customersurname'); ?>                
			</span>
        </div>
        <div class="col-xs-12 col-sm-4 pad-none">
        	<label class="lbl col-xs-12 alg-lft txt-sm lh-30">Home Phone</label>
            <span class="col-xs-12 txt-lg txt-4 lh-50"><?php $this->moveins->custdata('customerhomephone', 'Not Supplied'); ?></span>
        </div>
        <div class="col-xs-12 col-sm-4 pad-none">
        	<label class="lbl col-xs-12 alg-lft txt-sm lh-30">Mobile Phone</label>
            <span class="col-xs-12 txt-lg txt-4 lh-50"><?php $this->moveins->custdata('customermobilephone', 'Not Supplied'); ?></span>
        </div>
        <div class="col-xs-12 col-sm-4 pad-none">
        	<label class="lbl col-xs-12 alg-lft txt-sm lh-30">Work Phone</label>
            <span class="col-xs-12 txt-lg txt-4 lh-50"><?php $this->moveins->custdata('customerworkphone', 'Not Supplied'); ?></span>
        </div>
        <div class="col-xs-12 pad-none mrg-b-md">
        	<label class="lbl col-xs-12 alg-lft txt-sm lh-30">Email</label>
            <span class="col-xs-12 txt-lg txt-4 lh-50"><?php $this->moveins->custdata('customeremail', 'Not Supplied'); ?></span>
        </div>
        
        <h2 class="col-xs-12 mrg-b-md txt-lg bg-4 txt-1 lh-50">Customer Address Details</h2>
        <div class="col-xs-12 col-sm-6 pad-none">
        	<label class="lbl col-xs-12 alg-lft txt-sm lh-30">Home Address</label>
            <span class="col-xs-12 txt-lg txt-4 lh-50"><?php $this->moveins->custdata('customeraddress'); ?></span>
            <span class="col-xs-12 txt-lg txt-4 lh-50">
				<?php 
				if(in_array($this->moveins->facinfo['facilityregion'], array('CA', 'TH', 'SA')))
					{
					$this->moveins->custdata('customercity');
					echo ', ';
					$this->moveins->custdata('customerstate');
					echo ' ';
					$this->moveins->custdata('customerpostcode');	
					}
				else
					{
					$this->moveins->custdata('customersuburb');
					echo ', ';
					$this->moveins->custdata('customerstate');
					echo ' ';
					$this->moveins->custdata('customerpostcode'); 
					}
				
				?>
			</span>
        </div>
        <div class="col-xs-12 col-sm-6 pad-none mrg-b-md">
        	<label class="lbl col-xs-12 alg-lft txt-sm lh-30">Postage Address</label>
            <span class="col-xs-12 txt-lg txt-4 lh-50"><?php $this->moveins->custdata('customermailaddress'); ?></span>
            <span class="col-xs-12 txt-lg txt-4 lh-50">
				<?php 
				if(in_array($this->moveins->facinfo['facilityregion'], array('CA', 'TH', 'SA')))
					{
					$this->moveins->custdata('customermailcity');
					echo ', ';
					$this->moveins->custdata('customermailstate');
					echo ' ';
					$this->moveins->custdata('customermailpostcode');	
					}
				else
					{
					$this->moveins->custdata('customermailsuburb');
					echo ', ';
					$this->moveins->custdata('customermailstate');
					echo ' ';
					$this->moveins->custdata('customermailpostcode'); 
					}
				
				?>
			</span>
        </div>
        
        <h2 class="col-xs-12 mrg-b-md txt-lg bg-4 txt-1 lh-50">Alternate Contact Details</h2>
        <div class="col-xs-12 col-sm-4 pad-none mrg-b-md">
        	<label class="lbl col-xs-12 alg-lft txt-sm lh-30">Alt. Contact Name</label>
            <span class="col-xs-12 txt-lg txt-4 lh-50">
				<?php $this->moveins->custdata('customeralttitle'); ?> <?php $this->moveins->custdata('customeraltname'); ?>                
			</span>
        </div>
        <div class="col-xs-12 col-sm-4 pad-none mrg-b-md">
        	<label class="lbl col-xs-12 alg-lft txt-sm lh-30">Alt. Contact Mobile Phone</label>
            <span class="col-xs-12 txt-lg txt-4 lh-50"><?php $this->moveins->custdata('customeraltmobile', 'Not Supplied'); ?></span>
        </div>
        <div class="col-xs-12 col-sm-4 pad-none mrg-b-md">
        	<label class="lbl col-xs-12 alg-lft txt-sm lh-30">Alt. Contact Email</label>
            <span class="col-xs-12 txt-lg txt-4 lh-50"><?php $this->moveins->custdata('customeraltemail', 'Not Supplied'); ?></span>
        </div>
        <div class="col-xs-12 pad-none mrg-b-md">
        	<label class="lbl col-xs-12 alg-lft txt-sm lh-30">Alt. Contact Address</label>
            <span class="col-xs-12 txt-lg txt-4 lh-50"><?php $this->moveins->custdata('customeraltaddress'); ?></span>
            <span class="col-xs-12 txt-lg txt-4 lh-50">
				<?php 
				if(in_array($this->moveins->facinfo['facilityregion'], array('CA', 'TH', 'SA')))
					{
					$this->moveins->custdata('customeraltcity');
					echo ', ';
					$this->moveins->custdata('customeraltstate');
					echo ' ';
					$this->moveins->custdata('customeraltpostcode');	
					}
				else
					{
					$this->moveins->custdata('customeraltsuburb');
					echo ', ';
					$this->moveins->custdata('customeraltstate');
					echo ' ';
					$this->moveins->custdata('customeraltpostcode'); 
					}
				
				?>
			</span>
        </div>
        <?php
			}
		
		?>
        
        <h2 class="col-xs-12 mrg-b-md txt-lg bg-4 txt-1 lh-50">Facility Information</h2>
        <div class="col-xs-12 col-sm-4 pad-none mrg-b-md">
        	<label class="lbl col-xs-12 alg-lft txt-sm lh-30">Facility Name</label>
            <span class="col-xs-12 txt-lg txt-4 lh-50"><?php echo $this->moveins->facinfo['facilityfullname']; ?></span>
        </div>
        <div class="col-xs-12 col-sm-4 pad-none mrg-b-md">
        	<label class="lbl col-xs-12 alg-lft txt-sm lh-30">Facility Phone</label>
            <span class="col-xs-12 txt-lg txt-4 lh-50"><?php echo $this->moveins->facinfo['facilityphone']; ?></span>
        </div>
        <div class="col-xs-12 col-sm-4 pad-none mrg-b-md">
        	<label class="lbl col-xs-12 alg-lft txt-sm lh-30">Facility Email</label>
            <span class="col-xs-12 txt-lg txt-4 lh-50"><?php echo $this->moveins->facinfo['facilityemail']; ?></span>
        </div>
        <div class="col-xs-12 pad-none mrg-b-md">
        	<label class="lbl col-xs-12 alg-lft txt-sm lh-30">Facility Address</label>
            <span class="col-xs-12 txt-lg txt-4 lh-50"><?php echo $this->moveins->facinfo['facilityaddress'].' '.$this->moveins->facinfo['facilitysuburb'].', '.$this->moveins->facinfo['facilitystate'].' '.$this->moveins->facinfo['facilitypostcode']; ?></span>
        </div>
        
        <h2 class="col-xs-12 mrg-b-md txt-lg bg-4 txt-1 lh-50">Storage Fees and Charges</h2>
        <div class="col-xs-12 mrg-b-md lh-40">
        	Your storage fee is <span class="txt-lg txt-4">$<?php echo number_format($this->moveins->order['unitrate'],2,'.',','); ?></span> per month and is from the <span class="txt-lg txt-4"><?php echo date('jS M, Y', strtotime($this->moveins->order['unitfrom'])); ?></span> to the <span class="txt-lg txt-4"><?php echo date('jS M, Y', strtotime($this->moveins->order['unitto'])); ?></span> and is extended automatically until <span class="txt-lg txt-4"><?php echo $this->moveins->facinfo['facilitymoveoutnotice']; ?></span> days notice is given by either party.
        </div>
        <?php
		if(isset($this->moveins->facinfo['fees']['late']))
			{
		?>
        <div class="col-xs-12 mrg-b-md lh-40">
            A late fee of <span class="txt-lg txt-4">$<?php echo $this->moveins->facinfo['fees']['late']; ?></span> is applied <span class="txt-lg txt-4"><?php echo $this->moveins->facinfo['facilitylatedays']; ?></span> after the bill is due if the payment has not been received.
        </div>
        <?php
			}
			
		if(isset($this->moveins->facinfo['fees']['deposit']))
			{
		?>
        <div class="col-xs-12 col-md-4 pad-none mrg-b-md lh-40">
        	<span class="pull-left txt-3 txt-sm txt-uc pad-lr-md">Deposit Fee</span>
            $<?php echo $this->moveins->facinfo['fees']['deposit']; ?>
        </div>
        <?php
			}
		
		if(isset($this->moveins->facinfo['fees']['cleaning']))
			{	
		?>
        <div class="col-xs-12 col-md-4 pad-none mrg-b-md lh-40">
        	<span class="pull-left txt-3 txt-sm txt-uc pad-lr-md">Cleaning Fee</span>
            $<?php echo $this->moveins->facinfo['fees']['cleaning']; ?>
        </div>
        <?php
			}
		
		if(isset($this->moveins->facinfo['fees']['admin']))
			{	
		?>
        <div class="col-xs-12 col-md-4 pad-none mrg-b-md lh-40">
        	<span class="pull-left txt-3 txt-sm txt-uc pad-lr-md">Admin Fee</span>
            $<?php echo $this->moveins->facinfo['fees']['admin']; ?>
        </div>
        <?php
			}
			
		?>
        
        
        <h2 class="col-xs-12 mrg-b-md txt-lg bg-4 txt-1 lh-50">Marketing and Correspondence</h2>
        <div class="col-xs-12 pad-none mrg-b-md">
        <?php $this->page->fields->checkbox('sendmarketing', 'I DO NOT want to receive marketing material and notifications', '1'); ?>
        </div>
        <div class="col-xs-12 pad-none mrg-b-md">
        <?php $this->page->fields->checkbox('marketingafter', 'I DO NOT want to receive marketing material and notifications after my agreement ends', '1'); ?>
        </div>
        
        <h2 class="col-xs-12 mrg-b-md txt-lg bg-4 txt-1 lh-50">Summary of Important Terms and Conditions</h2>
        <div class="col-xs-12 mrg-b-md lh-40">
        	<ul class="col-xs-12 txt-xs lh-20">
                <li>All payments are to be made in advance by you (the Storer).</li>
                <li>Goods are stored at your own risk. We recommend that you take out insurance cover.</li>
                <li>The Facility Owner (the "FO") is excluded from liability for the loss of any goods stored on its premises, except for laws which cannot be excluded, including rights under the Australian Consumer Law.</li>
                <li>You must not store hazards dangerous, illegal, stolen, perishable, environmentally harmful or explosive goods.</li>
                <li>Unless specifically itemised and covered by insurance you must also not store goods that are irreplaceable such as currency, jewellery, furs, deeds, paintings, curios, works of art and items of personal sentimental value or items worth more than $2000 AUD in total. While the FO takes reasonable care to provide a secure Space, we cannot guard against all risks and unforeseen circumstances beyond our control and therefore, we recommend that you take out insurance in relation to items you intend to store in the Space or store valuable goods in places specifically designed for this purpose (i.e. a safety deposit box).</li>
                <li>The Space will only be accessible during set access hours as posted by the FO.</li>
                <li>7 days notice must be given for termination of this agreement.</li>
                <li>The Storer must notify the FO of all changes to their or the ACP’s address, e-mail, telephone numbers or other contact details.</li>
                <li>If you fail to comply with material terms in this agreement the FO will have certain rights which include forfeiture of your Deposit and the right to seize and sell and/or dispose of your goods (see clause 6).</li>
                <li>The FO may have the right to refuse access if all fees are not paid promptly (see clause 11).</li>
                <li>The FO has the right to enter the Space in certain circumstances (see clauses 6, 13, 14, 19, 20, 21 & 23).</li>
                <li>The FO may use a microprobe or CCTV to view inside the Space and rely on footage to enforce the contract, and/or may release footage to authorities (see clause 21A) in certain circum- stances, including where the FO reasonably suspects breach of the law or damage to premises.</li>
                <li>The FO may discuss your account, any default and your details with the ACP. Upon termination or default, the FO may elect to release items to the ACP (see clause 10(i)).</li>
            </ul>
            
        </div>
        
        <h2 class="col-xs-12 mrg-b-md txt-lg bg-4 txt-1 lh-50">Full Terms and Conditions</h2>
        <div class="col-xs-12 mrg-b-md lh-20" id="full-terms">
        <?php
		if(file_exists($_SERVER['DOCUMENT_ROOT'].'/_thm/'.$this->page->theme.'/views/pages/movein/terms.php'))
			{
			$this->load->view('../../'.$this->page->theme.'/views/pages/movein/terms', array());	
			}
		else
			{
			$this->load->view('pages/movein/terms', array());	
			}
		?>
        	
        </div>
        <div class="col-xs-12 pad-none mrg-b-md alert-error alg-ctr lh-50" id="scroll-msg">
        	You must scroll to the bottom of the terms and conditions to be able to accept them.
        </div>
        <div class="col-xs-12 pad-none mrg-b-md hdn" id="accepter">
        <?php
		
		$this->page->fields->checkbox('acceptterms', 'I have read and accept all the terms and conditions for the agreement (Not just the key points)', '1');		
		
		?>
        </div>
        <div class="col-xs-12 pad-none mrg-b-md">
        <?php
		
		$this->page->fields->checkbox('storercheck', 'I consent to the undertaking of a search of my details against the Storer Check Pty Ltd database, and to my details and personal information being released to Storer Check Pty Ltd pursuant to the Personal Information Document and the terms and conditions set out at www.storercheck.com.', '1');		
		
		?>
        </div>
        <div class="col-xs-12 pad-none mrg-b-md alg-ctr txt-red">
        	Please note that if you do not consent to the Storer Check, the facility may choose to not provide you with self storage.
        </div>
        <?php
		if(isset($this->moveins->facinfo['insrates']) && !empty($this->moveins->facinfo['insrates']))
			{
		?>      
        <h2 class="col-xs-12 mrg-b-md txt-lg bg-4 txt-1 lh-50">Insurance</h2>
        <div class="col-xs-12 pad-none mrg-b-md">
        	<?php $this->page->fields->checkbox('extrainsurance', 'Yes, I would like additional insurance on my unit', '1'); ?>	
        </div>
        <div class="col-xs-12 pad-none mrg-b-md storman-hdn" id="extra-insurance">
			<?php $this->page->fields->select('Select Insurance', 'insurance', $this->moveins->facinfo['insrates'], '', 'insurance', '', 'Select Insurance Coverage'); ?>
        </div>
        <?php
			}
		?>
        <h2 class="col-xs-12 mrg-b-md txt-lg bg-4 txt-1 lh-50">Signature</h2>
        <div class="col-xs-12 col-md-6 pad-none mrg-b-md">
        	<div id="signature" class="signature">
                <canvas id="sign-pad" height="150px" width="400px" style="max-width:100%"></canvas>
                <input class="output" type="hidden" name="output" value="">
            </div>
            <div id="sign-date">
                Signed by <span class="txt-4"><?php $this->moveins->custdata('customerfirstname'); ?> <?php $this->moveins->custdata('customersurname'); ?></span> On <span class="txt-4"><?php echo date('jS M, Y'); ?></span>
			</div>
        </div>
        <?php
		if(isset($this->moveins->customer['dual']) && $this->moveins->customer['dual']=='1')
			{
		?>
        <div class="col-xs-12 col-md-6 pad-none mrg-b-md">
        	<div id="signature-sec" class="signature">
                <canvas id="sign-pad-sec" height="150px" width="400px" style="max-width:100%"></canvas>
                <input class="output" type="hidden" name="output-2" value="">
            </div>
            <div id="sign-date">
                Signed by <span class="txt-4"><?php $this->moveins->custdata('customeraltfirstname').' '.$this->moveins->custdata('customeraltlastname'); ?></span> On <span class="txt-4"><?php echo date('jS M, Y'); ?></span>
			</div>
        	
        </div>
        <?php
			}
		?>
        
        <div class="col-xs-12 col-md-6 col-md-offset-3 pad-none mrg-b-md">
        	<button type="button" class="btn col-xs-12 bg-5 txt-1 bg-4-hover txt-1-hover txt-uc clearsign" id="clearsign">Clear Signatures &laquo;</button>
        </div>
        <div class="col-xs-12 col-md-6 col-md-offset-3 pad-none mrg-b-md">
        	<button type="button" class="btn col-xs-12 bg-3 txt-1 bg-4-hover txt-1 txt-1-hover txt-uc" id="generate">Continue &raquo;</button>
        </div>
        <div class="col-xs-12 col-md-6 col-md-offset-3 pad-none mrg-b-md">
        	<a href="/customer" class="btn col-xs-12 bg-3 bg-4-hover txt-1 txt-1-hover txt-uc">&laquo; Back to Login / Register</a>
        </div>
    </div>
</div>
</form>