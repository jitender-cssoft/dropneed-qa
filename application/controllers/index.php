<?php

/**
 * Class for Default module action reques handling
 *
 * This class is designed for handling default module actions
 * 
 * @package    Default
 * @author     Mujaffar S added on 11 July 2015
 */
class Index extends Cs_Front_Controller {

    var $customer;

    function __construct() {
        parent::__construct();
        $this->load->model(array('location_model','page_model','business_model'));
        $this->load->database();
        $this->load->library('cart');
        $this->load->library('session');
        $this->load->library('customemail');
        $this->customer = $this->mp_cart->customer();
		$currentClass =  $this->router->fetch_class();
		$currentMethod =  $this->router->fetch_method();
		
		$sessionData =  $this->session->userdata('locationDetail');
		if(isset($sessionData['location_hid_country_id']))
		{
			$currencyName = $this->business_model->get_country_currency($sessionData['location_hid_country_id'],'currencySymbol');
			$this->config->set_item('myCurrency', $currencyName);
			$this->config->set_item('myCountryId', $currencyName);
			//echo 'test'.  $this->config->item('myCurrency');	
		}
		$userDetail = $this->session->userdata('userDetail');
		if(isset($userDetail) && !empty($userDetail))
			$this->config->set_item('isLogin', 'YES');	
		else
			$this->config->set_item('isLogin', 'NO');	
			
		//echo "<pre>"; print_r($sessionData); echo "</pre>";	
			
    }

	public function index() {			
		
		$this->cart->destroy();
		$this->partial('indexHeader');
		$this->partial('index/index');
        $this->partial('indexFooter');		
    }

    /**
     * Home action to handle home page request
     * @author    Lynn added on 09 March 2016
     */
    function home() {
	
        $this->view('index/home');
    }

    /**
     * Home action to handle Static pages
     * @author     Lynn added on 09 March 2016
     */
    function aboutus() {
        $this->view('index/aboutus');
    }

    function press() {
		$result = $this->page_model->get_page(9);
		$data['pageTitle'] =  'Press';
        $this->callbackStaticPage($result);
    }
    function privacy() {
		$result = $this->page_model->get_page(6);
		$data['pageTitle'] =  'Press';
        $this->callbackStaticPage($result);
    }
    
    function help() {
        	$result = $this->page_model->get_page(8);
		$data['pageTitle'] =  'Press';
        $this->callbackStaticPage($result);
    }
    
    function term() {
		$result = $this->page_model->get_page(4);
		$data['pageTitle'] =  'Press';
        $this->callbackStaticPage($result);
    }

	function how_it_work()
	{
        $result = $this->page_model->get_page(10);
		$data['pageTitle'] =  'How It Works';
        $this->callbackStaticPage($result);		
	}
	
	
    function tc() {
        ini_set('display_errors', '1');
        $this->view('index/tc');
        //echo 'here';exit;
    }

   
    function policy() {
        $this->view('index/policy');
        //echo 'here';exit;
    }
    

    function returnpolicy() {
        $this->view('index/returnpolicy');
    }

    /**
     * faq action to display Frequently asked questions
     * @author     Mujaffar S added on 11 July 2015
     */
    function faq() {
        $result = $this->page_model->get_page(5);
		$data['pageTitle'] =  'FAQ';
        $this->callbackStaticPage($result);
    }

    /**
     * faq action to display Frequently asked questions
     * @author     Mujaffar S added on 11 July 2015
     */

    /**
     * faq action to display Frequently asked questions
     * @author     Mujaffar S added on 11 July 2015
     */
    function contactus() {
        	$result = $this->page_model->get_page(11);
		$data['pageTitle'] =  'Contact Us';
        $this->callbackStaticPage($result);
    }
	
	function callbackStaticPage($data)
	{
		$temp  = array();
		$temp['result'] =  $data;
		$this->view('index/staticPages',$temp);
	}

    function get_captcha() {
        $string = '';
        for ($i = 0; $i < 5; $i++) {
            $string .= chr(rand(97, 122));
        }
        $this->session->set_userdata('random_number', $string);
        $dir = FCPATH . '/assets/fonts/';

        $image = imagecreatetruecolor(165, 50);

        // random number 1 or 2
        $num = rand(1, 2);
        if ($num == 1) {
            $font = "Capture it 2.ttf"; // font style
        } else {
            $font = "Molot.otf"; // font style
        }

        // random number 1 or 2
        $num2 = rand(1, 2);
        if ($num2 == 1) {
            $color = imagecolorallocate($image, 113, 193, 217); // color
        } else {
            $color = imagecolorallocate($image, 163, 197, 82); // color
        }

        $white = imagecolorallocate($image, 255, 255, 255); // background color white
        imagefilledrectangle($image, 0, 0, 399, 99, $white);

        imagettftext($image, 30, 0, 10, 40, $color, $dir . $font, $this->session->userdata('random_number'));

        header("Content-type: image/png");
        imagepng($image);
    }

