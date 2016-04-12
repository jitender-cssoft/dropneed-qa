<?php $sessionData =  $this->session->userdata('locationDetail'); ?>
<!-- Content Area -->
  <script>

	window.onload = function() {
		var venture_id = "<?php echo $sessionData['venture_id']; ?>";
		tab_product_listing(venture_id,type='all',name='All');
	};
  </script>
  <input type="hidden" value="<?php echo $sessionData['venture_id']; ?>" id="productPage_venture_id" />
<div class="container">
  <div class="breadcrumb">
    <ul>
		<li><a href="<?php echo site_url('category') ?>"><?php echo !empty($sessionData['location_city'])?$sessionData['location_city']:$sessionData['location_zipcode']; ?></a></li>
		<li><a href="<?php echo site_url('seller/'.$sessionData['category_id'])?>"><?php echo $sessionData['category_name']; ?></a></li>
		<li><a href="<?php echo site_url('area')?>"><?php echo $sessionData['area_name']; ?></a></li>
		<li><?php echo $sessionData['venture_name']; ?></li>
    </ul>
  </div>
  
  <div class="seller-selection">
    <h2 class="mB30 mT0"><?php echo $search_line_div; ?></h2>
  </div>
  
  
   <div class="row">
    <!-- Left Section start -->
    <div class="col-sm-8">
		<div class="row">
				<div class="col-sm-3"><img src="<?php echo site_url(); ?>assets/front/images/deault_food_image.png"  /></div>
				<div class="col-sm-5">
					<div class="fieldset">
						<label>Avg Delivery Time :</label><?php echo $ventureResult['avg_delivery_time']; ?> min
					</div>
					<div class="fieldset">
						<label>Delivery Free : </label><?php echo $ventureResult['delivery_fee']; ?> <?php echo config_item('myCurrency'); ?>
					</div>
					<div class="fieldset">
						<label>Min Delivery Amount : </label><?php echo $ventureResult['min_delivery_amount']; ?> <?php echo config_item('myCurrency'); ?>
					</div>					
				</div>
				<div class="col-sm-3">
					<div class="row" >
						<span class="col-sm-2"><img src="<?php echo site_url(); ?>assets/front/images/rating.png" /></span>
						<span class="col-sm-2"><img src="<?php echo site_url(); ?>assets/front/images/rating.png" /></span>
						<span class="col-sm-2"><img src="<?php echo site_url(); ?>assets/front/images/rating.png" /></span>
						<span class="col-sm-2"><img src="<?php echo site_url(); ?>assets/front/images/rating.png" /></span>
						<span class="col-sm-2"><img src="<?php echo site_url(); ?>assets/front/images/rating.png" /></span>
					</div>
					<div class="row" >
						<h3>User Reviews</h3>
					</div>
					<div class="row" >
						<p><b>Be the first review of this restaurant</b></p>
					</div>
				</div>
		</div>
		
	<!-- Tab section start -->
	<div class="row" >
		<div id="detail-menu-tabs">
			<ul>
				<li><a href="#tabs-1">Menu</a></li>
				<li><a href="#tabs-2">User revies</a></li>
				<li><a href="#tabs-3">Delivery Details</a></li>
			</ul>
			<div id="tabs-1">
				<div class="row" >
					<div class="col-sm-3 product-catType-section" >
						<ul class="product-catType">
							<li data-type="all" class="active">All</li>
							<li data-type="most_selling">Most Selling</li>
							<li data-type="promotions" >Promotions</li>
						</ul>
					</div>
					<div class="col-sm-9 product-listing-section" >
						<?php //$this->load->view('front/index/tab_product_listing'); ?>
					</div>					
				</div>
			</div>
			<div id="tabs-2">
				<!-- Trigger the modal with a button -->
				
				<p>Mauris eleifend est et turpis. Duis id erat. Suspendisse potenti. Aliquam vulputate, pede vel vehicula accumsan, mi neque rutrum erat, eu congue orci lorem eget lorem. Vestibulum non ante. Class aptent taciti sociosqu ad litora torquent per conubia nostra, per inceptos himenaeos. Fusce sodales. Quisque eu urna vel enim commodo pellentesque. Praesent eu risus hendrerit ligula tempus pretium. Curabitur lorem enim, pretium nec, feugiat nec, luctus a, lacus.</p>
				<p>Duis cursus. Maecenas ligula eros, blandit nec, pharetra at, semper at, magna. Nullam ac lacus. Nulla facilisi. Praesent viverra justo vitae neque. Praesent blandit adipiscing velit. Suspendisse potenti. Donec mattis, pede vel pharetra blandit, magna ligula faucibus eros, id euismod lacus dolor eget odio. Nam scelerisque. Donec non libero sed nulla mattis commodo. Ut sagittis. Donec nisi lectus, feugiat porttitor, tempor ac, tempor vitae, pede. Aenean vehicula velit eu tellus interdum rutrum. Maecenas commodo. Pellentesque nec elit. Fusce in lacus. Vivamus a libero vitae lectus hendrerit hendrerit.</p>
				<!-- Modal -->
			
			</div>
			<div id="tabs-3">
				
				<p>Duis cursus. Maecenas ligula eros, blandit nec, pharetra at, semper at, magna. Nullam ac lacus. Nulla facilisi. Praesent viverra justo vitae neque. Praesent blandit adipiscing velit. Suspendisse potenti. Donec mattis, pede vel pharetra blandit, magna ligula faucibus eros, id euismod lacus dolor eget odio. Nam scelerisque. Donec non libero sed nulla mattis commodo. Ut sagittis. Donec nisi lectus, feugiat porttitor, tempor ac, tempor vitae, pede. Aenean vehicula velit eu tellus interdum rutrum. Maecenas commodo. Pellentesque nec elit. Fusce in lacus. Vivamus a libero vitae lectus hendrerit hendrerit.</p>
				<p>Mauris eleifend est et turpis. Duis id erat. Suspendisse potenti. Aliquam vulputate, pede vel vehicula accumsan, mi neque rutrum erat, eu congue orci lorem eget lorem. Vestibulum non ante. Class aptent taciti sociosqu ad litora torquent per conubia nostra, per inceptos himenaeos. Fusce sodales. Quisque eu urna vel enim commodo pellentesque. Praesent eu risus hendrerit ligula tempus pretium. Curabitur lorem enim, pretium nec, feugiat nec, luctus a, lacus.</p>
			</div>
		</div>
	</div>
    <!-- Tab section END -->  
    </div>
    <!-- Left Section end -->
    <!-- Right Section start -->
    <div class="col-sm-4 productPage-cartSection">
		<?php $this->load->view('front/index/product_cart'); ?>
    </div>
	<!-- Right Section end -->
  </div>
</div>
  
  
</div>
<div class="clearfix"></div>




