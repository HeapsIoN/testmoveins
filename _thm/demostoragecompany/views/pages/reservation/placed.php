<h1><?php $this->page->heading('pagetitle'); ?></h1>
<div class="col-xs-12 well">

    <div class="col-xs-12 pad-none">
    	<div class="col-xs-12 pad-none lh-30 mrg-b-lg">Thanks for choosing <?php echo $this->moveins->facinfo['facilityname']; ?>! Your reservation has been confirmed.</div>
        <div class="col-xs-12 col-md-5 pad-none">
        	<h5 class="col-xs-12 txt-bl">Your information</h5>
            <div class="col-xs-12 lh-30"><?php echo $this->moveins->customer['customerfirstname'].' '.$this->moveins->customer['customersurname']; ?></div>
            <div class="col-xs-12 lh-30">
            	<?php 
				if($this->moveins->customer['customerhomephone']!='')
					{
					echo '<span class="pull-left pad-r-md">(h) '.$this->moveins->customer['customerhomephone'].'</span>'; 
					}
				
				if($this->moveins->customer['customermobilephone']!='')
					{
					echo '<span class="pull-left pad-r-md">(m) '.$this->moveins->customer['customermobilephone'].'</span>'; 
					}
				
				if($this->moveins->customer['customerworkphone']!='')
					{
					echo '<span class="pull-left pad-r-md">(w) '.$this->moveins->customer['customerworkphone'].'</span>'; 
					}
				?>
            </div>
            <div class="col-xs-12 lh-30"><?php echo $this->moveins->customer['customeremail']; ?></div>
        </div>
        <div class="col-xs-12 col-md-7 pad-none bg-lgt-grey pad-b">
        	
            <div class="col-xs-12 col-md-6 pad-none">
                <h5 class="col-xs-12 txt-bl">Reservation Details</h5>
                <div class="col-xs-12 lh-30">
                    <div class="col-xs-7 col-md-5 txt-xs pad-none">MoveIn Date:</div>
                    <?php echo date('jS M, Y', strtotime($this->moveins->order['unitfrom'])); ?>
                </div>
                <div class="col-xs-12 lh-30">
                    <div class="col-xs-7 col-md-5 txt-xs pad-none">Unit Type / Size:</div>
                    <?php 
					echo $this->moveins->order['unitwebname']; 
					?>
                </div>
        	</div>
            
            <div class="col-xs-12 col-md-6 pad-none">
                <h5 class="col-xs-12 txt-bl">Monthly Rental Costs</h5>
                <div class="col-xs-12 lh-30">
                    <div class="col-xs-7 txt-xs pad-none">Monthly Rental:</div>
                    <?php $this->regioning->currency();echo number_format($this->moveins->order['unitrate'],2,'.',','); ?>
                </div>
                <?php
				if($this->moveins->order['resfees']!='')
					{
				?>
                <div class="col-xs-12 lh-30">
                    <div class="col-xs-7 txt-xs pad-none">Admin Fees:</div>
                    <?php $this->regioning->currency();echo number_format($this->moveins->order['resfees'],2,'.',','); ?>
                </div>
                <?php
					}
                ?>
                <div class="col-xs-12 lh-30">
                    <div class="col-xs-7 txt-xs pad-none">Total Cost to MoveIn:</div>
                    <?php $this->regioning->currency();echo number_format($this->moveins->order['duetoday'],2,'.',','); ?>
                </div>
        	</div>
            
        </div>
        
        <hr class="clear-hr" />
        
        <div class="col-xs-12 col-md-5 pad-none">
            <h5 class="col-xs-12 txt-bl">Your Account</h5>
            <div class="form-group">
             	<div class="col-xs-12 lh-30">
                    <div class="col-xs-7 col-md-5 txt-xs pad-none">Username:</div>
                    <?php echo $this->moveins->customer['customeremail']; ?>
                </div>   
            </div>
            <div class="form-group">
             	<div class="col-xs-12 lh-30">
                    <div class="col-xs-7 col-md-5 txt-xs pad-none">Reservation Number:</div>
                    <?php echo str_replace($this->moveins->faccode,'', $this->moveins->order['reservation']); ?>
                </div>   
            </div>
        </div>
        
        
        <div class="col-xs-12 col-md-7 pad-none bg-lgt-grey pad-b">
        	<?php
			if(isset($this->moveins->order['receiptid']))
				{
			?>
            <div class="col-xs-12 col-md-6 pad-none">
                <h5 class="col-xs-12 txt-bl">Booking Fee Paid</h5>
                <div class="col-xs-12 lh-30">
                    <div class="col-xs-7 col-md-5 txt-xs pad-none">Receipt No:</div>
                    <?php echo $this->moveins->order['receiptid']; ?>
                </div>
                <div class="col-xs-12 lh-30">
                    <div class="col-xs-7 col-md-5 txt-xs pad-none">Total Paid:</div>
                    <?php $this->regioning->currency();echo number_format($this->moveins->order['amountcharged'],2,'.',','); ?>
                </div>
        	</div>
            <?php
				}
			else
				{
			?>
            <div class="col-xs-12 col-md-6 pad-none">
                <h5 class="col-xs-12 txt-bl">How To Pay</h5>
                <div class="col-xs-12 lh-30">
                    We accept cash and, all major credit cards
                </div>
        	</div>
            <?php
				}
			?>
            <div class="col-xs-12 col-md-6 pad-none">
                <h5 class="col-xs-12 txt-bl">Please bring with you:</h5>
                <div class="col-xs-12 lh-30">
                    <ul>
                    	<li>Photo identification</li>
                        <li>Your confirmation email</li>
                    </ul>
                </div>
        	</div>
            
        </div>
        
        
        
        <div class="col-xs-12 pad-none mrg-t-md"> 
            
            
            <div class="form-group mrg-b-none">
                <div class="col-xs-12 pad-none mrg-b-md">
                	<span class="btn pull-left bg-red txt-1 bg-orange-hover">Print this Page</span>	
                </div>
                <div class="col-xs-12 pad-none">
                    <span class="col-xs-6 pad-none">
                    <span class="col-xs-12 pad-none lh-20">Proceed straight to move in?</span>
                    <a href="/reservation/movein/<?php echo strtolower($this->moveins->faccode); ?>/<?php echo $this->reservations->hashid; ?>" class="btn pull-left bg-3 txt-1 bg-4-hover">Move In Now</a>
                    </span>
					
					<?php
					if($this->moveins->facinfo['facilityresreturn']!='')
						{
					?>
                    <span class="col-xs-6 pad-none">
                    <span class="col-xs-12 pad-none lh-20">&nbsp;</span>
                    <a href="<?php echo $this->moveins->facinfo['facilityresreturn']; ?>" class="btn pull-right bg-3 txt-1 bg-4-hover">Finish</a>
                    <span class="pull-right alg-rt pad-t-lg lh-20 pad-r txt-xs">You may change your space at any time when arriving at the facility.</span>
                    </span>
                    <?php
						}
					?>		
                </div>
            </div>
        </div>
    
    </div>
</div>