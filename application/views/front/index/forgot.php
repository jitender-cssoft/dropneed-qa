<?php 	$sessionData =  $this->session->userdata('locationDetail');
	//	echo $ip =  $this->business_model->getip();
	//	$ipDetail =  $this->business_model->getAddressFromIP($ip);
	//	echo "<pre>"; print_r($ipDetail); echo "</pre>";
?>
<div class="container">
	<div class="row" >
	<h2>Forgot</h2>
		<div class="col-md-6 " >
			<form role="form" method="POST" action="<?php echo site_url('forgot'); ?>" onsubmit="return validate_forgot()" class="signUp-form" id="form-forgot">				
				<div class="row fieldset">
					<div class="col-md-3" >Email</div>
					<div class="col-md-7" ><input type="text" autocomplete="off" name="email" id="email" /></div>
					<div class="col-md-2"><img src="<?php echo site_url(); ?>assets/front/images/email-loader.gif" style="display:none" id="email-loader" /></div>
				</div>											
				<div class="row fieldset">
					<div class="col-md-3" ></div>
					<div class="col-md-9" ><input type="submit"  id="forgotSubmitBtn"  value="Submit" /></div>
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
