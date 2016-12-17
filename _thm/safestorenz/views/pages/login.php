<div class="container-home">
<h1><?php $this->page->heading('pagetitle'); ?></h1>
<form id="login-form" action="/admin/dashboard">
<div class="col-xs-12 pad-none">
	<div class="col-xs-12 col-md-6 col-md-offset-3 pad-none">
    	<div class="col-xs-12 pad-none mrg-b-md">
        	<label for="user" class="lbl col-xs-12 alg-lft txt-md">Email</label>
            <input type="text" class="input input-login col-xs-12 bdr-3 txt-lg txt-4" id="user" placeholder="Enter your email address" />
        </div>
        <div class="col-xs-12 pad-none mrg-b-md">
        	<label for="pass" class="lbl col-xs-12 alg-lft txt-md">Password</label>
            <input type="password" class="input input-login col-xs-12 bdr-3 txt-lg txt-4" id="pass" placeholder="Enter your password" />
        </div>
        <div class="col-xs-12 pad-none mrg-b-md">
        	<button type="button" class="btn col-xs-12 bg-3 bg-7-hover txt-1 txt-uc" id="enter">Login</button>
        </div>
    </div>
</div>
</form>

<form id="reset-form">
<div class="col-xs-12 pad-none">
	<div class="col-xs-12 col-md-6 col-md-offset-3 pad-none">
    	<h2>Password Reset</h2>
    	<div class="col-xs-12 pad-none mrg-b-md">
        	<p>Forgotten your password? Enter your email below and click reset and we will generate a new one and email it to you.</p>
            <p>Sometimes the email might get marked as spam so be sure to check your junk mail if you can't see it in your inbox.</p>			
        </div>
        <div class="col-xs-12 pad-none mrg-b-md">
        	<label for="user" class="lbl col-xs-12 alg-lft txt-md">Email</label>
            <input type="text" class="input input-reset col-xs-12 bdr-3 txt-lg txt-4" id="remail" placeholder="Enter your email address" />
        </div>
        <div class="col-xs-12 pad-none mrg-b-md">
        	<button type="button" class="btn col-xs-12 bg-6 bg-7-hover txt-1 txt-uc" id="reset-btn">Reset</button>
        </div>
    </div>
</div>
</form>

</div>
