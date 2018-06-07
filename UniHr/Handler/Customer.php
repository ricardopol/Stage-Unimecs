<?php
/**
 * Customer Handler
 * @author User
 *
 */
class UniHr_Handler_Customer{
	
	
	/* Get data */
	public function get_data(){
		
		$keys = array(
				'customer_cid',
				'customer_name',
				'customer_adres',
				'customer_zipcode',
				'customer_location_city',
				'customer_phone_number',
				'customer_contact_person',
				'customer_contact_person_email',
				'customer_comment',
		);
		
		$data = array();
		foreach ($keys as $key){
			/*Change base key*/
			$storage_key = str_replace('customer_', '', $key);
			
			/* Get value and sanitize*/
			if(isset($_POST[$key])){
				$value = sanitize_text_field($_POST[$key]);
				$data[$storage_key] = $value;
			}
		}
		
		return $data;
	} 
	
	/* 
	 * process data 
	 */
	public function process(){
		$data = $this->get_data();
		if(isset($data['cid'])){
			$reponce = UniHr_DB_Customer::update($data);
		}else{
			$reponce = UniHr_DB_Customer::insert($data);
		}
	}

}