    function verify_contact_form() {

        if ($this->input->post('code') && strtolower($this->input->post('code')) == strtolower($this->session->userdata('random_number'))) {
            $this->load->library('email');
            $config['mailtype'] = 'html';
            $this->email->initialize($config);
            $this->email->from($this->config->item('email'), $this->config->item('company_name'));
            $this->email->to($this->input->post('email'));
            $this->email->subject('Contact us form submiited');

            $message = 'Dear Admin,<br />Contact form has been submitted, details are as below.<br />'
                    . '<table>'
                    . '<tr><td>Name</td><td>:</td><td>' . $this->input->post('name') . '</td></tr>'
                    . '<tr><td>Email</td><td>:</td><td>' . $this->input->post('email') . '</td></tr>'
                    . '<tr><td>Message</td><td>:</td><td>' . $this->input->post('message') . '</td></tr>'
                    . '</table>'
                    . '<br />Thanks.';

            $this->email->message(html_entity_decode($message));

            $this->email->send();

            echo 1;
        } else {
            echo 0;
        }
        exit;
    }

	public function location($country_id)
	{
		$this->session->unset_userdata('locationDetail');
		$data['countryDetail'] = $this->location_model->get_country($country_id);
		$data['country_id'] = $country_id;
		$data['locationDetail'] =  $this->session->userdata('locationDetail');
		$this->view('index/location',$data);
	}
	
	function category()
	{
		$post =  $this->input->post();
		if(!empty($post))
		{		
			$sessionArr = array();
			$sessionArr['locationDetail'] = $post;		
			$this->session->set_userdata('locationDetail', $post); 
			redirect('category');			
		}
		else
		{
			$this->checkIssetSession();				
			$this->view('index/category',$data);
			
		}
	}
	
	function seller($category_id)
	{
		
		$this->checkIssetSession();		
		$sessionData =  $this->session->userdata('locationDetail');	
		
		if(empty($category_id) && isset($sessionData['category_id']))
		{
			$category_id = $sessionData['category_id'];
		}
		
		$where1 = array();
		$where1['id'] = $category_id;
		$categoriesResult = $this->business_model->select_data_where('gc_categories',$where1);					
		$temp =  array();
		$temp  = $sessionData;
		$temp['category_name'] = $categoriesResult['name'];
		$temp['category_id'] = $category_id;
		$this->session->set_userdata('locationDetail', $temp); 
		$latitude = $sessionData['location_hid_lat'];
		$longitude = $sessionData['location_hid_lng'];
		$country_id = $sessionData['location_hid_country_id'];		
		
		
		$distance = 50;		
		$this->db->select("*, ( 6371 * acos( cos( radians( ".$latitude." ) ) * cos( radians( p.latitude ) ) * cos( radians( p.longitude ) - radians( ".$longitude." ) ) + sin( radians( ".$latitude." ) ) * sin( radians( p.latitude ) ) ) ) AS distance");
        $this->db->from('gc_venture_address p');
        $this->db->having('distance <',$distance);
        $this->db->group_by('address');	
        $this->db->join('gc_map_vr_vt', 'gc_map_vr_vt.venture_id = p.venture_id');
        $this->db->join('gc_business_categories', 'gc_business_categories.customers_id = gc_map_vr_vt.vendor_id and  gc_business_categories.categories_id='.$category_id);
        //$this->db->where('p.venture_id  IN (select gc_business_categories.customers_id from gc_business_categories where   gc_business_categories.categories_id='.$category_id.')', NULL, FALSE);
		$query = $this->db->get();
        $areaResult =  $query->result_array();   
        	
		//echo $this->db->last_query();
		$data = array();
		$data['areaSelectResult'] =  $areaResult;	
		if($category_id == '3')
		{	
			$search_line = 'Restaurants ';
			$data['search_btn_value'] = 'Find  Restaurants ';
		}
		if($category_id == '1')
		{
			
			$search_line = 'Grocery Store';
			$data['search_btn_value'] = 'Find  Grocery Store';
		}
		if($category_id == '2')
		{
			$search_line = 'Pharmasy Store';
			$data['search_btn_value'] = 'Find  Pharmasy Store';
		}				
		$search_line_div =  '<span class="light">Search for '.$search_line.' in </span><span class="med">'.current(explode(",",$sessionData['location_city'])).'</span>';
		$data['search_line_div'] = $search_line_div;
		$data['detail'] = $sessionData;		
		$data['category_id'] = $category_id;
		 
		$this->view('index/seller',$data);
	}
	
