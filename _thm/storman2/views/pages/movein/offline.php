<h1>System Offline</h1>
<form id="form">
<div class="col-xs-12 pad-none">
	<div class="col-xs-12 col-md-6 col-md-offset-3 pad-none">
    	<div class="col-xs-12 pad-none mrg-b-md">
        	<p>Sorry but the system appears to be offline at the moment.</p>
            <?php
			if(isset($this->moveins->facinfo['facilityofflineurl']) && $this->moveins->facinfo['facilityofflineurl']!='')
				{
				$url = substr($this->moveins->facinfo['facilityofflineurl'], 0, 7)!='http://' ? 'http://'.$this->moveins->facinfo['facilityofflineurl'] : $this->moveins->facinfo['facilityofflineurl'];
			?>
            <p>You can use the button below to go to our online contact form so that you can email us regarding the issue.</p>
            <p><a href="<?php echo $url; ?>" class="col-xs-12 alg-cr txt-lg lh-50 bg-3 txt-1 bg-5-hover" target="_blank">Contact Us</a></p>
			<?php
				}
			?>
        </div>
    </div>
</div>
</form>