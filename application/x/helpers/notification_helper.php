<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');


function send_notification_login($email, $time)
{
    $CI =& get_instance();
    $CI->load->library('email');
    $config['mailtype'] = 'html';
    $CI->email->initialize($config);
    $sender_email = "info@windzoon.in";
    $sender_name = WEB_NAME;
    $CI->email->set_newline("\r\n");
    $CI->email->from($sender_email, $sender_name);
    $CI->email->to('developer.windzoon@gmail.com');
    $CI->email->subject('Login Notification on '.WEB_NAME);
   
    $msg = "Hi<br>Login User email : '".$emall."'<br>Login Time : '".$time."'<br><br>Thank You<br>".WEB_NAME;
    $CI->email->message($msg);      
    $CI->email->send();

    

}


