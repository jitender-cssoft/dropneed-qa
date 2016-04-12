<?php 	$sessionData =  $this->session->userdata('locationDetail');
	//	echo $ip =  $this->business_model->getip();
	//	$ipDetail =  $this->business_model->getAddressFromIP($ip);
	//	echo "<pre>"; print_r($ipDetail); echo "</pre>";
?>

<div class="container">
	
	<div class="row" >
	<h2>Reset password</h2>
		<div class="col-md-6 " >

			<form role="form" method="POST" action="<?php echo site_url('resetPassword'); ?>" onsubmit="return validate_resetPass()" class="signUp-form" id="form-forgot">
				<input type="hidden" name="verify_forgot_key" value="<?php echo $verify_forgot_key; ?>" />
				<div class="row fieldset">
					<div class="col-md-3" >Password</div>
					<div class="col-md-9" ><input type="password" autocomplete="off" name="password" id="password" /></div>
				</div>								
				<div class="row fieldset">
					<div class="col-md-3" >Confirm password</div>
					<div class="col-md-9" ><input type="password" autocomplete="off" name="confirm_password" id="confirm_password" /></div>
				</div>				
				<div class="row fieldset">
					<div class="col-md-3" ></div>
					<div class="col-md-9" ><input type="submit"  id="resetPassSubmitBtn"  value="Submit" /></div>
				</div>												
			</form>			
			<div class="row msg error errorMsg" style="display:none" id="errorMsg"></div>
		</div>
		<div class="col-md-6 " >
			<p>Go to <a href="<?php echo site_url('login') ?>" >Login</a> page</p>
		</div>
	</div>

</div>
<div class="clearfix"></div>
