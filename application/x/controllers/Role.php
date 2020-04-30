<?php


defined('BASEPATH') OR exit('No direct script access allowed');

class Role extends CI_Controller
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

        $this->table_name = "tbl_role";
        $this->dir_path = "role/"; 
        $this->name = "role";
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
    

               /* $data = array();
                $count = count($_REQUEST['sub_module_id']);
                $role_id = $_REQUEST['role_id'];
                for($i=0; $i < $count; $i++) {
                    
                    $module_id = $_REQUEST['module_id'][$i];
                    $sub_module_id =  $_REQUEST['sub_module_id'][$i];
                    $view = isset($_REQUEST['view'][$i]) ? $_REQUEST['view'][$i] : 'false'; 
                    $add = isset($_REQUEST['add'][$i]) ? $_REQUEST['add'][$i] : 'false';
                    $update = isset($_REQUEST['update'][$i]) ? $_REQUEST['update'][$i] : 'false';
                    $delete = isset($_REQUEST['delete'][$i]) ? $_REQUEST['delete'][$i] : 'false'; 
                    $export = isset($_REQUEST['export'][$i]) ? $_REQUEST['export'][$i] : 'false'; 

                    $data[$i] = array(
                        'role_id' => $role_id,
                        'module_id' => $module_id,
                        'sub_module_id' =>  $sub_module_id,
                        'view_permission' => $view,
                        'add_permission' => $add,
                        'update_permission' => $update,
                        'delete_permission' => $delete,
                        'export_permission' => $export,
                        'status' => '1',
                        'created_at' => date("Y-m-d H:i:s")   
                    );

                    $status = $this->db->insert('tbl_role', $data[$i]);

                }*/
                $role_id = $_REQUEST['role_id'];
                $module_id = $_REQUEST['module_id'];
                    $sub_module_id =  $_REQUEST['sub_module_id'];
                    $view = isset($_REQUEST['view']) ? $_REQUEST['view'] : 'false'; 
                    $add = isset($_REQUEST['add']) ? $_REQUEST['add'] : 'false';
                    $update = isset($_REQUEST['update']) ? $_REQUEST['update'] : 'false';
                    $delete = isset($_REQUEST['delete']) ? $_REQUEST['delete'] : 'false'; 
                    $export = isset($_REQUEST['export']) ? $_REQUEST['export'] : 'false'; 

                $is_exits = $this->db->where(array('role_id' => $role_id,
                    'module_id' => $module_id,
                    'sub_module_id' => $sub_module_id,
                    'status' => '1'

                ))->get('tbl_role')->row();

                if(empty($is_exits))
                {  

                     $data = array(
                            'role_id' => $role_id,
                            'module_id' => $module_id,
                            'sub_module_id' =>  $sub_module_id,
                            'view_permission' => $view,
                            'add_permission' => $add,
                            'update_permission' => $update,
                            'delete_permission' => $delete,
                            'export_permission' => $export,
                            'status' => '1',
                            'created_at' => date("Y-m-d H:i:s")   
                    );

                    $status = $this->db->insert('tbl_role', $data);

                    if ($this->db->affected_rows() > 0) {

                        $this->session->set_flashdata('success', ADD_SUCCESS);

                    } else {  // If $result array variable empty 

                        $this->session->set_flashdata('err_message', ERR_MESSAGE);

                    }
                }
                else
                {
                    $this->session->set_flashdata('error', "Already exits.");
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
           
            
            $role_id = $_REQUEST['role_id'];
            $module_id = $_REQUEST['module_id'];
            $sub_module_id =  $_REQUEST['sub_module_id'];
            $view = isset($_REQUEST['view']) ? $_REQUEST['view'] : 'false'; 
            $add = isset($_REQUEST['add']) ? $_REQUEST['add'] : 'false';
            $update = isset($_REQUEST['update']) ? $_REQUEST['update'] : 'false';
            $delete = isset($_REQUEST['delete']) ? $_REQUEST['delete'] : 'false'; 
            $export = isset($_REQUEST['export']) ? $_REQUEST['export'] : 'false';

            $data = array(
                            'role_id' => $role_id,
                            'module_id' => $module_id,
                            'sub_module_id' =>  $sub_module_id,
                            'view_permission' => $view,
                            'add_permission' => $add,
                            'update_permission' => $update,
                            'delete_permission' => $delete,
                            'export_permission' => $export,
                            'status' => '1',
                            'created_at' => date("Y-m-d H:i:s")   
            );

            $status = $this->db->where('id', $id)->update('tbl_role', $data);


            /*$role_permission_update = $this->db->set('status', '9')
                                               ->where('role_id', $role_id)
                                               ->update($this->table_name);


            $count = count($_REQUEST['sub_module_id']);
            
            for($i=0; $i < $count; $i++) {
                    
                    $module_id = $_REQUEST['module_id'][$i];
                    $sub_module_id =  $_REQUEST['sub_module_id'][$i];
                    $view = isset($_REQUEST['view'][$i]) ? $_REQUEST['view'][$i] : ''; 
                    $add = isset($_REQUEST['add'][$i]) ? $_REQUEST['add'][$i] : '';
                    $update = isset($_REQUEST['update'][$i]) ? $_REQUEST['update'][$i] : '';
                    $delete = isset($_REQUEST['delete'][$i]) ? $_REQUEST['delete'][$i] : ''; 
                    $export = isset($_REQUEST['export'][$i]) ? $_REQUEST['export'][$i] : ''; 

                    $data = array(
                        'role_id' => $role_id,
                        'module_id' => $module_id,
                        'sub_module_id' =>  $sub_module_id,
                        'view_permission' => $view,
                        'add_permission' => $add,
                        'update_permission' => $update,
                        'delete_permission' => $delete,
                        'export_permission' => $export,
                        'status' => '1',
                        'created_at' => date("Y-m-d H:i:s")   
                    );

                    $status = $this->db->insert('tbl_role', $data);

            }*/



            if ($this->db->affected_rows() > 0) {

                $this->session->set_flashdata('success', EDIT_SUCCESS);
                redirect($this->name.'/list');
            } else {  /* If $result array variable empty */

                $this->session->set_flashdata('err_message', ERR_MESSAGE);
                redirect($this->name.'/list');
            }
        }

        $this->db->from('tbl_role');
        $query = $this->db->where('id', $id)->get()->result();
        $result['1'] = $query[0];
        $result['id'] = $id;
        $data['result'] = $result;
        $data['page']['page_title'] = APP_NAME . EDIT_CATEGORY; /* Add default_room title*/
        $data['page']['css'] = 'form_css'; /* add default_room css */

        $this->load->view($this->dir_path.'update', $data);/* load update.php of default_room folder for edit of default_room */

    }


    public function get_ajax_update_role()
    {
        if($this->input->post())
        {
            $output = "";
            $count_module = 1;
            $row_count = 1;
            $role_id = $this->input->post('role_id');
            $module_array = $this->admin_model->get_module_by_role_id($role_id);
            foreach ($module_array as $key => $row) {
                
                $output .= 

                '<div class="row">
                    <div class="col-md-12">
                        <div class="form-group">
                            <label class="control-label col-md-3">'.$row['module_name'].'
                             
                            </label>
                            <div class="col-md-9">
                                <div class="portlet-body">
                                    <div class="table-scrollable">
                                       <table class="table table-condensed table-hover">
                                          <tbody>';

                                          $sub_module = $this->admin_model->get_sub_module_by_module_id($role_id, $row['module_id']);  
                                        
                                          foreach ($sub_module as $key => $row_sub) {
                                            
                                            $view_check = ($row_sub['view_permission']=='true') ? 'checked' : '';

                                            $add_check = ($row_sub['add_permission']=='true') ? 'checked' : '';

                                            $update_check = ($row_sub['update_permission']=='true') ? 'checked' : '';

                                            $delete_check = ($row_sub['delete_permission']=='true') ? 'checked' : '';

                                            $export_check = ($row_sub['export_permission']=='true') ? 'checked' : '';

                                             $output .= 
                                             '
                                             <input type="hidden" name="sub_module_id[]" value="'.$row_sub['id'].'" >
                                             <input type="hidden" name="module_id[]" value="'.$row_sub['module_id'].'" >
                                             <tr>
                                                <td>'.$row_count++.'. '.$row_sub['sub_module_name'].'</td>
                                                <td> <input type="checkbox" name="view[]" value="true" '.$view_check.' > view</td>
                                                <td> <input type="checkbox" name="add[]" value="true" '.$add_check.' > add</td>
                                                <td> <input type="checkbox" name="update[]" value="true" '.$update_check.' > update</td>
                                                <td> <input type="checkbox" name="delete[]" value="true" '.$delete_check.' > delete</td>
                                                <td> <input type="checkbox" name="export[]" value="true" '.$export_check.' > export</td>
                                             </tr>';
                                          }


                               $output .= '</tbody>
                                       </table>
                                    </div>
                                 </div>
                              </div>
                           </div>
                        </div>
                     </div>';


            }

            $m_array = $this->admin_model->get_module_by_not_assign($role_id);
           

            foreach ($m_array as $key => $row) {

                $output .= 

                '<div class="row">
                    <div class="col-md-12">
                        <div class="form-group">
                            <label class="control-label col-md-3">'.$row['module_name'].'
                             
                            </label>
                            <div class="col-md-9">
                                <div class="portlet-body">
                                    <div class="table-scrollable">
                                       <table class="table table-condensed table-hover">
                                          <tbody>';
                                          $sub_module = $this->admin_model->get_sub_module($row['id']);
                                          foreach ($sub_module as $key => $row_sub) {

                                            $output .= '
                                            <input type="hidden" name="sub_module_id[]" value="'.$row_sub['id'].'" >
                                            <input type="hidden" name="module_id[]" value="'.$row_sub['module_id'].'" >
                                            <tr>
                                                <td>'.$row_count++.'. '.$row_sub['sub_module_name'].'</td>
                                                <td> <input type="checkbox" name="view[]" value="true" > view</td>
                                                <td> <input type="checkbox" name="add[]" value="true" > add</td>
                                                <td> <input type="checkbox" name="update[]" value="true" > update</td>
                                                <td> <input type="checkbox" name="delete[]" value="true" > delete</td>
                                                <td> <input type="checkbox" name="export[]" value="true" > export</td>
                                            </tr>';
                                            

                                          }
                               $output .= '</tbody>
                                       </table>
                                    </div>
                                 </div>
                              </div>
                           </div>
                        </div>
                     </div>';


            }

            $output .= '<div class="form-actions" >
                            <div class="row">
                               <div class="col-md-12">
                                  <div class="row">
                                     <div class="col-md-offset-3 col-md-9">
                                        <button class="btn green" type="submit">Update</button>
                                        <button class="btn default" type="button">Cancel</button>
                                     </div>
                                  </div>
                               </div>
                               <div class="col-md-6"> </div>
                            </div>
                        </div>';
            echo $output;
        }
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


    public function get_sub_module()
    {
        if($this->input->post())
        {
            $module_id = ($this->input->post('module_id')) ? $this->input->post('module_id') : '';
            $output = '<option value="">Select Sub category</option>';
            $sub_module = $this->admin_model->get_sub_module($module_id);
            foreach ($sub_module as $key => $row_sub) {
                $output .= '<option value="'.$row_sub['id'].'" >'.$row_sub['sub_module_name'].'</option>';
            }

            echo $output;
        }
    }




}