jQuery(window).resize(function(){
	height1();
});

jQuery(window).load(function() {
	jQuery("#mainLoadingdiv").fadeOut();
	jQuery("#flexisel").show();
});

jQuery(document).ready(function(){
	/* common controller */
	height1();
	jQuery('.numbersOnly').keyup(function () { 
		this.value = this.value.replace(/[^0-9\.]/g,'');
	});		
	
	jcf.replaceAll();
	
	jQuery("#flexisel").hide();
	
	/* Footer controller */		
	jQuery("#flexisel").flexisel({
        visibleItems: 7,
        animationSpeed: 1000,
        autoPlay: true,
		clone:false,
        autoPlaySpeed: 3000,            
        pauseOnHover: true,
        enableResponsiveBreakpoints: true,
        responsiveBreakpoints: { 
            portrait: { 
                changePoint:480,
                visibleItems: 1
            }, 
            landscape: { 
                changePoint:640,
                visibleItems: 3
            },
            tablet: { 
                changePoint:768,
                visibleItems: 5
            }
        }
    });  	
		
	/* Area controller */
	if(currentClass=='index' && currentMethod =='area')
	{		
		

		/* Amount range */
		var tooltipRange = jQuery('<div id="tooltip" class="arrow-bg">0</div>').css({position: 'absolute',top: -30,left: -7});
		jQuery( "#slider-range-min" ).slider({
			range: "min",
			value: '0',
			min: 0,
			max: 100,
			slide: function( event, ui ) {
			jQuery( "#amount" ).val( "$" + ui.value );
			 tooltipRange.text(ui.value);
			},
			change: function( event, ui ) {
				tringerOn_listing_leftSearchBar();
			}
		}).find(".ui-slider-handle").append(tooltipRange).hover(function() {
			tooltipRange.show()
		});
		jQuery( "#amount" ).val( "$" + jQuery( "#slider-range-min" ).slider( "value" ) );
		
		callbackAvgTimeSlider('init');
		/* ratting range */
		jQuery( "#ratingSlider" ).slider({
			min: 0,
			max: 5,
			range: "min",
			value: 0,
			slide: function( event, ui ) {
				//select[ 0 ].selectedIndex = ui.value - 1;
			},
			change: function( event, ui ) {
				if(ui.value==0)
					jQuery("#selected_rating").val('');
				else					
					jQuery("#selected_rating").val(ui.value);					
					
				tringerOn_listing_leftSearchBar();
				
			}
		}).find(".ui-slider-handle").append(tooltip).hover(function() {
			tooltip.show()
		});	
	}
	
	/* Seller controller */
	jQuery("#cityName").geocomplete();
	/* location controller */		
	if(currentClass=='index' && currentMethod =='location')
	{	
		jQuery(".city").geocomplete({
		  
		  country: iso_code_2,
		   types:["geocode", "establishment"]
		   //types:["(cities)","geocode"]
		 
		}).bind("geocode:result", function (event, result) {
			//console.log(result);
			//$.log("Result: " + result.formatted_address);
			//console.log("Result: " + result.formatted_address);
			jQuery("#location-hid-locationName").val(result.formatted_address);
		})
		.bind("geocode:error", function (event, status) {
			//console.log("ERROR: " + status);
		})
		.bind("geocode:multiple", function (event, results) {
		   //console.log("Multiple: " + results.length + " results found");
		}).bind("geocode:result", function (event, result) {						
				//console.log(result.geometry.location.lat());
				jQuery("#location-hid-lat").val(result.geometry.location.lat());
				//console.log(result.geometry.location.lng());
				jQuery("#location-hid-lng").val(result.geometry.location.lng());
				//console.log(result);
		});
	}
	
	/* myAccount controller */
	jQuery( "#myAccountTabs" ).tabs().addClass( "ui-tabs-vertical ui-helper-clearfix" );
    jQuery( "#myAccountTabs li" ).removeClass( "ui-corner-top" ).addClass( "ui-corner-left" );
    
   /* Detail controller */
	jQuery('#horizontalTab').responsiveTabs({
		active: 0,
		startCollapsed: 'accordion',
		collapsible: 'accordion',
		rotate: false,
		setHash: true
	});
	
	//~ jQuery( ".imageEnlargeModel" ).dialog({
      //~ autoOpen: false,
      //~ show: {
        //~ effect: "blind",
        //~ duration: 1000
      //~ },
      //~ hide: {
        //~ effect: "explode",
        //~ duration: 1000
      //~ }
    //~ });	
	
});
	
