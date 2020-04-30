<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Newsletters extends CI_Controller
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
            $permission = $this->admin_model->check_role_permission();
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

        //$this->table_name = "tbl_cities";
        $this->dir_path = "newsletters/"; 
        $this->name = "newsletters"; 

    }
    
    /**
     *
     * List proparty
     */
    public function n_subscriber_lists()
    {
 
        $data['page']['page_title'] = APP_NAME . LIST_NEWSLETTER; /* Add rides title*/
        $data['page']['css'] = 'list_css'; /* add rides css */
        $this->load->view($this->dir_path.'newsletters_subscriber_list',$data);/* load list.php of rides folder for list of rides */

    }


    public function n_subscriber_delete($id)
    {
        
        $this->db->where('id', $id);

        $data = array(
            'status' => '9',
            'updated_at' => date('Y-m-d H:i:s')
        );
        $this->db->update('tbl_newsletter', $data);
        if ($this->db->affected_rows() > 0) {

            $this->session->set_flashdata('success', DELETE_SUCCESS);
             redirect($_SERVER['HTTP_REFERER']);
        } else {  /* If $result array variable empty */

            $this->session->set_flashdata('err_message', ERR_MESSAGE);
           redirect($_SERVER['HTTP_REFERER']);
        }

    }





}