<nav class="col-sm-3 col-md-2 bg-5 pad-none" id="left-nav">
<?php

$links = array();

if(isset($this->page->user['group']))
	{
	switch($this->page->user['group'])
		{
		case 'admin' :
		$links = array(	//'dashboard' 	=> array('lbl' => 'Dashboard', 'child' => ''),
						'companies' 	=> array('lbl' => 'Head Offices', 'child' => 'company'),
						'facilities'	=> array('lbl' => 'Facilities', 'child' => 'facility'),
						'units' 		=> array('lbl' => 'Unit Types', 'child' => 'unit'),
						'profile' 		=> array('lbl' => 'My Profile', 'child' => ''),
						'errors' 		=> array('lbl' => 'Error Log', 'child' => ''),
						'log' 			=> array('lbl' => 'Storman Log', 'child' => ''),
						'logout' 		=> array('lbl' => 'Logout', 'child' => ''),
						);
		break;
		case 'company' :
		$links = array(	//'dashboard' 	=> array('lbl' => 'Dashboard', 'child' => ''),
						'profile' 		=> array('lbl' => 'Company Profile', 'child' => ''),
						'logout' 		=> array('lbl' => 'Logout', 'child' => ''),
						);
		break;
		case 'facility' :
		$links = array(	//'dashboard' 	=> array('lbl' => 'Dashboard', 'child' => ''),
						'units' 		=> array('lbl' => 'Unit Types', 'child' => 'unit'),
						'profile' 		=> array('lbl' => 'Facility Profile', 'child' => ''),
						'logout' 		=> array('lbl' => 'Logout', 'child' => ''),
						);
		break;
		}
	}

if(!empty($links))
	{
	foreach($links as $url => $inf)
		{
		$c = $this->uri->segment(2)==$url || $inf['child']!='' && $this->uri->segment(2)==$inf['child'] ? 'bg-1 txt-5' : 'txt-1';
	?>
    <a href="/admin/<?php echo $url; ?>" class="col-xs-12 lh-50 <?php echo $c; ?> bg-4-hover txt-1-hover"><?php echo $inf['lbl']; ?></a>
    <?php		
		}
	}

?>
</nav>