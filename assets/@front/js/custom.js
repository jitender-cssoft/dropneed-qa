jQuery(document).ready(function(){
	height1();
	jQuery("#detail-menu-tabs").tabs();
	if(currentMethod !='area')
	{		
		jcf.replaceAll();
	}
	//alert(iso_code_2);
	if(currentClass=='index' && currentMethod =='location')
	{	
		$(".city").geocomplete({
		  
		  country: iso_code_2,
		   types:["geocode", "establishment"]
		   //types:["(cities)","geocode"]
		 
		}).bind("geocode:result", function (event, result) {
			console.log(result);
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
	
	if(currentClass=='index' && currentMethod =='area')
	{
		jQuery( "#slider-range-min" ).slider({
			range: "min",
			value: '0',
			min: 0,
			max: 100,
			slide: function( event, ui ) {
			jQuery( "#amount" ).val( "$" + ui.value );
			},
			change: function( event, ui ) {
					//alert("fff");
					//console.log(event);
					//console.log(ui.value);
					
					tringerOn_listing_leftSearchBar();
			}
			
		});
		jQuery( "#amount" ).val( "$" + jQuery( "#slider-range-min" ).slider( "value" ) );
		
		/* +++++++++++++++++++++++ */
		
		
		jQuery( "#slider" ).slider({
			min: 1,
			max: 4,
			range: "min",
			value: 4,
			slide: function( event, ui ) {
				//select[ 0 ].selectedIndex = ui.value - 1;
			},
			change: function( event, ui ) {
					//alert("fff");
					//console.log(event);
					if(ui.value==1)
						jQuery("#hid_avg_deliveryTime").val(30);
					else if(ui.value==2)
						jQuery("#hid_avg_deliveryTime").val(45);
					else if(ui.value==3)
						jQuery("#hid_avg_deliveryTime").val(60);
					else if(ui.value==4)
						jQuery("#hid_avg_deliveryTime").val('');
					
					tringerOn_listing_leftSearchBar();
			}
		});


		/* +++++++++++++++++++++++ */
		
		
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
	
});

jQuery(window).load(function() {
	jQuery("#mainLoadingdiv").fadeOut();
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


jQuery(window).resize(function(){
	height1();
});



jQuery(window).load(function() {
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
});

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

jQuery(document).on('keyup','#location-zipcode',function(){
	jQuery("#location-city").val('');
	//~ jQuery('#location-hid-locationName').val('');
	//~ jQuery('#location-hid-lat').val('');
	//~ jQuery('#location-hid-lng').val('');
});
jQuery(document).on('keyup','#location-city',function(){
	jQuery("#location-zipcode").val('');
	//~ jQuery('#location-hid-locationName').val('');
	//~ jQuery('#location-hid-lat').val('');
	//~ jQuery('#location-hid-lng').val('');	
});

jQuery(document).on('keyup change','#form-restaurant-listing-searchBox input,select',function(changeEvent){	
	//console.log(changeEvent.target.name);
	tringerOn_listing_leftSearchBar();
});

jQuery(document).on('click','.productList-plusBtn',function(){
	var index = this.id.split('-');
	index = index[2];
	var increamentValue = parseInt(jQuery("#productList-qty-"+index).val())+1 ;
	//alert(index);
	//alert(jQuery("#productList-qty-"+index).val());
	jQuery("#productList-qty-"+index).val(increamentValue);
	jQuery("#popupProduct-qty-"+index).val(increamentValue);
});

jQuery(document).on('click','.cart-addToBasketBtm',function(){

	var index = jQuery(this).attr('data-id');
	
	var formData  = jQuery("#popupProductModel-form-"+index).serializeArray();
	
	console.log(formData.addOnPrice); 
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
	 //alert(index);
    var ids = [];
		jQuery('.adon-checkbox:checked').each(function(){
		// var str = jQuery(this).prop('id');
		var val = jQuery(this).val();
		//ids[i] = str.substring(str.lastIndexOf('-')+1);
		ids[i] = val;
		i++;
    });
    
    var sum = ids.reduce(function(a, b) { return Number(a) + Number(b); }, 0);
    //alert(sum);
    var oldValue = jQuery("#product_main_price-"+index).val();
    
    var newValue = Number(sum) + Number(oldValue);
    jQuery("#productPriceLabel-"+index).html(newValue);
    jQuery("#product_price-"+index).val(newValue);
    
});

  
jQuery(document).on('click','.openAdonPupupBtn',function(){	 
	var index = jQuery(this).attr('data-index');
	jQuery("#popupProductModel-form-"+index)[0].reset();
});

jQuery(document).on('click','.clear-cart-basket',function(){	 
		
	var formData  = {type:'clear'};
	 
	var extendedUrl="index/clear_cart_item";
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



function tringerOn_listing_leftSearchBar()
{
	//jQuery("#hid-load_more").val(0);
	var formData  = jQuery("#form-restaurant-listing-searchBox").serializeArray();
	// console.log(formData); 
	var extendedUrl="/restaurantList_searchBy";
	var base_url = (BASE_URL) ? BASE_URL+currentClass : '';		
		//jQuery("#mainLoadingdiv").fadeIn('slow');
	//	var response=callAjax(formData,extendedUrl,base_url);


jQuery(".restaurant_list-ajaxSection").html('<div class="list-loader" ><img src="'+BASE_URL+'assets/front/images/list-loader.gif" /></div>');
	jQuery.ajax({
		url: base_url + extendedUrl,
		type: "POST",
		datatype: 'json',
		data: formData,
		beforeSend: function () {
		  //   alert(jsonEncode);
		  jQuery(".restaurant_list-ajaxSection").html('<div class="list-loader" ><img src="'+BASE_URL+'assets/front/images/list-loader.gif" /></div>');
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
			
				//jQuery("#mainLoadingdiv").fadeOut();		
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
			
		}
		
	});
}


function 	clearThisFilter(id)
{
	
	if(id=='restaurant-restaurantName' || id== 'all')
	{
		jQuery("#restaurant-restaurantName").val('');
	
		
	}
	if(id== 'listing_delivery_area' || id== 'all')
	{
		jQuery("#listing_delivery_area option:first-child").prop("selected", true);
		//jQuery("#listing_delivery_area option:first-child").attr("value", 'tt')
		
	}
	if(id== 'amount' || id== 'all')
	{
				jQuery( "#slider-range-min" ).slider({
			range: "min",
			value: '0',
			min: 0,
			max: 100,
			slide: function( event, ui ) {
			jQuery( "#amount" ).val( "$" + ui.value );
			},
			change: function( event, ui ) {
					//alert("fff");
					//console.log(event);
					console.log(ui.value);
					
					tringerOn_listing_leftSearchBar();
			}
			
		});
		jQuery( "#amount" ).val( "$" + jQuery( "#slider-range-min" ).slider( "value" ) );
	}
	if(id== 'hid_avg_deliveryTime' || id== 'all')
	{
		jQuery( "#hid_avg_deliveryTime" ).val('');
		

		jQuery( "#slider" ).slider({
			min: 1,
			max: 4,
			range: "min",
			value: 4,
			slide: function( event, ui ) {
				//select[ 0 ].selectedIndex = ui.value - 1;
			},
			change: function( event, ui ) {
					//alert("fff");
					//console.log(event);
					if(ui.value==1)
						jQuery("#hid_avg_deliveryTime").val(30);
					else if(ui.value==2)
						jQuery("#hid_avg_deliveryTime").val(45);
					else if(ui.value==3)
						jQuery("#hid_avg_deliveryTime").val(60);
					else if(ui.value==4)
						jQuery("#hid_avg_deliveryTime").val('');
					
					tringerOn_listing_leftSearchBar();
			}
		});		
	}
	if(id == 'listing_payment_method' || id== 'all')
	{
		jQuery("#listing_payment_method option:first-child").prop("selected", true);
	}
	if(id== 'cuisine_fav' || id== 'all')
	{
		jQuery(".cuisine_fav").prop( "checked", false );
	}
	if(id== 'selected_rating' || id== 'all')
	{
		jQuery("#selected_rating").val('');
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
	}	
		
	tringerOn_listing_leftSearchBar();	
}
	

function loadmore()
{
	jQuery("#hid-load_more").val('1');
	alert(jQuery("#hid-load_more").val());
	//tringerOn_listing_leftSearchBar();
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
	  //   alert(jsonEncode);
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
	if(jQuery("#seller-areaName").val() != "")
	{
		window.location=BASE_URL+"area/"+jQuery("#seller-areaName").val();
	}
}

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
