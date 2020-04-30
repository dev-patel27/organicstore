<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Order_list extends CI_Controller
{

    public $_loginId = array();
    public $_loginData = array();

    public function __construct()
    {

        parent::__construct();
        /* Get session data */
        $this->_loginId = $this->session->userdata(APP_NAME);
        error_reporting(0);

        if (!empty($this->_loginId)) {
            $this->_loginData = $this->db->from('tbl_admin')->where(array('id' => $this->_loginId['id']['id']))->get()->row();
        }
        if ($this->_loginData->role_id != '1') {
            $permission = $this->admin_model->check_role_permission();
        }

        /* Check session */
        if (empty($this->_loginData)) {
            redirect('x/login');
        }
/* Redirect to dashboard Proparty */

        //$this->table_name = "tbl_role_category";
        $this->dir_path = "order/";
        $this->name = "order";
    }

    /*category*/
    public function order_lists()
    {

        $data['page']['page_title'] = APP_NAME . LIST_ORDERS; /* Add rides title*/
        $data['page']['css'] = 'list_css'; /* add rides css */
        $this->load->view($this->name . '/order_list', $data); /* load list.php of rides folder for list of rides */

    }

    public function order_list_view($id)
    {
        $this->db->select('tbl_order_details.*')->from('tbl_order_details');
        $query = $this->db->where('id', $id)->get()->result();
        $result['0'] = $query[0];
        $result['id'] = $id;
        $data['result'] = $result;
        $data['page']['page_title'] = APP_NAME . VIEW_ORDERS;
        $data['page']['css'] = 'form_css';
        $this->load->view($this->dir_path . 'order_list_view', $data);
    }

    public function file_upload($file_name, $dir)
    {
        $file = "";
        $_FILES['uploadedimage']['name'] = md5(rand(10, 100)) . $file_name['name'];
        /*$_FILES['uploadedimage']['name'] = $file_name['name'];*/
        $_FILES['uploadedimage']['tmp_name'] = $file_name['tmp_name'];
        $_FILES['uploadedimage']['type'] = $file_name['type'];
        $_FILES['uploadedimage']['error'] = $file_name['error'];
        $_FILES['uploadedimage']['size'] = $file_name['size'];
        $config['upload_path'] = $dir;
        $config['allowed_types'] = '*';
        $this->load->library('upload', $config);
        $this->upload->initialize($config);
        if ($this->upload->do_upload('uploadedimage')) {
            $fileData = $this->upload->data();
            $this->resizeImage($fileData['file_name']);
            $uploadData['file_name'] = $fileData['file_name'];
            $file = $fileData['file_name'];
        }
        return $file;
    }

    public function multiple_file_upload($file_name, $dir)
    {
        $fileName_array = "";
        $filesCount = count($file_name['name']);
        for ($i = 0; $i < $filesCount; $i++) {
            $_FILES['uploadedimage']['name'] = md5(rand(10, 100)) . $file_name['name'][$i];
            $_FILES['uploadedimage']['type'] = $file_name['type'][$i];
            $_FILES['uploadedimage']['tmp_name'] = $file_name['tmp_name'][$i];
            $_FILES['uploadedimage']['error'] = $file_name['error'][$i];
            $_FILES['uploadedimage']['size'] = $file_name['size'][$i];

            $config['upload_path'] = $dir;
            $config['allowed_types'] = 'gif|jpg|png|JPEG|PNG|JPG|GIF|jpeg';

            $this->load->library('upload', $config);
            $this->upload->initialize($config);
            if ($this->upload->do_upload('uploadedimage')) {

                $fileData = $this->upload->data();
                $uploadData[$i]['file_name'] = $fileData['file_name'];
                $images[] = $fileData['file_name'];
                $fileName_array = implode(',', $images);

            }
        }
        return $fileName_array;
    }

}
