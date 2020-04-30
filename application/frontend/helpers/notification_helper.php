<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');


function send_notification_subscriber($email)
{
    $CI =& get_instance();
    $CI->load->library('email');
    $CI->load->model('front_model');
    $config['mailtype'] = 'html';
    $CI->email->initialize($config);
    $sender_email = SENDER_MAIL;
    $sender_name = WEB_NAME;
    $CI->email->set_newline("\r\n");
    $CI->email->from($sender_email, $sender_name);
    $CI->email->to($email);
    $CI->email->subject('Thank You for subscribe on '.WEB_NAME);
   
    $msg = $CI->front_model->get_notification_template(9);
    $CI->email->message($msg->template);      
    $CI->email->send();

     //send SLTL
    $get_email = $CI->front_model->get_notification_email(1);
    
    if(!empty($get_email)){
        foreach ($get_email as $row) {
            
            $CI->email->from($sender_email, $sender_name);
            $CI->email->to($row['email']);
            $CI->email->subject('Notification For New Subscriber on '.WEB_NAME);

            $msg = $CI->front_model->get_notification_template(10);
            $CI->email->message($msg->template);      
            $CI->email->send();
        }
    }

}
