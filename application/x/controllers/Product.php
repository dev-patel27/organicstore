<?php


defined('BASEPATH') OR exit('No direct script access allowed');

class Product extends CI_Controller
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
        $this->dir_path = "product/";
        $this->name = "product";
    }

    /*category*/
    public function product_category_lists()
    {

        $data['page']['page_title'] = APP_NAME . LIST_PRODUCT_CATEGORY; /* Add rides title*/
        $data['page']['css'] = 'list_css'; /* add rides css */
        $this->load->view($this->name . '/product_category_list', $data);/* load list.php of rides folder for list of rides */

    }


    public function product_category_post()
    {
        if ($this->input->post()) {
            /*$image = $this->file_upload($_FILES['image'], PRODUCT_CATEGORY_IMG_DIR);*/
            $category_name = $_REQUEST['category_name'];
            $rowData = $this->db->where(array('status' => '1', 'category_name' => $category_name))->get('tbl_product_category')->row();
            if (empty($rowData)) {
                $in_array = array(
                    'category_name' => ($category_name) ? ($category_name) : '',
                    /*'category_image' => ($image) ? ($image) : '',*/
                    'status' => '1',
                    'created_at' => date("Y-m-d H:i:s")
                );
                $this->db->insert('tbl_product_category', $in_array);


                if ($this->db->affected_rows() > 0) {

                    $this->session->set_flashdata('success', ADD_SUCCESS);

                } else {  // If $result array variable empty

                    $this->session->set_flashdata('error', ERR_MESSAGE);

                }
            } else {
                $this->session->set_flashdata('error', "Category is already exist.Try another.");
            }
            redirect('product/category/list');
        } else {
            $data['page']['page_title'] = APP_NAME . ADD_PRODUCT_CATEGORY; // Add rides title
            $data['page']['css'] = 'form_css'; // add rides css
            $this->load->view($this->dir_path . 'product_category_post', $data); //load post.php of rides folder for add of rides
        }

    }

    public function product_category_update($id)
    {
        if ($this->input->post()) {
            /*$image = $this->file_upload($_FILES['image'], PRODUCT_CATEGORY_IMG_DIR);
            $rowData = $this->db->where(array('status' => '1', 'id' => $id))->get('tbl_product_category')->row();*/
            $category_name = $_REQUEST['category_name'];
            $rowData = $this->db->where(array('status' => '1', 'id !=' => $id, 'category_name' => $category_name))->get('tbl_product_category')->row();
            if (empty($rowData)) {
                $in_array = array(
                    'category_name' => ($_REQUEST['category_name']) ? ($_REQUEST['category_name']) : '',
                    /*'category_image' => ($image) ? ($image) : $rowData->category_image,*/
                    'status' => '1',
                    'updated_at' => date("Y-m-d H:i:s")
                );

                $this->db->where('id', $id);
                $this->db->update('tbl_product_category', $in_array);

                if ($this->db->affected_rows() > 0) {

                    $this->session->set_flashdata('success', ADD_SUCCESS);

                } else {

                    $this->session->set_flashdata('error', ERR_MESSAGE);

                }
            } else {
                $this->session->set_flashdata('error', "Category is already exist.Try another.");
            }
            redirect('product/category/list');
        } else {
            $this->db->from('tbl_product_category');
            $query = $this->db->where('id', $id)->get()->result();
            $result['1'] = $query[0];
            $result['id'] = $id;
            $data['result'] = $result;
            $data['page']['page_title'] = APP_NAME . EDIT_PRODUCT_CATEGORY;
            $data['page']['css'] = 'form_css';
            $this->load->view($this->dir_path . 'product_category_update', $data);
        }
    }

    public function product_category_delete($id)
    {
        $this->db->where('id', $id);

        $data = array(
            'status' => '9',
            'updated_at' => date('Y-m-d H:i:s')
        );
        $this->db->update('tbl_product_category', $data);

        if ($this->db->affected_rows() > 0) {

            $this->session->set_flashdata('success', DELETE_SUCCESS);
            redirect($_SERVER['HTTP_REFERER']);
        } else {  /* If $result array variable empty */

            $this->session->set_flashdata('err_message', ERR_MESSAGE);
            redirect($_SERVER['HTTP_REFERER']);
        }
    }


    public function product_subcategory_lists()
    {

        $data['page']['page_title'] = APP_NAME . LIST_PRODUCT_SUB_CATEGORY; /* Add rides title*/
        $data['page']['css'] = 'list_css'; /* add rides css */
        $this->load->view($this->name . '/product_subcategory_list', $data);/* load list.php of rides folder for list of rides */

    }

    /*sub category*/
    public function product_subcategory_post()
    {
        if ($this->input->post()) {
            /*$image = $this->file_upload($_FILES['image'], PRODUCT_SUBCATEGORY_IMG_DIR);*/
            $sub_category_name = $_REQUEST['sub_category_name'];
            $rowData = $this->db->where(array('status' => '1', 'sub_category_name' => $sub_category_name))->get('tbl_product_subcategory')->row();
            if (empty($rowData)) {
                $in_array = array(
                    'category_id' => ($_REQUEST['category_id']) ? ($_REQUEST['category_id']) : '',
                    'sub_category_name' => ($sub_category_name) ? ($sub_category_name) : '',
                    /*'sub_category_image' => ($image) ? ($image) : '',*/
                    'status' => '1',
                    'created_at' => date("Y-m-d H:i:s")
                );
                $this->db->insert('tbl_product_subcategory', $in_array);


                if ($this->db->affected_rows() > 0) {

                    $this->session->set_flashdata('success', ADD_SUCCESS);

                } else {  // If $result array variable empty

                    $this->session->set_flashdata('error', ERR_MESSAGE);

                }
            } else {
                $this->session->set_flashdata('error', "Sub Category is already exist.Try another.");
            }
            redirect('product/sub-category/list');
        } else {
            $data['page']['page_title'] = APP_NAME . ADD_PRODUCT_SUB_CATEGORY; // Add rides title
            $data['page']['css'] = 'form_css'; // add rides css
            $this->load->view($this->dir_path . 'product_subcategory_post', $data); //load post.php of rides folder for add of rides
        }

    }


    public function product_subcategory_update($id)
    {
        if ($this->input->post()) {
            /*$image = $this->file_upload($_FILES['image'], PRODUCT_SUBCATEGORY_IMG_DIR);*/
            $sub_category_name = $_REQUEST['sub_category_name'];
            $rowData = $this->db->where(array('status' => '1', 'id !=' => $id, 'sub_category_name' => $sub_category_name))->get('tbl_product_subcategory')->row();
            if (empty($rowData)) {
                $in_array = array(
                    'category_id' => ($sub_category_name) ? ($sub_category_name) : '',
                    'sub_category_name' => ($_REQUEST['sub_category_name']) ? ($_REQUEST['sub_category_name']) : '',
                    /*'sub_category_image' => ($image) ? ($image) : $rowData->sub_category_image,*/
                    'status' => '1',
                    'updated_at' => date("Y-m-d H:i:s")
                );
                $this->db->where('id', $id);
                $this->db->update('tbl_product_subcategory', $in_array);

                if ($this->db->affected_rows() > 0) {

                    $this->session->set_flashdata('success', ADD_SUCCESS);

                } else {

                    $this->session->set_flashdata('error', ERR_MESSAGE);

                }
            } else {
                $this->session->set_flashdata('error', "Sub Category is already exist.Try another.");
            }
            redirect('product/sub-category/list');
        } else {
            $this->db->from('tbl_product_subcategory');
            $query = $this->db->where('id', $id)->get()->result();
            $result['1'] = $query[0];
            $result['id'] = $id;
            $data['result'] = $result;
            $data['page']['page_title'] = APP_NAME . EDIT_PRODUCT_SUB_CATEGORY;
            $data['page']['css'] = 'form_css';
            $this->load->view($this->dir_path . 'product_subcategory_update', $data);
        }
    }

    public function product_subcategory_delete($id)
    {
        $this->db->where('id', $id);

        $data = array(
            'status' => '9',
            'updated_at' => date('Y-m-d H:i:s')
        );
        $this->db->update('tbl_product_subcategory', $data);

        if ($this->db->affected_rows() > 0) {
            $this->session->set_flashdata('success', DELETE_SUCCESS);
            redirect($_SERVER['HTTP_REFERER']);
        } else {  /* If $result array variable empty */

            $this->session->set_flashdata('err_message', ERR_MESSAGE);
            redirect($_SERVER['HTTP_REFERER']);
        }
    }


    /*product*/
    public function product_lists()
    {
        if ($this->input->post()) {

            if ($_POST['checked'] != '' && $_POST['id'] != '') {
                $val = ($_POST['checked'] == 'true') ? '1' : '0';
                $id = ($_POST['id']);
                $in_array = array(
                    'availability' => ($val) ? ($val) : '',
                    'status' => '1',
                    'updated_at' => date("Y-m-d H:i:s")
                );

                $this->db->where('id', $id);
                $update = $this->db->update('tbl_product', $in_array);
                if ($update) {
                    $arrayData = array(
                        'status' => 200,
                        'message' => 'Display on page'
                    );
                } else {
                    $arrayData = array(
                        'status' => 400,
                        'message' => 'Record can not display on page'
                    );
                }
            }

            if ($_POST['checked1'] != '' && $_POST['id1'] != '') {
                $val = ($_POST['checked1'] == 'true') ? '1' : '0';
                $id = ($_POST['id1']);
                $in_array = array(
                    'deal_week' => ($val) ? ($val) : '',
                    'status' => '1',
                    'updated_at' => date("Y-m-d H:i:s")
                );

                $this->db->where('id', $id);
                $update = $this->db->update('tbl_product', $in_array);
                if ($update) {
                    $arrayData = array(
                        'status' => 200,
                        'message' => 'Display on page'
                    );
                } else {
                    $arrayData = array(
                        'status' => 400,
                        'message' => 'Record can not display on page'
                    );
                }
            }

            if ($_POST['checked2'] != '' && $_POST['id2'] != '') {
                $val = ($_POST['checked2'] == 'true') ? '1' : '0';
                $id = ($_POST['id2']);
                $in_array = array(
                    'featured_products' => ($val) ? ($val) : '',
                    'status' => '1',
                    'updated_at' => date("Y-m-d H:i:s")
                );

                $this->db->where('id', $id);
                $update = $this->db->update('tbl_product', $in_array);
                if ($update) {
                    $arrayData = array(
                        'status' => 200,
                        'message' => 'Display on page'
                    );
                } else {
                    $arrayData = array(
                        'status' => 400,
                        'message' => 'Record can not display on page'
                    );
                }
            }

        }

        $data['page']['page_title'] = APP_NAME . LIST_PRODUCT; /* Add rides title*/
        $data['page']['css'] = 'list_css'; /* add rides css */
        $this->load->view($this->name . '/product_list', $data);/* load list.php of rides folder for list of rides */

    }

    public function product_view($id)
    {
        $this->db->select('tbl_product.*')->from('tbl_product');
        $query = $this->db->where('id', $id)->get()->result();
        $result['1'] = $query[0];
        $result['id'] = $id;
        $data['result'] = $result;
        $data['page']['page_title'] = APP_NAME . EDIT_PRODUCT;
        $data['page']['css'] = 'form_css';
        $this->load->view($this->dir_path . 'product_view', $data);
    }


    public function product_post()
    {
        if ($this->input->post()) {
            $image = $this->file_upload($_FILES['image'], PRODUCT_IMG_DIR);
            $extension_pos = strrpos($image, '.'); // find position of the last dot, so where the extension starts
            $thumb = substr($image, 0, $extension_pos) . '_thumb' . substr($image, $extension_pos);

            $data['category_id'] = $_REQUEST['category_id'];
            $data['sub_category_id'] = $_REQUEST['sub_category_id'];
            $data['tag_id'] = implode(',', $_REQUEST['tag_id']);
            $data['product_name'] = $_REQUEST['product_name'];
            $data['image'] = ($image) ? ($image) : '';
            $data['thumbnail'] = ($thumb) ? ($thumb) : '';
            $data['short_description'] = $_REQUEST['short_description'];
            $data['description'] = $_REQUEST['description'];
            $data['calories'] = $_REQUEST['calories'];
            $data['nutrition'] = $_REQUEST['nutrition'];
            $data['storage_life'] = $_REQUEST['storage_life'];
            $data['per_pack'] = $_REQUEST['per_pack'];
            $data['price'] = $_REQUEST['price'];
            $data['discount_percentage'] = $_REQUEST['discount_percentage'];
            $data['shipping_charge'] = $_REQUEST['shipping_charge'];
            $data['meta_title'] = $_REQUEST['meta_title'];
            $data['meta_description'] = $_REQUEST['meta_description'];
            $data['meta_keyword'] = $_REQUEST['meta_keyword'];
            $data['status'] = '1';
            $data['created_at'] = date("Y-m-d H:i:s");

            $this->db->insert('tbl_product', $data);


            if ($this->db->affected_rows() > 0) {

                $this->session->set_flashdata('success', ADD_SUCCESS);

            } else {  // If $result array variable empty

                $this->session->set_flashdata('error', ERR_MESSAGE);

            }
            redirect('product/product/list');
        } else {
            $data['page']['page_title'] = APP_NAME . ADD_PRODUCT; // Add rides title
            $data['page']['css'] = 'form_css'; // add rides css
            $this->load->view($this->dir_path . 'product_post', $data); //load post.php of rides folder for add of rides
        }

    }


    public function product_update($id)
    {
        if ($this->input->post()) {
            $image = $this->file_upload($_FILES['image'], PRODUCT_IMG_DIR);
            $extension_pos = strrpos($image, '.'); // find position of the last dot, so where the extension starts
            $thumb = substr($image, 0, $extension_pos) . '_thumb' . substr($image, $extension_pos);
            $rowData = $this->db->where(array('status' => '1', 'id' => $id))->get('tbl_product')->row();

            $data['category_id'] = $_REQUEST['category_id'];
            $data['sub_category_id'] = $_REQUEST['sub_category_id'];
            $data['tag_id'] = implode(',', $_REQUEST['tag_id']);
            $data['product_name'] = $_REQUEST['product_name'];
            $data['image'] = ($image) ? ($image) : $rowData->image;
            $data['thumbnail'] = ($thumb) ? ($thumb) : $rowData->thumbnail;
            $data['short_description'] = $_REQUEST['short_description'];
            $data['description'] = $_REQUEST['description'];
            $data['calories'] = $_REQUEST['calories'];
            $data['nutrition'] = $_REQUEST['nutrition'];
            $data['storage_life'] = $_REQUEST['storage_life'];
            $data['per_pack'] = $_REQUEST['per_pack'];
            $data['price'] = $_REQUEST['price'];
            $data['discount_percentage'] = $_REQUEST['discount_percentage'];
            $data['shipping_charge'] = $_REQUEST['shipping_charge'];
            $data['meta_title'] = $_REQUEST['meta_title'];
            $data['meta_description'] = $_REQUEST['meta_description'];
            $data['meta_keyword'] = $_REQUEST['meta_keyword'];
            $data['status'] = '1';
            $data['created_at'] = date("Y-m-d H:i:s");

            $this->db->where('id', $id);
            $this->db->update('tbl_product', $data);

            if ($this->db->affected_rows() > 0) {

                $this->session->set_flashdata('success', ADD_SUCCESS);

            } else {

                $this->session->set_flashdata('error', ERR_MESSAGE);

            }

            redirect('product/product/list');
        } else {
            $this->db->from('tbl_product');
            $query = $this->db->where('id', $id)->get()->result();
            $result['1'] = $query[0];
            $result['id'] = $id;
            $data['result'] = $result;
            $data['page']['page_title'] = APP_NAME . EDIT_PRODUCT;
            $data['page']['css'] = 'form_css';
            $this->load->view($this->dir_path . 'product_update', $data);
        }
    }

    public function product_delete($id)
    {
        $this->db->where('id', $id);

        $data = array(
            'status' => '9',
            'updated_at' => date('Y-m-d H:i:s')
        );
        $this->db->update('tbl_product', $data);

        if ($this->db->affected_rows() > 0) {

            $this->session->set_flashdata('success', DELETE_SUCCESS);
            redirect($_SERVER['HTTP_REFERER']);
        } else {  /* If $result array variable empty */

            $this->session->set_flashdata('err_message', ERR_MESSAGE);
            redirect($_SERVER['HTTP_REFERER']);
        }
    }


    /*Tag*/
    public function tag_lists()
    {

        $data['page']['page_title'] = APP_NAME . LIST_TAG; /* Add rides title*/
        $data['page']['css'] = 'list_css'; /* add rides css */
        $this->load->view($this->dir_path . 'tag_lists', $data);/* load list.php of rides folder for list of rides */

    }

    public function tag_post()
    {
        if ($this->input->post()) {

            $tag_name = $_REQUEST['tag_name'];
            $rowData = $this->db->where(array('status' => '1', 'tag_name' => $tag_name))->get('tbl_tag')->row();
            if (empty($rowData)) {
                $in_array = array(
                    'tag_name' => ($tag_name) ? ($tag_name) : '',
                    'status' => '1',
                    'created_at' => date("Y-m-d H:i:s")
                );
                $this->db->insert('tbl_tag', $in_array);

                if ($this->db->affected_rows() > 0) {

                    $this->session->set_flashdata('success', ADD_SUCCESS);

                } else {  // If $result array variable empty

                    $this->session->set_flashdata('error', ERR_MESSAGE);

                }
            } else {
                $this->session->set_flashdata('error', "Tag is already exist.Try another.");
            }
            redirect('product/tag/list');
        } else {
            $data['page']['page_title'] = APP_NAME . ADD_TAG; // Add rides title
            $data['page']['css'] = 'form_css'; // add rides css
            $this->load->view($this->dir_path . 'tag_post', $data); //load post.php of rides folder for add of rides
        }

    }


    public function tag_update($id)
    {
        if ($this->input->post()) {

            $tag_name = $_REQUEST['tag_name'];
            $rowData = $this->db->where(array('status' => '1', 'id !=' => $id, 'tag_name' => $tag_name))->get('tbl_tag')->row();
            if (empty($rowData)) {
                $in_array = array(
                    'tag_name' => ($tag_name) ? ($tag_name) : '',
                    'status' => '1',
                    'updated_at' => date("Y-m-d H:i:s")
                );
                $this->db->where('id', $id)->update('tbl_tag', $in_array);

                if ($this->db->affected_rows() > 0) {

                    $this->session->set_flashdata('success', EDIT_SUCCESS);

                } else {  // If $result array variable empty

                    $this->session->set_flashdata('error', ERR_MESSAGE);

                }
            } else {
                $this->session->set_flashdata('error', "Tag is already exist.Try another.");
            }
            redirect('product/tag/list');
        } else {
            $this->db->from('tbl_tag');
            $query = $this->db->where('id', $id)->get()->result();
            $result['1'] = $query[0];
            $result['id'] = $id;
            $data['result'] = $result;
            $data['page']['page_title'] = APP_NAME . EDIT_TAG; /* Add default_room title*/
            $data['page']['css'] = 'form_css'; /* add default_room css */
            $this->load->view($this->dir_path . 'tag_update', $data);/* load update.php of default_room folder for edit of default_room */
        }

    }

    public function tag_delete($id)
    {

        $this->db->where('id', $id);
        $data = array(
            'status' => '9',
            'updated_at' => date('Y-m-d H:i:s')
        );
        $this->db->update('tbl_tag', $data);
        /* If $result array variable not empty */
        if ($this->db->affected_rows() > 0) {
            $this->session->set_flashdata('success', DELETE_SUCCESS);
            redirect($_SERVER['HTTP_REFERER']);
        } else {  /* If $result array variable empty */

            $this->session->set_flashdata('err_message', ERR_MESSAGE);
            redirect($_SERVER['HTTP_REFERER']);
        }

    }

    //coupon code//
    public function couponcode_lists()
    {

        $data['page']['page_title'] = APP_NAME . LIST_COUPON; /* Add rides title*/
        $data['page']['css'] = 'list_css'; /* add rides css */
        $this->load->view($this->dir_path . 'couponcode_lists', $data);/* load list.php of rides folder for list of rides */

    }


    public function couponcode_post()
    {
        if ($this->input->post()) {

            $coupon_name = $_REQUEST['coupon_name'];
            $rowData = $this->db->where(array('status' => '1', 'coupon_name' => $coupon_name))->get('tbl_coupon_code')->row();
            if (empty($rowData)) {
                $data['coupon_name'] = ($coupon_name) ? ($coupon_name) : '';
                $data['price'] = ($_REQUEST['price']) ? ($_REQUEST['price']) : '';
                $data['created_at'] = date("Y-m-d H:i:s");
                $data['status'] = '1';

                $this->db->insert('tbl_coupon_code', $data);

                if ($this->db->affected_rows() > 0) {

                    $this->session->set_flashdata('success', ADD_SUCCESS);

                } else {  // If $result array variable empty

                    $this->session->set_flashdata('err_message', ERR_MESSAGE);

                }
            } else {
                $this->session->set_flashdata('error', "Coupon code is already exist.Try another.");
            }
            redirect('product/coupon-code/list');
        }

        $data['page']['page_title'] = APP_NAME . ADD_COUPON; // Add rides title
        $data['page']['css'] = 'form_css'; // add rides css
        $this->load->view($this->dir_path . 'couponcode_post', $data); //load post.php of rides folder for add of rides
    }


    public function couponcode_update($id)
    {
        if ($this->input->post()) {

            $coupon_name = $_REQUEST['coupon_name'];
            $rowData = $this->db->where(array('status' => '1', 'coupon_name' => $coupon_name))->get('tbl_coupon_code')->row();
            if (empty($rowData)) {

                $data['coupon_name'] = ($coupon_name) ? ($coupon_name) : '';
                $data['price'] = ($_REQUEST['price']) ? ($_REQUEST['price']) : '';
                $data['updated_at'] = date("Y-m-d H:i:s");
                $data['status'] = '1';

                $this->db->where('id', $id);
                $this->db->update('tbl_coupon_code', $data);

                if ($this->db->affected_rows() > 0) {

                    $this->session->set_flashdata('success', EDIT_SUCCESS);

                } else {  /* If $result array variable empty */

                    $this->session->set_flashdata('err_message', ERR_MESSAGE);

                }

            } else {
                $this->session->set_flashdata('error', "Coupon code is already exist.Try another.");
            }
            redirect('product/coupon-code/list');
        }

        $this->db->from('tbl_coupon_code');
        $query = $this->db->where('id', $id)->get()->result();
        $result['1'] = $query[0];
        $result['id'] = $id;
        $data['result'] = $result;
        $data['page']['page_title'] = APP_NAME . EDIT_COUPON; /* Add default_room title*/
        $data['page']['css'] = 'form_css'; /* add default_room css */
        $this->load->view($this->dir_path . 'couponcode_update', $data);/* load update.php of default_room folder for edit of default_room */

    }


    public function couponcode_delete($id)
    {

        $this->db->where('id', $id);

        $data = array(
            'status' => '9',
            'updated_at' => date('Y-m-d H:i:s')
        );
        $this->db->update('tbl_coupon_code', $data);
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


    public function getProduct_subcategory()
    {
        if ($this->input->post('category_id')) {
            $category_id = $this->input->post('category_id');
            $sub_category = $this->db->where(array('status' => '1', 'category_id' => $category_id))->get('tbl_product_subcategory')->result();
            $output = "";
            $output .= "<option value=''>Select Sub Category</option>";
            if ($sub_category) {
                foreach ($sub_category as $row) {
                    $output .= "<option value='" . $row->id . "'>" . $row->sub_category_name . "</option>";
                }
                $arrayData = array(
                    'status' => 200,
                    'message' => 'OK',
                    'data' => $output);
                echo json_encode($arrayData);
                exit;
            } else {
                $arrayData = array(
                    'status' => 400,
                    'message' => 'OK',
                    'data' => $output);
                echo json_encode($arrayData);
                exit;
            }
        }

    }

    public function resizeImage($filename)
    {
        $source_path = PRODUCT_IMG_DIR . $filename;
        $target_path = PRODUCT_IMG_DIR . 'thumbnail';
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