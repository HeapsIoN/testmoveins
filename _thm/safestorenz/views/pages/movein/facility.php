<?php
$cls = isset($this->moveins->user['facilitycode']) && $this->moveins->user['facilitycode']!='' ? '' : ' storman-hdn';
?>
<p>&nbsp;</p>
<h2><?php $this->page->heading('pagetitle'); ?></h2>
<p>&nbsp;</p>



<div class="bs-docs-section mrg-t-md">
    <div class="row">
        <div class="col-lg-7">
            <div class="well bs-component col-xs-12">
                <form id="form" action="<?php if($this->uri->segment(1)=='reservation'){echo '/reservation';} ?>/unit" class="form-horizontal" method="post">
                    <input type="hidden" name="facilitycode" id="facilitycode" value="<?php $this->moveins->userdata('facilitycode'); ?>" />
                    <fieldset> 
                        <legend>Find a facility...</legend>
                        <?php
                        if($cls=='')
                        	{
                        ?>
                        <p>Your current facility is <strong><?php echo $this->moveins->facinfo['facilityfullname']; ?></strong>. You can search for another facility that is part of the Storman network or click 'Continue' to order and move into a unit.</p>
                        <?php
							}
						?>
                        <div class="form-group">
                        	<label for="facilityname" class="col-xs-12 col-lg-3 control-label">Storage Facility</label>
                        	<div class="col-xs-12 col-lg-9">
                        		<input type="text" class="input col-xs-12 txt-sm" id="facility" placeholder="Enter the name of the storage facility..." />
                        	</div>
                        </div>
                        <div class="form-group">
                            <div class="col-xs-12">
                            	<button type="button" id="setfacility" class="btn btn-primary pull-right">Continue</button>
                            </div>
                        </div>
                    </fieldset>
                </form>
            </div>
        </div>
    </div>
</div>