<html>
<head>
<style>

body
	{
	line-height:12px;
	font-size:8px;
	font-family:Calibri, Arial, Helvetica, sans-serif;
	margin:-10px 0;
	}

div, h1, h2
	{
	padding:0;
	margin:0;
	display:block;	
	}

h1, h2
	{
	text-transform:uppercase;
	background-color:#f3f3f3;
	color:#5d5d5d;
	margin:10px 0;
	}

h1
	{
	font-size:10px;
	line-height:16px;
	}

h2
	{
	font-size:9px;
	line-height:13px;
	}

.group
	{
	position:relative;
	float:left;
	display:inline-block;
	width:50%;
	line-height:12px;
	padding:0;
	margin:0;	
	}

.row
	{
	position:relative;
	float:left;
	width:100%;
	line-height:12px;
	max-width:550px;
	padding:0;
	margin:0;
	}

.group .row
	{
	max-width:250px;	
	}


.row div, .group .row div, .row b
	{
	position:relative;
	display:inline-block;
	padding:0;
	margin:0;
	line-height:12px
	}

.pad-t-md, .row div.pad-t-md
	{
	padding-top:10px;	
	}

.group .row div ul.key-points
	{
	font-size:8px;
	line-height:10px;	
	}
	
	
.row div.lbl
	{
	text-align:right;
	font-size:8px;
	text-transform:uppercase;
	padding:0 5px 0 0;
	margin:0;
	line-height:12px;
	color:#ccc;
	}

.row div.info
	{
	text-align:left;
	font-size:9px;
	font-weight:normal;
	padding:0;
	margin:0;
	line-height:12px;
	}

.sign-box
	{
	border-bottom:#999 solid 1px;	
	}

.pagebreak
	{
	page-break-before:always;	
	}

.key-points
	{
	margin:0;
	padding:0 0 0 10px;	
	}

.txt-ty, .row div.txt-ty, .group .row div.txt-ty	{font-size:5px;line-height:7px}
.txt-xs, .row div.txt-xs, .group .row div.txt-xs	{font-size:6px;line-height:9px}
.txt-xs, .row div.txt-sm, .group .row div.txt-sm	{font-size:7px;line-height:10px}
.txt-xs, .row div.txt-md, .group .row div.txt-md	{font-size:8px;line-height:11px}

.alg-ctr, .row div.lbl.alg-ctr	{text-align:center}
.alg-lft, .row div.lbl.alg-lft	{text-align:left}
.alg-rgt, .row div.lbl.alg-rgt	{text-align:right}

.lh-12, .row div.lh-12		{line-height:12px}
.lh-20, .row div.lh-20		{line-height:20px}
.lh-30, .row div.lh-30		{line-height:30px}

.wid-10		{width: 50px}
.wid-20		{width: 100px}
.wid-30		{width: 150px}
.wid-40		{width: 200px}
.wid-50		{width: 250px}
.wid-60		{width: 300px}
.wid-70		{width: 350px}
.wid-80		{width: 400px}
.wid-90		{width: 450px}
.wid-100	{width: 500px}

.logo
	{
	width:100px;
	margin:10px;	
	}

.ssaa-logo
	{
	width:75px;
	margin:5px;	
	}

.key-group
	{
	margin-left:40px;	
	}

