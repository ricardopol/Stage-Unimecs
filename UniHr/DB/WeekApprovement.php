<?php
class UniHr_DB_WeekApprovement{
	const table_name ='unihr_week_approvement';
	
	/* States */
	const WAITING = 0;
	const APPROVED = 1;
	const DISAPPROVED = 2;
	
	/**
	 * Insert
	 * @param array $data
	 * @return number
	 */
	public function insert($data =array()){
		global $wpdb;
		
		$data = array_merge(array(
				'weeknumber' => '',
				'year' => '',
				'user_id' => '',
				'state' => '',
				'email_approvement' => '',
				'log_comment' =>'',
				'log_date' => '',
				'log_modified' => '',
		),$data);
		
		
		
		if(empty($data['log_date'])){
			$data['log_date'] = date("Y-m-d H:i",time());
		}
		
		if(empty($data['log_modified'])){
			$data['log_modified'] = date("Y-m-d H:i",time());
		}

		$table_name = $wpdb->prefix . UniHr_DB_WeekApprovement::table_name;
		$wpdb->insert($table_name,$data);
		return $wpdb->insert_id;
	}
	
	public static function update_state($data =array()){
		global $wpdb;
	
		$data = array_merge(array(
				'state' => '',
				'user_id' => '',
				'log_modified' => '',
		),$data);
	
		if(empty($data['log_modified'])){
			$data['log_modified'] = date("Y-m-d H:i",time());
		}
	
		$table_name = $wpdb->prefix . UniHr_DB_WeekApprovement::table_name;
		$where = array('user_id'=>$data['user_id'],'id'=>$data['id']);
		$wpdb->update($table_name,$data,$where);
		
		return $wpdb->insert_id;
	}
	
	
	public static function get_approvement($user_id,$weeknumber,$year){
		
		/*Sanitize input */
		$user_id = intval($user_id);
		$weeknumber = intval($weeknumber);
		$year  = intval($year);
		
		global $wpdb;
		
		$table_name = $wpdb->prefix.UniHr_DB_WeekApprovement::table_name;
		$sql = "SELECT * FROM $table_name WHERE user_id = $user_id AND weeknumber = $weeknumber AND year = $year";
		return $wpdb->get_row($sql);
	}
	
	public static function get_approvement_by_id($id = NULL){
		/*Sanitize input */
		$id = intval($id);
			global $wpdb;
	
		$table_name = $wpdb->prefix.UniHr_DB_WeekApprovement::table_name;
		$sql = "SELECT * FROM $table_name WHERE id = ".$id;
		return $wpdb->get_row($sql);
	}
}