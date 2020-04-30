<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Authentication extends CI_Controller {


    public $_loginId = array();
    public $_loginData = array();

    function __construct(){

        parent::__construct();
        /* Get session data */
        $this->_loginId = $this->session->userdata(APP_NAME);
        $this->_type = $this->_loginId['id']['type'];
        
        if($this->_type == 'user')
        {
             /* Check session empty or not */
            if (!empty($this->_loginId)) {
                $this->_loginData = $this->db->from('tbl_storeusers')->where(array('storeuser_id' => $this->_loginId['id']['id']))->get()->row();
            }
        }
        else
        {
             /* Check session empty or not */
            if (!empty($this->_loginId)) {
                $this->_loginData = $this->db->from('tbl_admin')->where(array('id' => 
                    $this->_loginId['id']['id']))->get()->row();
            }
        }


        /* Check session */
        if( isset( $this->_loginData ) && !empty( $this->_loginData ) ) redirect('welcome');/* Redirect to dashboard page */

    }

    /**
    *
    * login tbl_admin
    */

    public function login(){
            if ($this->input->post()) {
          
            // print_r($_REQUEST); exit();
                $where = array(
                    'email' => $this->input->post('email'),
                    'password' => md5($this->input->post('password'))
                );
                 $check_exist = $this->db->from('tbl_admin')->where($where)->get()->row();

                // if ( !empty( $check_exist ) ) 
                // {

                    $check_status = $this->db->from('tbl_admin')->where($where)->where('status', '1')->get()->num_rows();

                    if ($check_status == 1) 
                    {

                        /* Set user Session variable */
                        $admin_array = array('id' => $check_exist->id, 
                                                'type' => 'admin');
                        $session_data[APP_NAME]['id'] = $admin_array;
                        $this->session->set_userdata($session_data);

                        redirect('welcome');

                    } 
                    else 
                    {
                       
                        $this->session->set_flashdata('error', ERR_INACTIVE_USER);
                        redirect('login');

                    }
                // }
                // else 
                // {
                //     $where = array(
                //         'storeuser_email' => $this->input->post('email'),
                //         'storeuser_password' => md5($this->input->post('password'))
                //     );
                //     $check_user = $this->db->from('tbl_storeusers')->where($where)->get()->row();

                //     if(!empty( $check_user ))
                //     {
                //         $check_status = $this->db->from('tbl_storeusers')->where($where)->where('status', '1')->get()->num_rows();


                //         if ($check_status == 1) 
                //         {
                //             $user_array = array('id' => $check_user->storeuser_id, 
                //                                 'type' => 'user');

                //             $session_data[APP_NAME]['id'] = $user_array;
                //             $this->session->set_userdata($session_data);
                //             redirect('welcome');

                //         } 
                //         else 
                //         {
                           
                //             $this->session->set_flashdata('error', ERR_INACTIVE_USER);
                //             redirect('login');

                //         }

                //     }


                //     $this->session->set_flashdata('error', LOGIN_FAIL);
                //     redirect('login');
                // }

            } else {
                $data['page']['page_title'] = APP_NAME . ADMIN_LOGIN;
                $this->load->view('x/login',$data);/* load login.php of x folder  for login new admin */
            }
        }


    /**
     *
     * forgot_password admin
     */

    public function forgot(){
        if ($this->input->post()) {

            $email = $this->input->post('email');
            /** @var  $result Get data from `admin` table */
            $result = $this->db->from('tbl_admin')->where('email', $email)->get()->row();

            if (!empty($result)) {

                /*$header_formate = $this->db->from('email')->where('id ', '1')->get()->row();*/
                $middle_formate = $this->db->from('tbl_admin')->where('id ', '1')->get()->row();
                /*$footer_formate = $this->db->from('email')->where('id ', '2')->get()->row();
                $footer = $footer_formate->text;
                $header = $header_formate->text;*/

                $middel = $middle_formate->text;
                /*$headrer = str_replace("{image}", IMG_URL . 'modellogo.png', $header);*/

                $middel = str_replace('{IMG_URL}', IMG_URL."renter.png", $middel);
                $middel = str_replace('{name}', $result->name, $middel);
                $middel = str_replace('{SITE_URL}', SITE_URL, $middel);
                $middel = str_replace('{EMAIL_FOOTER}', EMAIL_FOOTER, $middel);
                $middel = str_replace('{APP_NAME}', APP_NAME, $middel);
               // $middel = str_replace("{url}", ADMIN_BASE_URL .base64_encode($email).'/reset-password.html', $middel);

                $myemail = $middel;
                $this->email->from('noreply@renter.com', 'Renter');
                $this->email->to($result->email);

                $this->email->subject($middle_formate->subject);
                $this->email->message($myemail);

                if ($this->email->send()) {
                    $this->session->set_flashdata('send_success', SEND_PASSWORD);  /* set success message in session */
                    redirect('x/forgot-password');/* Redirect to forgot password page */
                }
                else
                {
                    $this->session->set_flashdata('email_not_exist', EMAIL_NOT_EXIST); /* set not email exist message in session  */
                    redirect('x/forgot-password');/* Redirect forgot password page */
                }
            }
            else
            {
                $this->session->set_flashdata('email_not_exist', EMAIL_NOT_EXIST); /* set not email exist message in session  */
                redirect('x/forgot-password');/* Redirect forgot password page */
            }

        }
        $data['page']['page_title'] = APP_NAME . ADMIN_FORGOT_PASSWORD;
        $this->load->view('x/forgot',$data);/* load forgot.php of x folder  for forgot password of admin */
    }


    /**
     *
     * reset_password admin
     */

    public function reset($email){

        $email_id =  base64_decode($email);

        /* ## If get post data */
        if($this->input->post()){

            /* Where condition for check in record */
            $data = array(

                'password' => md5($this->input->post('password'))
            );
            //print_r($data);exit;
            /** @var  $result Get data from `admin` table */
            $this->db->where('email', $email_id);
            $this->db->update('tbl_admin' ,$data);
            /* If $result array variable not empty */
            if ($this->db->affected_rows() === 1) {

                $this->session->set_flashdata('success',CHANGE_PASSWORD_SUCCESS);
                redirect('x/login');
            } else {  /* If $result array variable empty */

                $this->session->set_flashdata('err_message', RESET_PASSWORD_ERROR);
                redirect('x/'.$email.'/reset-password');
            }
        }

        $data['page']['page_title'] = APP_NAME . ADMIN_RESET_PASSWORD;
        $data['email']= $email;
        $this->load->view('x/reset', $data); /* load reset.php of x folder  for reset password of admin */
    }


}