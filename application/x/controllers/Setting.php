<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Setting extends CI_Controller
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
            //$permission = $this->admin_model->check_role_permission();

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

        $this->table_name = "tbl_storeusers";
        $this->dir_path = "setting/"; 
        $this->name = "setting"; 

    }
    
    



    

    public function profile_update()
    {      
        if ($this->input->post()) {
            
            $filename = pathinfo($_FILES['storeuser_image']['name'], PATHINFO_FILENAME);
            $storeuser_image = $this->file_upload($_FILES['storeuser_image'], USER_IMG_DIR);

            $row_user = $this->admin_model->get_user_image($id);

               
            $data['honorific'] = implode(",",$_REQUEST['honorific']);
            $data['storeuser_fname'] = $_REQUEST['firstname'];
            $data['storeuser_lname'] = $_REQUEST['lastname'];
            $data['storeuser_dob'] = $_REQUEST['dob'];
            $data['storeuser_ccode'] = implode(",",$_REQUEST['country_code']);
            $data['storeuser_phone'] = $_REQUEST['phone'];
            $data['storeuser_address'] = $_REQUEST['address'];
            $data['storeuser_image'] = ($storeuser_image) ? ($storeuser_image) : $row_user->storeuser_image;
               
            $data['storeuser_email'] = $_REQUEST['storeusers_email'];
            $data['storeuser_password'] = ($_REQUEST['storeusers_password']) ? (md5($_REQUEST['storeusers_password'])) : $row_user->storeuser_password;
                
            $data['updated_at'] = date("Y-m-d H:i:s");
                
            $this->db->where('storeuser_id', $this->_loginData->storeuser_id);
            $this->db->update($this->table_name, $data);

                
                
            if ($this->db->affected_rows() > 0) {

                    $this->session->set_flashdata('success', EDIT_SUCCESS);
                    redirect('setting/profile/edit');
            } else {  /* If $result array variable empty */

                    $this->session->set_flashdata('err_message', ERR_MESSAGE);
                    redirect('setting/profile/edit');
                }

                
        }

        /** @var  $result Get data from `tbl_room` table */
        $this->db->from($this->table_name);
        $query = $this->db->where('storeuser_id', $this->_loginData->storeuser_id)->get()->result();
        // echo "<pre>"; print_r($query); exit;

        $result['1'] = $query[0];
        $result['id'] =$this->_loginData->storeuser_id;
        $data['result'] = $result;
        $data['page']['page_title'] = APP_NAME . EDIT_STOREUSERS; /* Add default_room title*/
        $data['page']['css'] = 'form_css'; /* add default_room css */
        $this->load->view($this->dir_path.'profile_update', $data);/* load update.php of default_room folder for edit of default_room */

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