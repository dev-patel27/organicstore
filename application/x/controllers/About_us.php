<?php


defined('BASEPATH') OR exit('No direct script access allowed');

class About_us extends CI_Controller
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

        $this->dir_path = "about_us/";
        $this->name = "about_us";
    }


//about us
    public function about_us_lists()
    {

        $data['page']['page_title'] = APP_NAME . LIST_ABOUT_US; /* Add rides title*/
        $data['page']['css'] = 'list_css'; /* add rides css */
        $this->load->view($this->name . '/about_us_list', $data);/* load product_list.php of rides folder for list of rides */

    }


    public function about_us_post()
    {
        if ($this->input->post()) {
            $image = $this->file_upload($_FILES['image'], ABOUT_US_IMG_DIR);
            $in_array = array(
                'image' => ($image) ? ($image) : '',
                'description' => ($_REQUEST['description']) ? ($_REQUEST['description']) : '',
                'status' => '1',
                'created_at' => date("Y-m-d H:i:s")
            );
            $this->db->insert('tbl_about_us', $in_array);


            if ($this->db->affected_rows() > 0) {

                $this->session->set_flashdata('success', ADD_SUCCESS);

            } else {  // If $result array variable empty 

                $this->session->set_flashdata('error', ERR_MESSAGE);

            }
            redirect('about-us/about-us/list');
        } else {
            $data['page']['page_title'] = APP_NAME . ADD_ABOUT_US; // Add rides title
            $data['page']['css'] = 'form_css'; // add rides css 
            $this->load->view($this->dir_path . 'about_us_post', $data); //load product_post.php of rides folder for add of rides
        }

    }


    public function about_us_update($id)
    {
        if ($this->input->post()) {
            $image = $this->file_upload($_FILES['image'], ABOUT_US_IMG_DIR);
            $rowData = $this->db->where(array('status' => '1', 'id' => $id))->get('tbl_about_us')->row();
            $in_array = array(
                'image' => ($image) ? ($image) : $rowData->image,
                'description' => ($_REQUEST['description']) ? ($_REQUEST['description']) : '',
                'status' => '1',
                'updated_at' => date("Y-m-d H:i:s")
            );

            $this->db->where('id', $id);
            $this->db->update('tbl_about_us', $in_array);

            if ($this->db->affected_rows() > 0) {

                $this->session->set_flashdata('success', ADD_SUCCESS);

            } else {

                $this->session->set_flashdata('error', ERR_MESSAGE);

            }

            redirect('about-us/about-us/list');
        } else {
            $this->db->from('tbl_about_us');
            $query = $this->db->where('id', $id)->get()->result();
            $result['1'] = $query[0];
            $result['id'] = $id;
            $data['result'] = $result;
            $data['page']['page_title'] = APP_NAME . EDIT_ABOUT_US;
            $data['page']['css'] = 'form_css';
            $this->load->view($this->dir_path . 'about_us_update', $data);
        }
    }

    public function about_us_view($id)
    {

        $this->db->select('description,image,')->from('tbl_about_us');
        $query = $this->db->where('id', $id)->get()->result();
        $result['1'] = $query[0];
        $result['id'] = $id;
        $data['result'] = $result;
        $data['page']['page_title'] = APP_NAME . EDIT_ABOUT_US;
        $data['page']['css'] = 'form_css';
        $this->load->view($this->dir_path . 'about_us_view', $data);

    }

    public function about_us_delete($id)
    {

        $this->db->where('id', $id);

        $data = array(
            'status' => '9',
            'updated_at' => date('Y-m-d H:i:s')
        );
        $this->db->update('tbl_about_us', $data);

        if ($this->db->affected_rows() > 0) {

            $this->session->set_flashdata('success', DELETE_SUCCESS);
            redirect($_SERVER['HTTP_REFERER']);
        } else {  /* If $result array variable empty */

            $this->session->set_flashdata('err_message', ERR_MESSAGE);
            redirect($_SERVER['HTTP_REFERER']);
        }

    }