	function area($area_id)
	{
		
		$post = $this->input->post();
		$sessionData =  $this->session->userdata('locationDetail');
		
		if(isset($post) && !empty($post))
		{
			$temp =  array();
			$temp  = $sessionData;
			$temp['area_id'] = $post['seller-areaName'];
			$temp['area_name'] = $post['seller_hid_locationName'];
			$temp['seller_hid_lat'] = $post['seller_hid_lat'];
			$temp['seller_hid_lng'] = $post['seller_hid_lng'];
			$this->session->set_userdata('locationDetail', $temp);
			$area_id = $post['seller-areaName'];
			$latitude = $post['seller_hid_lat'];
			$longitude = $post['seller_hid_lng'];
			redirect(site_url('area'));			
		}
		else if(isset($sessionData['area_id']))
		{
			
			$this->checkIssetSession();					
			$area_id = $sessionData['area_id'];
			$latitude = $sessionData['seller_hid_lat'];
			$longitude = $sessionData['seller_hid_lng'];
		}
		else
		{
			redirect(site_url('/'));
		}
		
		$where1 = array();
		$where1['id'] = $area_id;
		$areaResult = $this->business_model->select_data_where('gc_venture_address',$where1);
		//echo "<pre>"; print_r($sessionData); echo "</pre>";
		//~ $latitude = $sessionData['location_hid_lat'];
		//~ $longitude = $sessionData['location_hid_lng'];
		$country_id = $sessionData['country_id'];
		$category_id = $sessionData['category_id'];
		$distance = 1;
			
		//$this->db->select("p.venture_id,gc_customers.id as user_id, ( 6371 * acos( cos( radians( ".$latitude." ) ) * cos( radians( p.latitude ) ) * cos( radians( p.longitude ) - radians( ".$longitude." ) ) + sin( radians( ".$latitude." ) ) * sin( radians( p.latitude ) ) ) ) AS distance");
		$this->db->select("p.venture_id,gc_customers.id as user_id,p.address");
		$this->db->select('gc_venture_option.min_delivery_amount');
		$this->db->select('gc_venture_option.avg_delivery_time');
		$this->db->select('gc_venture_option.delivery_fee');
		$this->db->select('gc_venture_option.payment_type');
		$this->db->select('gc_venture_option.with_promotion');
       	$this->db->select('gc_customers.company');
       
        $this->db->from('gc_venture_address p');
       // $this->db->having('distance <',$distance);
		$this->db->join('gc_map_vr_vt', 'gc_map_vr_vt.venture_id = p.venture_id');
		$this->db->join('gc_business_categories', 'gc_business_categories.customers_id = gc_map_vr_vt.vendor_id and  gc_business_categories.categories_id='.$category_id);
        $this->db->join('gc_customers', 'gc_customers.id = p.venture_id', 'left');
        $this->db->join('gc_venture_option', 'gc_venture_option.venture_id = p.venture_id', 'left');	
		$this->db->where('p.latitude',$latitude);
		$this->db->where('p.longitude',$longitude);
		//$this->db->where('p.venture_id  IN (select gc_business_categories.customers_id from gc_business_categories where   gc_business_categories.categories_id='.$sessionData['category_id'].')', NULL, FALSE);
		
		$hid_limit = 3;
		$hid_ofset = 0;			
			
		$this->db->order_by("company",'asc'); 
		$query = $this->db->get();
        $finalResult =  $query->result_array();		
		//echo $this->db->last_query();
		//echo "<pre>"; print_r($finalResult); echo "</pre>";
		$data = array();
		$data['detail'] =  $this->session->userdata('locationDetail');
		$data['finalResult'] = $finalResult;
		$data['address'] = $areaResult['address'];
		
		$data['vanture_id'] = $finalResult['id'];
		
		$this->view('index/area',$data);
	}
	
	function detail($venture_id)
	{
		
		$sessionData =  $this->session->userdata('locationDetail');
		$this->checkIssetSession();			
		if(empty($venture_id) && isset($sessionData['venture_id']))
		{
			$venture_id = $sessionData['venture_id'];
		}
		
		$data = array();
		$this->db->select("gc_customers.company");
		$this->db->select("gc_venture_option.venture_id");
		$this->db->select("gc_venture_option.min_delivery_amount");
		$this->db->select("gc_venture_option.avg_delivery_time");
		$this->db->select("gc_venture_option.delivery_fee");
		$this->db->select("gc_venture_option.payment_type");
		
		$this->db->from('gc_customers');
		$this->db->join('gc_venture_address', 'gc_venture_address.venture_id = gc_customers.id');	
		$this->db->join('gc_venture_option', 'gc_venture_option.venture_id = gc_customers.id');	
		$this->db->where('gc_customers.id ', $venture_id);
		$query = $this->db->get();
        $ventureResult =  $query->row_array();			
		
		 
		$this->db->select("*");
		$this->db->from('gc_products');
		$this->db->where('gc_products.added_by_cust ', $venture_id);
		$this->db->join('gc_products_addons', 'gc_products_addons.product_id = gc_products.id', 'left');	
		//$this->db->where("gc_products.id  IN (select distinct(product_id) as id from gc_order_items where venture_id=".$venture_id." )");		
		$query1 = $this->db->get();
        $productResult =  $query1->result_array();			
			
		$temp =  array();
		$temp  = $sessionData;
		$temp['venture_id'] = $venture_id;
		$temp['venture_name'] = $ventureResult['company'];
		$this->session->set_userdata('locationDetail', $temp);		
		
		
		$data['ventureResult'] = $ventureResult;
		$data['productResult'] = $productResult;
		//echo '<pre>'; print_r($data); echo '</pre>';
		$this->view('index/detail',$data);
	}
	
