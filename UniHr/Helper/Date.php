<?php
class UniHr_Helper_Date{
	/**
	 * Get the start timestamp of the begin of the week
	 * @param unknown $weeknumber
	 * @param unknown $year
	 */
	public static function get_start_timestamp_week($weeknumber, $year){
		$timestamp = sprintf("%dW%s",$year,zeroise($weeknumber, 2));
		return strtotime($timestamp);
	}
}