.txt-red	{color:#bc2114}
.txt-grey	{color:#5d5d5d}

.strikeout {text-decoration:line-through}

</style>
</head>
<body>
<div class="row">
    <div class="wid-20 lh-20">
        <img src="./_med/<?php echo $this->moveins->facinfo['logo']; ?>" alt="Logo" class="logo" />
    </div>
    <div class="wid-10">&nbsp;</div>
    <div class="wid-40 lh-12 pad-t-md txt-md">
        <?php
        echo $this->moveins->facinfo['facilityaddress'].', '.$this->moveins->facinfo['facilitysuburb'].' '.$this->moveins->facinfo['facilitystate'].' '.$this->moveins->facinfo['facilitypostcode'].'<br/>
        P: '.$this->moveins->facinfo['facilityphone'].'<br/>
        E: '.$this->moveins->facinfo['facilityemail'];
        ?><br/>
    </div>
    <div class="wid-10">&nbsp;</div>
    <div class="wid-20 lh-20 alg-rgt">
        <b class="agreement"><?php echo $this->moveins->user['order']['agreement']; ?></b><br/>
        <img src="./_med/images/ssaa-logo.jpg" alt="SSAA" class="ssaa-logo" />
    </div>
</div>
<h1 class="alg-ctr">Self Storage Agreement</h1>
<div class="row">
    <div class="lbl wid-20">Company Name</div>
    <div class="info wid-80"><?php echo $this->moveins->facinfo['facilityfullname']; ?></div>
</div>
<div class="row">
    <div class="lbl wid-20">Storer's Name</div>
	<div class="info wid-80"><?php echo $this->moveins->customer['customertitle'].' '.$this->moveins->customer['customerfirstname'].' '.$this->moveins->customer['customersurname']; ?></div>
</div>
<div class="row">
    <div class="lbl wid-20">Address</div>
	<div class="info wid-80"><?php echo $this->moveins->customer['customeraddress'].', '.$this->moveins->customer['customersuburb'].' '.$this->moveins->customer['customerstate'].' '.$this->moveins->customer['customerpostcode']; ?></div>
</div>
<div class="row">
    <div class="lbl wid-20">Mail Address</div>
	<div class="info wid-80"><?php echo $this->moveins->customer['customermailaddress'].', '.$this->moveins->customer['customermailsuburb'].' '.$this->moveins->customer['customermailstate'].' '.$this->moveins->customer['customermailpostcode']; ?></div>
</div>
<h2 class="alg-ctr">Contact Information</h2>
<div class="row">
    <div class="lbl wid-20">Home</div>
	<div class="info wid-20"><?php echo $this->moveins->customer['customerhomephone']; ?></div>
    <div class="lbl wid-10">Work</div>
    <div class="info wid-20"><?php echo $this->moveins->customer['customerworkphone']; ?></div>
    <div class="lbl wid-10">Mobile</div>
    <div class="info wid-20"><?php echo $this->moveins->customer['customermobilephone']; ?></div>
</div>
<div class="row">
    <div class="lbl wid-20">Email</div>
    <div class="info wid-80"><?php echo $this->moveins->customer['customeremail']; ?></div>
</div>
<h2 class="alg-ctr">Alternate Contact Person</h2>
<div class="row">
    <div class="lbl wid-20">Name</div>
    <div class="info wid-80"><?php echo $this->moveins->customer['customeralttitle'].' '.$this->moveins->customer['customeraltfirstname'].' '.$this->moveins->customer['customeraltlastname']; ?></div>
</div>
<div class="row">
    <div class="lbl wid-20">Address</div>
    <div class="info wid-80"><?php echo $this->moveins->customer['customeraltaddress'].', '.$this->moveins->customer['customeraltsuburb'].' '.$this->moveins->customer['customeraltstate'].' '.$this->moveins->customer['customeraltpostcode']; ?></div>
</div>
<div class="row">
    <div class="lbl wid-20">Home</div>
    <div class="info wid-30">&nbsp;</div>
    
    <div class="lbl wid-10">Mobile</div>
    <div class="info wid-40"><?php echo $this->moveins->customer['customeraltmobile']; ?></div>
</div>
<div class="row">
    <div class="lbl wid-20">Email</div>
	<div class="info wid-80"><?php echo $this->moveins->customer['customeraltemail']; ?></div>
</div>
<div class="row">
    <div class="wid-100 txt-grey alg-ctr">
        Please advise us immediately if your address or contact details or those of your alternate person change
    </div>
</div>

<h2 class="alg-ctr">Storage Details</h2>
<div class="row">
    <div class="lbl wid-20">Space #</div>
	<div class="info wid-10"><?php echo $this->moveins->order['unitnums']; ?></div>
    <div class="lbl wid-20">Storage From</div>
    <div class="info wid-10"><?php echo $this->moveins->order['unitfrom']; ?></div>
    <div class="lbl wid-20">Storage To</div>
    <div class="info wid-10"><?php echo $this->moveins->order['unitto'];  ?></div>
</div>
<div class="row">
    <div class="lbl wid-20">Extended</div>
	<div class="info wid-80">Automatically until <?php echo $this->moveins->facinfo['facilitymoveoutnotice']; ?> days notice is given by either party.</div>
</div>
<div class="row">
    <div class="lbl wid-20">Storage Fee</div>
    <div class="info wid-20">$<?php echo number_format($this->moveins->order['unitrate'],2,'.',','); ?> per month</div>
    <?php
    if(isset($this->moveins->facinfo['fees']['deposit']))
		{
    ?>
    <div class="lbl wid-20">Deposit</div>
    <div class="info wid-30">$<?php echo $this->moveins->facinfo['fees']['deposit']; ?></div>    
    <?php
		}
	?>
</div>
<?php
if(isset($this->moveins->facinfo['fees']['cleaning']) || isset($this->moveins->facinfo['fees']['admin']))
	{
?>
<div class="row">
    <?php
    if(isset($this->moveins->facinfo['fees']['cleaning']))
		{
    ?>
    <div class="lbl wid-20">Cleaning Fee</div>
    <div class="info wid-20">$<?php echo $this->moveins->facinfo['fees']['cleaning']; ?></div>
    <?php
		}
		
    if(isset($this->moveins->facinfo['fees']['admin']))
		{
    ?>
    <div class="lbl wid-20">Admin Fee</div>
    <div class="info wid-40">$<?php echo $this->moveins->facinfo['fees']['admin']; ?></div>
    <?php
		}
	?>
</div>
<?php
	}

if(isset($this->moveins->facinfo['fees']['late']) && isset($this->moveins->facinfo['fees']['dayslate']))
	{
?>
<div class="row">
    <div class="lbl wid-20">Late Payment Fee</div>
    <div class="info wid-20">$<?php echo $this->moveins->facinfo['fees']['late']; ?></div>
    <div class="lbl wid-20">Late Fee Applied</div>
    <div class="info wid-40"><?php echo $this->moveins->facinfo['fees']['dayslate']; ?> days after due date</div>
</div>
<?php
	}
	
if(isset($this->moveins->facinfo['fees']['cheque']))
	{
?>
<div class="row">
    <div class="info wid-100 alg-ctr txt-sm">Fee for any cheque returned unpaid $<?php echo $this->moveins->facinfo['fees']['cheque']; ?> plus Bank Fee</div>
</div>
<?php
	}
?>
<div class="row">
    <div class="wid-100 txt-xs">All fees include GST, except for the deposit and late fee.</div>
</div>

<div class="group wid-50">
    <h2 class="alg-ctr">Marketing</h2>
    <div class="row">
        <div class="lbl wid-20 txt-sm">Marketing Source</div> 
        <div class="info wid-30 txt-sm">Website / Online Signup</div>
    </div>
    <div class="row">
        <div class="info wid-50 txt-sm">
        <?php
        if(isset($this->page->postdata['sendmarketing']))
            {
            echo 'I DO NOT want to receive marketing materials and notifications.';	
            }
        else
            {
            echo 'I do want to receive marketing materials and notifications.';
            }
        ?>
        </div>
    </div>
    <div class="row">
        <div class="info wid-50 txt-sm">
        <?php
        if(isset($this->page->postdata['marketingafter']))
            {
            echo 'I DO NOT want to be contacted by this business for promotion or feedback after this contract expires.';	
            }
        else
            {
            echo 'I do want to be contacted by this business for promotion or feedback after this contract expires.';
            }
        ?>
        </div>
    </div>

    <h2 class="alg-ctr">Acceptance of Terms and Signature</h2>
    <div class="row">
        <div class="wid-50 alg-lft txt-sm">PLEASE READ CONDITIONS OVERLEAF CAREFULLY AS BY SIGNING THIS AGREEMENT YOU WILL BE BOUND BY THEM</div>
    </div>
    <div class="row">
        <div class="wid-50 alg-lft txt-sm">I agree to be bound by the conditions of this agreement as shown overleaf.</div>
    </div>
    <div class="row">
        <div class="lbl wid-50 alg-ctr">Storer's Signature</div>
	</div>
    <div class="row">
        <div class="sign-box wid-50">
            <img src="<?php echo $this->moveins->customer['signature']; ?>" class="signature" alt="" width="200" height="75" />
        </div>
    </div>
    <div class="row">
         <div class="info wid-50">Signed by <?php echo $this->moveins->customer['customertitle'].' '.$this->moveins->customer['customerfirstname'].' '.$this->moveins->customer['customersurname']; ?></div>
    </div>
    <?php
	if(isset($this->moveins->customer['dual']) && $this->moveins->customer['dual']=='1')
		{
	?>
    <div class="row">
        <div class="sign-box wid-50">
            <img src="<?php echo $this->moveins->customer['signsec']; ?>" class="signature" alt="" width="200" height="75" />
        </div>
    </div>
    <div class="row">
         <div class="info wid-50">Signed by <?php echo $this->moveins->customer['customeralttitle'].' '.$this->moveins->customer['customeraltfirstname'].' '.$this->moveins->customer['customeraltlastname']; ?></div>
    </div>
    <?php
		}
	?>
    <div class="row">
         <div class="info wid-50">Date of this Agreement <?php echo date('jS').' day of '.date('F').' '.date('Y'); ?></div>
    </div>
    <h2 class="alg-ctr">Storer Check Consent</h2>
    <div class="row">
        <?php $scl = !isset($this->page->postdata['storercheck']) ? ' strikeout' : ''; ?>
        <div class="info txt-xs wid-50<?php echo $scl; ?>">
        	I consent to the undertaking of a search of my details against the Storer Check Pty Ltd database, and to my details and personal information being released to Storer Check Pty Ltd pursuant to the Personal Information Document and the terms and conditions set out at www.storercheck.com.
		</div>
    </div>
</div>

<div class="group key-group wid-50">
    <div class="row">
        <h2 class="alg-ctr">Summary of Important Points</h2>
        <ul class="key-points txt-ty">
            <li>All payments are to be made in advance by you (the Storer).</li>
            <li>Goods are stored at your own risk. We recommend that you take out insurance cover.</li>
            <li>The Facility Owner (the "FO") is excluded from liability for the loss of any goods stored on its premises, except for laws which cannot be excluded, including rights under the Australian Consumer Law.</li>
            <li>You must not store hazards dangerous, illegal, stolen, perishable, environmentally harmful or explosive goods.</li>
            <li>Unless specifically itemised and covered by insurance you must also not store goods that are irreplaceable such as currency, jewellery, furs, deeds, paintings, curios, works of art and items of personal sentimental value or items worth more than $2000 AUD in total. While the FO takes reasonable care to provide a secure Space, we cannot guard against all risks and unforeseen circumstances beyond our control and therefore, we recommend that you take out insurance in relation to items you intend to store in the Space or store valuable goods in places specifically designed for this purpose (i.e. a safety deposit box).</li>
            <li>The Space will only be accessible during set access hours as posted by the FO.</li>
            <li><?php echo $this->moveins->facinfo['facilitymoveoutnotice']; ?> days notice must be given for termination of this agreement.</li>
            <li>The Storer must notify the FO of all changes to their or the ACP's address, e-mail, telephone numbers or other contact details</li>
            <li>If you fail to comply with material terms in this agreement the FO will have certain rights which include forfeiture of your Deposit and the right to seize and sell and/or dispose of your goods (see clause 6).</li>
            <li>The FO may have the right to refuse access if all fees are not paid promptly (see clause 11).</li>
            <li>The FO has the right to enter the Space in certain circumstances (see clauses 6, 13, 14, 19, 20, 21 &amp; 23).</li>
            <li>The FO may use a microprobe or CCTV to view inside the Space and rely on footage to enforce the contract, and/or may release footage to authorities (see clause 21A) in certain circumstances, including where the FO reasonably suspects breach of the law or damage to premises.</li>
            <li>The FO may discuss your account, any default and your details with the ACP. Upon termination or default, the FO may elect to release items to the ACP (see clause 10(i))</li>
        </ul>
    </div>
    <?php
	if(isset($this->page->postdata['insurancerate']))
		{
	?>
    <h2 class="alg-ctr">Insurance</h2>
    <div class="row">
        <div class="wid-50 alg-lft txt-sm"></div>
    </div>
    <?php
		}
	?>
</div>
<div class="pagebreak"></div>
<div class="txt-ty">
    <h2 class="alg-ctr">Full Terms and Conditions</h2>
    <b class="lbl wid-30">STORAGE:</b><br/>
    1. The Storer:<br/>
    (a) may store Goods in the Space allocated to the Storer by the Facility Owner ("FO"), and only in that Space:<br/>
    (b) has knowledge of the Goods in the Space;<br/>
    (c) warrants that they are the owner of the Goods in the Space, and/or are entitled at law to deal with them in accordance with all aspects of this Agreement.<br/>
    2. The FO:<br/>
    (a) does not have and will not be deemed to have, knowledge of the Goods;<br/>
    (b) is not a bailee nor a warehouseman of the Goods and the Storer acknowledges that the FO does not take possession of the Goods;<br/>
    (c) claims a contractual lien over the Goods in the event any moneys are owing under the Agreement.<br/>
    <b class="lbl wid-30">COST:</b><br/>
    3. The Storer must upon signing the Agreement pay to the FO:<br/>
    (a) the Deposit (which, when applicable, will be refunded within 30 days of termination of this Agreement) and/or<br/>
    (b) the Administration Fee.<br/>
    4. The Storer is responsible to pay:<br/>
    (a) the Storage Fee being the amount indicated in this Agreement or the amount notified to the Storer by the FO from time to time. The Storage Fee is payable in advance and it is the Storer's responsibility to make payment directly to the FO on time, and in full, throughout the period of storage. Any Storage Fees paid by direct deposit/direct credit ("Direct Payment") will not be credited to Storer's account unless the Storer identifies the
    Direct Payment clearly and as reasonably directed by the FO. The FO is indemnified from any claim for enforcement of the Agreement, including the sale or disposal of Goods, due to the Storer's failure to correctly identify a Direct Payment;<br/>
    (b) the Cleaning Fee, as indicated on the front on this Agreement, is payable at the FO's reasonable discretion;<br/>
    (c) a Late Payment Fee, as indicated on the front on this Agreement, which becomes payable each time a payment is late;<br/>
    (d) any reasonable costs incurred by the FO in collecting late or unpaid Storage Fees, or in enforcing this Agreement in any way, including but not limited to postal, telephone, debt collection, personnel and/ or the Default Action costs.<br/>
    5. The Storer will be responsible for payment of any government taxes or charges (including any goods and services tax) being levied on this Agreement, or any supplies pursuant to this Agreement.<br/>
    <b class="lbl wid-30">DEFAULT:</b><br/>
    6. (a) Notwithstanding clause 23,and subject to clause 6 (b), the Storer acknowledges that, in the event of the Storage Fee, or any other moneys owing under this Agreement, not being paid in full within 42 days of the due date, the FO may enter the Space, by force or otherwise, retain the Deposit and/or sell or dispose of any Goods in the Space on such terms that the FO may determine ("Default Action"). For the purposes of the Personal Property Securities Act 2009, the FO is deemed to be in possession of the Goods from the moment the FO accesses the Space. The Storer consents to and authorises the sale or disposal of all Goods regardless of their nature or value. The FO may also require payment of Default Action costs, including any costs associated with accessing the Storer's Space and disposal or sale of the Storer's Goods. Any excess funds will be returned to the Storer within 6 months of the sale of goods. In the event that the Storer cannot be located, excess funds will be deposited with the Public Trustee or equivalent authority. In the event that the Storer has more than one Space with the FO, default on either Space authorises the FO to take Default Action against all Spaces.<br/>
    (b) At least 14 days before the FO can take any Default Action the FO will provide the Storer with Notice that the Storer is in Default. The FO will provide the Storer with reasonable time to rectify the Default before any Default Action is taken.<br/>
    (c) If the FO reasonably believes it is a health and safety risk to conduct an inventory of Goods in the Space, subject to the FO providing the Storer with reasonable prior notice to pay outstanding moneys and collect the goods, the FO may dispose of some or all of the Goods without undertaking an inventory. Further, due to the inherent health and safety risks in relation to undertaking any sale or disposal of Goods whereby the FO must handle the Storer's Goods, the FO need not open or empty bags or boxes to undertake an inventory or assess the contents therein, and may elect to instead dispose of all bagged and/or boxed items without opening them.<br/>
    <b class="lbl wid-30">RIGHT TO DUMP:</b><br/>
    7. If, in the reasonable opinion of the FO, a defaulting Storer's Goods are either not saleable, fail to sell when offered for sale, may pose a health risk to staff or the public if handled, or are not of sufficient value to warrant the expense of attempting to sell, the FO may dispose of all Goods in the Storer's Space by any means.<br/>
    8. Further, upon Termination of the Agreement (Clause 23) by either the Storer or the FO, in the event that a Storer fails to remove all Goods from their Space or the Facility the FO is authorised to dispose of all Goods by any means 7 days from the Termination Date, regardless of the nature or value of the Goods. The FO will give 7 days' notice of intended disposal.<br/>
    9. Any items deemed left, in the FO's reasonable opinion, unattended in common areas or outside the Storer's Space at any time may at the FO's reasonable discretion be sold, disposed, moved or dumped immediately and at the expense and liability of the Storer.<br/>
    <b class="lbl wid-30">ACCESS AND CONDITIONS:</b><br/>
    10. The Storer:<br/>
    (a) has the right to access the Space during Access Hours as posted by the FO and subject to the terms of this Agreement;<br/>
    (b) will be solely responsible for the securing of the Space and shall so secure the Space at all times when the Storer is not in the Space in a manner reasonably acceptable to the FO, and where applicable will secure the external gates and/or doors of the Facility. The Storer is not permitted to apply a padlock to their Space in the FO's overlocking position, and the Storer may have any such padlock forcefully cut off at the Storer's expense;<br/>
    (c) must not store any Goods that are hazardous, illegal, stolen, inflammable, explosive, environmentally harmful, perishable, living, or that are a risk to the property of any person;<br/>
    (d) must not store items which are irreplaceable, such as currency, jewellery, furs, deeds, paintings, curios, works of art, items of personal sentimental value and/or any items that are worth more than $2000AUD in total unless they are itemised and covered by insurance;<br/>
    (e) will use the Space solely for the purpose of storage and shall not carry on any business or other activity in the Space;<br/>
    (f) must not attach nails, screws etc to any part of the Space, must maintain the Space by ensuring it is clean and in a state of good repair, and must not damage or alter the Space without the FO's consent; in the event of uncleanliness of or damage to the Space or Facility the FO will be entitled to retain the Storer's Deposit, charge a Cleaning Fee, and/or full reimbursement by the Storer to the value of the repairs and/or cleaning;<br/>
    (g) cannot assign this Agreement;
    (h) must give Notice of the change of address, phone numbers or email address of the Storer or the Alternate Contact Person ("ACP") within 48 hours of any change;<br/>
    (i) grants the FO entitlement to discuss any default by and any information it holds regarding the Storer with the ACP registered on the front of this Agreement. Further, where the FO reasonably believes that the Storer is unwilling or unable to remove Goods from the Space upon termination or default of the Agreement, despite reasonable notice under these terms, the Facility Owner may allow the ACP to remove the Goods on such terms as agreed between the FO and the ACP without the need for further consent from the Storer.<br/>
    (j) is solely responsible for determining whether the Space is appropriate and suitable for storing the Storer's Goods, having specific consideration for the size, nature and condition of the Space and Goods.<br/>
    (k) must ensure their Goods are free of food scraps and are not damp when placed into storage.<br/>
    11. In addition to clause 6, the FO has the right to refuse access to the Space and/or the Facility where any moneys are owing by the Storer to the FO where a demand or notice relating to payment of such monies has been made.<br/>
    12. The FO will not be liable for any loss or damaged suffered by the Storer resulting from any inability to access the Facility or the Space.<br/>
    13. The FO reserves the right to relocate the Storer to another Space under certain circumstances, including but not limited to unforeseen extraordinary events or redevelopment of the Facility.<br/>
    14. The FO may dispose of the Storer's Goods in the event that Goods are damaged due to fire, flood or other event that has rendered Goods, in the reasonable opinion of the FO severely damaged, or dangerous to the Facility, any persons, or other Storers and/or their Goods. Where practicable, the FO will provide the Storer with reasonable Notice and an opportunity to review the Goods before the Goods are disposed of.<br/>
    15. The Storer acknowledges that it has raised with the FO all queries relevant to its decision to enter this Agreement and that the FO has, prior to the Storer entering into this Agreement, answered all such queries to the satisfaction of the Storer. The Storer acknowledges that any matters resulting from such queries have, to the extent required by the Storer and agreed to by the FO, been reduced to writing and incorporated into the terms of this Agreement.<br/>
    15A The Storer is responsible (and must pay) for loss or damage caused by a third party who enters the Space or the Facility at the request, direction, or as facilitated by the Storer (including provision of gate key code or swipe card).<br/>
    <b class="lbl wid-30">RISK AND RESPONSIBILITY:</b><br/>
    16. The FO's services come with non-excludable guarantees under consumer protection law, including that they will be provided with due care and skill. Otherwise, to the extent permitted by law, the Goods are stored at the sole risk and responsibility of the Storer who shall be responsible for any and all theft, damage to, and deterioration of the Goods, and shall bear the risk of any and all damage caused by flood or fire or leakage or overflow of
    water, mildew, mould, heat, spillage of material from any other space, removal or delivery of the Goods, pest or vermin or any other reason whatsoever.<br/>
    17. Where loss, damage or injury is caused by the Storer, the Storer's actions or the Storer's Goods, the Storer agrees to indemnify and keep indemnified the FO from all claims for any loss of or damage to the property of, or personal injury to or death of the Storer, the Facility, the FO or third parties resulting from or incidental to the use of the Space by the Storer, including but not limited to the storage of Goods in the Space, the Goods themselves and/or accessing the Facility.<br/>
    18. Certain laws may apply to the storage of goods including criminal, bankruptcy, liquidation and others. The Storer acknowledges and agrees to comply with all relevant laws, including Acts and Ordinances, Regulations, By-laws, and Orders, as are or may be applicable to the use of the Space. This includes laws relating to the material which is stored, and the manner in which it is stored. Such liability and responsibility rests with the Storer, and includes any and all costs resulting from such a breach.<br/>
    19. If the FO reasonably believes that the Storer is not complying with any relevant laws the FO may take any action as it reasonably believes to be necessary, including the action outlined in clauses 21 & 23, contacting, cooperating with and/or submitting Goods to the relevant authorities, and/or immediately disposing of or removing the Goods at the Storer's expense, including where in the FO's reasonable opinion the Storer is engaging in illegal activity in relation to the storage of the Goods. No failure or delay by the FO to exercise its rights under this Agreement will operate to waive those rights.<br/>
    <b class="lbl wid-30">INSPECTION AND ENTRY BY THE FO:</b><br/>
    20. Subject to clause 21 the Storer consents to inspection and entry of the Space by the FO provided that the FO gives 14 days Notice.<br/>
    21. In the event of an emergency, that is where obliged to do so by law or in the event that property, the environment or human life is, in the reasonable opinion of the FO, threatened, the FO may enter the Space using all necessary force without the consent of the Storer, but the FO shall thereafter notify the Storer as soon as practicable. The Storer consents to such entry.<br/>
    21A The Storer agrees that in circumstances where the FO reasonably suspects a breach of the law or damage to the facility, the FO may use a microprobe or other CCTV camera to view the inside of the Space and any footage obtained which evidences a breach of the Agreement or the law may be relied upon by the FO to take any action authorised under this Agreement, including terminating the Agreement and/or cooperating with law enforcement agencies and other authorities.<br/>
    22. NOTICE: Notice will usually be given by email or SMS, or otherwise will be left at, or posted to, or faxed to the address of the Storer. In relation to the giving of Notice by the Storer to the FO, Notice must be in writing and actually be received to be valid, and the FO may specify a required method. In the event of not being able to contact the Storer, Notice is deemed to have been given to the Storer by the FO if the FO has sent Notice to the last notified address or has sent Notice via any other contact method, including by SMS or email to the Storer or the ACP without any electronic ‘bounce back' or similar notification. In the event that there is more than one Storer, Notice to or by any single Storer is agreed to be sufficient for the purposes of any Notice requirement under this Agreement<br/>
    23. TERMINATION: Once the initial fixed period of storage has ended, either party may terminate this Agreement by giving the other party Notice of the Termination Date in accordance with period indicated on the front of this Agreement. In the event of any activities reasonably considered by the FO to be illegal or environmentally harmful on the part of the Storer the FO may terminate the Agreement without Notice. The FO is entitled to retain or charge apportioned storage fees if less than the requisite Notice is given by the Storer. The Storer must remove all Goods in the Space before the close of business on the Termination Date and leave the Space in a clean condition and in a good state of repair to the satisfaction of the FO. In the event that Goods are left in the Space after the Termination Date, clause 8 will apply. The Storer must pay any outstanding Storage Fees and any expenses on default or any other moneys owed to the FO up to the Termination Date, or clauses 6, 7 or 8 may apply. Any calculation of the outstanding fees will be by the FO. If the FO enters the Space for any reason and there are no Goods stored therein, the FO may terminate the Agreement without giving prior Notice, but the FO will send Notice to the Storer within 7 days.<br/>
    24. The Parties' liability for outstanding moneys, property damage, personal injury, environmental damage and legal responsibility under this Agreement continues to run beyond the termination of this Agreement.<br/>
    25. SEVERANCE If any clause, term or provision of this Agreement is legally unenforceable or is made inapplicable, or in its application would breach any law, that clause, term or provision shall be severed or read down, but so as to maintain (as far as possible) all other terms of the Agreement.<br/>
</div>
</body>
</html>