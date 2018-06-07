<?php


if(!class_exists('PHPExcel')){
	require_once UniHr_DIR.'/include/lib/PHPExcel/Classes/PHPExcel.php';
}

$user_ids = $_POST['uid'];


$currancy = "\xE2\x82\xAc ";
/* Set current cel */



$doc = new PHPExcel();
/* Loop user ids */
$user_count = 0;
foreach ($user_ids as $user_id){
	
	$user_po = get_user_meta($user_id,'po_number',true);
	$user_name = get_user_meta($user_id,'name',true);
	$doc->setActiveSheetIndex($user_count);
   $doc->getActiveSheet()->setTitle($user_name);
		
	$data = array();
	$user = get_user_by('ID', $user_id);
	if(empty($user)){
		continue;
	}
	
	
	$week_from = sanitize_text_field($_POST['periode-from-week']);
	$week_till = sanitize_text_field($_POST['periode-till-week']);
	$year = sanitize_text_field($_POST['periode-year']);
	
	$weeks = UniHr_DB_HourRegistration::get_hour_total_per_week($user_id,$week_from,$week_till,$year);
	
	$hour_sum = 0;
	$days_sum = 0;



    $data[] = array('PO-nummer',$user_po);
	$data[] = array('Naam',$user_name);
	$data[] = array('');
	
	$data[] = array('Jaar','Weeknummer','Maandag vd week','');
	foreach ($weeks as $week){
		//printf("%s - %s - %s - %s <br/>",$week->week,,$week->total,$week->days);
		
		/* Get first day of the week */
		$firstday_of_the_week = date_i18n('d - F',UniHr_Helper_Date::get_start_timestamp_week($week->week, $week->year));
		
		$data[] = array($week->year,$week->week,$firstday_of_the_week,number_format_i18n($week->total,2));
		$hour_sum += floatval($week->total);
		$days_sum += floatval($week->days);
	}
	$rates = UniHr_Helper_User::get_user_rates($user_id);
	
	//echo 'uren: '.$hour_sum.'<br/>';
	$data[] = array('','','totaal aantal uren',number_format_i18n($hour_sum,2));
	
	$hourrate = (isset($rates['hour_rate']))?floatval($rates['hour_rate']):0;
	$loon = floatval($hour_sum)*$hourrate;
	//echo 'uurloon: '.number_format_i18n($loon,2).'<br/>';
	$data[] = array('','', sprintf('Uurloon %s',number_format_i18n($hourrate,2)),$currancy.number_format_i18n($loon,2));
	
	$loon_factor_customer = (isset($rates['factor-hour-rate-customer']))?floatval($rates['factor-hour-rate-customer']):0;
	$factuur_klant = $loon*$loon_factor_customer;
	//echo 'factuur aanklant: '.number_format_i18n($factuur_klant,2).'<br/>';
	$data[] = array('','', sprintf('factuur aanklant X %s x uurloon',number_format_i18n($loon_factor_customer,2)),$currancy.number_format_i18n($factuur_klant,2));
	
	$loon_factor_payroll = (isset($rates['factor-hour-rate-payroll']))?floatval($rates['factor-hour-rate-payroll']):0;
	$factuur_payroll = $loon*$loon_factor_payroll;
	//echo 'compay tarief naar IR: '.number_format_i18n($factuur_payroll,2).'<br/>';
	$data[] = array('','', sprintf('Compay tarief naar IR (=%s)',number_format_i18n($loon_factor_payroll,2)),$currancy.number_format_i18n($factuur_payroll,2));
	
	$day_rate_travel_expenses = (isset($rates['travel_cost_a_day']))?floatval($rates['travel_cost_a_day']):0;
	$travel_expenses = $days_sum * $day_rate_travel_expenses;
	//echo 'Reiskosten: '.number_format_i18n($travel_expenses,2).'<br/>';
	$data[] = array('','', sprintf('Reiskosten (%s p/d)',number_format_i18n($day_rate_travel_expenses,2)),$currancy.number_format_i18n($travel_expenses,2));
	
	
	$week_expenses_compay = (isset($rates['expences_a_week_customer']))?floatval($rates['expences_a_week_customer']):0;
	$week_expenses_compay = count($weeks) * $week_expenses_compay;
	//echo 'Onkostenvergoeding compay aan IR: '.number_format_i18n($week_expenses_compay,2).'<br/>';
	$data[] = array('','', 'Onkostenvergoeding compay aan IR',$currancy.number_format_i18n($week_expenses_compay,2));
	
	$week_expenses_ir = (isset($rates['expences_a_week_payroll']))?floatval($rates['expences_a_week_payroll']):0;
	$week_expenses_ir = count($weeks) * $week_expenses_ir;
	//echo 'Onkostenvergoeding IR ENCI: '.number_format_i18n($week_expenses_ir,2).'<br/>';
	$data[] = array('','', 'Onkostenvergoeding IR ENCI',$currancy.number_format_i18n($week_expenses_ir,2));
	
	$rendement = $factuur_klant-$factuur_payroll;
	//echo 'Rendement: '.number_format_i18n($rendement,2).'<br/>';
	$data[] = array('','', 'Marge',$currancy.number_format_i18n($rendement,2));

    $doc->getActiveSheet()->getColumnDimension('A')->setAutoSize(false);
    $doc->getActiveSheet()->getColumnDimension('A')->setWidth('12');


	$doc->getActiveSheet()->getColumnDimension('B')->setAutoSize(false);
	$doc->getActiveSheet()->getColumnDimension('B')->setWidth('15');
	
	$doc->getActiveSheet()->getColumnDimension('C')->setAutoSize(false);
	$doc->getActiveSheet()->getColumnDimension('C')->setWidth('50');
	
	$doc->getActiveSheet()->getColumnDimension('D')->setAutoSize(false);
	$doc->getActiveSheet()->getColumnDimension('D')->setWidth('15');
	
	$doc->getActiveSheet()->getStyle("A")->getAlignment()->setHorizontal(\PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
	$doc->getActiveSheet()->getStyle("B")->getAlignment()->setHorizontal(\PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
	$doc->getActiveSheet()->getStyle("D")->getAlignment()->setHorizontal(\PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);

	/* Merge cells */
	$doc->getActiveSheet()->fromArray($data, null, 'A1');
	
	$doc->getActiveSheet()->mergeCells('B1:C1');
	$doc->getActiveSheet()->mergeCells('B2:C2');
	$doc->getActiveSheet()->getStyle('A1:B1')->getFont()->setBold(true);
	$doc->getActiveSheet()->getStyle('A2:B2')->getFont()->setBold(true);

	/* Set col size */
	/* 	
 	$doc->getActiveSheet()->getColumnDimensionByColumn('A')->setWidth('30');
	$doc->getActiveSheet()->getColumnDimensionByColumn('A')->setAutoSize(false);

	$doc->getActiveSheet()->getColumnDimensionByColumn('B')->setWidth('30');
	$doc->getActiveSheet()->getColumnDimensionByColumn('B')->setAutoSize(false);
	
	$doc->getActiveSheet()->getColumnDimensionByColumn('C')->setWidth('30');
	$doc->getActiveSheet()->getColumnDimensionByColumn('C')->setAutoSize(false);
		
	$doc->getActiveSheet()->getColumnDimensionByColumn('D')->setWidth('30');
	$doc->getActiveSheet()->getColumnDimensionByColumn('D')->setAutoSize(false);
	 */
	
	/* Set headers bold */
	$doc->getActiveSheet()->getStyle('A4')->getFont()->setBold(true);
	$doc->getActiveSheet()->getStyle('B4')->getFont()->setBold(true);
	$doc->getActiveSheet()->getStyle('C4')->getFont()->setBold(true);
	
	$user_count++;
	if($user_count<count($user_ids)){
		$objWorkSheet = $doc->createSheet();
	}
}


//TODO change filename
$file_name= 'rendement_'.date('d-m-Y',time()).'.xlsx';
// Redirect output to a client�s web browser (Excel2007)
header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
header('Content-Disposition: attachment;filename="'.$file_name.'"');
header('Cache-Control: max-age=0');
// If you're serving to IE 9, then the following may be needed
header('Cache-Control: max-age=1');
// If you're serving to IE over SSL, then the following may be needed
//header ('Expires: Mon, 26 Jul 1997 05:00:00 GMT'); // Date in the past
header ('Last-Modified: '.gmdate('D, d M Y H:i:s').' GMT'); // always modified
header ('Cache-Control: cache, must-revalidate'); // HTTP/1.1
header ('Pragma: public'); // HTTP/1.0
$objWriter = PHPExcel_IOFactory::createWriter($doc, 'Excel2007');
$objWriter->save('php://output');



exit();