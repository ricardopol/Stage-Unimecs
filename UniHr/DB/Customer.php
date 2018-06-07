<?php
/**
 * Unimecs Cusomer
 * @author User
 *
 */
class UniHr_DB_Customer{
	const table_name ='unihr_customer';
	
	/*
	 *  Insert 
	 */
	public static function insert($data = array()){
		global $wpdb;
		$data = array_merge(array(
			//'cid' => null,
			'name' => '',
			'adres' => '',
			'zipcode' => '',
			'location_city' => '',
			'phone_number' => '',
			'contact_person' => '',
			'contact_person_email' => '',
			'comment' => '',
		),$data);
		$table  = $wpdb->prefix.UniHr_DB_Customer::table_name;
		$wpdb->insert($table, $data);
		
		return $wpdb->insert_id;
	}
	
	/* Insert */
	public static function update($data = array()){
		global $wpdb;
		
		$data = array_merge(array(
				//'cid' => null,
				'name' => '',
				'adres' => '',
				'zipcode' => '',
				'location_city' => '',
				'phone_number' => '',
				'contact_person' => '',
				'contact_person_email' => '',
				'comment' => '',
		),$data);
		
		$where = array('cid'=>$data['cid']);
		$table  = $wpdb->prefix.UniHr_DB_Customer::table_name;
		$wpdb->update($table, $data,$where);
		
		return $data['cid'];
	}
	
	
	/**
	 * Get Customer by id
	 */
	public static function get_customer_by_id($cid = null, $output=OBJECT){
		global $wpdb;
		$query = sprintf('SELECT * FROM '.$wpdb->prefix.UniHr_DB_Customer::table_name.' WHERE cid = %d',$cid);
		$result = $wpdb->get_row($query,$output);
		return $result;
	}
	
	/**
	 * Get All Customers
	 */
	public static function get_customers(){
		global $wpdb;
		$query = sprintf('SELECT * FROM '.$wpdb->prefix.UniHr_DB_Customer::table_name.' ORDER BY name');
		$result = $wpdb->get_results($query);
		return $result;
	}
}