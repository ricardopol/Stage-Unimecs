<?php
class UniHr_DB_HourRegistration{

	/**
	 * Insert
	 * @param array $data
	 * @return number
	 */
	public function insert($data =array()){
		global $wpdb;

		$data = array_merge(array(
				'log_day' => '',
				'starttime' => '',
				'endtime' => '',
				'hours' => '',
				'hours_additional' => '',
				'hours_total' => '',
				'registration_type' => '',
				'user_id' => '',
		),$data);

		$table_name = $wpdb->prefix . 'unihr_hour_registration';
		$wpdb->insert($table_name,$data);

		return $wpdb->insert_id;
	}



	/* Update item */
	public function update($data =array()){
		global $wpdb;

		$data = array_merge(array(
				'log_day' => '',
				'starttime' => '',
				'endtime' => '',
				'hours' => '',
				'hours_additional' => '',
				'hours_total' => '',
				'registration_type' => '',
				'user_id' => '',
		),$data);

		$table_name = $wpdb->prefix . 'unihr_hour_registration';
		$where = array('user_id'=>$data['user_id'],'log_day'=>$data['log_day']);

		$updates = $wpdb->update($table_name,$data,$where);

		return $updates;
	}


	/**
	 * Get user Weeks
	 * @param unknown $user_id
	 * @return boolean|object|NULL
	 */
	public static function get_user_weeks($user_id= null,$output = OBJECT){
		global $wpdb;
		if($user_id===null){
			return false;
		}
		$sql = 'SELECT DISTINCT WEEK(log_day,1) as weeks, year(log_day) as year FROM unihrs_unihr_hour_registration WHERE user_id = '.$user_id;
		$results = $wpdb->get_results($sql,$output);
		return $results;
	}

	/**
	 * Get User week number
	 * @param unknown $user_id
	 * @param unknown $weeknumber
	 * @param unknown $year
	 * @return boolean|object|NULL
	 */
	public static function get_user_week($user_id,$weeknumber,$year,$output = OBJECT){
		global $wpdb;
		if($user_id===null){
			return false;
		}
		$sql = 'SELECT * FROM unihrs_unihr_hour_registration
				WHERE user_id = '.$user_id. ' AND WEEK(log_day,1) = '.$weeknumber.'	AND YEAR(log_day) = '.$year;
		$results = $wpdb->get_results($sql,$output);
		return $results;
	}

	/**
	 * Get total hours per week by user
	 * @param unknown $user_id
	 * @param string $output
	 * @return boolean|object|NULL
	 */
	public static function get_hour_total_per_week($user_id = null,$week_from,$week_till,$year,$output = OBJECT){
		global $wpdb;
		if($user_id===null){
			return false;
		}

		$wheres = array();
		$wheres[] = '1=1';
		if(!empty($week_from)){
			$wheres[] = ' WEEK(log_day,1)  >= '.$week_from;
		}

		if(!empty($week_till)){
			$wheres[] = ' WEEK(log_day,1)  <= '.$week_till;
		}

		if(!empty($year)){
			$wheres[] = ' YEAR(log_day) = '.$year;
		}

		$wheres = implode(" AND ", $wheres);

		$sql = "SELECT WEEK(log_day,1) as week, YEAR(log_day) as year,count(hours_total) as days ,sum(hours_total) as total
		FROM {$wpdb->prefix}unihr_hour_registration
		WHERE user_id = {$user_id}
		AND {$wheres}
		GROUP BY week, year ORDER BY week DESC, year DESC";

		$results = $wpdb->get_results($sql,$output);
		return $results;
	}

	public static function get_hour_totals_per_week_by_customer($cid = null,$week_from,$week_till,$year,$output = OBJECT){
		global $wpdb;

		$wheres = array();
		$wheres[] = '1=1';
		if(!empty($week_from)){
			$wheres[] = ' WEEK(log_day,1)  >= '.$week_from;
		}

		if(!empty($week_till)){
			$wheres[] = ' WEEK(log_day,1)  <= '.$week_till;
		}

		if(!empty($year)){
			$wheres[] = ' YEAR(log_day) = '.$year;
		}

		$wheres = implode(" AND ", $wheres);

		$sql = "SELECT WEEK(log_day,1) as week, YEAR(log_day) as year,hr.user_id, sum(hours) as hr_hours, count(hours_total) as days,sum(hours_total) as total
		FROM {$wpdb->prefix}unihr_hour_registration AS hr
		JOIN {$wpdb->prefix}usermeta as p on p.user_id = hr.user_id
		WHERE p.meta_key = 'customer' AND p.meta_value = {$cid} AND hours_total > 0
		AND {$wheres}
		GROUP BY week, year
		ORDER BY year DESC, week DESC";

		$results = $wpdb->get_results($sql,$output);
		return $results;
	}

	public static function get_hour_totals_per_week_by_customer_and_userid($cid = null,$userid =null,$week_from,$week_till,$year,$output = OBJECT){
		global $wpdb;

		$wheres = array();
		$wheres[] = '1=1';
		if(!empty($week_from)){
			$wheres[] = ' WEEK(log_day,1)  >= '.$week_from;
		}

		if(!empty($week_till)){
			$wheres[] = ' WEEK(log_day,1)  <= '.$week_till;
		}

		if(!empty($year)){
			$wheres[] = ' YEAR(log_day) = '.$year;
		}

		/* user id */
		$wheres[] = ' hr.user_id = '.$userid;

		$wheres = implode(" AND ", $wheres);

		$sql = "SELECT WEEK(log_day,1) as week, YEAR(log_day) as year,hr.user_id, sum(hours) as hr_hours, sum(hours_additional) as hr_hours_additional, count(hours_total) as days,sum(hours_total) as total,
		sum(IF(hr.hours>0||hr.hours_additional>0&&hr.registration_type NOT IN ('Vakantie','Ziek'),1,0)) as billable_days
		FROM {$wpdb->prefix}unihr_hour_registration AS hr
		JOIN {$wpdb->prefix}usermeta as p on p.user_id = hr.user_id
		WHERE p.meta_key = 'customer' AND p.meta_value = {$cid} AND hours_total > 0
		AND {$wheres}
		GROUP BY week, year,hr.user_id
		ORDER BY year DESC, week DESC";

		$results = $wpdb->get_results($sql,$output);
		return $results;
	}




	public static function get_grouped_hour_totals_per_week_by_customer_and_user($cid = null,$user_id = null,$week=null,$year,$output = OBJECT){
		global $wpdb;

		$wheres = array();
		$wheres[] = '1=1';


		if(!empty($user_id)){
			$wheres[] = 'hr.user_id = '.$user_id;
		}

		if(!empty($week)){
			$wheres[] = ' WEEK(log_day,1)  = '.$week;
		}


		if(!empty($year)){
			$wheres[] = ' YEAR(log_day) = '.$year;
		}

		$wheres = implode(" AND ", $wheres);

		$sql = "SELECT  WEEK(log_day,1) as week, YEAR(log_day) as year, hr.user_id, registration_type,
		sum(hours) as total_hours ,
		sum(hours_additional) as total_additional,
		sum(hours_total) as total
		FROM {$wpdb->prefix}unihr_hour_registration AS hr
		JOIN {$wpdb->prefix}usermeta as p on p.user_id = hr.user_id
		WHERE p.meta_key = 'customer' AND p.meta_value = {$cid} AND hours_total > 0
		AND {$wheres}
		GROUP BY year,week, hr.user_id, hr.registration_type
		ORDER BY week DESC, year, user_id, registration_type";

		$results = $wpdb->get_results($sql,$output);
		return $results;
	}


}