	/* list page functionality */
	function restaurantList_searchBy()
	{
		$sessionData =  $this->session->userdata('locationDetail');
		$post  = $this->input->post();
		$filterChecksHTML = array();
		
		$where1 = array();
		$where1['id'] = $sessionData['area_id'];
		$areaResult = $this->business_model->select_data_where('gc_venture_address',$where1);
		
		$latitude = $sessionData['seller_hid_lat'];
		$longitude = $sessionData['seller_hid_lng'];		
		//~ $latitude = $areaResult['latitude'];
		//~ $longitude = $areaResult['longitude'];
		$country_id = $sessionData['country_id'];
		$category_id = $sessionData['category_id'];
		$distance = 1;
		
		
		//$this->db->select("p.venture_id,gc_customers.id as user_id,gc_customers.id as user_id, ( 6371 * acos( cos( radians( ".$latitude." ) ) * cos( radians( p.latitude ) ) * cos( radians( p.longitude ) - radians( ".$longitude." ) ) + sin( radians( ".$latitude." ) ) * sin( radians( p.latitude ) ) ) ) AS distance");
		$this->db->select("p.venture_id,gc_customers.id as user_id,p.address");
		$this->db->select('gc_venture_option.min_delivery_amount');
		$this->db->select('gc_venture_option.avg_delivery_time');
		$this->db->select('gc_venture_option.delivery_fee');
		$this->db->select('gc_venture_option.payment_type');
		$this->db->select('gc_venture_option.with_promotion');
       	$this->db->select('gc_customers.company');
       			
        $this->db->from('gc_venture_address p');
        //$this->db->having('distance <',$distance);
		$this->db->join('gc_map_vr_vt', 'gc_map_vr_vt.venture_id = p.venture_id');
		$this->db->join('gc_business_categories', 'gc_business_categories.customers_id = gc_map_vr_vt.vendor_id and  gc_business_categories.categories_id='.$category_id);        
        $this->db->join('gc_customers', 'gc_customers.id = p.venture_id', 'left');
        $this->db->join('gc_venture_option', 'gc_venture_option.venture_id = p.venture_id', 'left');
        $this->db->where("(p.latitude = '".$latitude."' and p.longitude = '".$longitude."')");
        //$this->db->where('p.latitude',$latitude);
		//$this->db->where('p.longitude',$longitude);  
	     
        
		if(isset($post['listing_ul_restaurantType']) && in_array('now_open',$post['listing_ul_restaurantType'])) 
		{        
			$this->db->join('gc_venture_timing', 'gc_venture_timing.venture_id = p.venture_id and gc_venture_timing.weekday=dayofweek(curdate()) ');
		}
       
		if($post['restaurant_restaurantName'] != '')
		{
			$this->db->like('company', $post['restaurant_restaurantName']);
			$filterChecksHTML[] = $this->callbackFilterLink($post['restaurant_restaurantName'],'restaurant-restaurantName');
		}
		       
		if($post['minimumDeliveryAmount'] != '' && $post['minimumDeliveryAmount'] != '$0')
		{
			
			$listing_minimumDeliveryAmount = substr($post['minimumDeliveryAmount'],1);
			$this->db->where('min_delivery_amount <=', $listing_minimumDeliveryAmount);
			$filterChecksHTML[] = $this->callbackFilterLink('Delivery amount :'.$post['minimumDeliveryAmount'],'amount');
		}
		if($post['hid_avg_deliveryTime'] != '')
		{
			$hid_avg_deliveryTime = $post['hid_avg_deliveryTime'];
			$this->db->where('avg_delivery_time <=', $hid_avg_deliveryTime);
			$filterChecksHTML[] = $this->callbackFilterLink('Avg delivery time :'.$post['hid_avg_deliveryTime'],'hid_avg_deliveryTime');
			
		}		
		if($post['listing_delivery_area'] != '')
		{
			$this->db->where('coverage_area <=', $post['listing_delivery_area']);
			$filterChecksHTML[] = $this->callbackFilterLink('Delivery Area :'.$post['listing_delivery_area'],'listing_delivery_area');
		}
		if($post['listing_payment_method'] != '')
		{
			$this->db->where('payment_type ', $post['listing_payment_method']);
			$filterChecksHTML[] = $this->callbackFilterLink('Payment method :'.$post['listing_payment_method'],'listing_payment_method');
		}
			
		if($post['delivery_fee'] != '')
		{
			if($post['delivery_fee'] == 'free' )
				$this->db->where('delivery_fee ', 0);
			else
				$this->db->where('delivery_fee > ', 0);
				
			$filterChecksHTML[] = $this->callbackFilterLink('Delivery type :'.$post['delivery_fee'],'delivery_fee');
		}	
		
		if(isset($post['cuisine_fav']) && !empty($post['cuisine_fav']))
		{
			$coisineCount = 0;
			foreach($post['cuisine_fav'] as $fav){
				$value = $fav;
				$coisineQuery = "p.venture_id in (select gc_venture_cuisine_map.venture_id from gc_venture_cuisine_map where gc_venture_cuisine_map.cuisine_id=".$value." and gc_venture_cuisine_map.venture_id=p.venture_id )";
				if(count($post['cuisine_fav'])==1)
				{
					$qry = $coisineQuery;
				}
				else
				{
					if($coisineCount ==0)
					{
						$qry = '('.$coisineQuery;
					}
					else
					{
						$qry .= ' or '. $coisineQuery;
					}
					if($coisineCount ==count($post['cuisine_fav'])-1)
					{
						$qry .= ' ) ';
					}										
				}
				
				//$this->db->or_where($coisineQuery);
				
				$coisineCount++;
			}
			$this->db->where($qry);
			$result2 = $this->business_model->select_coulmnOnlyName_data_where_in('cuisine_name','gc_cuisine','cuisine_id',implode(",",$post['cuisine_fav']));
			$cuisineArr = implode(" | ",$result2);
			
			$filterChecksHTML[] = $this->callbackFilterLink('Cuisine :'.$cuisineArr,'cuisine_fav');
		}
		if(isset($post['selected_rating']) && !empty($post['selected_rating']))
		{
			$this->db->where('rating ', $post['selected_rating']);
			$filterChecksHTML[] = $this->callbackFilterLink('Rating :'.$post['selected_rating'],'selected_rating');
		}
		
		if(isset($post['listing_ul_restaurantType']) && in_array('now_open',$post['listing_ul_restaurantType'])) 
		{		
			$filterChecksHTML[] = $this->callbackFilterLink('Now open','now_open');
		}	
		if(isset($post['listing_ul_restaurantType']) && in_array('with_promotion',$post['listing_ul_restaurantType']))
		{			
			$this->db->where('with_promotion', '1');
			$filterChecksHTML[] = $this->callbackFilterLink('With promotion','with_promotion');
		}			 
		if($post['hid_sort_type'] == 'alphabet')
		{
			$hid_sort_order = $post['hid_sort_order'];
			$this->db->order_by("company", $hid_sort_order); 
		}     
		if($post['load_more']==1)
		{
			$hid_limit = $post['hid_limit'];
			$hid_ofset = $post['hid_ofset'];
		}
		else
		{
			$hid_limit = 3;
			$hid_ofset = 0;			
		}
		//	$this->db->limit($hid_limit,$hid_ofset);
		$query = $this->db->get();
        $finalResult =  $query->result_array();
        $lastQury = $this->db->last_query();
        //echo "<pre>"; print_r($finalResult); echo "</pre>";
		if(!empty($finalResult))
		{		
			$data = array();
			$data['detail'] =  $this->session->userdata('locationDetail');
			$data['finalResult'] = $finalResult;
			$html = $this->load->view('front/index/restaurant_list',$data,true); 
			$json = array();
			$json['hasRecordStatus'] = 'Y';
			$json['qry'] =  $lastQury;
			$json['html'] = $html;
			$json['limit'] = $hid_limit;
			$json['ofset'] = $hid_limit+$hid_ofset+2;
			$json['filterChecksHTML'] = implode('',$filterChecksHTML);
		}
		else
		{
			$json = array();
			$json['qry'] = $this->db->last_query(); 
			$json['hasRecordStatus'] = 'N';
			$json['filterChecksHTML'] = implode('',$filterChecksHTML);
		}	
		echo json_encode($json);	
	}
	
