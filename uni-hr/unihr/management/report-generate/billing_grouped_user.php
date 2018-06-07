<?php
if(!class_exists('PHPExcel')){
	require_once UniHr_DIR.'/include/lib/PHPWord/bootstrap.php';
}

$selected_user_id = (isset($_POST['uid']))?$_POST['uid']:false;
$customers_ids =array();
$customers_ids[] = get_user_meta($selected_user_id,'customer',true);
$user_po = get_user_meta($selected_user_id,'po_number',true);


/* Registration types */
$types = UniHr_Registration_Helper_Day::get_day_registration_types();

$biling_additional_week_cost = array();

if(empty($customers_ids)){exit();}

$currancy = "\xE2\x82\xAc ";
/* Set current cel */


/* Loop user ids */
$user_count = 0;
foreach ($customers_ids as $cid){
	$customer = UniHr_DB_Customer::get_customer_by_id($cid);

	$phpWord = new \PhpOffice\PhpWord\PhpWord();


	// Normal
	$section = $phpWord->addSection();


	$section->addImage ( THEME_BASE . '/assets/images/template/doc/logo.png', array (
		'width' => 225,
		'align' => 'right',
	));

	$header = array('size' => 14, 'bold' => true);

	// 1. Basic table

	$rows = 11;
	$cols = 5;

	//$textrun = $section->addTextRun(array('align' => 'left'));
	if(isset($customer->name)){
		$section->addText($customer->name);
	}
	if(isset($customer->adres)){
		$section->addText($customer->adres);
	}
	if(isset($customer->zipcode)&&isset($customer->location_city)){
		$section->addText($customer->zipcode.' '.$customer->location_city);
	}

	//$section->addText('Klantgegevens');
	$section->addTextBreak();
	$section->addText('Factuur', $header);
	$section->addTextBreak();

	$pstyle = array('indentation' => array('left' => \PhpOffice\PhpWord\Shared\Converter::cmToTwip(10)));
	$section->addText('Pagina 1 van 1',array(),$pstyle);
	$section->addText('Factuurdatum '.date_i18n('d F Y'),array(),$pstyle);
	$section->addText('Factuurnummer {factuurnummer}',array(),$pstyle);
	$section->addText('Contactpersoon {contactpersoon}',array(),$pstyle);
	$section->addText('PO-nummer: '.$user_po,array(),$pstyle);


	$section->addTextBreak();
	$section->addTextBreak();



	$styleTable = ['borderSize' => 0];
	$phpWord->addTableStyle('Colspan Rowspan', $styleTable);
	$table = $section->addTable(
		array(
			'unit' => \PhpOffice\PhpWord\Style\Table::WIDTH_PERCENT,
			'width' => 100 * 50,
		)
	);
	$data = array();
	/* Header */
	$data[] = array('Omschrijving','Aantal','Prijs');
	/* Data */


	$week_from = sanitize_text_field($_POST['periode-from-week']);
	$week_till = sanitize_text_field($_POST['periode-till-week']);
	$year = sanitize_text_field($_POST['periode-year']);

	$weeks = UniHr_DB_HourRegistration::get_hour_totals_per_week_by_customer_and_userid($cid,$selected_user_id,$week_from,$week_till,$year);


	$billing_total_excl = 0;
	foreach ($weeks as $week){

		$work_days = 0;
		$user_name = get_user_meta($week->user_id,'name',true);
//        $user_po = get_user_meta($week->user_id,'po_number',true);
		$rates = UniHr_Helper_User::get_user_rates($week->user_id);

		if(isset($rates['expences_a_week_customer'])&&!empty($rates['expences_a_week_customer'])){
			$biling_additional_week_cost[$week->user_id][] = $rates['expences_a_week_customer'];
			$billing_total_excl += $rates['expences_a_week_customer'];
		}


		/* Get rates */
		$hourrate = (isset($rates['hour_rate']))?floatval($rates['hour_rate']):0;
		$loon_factor_customer = (isset($rates['factor-hour-rate-customer']))?floatval($rates['factor-hour-rate-customer']):0;
		$hourrate_customer = $hourrate*$loon_factor_customer;

		/* Week Totaal */
		/*
			$row_total = $hourrate_customer*$week->total;
			$label = sprintf("Werkuren week %s %s ".PHP_EOL."(Tarief %s p/u)" ,$week->week,$user_name,$currancy.number_format_i18n($hourrate_customer,2));
			$data[] = array($label,$week->total,$currancy.number_format_i18n($row_total,2));
		*/

		$row_hr_total = $hourrate_customer*$week->hr_hours;
		$label = sprintf("Werkuren week %s %s ".PHP_EOL."(Tarief %s p/u)" ,$week->week,$user_name,$currancy.number_format_i18n($hourrate_customer,2));
		$data[] = array($label,$week->hr_hours,$currancy.number_format_i18n($row_hr_total,2));

		$additional_hours = UniHr_DB_HourRegistration::get_grouped_hour_totals_per_week_by_customer_and_user($cid,$week->user_id,$week->week,$week->year);

		$exclude_types = array('');
		foreach ($additional_hours as $additional_hour){
			$amount = 0;
			/*
			* additional hours and exclude Vakantie
			*/
			if($additional_hour->total_additional>=1&&!in_array($additional_hour->registration_type,$exclude_types)){
				$factor = 0;
				if(isset($types[$additional_hour->registration_type])){
					$current_type = $types[$additional_hour->registration_type];
					$factor = $current_type['factor'];
				}
				$amount = ($additional_hour->total_additional*$factor)*$hourrate_customer;
				$billing_total_excl +=$amount;
				$data[] = array($additional_hour->registration_type,$additional_hour->total_additional,$currancy.number_format_i18n($amount,2));
			}
		}


		/* Reiskosten */
		$travel_cost_a_day = (isset($rates['travel_cost_a_day']))?floatval($rates['travel_cost_a_day']):0;
		$reiskosten = $travel_cost_a_day*$week->billable_days;
		$label = sprintf("Reiskosten ".PHP_EOL."(Tarief %s p/d) ",$currancy.number_format_i18n($travel_cost_a_day,2));
		$data[] = array($label,$week->billable_days, $currancy.number_format_i18n($reiskosten,2));

		/* Spacer */
		$data[] = array('','', '');


		/* Add totals */
		$billing_total_excl +=$row_hr_total;
		$billing_total_excl +=$reiskosten;
	}

	/* Additional cost */
	foreach ($biling_additional_week_cost as $user_id => $user_weeks){

		$user_name = get_user_meta($user_id,'name',true);
		$user_po = get_user_meta($user_id,'po_number',true);
		$user_additional = current($user_weeks);
		$user_additional = number_format_i18n($user_additional,2);
		$user_additional_weeks = count($user_weeks);
		$user_additional_week_cost = array_sum($user_weeks);

		$label = sprintf('Onkostenvergoeding %s '.PHP_EOL."(Tarief %dx %s )",$user_name,$user_additional_weeks,$currancy.$user_additional);

		$data[] = array($label,$user_additional_weeks, $currancy.$user_additional_week_cost);
	}
	/* Spacer */
	$data[] = array('','', '');


	$i=0;
	foreach ($data as $row){
		$i++;
		$table->addRow();
		$j=0;
		foreach ($row as $cell){
			$j++;
			$style = array();
			if($i==1){
				$style = array('borderBottomColor'=>'000000','borderBottomSize'=>3);
			}

			if($j==1){
				$current_cell = $table->addCell(4000,$style);
			}else{
				$current_cell = $table->addCell(1000,$style);
			}

			$lines = explode(PHP_EOL, $cell);
			foreach ($lines as $line){
				$current_cell->addText($line);
			}

		}
	}

	/* Subtotals */
	$data = array();

	$data[] = array('','','');
	$data[] = array('Subtotaal','',$currancy.number_format_i18n($billing_total_excl,2));
	$total_vat = $billing_total_excl*0.21;
	$data[] = array('21% BTW','',$currancy.number_format_i18n($total_vat,2));
	$data[] = array('','','');

	$i=0;
	foreach ($data as $row){
		$i++;
		$table->addRow();
		foreach ($row as $cell){
			$style = array();
			if($i==1){
				$style = array('borderTopColor'=>'000000','borderTopSize'=>3);
			}
			$current_cell = $table->addCell(1750,$style);

			$lines = explode(PHP_EOL, $cell);
			foreach ($lines as $line){
				$current_cell->addText($line);
			}

		}
	}

	/* Subtotals */
	$data = array();
	$total_excl = $billing_total_excl+$total_vat;
	$data[] = array('','','');
	$data[] = array('Factuur totaal','',$currancy.number_format_i18n($total_excl,2));

	$i=0;
	foreach ($data as $row){
		$i++;
		$table->addRow();
		foreach ($row as $cell){
			$style = array();
			if($i==1){
				$style = array('borderTopColor'=>'000000','borderTopSize'=>3);
			}
			$current_cell = $table->addCell(1750,$style);
			$lines = explode(PHP_EOL, $cell);
			foreach ($lines as $line){
				$current_cell->addText($line,array('bold' => true));
			}

		}
	}

	/* Footer text */
	$section->addTextBreak();


	$textrun = $section->addTextRun(array('align' => 'left','indentation' => array('left' => \PhpOffice\PhpWord\Shared\Converter::cmToTwip(2)),'space' => array('before' => \PhpOffice\PhpWord\Shared\Converter::cmToTwip(1), 'after' => \PhpOffice\PhpWord\Shared\Converter::cmToTwip(1))));
	$textrun->addText('Betaling dient te geschieden binnen 14 dagen ',array('normal' => true));
	$textrun->addTextBreak();
	$textrun->addText(' Reknr: NL 29 RABO 003 241 488 95 ',array('bold' => true));
	$textrun->addTextBreak();
	$textrun->addText(' B.T.W.nr: NL 858 115 384 B01 K.v.K.nr: 70040591 ',array('bold' => true));
	$textrun->addTextBreak();
	$textrun->addText("\nt.n.v. Plug Schoonmaak B.V. te Hoogvliet Rotterdam ondervermelding van het factuurnummer.");



	/* Add footer */
	$footer = $section->createFooter();
	$footer->addImage ( THEME_BASE . '/assets/images/template/doc/doc-footer-v2.png', array (
		'width' => 600,
		'align' => 'right',
	));

	// save as a random file in temp file
	$temp_file = tempnam(sys_get_temp_dir(), 'PHPWord');
	$objWriter = \PhpOffice\PhpWord\IOFactory::createWriter($phpWord, 'Word2007');
	$objWriter->save($temp_file);


	//TODO change filename

	$company_name = sanitize_title($customer->name);
	$filename = 'Factuur_'.$company_name.'_'.date('d-m-Y').'.docx';


	header("Content-Disposition: attachment; filename='{$filename}'");
	readfile($temp_file); // or echo file_get_contents($temp_file);
	unlink($temp_file);  // remove temp file

}
exit();
