<?php


defined('BASEPATH') OR exit('No direct script access allowed');

class Role_permission extends CI_Controller
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

        $this->table_name = "tbl_role_category";
        $this->dir_path = "role_permission/"; 
        $this->name = "role_permission";
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
    
            $role_id = trim($_REQUEST['role_id']);
            $role_data = $this->db->where(array('status' => '1','id' => $role_id))->get('tbl_user_type')->row();
            $in_array = array(
                'role_id' => $role_id,
                'role_name' => $role_data->type_name,
                'status' => '1',
                'created_at' => date("Y-m-d H:i:s")
            );

            $this->db->insert('tbl_role_category', $in_array);
            //$role_id = $this->db->insert_id();

            $count = count($_REQUEST['module_id']);
            for($i=0; $i < $count; $i++) {

                $module_id =  $_REQUEST['module_id'][$i];
                $view =  isset($_REQUEST['view'][$i]) ? ($_REQUEST['view'][$i]) : '';
                $add =  isset($_REQUEST['add'][$i]) ? ($_REQUEST['add'][$i]) : '';
                $update =  isset($_REQUEST['update'][$i]) ? ($_REQUEST['update'][$i]) : '';
                $delete =  isset($_REQUEST['delete'][$i]) ? ($_REQUEST['delete'][$i]) : '';
                $export =  isset($_REQUEST['export'][$i]) ? ($_REQUEST['export'][$i]) : '';
            
                    $data_array[$i] = array(
                        'role_id' => $role_id,
                        'module_id' => $module_id,
                        'view_permission' => $view,
                        'add_permission' => $add,
                        'update_permission' => $update,
                        'delete_permission' => $delete,
                        'export_permission' => $export,
                        'created_at' => date("Y-m-d H:i:s"),
                        'status' => '1' 
                    ); 

                $this->db->insert('tbl_role', $data_array[$i]);
              
                
            
            }
             
                
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
                      
            $role_id = trim($_REQUEST['role_id']);
            $role_data = $this->db->where(array('status' => '1','id' => $role_id))->get('tbl_user_type')->row();
            $up_array = array(
                'role_id' => $role_id,
                'role_name' => $role_data->type_name,
                'updated_at' =>  date("Y-m-d H:i:s")

            );
        
            $this->db->where('id', $id);
            $this->db->update($this->table_name, $up_array);
            
            $this->db->where('role_id', $role_id)->set('status', '9')->update('tbl_role');

            $count = count($_REQUEST['module_id']);
            for($i=0; $i < $count; $i++) {

                $module_id =  $_REQUEST['module_id'][$i];
                $view =  isset($_REQUEST['view'][$i]) ? ($_REQUEST['view'][$i]) : '';
                $add =  isset($_REQUEST['add'][$i]) ? ($_REQUEST['add'][$i]) : '';
                $update =  isset($_REQUEST['update'][$i]) ? ($_REQUEST['update'][$i]) : '';
                $delete =  isset($_REQUEST['delete'][$i]) ? ($_REQUEST['delete'][$i]) : '';
                $export =  isset($_REQUEST['export'][$i]) ? ($_REQUEST['export'][$i]) : '';
            
                  $data_array[$i] = array(
                        'role_id' => $role_id,
                        'module_id' => $module_id,
                        'view_permission' => $view,
                        'add_permission' => $add,
                        'update_permission' => $update,
                        'delete_permission' => $delete,
                        'export_permission' => $export,
                        'created_at' => date("Y-m-d H:i:s"),
                        'status' => '1' 
                    ); 

                   $this->db->insert('tbl_role', $data_array[$i]);
              
            }
                  

           
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

        $this->db->where('role_id', $id)->update('tbl_role', $data);

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