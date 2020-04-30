<?php


defined('BASEPATH') OR exit('No direct script access allowed');

class Module_subcategory extends CI_Controller
{

    public $_loginId = array();
    public $_loginData = array();

    function __construct()
    {

        parent::__construct();
        /* Get session data */
        $this->_loginId = $this->session->userdata(APP_NAME);
        $this->_type = $this->_loginId['id']['type'];
        
        
         if (!empty($this->_loginId)) {
            $this->_loginData = $this->db->from('tbl_admin')->where(array('id' => $this->_loginId['id']['id']))->get()->row();
        }
        if($this->_loginData->role_id != '1'){
            $permission = $this->admin_model->check_role_permission();    
        }
        

        /* Check session */
        if (empty($this->_loginData)) redirect('x/login');/* Redirect to dashboard Proparty */

        $this->table_name = "tbl_module_subcategory";
        $this->dir_path = "module_subcategory/"; 
        $this->name = "module_subcategory";
    }
    
    /**
     *
     * List proparty
     */
    public function lists()
    {
        
        $data['page']['page_title'] = APP_NAME . LIST_CATEGORY; /* Add rides title*/
        $data['page']['css'] = 'list_css'; /* add rides css */
        $this->load->view($this->name.'/list',$data);/* load list.php of rides folder for list of rides */

    }

    public function post()
    {
        if ($this->input->post()) {
    
                $array = $this->input->post();
                $data['module_id'] = ($_REQUEST['module_id']);
                $data['sub_module_name'] = trim($_REQUEST['name']);
                $data['slug_sub_module_name'] = url_title(trim($_REQUEST['name']));
                $data['status'] = 1;
                $data['created_at'] = date("Y-m-d H:i:s");
                $this->db->insert($this->table_name, $data);
                if ($this->db->affected_rows() > 0) {

                    $this->session->set_flashdata('success', ADD_SUCCESS);

                } else {  // If $result array variable empty 

                    $this->session->set_flashdata('err_message', ERR_MESSAGE);

                }

                redirect($this->name.'/list');
        }
        else 
        {
            $data['page']['page_title'] = APP_NAME . ADD_CATEGORY; // Add rides title
            $data['page']['css'] = 'form_css'; // add rides css 
            $this->load->view($this->dir_path.'post', $data); //load post.php of rides folder for add of rides 
        }

    }





    public function update($id){

        if ($this->input->post()) {
           
            $data['module_id'] = ($_REQUEST['module_id']);
            $data['sub_module_name'] = trim($_REQUEST['name']);
            $data['slug_sub_module_name'] = url_title(trim($_REQUEST['name']));
            $data['status'] = 1;
            $data['updated_at'] = date("Y-m-d H:i:s");                     
                    
            /* Where condition for check in record */
            $this->db->where('id', $id);
            $this->db->update($this->table_name, $data);
            /* If $result array variable not empty */
            if ($this->db->affected_rows() > 0) {

                $this->session->set_flashdata('success', EDIT_SUCCESS);
                redirect($this->name.'/list');
            } else {  /* If $result array variable empty */

                $this->session->set_flashdata('err_message', ERR_MESSAGE);
                redirect($this->name.'/list');
            }
        }

        /** @var  $result Get data from `tbl_room` table */
        $this->db->from($this->table_name);
        $query = $this->db->where('id', $id)->get()->result();
        $result['1'] = $query[0];
        $result['id'] = $id;
        $data['result'] = $result;
        $data['page']['page_title'] = APP_NAME . EDIT_CATEGORY; /* Add default_room title*/
        $data['page']['css'] = 'form_css'; /* add default_room css */

        $this->load->view($this->dir_path.'update', $data);/* load update.php of default_room folder for edit of default_room */

    }


    

    public function delete($id){
        
        $this->db->where('id', $id);
        $data = array(
            'status' => '9',
            'updated_at' => date('Y-m-d H:i:s')
        );
        $this->db->update($this->table_name, $data);

        /* If $result array variable not empty */
        if ($this->db->affected_rows() > 0) {
            $this->session->set_flashdata('success', DELETE_SUCCESS);
            redirect($_SERVER['HTTP_REFERER']);
        } else {  /* If $result array variable empty */

            $this->session->set_flashdata('err_message', ERR_MESSAGE);
            redirect($_SERVER['HTTP_REFERER']);
        }

    }




}