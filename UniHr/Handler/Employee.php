<?php
/**
 * Customer Handler
 * @author User
 *
 */
class UniHr_Handler_Employee{
	
	
	/* Get data */
	public function get_data(){
		

		$keys = array(
				'employee_user_id',
				'employee_po_number',
				'employee_name',
				'employee_adres',
				'employee_zipcode',
				'employee_location_city',
				'employee_phone_number',
				'employee_mobile_number',
				'employee_email',
				'employee_hour_rate',
				'employee_start_week',
				'employee_start_week_year',
				'employee_customer',
				'employee_factor-hour-rate-customer',
				'employee_factor-hour-rate-payroll',
				'employee_travel_cost_a_day',
				'employee_expences_a_week_customer',
				'employee_expences_a_week_payroll',
				'employee_supervisor_name',
				'employee_supervisor_email',
				'employee_supervisor_name_2',
				'employee_supervisor_email_2',
				'employee_additionional_rate_overtime',
				'employee_additionional_rate_holiday',
		);
		
		$data = array();
		foreach ($keys as $key){
			/*Change base key*/
			$storage_key = str_replace('employee_', '', $key);
			
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
		
		if(isset($data['user_id'])){
			return $this->update_user($data);
		}else{
			return $this->create_new_user($data);
		}
		
	}
	
	/**
	 * Create new User
	 * @param unknown $data
	 */
	protected function create_new_user($data){
		$userdata = array(
				'user_login'  =>  $data['email'],
				'user_email'  =>  $data['email'],
				'user_pass'   =>  wp_generate_password()  // When creating an user, `user_pass` is expected.
		);
		
		if(!empty($data['name'])){
			$name = $data['name'];
			$userdata['display_name'] = $name;
			$userdata['first_name'] = $name;
		}
		
		$user_id = wp_insert_user( $userdata ) ;
		
		
		
		if ( ! is_wp_error( $user_id ) ) {
			$this->update_user_meta($user_id,$data);
			
			/* Create new user email */
			wp_new_user_notification($user_id,null,'user');
		}
		
		return $user_id;
	}
	
	
	/**
	 * Udate user id
	 * @param unknown $data
	 */
	protected function update_user($data){
		$userdata = array(
				'ID' => $data['user_id'],
				'user_login'  =>  $data['email'],
				'user_email'  =>  $data['email'],
		);
		
		
		if(!empty($data['name'])){
			$name = $data['name'];
			$userdata['display_name'] = $name;
			$userdata['first_name'] = $name;
		}
	
		//$user_id = wp_insert_user( $userdata ) ;
		$user_id = wp_update_user($userdata);
	
	
	
		if ( ! is_wp_error( $user_id ) ) {
			$this->update_user_meta($user_id,$data);
		}
		
		return $user_id;
	}
	
	
	protected function update_user_meta($user_id = null,$data = array()){
		$eclude_keys = array();
		
		foreach ($data as $key => $value){
			/* Skip keys */
			if(in_array($key,$eclude_keys)){
				continue; 
			}
			
			$meta_value = sanitize_text_field($value);
			update_user_meta($user_id, $key, $meta_value);
		}
	}

}