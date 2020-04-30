<?php


defined('BASEPATH') OR exit('No direct script access allowed');

class Gallery extends CI_Controller
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
        if ($this->_loginData->role_id != '1') {
            $permission = $this->admin_model->check_role_permission();
        }

        /* Check session */
        if (empty($this->_loginData)) redirect('x/login');/* Redirect to dashboard Proparty */

        //$this->table_name = "tbl_role_category";
        $this->dir_path = "gallery/";
        $this->name = "gallery";
    }


    public function gallery_lists($product_id)
    {
        $data['page']['page_title'] = APP_NAME . LIST_GALLERY; /* Add rides title*/
        $data['page']['css'] = 'list_css'; /* add rides css */
        $data['product_id'] = $product_id;
        $this->load->view($this->name . '/gallery_list', $data);/* load list.php of rides folder for list of rides */
    }


    public function gallery_post($id)
    {
        if ($_FILES['image']) {
            $image = $this->file_upload($_FILES['image'], GALLERY_IMG_DIR);
            $extension_pos = strrpos($image, '.'); // find position of the last dot, so where the extension starts
            $thumb = substr($image, 0, $extension_pos) . '_thumb' . substr($image, $extension_pos);
            $in_array = array(
                'product_id' => ($id) ? ($id) : '',
                'image' => ($image) ? ($image) : '',
                'thumbnail' => ($thumb) ? ($thumb) : '',
                'status' => '1',
                'created_at' => date("Y-m-d H:i:s")
            );
            $this->db->insert('tbl_gallery', $in_array);

            if ($this->db->affected_rows() > 0) {

                $this->session->set_flashdata('success', ADD_SUCCESS);

            } else {  // If $result array variable empty

                $this->session->set_flashdata('error', ERR_MESSAGE);

            }
            redirect('product/product/' . $id . '/gallery/list');
        } else {
            $data['page']['page_title'] = APP_NAME . ADD_GALLERY; // Add rides title
            $data['page']['css'] = 'form_css'; // add rides css
            $data['product_id'] = $id;
            $this->load->view($this->dir_path . 'gallery_post', $data); //load post.php of rides folder for add of rides
        }

    }


    public function gallery_update($product_id, $id)
    {
        if ($_FILES['image']) {
            $image = $this->file_upload($_FILES['image'], GALLERY_IMG_DIR);
            $extension_pos = strrpos($image, '.'); // find position of the last dot, so where the extension starts
            $thumb = substr($image, 0, $extension_pos) . '_thumb' . substr($image, $extension_pos);
            $rowData = $this->db->where(array('status' => '1', 'id' => $id))->get('tbl_gallery')->row();
            $in_array = array(
                'image' => ($image) ? ($image) : $rowData->image,
                'thumbnail' => ($thumb) ? ($thumb) : $rowData->thumbnail,
                'product_id' => $product_id,
                'status' => '1',
                'created_at' => date("Y-m-d H:i:s")
            );

            $this->db->where('id', $id);
            $this->db->update('tbl_gallery', $in_array);

            if ($this->db->affected_rows() > 0) {

                $this->session->set_flashdata('success', ADD_SUCCESS);

            } else {

                $this->session->set_flashdata('error', ERR_MESSAGE);

            }

            redirect('product/product/' . $product_id . '/gallery/list');
        } else {
            $this->db->from('tbl_gallery');
            $query = $this->db->where('id', $id)->get()->result();
            $result['1'] = $query[0];
            $result['id'] = $id;
            $data['result'] = $result;
            $data['page']['page_title'] = APP_NAME . EDIT_GALLERY;
            $data['page']['css'] = 'form_css';
            $data['product_id'] = $id;
            $this->load->view($this->dir_path . 'gallery_update', $data);
        }
    }

    public function gallery_delete($product_id, $id)
    {
        $this->db->where('id', $id);

        $data = array(
            'product_id' => $product_id,
            'status' => '9',
            'updated_at' => date('Y-m-d H:i:s')
        );
        $this->db->update('tbl_gallery', $data);

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

    public function resizeImage($filename)
    {
        $source_path = GALLERY_IMG_DIR . $filename;
        $target_path = GALLERY_IMG_DIR . 'thumbnail';
        $config_manip = array(
            'image_library' => 'gd2',
            'source_image' => $source_path,
            'new_image' => $target_path,
            'maintain_ratio' => TRUE,
            'create_thumb' => TRUE,
            'thumb_marker' => '_thumb',
            'width' => 150,
            'height' => 150
        );

        $this->load->library('image_lib', $config_manip);
        if (!$this->image_lib->resize()) {
            echo $this->image_lib->display_errors();
        }

        $this->image_lib->clear();
    }

}