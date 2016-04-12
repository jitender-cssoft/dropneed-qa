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
        $this->customer = $this->mp_cart->customer();
		$currentClass =  $this->router->fetch_class();
		$currentMethod =  $this->router->fetch_method();
		
    }

   public function index() {	
		
		
		$this->session->unset_userdata('locationDetail');
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
            $this->email->subject('Contact us form submiited!');

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
			//echo "<pre>"; print_r($post); echo "</pre>"; 			
			$sessionArr = array();
			$sessionArr['locationDetail'] = $post;		
			$this->session->set_userdata('locationDetail', $post); 
			redirect('category');			
		}
		else
		{
			$sessionData =  $this->session->userdata('locationDetail');
			//echo "dfgfd<pre>"; print_r($sessionData); echo "</pre>"; 
			$data['detail'] = $sessionData;
			$this->view('index/category',$data);
			
		}
	}
	
	function seller($category_id)
	{
		//$this->session->set_userdata('selected', $post); 
		$sessionData =  $this->session->userdata('locationDetail');
		$temp =  array();
		$temp  = $sessionData;
		$temp['category_name'] = $category_id;
		$this->session->set_userdata('locationDetail', $temp); 
		
		
		$latitude = $sessionData['location_hid_lat'];
		$longitude = $sessionData['location_hid_lng'];
		$country_id = $sessionData['location_hid_country_id'];
		
		$distance = 50;
		
		// $query = "SELECT * , ( 6371 * acos( cos( radians( ".$latitude." ) ) * cos( radians( p.latitude ) ) * cos( radians( p.longitude ) - radians( ".$longitude." ) ) + sin( radians( ".$latitude." ) ) * sin( radians( p.latitude ) ) ) ) AS distance FROM gc_venture_address p HAVING distance < ".$distance." and p.country_id=".$country_id ;	 
		// $areaResult =  $this->business_model->run_result_query($query);
		//$areaResult = array_unique($areaResult);
		
		$this->db->select("*, ( 6371 * acos( cos( radians( ".$latitude." ) ) * cos( radians( p.latitude ) ) * cos( radians( p.longitude ) - radians( ".$longitude." ) ) + sin( radians( ".$latitude." ) ) * sin( radians( p.latitude ) ) ) ) AS distance");
        $this->db->from('gc_venture_address p');
        $this->db->having('distance <',$distance);
        $this->db->group_by('address');	
		$query = $this->db->get();
        $areaResult =  $query->result_array();        	
		
		$data = array();
		$data['areaSelectResult'] =  $areaResult;
		
		
		if($category_id == 'food')
		{	
			$search_line = 'Restaurants ';
			$data['search_btn_value'] = 'Find  Restaurants ';
		}
		if($category_id == 'grocery')
		{
			
			$search_line = 'Grocery Store';
			$data['search_btn_value'] = 'Find  Grocery Store';
		}
		if($category_id == 'pharmasy')
		{
			$search_line = 'Pharmasy Store';
			$data['search_btn_value'] = 'Find  Pharmasy Store';
		}				
		$search_line_div =  '<span class="light">Search for '.$search_line.' in </span><span class="med">'.$sessionData['location_city'].'</span>';
		$data['search_line_div'] = $search_line_div;
		$data['detail'] = $sessionData;		
		$data['category_id'] = $category_id;
		$this->view('index/seller',$data);
	}
	
	function area($area_id)
	{

		$where1 = array();
		$where1['id'] = $area_id;
		$areaResult = $this->business_model->select_data_where('gc_venture_address',$where1);

		$sessionData =  $this->session->userdata('locationDetail');
		$temp =  array();
		$temp  = $sessionData;
		$temp['area_id'] = $area_id;
		$temp['area_name'] = $areaResult['address'];
		$this->session->set_userdata('locationDetail', $temp);

		//echo "<pre>"; print_r($areaResult); echo "</pre>";
		$latitude = $areaResult['latitude'];
		$longitude = $areaResult['longitude'];
		$country_id = $areaResult['country_id'];
		$distance = 50;
			
		$this->db->select("*, ( 6371 * acos( cos( radians( ".$latitude." ) ) * cos( radians( p.latitude ) ) * cos( radians( p.longitude ) - radians( ".$longitude." ) ) + sin( radians( ".$latitude." ) ) * sin( radians( p.latitude ) ) ) ) AS distance");
        $this->db->from('gc_venture_address p');
        $this->db->having('distance <',$distance);
        $this->db->join('gc_customers', 'gc_customers.id = p.venture_id', 'left');
        $this->db->join('gc_venture_option', 'gc_venture_option.venture_id = p.venture_id', 'left');	
		$this->db->join('gc_product_rating', 'gc_product_rating.user_id = p.venture_id', 'left');
		
		$hid_limit = 3;
		$hid_ofset = 0;			
			
		$this->db->order_by("company",'asc'); 
		$query = $this->db->get();
        $finalResult =  $query->result_array();		
		
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
		$data = array();

		
		$this->db->select("*");
		$this->db->from('gc_customers');
		$this->db->join('gc_venture_address', 'gc_venture_address.venture_id = gc_customers.id', 'left');	
		$this->db->join('gc_venture_option', 'gc_venture_option.venture_id = gc_customers.id', 'left');	
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
			
		$sessionData =  $this->session->userdata('locationDetail');
			
		$temp =  array();
		$temp  = $sessionData;
		$temp['venture_id'] = $venture_id;
		$temp['venture_name'] = $ventureResult['company'];
		$this->session->set_userdata('locationDetail', $temp);		
		
		
		$data['ventureResult'] = $ventureResult;
		$data['productResult'] = $productResult;
		$this->view('index/detail',$data);
	}
	
	/* list page functionality */
	function restaurantList_searchBy()
	{
		$sessionData =  $this->session->userdata('locationDetail');
		$post  = $this->input->post();
		$filterChecksHTML = array();
		//echo "<pre>"; print_r($post); echo "</pre>";die();
		$where1 = array();
		$where1['id'] = $sessionData['area_id'];
		$areaResult = $this->business_model->select_data_where('gc_venture_address',$where1);
		
		$latitude = $areaResult['latitude'];
		$longitude = $areaResult['longitude'];
		$country_id = $areaResult['country_id'];
		$distance = 50;
		
		
		$this->db->select("*, ( 6371 * acos( cos( radians( ".$latitude." ) ) * cos( radians( p.latitude ) ) * cos( radians( p.longitude ) - radians( ".$longitude." ) ) + sin( radians( ".$latitude." ) ) * sin( radians( p.latitude ) ) ) ) AS distance");
        $this->db->from('gc_venture_address p');
        $this->db->having('distance <',$distance);
        $this->db->join('gc_customers', 'gc_customers.id = p.venture_id', 'left');
        $this->db->join('gc_venture_option', 'gc_venture_option.venture_id = p.venture_id', 'left');
        $this->db->join('gc_product_rating', 'gc_product_rating.user_id = p.venture_id', 'left');
		if(isset($post['listing_ul_restaurantType']) && in_array('now_open',$post['listing_ul_restaurantType'])) 
		{        
			//$this->db->join('gc_venture_timing', 'gc_venture_timing.venture_id = p.venture_id and gc_venture_timing.weekday=dayofweek(curdate()) and curtime() >= gc_venture_timing.OpenTime OR curtime() <= gc_venture_timing.CloseTime ');
			$this->db->join('gc_venture_timing', 'gc_venture_timing.venture_id = p.venture_id and gc_venture_timing.weekday=dayofweek(curdate()) ');
		}
        //weekday=dayofweek(curdate()) and shop_id=1
        //$this->db->group_by('address');
       
		if($post['restaurant_restaurantName'] != '')
		{
			$this->db->like('company', $post['restaurant_restaurantName']);
			$filterChecksHTML[] = '<span >'.$post['restaurant_restaurantName'] .' <a href="javascript:void(0)" onclick="clearThisFilter('."'restaurant-restaurantName'".')">x</a> </span>';
		}       
		if($post['listing_minimumDeliveryAmount'] != '' && $post['listing_minimumDeliveryAmount'] != '$0')
		{
			$listing_minimumDeliveryAmount = substr($post['listing_minimumDeliveryAmount'],1);
			$this->db->where('min_delivery_amount <=', $listing_minimumDeliveryAmount);
			$filterChecksHTML[] = '<span >Delivery amount :'.$post['listing_minimumDeliveryAmount'] .' <a href="javascript:void(0)" onclick="clearThisFilter('."'amount'".')">x</a> </span>';
		}
		if($post['hid_avg_deliveryTime'] != '')
		{
			$hid_avg_deliveryTime = $post['hid_avg_deliveryTime'];
			$this->db->where('avg_delivery_time <=', $hid_avg_deliveryTime);
			$filterChecksHTML[] = '<span >Avg delivery time: '.$post['hid_avg_deliveryTime'] .' <a href="javascript:void(0)" onclick="clearThisFilter('."'hid_avg_deliveryTime'".')">x</a> </span>';
		}		
		if($post['listing_delivery_area'] != '')
		{
			$this->db->where('coverage_area <=', $post['listing_delivery_area']);
			$filterChecksHTML[] = '<span >Delivery area: '.$post['listing_delivery_area'] .' <a href="javascript:void(0)" onclick="clearThisFilter('."'listing_delivery_area'".')">x</a> </span>';
		}
		if($post['listing_payment_method'] != '')
		{
			$this->db->where('payment_type ', $post['listing_payment_method']);
			$filterChecksHTML[] = '<span >Payment method: '.$post['listing_payment_method'] .' <a href="javascript:void(0)" onclick="clearThisFilter('."'listing_payment_method'".')">x</a> </span>';
		}	
		if($post['delivery_fee'] != '')
		{
			if($post['delivery_fee'] == 'free' )
				$this->db->where('delivery_fee ', 0);
			else
				$this->db->where('delivery_fee > ', 0);
				
			$filterChecksHTML[] = '<span >Delivery type : '.$post['delivery_fee'] .' <a href="javascript:void(0)" onclick="clearThisFilter('."'delivery_fee'".')">x</a> </span>';
		}	
		
		if(isset($post['cuisine_fav']) && !empty($post['cuisine_fav']))
		{
			foreach($post['cuisine_fav'] as $fav){
				$value = $fav;
				$this->db->or_where("FIND_IN_SET('$value',cuisine) !=", 0);
			}
			
			$result2 = $this->business_model->select_coulmnOnlyName_data_where_in('cuisine_name','gc_cuisine','cuisine_id',implode(",",$post['cuisine_fav']));
			$cuisineArr = implode(" | ",$result2);
			
			$filterChecksHTML[] = '<span >Cuisine: '.$cuisineArr .' <a href="javascript:void(0)" onclick="clearThisFilter('."'cuisine_fav'".')">x</a> </span>';
		}
		if(isset($post['selected_rating']) && !empty($post['selected_rating']))
		{
			$this->db->where('rating ', $post['selected_rating']);
			$filterChecksHTML[] = '<span >Rating: '.$post['selected_rating'] .' <a href="javascript:void(0)" onclick="clearThisFilter('."'selected_rating'".')">x</a> </span>';
		}
		
		if(isset($post['listing_ul_restaurantType']) && in_array('now_open',$post['listing_ul_restaurantType'])) 
		{
			//$current_day =  date('N');
				$filterChecksHTML[] = '<span > Now open <a href="javascript:void(0)" onclick="clearThisFilter('."'now_open'".')">x</a> </span>';
		}
		
		if(isset($post['listing_ul_restaurantType']) && in_array('with_promotion',$post['listing_ul_restaurantType']))
		{			
			$this->db->where('with_promotion', '1');
				$filterChecksHTML[] = '<span > With promotion <a href="javascript:void(0)" onclick="clearThisFilter('."'with_promotion'".')">x</a> </span>';
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
	
	
	function ajax_add_to_cart()
	{
		//$this->cart->destroy();
		
		$post = $this->input->post();
			
		$price = $post['product_price'] * $post['popupProduct_qty']; 
		$variable = $post['product_name'];
		$convertedVariable = str_replace('™','',$post['product_name']);
		$data = array(
					   'id'      => 'sku_'.rand(),
					   'qty'     => $post['popupProduct_qty'],
					   'price'   => $post['product_price'],			   
					   'name'    => $convertedVariable,
					   'venture_id'    =>  $post['venture_id']
					   //'options' => array('Size' => 'L', 'Color' => 'Red','ship_price'   => 10.00)
					);		
					
		//echo "<pre>"; print_r($data); echo "</pre>";
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
			//echo "<pre>"; print_r($post); echo "</pre>";
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
			//echo "<pre>"; print_r($post); echo "</pre>";
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
	
	function clear_cart_item()
	{
		$this->cart->destroy();
		$data =array();
			$cartBoxHtml =  $this->load->view('front/index/product_cart',$data,true);
			$json = array();
			$json['cartBoxHtml'] = $cartBoxHtml;
			echo json_encode($json);
	}
	
	function ajax_tab_product_listing()
	{//$this->cart->destroy();
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
         //echo $this->db->last_query();
       
        $data['productResult'] = $productResult;
        $data['heading'] = $post['headingName'];
		$productBoxHtml =  $this->load->view('front/index/tab_product_listing',$data,true);
		$json = array();
		$json['productBoxHtml'] = $productBoxHtml;
		echo json_encode($json);        
        
	}
}
