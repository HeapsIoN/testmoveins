<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Account Created with <?php echo $this->moveins->facinfo['facilityname']; ?></title>
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
            	<img src="https://signup.storman.com/_med/<?php echo $this->moveins->emailhead; ?>" alt="Logo" width="800" height="150" />
            </td>
		</td>
        <tr>
        	<td colspan="2" class="head">
            	Account Created with <?php echo $this->moveins->facinfo['facilityname']; ?>
            </td>
        </tr>    
    </thead>
    <tbody cellpadding="5" cellspacing="0">
    	<tr>
			<td colspan="2" class="body">
            	<p>&nbsp;</p>
            	<p>Dear <?php echo $this->page->postdata['customerfirstname'].' '.$this->page->postdata['customersurname']; ?>,</p>
                <p>An account has been created for you at <?php echo $this->moveins->facinfo['facilityfullname']; ?>. You can log into the system using the email address and the password you entered during the registration process.</p>
                <p>Your customer code is: <?php echo $this->page->postdata['customercode']; ?>.</p>
                <p>If you forget your password, you can always return to the Move-ins System and request a new password. You will need your email and customer code to reset your password. Thank you for choosing <?php echo $this->moveins->facinfo['facilityfullname']; ?> for your self storage needs.</p>
                <p>Regards,</p>
              	<p><?php echo $this->moveins->facinfo['facilityfullname']; ?></p>
                <p><img src="https://signup.storman.com/_med/<?php echo $this->moveins->emailfoot; ?>" class="foot-logo" alt="Logo" width="210" height="60" /></p>
          <p>&nbsp;</p></td>
        </tr>
    </tbody>
	<tfoot>
    	<tr>
        	<td colspan="2" class="foot">
            	This is a system generated email that was sent via the <?php echo $this->page->site['sitename']; ?> website. This was sent to <a href="mailto:<?php echo $this->page->postdata['customeremail']; ?>" class="foot"><?php echo $this->page->postdata['customeremail']; ?></a> as this was the email address that was on file for the customer. A copy was also sent to the facility. If you have received this in error, please immediately delete any and all copies of this email, in part or in whole.
            </td>
        </tr>
    </tfoot>
</table>
</body>
</html>