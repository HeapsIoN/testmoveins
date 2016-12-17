<div class="col-xs-12 col-sm-9 col-sm-offset-3 col-md-10 col-md-offset-2 pad-none form-tabs bg-2 bdr-t-s-1 bdr-3" id="form-tabs">
	<?php
	$tabs = array(	'main' 			=> 'Company Info',
					'images' 		=> 'Images and Logo',
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
	<form id="form" smp-process="company" smp-action="save">
	<?php $this->page->fields->text('', 'coid', 'index', '', '', 'hidden'); ?>
    
    <div class="col-xs-12 pad-none group" id="main">
        <h1 class="col-xs-12"><?php $this->page->heading('pagetitle'); ?></h1>
        <div class="col-xs-12 form-group<?php if(!isset($this->page->record['coid']) || $this->page->record['coid']==''){echo ' needs-id'; } ?>">
            <p>Welcome to the company manager. You can use this to create and manage companies or corporate chains that have multiple outlets under the one branch.</p>	
        </div>
        <div class="col-xs-12 form-group">
            <?php
            $this->page->fields->text('Company Name', 'companyname', 'companyname', 'Enter the company name', 'bdr-3 txt-lg txt-4');
            ?>
        </div>
        <div class="col-xs-12 form-group">
            <?php
            $this->page->fields->toggle('Active', 'companyactive', 'companyactive');
            ?>
        </div>
        <div class="col-xs-12 form-group">
            <?php
            $this->page->fields->text('Company Contact', 'companycontact', 'companycontact', 'Enter the contact name for the company', 'bdr-3 txt-lg txt-4');
            ?>
        </div>
        <div class="col-xs-12 form-group">
            <?php
            $this->page->fields->text('Company Email', 'companyemail', 'companyemail', 'Enter the contact email for the company', 'bdr-3 txt-lg txt-4');
            ?>
        </div>
        <div class="col-xs-12 form-group">
            <?php
            $this->page->fields->text('Company Phone', 'companyphone', 'companyphone', 'Enter the contact phone for the company', 'bdr-3 txt-lg txt-4');
            ?>
        </div>
        <div class="col-xs-12 form-group">
            <?php
            $this->page->fields->button('Save Company', '', 'form', 'bg-4 bg-5-hover txt-1 lh-60');
            ?>
        </div>
    </div>
	
	<?php
	$cls = !isset($this->page->record['coid']) || $this->page->record['coid']=='' ? ' needs-id' : '';
	?>
    
    <div class="col-xs-12 pad-none group group-hdn" id="images">
    
        <h2 class="col-xs-12<?php echo $cls; ?>">Company Logo</h2>
        <div class="col-xs-12 form-group<?php echo $cls; ?>">
            <p>You can upload a company logo by dragging and dropping the logo into the space below.</p>
            <p>It is recommended that use a PNG file on a transparent background.</p>
            <p>The recommended size of the logo is 250px wide by 80px tall.</p>	
        </div>
        <div class="col-xs-12 col-sm-9 col-md-10 col-sm-offset-3 col-md-offset-2 form-group company-logo<?php echo $cls; ?>" id="logo-row">
            <?php
			if(isset($this->page->record['companylogo']) && $this->page->record['companylogo']!='')
				{
			?>
            <img src="/_med/companies/<?php echo $this->page->record['companylogo']; ?>" alt="Company Logo" class="pull-left" />
            <?php
				}
			?>
        </div>
        <div class="col-xs-12 col-sm-9 col-md-10 col-sm-offset-3 col-md-offset-2 pad-none form-group<?php if(!isset($this->page->record['coid']) || $this->page->record['coid']==''){echo ' needs-id'; } ?>" id="logouploader">
            <div class="col-xs-12 col-sm-6 col-md-4 pad-none pad-lr-md">
            <?php
            $this->page->fields->filedrop('companylogo', 'companylogo');
            ?>
            </div>
        </div>
        
        
        <h2 class="col-xs-12<?php echo $cls; ?>">Email Header</h2>
        <div class="col-xs-12 form-group<?php echo $cls; ?>">
            <p>You can upload your own email header image.</p>
            <p>This is used in the email template when sending an email to customers with a copy of the agreement or the confirmation of payment if they are using on site payments via EziDebit.</p>
            <p>The image must be 800px wide by 150px tall.</p>
        </div>
        <div class="col-xs-12 col-sm-9 col-md-10 col-sm-offset-3 col-md-offset-2 form-group company-logo<?php echo $cls; ?>" id="eheader-row">
            <?php
			if(isset($this->page->record['companyemailheader']) && $this->page->record['companyemailheader']!='')
				{
			?>
            <img src="/_med/companies/header/<?php echo $this->page->record['companyemailheader']; ?>" alt="Company Email Header" class="pull-left" />
            <?php
				}
			?>
        </div>
        <div class="col-xs-12 col-sm-9 col-md-10 col-sm-offset-3 col-md-offset-2 pad-none form-group<?php echo $cls; ?>">
            <div class="col-xs-12 col-sm-6 col-md-4 pad-none form-group pad-lr-md">
            <?php
            $this->page->fields->filedrop('companyheader', 'companyheader');
            ?>
            </div>
        </div>
        
        
        <h2 class="col-xs-12<?php echo $cls; ?>">Email Footer</h2>
        <div class="col-xs-12 form-group<?php echo $cls; ?>">
            <p>You can upload your own email header image.</p>
            <p>This is used in the email template when sending an email to customers with a copy of the agreement or the confirmation of payment if they are using on site payments via EziDebit.</p>
            <p>The image must be 210px wide by 60px tall.</p>	
        </div>
        <?php
        $ftr = isset($this->page->record['companyemailfooter']) && $this->page->record['companyemailfooter']!='' ? $this->page->record['companyemailfooter'] : 'storman-email-footer.jpg';
        ?>
        <div class="col-xs-12 col-sm-9 col-md-10 col-sm-offset-3 col-md-offset-2 form-group company-logo<?php echo $cls; ?>" id="efooter-row">
            <?php
			if(isset($this->page->record['companyemailfooter']) && $this->page->record['companyemailfooter']!='')
				{
			?>
            <img src="/_med/companies/footer/<?php echo $this->page->record['companyemailfooter']; ?>" alt="Company Email Header" class="pull-left" />
            <?php
				}
			?>
        </div>
        <div class="col-xs-12 col-sm-9 col-md-10 col-sm-offset-3 col-md-offset-2 pad-none form-group<?php echo $cls; ?>">
            <div class="col-xs-12 col-sm-6 col-md-4 pad-none form-group pad-lr-md">
            <?php
            $this->page->fields->filedrop('companyfooter', 'companyfooter');
            ?>
            </div>
        </div>
        <div class="col-xs-12 form-group">
            <?php
            $this->page->fields->button('Save Company', '', 'form', 'bg-4 bg-5-hover txt-1 lh-60');
            ?>
        </div>
    </div>
    </form>
</div>