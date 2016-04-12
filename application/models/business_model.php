<?php

class Business_model extends CI_Model {

    function __construct() {
        $this->load->database(); // load databse library in constructor
    }

    public function getSingleData($tableName, $whereCondition, $type = "array", $join = '', $colName = '') {
        if ($colName != '')
            $this->db->select($colName);
        $this->db->from($tableName);
        if ($join != '') {
            foreach ($join as $tbName => $condition) {
                $this->db->join($tbName, $condition);
            }
        }
        $this->db->where($whereCondition);
        $query = $this->db->get();
        return ($type == 'object') ? $query->result() : $query->result_array();
    }

    /*
     * Insert record
     * @param {string} $tableName
     * @param {array} $data
     * @returns {array/object}
     */

    public function insertData($tableName, $data) {
        $this->db->insert($tableName, $data);
        return $insert_id = $this->db->insert_id();
    }

    /*
     * update record
     * @param {string} $tableName
     * @param {array} $data
     * @param {string} $updateIdCol
     * @param {string} $updateIdVal
     * @returns {int}
     */

    public function updateData($tableName, $data, $updateIdCol, $updateIdVal) {
        $this->db->where($updateIdCol, $updateIdVal);
        $this->db->update($tableName, $data);
        return $this->db->affected_rows();
    }

    /*
     * delete record
     * @param {string} $tableName
     * @param {string} $whereCol
     * @param {string} $whereVal
     * @returns {int}
     */

    public function deleteData($tableName, $whereCol = '', $whereVal = '') {
        $this->db->delete($tableName, array($whereCol => $whereVal));
        return $this->db->affected_rows();
    }

    /*
     * delete multiple records
     * @param {string} $tableName
     * @param {string} $whereCol
     * @param {string} $whereVal
     * @returns {int}
     */

    public function deleteMultiple($tableName, $whereCol = '', $whereVal = '') {
        $this->db->where_in($whereCol, $whereVal);
        $this->db->delete($tableName);
        return $this->db->affected_rows();
    }

    /*
     * Count number of rows
     * @param {string} $tableName
     * @param {string} $whereCol
     * @param {string} $whereVal
     * @returns {int}
     */

    public function countRows($tableName, $whereCol = '', $whereVal = '', $like = 0, $orLike = 0, $status = 0) {
        $this->db->select('COUNT(*) AS `numrows`');
        if ($whereCol != '')
            $this->db->where(array($whereCol => $whereVal));
        if ($status == 1)
            $this->db->where('status', 1);
        if ($like != 0)
            $this->db->like($like);
        if ($orLike != 0) {
            foreach ($orLike as $col => $cond) {
                $this->db->or_like($col, $cond);
            }
        }
        $query = $this->db->get($tableName);
        return $query->row()->numrows;
    }

    /*
     * Generate a random string with 10 character
     */

    public function generateRandomString($length = 10) {
        return substr(str_shuffle("0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ"), 0, $length);
    }

    /*
     * Execute custom Query
     * @param {string} $qry
     * @returns {array}
     */

    public function customQuery($qry) {
        $query = $this->db->query($qry);
        return $query->result_array();
    }
    /*
     * return last executed query
     */
    public function print_query() {
        return $this->db->last_query();
    }
    /*
     * send mail
     * @param {string} $to 
     * @returns {string} $sub
     * @returns {array} $msg
     */
    public function sendMail($to, $sub, $msg) {
        $this->load->library('email');
        $this->email->set_mailtype("html");
        $this->email->from('abc@abc.com', 'Turner Information Mail');
        $this->email->to($to);
        $this->email->subject($sub);
        $this->email->message($msg);
        return $this->email->send();
    }

    /*
     * call paypal api for credit card payment
     * @param {string} $methodName (dodirectpayment)
     * @returns {string} $nvpStr_ ( string to call API )
     * @returns {array} api response
     */

    public function PPHttpPost($methodName_, $nvpStr_) {
        // Set up your API credentials, PayPal end point, and API version.  
        //$environment = 'live';                                      //live or sandbox  
        $environment = 'sandbox';                                      //live or sandbox  
        $API_UserName = urlencode('vipuln_1349947071_biz_api1.yahoo.com');           //paypal api username  
        $API_Password = urlencode('1349947145');              //paypal api password  
        $API_Signature = urlencode('A2JzD249c4LtceKyb5C0vw0LR8DBAuqr-7XGgDlVCnszDXlueE2cPb86');   //paypal api signature  

        if ($environment == 'sandbox') //// live 
            $subenvi = 'sandbox';  // $subenvi = ''; 
        else
            $subenvi = $environment . '.';

        $API_Endpoint = 'https://api-3t.' . $subenvi . '.paypal.com/nvp';

        $version = urlencode('51.0');                               //paypal version  
        // Set the curl parameters.  
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $API_Endpoint);
        curl_setopt($ch, CURLOPT_VERBOSE, 1);

