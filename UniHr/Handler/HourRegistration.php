<?php
class UniHr_Handler_HourRegistration{


	/* Get data */
	public function get_data($user_id=null){

		if(!isset($_POST['reg-day-starttime'])){return;;}

		$keys = array_keys($_POST['reg-day-starttime']);

		$data = array();
		foreach ($keys as $key){

			$starttime = $_POST['reg-day-starttime'][$key];
			$endtime =   $_POST['reg-day-endtime'][$key];

			$hours =    $_POST['reg-day-hours'][$key];
			$hours_additional =   $_POST['reg-day-additional-hours'][$key];
			$hours_total =   	  $_POST['reg-day-additional-total'][$key];
			$registration_type =  $_POST['reg-day-type'][$key];


			/* Dataobject */
			$data[] = array(
				'log_day' => $key,
				'starttime' => $starttime,
				'endtime' => $endtime,
				'hours' => $hours,
				'hours_additional' => $hours_additional,
				'hours_total' => $hours_total,
				'registration_type' => $registration_type,
				'user_id' => $user_id,
			);
		}

		return $data;
	}

	public function process(){

		$user_id = get_current_user_id();
		$data = $this->get_data($user_id);
		if(!empty($data)){
			$this->add_data($data);

			/* Set apporovement data */
			$this->add_approvements($data,$user_id);
		}


	}

	/**
	 * Update user time
	 */
	public function process_update(){
		$user_id = sanitize_text_field($_POST['uid']);

		$data = $this->get_data($user_id);

		if(!empty($data)){
			$this->update_data($data);
			/* Set apporovement data */
			//$this->add_approvements($data,$user_id);
		}
	}



	public function add_approvements($results = array(),$user_id=null){
		if(empty($results)){
			return;
		}


		$register_weeks = array();
		$apporovement_manager = new UniHr_DB_WeekApprovement();


		$approvement_ids = array();
		foreach ($results as $data){
			if(isset($data['log_day'])){
				$year = date('Y',strtotime($data['log_day']));
				$week = date('W',strtotime($data['log_day']));
				if(!isset($register_weeks[$year][$week])){
					$register_weeks[$year][$week] = $week;

					$approvement = array(
							'weeknumber' => $week,
							'year' => $year,
							'user_id' => $user_id,
							'state' => UniHr_DB_WeekApprovement::WAITING,
							'email_approvement' => '',
					);
					$approvement_ids[] = $apporovement_manager->insert($approvement);

				}
			}
		}

		/* sending emails */
		$this->send_confirmation_emails($approvement_ids);
	}

	/**
	 * Send approvement ids
	 */
	protected function send_confirmation_emails($approvement_ids = array()){
		if(empty($approvement_ids)){return; }

		foreach ($approvement_ids as $id){
			$this->send_email_approvement_confirmation($id);
			$this->send_email_confirmation($id);

			error_log('Sending approvement emails');
		}
	}


	public function send_email_confirmation($id){
		$approvement = UniHr_DB_WeekApprovement::get_approvement_by_id($id);
		if(empty($approvement)){return;}

		$user = get_user_by('id', $approvement->user_id);
		if(empty($user)){return;}

		/* Email ondewerp */
		$to = $user->user_email;
		$subject = sprintf('Uren overzicht week %d %d',$approvement->weeknumber,$approvement->year);


		global $unihr_approvement;
		$unihr_approvement = $approvement;
		$content = theme_get_template_part('/email/approvement/user',null,false);

		$headers = array();
		$headers[] = 'Content-Type: text/html; charset=UTF-8';
		@wp_mail($to, $subject, $content,$headers);
	}

	public function send_email_approvement_confirmation($id){
		$approvement = UniHr_DB_WeekApprovement::get_approvement_by_id($id);
		if(empty($approvement)){return;}

		$user = get_user_by('id', $approvement->user_id);
		if(empty($user)){return;}

		/* Email ondewerp */
		$to = get_user_meta($user->ID,'supervisor_email',true);

		if(empty($to)){ return; }

		$subject = sprintf('Uren overzicht week %d %d',$approvement->weeknumber,$approvement->year);


		global $unihr_approvement;
		$unihr_approvement = $approvement;
		$content = theme_get_template_part('/email/approvement/manager',null,false);

		$headers = array();
		$headers[] = 'Content-Type: text/html; charset=UTF-8';

		$cc = get_user_meta($user->ID,'supervisor_email_2',true);
		if(!empty($cc)&&is_email($cc)){
			$headers[] = 'Cc: '.$cc;
		}

		@wp_mail($to, $subject, $content,$headers);
	}

	/**
	 * Add Data
	 * @param array $data
	 */
	protected function add_data($data = array()){
		$manager = new UniHr_DB_HourRegistration();
		$ids = array();
		foreach ($data as $item){
			$ids[] = $manager->insert($item);
		}

		return $ids;
	}

	/**
	 * Add Data
	 * @param array $data
	 */
	protected function update_data($data = array()){
		$manager = new UniHr_DB_HourRegistration();
		$ids = array();
		foreach ($data as $item){
			$ids[] = $manager->update($item);
		}

		/* Quick fix nothing updated not records available */
		/*
		if(array_sum($ids)==0){
			$ids = array();
			foreach ($data as $item){
				$ids[] = $manager->insert($item);
			}
		}
		return $ids;
		*/
	}
}
