<?php


defined('BASEPATH') OR exit('No direct script access allowed');

class Users extends CI_Controller
{

    public $_loginId = array();
    public $_loginData = array();

    function __construct()
    {

        parent::__construct();
       
       $this->_loginId = $this->session->userdata(APP_NAME);
        error_reporting(0);
       
        if (!empty($this->_loginId)) {
            $this->_loginData = $this->db->from('tbl_admin')->where(array('id' => $this->_loginId['id']['id']))->get()->row();
        }
        if($this->_loginData->role_id != '1'){
            $permission = $this->admin_model->check_role_permission();    
        }
        

        /* Check session */
        if (empty($this->_loginData)) redirect('x/login');/* Redirect to dashboard Proparty */

        $this->table_name = "tbl_admin";
        $this->dir_path = "users/"; 
        $this->name = "users"; 

    }
    
    
    public function lists()
    {
        /*$permission = $this->admin_model->check_permission((strtolower($this->name)),$this->_loginData->role_id, array(4) );
        if(!$permission){ redirect('permission_not_found'); exit;}*/


        $data['page']['page_title'] = APP_NAME . LIST_USERS; 
        $data['page']['css'] = 'list_css'; 
        $this->load->view($this->dir_path.'list',$data);

    }


    public function post()
    {
        /*$permission = $this->admin_model->check_permission((strtolower($this->name)),$this->_loginData->role_id, array(6) );
        if(!$permission){ redirect('permission_not_found'); exit;}
*/

        if ($this->input->post()) {
        
            $check_email = $this->db->where('email', $_REQUEST['email'])->where('status', '1')->get($this->table_name)->row();
            $manager_image = $this->file_upload($_FILES['manager_image'], FARM_MANAGED_IMG_DIR);
            if(empty($check_email))
            {

                $get_user_type = $this->db->where('id', $_REQUEST['role_id'])->get('tbl_user_type')->row();

                $data['role_id'] = $_REQUEST['role_id'];
                $data['type'] = $get_user_type->type_name;

                $data['name'] = $_REQUEST['name'];
                $data['email'] = $_REQUEST['email'];
                $data['password'] = md5($_REQUEST['password']);
                $data['mobile_number'] = $_REQUEST['mobile_number'];
                $data['address'] = $_REQUEST['address'];
                $data['alternate_mobile_number'] = $_REQUEST['alternate_mobile_number'];
                $data['manager_image'] = $manager_image;
                $data['status'] = 1;
                $data['created_at'] = date("Y-m-d H:i:s");
                $this->db->insert($this->table_name, $data);
                if ($this->db->affected_rows() > 0) {

                $this->session->set_flashdata('success', ADD_SUCCESS);

                } else {  // If $result array variable empty 

                    $this->session->set_flashdata('error', ERR_MESSAGE);

                }
            }
            else
            {
                $this->session->set_flashdata('error',ERR_EMAIL_EXIST);
            }
          
            redirect($this->dir_path.'/add-user/list');
        }
        else {
            $data['page']['page_title'] = APP_NAME . ADD_USERS; 
            $data['page']['css'] = 'form_css'; 
            $this->load->view($this->dir_path.'post', $data); 
        }

    }


