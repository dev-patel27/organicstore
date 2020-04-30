<?php


defined('BASEPATH') OR exit('No direct script access allowed');

class Welcome extends CI_Controller
{

    public $_loginId = array();
    public $_loginData = array();

    function __construct()
    {
       
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
        if (empty($this->_loginData)) redirect('x/login');/* Redirect to dashboard Proparty */
    }
	
	/**
     *
     * List proparty
     */
    public function index()
    {
	   

        $data['page']['page_title'] = APP_NAME . DASHBOARD; /* Add rides title*/
        $data['page']['css'] = 'dashboard_css'; /* add rides css */
        $data['page']['js'] = 'dashboard_js'; /* add rides css */
        $this->load->view('dashboard',$data);/* load list.php of rides folder for list of rides */

    }


    public function farm_map_view()
    {       
        $data['page']['page_title'] = APP_NAME . DASHBOARD; /* Add rides title*/
        $data['page']['css'] = 'dashboard_css'; /* add rides css */
        $data['page']['js'] = 'dashboard_js'; /* add rides css */
        $this->load->view('farm_map',$data);/* load list.php of rides folder for list of rides */

    }

   


}