	function callbackFilterLink($label,$value)
	{
		$html = '<a href="javascript:void(0)" onclick="clearThisFilter('."'".$value."'".')" >'.$label.' <img alt="x" src="'.site_url().'assets/front/images/remove.png"></a>';
		return $html;
	}
	
	function ajax_add_to_cart()
	{
		$post = $this->input->post();
		
		$where1 = array();
		$where1['id'] = $post['product_id'];
		$product = $this->business_model->select_data_where('gc_products',$where1);	
		$images = (array) json_decode($product['images']);
		$productImageArray = array_values($images);			
		// echo '<pre>'; print_r($product['images']); echo '</pre>';
		
		$price = $post['product_price'] * $post['popupProduct_qty']; 
		$variable = $post['product_name'];
		$convertedVariable = str_replace('™','',$post['product_name']);
		$option['addOns'] = isset($post['addOnPrice'])?$post['addOnPrice']:'';
		$option['product_id'] = $post['product_id'];
		$option['product_image'] = site_url().'uploads/images/small/'.$productImageArray[0]->filename;
		$data = array(
					   'id'      => 'sku_'.rand(),
					   'qty'     => $post['popupProduct_qty'],
					   'price'   => $post['product_price'],			   
					   'name'    => $convertedVariable,
					   'venture_id'    =>  $post['venture_id'],
					   'options' =>$option
		);		
				
		$this->cart->product_name_rules = '[:print:]';
		$rowID = $this->cart->insert($data); 	
		if(!empty($rowID))
		{
			$data =array();
			$cartBoxHtml =  $this->load->view('front/index/product_cart',$data,true);
			$json = array();
			$json['cartBoxHtml'] = $cartBoxHtml;
			echo json_encode($json);
		}
		else
		{
			$json = array();
			$json['cartBoxHtml'] = '<h1>Server Error</h1>';
			echo json_encode($json);
		}
	}
	
	function ajax_update_cart_item()
	{
		$post = $this->input->post();	
		$data = array(
		   'rowid' => $post['rowid'],
		   'qty'   => $post['qty']
		);
		$this->cart->update($data); 
		$data =array();
		$cartBoxHtml =  $this->load->view('front/index/product_cart',$data,true);
		$json = array();
		$json['cartBoxHtml'] = $cartBoxHtml;
		echo json_encode($json);			
	}
	
	function ajax_delete_cart_item()
	{
		$post = $this->input->post();			
		$data = array(
		   'rowid' => $post['rowid'],
		   'qty'   =>0
		);

		$this->cart->update($data); 

		$data =array();
		$cartBoxHtml =  $this->load->view('front/index/product_cart',$data,true);
		$json = array();
		$json['cartBoxHtml'] = $cartBoxHtml;
		echo json_encode($json);	
	}	
	
	function ajax_clear_cart_item()
	{
		$this->cart->destroy();
		$data =array();
		$cartBoxHtml =  $this->load->view('front/index/product_cart',$data,true);
		$json = array();
		$json['cartBoxHtml'] = $cartBoxHtml;
		echo json_encode($json);
	}
	