/* Seller page Map */
if(currentClass=='index' && currentMethod =='seller')
{
	/* Map on page load */
	var centerLat = sellerMap_lat;
	var centerLng = sellerMap_lng;
	function initialize() {
		//alert(centerLat+" "+centerLng);
		var mapProp = {
			center:new google.maps.LatLng(centerLat,centerLng),
			zoom:14,
			mapTypeId:google.maps.MapTypeId.ROADMAP
		};
		var map=new google.maps.Map(document.getElementById("dvMap"),mapProp);
	}
	google.maps.event.addDomListener(window, 'load', initialize);
	/* Map on page load */
	    //~ $(function(){
		//~ var options = {
        //~ map: ".map",
        //~ details: "form ",
        //~ markerOptions: {
        //~ draggable: true
        //~ }
        //~ };
        //~ 
        //~ $(".cityMap").geocomplete(options);
		//~ 
		//~ });
		/* Area textbox autocomplete */
		jQuery(".cityMap").geocomplete({
			//types: ['(cities)']
			country: iso_code_2,
			types:["geocode", "establishment"]
		}).bind("geocode:result", function (event, result) {
			//console.log(result);
			//$.log("Result: " + result.formatted_address);
			//console.log("Result: " + result.formatted_address);
			jQuery("#location-hid-locationName").val(result.formatted_address);
		})
		.bind("geocode:error", function (event, status) {
			//console.log("ERROR: " + status);
		})
		.bind("geocode:multiple", function (event, results) {
			//console.log("Multiple: " + results.length + " results found");
		})
		.bind("geocode:result", function (event, result) {						
			//console.log(result.geometry.location.lat());
			jQuery("#location-hid-lat").val(result.geometry.location.lat());
			//console.log(result.geometry.location.lng());
			jQuery("#location-hid-lng").val(result.geometry.location.lng());
			//console.log(result);
		});
 
}

/* Location controller */
jQuery(document).on('keyup','#location-zipcode',function(){
	jQuery("#location-city").val('');
});
jQuery(document).on('keyup','#location-city',function(){
	jQuery("#location-zipcode").val('');	
});
/* Seller controller */
jQuery(document).on('change','#seller-areaName',function(){
	var lat = jQuery(this).find(':selected').attr('data-lat');
	var lng = jQuery(this).find(':selected').attr('data-lng');
	var text = jQuery(this).find("option:selected").text();
	jQuery("#seller-hid-lat").val(lat);
	jQuery("#seller-hid-lng").val(lng);
	jQuery("#seller-hid-locationName").val(text);
	
});

/* Area controller */
jQuery(document).on('keyup','#form-restaurant-listing-searchBox input',function(changeEvent){	
	//console.log(changeEvent);
	tringerOn_listing_leftSearchBar();
	
});
jQuery(document).on('change','#form-restaurant-listing-searchBox input[type=checkbox]',function(changeEvent){	
	//console.log(changeEvent);
	tringerOn_listing_leftSearchBar();
	
});
jQuery(document).on('change','#form-restaurant-listing-searchBox select',function(changeEvent){	
	//console.log(changeEvent);
	tringerOn_listing_leftSearchBar();
	
});
jQuery(document).on('hover focus click','.dropdown-menu',function(){
	jQuery(".cart-dropdown").show();
});
jQuery(document).on('click','#seeAllCuisinesLink',function(){
	
	jQuery("#seeAllCuisinesLink").hide();
	jQuery(".allCuisine").show();
});

//~ jQuery(document).on('mouseover','.white-wrapper',function(){
	//~ jQuery('.filter a').focus();
//~ });