//counter
    public function counter_lists()
    {

        $data['page']['page_title'] = APP_NAME . LIST_COUNTER; /* Add rides title*/
        $data['page']['css'] = 'list_css'; /* add rides css */
        $this->load->view($this->name . '/counter_list', $data);/* load product_list.php of rides folder for list of rides */

    }


    public function counter_post()
    {
        $image = $this->file_upload($_FILES['image'], ABOUT_US_IMG_DIR);
        if ($this->input->post()) {
            $in_array = array(
                'image' => ($image) ? ($image) : '',
                'title' => ($_REQUEST['title']) ? ($_REQUEST['title']) : '',
                'counter_value' => ($_REQUEST['counter_value']) ? ($_REQUEST['counter_value']) : '',
                'status' => '1',
                'created_at' => date("Y-m-d H:i:s")
            );

            $this->db->insert('tbl_counter', $in_array);

            if ($this->db->affected_rows() > 0) {

                $this->session->set_flashdata('success', ADD_SUCCESS);

            } else {  // If $result array variable empty

                $this->session->set_flashdata('error', ERR_MESSAGE);

            }
            redirect('about-us/counter/list');
        } else {
            $data['page']['page_title'] = APP_NAME . ADD_COUNTER; // Add rides title
            $data['page']['css'] = 'form_css'; // add rides css
            $this->load->view($this->dir_path . 'counter_post', $data); //load product_post.php of rides folder for add of rides
        }

    }


    public function counter_update($id)
    {
        $image = $this->file_upload($_FILES['image'], ABOUT_US_IMG_DIR);
        if ($this->input->post()) {
            $rowData = $this->db->where(array('status' => '1', 'id' => $id))->get('tbl_counter')->row();
            $in_array = array(
                'image' => ($image) ? ($image) : $rowData->image,
                'title' => ($_REQUEST['title']) ? ($_REQUEST['title']) : '',
                'counter_value' => ($_REQUEST['counter_value']) ? ($_REQUEST['counter_value']) : '',
                'status' => '1',
                'updated_at' => date("Y-m-d H:i:s")
            );

            $this->db->where('id', $id);
            $this->db->update('tbl_counter', $in_array);

            if ($this->db->affected_rows() > 0) {

                $this->session->set_flashdata('success', ADD_SUCCESS);

            } else {

                $this->session->set_flashdata('error', ERR_MESSAGE);

            }

            redirect('about-us/counter/list');
        } else {
            $this->db->from('tbl_counter');
            $query = $this->db->where('id', $id)->get()->result();
            $result['1'] = $query[0];
            $result['id'] = $id;
            $data['result'] = $result;
            $data['page']['page_title'] = APP_NAME . EDIT_COUNTER;
            $data['page']['css'] = 'form_css';
            $this->load->view($this->dir_path . 'counter_update', $data);
        }
    }

    public function counter_delete($id)
    {

        $this->db->where('id', $id);

        $data = array(
            'status' => '9',
            'updated_at' => date('Y-m-d H:i:s')
        );
        $this->db->update('tbl_counter', $data);

        if ($this->db->affected_rows() > 0) {

            $this->session->set_flashdata('success', DELETE_SUCCESS);
            redirect($_SERVER['HTTP_REFERER']);
        } else {  /* If $result array variable empty */

            $this->session->set_flashdata('err_message', ERR_MESSAGE);
            redirect($_SERVER['HTTP_REFERER']);
        }

    }


//   why choose us
    public function why_choose_us_lists()
    {

        $data['page']['page_title'] = APP_NAME . LIST_WHY_CHOOSE_US; /* Add rides title*/
        $data['page']['css'] = 'list_css'; /* add rides css */
        $this->load->view($this->name . '/why_choose_us_list', $data);/* load product_list.php of rides folder for list of rides */

    }


    public function why_choose_us_post()
    {
        $image = $this->file_upload($_FILES['image'], ABOUT_US_IMG_DIR);
        if ($this->input->post()) {
            $in_array = array(
                'title' => ($_REQUEST['title']) ? ($_REQUEST['title']) : '',
                'image' => ($image) ? ($image) : '',
                'status' => '1',
                'created_at' => date("Y-m-d H:i:s")
            );
            $this->db->insert('tbl_why_choose_us', $in_array);


            if ($this->db->affected_rows() > 0) {

                $this->session->set_flashdata('success', ADD_SUCCESS);

            } else {  // If $result array variable empty

                $this->session->set_flashdata('error', ERR_MESSAGE);

            }
            redirect('about-us/why-choose-us/list');
        } else {
            $data['page']['page_title'] = APP_NAME . ADD_WHY_CHOOSE_US; // Add rides title
            $data['page']['css'] = 'form_css'; // add rides css
            $this->load->view($this->dir_path . 'why_choose_us_post', $data); //load product_post.php of rides folder for add of rides
        }

    }


    public function why_choose_us_update($id)
    {
        $image = $this->file_upload($_FILES['image'], ABOUT_US_IMG_DIR);
        $rowData = $this->db->where(array('status' => '1', 'id' => $id))->get('tbl_why_choose_us')->row();
        if ($this->input->post()) {
            $in_array = array(
                'title' => ($_REQUEST['title']) ? ($_REQUEST['title']) : '',
                'image' => ($image) ? ($image) : $rowData->image,
                'status' => '1',
                'updated_at' => date("Y-m-d H:i:s")
            );

            $this->db->where('id', $id);
            $this->db->update('tbl_why_choose_us', $in_array);

            if ($this->db->affected_rows() > 0) {

                $this->session->set_flashdata('success', ADD_SUCCESS);

            } else {

                $this->session->set_flashdata('error', ERR_MESSAGE);

            }

            redirect('about-us/why-choose-us/list');
        } else {
            $this->db->from('tbl_why_choose_us');
            $query = $this->db->where('id', $id)->get()->result();
            $result['1'] = $query[0];
            $result['id'] = $id;
            $data['result'] = $result;
            $data['page']['page_title'] = APP_NAME . EDIT_WHY_CHOOSE_US;
            $data['page']['css'] = 'form_css';
            $this->load->view($this->dir_path . 'why_choose_us_update', $data);
        }
    }

    public function why_choose_us_delete($id)
    {

        $this->db->where('id', $id);

        $data = array(
            'status' => '9',
            'updated_at' => date('Y-m-d H:i:s')
        );
        $this->db->update('tbl_why_choose_us', $data);

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