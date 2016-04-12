<?php $area_name = $detail['area_name']; $area_name = explode(",",$area_name); $area_name = $area_name[0]; 
	$where1 = array();
	$where1['id'] = $this->session->userdata('userDetail')['user_id'];
	$userResult = $this->business_model->select_data_where('gc_customers',$where1);	
?>
<!-- Content Area -->
<div class="container">
	<div class="row">
		<div class="col-sm-6">
			<div class="breadcrumb">
				<ul>
					<li><a href="<?php echo site_url('category') ?>" ><?php echo !empty($detail['location_city'])?current(explode(",",$detail['location_city'])):$detail['location_zipcode']; ?></a></li>
					<li><a href="<?php echo site_url('seller/'.$detail['category_id'])?>"><?php echo $detail['category_name']; ?></a></li>
					<li><?php echo $area_name; ?></li>
				</ul>
			</div>
		</div>	
		<div class="col-sm-offset-3 col-sm-2"> 
			<?php if(config_item('isLogin') == 'YES' ) {  ?>    
			<div class="welcome">
				<span>Hi <?php echo $userResult['firstname']; ?></span><br>
				<a href="#;">  Your Account</a>
			</div> 
			<?php } ?>  
		</div>		
		<div class="col-sm-1">
			<div class="cart">
				<div class="alertbadge"><a href="javascript:void(0)"><?php echo $this->cart->total_items(); ?></a></div>
				<a id="dLabel" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" href="#;"><img src="<?php echo site_url(); ?>assets/front/images/cart-icon.png" /></a>
				<div class="dropdown-menu" aria-labelledby="dLabel">
					<?php $this->load->view('front/index/area_cartBox'); ?>	
				</div>    
			</div>
		</div>
	</div>
	<div class="clearfix"></div>
	<div class="heading"><h2>Search for restaurants in <span><?php echo current(explode(",",$detail['location_city'])); ?>, <?php echo $area_name; ?></span></h2></div>		
		<div class="row">
			<input type="hidden" name="" id="hid-clearFilter-status" value="0" />
			<input type="hidden" name="" id="hid-autoRun-status" value="0" />
			<form id="form-restaurant-listing-searchBox" method="POST" >
				<input type="hidden" name="hid_sort_order" id="hid-sort-order" value="asc" />
				<input type="hidden" name="hid_sort_type" id="hid-sort-type" value="alphabet" />
				<input type="hidden" name="hid_limit" id="hid_limit" value="3" />
				<input type="hidden" name="hid_ofset" id="hid_ofset" value="3" />
				<input type="hidden" name="load_more" id="hid-load_more" value="0" />
			<div class="col-sm-3">
				<div class="left-panel">    
					<div class="divider">
						<div class="form-group">   
							<input type="text" id="restaurant-restaurantName" name="restaurant_restaurantName" class="form-control"  placeholder="Restaurant name" />
						</div>
					</div>
					<hr>
				   <!--<div class="divider checkbox-list">
						<div class="checkbox"> <label> <input id="chk2" type="checkbox">Now open </label> <span class="pull-right">(27)</span> </div>
						<div class="checkbox"> <label> <input type="checkbox"> With promotion </label> <span class="pull-right">(9)</span> </div>
						<div class="checkbox"> <label> <input type="checkbox"> Pre-Order Restaurants </label> <span class="pull-right">(0)</span> </div>
				   </div>-->				
					<div class="divider rounded-field">
						<h4 class="widget-title">Delivery area</h4>
						<div class="form-group"> 
							<select  class="form-control" name="listing_delivery_area" id="listing_delivery_area" >
								<option value="">Select Delivery area</option>
								
								<?php 	
									for($i=1;$i<=20; $i++)	{
										if($i%5==0)
											echo '<option value="'.$i.'" >'.$i.' km</option>';
									} ?>
							</select>                     
						</div>
					</div>            
					<hr>            
					<div class="divider">
						<h4 class="widget-title">Minimum Delivery Amount</h4>
						<div class="form-group"> 
							<input  name="minimumDeliveryAmount" id="amount" data-slider-id='ex1Slider' type="hidden" data-slider-min="0" data-slider-max="20" data-slider-step="1" data-slider-value="20"/>							
							<div id="slider-range-min"></div>
							<div class="numbering">
								<ul>
									<li>0</li>
									<li>|</li>
									<li>|</li>
									<li>|</li>
									<li>|</li>
									<li>|</li>
									<li>|</li>
									<li>|</li>
									<li>100</li>
								</ul>
							</div>
						</div>
					</div>     
					<div class="clearfix"></div>               
					<hr>
					<div class="divider rounded-field">
						<h4 class="widget-title">Delivery Fee</h4>
						<div class="form-group"> 
							<select class="form-control" name="delivery_fee" id="delivery_fee">
								<option value="" >All</option>
								<option value="free" >Free</option>
								<option value="paid" >Paid</option>
							</select>
						</div>
					</div>              
					<hr>
