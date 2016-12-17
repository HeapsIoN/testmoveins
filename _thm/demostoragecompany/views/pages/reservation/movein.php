<p>&nbsp;</p>
<h2><?php $this->page->heading('pagetitle'); ?></h2>
<p>&nbsp;</p>

<p>Thank you for selecting your unit<strong>. </strong>(Need to <a href="/unit" class="txt-3" style="text-decoration: underline;">choose a different unit</a>?)</p>

<form id="login" class="form-horizontal col-xs-12 col-md-6 col-md-offset-3 mrg-b-md">
    <div class="col-xs-12 well">
        <legend>Existing User</legend>
        <div class="col-xs-12 pad-none pad-b-md">
            <label class="col-xs-12 col-lg-5 pad-none pad-r-md control-label" for="customerexistingcode">Email address / customer code</label>
            <div class="col-xs-12 col-lg-7 pad-none">
                <input type="text" class="form-control login-input" id="customerexistingcode" name="customerexistingcode" placeholder="Your email or customer code" />
            </div>
        </div>
        <div class="col-xs-12 pad-none pad-b-md">
            <label class="col-xs-12 col-lg-5 pad-none pad-r-md control-label" for="customerexistingpass">Password</label>
            <div class="col-xs-12 col-lg-7 pad-none">
                <input type="password" class="form-control login-input" id="customerexistingpass" name="customerexistingpass" placeholder="Your password" />
                <button type="button" class="bdr-none col-xs-12 pad-none txt-3 alg-lt lh-30" style="background-color: transparent;" id="reset-loader"><span class="txt-grey">Forgot your</span> password?</button>
            </div>        	
        </div>
        <div class="col-xs-12 pad-none">
        <button type="button" class="btn pull-right bg-3 bg-4-hover txt-1 txt-1-hover txt-uc" id="logincustomer">Login &raquo;</button>
        </div>
    </div>
</form>