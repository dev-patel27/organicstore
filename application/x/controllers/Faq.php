<?php


defined('BASEPATH') OR exit('No direct script access allowed');

class Faq extends CI_Controller
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

        //$this->table_name = "tbl_role_category";
        $this->dir_path = "faq/"; 
        $this->name = "faq";
    }
    


    public function faq_lists()
    {
        
        $data['page']['page_title'] = APP_NAME . LIST_FAQ; /* Add rides title*/
        $data['page']['css'] = 'list_css'; /* add rides css */
        $this->load->view($this->name.'/faq_list',$data);/* load list.php of rides folder for list of rides */

    }

    

    public function faq_post()
    {
        if ($this->input->post()) {

            $in_array = array(
                'question' => ($_REQUEST['question']) ? ($_REQUEST['question']) : '',
                'answer' => ($_REQUEST['answer']) ? ($_REQUEST['answer']) : '',
                'status' => '1',
                'created_at' => date("Y-m-d H:i:s")
            );

            $this->db->insert('tbl_faq', $in_array);

            if ($this->db->affected_rows() > 0) {

                $this->session->set_flashdata('success', ADD_SUCCESS);

            } else {  // If $result array variable empty 
                $this->session->set_flashdata('error', ERR_MESSAGE);
            }
            redirect($this->name.'/add-faq/list');
        }
        else 
        {
            $data['page']['page_title'] = APP_NAME . ADD_FAQ; // Add rides title
            $data['page']['css'] = 'form_css'; // add rides css 
            $this->load->view($this->dir_path.'faq_post', $data); //load post.php of rides folder for add of rides 
        }

    }

    public function faq_update($id)
    {
        if ($this->input->post()) {

            $in_array = array(
                'question' => ($_REQUEST['question']) ? ($_REQUEST['question']) : '',
                'answer' => ($_REQUEST['answer']) ? ($_REQUEST['answer']) : '',
                'status' => '1',
                'updated_at' => date("Y-m-d H:i:s")
            );

            $this->db->where('id', $id)->update('tbl_faq', $in_array);
                   
            if ($this->db->affected_rows() > 0) {

                $this->session->set_flashdata('success', EDIT_SUCCESS);

            } else {  // If $result array variable empty 

                $this->session->set_flashdata('error', ERR_MESSAGE);

            }
           
           
            redirect($this->name.'/add-faq/list');
        }
        else 
        {
             /** @var  $result Get data from `tbl_room` table */
            $this->db->from('tbl_faq');
            $query = $this->db->where('id', $id)->get()->result();
            $result['1'] = $query[0];
            $result['id'] = $id;
            $data['result'] = $result;
            $data['page']['page_title'] = APP_NAME . EDIT_FAQ; /* Add default_room title*/
            $data['page']['css'] = 'form_css'; /* add default_room css */

            $this->load->view($this->dir_path.'faq_update', $data);/* load update.php of default_room folder for edit of default_room */
        }

    }

    

    public function faq_view($id){
        $this->db->select('tbl_faq.*,')
                 ->from('tbl_faq');
        $query = $this->db->where('id', $id)->get()->result();
        $result['1'] = $query[0]; 
        $result['id'] = $id;
        $data['result'] = $result;
        $data['page']['page_title'] = APP_NAME . EDIT_FAQ;
        $data['page']['css'] = 'form_css'; 
        $this->load->view($this->dir_path.'faq_view', $data);

    }

    

    public function faq_delete($id){
        
        $this->db->where('id', $id);
        $data = array(
            'status' => '9',
            'updated_at' => date('Y-m-d H:i:s')
        );
        $this->db->update('tbl_faq', $data);
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