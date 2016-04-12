<?php// echo "<pre>"; print_r($detail); echo "</pre>"; ?>
<!-- Content Area -->

<div class="container">
  <div class="breadcrumb">
    <ul>

      <li><a href="<?php echo site_url('category') ?>" ><?php echo !empty($detail['location_city'])?$detail['location_city']:$detail['location_zipcode']; ?></a></li>


      <li><a href="<?php echo site_url('seller/'.$detail['category_id'])?>"><?php echo $detail['category_name']; ?></a></li>
      <li><?php echo $detail['area_name']; ?></li>

    </ul>
  </div>
  <div class="seller-selection">
    <h2 class="mB30 mT0"><?php echo $search_line_div; ?></h2>
   
  </div>
  <style>
 .active-sort {    font-weight: bold;}
</style>

   <div class="row">
    <!-- Left Section start -->
    <div class="col-sm-4 hotel-listing-left">
		
		<form id="form-restaurant-listing-searchBox" method="POST" >
			<input type="hidden" name="hid_sort_order" id="hid-sort-order" value="asc" />
			<input type="hidden" name="hid_sort_type" id="hid-sort-type" value="alphabet" />
			<input type="hidden" name="hid_limit" id="hid_limit" value="3" />
			<input type="hidden" name="hid_ofset" id="hid_ofset" value="3" />
			<input type="hidden" name="load_more" id="hid-load_more" value="0" />
			<div class="row hotel-listing-left-box search">
				<input type="text" id="restaurant-restaurantName" name="restaurant_restaurantName" placeholder="Restaurant name" />
			</div>
			
			<div class="row hotel-listing-left-box">
				<ul class="listing_ul_restaurantType"  id="listing-ul-restaurantType" >
					<li><input type="checkbox"  id="now_open" value="now_open" name="listing_ul_restaurantType[]" /> Now open </li>
					<li><input type="checkbox" id="with_promotion" value="with_promotion"  name="listing_ul_restaurantType[]" /> With promotion </li>
									
				</ul>
								
			</div>

			<div class="row hotel-listing-left-box">
				<label>Delivery Area</label>
				<select name="listing_delivery_area" id="listing_delivery_area" >
					<option value="">Select Delivery area</option>
					<?php 	
						for($i=1;$i<=50; $i++)	{
							echo '<option value="'.$i.'" >'.$i.' km</option>';
						} ?>
				</select>
			</div>

			<div class="row hotel-listing-left-box ">
				<label>Minimum Delivery amount </label>
				<input type="text" name="listing_minimumDeliveryAmount" id="amount" value='' readonly style="border:0; color:#f6931f; font-weight:bold;">
				
				<div id="slider-range-min"></div>
			</div>
			<div class="row hotel-listing-left-box ">
				<label>Delivery fee</label>
				<select name="delivery_fee" id="delivery_fee">
					<option value="" >All</option>
					<option value="free" >Free</option>
					<option value="paid" >Paid</option>
				</select>
			</div>
			<?php /* ?>
			<div class="row hotel-listing-left-box ">
				
				<label for="minbeds">Rating</label>
					 <!--<select name="minbeds" id="minbeds"><option>1</option><option>2</option><option>3</option><option>4</option></select>-->
				
				<input type="hidden" id="selected_rating" name="selected_rating" value="" />
				<div id='ratingSlider'></div>
				
				<span class="col-sm-2">ALL</span>
				<span class="col-sm-2"><img src="<?php echo site_url(); ?>assets/front/images/rating.png" /></span>
				<span class="col-sm-2"><img src="<?php echo site_url(); ?>assets/front/images/rating.png" /></span>
				<span class="col-sm-2"><img src="<?php echo site_url(); ?>assets/front/images/rating.png" /></span>
				<span class="col-sm-2"><img src="<?php echo site_url(); ?>assets/front/images/rating.png" /></span>
				<span class="col-sm-2"><img src="<?php echo site_url(); ?>assets/front/images/rating.png" /></span>
				
			</div>		
			<?php */ ?>
			<div class="row hotel-listing-left-box ">
				<div class="col-md-12">			
					<div class="row"  ><label>Cuisin </label></div>
				<?php $allCuisine =  $this->business_model->select_all_data('gc_cuisine'); 
					
				?>
				<div class="row"  >
				
					
					<?php
					$i=0;
					foreach($allCuisine as $cuisine)
					{
						echo '<input class="cuisine_fav" type="checkbox" name="cuisine_fav[]" value="'.$cuisine['cuisine_id'].'" />'.$cuisine['cuisine_name'].'<br>'; 
					$i++;
					}
					 ?>
				
				</div>
				</div>
			</div>
			
			<div class="row hotel-listing-left-box ">
				
				<label for="minbeds">Avg. Delivery Time</label>
					 <!--<select name="minbeds" id="minbeds"><option>1</option><option>2</option><option>3</option><option>4</option></select>-->
				
				<input type="hidden" id="hid_avg_deliveryTime" name="hid_avg_deliveryTime" value="" />
				<div id='slider'></div>
				
				<span class="col-sm-3">30</span>
				<span class="col-sm-3">45</span>
				<span class="col-sm-3">60</span>
				<span class="col-sm-3">ALL</span>
			</div>
			<div class="row hotel-listing-left-box ">
			
				<label for="minbeds">Payment method</label>
					<select name="listing_payment_method"  id="listing_payment_method" >
						<option value="">Select Payment method</option>
						<option value="cod">Cash on delivery</option>	
						<option value="paypal">Paypal</option>	
					</select>		
			</div>            
		</form>  
    </div>
    <!-- Left Section end -->
    <!-- Right Section start -->
    <div class="col-sm-8 hotel-listing-right">
		<!-- FilterBox Section start -->
		<div class="row">
			<div class="col-sm-1"><b>Filter</b></div>
			<div class="col-sm-9 filter-action-area " id="filter-action-area">
											
			</div>
			<div class="col-sm-2"><b><a href="javascript:void(0)" onclick="clearThisFilter('all')" >Clear filter</a></b></div>
		</div>	
		<!-- FilterBox Section end -->
		<!-- SortingBox Section start -->
		<div class="row">
			<div class="col-sm-4"><b>Sort by:  </b> </div>
			<div class="col-sm-8">
				<a href="javascript:void(0)" class="active-sort" onclick="changeOrder('Alfabet')" >Alfabet <span id="orderStatment">A-Z</span></a> 
				<!--
								<a href="javascript:void(0)" >Rating</a> 
				-->
			</div>
			
		</div>			
		<!-- SortingBox Section end -->
		<!-- ListingBox Section start -->
		<div class="restaurant_list-ajaxSection">
<!--
			<div class="list-loader" ><img src="<?php echo site_url(); ?>assets/front/images/list-loader.gif" /></div>
-->
			<?php $this->load->view('front/index/restaurant_list'); ?>
		</div>
		<div class="row" >
<!--
			<input type="button"  value="load more . . ." onclick="loadmore();" />
-->
		</div>
		<!-- ListingBox Section start -->
    </div>
	<!-- Right Section end -->
  </div>
</div>
  
  
</div>
<div class="clearfix"></div>