<!--
					<div class="divider">
						<h4 class="widget-title">Restaurant Ratings</h4>
						<div class="form-group"> 
							<input id="ex9" data-slider-id='ex1Slider' type="text" data-slider-min="0" data-slider-max="20" data-slider-step="1" data-slider-value="20"/>
							<div class="star-rating">
								<ul>
									<li>All</li>
									<li><img src="<?php echo site_url(); ?>assets/front/images/star2.png"></li>
									<li><img src="<?php echo site_url(); ?>assets/front/images/star2.png"></li>
									<li><img src="<?php echo site_url(); ?>assets/front/images/star2.png"></li>
									<li><img src="<?php echo site_url(); ?>assets/front/images/star2.png"></li>
									<li><img src="<?php echo site_url(); ?>assets/front/images/star2.png"></li>
								</ul>
							</div>
						</div>
					</div>
-->				
					<div class="clearfix"></div>
					<hr>          
					<div class="divider checkbox-list">				   
						<h4 class="widget-title">Cuisine Selection</h4>
						<?php $allCuisine =  $this->business_model->select_all_data('gc_cuisine'); 
							$i=1;
							$cuisineNames =  array();
							foreach($allCuisine as $cuisine)
							{
								$cuisineNames[] = $cuisine['cuisine_name'];
								if($i==1)
									echo '<div class="shortCuisine" >';
								if($i==5)
								{
									echo '<a id="seeAllCuisinesLink" style="font-size:12px; color:#669934;" href="javascript:void(0)"><img src="'.site_url().'assets/front/images/arrow.png"> See all cuisines</a>';
									echo '</div><div style="display:none" class="allCuisine" >';
								}								
						?>
								<div class="checkbox"> <label> <input class="cuisine_fav"  type="checkbox" name="cuisine_fav[]" value="<?php echo $cuisine['cuisine_id']; ?>"  /><?php echo $cuisine['cuisine_name']; ?> </label> <span class="pull-right" id="cuisineCount_<?php echo $cuisine['cuisine_name']; ?>">(0)</span> </div>
						<?php																
								$i++;								
							}	
							echo '</div>';
						?>											
					</div>
					<hr>
					<div class="divider">
						<h4 class="widget-title">Average Delivery Time</h4>
						<div class="form-group"> 
							<input class="ex10" id="hid_avg_deliveryTime" name="hid_avg_deliveryTime" data-slider-id='ex1Slider' type="hidden" data-slider-min="0" data-slider-max="20" data-slider-step="1" data-slider-value="20"/>							
							<div id='slider'></div>
							<div class="average">
								<ul>
									<li>30</li>
									<li>|</li>
									<li>45</li>
									<li>|</li>
									<li>60</li>
									<li>|</li>
									<li>All</li>
								</ul>
							</div>
						</div>
					</div>               
				<div class="clearfix"></div>
				<hr>               
				<div class="divider rounded-field">
					<h4 class="widget-title">Payment Method</h4>
					<div class="form-group">                     
						<select  class="form-control" name="listing_payment_method"  id="listing_payment_method" >
							<option value="">Select Payment method</option>
								<option value="card">Card</option>
								<option value="paypal">Paypal</option>
								<option value="delivery">Delivery</option>
						</select>	                     
                   </div>
               </div>                              
            </div>
			</div>
			</form>
			<div class="col-sm-9 ventureListingSection">
			<!-- Loading div -->
			<div  id="ventureLisingLoader" class="ventureLisingLoader">
				<div class="inner" >			
						<span class="icon"><img src="<?php echo site_url(); ?>assets/front/images/cartLoader.gif" width="25px" height="25px"  />Loading . . .</span> 
				</div>
			</div>
			<!--loading div -- >  								
             <!--white-wrapper --> 
            <div class="white-wrapper">     

            <div class="filter"><h3>Filtered by:</h3> <span  id="filter-action-area" > </span>            
			<a class="reset" href="javascript:void(0)" onclick="clearThisFilter('all')" >Reset filters</a>
            </div>                 
            <div class="sort">            
            <h3>Sort by:</h3>
            <a href="javascript:void(0)" class="active-sort" onclick="changeOrder('Alfabet')" >Alphabetic</a>
			<!--<a href="#">Rating <img src="<?php echo site_url(); ?>assets/front/images/rating.png"></a>-->
            </div>                      
            <div class="note">Your selected area is <span><?php echo $area_name; ?></span> you can change it from Delivery Area filter.</div>     
            <!--search result box -->
			<div class="restaurant_list-ajaxSection">        
			<?php	$data =  array();
			$data['cuisineNames'] =  $cuisineNames;
			 $this->load->view('front/index/restaurant_list',$data); ?>			
			</div>
			<!--search result box //-->           
            </div>
            <!--white-wrapper //-->
        </div>
		</div>
</div>
<div class="clearfix"></div>


