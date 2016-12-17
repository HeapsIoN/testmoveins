
<?php

if(isset($_GET['profile']))
	{	
	$this->output->enable_profiler(TRUE);
	}


if($this->page->full!='1')
	{
?>
</div>
<?php
	}

if($this->session->flashdata('error') || isset($this->page->response['error']))
	{
	$msg = $this->session->flashdata('error') ? $this->session->flashdata('error') : $this->page->response['error'];
?>
<div class="alert alert-error"><?php echo $msg; ?></div>
<?php	
	}

if($this->session->flashdata('success'))
	{
?>
<div class="alert alert-success"><?php echo $this->session->flashdata('success'); ?></div>
<?php	
	}
?>
<script type="application/javascript" language="javascript" src="/_thm/<?php echo $this->page->theme; ?>/js/bootstrap/bootstrap.ie10.js"></script>
<?php if(!empty($this->page->js)){foreach($this->page->js as $js){ ?>
<script type="application/javascript" language="javascript" src="/_thm/<?php echo $this->page->theme; ?>/js/inc/<?php echo $js; ?>"></script>
<?php }} ?>
<div id="loading"><div id="loadingprogress"></div></div>
    <div class="container" id="foot-container"> 
        <footer>
            <ul class="nav navbar-nav navbar-right footerlogo">
            	<li><a href="http://www.storman.com/?src=olm" target="_blank"><img src="/_med/images/logo_storman-small.png"/></a></li>
            </ul>
        	<p class="light txt-md"> Thank you for using the Online Move-in System. | Powered by Storman <a href="http://www.storman.com/?src=olm" target="_blank">Self Storage Software</a></p>
        </footer>
    </div>
</body>
</html>