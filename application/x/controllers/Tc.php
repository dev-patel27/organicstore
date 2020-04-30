<?php


defined('BASEPATH') OR exit('No direct script access allowed');

class Tc extends CI_Controller
{

    public $_loginId = array();
    public $_loginData = array();

    function __construct()
    {

        parent::__construct();
        /* Get session data */
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

        //$this->table_name = "tbl_role_category";
        $this->dir_path = "tc/";
        $this->name = "tc";
    }


     public function tc_lists()
    {

        $data['page']['page_title'] = APP_NAME . LIST_TC; /* Add rides title*/
        $data['page']['css'] = 'list_css'; /* add rides css */
        $this->load->view($this->name.'/tc_list',$data);/* load product_list.php of rides folder for list of rides */

    }


    public function tc_post()
    {
        if ($this->input->post()) {
            $in_array = array(
                'title' => ($_REQUEST['title']) ? ($_REQUEST['title']) : '',
                'description' => ($_REQUEST['description']) ? ($_REQUEST['description']) : '',
                'status' => '1',
                'created_at' => date("Y-m-d H:i:s")
            );
            $this->db->insert('tbl_tc', $in_array);


            if ($this->db->affected_rows() > 0) {

                $this->session->set_flashdata('success', ADD_SUCCESS);

            } else {  // If $result array variable empty

                $this->session->set_flashdata('error', ERR_MESSAGE);

            }
            redirect('tc/tc/list');
        }
        else
        {
            $data['page']['page_title'] = APP_NAME . ADD_TC; // Add rides title
            $data['page']['css'] = 'form_css'; // add rides css
            $this->load->view($this->dir_path.'tc_post', $data); //load post.php of rides folder for add of rides
        }

    }



    public function tc_update($id)
    {
        if ($this->input->post()) {
            $in_array = array(
                'title' => ($_REQUEST['title']) ? ($_REQUEST['title']) : '',
                'description' => ($_REQUEST['description']) ? ($_REQUEST['description']) : '',
                'status' => '1',
                'updated_at' => date("Y-m-d H:i:s")
            );

            $this->db->where('id', $id);
            $this->db->update('tbl_tc', $in_array);

            if ($this->db->affected_rows() > 0) {

                $this->session->set_flashdata('success', ADD_SUCCESS);

            } else {  

                $this->session->set_flashdata('error', ERR_MESSAGE);

            }
           
            redirect('tc/tc/list');
        }
        else 
        {
            $this->db->from('tbl_tc');
            $query = $this->db->where('id', $id)->get()->result();
            $result['1'] = $query[0];
            $result['id'] = $id;
            $data['result'] = $result;
            $data['page']['page_title'] = APP_NAME . EDIT_TC;
            $data['page']['css'] = 'form_css'; 
            $this->load->view($this->dir_path.'tc_update', $data);
        }
    }


    public function tc_view($id)
    {
        $this->db->select('title,description')
                    ->from('tbl_tc');
        $query = $this->db->where('id', $id)->get()->result();
        $result['1'] = $query[0];
        $result['id'] = $id;
        $data['result'] = $result;
        $data['page']['page_title'] = APP_NAME . EDIT_TC;
        $data['page']['css'] = 'form_css';
        $this->load->view($this->dir_path.'tc_view', $data);
    }

    public function tc_delete($id)
    {
        
        $this->db->where('id', $id);

        $data = array(
            'status' => '9',
            'updated_at' => date('Y-m-d H:i:s')
        );
        $this->db->update('tbl_tc', $data);

        if ($this->db->affected_rows() > 0) {

            $this->session->set_flashdata('success', DELETE_SUCCESS);
             redirect($_SERVER['HTTP_REFERER']);
        } else {  /* If $result array variable empty */

            $this->session->set_flashdata('err_message', ERR_MESSAGE);
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

     public function multiple_file_upload($file_name, $dir)
    {
         $fileName_array = "";
         $filesCount = count($file_name['name']);
         for($i = 0; $i < $filesCount; $i++){
                    $_FILES['uploadedimage']['name'] = md5(rand(10,100)).$file_name['name'][$i];
                    $_FILES['uploadedimage']['type'] = $file_name['type'][$i];
                    $_FILES['uploadedimage']['tmp_name'] = $file_name['tmp_name'][$i];
                    $_FILES['uploadedimage']['error'] = $file_name['error'][$i];
                    $_FILES['uploadedimage']['size'] = $file_name['size'][$i];

                    
                    $config['upload_path'] = $dir;
                    $config['allowed_types'] = 'gif|jpg|png|JPEG|PNG|JPG|GIF|jpeg';


                    $this->load->library('upload', $config);
                    $this->upload->initialize($config);
                    if($this->upload->do_upload('uploadedimage')){
                        $fileData = $this->upload->data();
                        $uploadData[$i]['file_name'] = $fileData['file_name'];
                        $images[] = $fileData['file_name'];
                        $fileName_array = implode(',',$images);

                    }
        }
        return $fileName_array;
    }

  

}