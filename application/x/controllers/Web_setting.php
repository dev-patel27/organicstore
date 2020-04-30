<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Web_setting extends CI_Controller
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

        $this->table_name = "tbl_web_setting";
        $this->dir_path = "web_setting/"; 
        $this->name = "web_setting"; 

    }

    public function update($id)
    {      
        if ($this->input->post()) {

                $social_link = json_encode(array(
                                                 'facebook' => $_REQUEST['facebook_link'],
                                                 'twitter' =>  $_REQUEST['twitter_link'],
                                                 'linkedin' =>  $_REQUEST['linkedin_link'],
                                                 'instagram' =>  $_REQUEST['instagram_link'])
                                           );

                $data['site_name'] = $_REQUEST['site_name'];
                $data['social_link'] = $social_link;
                $data['address'] = $_REQUEST['address'];
                $data['cell_number'] = $_REQUEST['phone_no'];
                $data['email'] = $_REQUEST['email_address'];
                $data['updated_at'] = date("Y-m-d H:i:s");

                $this->db->where('id', $id);
                $this->db->update($this->table_name, $data);

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
        $this->load->view($this->dir_path.'update', $data);/* load product_update.php of default_room folder for edit of default_room */

    }



      
    public function file_upload($file_name, $dir)
    {
         $file = "";
         $_FILES['uploadedimage']['name'] = md5(rand(10,100)).$file_name['name'];
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