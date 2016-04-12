<?php 	$sessionData =  $this->session->userdata('locationDetail'); ?>
<div class="container">
	<div class="row" >
	<h2>Register</h2>
		<div class="col-md-6 " >
			<div class="row" >
				Register with <a href="<?php echo site_url('index/facebook_login'); ?>"><img src="<?php echo site_url(); ?>assets/front/images/facebook.png" /></a> &nbsp; or &nbsp; <a href="<?php echo site_url(); ?>index/google_login"><img src="<?php echo site_url(); ?>assets/front/images/googlePlus.png" /></a>
			</div>
			<div class="row" ><strong>OR</strong></div>
			
			<form role="form" method="POST" id="form-register" action="<?php echo site_url('index/register'); ?>" onsubmit="return validate_signupForm()" class="signUp-form">
				<div class="row fieldset">
					<div class="col-md-4" >Name *</div>
					<div class="col-md-8" ><input type="text" class="cls-req" name="name" id="name" maxlength="10" /></div>
				</div>
				<div class="row fieldset">
					<div class="col-md-4" >Surname *</div>
					<div class="col-md-8" ><input type="text" class="cls-req" name="surname" id="surname" maxlength="10" /></div>
				</div>				
				<div class="row fieldset">
					<div class="col-md-4" >Email *</div>
					<div class="col-md-6" ><input type="email"  name="email" id="email" autocomplete="off" value="" /></div>
					<div class="col-md-2"><img src="<?php echo site_url(); ?>assets/front/images/email-loader.gif" style="display:none" id="email-loader" /></div>
				</div>								
				<div class="row fieldset">
					<div class="col-md-4" >Pasword *</div>
					<div class="col-md-8" ><input type="password" class="cls-req" name="password" id="password" maxlength="15" /></div>
				</div>								
				<div class="row fieldset">
					<div class="col-md-4" >Confirm password *</div>
					<div class="col-md-8" ><input type="password" data-confirmWith="password" class="cls-req cls-confirm" name="confirm_password" id="confirm_password" maxlength="15" /></div>
				</div>								
				<div class="row fieldset">
					<div class="col-md-4" >City *</div>
					<div class="col-md-8" >
						<input type="text" id="cityName" name="cityName"  />
						
					</div>
				</div>								
				<div class="row fieldset">
					<div class="col-md-4" >Mobile number *</div>
					<div class="col-md-8" ><input type="text" class="cls-req numbersOnly" name="mobile_number" id="mobile_number"  /></div>
				</div>																
				<p>By click register button bellow, You agree to our <a href="<?php echo site_url('term'); ?>">Terms</a> and <a href="<?php echo site_url('privacy'); ?>">Privacy policy</a> and that you have fully read and understood them</p>
				<div class="row fieldset">
					
					<div class="col-md-12" ><input type="submit" id="registerSubmitBtn" value="Register" /></div>
				</div>								
			</form>			
		
		<div class="row msg error errorMsg" style="display:none" id="errorMsg"></div>
		</div>
		<div class="col-md-6 " >
			<p>Already have an account <a href="<?php echo site_url('login') ?>" >Log in</a></p>
		</div>
	</div>

</div>
<div class="clearfix"></div>