/* Detail controller */
jQuery(document).on('click','.productList-plusBtn',function(){
	//~ var index = this.id.split('-');
	//~ index = index[2];
	//~ var increamentValue = parseInt(jQuery("#productList-qty-"+index).val())+1 ;
	//~ 
	//~ 
	//~ jQuery("#productList-qty-"+index).val(increamentValue);
	//~ var value = parseInt(increamentValue);
	//~ alert(value +' '+ index);
	//~ jQuery("#popupProduct-qty-"+index).val(value);
});
jQuery(document).on('click','.cart-addToBasketBtm',function(){

	var index = jQuery(this).attr('data-id');
	
	var formData  = jQuery("#popupProductModel-form-"+index).serializeArray();
	
	 
	var extendedUrl="index/ajax_add_to_cart";
	var base_url = (BASE_URL) ? BASE_URL : '';	
	var response = callAjax(formData, extendedUrl, base_url) ;
	jQuery(".productPage-cartSection").html('<div class="cart-loader" ><img src="'+BASE_URL+'assets/front/images/cartLoader.gif" /></div>');
	response.success(function (data) {
            var obj=JSON.parse(data); 
			jQuery(".productPage-cartSection").html(obj.cartBoxHtml);
			jQuery('#myModal-'+index).modal('hide');
    });	
});
jQuery(document).on('click','.adon-checkbox',function(){
	
	var i = 0;
	var index = jQuery(this).attr('data-index');
	var adonName = jQuery(this).attr('data-adonName');
	var adonCount = jQuery(this).attr('data-adonCount');
	//alert(index+' '+adonName+' '+adonCount);
	//alert(jQuery('.adon-checkbox.'+adonName+':checked').length);
		 
	if (jQuery('.adon-checkbox.'+adonName+':checked').length <= adonCount) {
		var ids = [];
			jQuery('.adon-checkbox:checked').each(function(){
			// var str = jQuery(this).prop('id');
			var val = jQuery(this).val();
			//ids[i] = str.substring(str.lastIndexOf('-')+1);
			ids[i] = val;
			i++;
		});
		
		var sum = ids.reduce(function(a, b) { return Number(a) + Number(b); }, 0);
		var oldValue = jQuery("#product_main_price-"+index).val();
		var newValue = Number(sum) + Number(oldValue);
			
		var price = myCurrency+''+newValue.toFixed(2);
			
		jQuery("#productPriceLabel-"+index).html(price);
		jQuery("#product_price-"+index).val(newValue); 
		/*validation */
		//alert(jQuery('.adon-checkbox.'+adonName+':checked').length);
	}
	else
	{
			
			//jQuery.notify('You can select maximum '+adonCount+' item', "info");
			jQuery("#addOnPopUPError-"+index).show(function(){
					jQuery("#addOnPopUPError-"+index).html('You can select maximum '+adonCount+' item');
					setTimeout(function(){ jQuery("#addOnPopUPError-"+index).fadeOut('slow'); }, 3000);
			});
			jQuery(this).prop( "checked", false );
	}
    
});
jQuery(document).on('click','.openAdonPupupBtn',function(){	 
	var index = jQuery(this).attr('data-index');
	jQuery("#popupProductModel-form-"+index)[0].reset();
	jQuery("#product_price-1-"+index).val(jQuery("#product_main_price-"+index).val());
	var price = jQuery("#product_main_price-"+index).val();
	var price1 = myCurrency+''+price;
	jQuery("#productPriceLabel-"+index).html(price1);
});
jQuery(document).on('click','.clear-cart-basket',function(){	 
		
	var formData  = {type:'clear'};
	 
	var extendedUrl="index/ajax_clear_cart_item";
	var base_url = (BASE_URL) ? BASE_URL : '';	
	var response = callAjax(formData, extendedUrl, base_url) ;
	jQuery(".productPage-cartSection").html('<div class="cart-loader" ><img src="'+BASE_URL+'assets/front/images/cartLoader.gif" /></div>');
	response.success(function (data) {
			var obj=JSON.parse(data); 
			jQuery(".productPage-cartSection").html(obj.cartBoxHtml);
			jQuery('#myModal-'+index).modal('hide');
    });		
});
jQuery(document).on('keyup','.productPage-cartSection .cart-qty',function(){
	var numbers = /^[0-9]+$/;  /* For mobile number */
	if(this.value.match(numbers)) {	
		var index = this.id;
		index =  index.split('-');
		var rowId = index[2];
		var formData  = {rowid:rowId,qty:this.value};
		 
		var extendedUrl="index/ajax_update_cart_item";
		var base_url = (BASE_URL) ? BASE_URL : '';	
		var response = callAjax(formData, extendedUrl, base_url) ;
		jQuery(".productPage-cartSection").html('<div class="cart-loader" ><img src="'+BASE_URL+'assets/front/images/cartLoader.gif" /></div>');
		response.success(function (data) {
				var obj=JSON.parse(data); 
				jQuery(".productPage-cartSection").html(obj.cartBoxHtml);
				jQuery('#myModal-'+index).modal('hide');
		});
	}
});

