<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class X extends CI_Controller {

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
        if( empty( $this->_loginData ) ) redirect('x/login');/* Redirect to dashboard page */

    }

    /**
     *
     * Admin Dashboard
     *
     */

     public function change_store()
   {
       if($this->input->post())
       {
           $active_store = $this->input->post('store_id');
           $user_id = $this->_loginData->storeuser_id;
           
           
           if( $active_store == '0') {
            
               $up_array = array('active_store' => '0',
                             'storeuser_role' => '0',
               );
              
               $status = $this->db->where(array('storeuser_id' => $user_id))->update('tbl_storeusers', $up_array);

               redirect($_SERVER['HTTP_REFERER']);
           }
           
           
        
           
           $user_role = $this->db->where('store_id', $active_store)
                                ->where('status', '1')
                                ->where('user_id', $user_id)
                                ->get('tbl_user_store_permission')
                                ->row();
            
           $role_id = ($this->input->post('role_id')) ? ($this->input->post('role_id')) : $user_role->role_permission_id;
          
           $update_array = array('active_store' => $active_store,
                             'storeuser_role' => $role_id,
               );
           $status = $this->db->where(array('storeuser_id' => $user_id))->update('tbl_storeusers', $update_array);
          
          /* $user = $this->db->from('tbl_storeusers')
                            ->where(array('status' => '1', 'storeuser_id' => $user_id))
                            ->get()->row();
           $user_array = array('id' => $user->storeuser_id, 'type' => 'user');
           
           $session_data[APP_NAME]['id'] = $user_array;
           $this->session->set_userdata($session_data);*/
           redirect($_SERVER['HTTP_REFERER']);

                   
       }
   }

    public function dashboard(){

        /* Dashboard statistics */
        //$data['total_user'] = $this->db->from('user')->get()->num_rows();
       // $data['total_main_category'] = $this->db->from('category')->where( [ 'confirmed' => 1, 'language_id' => 1, 'parent_id' => '0' ] )->get()->num_rows();
       // $data['total_sub_category'] = $this->db->from('category')->where( [ 'confirmed' => 1, 'language_id' => 1 ] )->where( 'parent_id != 0')->get()->num_rows();
       // $data['total_hotline'] = $this->db->from('hotline')->where( [ 'confirmed' => 1,'language_id' => 1 ] )->get()->num_rows();
        //$data['total_hotline'] = $this->db->from('hotline')->where( [ 'confirmed' => 1,'language_id' => 1 ] )->get()->num_rows();
        //$data['total_happy_feedback'] = $this->db->from('feedback')->where( [ 'confirmed' => 1, 'emoji_status' => 0,  ] )->get()->num_rows();
       // $data['total_sad_feedback'] = $this->db->from('feedback')->where( [ 'confirmed' => 1, 'emoji_status' => 1 ] )->get()->num_rows();

        $data['page']['page_title'] = APP_NAME . ADMIN_DASHBOARD; /* Add page title*/
        $data['page']['css'] = 'dashboard_css'; /* add page css */
        $this->load->view('x/dashboard', $data);

    }


    /**
     *
     * change password admin
     */

    public function change_password(){

        $data['page']['page_title'] = APP_NAME . ADMIN_CHANGEPASSWORD; /* Add page title*/
        $data['page']['css'] = 'form_css'; /* add page css */
        $this->load->view('x/change_password',$data);/* load change_password.php of x folder for change_password of x */
    }


    /**
     *
     * edit change password detail (by id)
     */

    public function update($id){

        $this->load->view('x/update');/* load update.php of x folder for update of x */
    }

    /**
     *
     * logout admin
     */

    public function logout(){

        $this->session->unset_userdata( APP_NAME );
        redirect('login');/* Redirect to login page */
    }
}