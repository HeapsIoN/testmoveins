<p>&nbsp;</p>
<h2><?php $this->page->heading('pagetitle'); ?></h2>
<p>&nbsp;</p>

<p>Please review your agreement information and the terms &amp; conditions below. If you need to, you can also return to the <a href="/customer" class="txt-3" style="text-decoration: underline;">login screen</a>.</p>
<p>&nbsp;</p>
<div class="col-xs-12 well">
<form id="form" class="form-horizontal">
	<fieldset>
		<?php
		if($this->moveins->customer['isbusiness']=='1')
			{
		?>
        <h4>Company Details</h4>
        <div class="form-group">
            <div class="col-lg-4">
                <p class="label">Company Name</p>
                <p><?php $this->moveins->custdata('customerfullname'); ?></p>
            </div>
            <div class="col-lg-4">
                <p class="label">Company GST Number</p>
                <p><?php $this->moveins->custdata('companynumber'); ?></p>
            </div>
            <div class="col-lg-4">
                <p class="label">Email</p>
                <p><?php $this->moveins->custdata('customeremail', 'Not Supplied'); ?></p>
            </div>
        </div>
        <div class="form-group">
            <div class="col-lg-4">
                <p class="label">Contact Name</p>
                <p><?php $this->moveins->custdata('contactname'); ?></p>
            </div>
            <div class="col-lg-4">
                <p class="label">Office Phone</p>
                <p><?php $this->moveins->custdata('customerworkphone'); ?></p>
            </div>
            <div class="col-lg-4">
                <p class="label">Office Mobile</p>
                <p><?php $this->moveins->custdata('customermobilephone'); ?></p>
            </div>
        </div>
        
        
        <hr />
        
        <h4>Owner Details</h4>
        <div class="form-group">
            <div class="col-xs-6">
                <p class="label">Business Owner Name</p>
                <p><?php $this->moveins->custdata('customeralttitle'); ?> <?php $this->moveins->custdata('customeraltname'); ?></p>
            </div>
            <div class="col-xs-6">
                <p class="label">Business Owner Phone</p>
                <p><?php $this->moveins->custdata('customeraltmobile'); ?></p>
            </div>
            <div class="col-xs-6">
                <p class="label">Owner Address</p>
                <p><?php $this->moveins->custdata('customeraltaddress'); ?>, <?php $this->moveins->custdata('customeraltsuburb'); ?> <?php $this->moveins->custdata('customeraltstate'); ?> <?php $this->moveins->custdata('customeraltpostcode'); ?></p>
            </div>
            <div class="col-xs-6">
                <p class="label">Business Owner Email</p>
                <p><?php $this->moveins->custdata('customeraltemail'); ?></p>
            </div>
        </div>
        
        <hr />
        
        <h4>Company Address Details</h4>
        <div class="form-group">
        	<div class="col-xs-12">
                <p class="label">Business Address</p>
                <p><?php $this->moveins->custdata('customeraddress'); ?>, <?php 
                    if(in_array($this->moveins->facinfo['facilityregion'], array('CA', 'TH', 'SA')))
                        {
                        $this->moveins->custdata('customercity');
                        echo ' ';
                        $this->moveins->custdata('customerstate');
                        echo ' ';
                        $this->moveins->custdata('customerpostcode');	
                        }
                    else
                        {
                        $this->moveins->custdata('customersuburb');
                        echo ' ';
                        $this->moveins->custdata('customerstate');
                        echo ' ';
                        $this->moveins->custdata('customerpostcode'); 
                        }
                    ?>
                </p>
			</div>
        	<div class="col-xs-12">
                <p class="label">Postage Address</p>
                <p><?php $this->moveins->custdata('customermailaddress'); ?>, <?php 
                    if(in_array($this->moveins->facinfo['facilityregion'], array('CA', 'TH', 'SA')))
                        {
                        $this->moveins->custdata('customermailcity');
                        echo ' ';
                        $this->moveins->custdata('customermailstate');
                        echo ' ';
                        $this->moveins->custdata('customermailpostcode');	
                        }
                    else
                        {
                        $this->moveins->custdata('customermailsuburb');
                        echo ' ';
                        $this->moveins->custdata('customermailstate');
                        echo ' ';
                        $this->moveins->custdata('customermailpostcode'); 
                        }
                    ?>
                </p>
            </div>
        </div>
        
        
        <?php		
			}
		else
			{
		?>
        <h4>Primary Contact Information</h4>
        <div class="form-group">
            <div class="col-lg-4">
                <p class="label">Customer Name</p>
                <p>
                    <?php $this->moveins->custdata('customertitle'); ?> <?php $this->moveins->custdata('customerfirstname'); ?> <?php $this->moveins->custdata('customersurname'); ?>                
                </p>
            </div>
            <div class="col-lg-8">
                <p class="label">Email</p>
                <p><?php $this->moveins->custdata('customeremail', 'Not Supplied'); ?></p>
            </div>
            <div class="col-lg-4">
                <p class="label">Home Phone</p>
                <p><?php $this->moveins->custdata('customerhomephone', 'Not Supplied'); ?></p>
            </div>
            <div class="col-lg-4">
                <p class="label">Mobile Phone</p>
                <p><?php $this->moveins->custdata('customermobilephone', 'Not Supplied'); ?></p>
            </div>
            <div class="col-lg-4">
                <p class="label">Work Phone</p>
                <p><?php $this->moveins->custdata('customerworkphone', 'Not Supplied'); ?></p>
            </div>
        	<div class="col-lg-4">
                <p class="label">Home Address</p>
                <p><?php $this->moveins->custdata('customeraddress'); ?>, <?php 
                    if(in_array($this->moveins->facinfo['facilityregion'], array('CA', 'TH', 'SA')))
                        {
                        $this->moveins->custdata('customercity');
                        echo ' ';
                        $this->moveins->custdata('customerstate');
                        echo ' ';
                        $this->moveins->custdata('customerpostcode');	
                        }
                    else
                        {
                        $this->moveins->custdata('customersuburb');
                        echo ' ';
                        $this->moveins->custdata('customerstate');
                        echo ' ';
                        $this->moveins->custdata('customerpostcode'); 
                        }
                    
                    ?></p>
        	</div>
        	<div class="col-lg-4">
                <p class="label">Postage Address</p>
                <p><?php $this->moveins->custdata('customermailaddress'); ?>, <?php 
                    if(in_array($this->moveins->facinfo['facilityregion'], array('CA', 'TH', 'SA')))
                        {
                        $this->moveins->custdata('customermailcity');
                        echo ' ';
                        $this->moveins->custdata('customermailstate');
                        echo ' ';
                        $this->moveins->custdata('customermailpostcode');	
                        }
                    else
                        {
                        $this->moveins->custdata('customermailsuburb');
                        echo ' ';
                        $this->moveins->custdata('customermailstate');
                        echo ' ';
                        $this->moveins->custdata('customermailpostcode'); 
                        }
                    
                    ?>
                </p>
            </div>
		</div>
        
        <hr />
        
        <h4>Alternate Contact Details</h4>
        <div class="form-group">
            <div class="col-lg-12">
                <p class="label">Alt. Contact Name</p>
                <p><?php $this->moveins->custdata('customeralttitle'); ?> <?php $this->moveins->custdata('customeraltname'); ?></p>
            </div>
            <div class="col-lg-4">
                <p class="label">Alt. Contact Mobile Phone</p>
                <p><?php $this->moveins->custdata('customeraltmobile', 'Not Supplied'); ?></p>
            </div>
            <div class="col-lg-8">
                <p class="label">Alt. Contact Email</p>
                <p><?php $this->moveins->custdata('customeraltemail', 'Not Supplied'); ?></p>
            </div>
            <div class="col-lg-12">
                <p class="label">Alt. Contact Address</p>
                <p><?php $this->moveins->custdata('customeraltaddress'); ?>, <?php 
                    if(in_array($this->moveins->facinfo['facilityregion'], array('CA', 'TH', 'SA')))
                        {
                        $this->moveins->custdata('customeraltcity');
                        echo ' ';
                        $this->moveins->custdata('customeraltstate');
                        echo ' ';
                        $this->moveins->custdata('customeraltpostcode');	
                        }
                    else
                        {
                        $this->moveins->custdata('customeraltsuburb');
                        echo ' ';
                        $this->moveins->custdata('customeraltstate');
                        echo ' ';
                        $this->moveins->custdata('customeraltpostcode'); 
                        }
                    
                    ?>
                </p>
            </div>
		</div>
        <?php
			}
		
		?>
        
        <hr />
        
        <h4>Facility Information</h4>
        <div class="form-group">
            <div class="col-lg-4 mrg-b-md">
                <p class="label">Facility Name</p>
                <p><?php echo $this->moveins->facinfo['facilityfullname']; ?></p>
            </div>
            <div class="col-lg-4 mrg-b-md">
                <p class="label">Facility Phone</p>
                <p><?php echo $this->moveins->facinfo['facilityphone']; ?></p>
            </div>
            <div class="col-lg-4 mrg-b-md">
                <p class="label">Facility Email</p>
                <p><?php echo $this->moveins->facinfo['facilityemail']; ?></p>
            </div>
            <div class="col-xs-12 mrg-b-md">
                <p class="label">Facility Address</p>
                <p><?php echo $this->moveins->facinfo['facilityaddress'].', '.$this->moveins->facinfo['facilitysuburb'].' '.$this->moveins->facinfo['facilitystate'].' '.$this->moveins->facinfo['facilitypostcode']; ?></p>
            </div>
        </div>
        <hr />
        
        <h4>Storage Fees and Charges</h4>
        <div class="form-group">
            <div class="col-lg-12">
                <ul>
                    <li>Your storage fee is <span class="txt-4 txt-bl"><?php $this->regioning->currency();echo number_format($this->moveins->order['unitrate'],2,'.',','); ?></span> per month.</li>
                    <li>Your storage fee is from the <span class="txt-4 txt-bl"><?php echo date('jS M, Y', strtotime($this->moveins->order['unitfrom'])); ?></span> to the <span class="txt-4 txt-bl"><?php echo date('jS M, Y', strtotime($this->moveins->order['unitto'])); ?></span> and is extended automatically until <span class="txt-4 txt-bl"><?php echo $this->moveins->facinfo['facilitymoveoutnotice']; ?></span> days notice is given by either party.</li>
					<?php
                    if(isset($this->moveins->facinfo['fees']['late']))
                        {
                    ?>
                    <li>
                        A late fee of <span class="txt-4 txt-bl"><?php $this->regioning->currency();echo $this->moveins->facinfo['fees']['late']; ?></span> is applied <span class="txt-4 txt-bl"><?php echo $this->moveins->facinfo['facilitylatedays']; ?></span> after the bill is due if the payment has not been received.
                    </li>
                    <?php
                        }
                        
                    if(isset($this->moveins->facinfo['fees']['deposit']))
                        {
                    ?>
                    <li>
                        Deposit Fee: <?php $this->regioning->currency();echo $this->moveins->facinfo['fees']['deposit']; ?>
                    </li>
                    <?php
                        }
                    
                    if(isset($this->moveins->facinfo['fees']['cleaning']))
                        {	
                    ?>
                    <li>
                        Cleaning Fee: <?php $this->regioning->currency();echo $this->moveins->facinfo['fees']['cleaning']; ?>
                    </li>
                    <?php
                        }
                    
                    if(isset($this->moveins->facinfo['fees']['admin']))
                        {	
                    ?>
                    <li class="col-xs-12 col-md-4 mrg-b-md lh-40">
                        Admin Fee <?php $this->regioning->currency();echo $this->moveins->facinfo['fees']['admin']; ?>
                    </li>
                    <?php
                        }
                        
                    ?>
                </ul>
            </div>
        </div>
        <hr />
        
        <h4>Marketing and Correspondence</h4>
        <div class="form-group">
            <div class="col-xs-12 mrg-b-md">
                <?php $this->page->fields->checkbox('sendmarketing', 'I <strong>do not</strong> want to receive marketing material and notifications', '1'); ?>
            </div>
            <div class="col-xs-12 mrg-b-md">
                <?php $this->page->fields->checkbox('marketingafter', 'I <strong>do not</strong> want to receive marketing material and notifications after my agreement ends', '1'); ?>
            </div>
        </div>
        <hr />
        
        <h4>Summary of Important Terms and Conditions</h4>
        <div class="form-group">
            <div class="col-lg-12">
                <ul>
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
		</div>
        <h4>Full Terms and Conditions</h4>
        <div class="form-group">            
            <div class="col-lg-12">
                <div class="col-lg-12 bg-white mrg-b-md" id="full-terms">
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
            	<div class="col-xs-12 mrg-b-md alert-error alg-ctr lh-50" id="scroll-msg">
                    You must scroll to the bottom of the terms and conditions to be able to accept them.
                </div>
            </div>            
            <div class="col-xs-12 hdn" id="accepter">
            <?php
            
            $this->page->fields->checkbox('acceptterms', 'I have read and accept all the terms and conditions for the agreement (Not just the key points)', '1');		
            
            ?>
            </div>
            <div class="col-xs-12 mrg-b-md">
            <?php
            
            $this->page->fields->checkbox('storercheck', 'I consent to the undertaking of a search of my details against the Storer Check Pty Ltd database, and to my details and personal information being released to Storer Check Pty Ltd pursuant to the Personal Information Document and the terms and conditions set out at www.storercheck.com.', '1');		
            
            ?>
            </div>
            <div class="col-xs-12 mrg-b-md alg-ctr txt-red">
                Please note that if you do not consent to the Storer Check, the facility may choose to not provide you with self storage.
            </div>
        </div>
        <?php
		if(isset($this->moveins->facinfo['insrates']) && !empty($this->moveins->facinfo['insrates']))
			{
		?> 
        
        <hr />
        <h4>Insurance</h4>
        <div class="form-group">
            <div class="col-lg-6">
                <?php $this->page->fields->checkbox('extrainsurance', 'Yes, I would like additional insurance on my unit', '1'); ?>	
            </div>
            <div class="col-lg-6 storman-hdn" id="extra-insurance">
                <select class="form-control" name="insurance" id="insurance">
					<option value="">[ Select Insurance Coverage ]</option>
				<?php 
				foreach($this->moveins->facinfo['insrates'] as $v => $l)
					{
					echo '<option value="'.$v.'">'.$l.'</option>';	
					}
				//$this->page->fields->select('', 'insurance', $this->moveins->facinfo['insrates'], '', 'insurance', '', 'Select Insurance Coverage'); 
				?>
                </select>
            </div>
        </div>
        <?php
			}
		?>
        
        <hr />
        
        <h4>Signature</h4>
        <div class="form-group">
            <div class="col-xs-12 col-md-6 mrg-b-md">
                <div id="signature" class="signature">
                    <canvas id="sign-pad" height="150px" width="400px" style="max-width:100%"></canvas>
                    <input class="output" type="hidden" name="output" value="">
                </div>
                <?php 
				$nme = $this->moveins->customer['customerfirstname'].' '.$this->moveins->customer['customersurname'];
				$lbl = 'Signed by ';
				
				if($this->moveins->customer['isbusiness']=='1')
					{
					$nme = $this->moveins->customer['customerfirstname'];
					$lbl = 'Signed by staff from ';
					}
				?>
                <div id="sign-date">
                    <?php echo $lbl; ?> <span class="txt-4"><?php echo $nme; ?></span> On <span class="txt-4"><?php echo date('jS M, Y'); ?></span>
                </div>
            </div>
        <?php
		if(isset($this->moveins->customer['dualaccount']) && $this->moveins->customer['dualaccount']=='1')
			{
		?>
            <div class="col-xs-12 col-md-6 mrg-b-md">
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
        </div>
        <div class="form-group mrg-b-none">
        	<div class="col-lg-12">
            	<button type="button" class="btn pull-left bg-5 txt-1 bg-4-hover txt-1-hover txt-uc clearsign" id="clearsign">Clear Signatures</button>
            	<button type="button" class="btn pull-right bg-3 txt-1 bg-4-hover txt-1 txt-1-hover txt-uc" id="generate">Continue &raquo;</button>
            </div>
		</div>
	</fieldset>
</form>
</div>


<p> If you need to, you can also return to the <a href="/customer" class="txt-3" style="text-decoration: underline;">login screen</a>.</p>