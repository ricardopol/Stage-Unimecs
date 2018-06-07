<?php
class UniHr_Registration_Helper_Day{
	
	/**
	 * Get Day registration types
	 */
	public static function get_day_registration_types($user_id = null){
		$holyday_factor = UniHr_Helper_User::get_user_rates($user_id);
		$holyday_factor = isset($holyday_factor['additionional_rate_holiday'])?$holyday_factor['additionional_rate_holiday']:100;
		
		if(!empty($holyday_factor)){
			$holyday_factor = floatval($holyday_factor)/100;
		}
		
		$types = array(
			'Standaard'=>array(
					'label' => 'Standaard',
					'factor' => 1
			),
			array(
					'label' => 'Vakantie',
					'factor' => $holyday_factor
			),
			array(
					'label' => 'Ziek',
					'factor' => $holyday_factor
			),
			'Overuren 115%'=> array(
					'label' => 'Overuren 115%',
					'factor' => 1.15
			),
			'Overuren 128.26%'=> array(
					'label' => 'Overuren 128.26%',
					'factor' => 1.2826
			),			
			'Overuren 130%'=> array(
					'label' => 'Overuren 130%',
					'factor' => 1.3
			),
			'Overuren 136.93%'=> array(
					'label' => 'Overuren 136.93%',
					'factor' => 1.3693
			),
			'Overuren 145%'=> array(
				'label' => 'Overuren 145%',
				'factor' => 1.45
			),
			'Overuren 150%'=> array(
					'label' => 'Overuren 150%',
					'factor' => 1.5
			),
			'Overuren 175%'=>array(
					'label' => 'Overuren 175%',
					'factor' => 1.75
			),
			'Overuren 177%'=>array(
					'label' => 'Overuren 177%',
					'factor' => 1.77
			),
			'Overuren 180%'=>array(
				'label' => 'Overuren 180%',
				'factor' => 1.80
			),
			'Overuren 200%'=>array(
					'label' => 'Overuren 200%',
					'factor' => 2
			),
			'Overuren 220%'=>array(
					'label' => 'Overuren 220%',
					'factor' => 2.2
			),
			'Overuren 250%'=>array(
					'label' => 'Overuren 250%',
					'factor' => 2.5
			),
			'Overuren 265%'=>array(
					'label' => 'Overuren 265%',
					'factor' => 2.65
			),
			'Overuren 300%'=>array(
					'label' => 'Overuren 300%',
					'factor' => 3
			),
			 /*array(
					'label' => 'Vrije uren',
					'factor' => $holyday_factor
			),*/
		);
		
		return apply_filters('unihr-get_day_registration_types', $types);
	}
}