    public function update($id)
    {
       /* $permission = $this->admin_model->check_permission((strtolower($this->name)),$this->_loginData->role_id, array(6) );
        if(!$permission){ redirect('permission_not_found'); exit;}

*/
        if ($this->input->post()) {

            $old_data = $this->db->where('id', $id)->where('status', '1')->get($this->table_name)->row();
            $check_email = $this->db->where('email', $_REQUEST['email'])->where('id !=', $id)->where('status', '1')->get($this->table_name)->row();
            $manager_image = $this->file_upload($_FILES['manager_image'], FARM_MANAGED_IMG_DIR);
            if(empty($check_email))
            {
                $get_user_type = $this->db->where('id', $_REQUEST['role_id'])->get('tbl_user_type')->row();

                if($check_email->password == $_REQUEST['password'])
                {
                    $password = $check_email->password;
                }else{
                    $password = md5($_REQUEST['password']); 
                }
                $data['role_id'] = $_REQUEST['role_id'];
                $data['type'] = $get_user_type->type_name;
                $data['name'] = $_REQUEST['name'];
                $data['email'] = $_REQUEST['email'];
                $data['mobile_number'] = $_REQUEST['mobile_number'];
                $data['address'] = $_REQUEST['address'];
                $data['password'] = $password;
                 $data['alternate_mobile_number'] = $_REQUEST['alternate_mobile_number'];
                $data['manager_image'] = ($manager_image) ? ($manager_image) : $old_data->manager_image;
                $data['updated_at'] = date("Y-m-d H:i:s");

                $this->db->where('id', $id);
                $this->db->update($this->table_name, $data);

                 /* If $result array variable not empty */
                if ($this->db->affected_rows() > 0) {

                    $this->session->set_flashdata('success', EDIT_SUCCESS);
                    redirect($this->dir_path.'/add-user/list');
                } else {  /* If $result array variable empty */

                    $this->session->set_flashdata('error', ERR_MESSAGE);
                    redirect($this->dir_path.'/add-user/list');
                }
            }
            else
            {
                 $this->session->set_flashdata('error', ERR_EMAIL_EXIST);
                 redirect($this->dir_path.'/add-user/list');
            }
        }

        /** @var  $result Get data from `tbl_room` table */
        $this->db->from($this->table_name);
        $query = $this->db->where('id', $id)->get()->result();

        $result['1'] = $query[0];
        $result['id'] = $id;
        $data['result'] = $result;


        $data['page']['page_title'] = APP_NAME . EDIT_USERS;
        $data['page']['css'] = 'form_css'; 

        $this->load->view($this->dir_path.'update', $data);

    }


    public function delete($id)
    {
        /*$permission = $this->admin_model->check_permission((strtolower($this->name)),$this->_loginData->role_id, array(1) );
        if(!$permission){ redirect('permission_not_found'); exit;}*/


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

           $this->session->set_flashdata('error', ERR_MESSAGE);
           redirect($_SERVER['HTTP_REFERER']);
        }

    }

     public function active($id)
    {
        $permission = $this->admin_model->check_permission((strtolower($this->name)),$this->_loginData->role_id, array(1) );
        if(!$permission){ redirect('permission_not_found'); exit;}

        $this->db->where('id', $id);

        $data = array(
            'status' => '1',
            'updated_at' => date('Y-m-d H:i:s')
        );
        $this->db->update($this->table_name, $data);

        
        if ($this->db->affected_rows() > 0) {

            $this->session->set_flashdata('success', ACTIVE_SUCCESS);
            redirect($_SERVER['HTTP_REFERER']);
        } else {  /* If $result array variable empty */

            $this->session->set_flashdata('error', ERR_MESSAGE);
            redirect($_SERVER['HTTP_REFERER']);
        }

    }

    public function inactive($id)
    {
        $permission = $this->admin_model->check_permission((strtolower($this->name)),$this->_loginData->role_id, array(1) );
        if(!$permission){ redirect('permission_not_found'); exit;}

        $this->db->where('id', $id);

        $data = array(
            'status' => '0',
            'updated_at' => date('Y-m-d H:i:s')
        );
        $this->db->update($this->table_name, $data);

        if ($this->db->affected_rows() > 0) {

            $this->session->set_flashdata('success', INACTIVE_SUCCESS);
           redirect($_SERVER['HTTP_REFERER']);
        } else {  /* If $result array variable empty */

            $this->session->set_flashdata('error', ERR_MESSAGE);
           redirect($_SERVER['HTTP_REFERER']);
        }

    }

      public function file_upload($file_name, $dir)
    {
         $file = "";
         //$_FILES['uploadedimage']['name'] = md5(rand(10,100)).$file_name['name'];
         $_FILES['uploadedimage']['name'] = $file_name['name'];
         $_FILES['uploadedimage']['tmp_name'] = $file_name['tmp_name'];
         $_FILES['uploadedimage']['type'] = $file_name['type'];
         $_FILES['uploadedimage']['error'] = $file_name['error'];
         $_FILES['uploadedimage']['size'] = $file_name['size'];
         $config['upload_path'] = $dir;
         $config['allowed_types'] = '*';
         $this->load->library('upload', $config);
         $this->upload->initialize($config);
         if($this->upload->do_upload('uploadedimage'))
         {
            $fileData = $this->upload->data();
            $uploadData['file_name'] = $fileData['file_name'];
            $file = $fileData['file_name'];
         }
         return $file;
    }    



}