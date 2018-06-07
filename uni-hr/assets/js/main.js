/* Registration */
jQuery('.week-container').on('change keyup','.reg-action-hours, .reg-action-total',function(){
	/* Hours */
	$ri = jQuery(this).closest('.registration-item');
	hours = $ri.find('.reg-action-hours').val();
	hours = parseFloat(hours);
	hours = isNaN(hours)?0:hours;
	
	/* Additional */
	
	additional_factor = $ri.find('.reg-action-hours-additional').data('factor');
	
	
	/* Total factor */
	total_factor = $ri.find('.reg-action-total option:selected').data('factor');
	total_factor = parseFloat(total_factor);
	total_factor = isNaN(total_factor)?1:total_factor;
	
	
	additional_factor = total_factor; 
		
	additional_total = $ri.find('.reg-action-hours-additional').val();
	additional_total = parseFloat(additional_total);
	additional_total = isNaN(additional_total)?0:additional_total;
	
	/* calculate factor */
	additional_total *=additional_factor;
	
	total = hours+additional_total;
	//total *=total_factor;
	
	/* Total */
	$ri.find('.reg-action-hours-total').val(total);
	
	/* Recalculate totals */
	$week_container = jQuery(this).closest('.week-container');
	
	
	/* calculate sum */
	sum_reg_action_hours =0;
	sum_reg_action_hours_additional =0;
	sum_reg_action_hours_total =0;
	
	/* Fields */
	$reg_action_hours = $week_container.find('.reg-hour');
	$reg_action_hours_additional = $week_container.find('.reg-hour-additional');
	$reg_action_hours_total = $week_container.find('.reg-hour-total');
	
	/* Calculate sum */
	$reg_action_hours.each(function(){
		value = jQuery(this).val();
		value = parseFloat(value)
		if(isNaN(value)){value=0; }
		sum_reg_action_hours += value
	});
	
	$reg_action_hours_additional.each(function(){
		value = jQuery(this).val();
		value = parseFloat(value)
		if(isNaN(value)){value=0; }
		sum_reg_action_hours_additional += parseFloat(value);
	});
	
	$reg_action_hours_total.each(function(){
		value = jQuery(this).val();
		value = parseFloat(value)
		if(isNaN(value)){value=0; }
		sum_reg_action_hours_total += parseFloat(value);
	});
	
	/* Set values */
	$week_container.find('.uni-week-sum-hours').val(sum_reg_action_hours.toFixed(2));
	$week_container.find('.uni-week-sum-additional-hours').val(sum_reg_action_hours_additional.toFixed(2));
	$week_container.find('.uni-week-total-sum').val(sum_reg_action_hours_total.toFixed(2));
});


jQuery(document).ready(function(){
	jQuery('#form-week-confirmation').on('click','.btn-submit',function(event){
		value = jQuery(this).val();
		$comment = jQuery('#form-comment-field');
		if(value==0){
			$comment.attr('required','required');
		}else{
			$comment.removeAttr('required');
		}
	});
});