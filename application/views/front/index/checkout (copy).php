<?php 	$sessionData =  $this->session->userdata('locationDetail');
		$userDetail =  $this->session->userdata('userDetail');
		$cartData =  $this->cart->contents(); 
?>

<div class="container">
	<div class="breadcrumb">
		<ul>
			<li><a href="<?php echo site_url('category') ?>"><?php echo !empty($sessionData['location_city'])?$sessionData['location_city']:$sessionData['location_zipcode']; ?></a></li>
			<li><a href="<?php echo site_url('seller/'.$sessionData['category_name'])?>"><?php echo $sessionData['category_name']; ?></a></li>
			<li><a href="<?php echo site_url('area/'.$sessionData['area_id'])?>"><?php echo $sessionData['area_name']; ?></a></li>
			<li><a href="<?php echo site_url('detail/'.$sessionData['venture_id'])?>"><?php echo $sessionData['venture_name']; ?></a></li>
			<li>Checkout</li>
		</ul>
	</div>
<?php 
	if(isset($cartData) && !empty($cartData)) {  
		$cartData = $this->business_model->cart_order_by_vanture($cartData,'venture_id');
		$delivery_fee_array =  array();
		?>	
		
<form method="POST" action="<?php echo site_url('order'); ?>" >
	<div class="row" >
	
		 <div class="table-responsive">
			<table class="table">
				<tr>
					<th width="40%">Item</th>
					<th width="20%">Price</th>
					<th width="20%">Unit</th>
					<th width="20%">Amount</th>
				</tr>
<?php	if(isset($cartData[0])) { unset($cartData[0]); }
				foreach ($cartData as $venture_id=>$cart)
				{	
					if(!empty($cart))
					{
						$venture_name = $this->business_model->select_coulmn_single_value('company','gc_customers','id',$venture_id);
						$delivery_fee_res = $this->business_model->select_coulmn_single_value('delivery_fee','gc_venture_option','venture_id',$venture_id);
		
						$delivery_fee_array[] =  !empty($delivery_fee_res)?$delivery_fee_res:'0';						
						
?>				
						<tr >
							<td colspan="4" style="color:#0D8EFF" >
							<strong><?php echo $venture_name; ?></strong>
							</td>
						</tr>
						<?php foreach($cart as $singleItem) 
						{
?>		
						<tr>
							<td><?php echo $singleItem['name']; ?></td>
							<td><?php echo $singleItem['price']; ?></td>
							<td><?php echo $singleItem['qty']; ?></td>
							<td><?php echo $singleItem['subtotal']; ?> <?php echo config_item('myCurrency'); ?></td>
						</tr>										
<?php 				
						}
					} 
				}
				$delivery_fee = !empty($delivery_fee_array)?array_sum($delivery_fee_array):'0';
?>				
			<tr style="font-weight: bold;">
				<td></td>
				<td></td>
				<td>Sub total</td>
				<td><?php echo $this->cart->total(); ?> <?php echo config_item('myCurrency'); ?></td>
			</tr>
			<tr style="font-weight: bold;">
				<td></td>
				<td></td>
				<td>Delevry Fee</td>
				<td><?php echo $delivery_fee; ?> <?php echo config_item('myCurrency'); ?></td>
			</tr>			
			<tr style="font-weight: bold;">
				<td></td>
				<td></td>
				<td>Total amount</td>
				<td><?php echo $this->cart->total()+$delivery_fee; ?> <?php echo config_item('myCurrency'); ?> </td>
			</tr>			
			</table>
		</div> 
	
		
	</div>
	<div class="row" >
		<div class="col-md-6 " ></div>
		<div class="col-md-6 " >
			<div class="row" >
				<div class="col-md-6" ><label>Select Delevery Time</label></div>
				<div class="col-md-6" style="float:left" ><input type="radio" />Now</div>
			</div>
			<div class="row" >
				<div class="col-md-6" ><label>Select payment method</label></div>
				<div class="col-md-6" style="float:left" ><input checked type="radio" />Pay cash</div>
			</div>			
		</div>
	</div>
	<div class="row" >
		<div class="col-md-6 " ></div>
			<div class="col-md-6 " >
				<div class="row" >
					<div class="col-md-6" ><label>Special requiest</label></div>
					<div class="col-md-6" style="float:left" ><textarea id="text-note" placeholder="Please enter your special requiest and order detail here . You can also save your note for express use later" ></textarea></div>
				</div>
			</div>
	</div>

	<div class="row" >
		<div class="col-md-6 " ></div>	
			<div class="col-md-6 " >
				<div class="row" >
					<div class="col-md-6 " ></div>	
						<div class="col-md-6 " >
							<div class="row" >
								<div class="col-md-12 " >
									<a href="javascript:void(0)" id="btn-saveNotes">Save notes</a> <img src="<?php echo site_url(); ?>assets/front/images/email-loader.gif" style="display:none" id="email-loader" />
								</div>	
							</div>
							<div class="row" >		
								<div class="col-md-12 " >
									
									<select id="note-list" name="note_list" >
										<option value="" >Select Note</option>
										<?php if(!empty($notesData)) { 
											foreach($notesData as $notes)
											{
										?>
												<option value="<?php echo $notes['note_id'] ;?>"><?php echo $notes['note_text'] ;?></option>
										<?php } 
										} ?>	
									</select>
								</div>
							</div>	
						</div>
					</div>
				</div>	
			</div>
		
	<div class="row" >
		<div class="col-md-9 " ><p>Please check your order detail before hitting the "Place Order" button as all orders are processed immediately</p></div>
		<div class="col-md-3 " ><input type="submit"  class="checkout-placeOrderBtn" value="Place order" /></div>
	</div>		

</form>			

<?php } ?>		
</div>
<div class="clearfix"></div>
