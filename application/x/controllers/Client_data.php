<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Client_data extends CI_Controller
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

        $this->table_name = "tbl_web_setting";
        $this->dir_path = "client_data/"; 
        $this->name = "client_data";
    }
    
    /**
     *
     * List proparty
     */
    public function lists()
    {
        
        $data['page']['page_title'] = APP_NAME . LIST_WEB_SETTING; /* Add rides title*/
        $data['page']['css'] = 'list_css'; /* add rides css */
        $this->load->view('client_data/list',$data);/* load list.php of rides folder for list of rides */

    }


    public function update($id){

        if ($this->input->post()) {
          
            $client_data = json_encode(array(
                'total_leads' => $_REQUEST['total_leads'],
                'trades_given' => $_REQUEST['trades_given'],
                'total_groups' => $_REQUEST['total_groups'],
                'total_clients' => $_REQUEST['total_clients'],
            ));

            $default_room['client_data'] = $client_data;
            $default_room['status'] = 1;
            $default_room['updated_at'] = date("Y-m-d H:i:s");                     
                    
                /* Where condition for check in record */
                $this->db->where('id', $id);
                $this->db->update($this->table_name, $default_room);

            /* If $result array variable not empty */
            if ($this->db->affected_rows() > 0) {

                $this->session->set_flashdata('success', EDIT_SUCCESS);
                redirect($_SERVER['HTTP_REFERER']);
            } else {  /* If $result array variable empty */

                $this->session->set_flashdata('err_message', ERR_MESSAGE);
                redirect($_SERVER['HTTP_REFERER']);
            }
        }

        /** @var  $result Get data from `tbl_room` table */
        $this->db->from($this->table_name);
        $query = $this->db->where('id', $id)->get()->result();
        $result['1'] = $query[0];
        $result['id'] = $id;
        $data['result'] = $result;
        $data['page']['page_title'] = APP_NAME . EDIT_WEB_SETTING; /* Add default_room title*/
        $data['page']['css'] = 'form_css'; /* add default_room css */

        $this->load->view('client_data/update', $data);/* load update.php of default_room folder for edit of default_room */

    }


}