jQuery(document).on('click','.productPage-cartSection .cart-deleteItem',function(){
	var index = this.id;
	index =  index.split('-');
	var rowId = index[2];
	var formData  = {rowid:rowId};
	
	var extendedUrl="index/ajax_delete_cart_item";
	var base_url = (BASE_URL) ? BASE_URL : '';	
	var response = callAjax(formData, extendedUrl, base_url) ;
	jQuery(".productPage-cartSection").html('<div class="cart-loader" ><img src="'+BASE_URL+'assets/front/images/cartLoader.gif" /></div>');

	response.success(function (data) {
            var obj=JSON.parse(data); 
			jQuery(".productPage-cartSection").html(obj.cartBoxHtml);
			jQuery('#myModal-'+index).modal('hide');
    });
});

jQuery(document).on('click','.product-catType li',function(){
	jQuery('.product-catType li').removeClass('active');
	jQuery(this).addClass('active');
	var type = jQuery(this).attr('data-type');
	var name = jQuery(this).html();
	var venture_id = jQuery("#productPage_venture_id").val();
	tab_product_listing(venture_id,type,name);	
});

jQuery(document).on('mouseover','.imageEnlargeModelLink',function(){
	jQuery( ".imageEnlargeModel" ).show();
});

jQuery(document).on('mouseout','.imageEnlargeModelLink',function(){
	jQuery( ".imageEnlargeModel" ).hide();
});

/* Checkout controller */
jQuery(document).on('click','#btn-saveNotes',function(){
	
	if(jQuery('#text-note').val() != '')
	{
		var formData  = {note:jQuery('#text-note').val()};
		jQuery("#email-loader").show();
		var extendedUrl="index/ajax_insertNewNote";
		var base_url = (BASE_URL) ? BASE_URL : '';	
		var response = callAjax(formData, extendedUrl, base_url) ;
		response.success(function (data) {
			var obj=JSON.parse(data);
			var inserted_id = obj.id;
			var _option = '<option value="'+inserted_id+'">'+jQuery('#text-note').val()+'</option>';
			jQuery('#note-list').append(_option);
			  
			//jQuery('#text-note').val('');
			jQuery("#email-loader").hide();
			jQuery.notify("Your note saved successfully", "success");
			
		});			
	}
	else
	{
		jQuery('#text-note').focus()
	}
});

