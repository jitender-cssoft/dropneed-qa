<?php 
	
	
	$cuisineCount = array();
	$i=1;
	foreach($finalResult as $row)
	{ 
		//	echo "<pre>"; print_r($row); echo "</pre>";	
		$venture_name = $this->business_model->select_coulmn_single_value('company','gc_customers','id',$venture_id);
			
?>
		<!--search result box -->
		<div class="search-product-box">
			<div class="product-star">
				<img src="<?php echo site_url(); ?>assets/front/images/star3.png">
				<img src="<?php echo site_url(); ?>assets/front/images/star3.png">
				<img src="<?php echo site_url(); ?>assets/front/images/star3.png">
				<img src="<?php echo site_url(); ?>assets/front/images/star3.png">
				<img src="<?php echo site_url(); ?>assets/front/images/star3.png">
			</div>
			<div class="product-pic col-md-3 col-sm-3 col-xs-12 "><img src="<?php echo site_url(); ?>assets/front/images/deault_food_image.png"  /></div>
			<div class="product-review col-md-9 col-sm-9 col-xs-12">
				<h1><a href="<?php echo site_url(); ?>detail/<?php echo $row['user_id']; ?>" ><?php echo $row['company']; ?> </a></h1>
					<?php
						$result = $this->business_model->return_venture_cuisine($row['user_id'],'result');	
					 	if(!empty($result)) 
						{
							$ids = array();
							foreach($result as $res)
							{
								
								if(in_array($res->cuisine_name,$cuisineNames))
								{
									//echo $res->cuisine_name;
									$cuisineCount[$res->cuisine_name][] = 1;
								}
								$ids[] = $res->cuisine_name; 
							}
							$cuisineArr = implode(" | ",$ids);
							echo '<div class="cuisineSelection">'.$cuisineArr.'</div>';
						} 
					?>
				<div class="clearfix"></div>
				<ul>
					<li>Min. Delivery Amount <span><?php echo config_item('myCurrency'); ?><?php echo !empty($row['min_delivery_amount'])?$row['min_delivery_amount']:'0' ?> </span></li>
					<li>Avg. Delivery Time <span><?php echo !empty($row['avg_delivery_time'])?$row['avg_delivery_time']:'0' ?> Min</span></li>
					<li>Delivery Fee <span><?php echo config_item('myCurrency'); ?><?php echo !empty($row['delivery_fee'])?$row['delivery_fee']:'0' ?> </span></li>
				</ul>
			</div>
			<div class="clearfix"></div>
		</div>        
		<!--search result box //-->
	
<?php 
		$i++;
	}
	//echo "vvbv<pre>"; print_r($cuisineCount); echo "</pre>"; 
	
?>
<script>
<?php 

if(isset($cuisineCount) && !empty($cuisineCount)) {
foreach($cuisineCount as $key=>$cousine)
{
	$count = count($cousine);
	?>
		document.getElementById("cuisineCount_<?php echo $key; ?>").innerHTML = "(<?php echo $count; ?>)";

<?php }
} ?>
</script>