	function ajax_tab_product_listing()
	{	
		$post = $this->input->post();
		$venture_id = $post['venture_id'];
		$this->db->select("*");
		$this->db->from('gc_products');
		$this->db->join('gc_products_addons', 'gc_products_addons.product_id = gc_products.id', 'left');			
		$this->db->where('gc_products.added_by_cust ', $post['venture_id']);
		if($post['selected_type']=='most_selling')
		{
			$this->db->where("gc_products.id  IN (select distinct(product_id) as id from gc_order_items where venture_id=".$venture_id." )");		
		}
		if($post['selected_type']=='promotions')
		{
			$this->db->where('product_promotion_status','1');
			
		}		
		$query1 = $this->db->get();
        $productResult =  $query1->result_array();
        $data['productResult'] = $productResult;
        $data['heading'] = $post['headingName'];
		$productBoxHtml =  $this->load->view('front/index/tab_product_listing',$data,true);
		$json = array();
		$json['productBoxHtml'] = $productBoxHtml;
		echo json_encode($json);                
	}
	
	function ajax_checkValideEmail()
	{
		$post = $this->input->post();	
		$where1 = array();
		$where1['email'] = $post['email'];
		$areaResult = $this->business_model->select_data_where('gc_customers',$where1);
		if(empty($areaResult))
		{
			$json['emailValidStatus'] = 'Y';
		}
		else
		{
			$json['emailValidStatus'] = 'N';
		}
		echo json_encode($json);
	}
	
	function ajax_insertNewNote()
	{
		$userDetail = $this->session->userdata('userDetail');
		$post = $this->input->post();		
		$insertData['note_text'] = $post['note'];
		$insertData['user_id'] = $userDetail['user_id'];		
		$id= $this->business_model->insert_entry('gc_order_notes',$insertData);
		$json['status'] = 'Y';
		$json['id'] = $id;
		echo json_encode($json);		
	}

	function checkout()
	{
		
		$this->checkIssetSession();	
		$userDetail = $this->session->userdata('userDetail');
		if(empty($userDetail))
		{
			$this->session->set_userdata('returnController','checkout'); 
			redirect('login/checkout');
		}		
		$data = array();
		$where =  array(); 
		$where['user_id'] = $userDetail['user_id'];
		$data['notesData'] = $this->business_model->select_data_where_result('gc_order_notes',$where);
		$this->view('index/checkout',$data);
	}
	
	function order()
	{
		$userDetail = $this->session->userdata('userDetail');
		if(empty($userDetail))
		{
			$this->session->set_userdata('returnController','order'); 
			redirect('login/order');
		}
		else
		{				
			$msg['message'] = '<strong>Order page : Work Under construction</strong>,<br>
			Note: This page is  under construction<br>
			<a href="'.site_url().'">Click to go back to Home</a>';
			$this->view('index/notifyMessage',$msg);
		}
	}
	
	function checkIssetSession()
	{
		$sessionData =  $this->session->userdata('locationDetail');
		$currentClass =  $this->router->fetch_class(); 		
		$currentMethod =  $this->router->fetch_method(); 
		if(empty($sessionData['location_hid_lat']))
		{
			redirect('/');			
		}
		//if($currentMethod=='seller' && )
	}	
	
	function checkIsLogin()
	{
		$userDetail = $this->session->userdata('userDetail');
		
		if(!empty($userDetail))
		{
			$returnController = $this->session->userdata('returnController'); 
			$denyRedirect = array('register','login','forgot');
			if(!empty($returnController) && !in_array($returnController,$denyRedirect))
			{
				redirect(site_url($returnController));
			}
			else
			{
				redirect(site_url('/'));
			}
		}
	}	
	
	function login()
	{
		$lastAction = $this->uri->segment(2);
		if(!empty($lastAction))
		{
			$this->session->set_userdata('returnController',$lastAction); 
		}
		
		$this->checkIsLogin();
		$post =  $this->input->post();
		if(!empty($post))
		{
			$where1 = array();
			$where1['email'] = $post['loginEmail'];
			$where1['password'] = sha1($post['loginPassword']);	
			$areaResult = $this->business_model->select_data_where('gc_customers',$where1);
			if(!empty($areaResult))
			{
				/******************* Remeber me *************** */				
				if($areaResult['email_verified'] =='1')
				{
					$this->load->helper('cookie');
					if(isset($post['remember_me']))
					{	
						$hour = time() + 3600;
						setcookie('email', $post['loginEmail'], $hour);
						setcookie('password', $post['loginPassword'], $hour);		
					}		
					else
					{
						setcookie("email", "", time()-3600);
						setcookie("password", "", time()-3600);	
					}			
					$sessData['user_id'] = $areaResult['id'];
					$this->session->set_userdata('userDetail', $sessData); 
					$this-> checkIsLogin();
				}
				else
				{
					$data['errorMessage'] = '<div class="row msg error errorMsg" id="errorMsg">Your email address is not verify.</div>';
					$this->session->set_flashdata('msg', $error );				
					$this->view('index/login',$data);						
				}
			}
			else
			{
				$data['errorMessage'] = '<div class="row msg error errorMsg" id="errorMsg">Incorrect username or password</div>';
				$this->session->set_flashdata('msg', $error );				
				 $this->view('index/login',$data);	
			}		
		}
		else
		{		
			$this->view('index/login');
		}
	}
	