        // Turn off the server and peer verification (TrustManager Concept).  
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, FALSE);

        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_POST, 1);

        // Set the API operation, version, and API signature in the request.  
        $nvpreq = "METHOD=$methodName_&VERSION=$version&PWD=$API_Password&USER=$API_UserName&SIGNATURE=$API_Signature$nvpStr_";
        // Set the request as a POST FIELD for curl.  
        curl_setopt($ch, CURLOPT_POSTFIELDS, $nvpreq);
        // Get response from the server.  
        $httpResponse = curl_exec($ch);
        if (!$httpResponse) {
            exit("$methodName_ failed: " . curl_error($ch) . '(' . curl_errno($ch) . ')');
        }
        // Extract the response details.  
        $httpResponseAr = explode("&", $httpResponse);

        $httpParsedResponseAr = array();
        foreach ($httpResponseAr as $i => $value) {
            $tmpAr = explode("=", $value);
            if (sizeof($tmpAr) > 1) {
                $httpParsedResponseAr[$tmpAr[0]] = $tmpAr[1];
            }
        }
        if ((0 == sizeof($httpParsedResponseAr)) || !array_key_exists('ACK', $httpParsedResponseAr)) {
            exit("Invalid HTTP Response for POST request($nvpreq) to $API_Endpoint.");
        }
        return $httpParsedResponseAr;
    }
 /* ******************************************************8 */
 	public	function getip() {
			return $_SERVER["REMOTE_ADDR"];
	}
		
	public	function getAddressFromIP($ip)	{
			$details = file_get_contents("http://freegeoip.net/json/".$ip); 
			return json_decode($details); 
	}
    
	public	function getGeoDataFromAddress($dlocation = '')	{
			    $address = $dlocation; // Google HQ
				$prepAddr = str_replace(' ','+',$address);
				$geocode=file_get_contents('http://maps.google.com/maps/api/geocode/json?address='.$prepAddr.'&sensor=false');
				$output= json_decode($geocode);  
				//debug($output);
				$geodata='';
				if(!empty($output->results))
				{
					$latitude = $output->results[0]->geometry->location->lat;
					$longitude = $output->results[0]->geometry->location->lng;
					$geodata['latitude'] = $latitude;
					$geodata['longitude'] = $longitude;
				}
				return $geodata;
	}
   
   //Calculate the time 		
	public	function time_elapsed_string($ptime)	{
		//$etime = time() - $ptime;  
		$etime = $ptime;
		//$time =time();
		//$etime= $time-$etime;
		if ($etime < 1)
		{
			return '0 seconds';
		}
		$a = array( 12 * 30 * 24 * 60 * 60  =>  'year',
					30 * 24 * 60 * 60       =>  'month',
					24 * 60 * 60            =>  'day',
					60 * 60                 =>  'hour',
					60                      =>  'minute',
					1                       =>  'second'
			);
		foreach ($a as $secs => $str)
		{
			$d = $etime / $secs;
			if ($d >= 1)
			{
				$r = round($d);
				return $r . ' ' . $str . ($r > 1 ? 's' : '') . ' ago';
			}
		}
	}

	public	function select_data_where($tablename, $where,$type='array')	{
		$this->load->database();		 
		$query = $this->db->get_where($tablename, $where);		 
		return ($type == 'object') ? $query->row() : $query->row_array();
	//	return  $query->row();		
	}
		
	public	function select_all_data($tablename,$type='array')	{
		$this->load->database();
		$str = "SELECT * FROM ".$tablename;
		$rs = $this->db->query($str);
		$row = $rs->result(); 
		return ($type == 'object') ? $rs->result() : $rs->result_array();
	}

	public	function select_all_data_orderBy($tablename,$type='array',$coulmn_name,$order_type ="ASC")	{
		$this->load->database();
		$str = "SELECT * FROM ".$tablename." order by ".$coulmn_name." ".$order_type;
		$rs = $this->db->query($str);
		$row = $rs->result(); 
		return ($type == 'object') ? $rs->result() : $rs->result_array();
	}
		
	public	function select_data_where_result($tablename, $where,$order_byArr='',$type='array')	{
		$this->load->database();
		if(!empty($order_byArr))
		{
			$order_Arr = explode("+",$order_byArr);
			$this->db->order_by($order_Arr[0],$order_Arr[1]); 
		}			 
		$query = $this->db->get_where($tablename, $where);		 
		return ($type == 'object') ? $query->result() : $query->result_array();
	}
		
	public	function select_data_where_result_limit($tablename, $where,$limit, $offset,$type='array')	{
		$this->load->database();		 
		$query = $this->db->get_where($tablename, $where,$limit, $offset);		 
		return ($type == 'object') ? $query->result() : $query->result_array();	
	}
	
	public	function insert_entry($tablename, $data)	{
       	if($this->db->insert($tablename, $data)) 
		{
			$id = $this->db->insert_id();
			return $id;
		}
		else
		{
			return false;
		}
	}
		
	public	function update_entry($tablename,$where_key,$where_value,$updateData,$where_in="")	{
		$this->load->database();
		//	$updateData=array('status' => 1);
		if(empty($where_in))
			$this->db->where($where_key,$where_value);
		else
		$this->db->where_in($where_key,$where_value);			
		
	    $query=$this->db->update($tablename,$updateData);
		$retArr = null;
		if($this->db->affected_rows()>0)
		{ 
			$retArr=1;
		}
		return $retArr;
	}
	
	
		
	public	function get_all_tableCoulmn($table_name)	{
		$this->load->database();
		$str = "Select * FROM $table_name";
		$rs = $this->db->query($str);
		$row = $rs->row(); 
		$all_fields='';
		foreach ($rs->row()  as $key=>$row)
		{				
			$all_fields[] = $key;								
		}
		return $all_fields;
	}	
	
	public function get_max_value($table_name,$column_name,$array)	{
		$this->db->select_max($column_name);
		//$this->db->where('name', $name); 
		$this->db->where($array); 
		$query = $this->db->get($table_name);
		return  $query->row();	
	}		
	
	public function select_data_where_count($tablename, $where)	{
		$this->load->database();		 
		$query = $this->db->get_where($tablename, $where);		 
		return  $query->num_rows(); 
	}
		
	public function select_coulmn_data_where($coulmn_name,$table_name,$where,$value)	{
		$str = "SELECT ".$coulmn_name." from ".$table_name." where ".$where." = '".$value."'"; 
		$query = $this->db->query($str);
		$result = $query->result();
		$ids = array();
		if($result)
		{
			foreach($result as $res)
			{
				$ids[] = $res->$coulmn_name; 
			}
		}
		return $ids;	
	}

	public function run_row_query($str)
	{
		$query = $this->db->query($str);
		$row = $query->row();	
		return $row;		
	}
	public function run_result_query($str,$type='array')
	{
		$query = $this->db->query($str);
		return ($type == 'object') ? $query->result() : $query->result_array();		
	}
	public function select_coulmn_data_where_in($coulmn_name,$table_name,$where,$value)	{
		$str = "SELECT ".$coulmn_name." from ".$table_name." where ".$where.' in('.$value.')'; 
		$query = $this->db->query($str);
		$result = $query->result();
		$ids = array();
		if($result)
		{
			foreach($result as $res)
			{
				$ids[] = $res->$coulmn_name; 
			}
		}
		return $result;	
	}

	public function select_coulmnOnlyName_data_where_in($coulmn_name,$table_name,$where,$value)	{
		$str = "SELECT ".$coulmn_name." from ".$table_name." where ".$where.' in('.$value.')'; 
		$query = $this->db->query($str);
		$result = $query->result();
		$ids = array();
		if($result)
		{
			foreach($result as $res)
			{
				$ids[] = $res->$coulmn_name; 
			}
		}
		return $ids;	
	}
	

	
	public function select_combineTwoCoulmn_data_where_in($coulms_name,$table_name,$where,$value,$sortData=array())	{
		
		if (empty($sortData))
			$str = "SELECT ".$coulms_name." from ".$table_name." where ".$where.' in('.$value.')'; 
		else 
			$str = "SELECT ".$coulms_name." from ".$table_name." where ".$where.' in('.$value.') order by '.$sortData['sortCol'].' '.$sortData['orderBy']; 
		
		$query = $this->db->query($str);
		$result = $query->result_array();
		
		//echo "<pre>"; print_r($result); echo "</pre>";die();
		$ids = array();
		if($result)
		{
			foreach($result as $res)
			{
				//echo "<pre>"; print_r($res); echo "</pre>";die();
				$first_value = reset($res); // First Element's Value
				$second = end($res); // First Element's Value
				$ids[$second] = $first_value; 
			}
		}
		return $ids;	
	//	echo "<pre>"; print_r($ids); echo "</pre>");
	}	
	public function select_single_coulmn_data($coulmn_name,$table_name)	{
		$str = "SELECT ".$coulmn_name." from ".$table_name; 
		$query = $this->db->query($str);
		$result = $query->result();
		$ids = array();
		if($result)
		{
			foreach($result as $res)
			{
				$ids[] = $res->$coulmn_name; 
			}
		}
		return $ids;	
	}
	
	public function select_single_coulmn_data_with_distinct($coulmn_name,$table_name,$where=array(),$sortData,$where_in=array())	{
		
		 $userId = $this->session->userdata('logged_in')['userId'];
		if($userId != '') { $userDetails =  $this->select_data_where('users',array('userId'=>$userId)); }
		
		$this->db->select('DISTINCT('.$coulmn_name.')');  
		$this->db->from($table_name); 
			
		if($table_name == "users")
		{
			$userType = $userDetails['userType'];

			$roleTypes = array();
			if($userType == 'SA')
				$roleTypes = array('SA','A','M', 'C','V');
			else if($userType == 'A')
				$roleTypes = array('M','C','V');
			else if($userType == 'M')
				$roleTypes = array('C','V');   
			else if($userType == 'C')
				$roleTypes = array('V');   			
				
			if(isset($userDetails) && !empty($userDetails['userRegionId']) && $userDetails['userType'] != 'SA')
				$this->db->where_in('userRegionId', $userDetails['userRegionId']);


			$this->db->where_in('userType', $roleTypes);
			
			$this->db->where_not_in('userId', $userId);
			
			
		}
		if($table_name == "assets")
		{		
		  if(isset($userDetails) && !empty($userDetails['userRegionId']) && $userDetails['userType'] != 'SA')
			$this->db->join('users', 'users.userId = assets.asset_addedBy_id and users.userRegionId ='.$userDetails['userRegionId']);
			
			//$this->db->where_not_in('asset_addedBy_id', $userId);
		}

		if(!empty($where))
		{							
			foreach ($where as $coulmnName => $values) {			
				$this->db->where($coulmnName, $values);
			}
		}
		if($where_in != '')	{
			foreach ($where_in as $coulmnName => $values) {	
					$chkArr =  explode("|",trim($values));
					$this->db->where_in($coulmnName, $chkArr);				
			}
		} 
		if (!empty($sortData))
            $this->db->order_by($sortData['sortCol'], $sortData['orderBy']);		
            
		$query = $this->db->get();
		//echo $this->logicalexpert_model->print_query();
		
		$result = $query->result();
		$ids = array();
		if($result)
		{
			foreach($result as $res)
			{
				$ids[] = $res->$coulmn_name; 
			}
		}
		
		return $ids;	
	}	   
	
	
	public function delete_data_where_in($coulmn_name,$table_name,$invalue)	{
		$str = "delete from ".$table_name." where ".$coulmn_name." in(".$invalue.")";
		$query = $this->db->query($str);
		if($query)
		{
			return true;
		}
		else
		{
			return false;
		}
	}
	
	public function select_data_where_in_result($tablename,$where,$in_field,$in_value,$type = 'array')	{
			$this->load->database();	
			$this->db->where_in($in_field,$in_value);	 
			$query = $this->db->get_where($tablename, $where);		 
			return ($type == 'object') ? $query->result() : $query->result_array();
	}
	
	public function select_coulmn_single_data($coulmn_name,$table_name,$field,$value,$type='array')	{
		$str = "SELECT ".$coulmn_name." from ".$table_name." where ".$field." = '".$value."'"; 
		$query = $this->db->query($str);
		
		return ($type == 'object') ? $query->row() : $query->row_array();
	}	

	public function select_coulmn_single_value($coulmn_name,$table_name,$field,$value)	{
		$str = "SELECT ".$coulmn_name." from ".$table_name." where ".$field." = '".$value."'"; 
		$query = $this->db->query($str);
		$result =  $query->row_array();
		$retCloulmn = '';
		if(!empty($result))
		{
			$retCloulmn = $result[$coulmn_name];
		}		
		return $retCloulmn;
	}
	
	public function all_thumb_genrater($path,$end)	{
		$configs = array();
		$configs[] = array('source_image' => $end, 'new_image' => 'thumbs/29/'.$end, 'width' => 29, 'height' => 29, 'maintain_ratio' => FALSE);
		$configs[] = array('source_image' => $end, 'new_image' => 'thumbs/31/'.$end, 'width' => 31, 'height' => 31, 'maintain_ratio' => FALSE);
		$configs[] = array('source_image' => $end, 'new_image' => 'thumbs/48/'.$end, 'width' => 48, 'height' => 48, 'maintain_ratio' => FALSE);
		$configs[] = array('source_image' => $end, 'new_image' => 'thumbs/198/'.$end, 'width' => 198, 'height' => 198, 'maintain_ratio' => FALSE);
		$configs[] = array('source_image' => $end, 'new_image' => 'thumbs/500/'.$end, 'width' => 500, 'height' => 500, 'maintain_ratio' => FALSE);
		$configs[] = array('source_image' => $end, 'new_image' => 'thumbs/76x69/'.$end, 'width' => 76, 'height' => 69, 'maintain_ratio' => FALSE);
		$configs[] = array('source_image' => $end, 'new_image' => 'thumbs/142x107/'.$end, 'width' => 142, 'height' => 107, 'maintain_ratio' => FALSE);
		$configs[] = array('source_image' => $end, 'new_image' => 'thumbs/197x255/'.$end, 'width' => 197, 'height' => 255, 'maintain_ratio' => FALSE);
		$configs[] = array('source_image' => $end, 'new_image' => 'thumbs/75x63/'.$end, 'width' => 75, 'height' => 63, 'maintain_ratio' => FALSE);
		$configs[] = array('source_image' => $end, 'new_image' => 'thumbs/101x74/'.$end, 'width' => 101, 'height' => 74, 'maintain_ratio' => FALSE);
		$configs[] = array('source_image' => $end, 'new_image' => 'thumbs/100x79/'.$end, 'width' => 100, 'height' => 79, 'maintain_ratio' => FALSE);
                
		// Loop through the array to create thumbs
		$this->load->library('image_lib');
		foreach ($configs as $config) {
			//$this->image_lib->thumb($config, FCPATH . 'application/upload/avatar/');
			$this->image_lib->thumb($config, $path);
			
		}
		// Pass the config array to the view
		return $data = array('images' => $configs);
	}		
	
	public	function genrater_assets_thumb($end)
	{
		$configs = array();
		//$configs[] = array('source_image' => $end, 'new_image' => 'thumbs/500/'.$end, 'width' => 500, 'height' => 500, 'maintain_ratio' => FALSE);
		$configs[] = array('source_image' => $end, 'new_image' => 'thumbs/316x243/'.$end, 'width' => 316, 'height' => 243, 'maintain_ratio' => FALSE);
                
                /*********************************************************/
                $configs[] = array('source_image' => $end, 'new_image' => 'thumbs/270x200/'.$end, 'width' => 270, 'height' => 200, 'maintain_ratio' => FALSE);
                $configs[] = array('source_image' => $end, 'new_image' => 'thumbs/349x280/'.$end, 'width' => 349, 'height' => 280, 'maintain_ratio' => FALSE);
                /**********************************************************/
		//	$configs[] = array('source_image' => $end, 'new_image' => 'thumbs/198x200/'.$end, 'width' => 198, 'height' => 200, 'maintain_ratio' => FALSE);
		//	$configs[] = array('source_image' => $end, 'new_image' => 'thumbs/500/'.$end, 'width' =>500, 'height' => 500, 'maintain_ratio' => FALSE);
		// Loop through the array to create thumbs
		$this->load->library('image_lib');
                ini_set('memory_limit', '1280M');
		foreach ($configs as $config) {
			$this->image_lib->thumb($config, FCPATH . '/uploads/assets_photos/');
                        $this->image_lib->clear();
                        
		}
		// Pass the config array to the view
		return $data = array('images' => $configs);
	}
			
			
				
	public	function delete_from_all_thumbs($end)	{
		//echo	$end;
		$adirArr = array('29','31','48','198','76x69','142x107','197x255','75x63','101x74','100x79');
		foreach($adirArr as $dir_name)
		{	
			if(file_exists(dirname(dirname(__FILE__)).'/upload/avatar/thumbs/'.$dir_name.'/'.$end))
			{ 
				unlink(dirname(dirname(__FILE__)).'/upload/avatar/thumbs/'.$dir_name.'/'.$end);
			}		
		}
	}

	function get_asset_thumbnail($image_name,$size)
	{
		
	 	$upload_path = dirname(dirname(dirname(__FILE__))).'/uploads/assets_photos/';
		//echo  $upload_pathFile = $upload_path.'thumbs/'.$size.'/'.$image_name;
		if(file_exists($upload_path.'thumbs/'.$size.'/'.$image_name))
		{
			$img = URL.'uploads/assets_photos/thumbs/'.$size.'/'.$image_name;
		}	
		else
		{
			$img = URL.'uploads/assets_photos/'.$image_name;
			
		}
		return $img;
	}	
	
	function turner_send_email($to,$subject,$message='',$heading='',$from='donotreply@tcdam.com',$cc='',$bcc='',$your_name='Developer')
{
	
	$to = $to;
	$from_name = "tcdam";
	$from_address = $from;
    $header = "MIME-Version: 1.0" . "\r\n";
    $header .= "From: Tcdan <".$from.">" . "\r\n";
    $header .= "Content-type:text/html;charset=iso-8859-1" . "\r\n";
	
	
						$messageBody ="	<table width='590' border='0' align='center' cellpadding='0' cellspacing='0' style='border:solid 1px #dfdfdf; background:url(images/bg.jpg) repeat center top;'>
									<tr>
										<td valign='top'><table width='100%' border='0' cellspacing='0' cellpadding='15'>
											<tr>
												<td valign='top' style='font-family:Arial, Tahoma; font-size:13px; color:#484848; line-height:18px;'>
												<h2 style='color:#A2BC8D;'>".$heading."</h2>

												
												<table>

												<tr>

												 <td>".$message."</td>

												</tr>

												

											   </table>
											</tr>

										</table></td>
								</tr>
								<tr>
								<td valign='top' style='border-top:solid 1px #dfdfdf; padding:10px;'><table width='100%' border='0' cellspacing='0' cellpadding='0'>
								<tr>
									<td width='56%' valign='middle'>
										  </td>

											<td width='44%' align='right' valign='middle' style='font-family:arial, tahoma; color:#afafb0; font-size:11px;'>Copyrights 2015 tcdam.com. All Rights Reserved.</td>

										</tr>

									</table></td>

								</tr>

							</table>";
		return	mail($to, $subject, $messageBody,$header);
	}
	
	function attachment_metadata($assets_id)
	{
		$metadata =  array();
		$where['assets_id'] = $assets_id;
		$assetDetail = $this->select_data_where('assets', $where);
		$path = dirname(dirname(dirname(__FILE__))).'/uploads/'.$assetDetail['assets_type_name'].'/'.$assetDetail['assets_image'];
		$size = getimagesize($path, $info);
		$updateData =  array();
		if ($size['channels'] === 4 && !empty($size)) {
			$updateData['color'] = 'CMYK';
		} elseif ($size['channels'] === 3 && !empty($size)) {
			$updateData['color'] = 'RGB';
		}
		else {
			$updateData['color'] = '';
		}		
		
		$uploadedFileSize = filesize($path);
		$uploadedFileSize = $this->formatSizeUnits($uploadedFileSize);
		$updateData['file_size'] = $uploadedFileSize;
		//echo "<pre>";print_r($size); echo "</pre>";
		$data = read_exif_data($path, 0, true);
		if(!empty($data))
		{
			$updateData['height'] = $data['COMPUTED']['Height'];
			$updateData['width'] = $data['COMPUTED']['Width'];
                        
		}
		
		echo "<pre>";print_r($data); echo "</pre>";
		if(isset($info['APP13']))
		{
			$iptc = iptcparse($info['APP13']);
			
			/* echo '<PRE>';
			print_r($iptc); exit; */
			$humanIPTC = $this->human_readable_iptc(iptcparse($info['APP13']));
			//echo "<pre>";print_r($iptc); echo "</pre>";
			
			$job_identifier =  isset($iptc['2#103']['0'])?$iptc['2#103']['0']:'';
			$metadata['ID'] =  $job_identifier;
							
			$headline = isset($iptc['2#105'][0])?$iptc['2#105'][0]:'';
			$metadata['title'] = $headline;
			$description = isset($iptc['2#120'][0])?$iptc['2#120'][0]:'';
			$metadata['description'] =trim($description);								
			if(isset($iptc['2#025']))	{
				$string = implode(", ", $iptc['2#025']);
				$metadata['keywords'] =  trim($string) ;
			}				
			else {
				$metadata['keywords'] =  '';
			}
			
			$creator = isset($iptc["2#080"][0])?$iptc["2#080"][0]:'';
			$metadata['creator'] =  $creator; 	

			$copyright = isset($iptc["2#116"][0])?$iptc["2#116"][0]:'';
			$metadata['copyright'] =  $copyright; 
											
			$file_name = isset($data['FILE']['FileName'])?$data['FILE']['FileName']:'';
		//	$metadata['assets_image'] = $file_name;				


			$job_title = isset($iptc['2#085'][0])?$iptc['2#085'][0]:'';
			$metadata['business_unit'] =  $job_title;

			
			if(isset($iptc['2#055'][0]))
			{
				$time = $iptc['2#055'][0];
				$year = substr($time, 0, 4);
				$month = substr($time, 4, 2);
				$day = substr($time, -2);
				$metadata['yearMonthDate'] = $year.'-'.$month.'-'.$day;
				$datetaken = date('l F jS Y', mktime(0, 0, 0, $month, $day, $year));
				$metadata['datetaken'] = $datetaken;
			}
			else
			{
				$metadata['year']='';	$metadata['month']='';	$metadata['day']='';	$metadata['datetaken']='';	
			}
			
			$city = isset($iptc["2#090"][0])?$iptc["2#090"][0]:'';
			$metadata['city'] = $city;
			
			$state = isset($iptc["2#095"][0])?$iptc["2#095"][0]:'';
			$metadata['state'] = $state;
			
			
			$country = isset($iptc["2#101"][0])?$iptc["2#101"][0]:'';
			$metadata['country'] = $country;
			
			$contact = isset($iptc["2#118"][0])?$iptc["2#118"][0]:'';
			$metadata['phone'] = $contact;	

				
			if(isset($data['IFD0']['XResolution']))
			{
				$res = explode("/", $data['IFD0']['XResolution']);
				$resolution=$res[0]/$res[1];
				$metadata['resolution'] =  $resolution ;
				$orientation='';
				if($data['COMPUTED']['Width'] > $data['COMPUTED']['Height']){
					$orientation='Horizontal';
				}else if($data['COMPUTED']['Width'] < $data['COMPUTED']['Height']){
					$orientation='Vertical';
				}else{
					$orientation='Square';
				}
				$metadata['orientation'] = $orientation ;
			}
			else
			{
				$metadata['resolution']=''; $metadata['orientation']=''; 
			}
			//echo "<pre>";print_r($metadata); echo "</pre>";
			
			if(!empty($metadata)) {  foreach($metadata as $metaKey=>$metaVal){ if(!empty($metaVal)) { $updateData[$metaKey] = $metaVal; } } }
		
//store dimensions in inches//
          if(isset($updateData['resolution']) && $updateData['width'] && $updateData['height'])
          {
                   $inchWidth = $updateData['width'] / $updateData['resolution'];
	           $inchHeight = $updateData['height'] / $updateData['resolution']; 
                   $updateData['fileWidth_inch']  =  round($inchWidth,1); 
                   $updateData['fileHeight_inch'] = round($inchHeight,1);
          }
          
          }		
		$this->update_entry('assets','assets_id',$assets_id,$updateData);
		return $metadata;
	  } 
	
	
	function human_readable_iptc($iptc) {
		# From the exiv2 sources
		static $iptc_codes_to_names =
		array(    
		// IPTC.Envelope-->
		"1#000" => 'ModelVersion',
		"1#005" => 'Destination',
		"1#020" => 'FileFormat',
		"1#022" => 'FileVersion',
		"1#030" => 'ServiceId',
		"1#040" => 'EnvelopeNumber',
		"1#050" => 'ProductId',
		"1#060" => 'EnvelopePriority',
		"1#070" => 'DateSent',
		"1#080" => 'TimeSent',
		"1#090" => 'CharacterSet',
		"1#100" => 'UNO',
		"1#120" => 'ARMId',
		"1#122" => 'ARMVersion',
		// <-- IPTC.Envelope
		// IPTC.Application2 -->
		"2#000" => 'RecordVersion',
		"2#003" => 'ObjectType',
		"2#004" => 'ObjectAttribute',
		"2#005" => 'ObjectName',
		"2#007" => 'EditStatus',
		"2#008" => 'EditorialUpdate',
		"2#010" => 'Urgency',
		"2#012" => 'Subject',
		"2#015" => 'Category',
		"2#020" => 'SuppCategory',
		"2#022" => 'FixtureId',
		"2#025" => 'Keywords',
		"2#026" => 'LocationCode',
		"2#027" => 'LocationName',
		"2#030" => 'ReleaseDate',
		"2#035" => 'ReleaseTime',
		"2#037" => 'ExpirationDate',
		"2#038" => 'ExpirationTime',
		"2#040" => 'SpecialInstructions',
		"2#042" => 'ActionAdvised',
		"2#045" => 'ReferenceService',
		"2#047" => 'ReferenceDate',
		"2#050" => 'ReferenceNumber',
		"2#055" => 'DateCreated',
		"2#060" => 'TimeCreated',
		"2#062" => 'DigitizationDate',
		"2#063" => 'DigitizationTime',
		"2#065" => 'Program',
		"2#070" => 'ProgramVersion',
		"2#075" => 'ObjectCycle',
		"2#080" => 'Byline',
		"2#085" => 'BylineTitle',
		"2#090" => 'City',
		"2#092" => 'SubLocation',
		"2#095" => 'ProvinceState',
		"2#100" => 'CountryCode',
		"2#101" => 'CountryName',
		"2#103" => 'TransmissionReference',
		"2#105" => 'Headline',
		"2#110" => 'Credit',
		"2#115" => 'Source',
		"2#116" => 'Copyright',
		"2#118" => 'Contact',
		"2#120" => 'Caption',
		"2#122" => 'Writer',
		"2#125" => 'RasterizedCaption',
		"2#130" => 'ImageType',
		"2#131" => 'ImageOrientation',
		"2#135" => 'Language',
		"2#150" => 'AudioType',
		"2#151" => 'AudioRate',
		"2#152" => 'AudioResolution',
		"2#153" => 'AudioDuration',
		"2#154" => 'AudioOutcue',
		"2#200" => 'PreviewFormat',
		"2#201" => 'PreviewVersion',
		"2#202" => 'Preview',
		// <--IPTC.Application2
		);
		$human_readable = array();
		foreach ($iptc as $code => $field_value) {
			$human_readable[$iptc_codes_to_names[$code]] = $field_value;
		}
		return $human_readable;
		//http://php.net/manual/en/function.iptcembed.php
	}	
	
	
	function formatSizeUnits($bytes)
	{
		if ($bytes >= 1073741824)
		{
			$bytes = number_format($bytes / 1073741824, 2) . ' GB';
		}
		elseif ($bytes >= 1048576)
		{
			$bytes = number_format($bytes / 1048576, 2) . ' MB';
		}
		elseif ($bytes >= 1024)
		{
			$bytes = number_format($bytes / 1024, 2) . ' KB';
		}
		elseif ($bytes > 1)
		{
			$bytes = $bytes . ' bytes';
		}
		elseif ($bytes == 1)
		{
			$bytes = $bytes . ' byte';
		}
		else
		{
			$bytes = '0 bytes';
		}

		return $bytes;
	}	
	// Function for encryption
	function encrypt($data) {
		return base64_encode(base64_encode(base64_encode(strrev($data))));
	}

	// Function for decryption
	function decrypt($data) {
		return strrev(base64_decode(base64_decode(base64_decode($data))));
	}	
	
	function filterFields_html($coulmnArray,$coulmn_name,$valueType="same",$filterData=array(),$sessionFilter=array())
	{
			$filterFields_htmlArr = array();
		
		$disableClearFiletButton = '';
		$selectAllCheckboxChecked='';
		if(count($coulmnArray)==count($sessionFilter))
		{
			$disableClearFiletButton = 'disabled="true"';
		}
		
		$filterFields_htmlArr[] = '<input type="hidden" class="openBosStatus" id="openBosStatus_'.$coulmn_name.'" value="'.$coulmn_name.'" />';
		$filterFields_htmlArr[] = '<div class="filter-order-div">';
		$filterFields_htmlArr[] = '<span class="ascending"  ><input type="button" onclick="userCoulmnOrderChange('."'ASC','".$coulmn_name."'".')" value="A to Z"></span>';
		$filterFields_htmlArr[] = '<span class="descending" ><input type="button"  onclick="userCoulmnOrderChange('."'DESC','".$coulmn_name."'".')"  value="Z to A"></span>';
		$filterFields_htmlArr[] = '<span class="clearFilterBox" > <input type="button" id="clearFilterBoxButton-'.$coulmn_name.'" value="Clear" '.$disableClearFiletButton.'  onclick="clearFilterBox('."'".$coulmn_name."'".')" /> </span>';
		$filterFields_htmlArr[] = '</div>';
		
		$filterFields_htmlArr[] = '<form class="the-filter-form"  method="POST" id="filterForm-'.$coulmn_name.'">';
		$filterFields_htmlArr[] = '<div class="inner-drop-box">	';
		
		if(!empty($coulmnArray))
		{
			if($valueType=="same")
			{
				foreach($coulmnArray as $item)
				{
					$checked = '  ';
					if(!empty($sessionFilter)  && in_array($item, $sessionFilter))
					{
						$checked = ' checked ';
					}
				
					$filterFields_htmlArr[] = '<div class="form-row"><input type="checkbox" '.$checked.' class="filter_checkbox_'.$coulmn_name.'" name="checkBoxFilterField_'.$coulmn_name.'" value="'.$item.'" /><label>'.$item.'</label></div>	';
				}	
			}
			else 
			{
				foreach($coulmnArray as $name=>$value)
				{
					//print_r($filterData);
					//echo $value;
					$checked = '  ';
					if(!empty($sessionFilter)  && in_array($value, $sessionFilter))
					{
						$checked = ' checked ';
					}
					$filterFields_htmlArr[] = '<div class="form-row"><input type="checkbox"  '.$checked.' class="filter_checkbox_'.$coulmn_name.'" name="checkBoxFilterField_'.$coulmn_name.'" value="'.$value.'" /><label>'.$name.'</label></div>	';
				}					
			}	
		}
		$filterFields_htmlArr[] = '</div>';
			
		$filterFields_htmlArr[] = '<div class="all-section">';
		$filterFields_htmlArr[] = '<input type="checkbox" checked id="allFilterCheckbox_'.$coulmn_name.'" onclick="checkAllFilterCheckbox('."'".$coulmn_name."'".')" > <label>All</label>';
		$filterFields_htmlArr[] = '</div>';
			
		$filterFields_htmlArr[] = '<div class="btn-block">';
		$filterFields_htmlArr[] = '<input type="button" onclick="runFilterAction('."'".$coulmn_name."'".')" value="OK" class="btn ok"><input type="button" onclick="close_filter_box()" value="Cancel" class="btn cancel">';
		$filterFields_htmlArr[] = '</div>';
				
		$filterFields_htmlArr[] = '</form>';
		
		$filterFields_html =  implode('',$filterFields_htmlArr);
		
		return $filterFields_html ;
	}
	
	function cart_order_by_vanture($cartData=array(),$key='venture_id')
	{
		$array = array_values($cartData);
		
		
		$templevel=0;   

		$newkey=0;

		$grouparr[$templevel]="";

		foreach ($array as $key => $val) {
				//echo "<pre>"; print_r($val['venture_id']); echo "</pre>";
			if ($templevel==$val['venture_id']){
				$grouparr[$templevel][$newkey]=$val;
			} else {
				$grouparr[$val['venture_id']][$newkey]=$val;
			}
			$newkey++;       
		}
		
		return $grouparr;
	}
	
	function get_country_currency($country_id='99',$currencyType='currencySymbol')
	{
		$currencyDetailArray =  array();
		$currencyDetailArray['99'] = array('currencyName'=>'INR','currencySymbol'=>'₹');
		$currencyDetailArray['223'] = array('currencyName'=>'USD','currencySymbol'=>'$');
		$currencyDetailArray['221'] = array('currencyName'=>'EUR','currencySymbol'=>'€');
		$currencyDetailArray['176'] = array('currencyName'=>'AED','currencySymbol'=>'AED');
		
		return $currencyDetailArray[$country_id][$currencyType];
			
	}
	
	public function return_venture_cuisine($venture_id,$returnType='id')
	{
		$str = "SELECT cuisine_name from gc_cuisine where cuisine_id in(select gc_venture_cuisine_map.cuisine_id from gc_venture_cuisine_map where gc_venture_cuisine_map.venture_id=".$venture_id."  )"; 
		$query = $this->db->query($str);
		$result = $query->result();
		$ids = array();
		if($result)
		{
			foreach($result as $res)
			{
				$ids[] = $res->cuisine_name; 
			}
		}
		return ($returnType == 'id') ? $ids : $result;
	}	
}