jQuery(document).on('change','#note-list',function(){
	if(this.value !='')
	{
		var thisvalue = jQuery(this).find("option:selected").text();
		jQuery('#text-note').val(thisvalue);
	}
	else
	{
		jQuery('#text-note').val('');
	}
});
/* Register controller */
jQuery(document).on('keyup','#form-register #email',function(){
	
	var formData  = {email:this.value};
	var email = this.value;
	var re = /^(([^<>()[\]\\.,;:\s@\"]+(\.[^<>()[\]\\.,;:\s@\"]+)*)|(\".+\"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
    var chk_val = re.test(email);
    if(chk_val==true)
    {
		var extendedUrl="index/ajax_checkValideEmail";
		var base_url = (BASE_URL) ? BASE_URL : '';	
		var response = callAjax(formData, extendedUrl, base_url) ;
		jQuery("#email-loader").show();

		response.success(function (data) {
			var obj=JSON.parse(data); 
			if(obj.emailValidStatus=='N')
			{
				jQuery("#errorMsg").html('Email address already exist');
				jQuery("#errorMsg").show(function(){	setTimeout(function(){ jQuery("#errorMsg").fadeOut('slow'); }, 3000); 	});
			}
			jQuery("#email-loader").hide();
			//jQuery('#myModal-'+index).modal('hide');
		});
	}
});
/* Forgot controller */
jQuery(document).on('keyup','#form-forgot #email',function(){
	
	jQuery('#forgotSubmitBtn').attr('disabled',true);
	jQuery('#forgotSubmitBtn').addClass('disabled');
	var formData  = {email:this.value};
	var email = this.value;
	if(email=='')
	{
		jQuery('#forgotSubmitBtn').attr('disabled',false);
		jQuery('#forgotSubmitBtn').removeClass('disabled');
	}

	var re = /^(([^<>()[\]\\.,;:\s@\"]+(\.[^<>()[\]\\.,;:\s@\"]+)*)|(\".+\"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
    var chk_val = re.test(email);
    if(chk_val==true)
    {
		var extendedUrl="index/ajax_checkValideEmail";
		var base_url = (BASE_URL) ? BASE_URL : '';	
		var response = callAjax(formData, extendedUrl, base_url) ;
		jQuery("#email-loader").show();

		response.success(function (data) {
			var obj=JSON.parse(data); 
			if(obj.emailValidStatus=='Y')
			{
				jQuery("#errorMsg").html('Email address does not exist');
				jQuery("#errorMsg").show(function(){	setTimeout(function(){ jQuery("#errorMsg").fadeOut('slow'); }, 3000); 	});
				jQuery('#forgotSubmitBtn').attr('disabled',true);
				jQuery('#forgotSubmitBtn').addClass('disabled');
			}
			else
			{
				jQuery("#errorMsg").hide();
				jQuery('#forgotSubmitBtn').attr('disabled',false);
				jQuery('#forgotSubmitBtn').removeClass('disabled');
			}
			jQuery("#email-loader").hide();
			//jQuery('#myModal-'+index).modal('hide');
		});
	}
	
});

function callbackAvgTimeSlider(type)
{
	console.log("fff");
	/* Delivery time range */
		var tooltipAVGRange = jQuery('<div id="tooltip" class="arrow-bg"class="arrow-bg" >0</div>').css({position: 'absolute',top: -30,left: -7});
		jQuery( "#slider" ).slider({
			min: 1,
			max: 4,
			range: "min",
			value: 4,
			slide: function( event, ui ) {
				tooltipAVGRange.text(ui.value);
			},
			create: function( event, ui ) {  tooltipAVGRange.text('All'); },
			change: function( event, ui ) {
					if(ui.value==1)
					{
						jQuery("#hid_avg_deliveryTime").val(30);
						 tooltipAVGRange.text('30');
					}
					else if(ui.value==2)
					{
						jQuery("#hid_avg_deliveryTime").val(45);
						tooltipAVGRange.text('45');
					}
					else if(ui.value==3)
					{
						jQuery("#hid_avg_deliveryTime").val(60);
						tooltipAVGRange.text('60');
					}
					else if(ui.value==4)
					{
						jQuery("#hid_avg_deliveryTime").val('');
						tooltipAVGRange.text('All');
					}
					
					if(type=='init')
					{
						tringerOn_listing_leftSearchBar();
					}
			}
		}).find(".ui-slider-handle").append(tooltipAVGRange).hover(function() {
			tooltipAVGRange.show()
		});
		
}

/* Location controller */
function validate_location_selection()
{	
	if(jQuery("#location-city").val().trim() == '' )
	{
		jQuery("#location-city").focus();
		//jQuery("#location-zipcode").addClass('error');
		return false;
	}
	else if(jQuery("#location-hid-locationName").val().trim() == '')
	{	
		jQuery("#location-alert").html('<strong>Warrning ! <stronng>Please select valid address on zipcode from list.');
		jQuery("#location-alert").show(function(){
			setTimeout(function(){ jQuery("#location-alert").fadeOut('slow'); }, 3000);
		})
		return false;
	}
}
/* Register controller */
function validate_signupForm()
{
	var re = /^(([^<>()[\]\\.,;:\s@\"]+(\.[^<>()[\]\\.,;:\s@\"]+)*)|(\".+\"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
    var chk_val = re.test(jQuery("#email").val());
	var pattern = /^\d{10}$/; /* For mobile number */
	
	if(jQuery("#name").val().trim()=='')
	{	jQuery("#name").focus();	jQuery("#errorMsg").html('Please enter name');	jQuery("#errorMsg").show(function(){	setTimeout(function(){ jQuery("#errorMsg").fadeOut('slow'); }, 3000); 	});	return false;		}
	else if(jQuery("#surname").val().trim()=='')
	{	jQuery("#surname").focus();	jQuery("#errorMsg").html('Please enter surname');	jQuery("#errorMsg").show(function(){	setTimeout(function(){ jQuery("#errorMsg").fadeOut('slow'); }, 3000); 	});	return false;	}
	else if(jQuery("#email").val().trim()=='')
	{	jQuery("#email").focus();	jQuery("#errorMsg").html('Please enter email');		jQuery("#errorMsg").show(function(){	setTimeout(function(){ jQuery("#errorMsg").fadeOut('slow'); }, 3000); 	});		return false;	}
	else  if (chk_val == false)
    {	jQuery("#email").focus();	jQuery("#errorMsg").html('Please enter valid email');		jQuery("#errorMsg").show(function(){	setTimeout(function(){ jQuery("#errorMsg").fadeOut('slow'); }, 3000); 	});	return false;	}
	else if(jQuery("#password").val().trim()=='')
	{	jQuery("#password").focus();	jQuery("#errorMsg").html('Please enter password');	jQuery("#errorMsg").show(function(){	setTimeout(function(){ jQuery("#errorMsg").fadeOut('slow'); }, 3000); 	});		return false;	}	
	else if(jQuery("#confirm_password").val().trim()=='')
	{	jQuery("#confirm_password").focus();	jQuery("#errorMsg").html('Please enter confirm password');		jQuery("#errorMsg").show(function(){	setTimeout(function(){ jQuery("#errorMsg").fadeOut('slow'); }, 3000); 	});		return false;	}	
	else if(jQuery("#password").val().trim() != jQuery("#confirm_password").val().trim())
	{	jQuery("#confirm_password").focus();	jQuery("#errorMsg").html('Password and confirm password does not match');	jQuery("#errorMsg").show(function(){	setTimeout(function(){ jQuery("#errorMsg").fadeOut('slow'); }, 3000); 	});		return false;	}
	else if(jQuery("#cityName").val().trim()=='')
	{	jQuery("#cityName").focus();	jQuery("#errorMsg").html('Please enter city');		jQuery("#errorMsg").show(function(){	setTimeout(function(){ jQuery("#errorMsg").fadeOut('slow'); }, 3000); 	});		return false;	}	
	else if(jQuery("#mobile_number").val().trim()=='')
	{	jQuery("#mobile_number").focus();	jQuery("#errorMsg").html('Please enter mobile number');		jQuery("#errorMsg").show(function(){	setTimeout(function(){ jQuery("#errorMsg").fadeOut('slow'); }, 3000); 	});		return false;	}
	else  if(!pattern.test(mobile)) {	jQuery("#mobile_number").focus();	jQuery("#errorMsg").html('Please enter 10 digit number');	jQuery("#errorMsg").show(function(){	setTimeout(function(){ jQuery("#errorMsg").fadeOut('slow'); }, 3000); 	});	return false;	}	
}
/* Forgot controller */
function validate_forgot()
{
	var re = /^(([^<>()[\]\\.,;:\s@\"]+(\.[^<>()[\]\\.,;:\s@\"]+)*)|(\".+\"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
    var chk_val = re.test(jQuery("#email").val());	
	if(jQuery("#email").val().trim()=='')
	{	jQuery("#email").focus();	jQuery("#errorMsg").html('Please enter email');	jQuery("#errorMsg").show(function(){	setTimeout(function(){ jQuery("#errorMsg").fadeOut('slow'); }, 3000); 	});		return false;	}
	else  if (chk_val == false)
    {	jQuery("#email").focus();	jQuery("#errorMsg").html('Please enter valid email');	jQuery("#errorMsg").show(function(){	setTimeout(function(){ jQuery("#errorMsg").fadeOut('slow'); }, 3000); 	});		return false;	}	
}
/* ResetPassword controller */
function validate_resetPass()
{
	if(jQuery("#password").val().trim()=='')
	{	jQuery("#password").focus();	jQuery("#errorMsg").html('Please enter password');	jQuery("#errorMsg").show(function(){	setTimeout(function(){ jQuery("#errorMsg").fadeOut('slow'); }, 3000); 	});	return false;	}	
	else if(jQuery("#confirm_password").val().trim()=='')
	{	jQuery("#confirm_password").focus();	jQuery("#errorMsg").html('Please enter confirm password');	jQuery("#errorMsg").show(function(){	setTimeout(function(){ jQuery("#errorMsg").fadeOut('slow'); }, 3000); 	});		return false;	}	
	else if(jQuery("#password").val().trim() != jQuery("#confirm_password").val().trim())
	{	jQuery("#confirm_password").focus();	jQuery("#errorMsg").html('Password and confirm password does not match');	jQuery("#errorMsg").show(function(){	setTimeout(function(){ jQuery("#errorMsg").fadeOut('slow'); }, 3000); 	});		return false;	}
}

function tringerOn_listing_leftSearchBar()
{
	var formData  = jQuery("#form-restaurant-listing-searchBox").serializeArray();
	var extendedUrl="/restaurantList_searchBy";
	var base_url = (BASE_URL) ? BASE_URL+currentClass : '';		
	jQuery(".ventureLisingLoader").show();
	//jQuery(".restaurant_list-ajaxSection").html('<div class="list-loader" ><img src="'+BASE_URL+'assets/front/images/list-loader.gif" /></div>');
	jQuery.ajax({
		url: base_url + extendedUrl,
		type: "POST",
		datatype: 'json',
		data: formData,
		beforeSend: function () {
		  //   alert(jsonEncode);
		  //jQuery(".restaurant_list-ajaxSection").html('<div class="list-loader" ><img src="'+BASE_URL+'assets/front/images/list-loader.gif" /></div>');
		},
		success: function (data) {

			var obj=JSON.parse(data);
			if(obj.hasRecordStatus=='Y')
			{
				jQuery(".restaurant_list-ajaxSection").html('');
				if(jQuery("#hid-load_more").val()==1)
				{
					jQuery(".restaurant_list-ajaxSection").append(obj.html);	
				}else {
					jQuery(".restaurant_list-ajaxSection").html(obj.html);	
				}
				//jQuery(".restaurant_list-ajaxSection").append(obj.qry);	
				jQuery("#hid-load_more").val(0);
				jQuery("#hid_ofset").val(obj.ofset);
				jQuery("#hid_limit").val(obj.limit);
			}
			else
			{
				jQuery(".restaurant_list-ajaxSection").html('<h3>List not found</h3>');
				//jQuery(".restaurant_list-ajaxSection").append(obj.qry);	
			}
			jQuery("#filter-action-area").html(obj.filterChecksHTML);
			jQuery(".ventureLisingLoader").fadeOut();
		}
	});
}
/* Area controller */
function clearThisFilter(id)
{
	
	if(id=='restaurant-restaurantName' || id== 'all')	{	jQuery("#restaurant-restaurantName").val('');	}
	if(id== 'listing_delivery_area' || id== 'all')	{
		jQuery("#listing_delivery_area option:first-child").prop("selected", true);		
		jQuery("#listing_delivery_area").next("span").find("span").html("Select Delivery area"); 
		
	}
	if(id== 'amount' || id== 'all')
	{
		/* Amount range */
		jQuery( "#amount" ).val( "$0"); 
		var tooltipRange = jQuery('<div id="tooltip" class="arrow-bg">0</div>').css({position: 'absolute',top: -30,left: -7});
		tooltipRange.text('0');
		jQuery( "#slider-range-min" ).slider("destroy");
		jQuery( "#slider-range-min" ).slider({
			range: "min",
			value: '0',
			min: 0,
			max: 100,
			slide: function( event, ui ) {
			jQuery( "#amount" ).val( "$" + ui.value );
			 tooltipRange.text(ui.value);
			},
			change: function( event, ui ) {
				tringerOn_listing_leftSearchBar();
				console.log("ssss");
			}
		}).find(".ui-slider-handle").append(tooltipRange).hover(function() {
			tooltipRange.show()
		});
		//jQuery( "#amount" ).val( "$" + jQuery( "#slider-range-min" ).slider( "value" ) );
	}
	if(id== 'hid_avg_deliveryTime' || id== 'all')
	{
		jQuery( "#hid_avg_deliveryTime" ).val('');
		/* Delivery time range */
		var tooltipAVGRange = jQuery('<div id="tooltip" class="arrow-bg"class="arrow-bg" >0</div>').css({position: 'absolute',top: -30,left: -7});
		tooltipAVGRange.text('All');
		
		callbackAvgTimeSlider('init');
	}
	if(id == 'listing_payment_method' || id== 'all')
	{
		jQuery("#listing_payment_method option:first-child").prop("selected", true);
		jQuery("#listing_payment_method").next("span").find("span").html("Select Payment method"); 
	}
	if(id== 'cuisine_fav' || id== 'all')
	{
		jQuery(".cuisine_fav").prop( "checked", false );
	}
	if(id== 'selected_rating' || id== 'all')
	{
		jQuery("#selected_rating").val('');
		jQuery( "#ratingSlider" ).slider("destroy");
		jQuery( "#ratingSlider" ).slider({
			min: 0,
			max: 5,
			range: "min",
			value: 0,
			slide: function( event, ui ) {
				//select[ 0 ].selectedIndex = ui.value - 1;
			},
			change: function( event, ui ) {
				if(ui.value==0)
					jQuery("#selected_rating").val('');
				else					
					jQuery("#selected_rating").val(ui.value);					
					
				tringerOn_listing_leftSearchBar();
			}
		});
	}

	if(id== 'now_open' || id== 'all')
	{
		jQuery("#now_open").prop( "checked", false );
	}	

	if(id== 'with_promotion' || id== 'all')
	{
		jQuery("#with_promotion").prop( "checked", false );
	}	

	if(id== 'delivery_fee' || id== 'all')
	{
		jQuery("#delivery_fee option:first-child").prop("selected", true);
		jQuery("#delivery_fee").next("span").find("span").html("ALL"); 
	}		
	
	tringerOn_listing_leftSearchBar();	
	 
}
	

function loadmore()
{
	jQuery("#hid-load_more").val('1');
	alert(jQuery("#hid-load_more").val());
}

function changeOrder(type)
{
	if(type=='Alfabet')
	{
		if(jQuery("#hid-sort-order").val() == "asc")
		{
			jQuery("#hid-sort-order").val('desc');
			jQuery("#orderStatment").html('Z-A');
		}
		else
		{
			jQuery("#hid-sort-order").val('asc');
			jQuery("#orderStatment").html('A-Z');
		}
		tringerOn_listing_leftSearchBar();
	}
	
		
}

/* Common */
function callAjax(jsonEncode, extendUrl, useBaseUrl) {
  
  var base_url = (useBaseUrl) ? useBaseUrl : '';
  var returnData = '';
  // alert("site url"+jQuery('#controllerName').val());  
  return jQuery.ajax({
	  url: base_url + extendUrl,
	  type: "POST",
	  datatype: 'json',
	  data: jsonEncode,
	  beforeSend: function () {
	  
	  jQuery('.loader').show();
	  },
	  success: function (data) {
		jQuery('.loader').fadeOut();
	  }
  });
}

function height1(){
	var he1= $(window).height(); 
	var wd=jQuery(window).width();
	
	if(wd > 1024)
	{
		cc= he1- 200;           
		jQuery(".carousel-inner img").height(cc);
	}
	else{}
}

function action_areaSelection()
{
	if(jQuery("#seller-areaName").val() == "")
	{
		jQuery("#seller-areaName").focus();
		return false;
		//window.location=BASE_URL+"area/"+jQuery("#seller-areaName").val();
	}
}
/* Detail controller */
function tab_product_listing(venture_id,type,name)	
{
	var formData  = {venture_id:venture_id,selected_type:type,headingName:name};
	var extendedUrl="index/ajax_tab_product_listing";
	var base_url = (BASE_URL) ? BASE_URL : '';	
	var response = callAjax(formData, extendedUrl, base_url) ;
	jQuery(".product-listing-section").html('<div class="productlist-loader" ><img src="'+BASE_URL+'assets/front/images/productLoader.gif" /></div>');
	response.success(function (data) {
            var obj=JSON.parse(data); 
			jQuery(".product-listing-section").html(obj.productBoxHtml);
			
    });
}

function checkAddonCount(addOnName,totalCount)
{
	if (jQuery('.adon-checkbox.'+addOnName+'.input[type=checkbox]:checked').length > totalCount) {		
		jQuery.notify("Not Allowed", "info");
	}
}
