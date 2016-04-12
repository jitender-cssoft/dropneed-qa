	<p><?php echo $heading; ?></p>
	
						<?php
					//	echo "<pre>hj"; print_r($productResult); echo "</pre>";
						 if(isset($productResult) && !empty($productResult)) { 
							$i=1;
							foreach($productResult as $product)
							{
								$images = (array) json_decode($product['images']);
								$array = array_values($images);								
								
								 
							?>
							
								<div class="row product-listing-box" >
									<div class="col-sm-3" >
										<img src="<?php echo site_url(); ?>uploads/images/small/<?php echo $array[0]->filename; ?>" />
									</div>
									<div class="col-sm-9" >
										<div class="col-md-12" style="color:#F7941E;"><strong><a class="openAdonPupupBtn" data-index="<?php echo $i?>" href="javascript:void(0)" data-toggle="modal" data-target="#myModal-<?php echo $i?>" ><?php echo $product['name']; ?></a></strong></div>
										<div class="col-md-12" ><?php echo $product['description']; ?></div>
				 						<div class="col-md-12" >
											
											<input type="text" id="productList-qty-<?php echo $i?>" size="3" value="1" />
											<input type="button" class="productList-plusBtn" id="productList-plusBtn-<?php echo $i?>" value="+" />
											<span><strong><span ><?php echo $product['price']; ?></span>  <?php echo config_item('myCurrency'); ?> </strong></span>
										</div>
									</div>
								</div>
												
								<div id="myModal-<?php echo $i?>" class="modal fade" role="dialog">
								
								<form id="popupProductModel-form-<?php echo $i?>" method="POST" >
									<input type="hidden" name="venture_id" value="<?php echo isset($product['added_by_cust'])?$product['added_by_cust']:$product['added_by']; ?>" />
									<input type="hidden" name="product_id" value="<?php echo $product['id']; ?>" />
									<input type="hidden" name="product_name" value="<?php echo $product['name']; ?>" />
									<input type="hidden" id="product_price-<?php echo $i?>" name="product_price" value="<?php echo $product['price']; ?>" />
									<input type="hidden" id="product_main_price-<?php echo $i?>" value="<?php echo $product['price']; ?>" />
									
									<div class="modal-dialog">
										<!-- Modal content-->
										<div class="modal-content">
											<div class="modal-header">
												<button type="button" class="close" data-dismiss="modal">&times;</button>
												<h4 class="modal-title">ADD TO BASKET </h4>
											</div>
											<div class="modal-body">
												<div class="row msg error" id="addOnPopUPError-<?php echo $i; ?>" style="display:none" ></div>
												<div class="row" >
													<div class="col-md-2" ><img src="<?php echo site_url(); ?>uploads/images/small/<?php echo $array[0]->filename; ?>"></div>
													<div class="col-md-10" >
														<div class="row" >
															<p  style="color:#F7941E;"><strong><?php echo $product['name']; ?></strong></p>																	
															<p><span class="popupProduct-price" id="productPriceLabel-<?php echo $i?>" ><?php echo $product['price']; ?></span> <?php echo config_item('myCurrency'); ?> </p>
															<input type="number" id="popupProduct-qty-<?php echo $i; ?>" name="popupProduct_qty" size="3" value="1" />
														</div>
														<?php 
														if(!empty($product['addons'])) { 
															$addons = unserialize($product['addons']);
															foreach($addons as $addOn)
															{
																$nameArr = explode(" ",$addOn['mainaddonsname']);
																if(count($nameArr) > 1)
																{
																	$name = strtolower(implode("_",$nameArr));
																}
																else
																{
																	$name =  strtolower($addOn['mainaddonsname']);
																}
																//echo $name;
																
															?>
																<div class="row" >
																	<p><strong>Your Choice Of <?php echo $addOn['mainaddonsname']; ?></strong>(Select maximum <?php echo $addOn['mainaddoncnt']; ?> item<?php if($addOn['mainaddoncnt']>1) { ?>(s)<?php } ?>)</p>																
																	<?php foreach($addOn['subaddons'] as $singleItem) { ?>
																		
																	<div class="adon-item col-md-4"  ><label><input type="checkbox" data-index="<?php echo $i?>" data-adonName="<?php echo $name; ?>" data-adonName="<?php echo $name; ?>" data-adonCount="<?php echo $addOn['mainaddoncnt']; ?>"  class="adon-checkbox <?php echo $name; ?>" name="addOnPrice[<?php echo $name; ?>][]" value="<?php echo $singleItem['subaddonsprice']; ?>" /></label> <?php echo $singleItem['subaddonsname']; ?> [<?php echo $singleItem['subaddonsprice']; ?>]</div>
																	<?php } ?>													
																</div>
														<?php	
															}
														} ?>
																																														
													</div>
												</div>
											</div>
											<div class="modal-footer">
												<button type="button" class="btn btn-default" data-dismiss="modal">Back to menu</button>
												<button type="button" data-id="<?php echo $i; ?>" class="btn btn-default cart-addToBasketBtm"  >Add to basket</button>
											</div>
										</div>
									</div>
								</form>
								</div>																			
						<?php
						$i++; 
							}
						} ?>
					
