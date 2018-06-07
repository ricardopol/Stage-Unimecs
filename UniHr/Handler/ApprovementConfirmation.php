<?php
/**
 * Customer Handler
 * @author User
 *
 */
class UniHr_Handler_ApprovementConfirmation{
	
	
	/* Get data */
	public function get_data(){
		
		$keys = array(
				'hr_approvement_id',
				'hr_uid',
				'approvement-comment',
				'accept-action',
		);
		
		$data = array();
		foreach ($keys as $key){
			/*Change base key*/
			$storage_key = str_replace('hr_', '', $key);
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
		$responce_data = $this->get_data();
		
		$data = array(
				'id' => $responce_data['approvement_id'],
				'log_comment' =>$responce_data['approvement-comment'],
				'user_id' => $responce_data['uid'],
		);
		
		if($responce_data['accept-action']==1){
			$data['state'] = UniHr_DB_WeekApprovement::APPROVED;
		}else{
			$data['state'] = UniHr_DB_WeekApprovement::DISAPPROVED;
		}
		
		if(isset($data['id'])){
			UniHr_DB_WeekApprovement::update_state($data);
		}
	}

}