	function register()
	{
		
		$this-> checkIsLogin();		
		$post =  $this->input->post();
		if(!empty($post))
		{
			$verify_email_key = time().rand();
			$data = array();
			$data['firstname'] = $post['name'];
			$data['lastname'] = $post['surname'];
			$data['email'] = $post['email'];
			$data['password'] = sha1($post['password']);
			$data['mobile_number'] = $post['mobile_number'];
			$data['city'] = $post['cityName'];		
			$data['verify_email_key'] = $verify_email_key;
			$where1 = array();
			$where1['email'] = $post['email'];
			$areaResult = $this->business_model->select_data_where('gc_customers',$where1);
			if(empty($areaResult))
			{						
				$id= $this->business_model->insert_entry('gc_customers',$data);
			}
	
			$msg = 'Hello '.$post['name'].' <br> <br>					
					Thanks for registeting in Market Place. Your Participation is appreciated. 
					To verify your email address <a href="'.site_url('index/verifyAccount/'.$verify_email_key).'">Click here</a>. After successful verification of your email address you can access your account.
					 <br><br>Thanks , <br>Market Place';
			$subject ="Thanks for Participation";			
			$this->customemail->reg_confirmation($post['email'],$subject,$msg); 						
			$data = array();
			$data['emailData'] = $msg;
			$data['message'] = 'Thanks for the registeration,<br>Please check your Inbox or Spam for verification.';
			$this->view('index/notifyMessage',$data);
		}
		else
		{
			$this->view('index/register');
		}
	}
	
	function verifyAccount($verify_email_key='')
	{
		$data = array();		
		$data['email_verified'] = '1';
		$data['verify_email_key'] = '';
		$this->business_model->update_entry('gc_customers','verify_email_key',$verify_email_key,$data);
		$msg['message'] = 'Your account has been verified sucessfully<br>			
			<a href="'.site_url('login').'">Login here to access your account</a>';
		$this->view('index/notifyMessage',$msg);				
	}
	
	function logout()
	{
		//~ $lastAction = $this->uri->segment(2);
		//~ if(!empty($lastAction))
		//~ {
			//~ $this->session->set_userdata('returnController',$lastAction); 
		//~ }
		//echo "ff".$returnController = $this->session->userdata('returnController'); die();
		$this->load->library('googleplus');
		$this->session->unset_userdata('userDetail');
        $this->session->sess_destroy();
        $this->session->set_flashdata('msg', '<div class="alert alert-success text-center">Logout Successfully!</div>');
        /* Google logout*/
        unset($_SESSION['token']);
		$this->googleplus->revokeToken();		
        redirect('/');
	}
	function forgot()
	{
		$this-> checkIsLogin();		
		$post =  $this->input->post();		
		if(!empty($post))
		{		
			$where1 = array();
			$where1['email'] = $post['email'];
			$verify_forgot_key = md5($post['email'].time());
			$userResult = $this->business_model->select_data_where('gc_customers',$where1);							
			$updData = array();			
			$updData['verify_forgot_key'] = $verify_forgot_key;
			$this->business_model->update_entry('gc_customers','email',$post['email'],$updData);								
			$data = array();
			 $emailData = "Dear ".$userResult['firstname'].' <br><br>
									<a href="'.site_url('resetPassword/'.$verify_forgot_key).'">Click here to reset your password</a>	<br><br>
									Thanks<br>Market Place
								'; 
			$subject ="New password request";		
			$this->customemail->reg_confirmation($post['email'],$subject,$emailData); 
			$data['emailData'] = $emailData;
			$data['message'] = 'Your forgot password request accepted. The new password link has been sent to you on your email address<br>
								Please check your Inbox or Spam for reset your password';
			
			$this->view('index/notifyMessage',$data);		
		}
		else
		{
			$this->view('index/forgot');	
		}
	}	
	
	function resetPassword()
	{
		$post =  $this->input->post();
		if(!empty($post))
		{
			$updData = array();			
			$updData['verify_forgot_key']  = '';
			$updData['password'] = sha1($post['password']);
			$this->business_model->update_entry('gc_customers','verify_forgot_key',$post['verify_forgot_key'],$updData);					
			$msg['message'] = '<strong>Your password had been updated sucessfully</strong>,<br>			
			<a href="'.site_url('login').'">Click to login</a>';
			$this->view('index/notifyMessage',$msg);			
		}
		else
		{
			$verify_forgot_key =  $this->uri->segment(2);
			$where1 = array();
			$where1['verify_forgot_key'] = $verify_forgot_key;	
			$userResult = $this->business_model->select_data_where('gc_customers',$where1);	
			if(!empty($userResult))
			{
				$data = array();
				$data['verify_forgot_key']  = $verify_forgot_key;
				$data['userResult']  = $userResult;
				$this->view('index/resetPass',$userResult);	
			}
			else
			{
				$msg['message'] = 'Upps ! Your link has been expired';
				$this->view('index/notifyMessage',$msg);
			}
		}
	}
	
	function myAccount()
	{
		$this->view('index/myAccount');
	}
		
