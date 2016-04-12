<?php $detail =  $this->session->userdata('locationDetail'); ?>
<!-- Content Area -->
<div class="container mT60">
  <div class="row">
    <div class="col-md-11 col-center">
      <div class="category text-center">
        <p class="blue f16 text-left"><strong><?php echo !empty($detail['location_city'])?$detail['location_city']:$detail['location_zipcode']; ?></strong></p>
        <div class="row">
          <div class="col-xs-4"><a href="<?php echo site_url('seller/3'); ?>"><img src="<?php echo site_url(); ?>assets/front/images/category-food.jpg" alt="" /></a></div>
          <div class="col-xs-4"><a href="<?php echo site_url('seller/1'); ?>"><img src="<?php echo site_url(); ?>assets/front/images/category-grocery.jpg" alt="" /></a></div>
          <div class="col-xs-4"><a href="<?php echo site_url('seller/2'); ?>"><img src="<?php echo site_url(); ?>assets/front/images/category-pharmacy.jpg" alt="" /></a></div>
        </div>
      </div>
    </div>
  </div>
</div>
<div class="clearfix"></div>
