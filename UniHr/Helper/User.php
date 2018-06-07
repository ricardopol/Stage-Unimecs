<?php
class UniHr_Helper_User{

	/**
	 * Get start time user
	 * @param unknown $user_id
	 */
	public static function get_starttime($user_id=null){
		$week = get_user_meta($user_id,'start_week',true);
		$year = get_user_meta($user_id,'start_week_year',true);

		return UniHr_Helper_Date::get_start_timestamp_week($week, $year);
	}


	/**
	 * Get user week year registrations
	 */
	public static function get_week_registrations($user_id=null){
		$results = UniHr_DB_HourRegistration::get_user_weeks($user_id,ARRAY_A);

		$data = array();
		foreach ($results as $week){
			$data[$week['year']][$week['weeks']] = $week['weeks'];
		}
		return $data;
	}

	/**
	 * is user week year registrations approved
	 */
	public static function is_week_registration_approved($user_id=null,$year=null,$weeknumber=null){
		//TODO implement is approved
		$result = UniHr_DB_WeekApprovement::get_approvement($user_id, $weeknumber, $year);
		return $result;
	}

	/**
	 * Get user rates
	 * @param unknown $user_id
	 * @return mixed[]|boolean[]|string[]|unknown[]
	 */
	public static function get_user_rates($user_id= null){
		$data = array();
		$keys = array(
			'hour_rate',
			'factor-hour-rate-customer',
			'factor-hour-rate-payroll',
			'travel_cost_a_day',
			'expences_a_week_customer',
			'expences_a_week_payroll',
			'additionional_rate_overtime',
			'additionional_rate_holiday',
		);

		foreach ($keys as $key){
			$data[$key] = get_user_meta($user_id,$key,true);
		}

		apply_filters('unihr-user-rates', $data);
		return $data;
	}

}
