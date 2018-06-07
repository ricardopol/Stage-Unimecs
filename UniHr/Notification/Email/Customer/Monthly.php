<?php
/**
* Sending emails
*/
class UniHr_Notification_Email_Customer_Monthly{

  /* Send emails */
  public static function send_notifications($customers_ids = array()){
    //TODO implement function

    $customer_list = array();
    /* Create list for sending emails */
    foreach ($customers_ids as $cid) {
      $customer = UniHr_DB_Customer::get_customer_by_id($cid,ARRAY_A);
      if(isset($customer['contact_person_email'])&&is_email($customer['contact_person_email'])){
        $customer_list[] = $customer;
      }
    }

    //Create email
    $subject = sprintf('Herinnering');
    $content = theme_get_template_part('/email/notification/customer/monthly',null,false);
    $headers = array();
    $headers[] = 'Content-Type: text/html; charset=UTF-8';

    if(empty($content)){
      /* Do nothing */
      return;
    }

    /* Send emails to list */
    foreach ($customer_list as $c) {
      $to = $c['contact_person_email'];
  		@wp_mail($to, $subject, $content,$headers);
    }
  }
}