	function facebook_login()
	{
		$this-> checkIsLogin();		
		$app_id = "472478382959784";
		$app_secret = "7d849700babccdfc4efcb7e7260519de";
		$my_url = site_url()."index/facebook_login"; // mainly, redirect to this page	
		$perms_str = "email";
		if(isset($_REQUEST["code"]))
		{
			$code = $_REQUEST["code"];
		}
		else
		{
			$code = '';
		}		 
		if(empty($code)) 
		{
		    $auth_url = "http://www.facebook.com/dialog/oauth?client_id="
		    . $app_id . "&redirect_uri=" . urlencode($my_url)
		    . "&scope=" . $perms_str;
		    echo("<script>top.location.href='" . $auth_url . "'</script>");
		}
		 
		$token_url = "https://graph.facebook.com/oauth/access_token?client_id="
		. $app_id . "&redirect_uri=" . $my_url
		. "&client_secret=" . $app_secret
		. "&code=" . $code;
		$params = array();     
		$retResponseJson=$this->check_response($token_url);	 
		$retResponse = json_decode($retResponseJson);		
		if($retResponse->error->code=='100')
		{	
			 echo("<script>top.location.href='" . site_url().'index/facebook_login' . "'</script>");
		}		
		$pieces = explode("&",$retResponseJson); 
	    $access_token=substr($pieces[0],13);
		$infourl = "https://graph.facebook.com/me?access_token=$access_token";
		$retResponseJsonRep =$this->check_response($infourl);
		$result = json_decode($retResponseJsonRep);
		$where1 = array();
		$where1['facebook_id'] = $result->id;
		$userResult = $this->business_model->select_data_where('gc_customers',$where1);		
		if(empty($userResult))
		{
			$data = array();
			$data['firstname'] = $result->name;
			$data['facebook_id'] = $result->id;
			$id= $this->business_model->insert_entry('gc_customers',$data);
		}
		else
		{
			$id = $userResult['id'];
		}
		$sessData =  array();
		$sessData['user_id'] = $id;
		$this->session->set_userdata('userDetail', $sessData); 
		$returnController = $this->session->userdata('returnController'); 
		if(!empty($returnController))
		{
			redirect($returnController);
		}
		else
		{
			redirect('/');
		}
	}
	
	function check_response($url='')
	{    
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL,$url);
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
		curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 1);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);	
		$response = curl_exec($ch);
		$decoded = json_decode($response, true);
		if (curl_errno($ch))
		{
			print curl_error($ch);
		}
		else
		{
			curl_close($ch);
		//	print_r($decoded);
		//	print_r($response);
			return $response;
		}
	}	
	
	function google_login()
	{
		$this-> checkIsLogin();			
		$this->load->library('googleplus');
		if (isset($_GET['code'])) {

			$this->googleplus->client->authenticate();
			$_SESSION['token'] = $this->googleplus->client->getAccessToken();
			//$redirect = 'http://' . $_SERVER['HTTP_HOST'] . $_SERVER['PHP_SELF'];
			$redirect = site_url().'index/google_login';
			header('Location: ' . filter_var($redirect, FILTER_SANITIZE_URL));
		}
		if ($_SESSION['token'])
		{
			$this->googleplus->client->setAccessToken($_SESSION['token']);
		}
		if ($this->googleplus->client->getAccessToken())
		{
			$userData = $this->googleplus->people->get('me');
			$result  = $this->googleplus->people->get($userData['id']);
			//$activities = $this->googleplus->activities->listActivities('115414977082318263605','public');
			//$user =  $this; //get user info 
			//print 'Your Activities: <pre>' . print_r($result, true) . '</pre>';
			//$this->session->sess_destroy();
			// We're not done yet. Remember to update the cached access token.
			// Remember to replace $_SESSION with a real database or memcached.
			$_SESSION['token'] = $this->googleplus->client->getAccessToken();
			$where1 = array();
			$where1['googleplus_id'] = $userData['id'];
			$userResult = $this->business_model->select_data_where('gc_customers',$where1);		
			if(empty($userResult))
			{
				$data = array();
				$data['firstname'] = isset($userData['displayName'])?$userData['displayName']:'';
				$data['googleplus_id'] = $userData['id'];
				$id= $this->business_model->insert_entry('gc_customers',$data);
			}
			else
			{
				$id = $userResult['id'];
			}						
			$sessData =  array();
			$sessData['user_id'] = $id;
			$this->session->set_userdata('userDetail', $sessData); 
			$returnController = $this->session->userdata('returnController'); 
			if(!empty($returnController))
			{
				redirect($returnController);
			}
			else
			{
				redirect('/');
			}						
		}
		else
		{
			$authUrl = $this->googleplus->client->createAuthUrl();
			header('Location: ' . filter_var($authUrl, FILTER_SANITIZE_URL));
			//print "<a href='$authUrl'>Connect Me!</a>";
		}

	}
	
	function email_sending_smtp($to,$subject,$content)
	{
		   $CI = & get_instance();
            $configEmail = $CI->config->item('email_config');
            $this->load->library('email', $configEmail);
            $this->email->set_newline("\r\n");


            $this->email->from($configEmail['smtp_user'], 'Market Place');
            $this->email->to($to);
            $this->email->subject($subject);
            $this->email->message(html_entity_decode($content));
            

            if ($this->email->send()) {
            
            } else {
                echo $this->email->print_debugger();
            }
	}	
}
