<?php
class UniHr_Helper_Time extends UniHr_Helper_Date{


	/**
	 * Convert minutes to hour notation
	 * @param number $minutes
	 * @return string
	 */
	public static function minutes_to_hour_notation($minutes = 0){
		$t = intval($minutes);
		$t_hours = $t / 60; //since both are ints, you get an int
		$t_minutes = $t % 60;
		return sprintf("%02d:%02d", $t_hours, $t_minutes);
	}

}