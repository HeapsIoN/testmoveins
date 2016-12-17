<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Facility Profile Setup - <?php echo $this->page->site['sitename']; ?></title>
</head>
<body style="margin-top:0;margin-left:0;margin-right:0;margin-bottom:0;padding-top:0;padding-left:0;padding-right:0;padding-bottom:0;text-align:center">
<style>
body
	{
	font-family:'Century Gothic', Tahoma, Geneva, sans-serif;
	font-size:14px;
	background-color:#e3e3e3;
	}

#email
	{
	background-color:#fff;
	width:800px;
	table-layout:fixed;
	}

.head
	{
	background-color:#fff;
	color:#04242C;
	text-align:center;
	font-size:22px;	
	}



.body
	{
	padding-left:15px;
	padding-right:15px;
	padding-top:15px;
	padding-bottom:15px;
	text-align:left;	
	}

.lbl
	{
	width:25%;
	font-weight:bold;
	font-size:12px;
	text-transform:uppercase;
	color:#22357a;
	text-align:right;
	vertical-align:text-top;
	padding:5px;
	}

.inf
	{
	width:75%;
	border-bottom-color:#ccc;
	border-bottom-width:1px;
	border-bottom-style:dashed;
	text-align:left;
	padding:5px;
	}

.link
	{
	color:#1C91B6;
	text-decoration:none;	
	}

.foot
	{
	font-size:10px;
	padding:15px;
	color:#666;	
	}


.space
	{
	height:10px;	
	}

</style>
<table id="email" cellpadding="0" cellspacing="0" width="800px" border="none">
	<thead>
    	<tr>
        	<td colspan="2">
            	<img src="cid:<?php echo $this->facilities->headlogo; ?>" alt="StorMan" width="800" height="150" />
            </td>
		</td>
        <tr>
        	<td colspan="2" class="head">
            	Facility Profile Setup - <?php echo $this->page->site['sitename']; ?>
            </td>
        </tr>    
    </thead>
    <tbody cellpadding="5" cellspacing="0">
    	<tr>
			<td colspan="2" class="body">
            	<p>&nbsp;</p>
            	<p>A profile has been set up for your facility at <?php echo $this->page->site['sitename']; ?>. The details of your account are as follows:</p>
            	<p>&nbsp;</p>
            </td>
        </tr>
        <tr>
            <td class="lbl" style="width:25%;table-layout:fixed">URL</td>
            <td class="inf" style="width:75%;table-layout:fixed"><a href="http://<?php echo $this->page->site['sitename']; ?>/admin" class="link"><?php echo $this->page->site['sitename']; ?>/admin</a></td>
        </tr>
        <tr>
            <td class="lbl" style="width:25%;table-layout:fixed">User</td>
            <td class="inf" style="width:75%;table-layout:fixed"><?php echo $this->page->postdata['facilityemail']; ?></td>
        </tr>
        <tr>
            <td class="lbl" style="width:25%;table-layout:fixed">Password</td>
            <td class="inf" style="width:75%;table-layout:fixed"><?php echo $this->secure->pasr; ?></td>
        </tr>
        <tr>
			<td colspan="2" class="body">
            	<p>&nbsp;</p>
            	<p>After you have logged in you can use the 'My Profile' section to update your password if required.</p>
                <p>Regards,</p>
              	<p><?php echo $this->page->site['sitename']; ?></p>
                <p><img src="cid:<?php echo $this->facilities->footlogo; ?>" class="foot-logo" alt="StorMan" width="210" height="60" /></p>
             <p style="color: #cc0000;"><strong>Thank you for testing Storman Move-ins</strong> by using our Demo Storage Company website. Did you know that you can customise the look &amp; feel of this email? Find our more about  <a href="http://storman.com/add-ons/move-in/?src=dscemailtemplate" target="_blank">Storman Move-ins</a>.</p>
          <p>&nbsp;</p> </td>
        </tr>
    </tbody>
	<tfoot>
    	<tr>
        	<td colspan="2" class="foot">
            	This is a system generated email that was sent via the <?php echo $this->page->site['sitename']; ?> website. This was sent to <a href="mailto:<?php echo $this->page->postdata['facilityemail']; ?>" class="foot"><?php echo $this->page->postdata['facilityemail']; ?></a> as this was the email address that was on file for the facility. If you have received this in error, please immediately delete any and all copies of this email, in part or in whole.
            </td>
        </tr>
    </tfoot>
</table>
</body>
</html>