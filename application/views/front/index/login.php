<?php 	$sessionData =  $this->session->userdata('locationDetail');
	//	echo $ip =  $this->business_model->getip();
	//	$ipDetail =  $this->business_model->getAddressFromIP($ip);
	//	echo "<pre>"; print_r($ipDetail); echo "</pre>";
?>

<div class="container">
	
	<div class="row" >
	<h2>Login</h2>
		<div class="col-md-6 " >
			<div class="row" >
				Register with <a href="<?php echo site_url(); ?>index/facebook_login"><img src="<?php echo site_url(); ?>assets/front/images/facebook.png" /></a> &nbsp; or &nbsp; <a href="<?php echo site_url(); ?>index/google_login"><img src="<?php echo site_url(); ?>assets/front/images/googlePlus.png" /></a>
			</div>
			<div class="row" ><strong>OR</strong></div>
			<?php echo isset($errorMessage)?$errorMessage:''; ?>
			<form role="form" class="signUp-form" id="form-login" method="POST" >
				
				<div class="row fieldset">
					<div class="col-md-3" >Email</div>
					<div class="col-md-9" ><input type="text" name="loginEmail" id="loginEmail" value="<?php echo isset($_COOKIE['email'])?$_COOKIE['email']:'' ?>" /></div>
				</div>								
				<div class="row fieldset">
					<div class="col-md-3" >Pasword</div>
					<div class="col-md-9" ><input type="password" name="loginPassword" id="loginPassword"  value="<?php echo isset($_COOKIE['password'])?$_COOKIE['password']:'' ?>" /></div>
				</div>								

				<div class="row fieldset">
					<div class="col-md-5" ><input type="checkbox" id="remember_me" name="remember_me"  <?php echo isset($_COOKIE['email'])?'checked':'' ?>  />Remember me</div>
					<div class="col-md-6" ><input type="submit" name="submit" id="loginSubmitBtn"  value="Login" /></div>
				</div>								
				<div class="row fieldset">
					<div class="col-md-6" ><a href="<?php echo site_url('forgot') ?>">Forgot password</a></div>
					<div class="col-md-6" ></div>
				</div>
			</form>			
		</div>
		<div class="col-md-6 " >
			<p>Do not have an account <a href="<?php echo site_url('register') ?>" >Register</a></p>
		</div>
	</div>

</div>
<div class="clearfix"></div>
