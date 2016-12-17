<h1><?php $this->page->heading('pagetitle'); ?></h1>
<form id="form">
<input type="hidden" id="short-logout" value="1" />
<div class="col-xs-12 pad-none">
    <div class="col-xs-12 pad-none mrg-b-md">
        <?php
        if(isset($this->moveins->facinfo['facilitycompletedmessage']) && $this->moveins->facinfo['facilitycompletedmessage']!='')
            {
            echo $this->moveins->facinfo['facilitycompletedmessage'];	
            }
        else
            {
        ?>
        <p><?php echo $this->moveins->message; ?></p>
        <?php
            }
        ?>
    </div>
</div>
</form>
