<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title><?php $this->page->heading('pagetitle', '', ' - ')->heading('sitename'); ?></title>
<link type="text/css" rel="stylesheet" href="/_thm/<?php echo $this->page->theme; ?>/css/style.css" />
<?php if(!empty($this->page->css)){foreach($this->page->css as $css){ ?>
<link type="text/css" rel="stylesheet" href="/_thm/<?php echo $this->page->theme; ?>/css/inc/<?php echo $css; ?>" />
<?php }} ?>
<meta name="viewport" content="width=device-width; initial-scale=1.0; maximum-scale=1.0; user-scalable=no;"/>
<script type="application/javascript" language="javascript" src="/_thm/<?php echo $this->page->theme; ?>/js/jquery.2.1.4.min.js"></script>
<script type="application/javascript" language="javascript" src="/_thm/<?php echo $this->page->theme; ?>/js/jquery.ui.js"></script>
<script type="application/javascript" language="javascript" src="/_thm/<?php echo $this->page->theme; ?>/js/jquery.plugins.js"></script>
<script type="application/javascript" language="javascript" src="/_thm/<?php echo $this->page->theme; ?>/js/bootstrap/bootstrap.min.js"></script>
<script type="application/javascript" language="javascript" src="/_thm/<?php echo $this->page->theme; ?>/js/jquery.nicefields.js"></script>
<script type="application/javascript" language="javascript" src="/_thm/<?php echo $this->page->theme; ?>/js/inc/validator.js"></script>
<script type="application/javascript" language="javascript" src="/_thm/<?php echo $this->page->theme; ?>/js/jquery.init.js"></script>
</head>
<body>

<header id="header" class="navbar navbar-default navbar-fixed-top">
  <div class="container pad-none">
    <div class="col-xs-12 col-md-4 pad-none">
    	<span class="navbar-brand txt-lg"><?php if(isset($this->moveins->facinfo['facilityname'])){echo $this->moveins->facinfo['facilityname'];}else{echo 'StorMan Online Tools';} ?></span>
        <button type="button" class="btn inl-btn bg-clear lh-60 mrg-t-sm pull-right hidden-md hidden-lg txt-white txt-black-hover" id="account-tglr"><i class="ion-navicon-round txt-xl"></i></button>    
    </div>
    <div class="navbar-collapse pull-right" id="navbar-main">
      
        <a href="http://www.storman.com/" target="_blank" class="hidden-xs hidden-sm pull-left pad-lr-lg lh-60 txt-white txt-black-hover">Storman Online Move-in</a>
        
        <?php
		if($this->uri->segment(1)=='admin' && $this->uri->segment(2)!='login')
			{
		?>
        <a href="/admin/logout" class="pull-left pad-lr-lg bg-7 bg-4-hover bdr-none lh-60" title="Admin Logout"><i class="fa fa-user txt-lg pad-lr-md"></i>Admin Logout</a>
        <?php		
			}
		elseif($this->uri->segment(1)!='admin')
			{
			$cls = isset($this->moveins->customer) && !empty($this->moveins->customer) && isset($this->moveins->customer['customercode']) && $this->moveins->customer['customercode']!='' ? '' : ' hdn';
		?>
        <div class="col-auto pull-left pad-none<?php echo $cls; ?>" id="account-tools">
            <button type="button" class="hidden-xs hidden-sm col-md-12 bg-7 bg-4-hover bdr-none lh-60 " title="Account Logout" id="account-tgl"><i class="fa fa-user txt-lg pad-lr-md"></i>Account Tools</button>
            <div class="col-xs-12 pad-none bg-1 box-shdw-black" id="sub-menu">
                <button type="button" class="col-xs-12 txt-4 bg-1 bg-4-hover lh-50 bdr-none alg-lft txt-sm" title="Account Logout" id="logout-confirm"><i class="fa fa-sign-out txt-lg lh-50 pad-r-md"></i>Account Logout</button>
                <button type="button" class="col-xs-12 txt-4 bg-1 bg-4-hover lh-50 bdr-none alg-lft txt-sm" title="Change Email" id="email-modal"><i class="fa fa-at txt-lg lh-50 pad-r-md"></i>Change Email</button>
                <button type="button" class="col-xs-12 txt-4 bg-1 bg-4-hover lh-50 bdr-none alg-lft txt-sm" title="Change Password" id="password-modal"><i class="fa fa-key txt-lg lh-50 pad-r-md"></i>Change Password</button>
            </div>
        </div>
        <?php
			}
		?>
        
    </div>
  </div>
</header>

<!--            --> 
<!-- END HEADER --> 
<!--            -->

<?php
if($this->page->full!='1')
	{
?>
<div class="container">
<?php
	}

?>