<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');


function send_mail_using_amazon_ses($store_id, $subject, $emails)
{
   /* $CI =& get_instance();
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
    $CI->email->send();*/

    $this->load->library('email');

    $config = array(
        'protocol' => 'smtp',
        'smtp_host' => 'email-smtp.us-east-1.amazonaws.com',
        'smtp_user' => 'YOUR SMTP USERNAME',
        'smtp_pass' => 'YOUR SMTP PASSWORD',
        'smtp_port' => 465,
        'mailtype' => 'html'
    );

    $this->email->initialize($config);
    //$this->email->print_debugger();

    $this->email->from('YOUR_EMAIL_ID', 'Test From');
    $this->email->to('email@example.com', 'Test To');
    $this->email->subject('Test');
    $this->email->message('test');        
    $this->email->set_newline("\r\n");
    $this->email->send();

}


