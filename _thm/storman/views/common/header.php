<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title><?php $this->page->heading('pagetitle', '', ' - ')->heading('sitename'); ?></title>
<link type="text/css" rel="stylesheet" href="/_thm/<?php echo $this->page->theme; ?>/css/style.css" />
<?php if(!empty($this->page->css)){foreach($this->page->css as $css){ ?>
<link type="text/css" rel="stylesheet" href="/_thm/<?php echo $this->page->theme; ?>/css/inc/<?php echo $css; ?>" />
<?php }} ?>
<script type="application/javascript" language="javascript" src="/_thm/<?php echo $this->page->theme; ?>/js/jquery.2.1.4.min.js"></script>
<script type="application/javascript" language="javascript" src="/_thm/<?php echo $this->page->theme; ?>/js/jquery.ui.js"></script>
<script type="application/javascript" language="javascript" src="/_thm/<?php echo $this->page->theme; ?>/js/jquery.plugins.js"></script>
<script type="application/javascript" language="javascript" src="/_thm/<?php echo $this->page->theme; ?>/js/bootstrap/bootstrap.min.js"></script>
<script type="application/javascript" language="javascript" src="/_thm/<?php echo $this->page->theme; ?>/js/jquery.nicefields.js"></script>
<script type="application/javascript" language="javascript" src="/_thm/<?php echo $this->page->theme; ?>/js/inc/validator.js"></script>
<script type="application/javascript" language="javascript" src="/_thm/<?php echo $this->page->theme; ?>/js/jquery.init.js"></script>
</head>
<body>
<header id="header" class="box-shdw-black bdr-b-s-1 bdr-3 bg-1">
	<div class="col-xs-6 col-sm-6 pad-none alg-lft">
    	<img src="/_med/images/storman_logo.png" class="pull-left" alt="Storman" />
    </div>
    <div class="col-xs-6 pad-none alg-rgt ht-80">
    	<a href="http://my.storman.com" class="hidden-xs hidden-sm pull-right pad-lr-lg bg-5 bg-4-hover lh-80 ht-80" title="Back to myStorMan"><i class="fa fa-chevron-left txt-lg lh-80 pad-lr-md"></i>Back to myStorMan</a>
        <?php
		if($this->uri->segment(1)=='admin' && $this->uri->segment(2)!='login')
			{
		?>
        <a href="/admin/logout" class="pull-right pad-lr-lg bg-7 bg-4-hover lh-80 ht-80 bdr-none" title="Admin Logout"><i class="fa fa-user txt-lg lh-80 pad-lr-md"></i>Admin Logout</a>
        <?php		
			}
		elseif($this->uri->segment(1)!='admin')
			{
			$cls = isset($this->moveins->customer) && !empty($this->moveins->customer) && isset($this->moveins->customer['customercode']) ? '' : ' hdn';
		?>
        <div class="col-auto pull-right pad-none<?php echo $cls; ?>" id="account-tools">
            <button type="button" class="col-xs-12 bg-7 bg-4-hover lh-80 ht-80 bdr-none" title="Account Logout" id="account-tgl"><i class="fa fa-user txt-lg lh-80 pad-lr-md"></i>Account Tools</button>
            <div class="col-xs-12 pad-none bg-1 box-shdw-black" id="sub-menu">
                <button type="button" class="col-xs-12 txt-4 bg-1 bg-4-hover lh-50 bdr-none alg-lft" title="Account Logout" id="logout-confirm"><i class="fa fa-sign-out txt-lg lh-50 pad-r-md"></i>Account Logout</button>
                <button type="button" class="col-xs-12 txt-4 bg-1 bg-4-hover lh-50 bdr-none alg-lft" title="Change Email" id="email-modal"><i class="fa fa-at txt-lg lh-50 pad-r-md"></i>Change Email</button>
                <button type="button" class="col-xs-12 txt-4 bg-1 bg-4-hover lh-50 bdr-none alg-lft" title="Change Password" id="password-modal"><i class="fa fa-key txt-lg lh-50 pad-r-md"></i>Change Password</button>
            </div>
        </div>
        <?php
			}
		?>
    </div>
</header>
<?php
if($this->page->full!='1')
	{
?>
<div class="container">
<?php
	}

?>