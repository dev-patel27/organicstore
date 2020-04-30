<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Front extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        if ($this->session->userdata('userSession')) {
            $this->userSession = $this->session->userdata('userSession');
        }
    }

    public function index()
    {
        $data['title'] = "";
        $this->load->view('index', $data);
    }

    public function registration()
    {
        $this->form_validation->set_rules('first_name', 'First Name', 'trim|min_length[3]|max_length[20]|required|regex_match[/^[a-z ,.-]+$/]', array('required' => 'First name is required', 'min_length' => 'The First name must be at least 3 characters in length', 'max_length' => 'The First name cannot exceed 20 characters in length', 'regex_match' => 'Please enter valid first name'));

        $this->form_validation->set_rules('last_name', 'Last Name', 'trim|min_length[3]|max_length[20]|required|regex_match[/^[a-z ,.-]+$/]', array('required' => 'Last name is required', 'min_length' => 'The Last name must be at least 3 characters in length', 'max_length' => 'The Last name cannot exceed 12 characters in length', 'regex_match' => 'Please enter valid last name'));

        $this->form_validation->set_rules('username', 'Username', 'trim|min_length[5]|max_length[12]|required|regex_match[/^[a-z]\w+$/]', array('required' => 'Username is required', 'regex_match' => 'Please enter valid name', 'min_length' => 'The Username must be at least 5 characters in length', 'max_length' => 'The Username cannot exceed 12 characters in length'));

        $this->form_validation->set_rules('email', 'Email', 'trim|required|valid_email', array('required' => 'Email is required', 'valid_email' => 'Please enter valid email'));

        $this->form_validation->set_rules('password', 'Password', 'trim|required|min_length[8]', array('required' => 'Please Enter Password', 'min_length' => 'The Password must be at least 8 characters in length'));

        $this->form_validation->set_rules('re_password', 'Password Confirmation', 'trim|matches[password]', array('matches' => 'Password don\'t match'));

        if ($this->form_validation->run() == false) {
            if (form_error('re_password')) {
                $arrayData = array(
                    'status' => 401,
                    'message' => 're_password',
                    'error' => true,
                    're_password_error' => strip_tags(form_error('re_password')),
                );
            }
            if (form_error('password')) {
                $arrayData = array(
                    'status' => 401,
                    'message' => 'password',
                    'error' => true,
                    'password_error' => strip_tags(form_error('password')),
                );
            }
            if (form_error('email')) {
                $arrayData = array(
                    'status' => 401,
                    'message' => 'email',
                    'error' => true,
                    'email_error' => strip_tags(form_error('email')),
                );
            }
            if (form_error('username')) {
                $arrayData = array(
                    'status' => 401,
                    'message' => 'username',
                    'error' => true,
                    'username_error' => strip_tags(form_error('username')),
                );
            }
            if (form_error('last_name')) {
                $arrayData = array(
                    'status' => 401,
                    'message' => 'last_name',
                    'error' => true,
                    'lname_error' => strip_tags(form_error('last_name')),
                );
            }
            if (form_error('first_name')) {
                $arrayData = array(
                    'status' => 401,
                    'message' => 'first_name',
                    'error' => true,
                    'fname_error' => strip_tags(form_error('first_name')),
                );
            }
        } else {
            $is_exits_email = $this->db->where(array('email' => $this->input->post('email'),
                'status' => '1'))
                ->get('tbl_customer_details')
                ->row();
            $is_exits_username = $this->db->where(array('username' => $this->input->post('username'),
                'status' => '1'))
                ->get('tbl_customer_details')
                ->row();
            if (empty($is_exits_email || $is_exits_username)) {
                $remote = $_SERVER['REMOTE_ADDR'];
                $in_array = array(
                    'first_name' => $this->input->post('first_name') ? $this->input->post('first_name') : '',
                    'last_name' => $this->input->post('last_name') ? $this->input->post('last_name') : '',
                    'username' => $this->input->post('username') ? $this->input->post('username') : '',
                    'email' => $this->input->post('email') ? $this->input->post('email') : '',
                    'password' => $this->input->post('password') ? md5($this->input->post('password')) : '',
                    'ip_address' => $remote,
                    'status' => '1',
                    'created_at' => date("Y-m-d H:i:s"),
                );

                $insert = $this->db->insert('tbl_customer_details', $in_array);
                $to = $this->input->post('email') ? $this->input->post('email') : '';
                $subject = 'Email verification';
                $username = $this->input->post('username') ? $this->input->post('username') : '';
                $first_name = $this->input->post('first_name') ? $this->input->post('first_name') : '';
                $last_name = $this->input->post('last_name') ? $this->input->post('last_name') : '';
                $this->send_mail_verification($to, $subject, $username, $first_name, $last_name);

                $arrayData = array(
                    'status' => 200,
                    'message' => 'OK',
                    'data' => 'Thank you for registering with ' . WEB_NAME . ' Please verify your account for email. And you can enjoy with' . WEB_NAME . ' services',
                );
            } else {
                if (!empty($is_exits_email)) {
                    $output = 'That email is already registered.';
                }
                if (!empty($is_exits_username)) {
                    $output1 = 'Username is already exist.Try another.';
                }
                $arrayData = array(
                    'status' => 400,
                    'message' => 'Bad Request',
                    'data' => $output,
                    'data1' => $output1,
                );
            }
        }

        echo json_encode($arrayData);
        exit;
    }

    public function send_mail_verification($to, $subject, $username, $first_name, $last_name)
    {
        $to = $to;
        $message = "
           <!DOCTYPE html PUBLIC '-//W3C//DTD XHTML 1.0 Transitional//EN' 'http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd'>
           <html xmlns='http://www.w3.org/1999/xhtml'>
           <head>
           <meta http-equiv='Content-Type' content='text/html; charset=UTF-8' />
           <link href='http://fonts.googleapis.com/css?family=Open+Sans:400,300,600,700&subset=all' rel='stylesheet' type='text/css' />
           <title>You have new contact inquiry</title>
           <style type='text/css'>
                table {
                    font-family: 'Open Sans',sans-serif;
                }
           </style>
           </head>
           <body>
           <table border='1' cellpadding='0' cellspacing='0' height='100%' width='100%'' id='bodyTable' style='border-collapse: collapse;border-radius: 25px;'>
           <tr>
           <td colspan='2' style='text-align: center;'><h3>Organic Store</h3></td>
           </tr>
           <table border='0' cellpadding='10' cellspacing='0' width='100%' id='emailContainer'>
           <tr style='background-color: #ead2b6'>
            <td colspan='2' valign='top' style='padding: 8px;text-align: left;'><strong>Dear " . $first_name . " " . $last_name . "</strong> ,<br>Your username to login in Organic Store is <strong style='color: #ff0000;font-style: italic;'>" . $username . "</strong>.<br> Please verify your account email from '" . site_url() . 'verify-email/' . md5($to) . "'.</td>
           </tr>
           </table>
           <tr>
           <td colspan='2' style='padding: 8px;text-align: right;'>This mail is sent from <a href='" . site_url() . "'> <strong>Organic Store</strong> </a></td>
           </tr>
           </table>
           </body>
           </html>
       ";

        $pass = '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';
        $url = 'https://api.sendgrid.com/';
        $params = array(
            'to' => $to,
            'subject' => $subject,
            'html' => $message,
            'from' => 'OrganicStore',
        );
        $request = $url . 'api/mail.send.json';
        $headr = array();
        $headr[] = 'Authorization: Bearer ' . $pass;
        $session = curl_init($request);
        curl_setopt($session, CURLOPT_POST, true);
        curl_setopt($session, CURLOPT_POSTFIELDS, $params);
        curl_setopt($session, CURLOPT_HEADER, false);
        curl_setopt($session, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($session, CURLOPT_HTTPHEADER, $headr);
        $response = curl_exec($session);
        curl_close($session);
    }

    public function verify_email($email)
    {
        if ($email != '') {
            $is_exits = $this->db->where(array('md5(email)' => $email, 'status' => '1'))
                ->get('tbl_customer_details')
                ->row();
            if (!empty($is_exits)) {

                $updateArray = array(
                    'verify_email' => '1',
                    'updated_at' => date("Y-m-d H:i:s"),
                );
                $m1 = 'Your account  has been successfully verified.';
                $logi = "Login";
                $m2 = 'Your email can not be verify.';
                $m3 = "Your email does not exits. Please registered first. Click here";
                $res = 'Registration';

                $update = $this->db->where(array('status' => '1', 'md5(email)' => $email))
                    ->update('tbl_customer_details', $updateArray);
                if ($update) {
                    $data['message'] = '' . $m1 . '<a href="#" style="width: 92%;margin-left: 30px;" class="nav-link" data-toggle="modal"
                    data-backdrop="false" data-target="#LogInModal">' . $logi . '</a>';
                } else {
                    $data['message'] = $m2;
                }

            } else {
                $data['message'] = '' . $m3 . '<a href="#" data-toggle="modal" data-target="#RegistrationModal" data-backdrop="false"
                data-dismiss="modal">' . $res . ' </a>';
            }
        }
        $this->load->view('verify-email', $data);
    }

    public function login()
    {
        if ($this->input->post()) {
            $login_id = $this->input->post('login_id');
            $login_password = md5($this->input->post('login_password'));
            $this->form_validation->set_rules('login_id', 'Login Id', 'trim|required', array('required' => 'Username / E-mail is required'));

            $this->form_validation->set_rules('login_password', 'Password', 'trim|required', array('required' => 'Password is required'));

            if ($this->form_validation->run() == false) {
                if (form_error('login_password')) {
                    $arrayData = array(
                        'status' => 401,
                        'message' => 'login_password',
                        'error' => true,
                        'password_error' => strip_tags(form_error('login_password')),
                    );
                }
                if (form_error('login_id')) {
                    $arrayData = array(
                        'status' => 401,
                        'message' => 'login_id',
                        'error' => true,
                        'login_id_error' => strip_tags(form_error('login_id')),
                    );
                }
            } else {
                $is_email = $this->db->where("(email = '$login_id' OR username = '$login_id')")
                    ->where(array('status' => '1'))
                    ->get('tbl_customer_details')
                    ->row();
                if (!empty($is_email)) {
                    $is_email_verify = $this->db->where("(email = '$login_id' OR username = '$login_id')")
                        ->where(array('status' => '1', 'verify_email' => '1'))
                        ->get('tbl_customer_details')
                        ->row();
                    if (!empty($is_email_verify)) {
                        $isExits = $this->db->where("(email = '$login_id' OR username = '$login_id')")
                            ->where(array('status' => '1', 'password' => $login_password,
                            ))
                            ->get('tbl_customer_details')
                            ->row();
                        if (!empty($isExits)) {
                            $userSession = $this->session->set_userdata('userSession', $isExits);

                            /* if ($this->session->userdata('cartSession')) {
                            $cart_array = $this->session->userdata('cartSession');
                            // echo "<pre>"; print_r($cart_array); exit;
                            foreach ($cart_array as $key => $value) {
                            $is_exits_data = $this->db->where(array('product_id' => $value['product_id'], 'user_id' => $isExits->id, 'status' => '1', 'language_id' => $this->lang_id->id, 'attribute_id' => $value['attribute_id']))
                            ->get('tbl_shop_cart')
                            ->row();
                            if ($is_exits_data) {
                            // $quantity = $value['quantity'] + $is_exits_data->quantity;
                            $up_array = array(
                            'quantity' => $value['quantity'],
                            'product_price' => $value['product_price'],
                            'status' => '1',
                            'updated_at' => date("Y-m-d H:i:s"),
                            );
                            $update = $this->db->where('product_id', $value['product_id'])->where('user_id', $isExits->id)->where('status', '1')->where('language_id', $this->lang_id->id)->where('attribute_id', $value['attribute_id'])
                            ->update('tbl_shop_cart', $up_array);
                            } else {
                            $in_array = array(
                            'product_id' => $value['product_id'],
                            'quantity' => $value['quantity'],
                            'product_price' => $value['product_price'],
                            'user_id' => $isExits->id,
                            'attribute_id' => $value['attribute_id'],
                            'language_id' => $this->lang_id->id,
                            'status' => '1',
                            'created_at' => date("Y-m-d H:i:s"),
                            );
                            $insert = $this->db->insert('tbl_shop_cart', $in_array);
                            }
                            }
                            $this->session->unset_userdata('cartSession');
                            } */
                            $arrayData = array(
                                'status' => 200,
                                'message' => 'OK',
                                'data' => 'Welcome ' . ucfirst($isExits->first_name),
                            );
                        } else {
                            $arrayData = array(
                                'status' => 400,
                                'message' => 'Bad Request',
                                'data' => 'Wrong Username / E-mail or Password.',
                            );
                        }
                    } else {
                        $arrayData = array(
                            'status' => 400,
                            'message' => 'Bad Request',
                            'data' => 'Your Email is not verified. Please verified your email from your email account.',
                        );
                    }
                } else {
                    $arrayData = array(
                        'status' => 400,
                        'message' => 'Bad Request',
                        'data' => 'Your Email does not exist. Please Register first.',
                    );
                }
            }
            echo json_encode($arrayData);
            exit;
        }
    }

    public function forgot_password()
    {
        if ($this->input->post()) {
            $this->form_validation->set_rules('forgot_email', 'Forgot Email', 'trim|required|valid_email', array('required' => 'Email is required', 'valid_email' => 'Please enter valid email'));
            if ($this->form_validation->run() == false) {
                if (form_error('forgot_email')) {
                    $arrayData = array(
                        'status' => 401,
                        'message' => 'forgot_email',
                        'error' => true,
                        'forgot_email_error' => strip_tags(form_error('forgot_email')),
                    );
                }
            } else {
                $is_exist = $this->db->where(array('email' => $this->input->post('forgot_email'), 'status' => '1'))->get('tbl_customer_details')->row();

                if (!empty($is_exist)) {
                    $is_email_verified = $this->db->where(array('email' => $this->input->post('forgot_email'), 'verify_email' => '1', 'status' => '1'))->get('tbl_customer_details')->row();
                    if (!empty($is_email_verified)) {
                        $user_id = $is_email_verified->id;
                        $to = $this->input->post('forgot_email') ? $this->input->post('forgot_email') : '';
                        $subject = 'Email for Reset Password';
                        $arrayData = array(
                            'status' => 200,
                            'message' => 'Ok',
                            'data' => 'Reset password link is sent to ' . $to,
                        );
                        $this->send_mail_reset_password($to, $subject, $user_id);
                    } else {
                        $arrayData = array(
                            'status' => 400,
                            'message' => 'Bad Request',
                            'data' => 'Your Email is not verified. Please verified your email from your email account.',
                        );
                    }
                } else {
                    $arrayData = array(
                        'status' => 400,
                        'message' => 'Bad Request',
                        'data' => 'Your Email does not exist. Please Register first.',
                    );
                }
            }
            echo json_encode($arrayData);
            exit;
        }
    }

    public function send_mail_reset_password($to, $subject, $user_id)
    {
        $to = $to;
        $message = "
           <!DOCTYPE html PUBLIC '-//W3C//DTD XHTML 1.0 Transitional//EN' 'http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd'>
           <html xmlns='http://www.w3.org/1999/xhtml'>
           <head>
           <meta http-equiv='Content-Type' content='text/html; charset=UTF-8' />
           <link href='http://fonts.googleapis.com/css?family=Open+Sans:400,300,600,700&subset=all' rel='stylesheet' type='text/css' />
           <title>You have new contact inquiry</title>
           <style type='text/css'>
                table {
                    font-family: 'Open Sans',sans-serif;
                }
           </style>
           </head>
           <body>
           <table border='1' cellpadding='0' cellspacing='0' height='100%' width='100%'' id='bodyTable' style='border-collapse: collapse;border-radius: 25px;'>
           <tr>
           <td colspan='2' style='text-align: center;'><h3>Organic Store</h3></td>
           </tr>
           <table border='0' cellpadding='10' cellspacing='0' width='100%' id='emailContainer'>
           <tr style='background-color: #ead2b6'>
            <td colspan='2' valign='top' style='padding: 8px;text-align: left;'><strong>Please reset your password from '" . site_url() . "reset-password/" . md5($to) . "-" . urlencode(base64_encode($user_id)) . "'.</td>
           </tr>
           </table>
           <tr>
           <td colspan='2' style='padding: 8px;text-align: right;'>This mail is sent from <a href='" . site_url() . "'> <strong>Organic Store</strong> </a></td>
           </tr>
           </table>
           </body>
           </html>
       ";

        $pass = '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';
        $url = 'https://api.sendgrid.com/';
        $params = array(
            'to' => $to,
            'subject' => $subject,
            'html' => $message,
            'from' => 'OrganicStore',
        );
        $request = $url . 'api/mail.send.json';
        $headr = array();
        $headr[] = 'Authorization: Bearer ' . $pass;
        $session = curl_init($request);
        curl_setopt($session, CURLOPT_POST, true);
        curl_setopt($session, CURLOPT_POSTFIELDS, $params);
        curl_setopt($session, CURLOPT_HEADER, false);
        curl_setopt($session, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($session, CURLOPT_HTTPHEADER, $headr);
        $response = curl_exec($session);
        curl_close($session);
    }

    public function reset_password($reset_id)
    {
        $ex_reset_id = explode('-', $reset_id);
        $email = $ex_reset_id[0];
        $id = base64_decode(urldecode($ex_reset_id[1]));
        if ($email != '' && $id != '') {
            $is_exist = $this->db->where(array('md5(email)' => $email, 'id' => $id, 'status' => '1'))->get('tbl_customer_details')->row();
            $data['id'] = $is_exist->id;
        } else {
            $data['message'] = 'Something went wrong! Please try again later.';
        }
        $this->load->view('reset-password', $data);
    }

    public function update_reset_password()
    {
        if ($this->input->post()) {
            $this->form_validation->set_rules('reset_password', 'Reset Password', 'trim|required|min_length[8]', array('required' => 'Please Enter Password', 'min_length' => 'The Password must be at least 8 characters in length'));

            $this->form_validation->set_rules('reset_password2', 'Password Confirmation', 'trim|matches[reset_password]', array('matches' => 'Password don\'t match'));

            if ($this->form_validation->run() == false) {
                if (form_error('reset_password2')) {
                    $arrayData = array(
                        'status' => 401,
                        'message' => 'reset_password2',
                        'error' => true,
                        'reset_password2_error' => strip_tags(form_error('reset_password2')),
                    );
                }
                if (form_error('reset_password')) {
                    $arrayData = array(
                        'status' => 401,
                        'message' => 'reset_password',
                        'error' => true,
                        'reset_password_error' => strip_tags(form_error('reset_password')),
                    );
                }
            } else {
                $id = $this->input->post('id') ? $this->input->post('id') : '';
                $new_password = $this->input->post('reset_password') ? $this->input->post('reset_password') : '';
                $up_array = array(
                    'password' => md5($new_password),
                    'status' => '1',
                    'updated_at' => date("Y-m-d H:i:s"),
                );
                $update_query = $this->db->where('id', $id)->update('tbl_customer_details', $up_array);
                if (!empty($update_query)) {
                    $arrayData = array(
                        'status' => 200,
                        'message' => 'Ok',
                        'data' => 'Your password has been updated successfully!',
                    );
                } else {
                    $arrayData = array(
                        'status' => 400,
                        'message' => 'Bad Request',
                        'data' => 'Something went wrong! Please try again later.',
                    );
                }
            }
        }
        echo json_encode($arrayData);
        exit;
    }

    public function logout()
    {
        $this->session->unset_userdata('userSession');
        redirect('', 'refresh');
    }

    public function search_listing()
    {
        if ($this->input->post()) {
            $search = $_REQUEST['search'];
            if ($search != '') {

                $search_array = [];
                $search_array_cat = [];
                $search_array_sub_cat = [];

                $search_result = $this->db->select('tbl_product_subcategory.sub_category_name,tbl_product.id,tbl_product_category.category_name,tbl_product.product_name')
                    ->where(array('tbl_product.status' => '1'))
                    ->group_start()
                    ->like('tbl_product.product_name', $search, 'both')
                    ->join('tbl_product_category', 'tbl_product_category.id = tbl_product.category_id')
                    ->join('tbl_product_subcategory', 'tbl_product_subcategory.id = tbl_product.sub_category_id')
                    ->group_end()
                    ->limit(5)
                    ->get('tbl_product')
                    ->result_array();

                $search_result1 = $this->db->where(array('status' => '1'))
                    ->group_start()
                    ->like('category_name', $search, 'both')
                    ->group_end()
                    ->limit(5)
                    ->get('tbl_product_category')
                    ->result_array();

                $search_result2 = $this->db->select('tbl_product_subcategory.sub_category_name,tbl_product_subcategory.id,tbl_product_category.category_name')
                    ->where(array('tbl_product_subcategory.status' => '1'))
                    ->group_start()
                    ->like('tbl_product_subcategory.sub_category_name', $search, 'both')
                    ->join('tbl_product_category', 'tbl_product_category.id = tbl_product_subcategory.category_id')
                    ->group_end()
                    ->limit(5)
                    ->get('tbl_product_subcategory')
                    ->result_array();

                if (!empty($search_result) || !empty($search_result1) || !empty($search_result2)) {
                    if (!empty($search_result)) {
                        foreach ($search_result as $key => $value) {
                            $search_array = $value['product_name'];
                            $url = site_url(url_title(strtolower($value['category_name'])) . '/' . url_title(strtolower($value['sub_category_name'])) . '/' . $value['id'] . '-' . url_title(strtolower($value['product_name'])));

                            $output .= '<div id="suggestion_product" class="suggestion_product">
                                        <a href=' . $url . '>' . $search_array . '</a>
                                    </div>';
                        }
                    }

                    if (!empty($search_result1)) {
                        foreach ($search_result1 as $key => $value) {
                            $search_array_cat = $value['category_name'];
                            $url = site_url($value['id'] . '-' . url_title(strtolower($value['category_name'])));
                            $output .= '<div id="suggestion_product" class="suggestion_product">
                                        <a href=' . $url . '>' . $search_array_cat . '</a>
                                    </div>';
                        }
                    }

                    if (!empty($search_result2)) {
                        foreach ($search_result2 as $key => $value) {
                            $search_array_sub_cat = $value['sub_category_name'];
                            $url = site_url(url_title(strtolower($value['category_name'])) . '/' . $value['id'] . '-' . url_title(strtolower($value['sub_category_name'])));
                            $output .= '<div id="suggestion_product" class="suggestion_product">
                                        <a href=' . $url . '>' . $search_array_sub_cat . '</a>
                                    </div>';
                        }
                    }
                } else {
                    $output = 'No result found';
                }
                $arrayData = array(
                    'status' => 200,
                    'message' => 'Ok',
                    'data' => $output,
                );
            }
            echo json_encode($arrayData);
            exit;
        }
    }

    public function search_listing_by_keyword()
    {
        $keyword = $_REQUEST['keyword'];

        if ($keyword != '') {

            $product_data = $this->db->where(array('tbl_product.status' => '1'))
                ->group_start()
                ->like('tbl_product.product_name', $keyword, 'both')
                ->or_like('tbl_product_category.category_name', $keyword, 'both')
                ->or_like('tbl_product_subcategory.sub_category_name', $keyword, 'both')
                ->limit('3')
                ->join('tbl_product_category', 'tbl_product_category.id = tbl_product.category_id', 'left')
                ->join('tbl_product_subcategory', 'tbl_product_subcategory.id = tbl_product.sub_category_id', 'left')
                ->group_end()
                ->order_by('tbl_product.id', 'desc')
                ->get('tbl_product')
                ->result_array();
            if (!empty($product_data)) {
                $data['product_data'] = $product_data;
            } else {
                $data['no_result_found'] = '<div id="no-products-found" class="no-products-found container" style="height: 300px;text-align: center;padding: 50px;">
                <img class="sorry-icon" src="' . FRONT_ASSETS_URL . '/images/sorry.png">
                <h3 style="font: 18px;margin: 4px auto 20px;color:#222;">Sorry!</h3>
                <div class="uiv2-no-results-new">
                    <h5 style="font: 18px;color:#444;margin: 10px auto 15px;">We could not find any results for <b>"' . $keyword . '"</b>. Please try again.</h5>
                    </div>
                </div>';
            }
        } else {
            $data['product_data'] = $this->db->where(array('status' => '1'))
                ->limit('9')
                ->order_by('id', 'desc')
                ->get('tbl_product')
                ->result_array();
        }
        $data['keyword'] = $keyword;
        $this->load->view('product', $data);
    }

    public function page_not_found()
    {
        $this->load->view('404');
    }

    public function wishlist()
    {
        if (!empty($this->session->userdata('userSession'))) {
            $wishlist = $this->front_model->get_wishlist($this->userSession->id);
            $output = '';
            if (!empty($wishlist)) {
                foreach ($wishlist as $row) {
                    $query = $this->db->where(array('id' => $row['product_id'], 'status' => '1'))->get('tbl_product')->result_array();
                    foreach ($query as $key => $value) {
                        $original_price = $value['price'];
                        $discount_percentage = $value['discount_percentage'];
                        $discount_amount = $discount_percentage / 100;
                        $final_price = $original_price - ($discount_amount * $original_price);
                        $category_name = $this->db->where(array('status' => '1', 'id' => $value['category_id']))->order_by('id', 'desc')->get('tbl_product_category')->row();
                        $sub_category_name = $this->db->where(array('status' => '1', 'id' => $value['sub_category_id']))->order_by('id', 'desc')->get('tbl_product_subcategory')->row();
                        $output .= '<tr class="_grid shopping-cart--list-item">
                    <td class="product-thumbnail">
                        <a href="#">
                            <img width="100" src="' . PRODUCT_IMG_URL . $value['image'] . '" class="" alt="">
                        </a>
                    </td>
                    <td class="product-name">
                    <p>
                        <a href="' . site_url(url_title(strtolower($category_name->category_name)) . '/' . url_title(strtolower($sub_category_name->sub_category_name)) . '/' . $value['id'] . '-' . url_title(strtolower($value['product_name']))) . '">' . $value['product_name'] . '</a>
                    </p>
                    <span>Quantity: ' . $value['per_pack'] . '</span>
                    </td>
                    <td class="text-center unit-price">
                        <p>&#x20B9; ' . round($final_price, 2) . '</p>
                    </td>
                    <td class="text-center product-add-date">
                        <p>' . date("M d, Y l", strtotime($value['created_at'])) . '</p>
                    </td>
                    <td class="text-center">';
                        if ($value['availability'] == 1) {
                            $output .= '<a href="#" class="add-to-3"><span class="hidden-xs">&nbsp;In Stock';
                        } else {
                            $output .= '<a href="#" class="add-to-4"><span class="hidden-xs">&nbsp;Out of Stock';
                        }
                        $output .= '</span></a></td>
                        <td class="text-center">
                            <a href="#" onClick="addToCart(' . $row['product_id'] . ',' . round($final_price, 2) . ',' . $value['availability'] . ',1)" class="add-to-cart">
                            <i class="fa fa-shopping-cart"></i>
                            <span class="hidden-xs">&nbsp; Add To Cart</span>
                            </a>
                        </td>
                        <td class="text-right subtotal2">
                            <button onClick="addToWishlist(' . $value['id'] . ');" class="_btn product-remove p-0">
                                <i class="fa fa-trash" aria-hidden="true" ></i>
                            </button>
                        </td>
                    </tr>';
                    }
                }
                $data['output'] = $output;
            } else {
                $data['empty_wishlist'] = '<div class="container">
                        <div class="row">
                            <div class="displayFlex">
                                <h1>Empty Wishlist</h1>
                                <div>You have no items in your wishlist. Start adding!</div>
                            </div>
                        </div>
                    </div>';
            }
            $this->load->view('wishlist', $data);
        } else {
            $data['empty_wishlist'] = '<div class="login-up my-class container">
                    <div class="row">
                        <div class="displayFlex"> Your Wishlist is empty </div>
                    </div>
                </div>';
            $this->load->view('wishlist', $data);
        }
    }

    public function add_wishlist()
    {
        if ($this->input->post()) {
            $product_id = $this->input->post('product_id');
            if (!empty($product_id)) {
                if (!empty($this->session->userdata('userSession'))) {
                    $user_id = $this->session->userdata('userSession')->id;
                    $is_exist = $this->db->where(array('status' => '1', 'user_id' => $user_id, 'product_id' => $product_id))->get('tbl_wishlist')->row();
                    if (empty($is_exist)) {
                        $is_exist_status = $this->db->where(array('status' => '9', 'user_id' => $user_id, 'product_id' => $product_id))->get('tbl_wishlist')->row();
                        if (!empty($is_exist_status)) {
                            $up_array = array('status' => '1',
                                'updated_at' => date("Y-m-d H:i:s"));
                            $update = $this->db->where(array('id' => $is_exist_status->id, 'user_id' => $user_id, 'product_id' => $product_id))->update('tbl_wishlist', $up_array);
                            if ($update) {
                                $arrayData = array(
                                    'status' => 200,
                                    'message' => 'Ok',
                                    'data' => 'Added to your Wishlist',
                                    'data1' => 1,
                                    'data2' => count($this->front_model->get_wishlist($this->userSession->id)),
                                );
                            } else {
                                $arrayData = array(
                                    'status' => 400,
                                    'message' => 'Bad Request',
                                    'data' => "Something went wrong! Please try again later",
                                );
                            }
                        } else {
                            $in_array = array('status' => '1',
                                'user_id' => $user_id,
                                'product_id' => $product_id,
                                'created_at' => date("Y-m-d H:i:s"));
                            $query = $this->db->insert('tbl_wishlist', $in_array);
                            if (!empty($query)) {
                                $arrayData = array(
                                    'status' => 200,
                                    'message' => 'Ok',
                                    'data' => 'Added to your Wishlist',
                                    'data1' => 1,
                                    'data2' => count($this->front_model->get_wishlist($this->userSession->id)),
                                );
                            } else {
                                $arrayData = array(
                                    'status' => 400,
                                    'message' => 'Bad Request',
                                    'data' => "Something went wrong! Please try again later",
                                );
                            }
                        }
                    } else {
                        $up_array = array('status' => '9',
                            'updated_at' => date("Y-m-d H:i:s"));
                        $update = $this->db->where(array('id' => $is_exist->id, 'user_id' => $user_id, 'product_id' => $product_id))->update('tbl_wishlist', $up_array);
                        if ($update) {
                            $arrayData = array(
                                'status' => 200,
                                'message' => 'Ok',
                                'data' => 'Removed from your Wishlist',
                                'data1' => 0,
                                'data2' => count($this->front_model->get_wishlist($this->userSession->id)),
                            );
                        } else {
                            $arrayData = array(
                                'status' => 400,
                                'message' => 'Bad Request',
                                'data' => "Something went wrong! Please try again later",
                            );
                        }
                    }
                } else {
                    $arrayData = array(
                        'status' => 200,
                        'message' => "Ok",
                        'data' => 'Please login for wishlisting a product',
                        'data1' => 2,
                    );
                }
            } else {
                $arrayData = array(
                    'status' => 400,
                    'message' => 'Bad Request',
                    'data' => 'Something went wrong! Please try again',
                );
            }
        }
        echo json_encode($arrayData);
        exit;
    }

    public function cart()
    {
        if (!empty($this->session->userdata('userSession'))) {
            $cart = $this->front_model->get_cart_data($this->userSession->id);

            $this->session->set_userdata('checkoutSession', $cart);

            $output = '';

            if (!empty($cart)) {
                /* $sub_total = 0;
                $shipping_charge = 0; */
                foreach ($cart as $row) {
                    $query = $this->db->where(array('id' => $row['product_id'], 'status' => '1'))->get('tbl_product')->result_array();
                    foreach ($query as $key => $value) {
                        $original_price = $value['price'];
                        $discount_percentage = $value['discount_percentage'];
                        $discount_amount = $discount_percentage / 100;
                        $final_price = $original_price - ($discount_amount * $original_price);
                        $total_price = $row['quantity'] * $row['product_price'];
                        /* $ship_charge = $row['quantity'] * $value['shipping_charge']; */
                        $output .= '
                    <tr class="_grid shopping-cart--list-item">
                    <td align="center">
                    <div class="img-div-2">
                        <a href="">
                            <img class="product-image--img img-fluid" src="' . PRODUCT_IMG_URL . $value['image'] . '" alt="Item image" />
                        </a>
                    </div>
                    </td>
                    <td class="product-thumbnail">
                    <div class="cart-detail _column product-info">
                    <h4 class="product-name">' . $value['product_name'] . '</h4></div>
                    </td>

                    <td class="text-center product-add-date">
                    <div class="price product-single-price">&#x20B9;' . round($final_price, 2) . '</div>
                    </td>
                        <td class="text-center">
                        <div class="quantity buttons_added">
                        <input type="button" id="minus' . $row['id'] . '" value="-" onClick="decrementQuantity(' . $row['id'] . ',' . $row['product_id'] . ');" class="minus">
                        <input type="number" step="1" min="1" max="" name="quantity" value="' . $row['quantity'] . '" title="Qty" class="input-text qty text" size="4" pattern="" id="qty' . $row['id'] . '" disabled>
                        <input type="button" onClick="incrementQuantity(' . $row['id'] . ',' . $row['product_id'] . ');" value="+" class="plus">
                        </div>
                        </div>
                        </td>
                        <td class="text-center">
                            <div style="width: 60px" class="price product-total-price-">&#x20B9;
                                <span class="update-total' . $row['id'] . '">' . $total_price . '</span>
                            </div>
                        </td>
                        <td class="text-right subtotal2">
                            <button onClick="removeCart(' . $row['id'] . ')" class="_btn product-remove p-0">
                                <i class="fa fa-trash" aria-hidden="true" ></i>
                            </button>
                        </td>
                    </tr>
                    ';
                    }
                }
                $data['output'] = $output;
            } else {
                $data['empty_cart'] = '<div class="container">
                        <div class="row my-cl rem-cls">
                            <div class="displayFlex">
                                <h1>Empty Cart</h1>
                                <div>You have no items in your cart. Start adding!</div>
                            </div>
                        </div>
                    </div>';
            }
            $this->load->view('cart', $data);
        } else {
            $data['empty_cart'] = '<div class="login-up my-class container">
                    <div class="row  my-cl rem-cls">
                        <div class="displayFlex"> Your Cart is empty </div>
                    </div>
                </div>';
            $this->load->view('cart', $data);
        }
    }

    public function add_cart()
    {
        if ($this->input->post()) {
            $product_id = $this->input->post('product_id');
            $quantity = $this->input->post('quantity');
            $availability = $this->input->post('availability');
            $product_price = $this->input->post('product_price');
            if (!empty($product_id)) {
                if (!empty($this->session->userdata('userSession'))) {
                    if (!empty($availability) && $availability != 0) {
                        $user_id = $this->session->userdata('userSession')->id;
                        $is_exist = $this->db->where(array('status' => '1', 'user_id' => $user_id, 'product_id' => $product_id))->get('tbl_cart')->row();
                        if (empty($is_exist)) {
                            $is_exist_status = $this->db->where(array('status' => '9', 'user_id' => $user_id, 'product_id' => $product_id))->get('tbl_cart')->row();
                            $in_array = array('status' => '1',
                                'user_id' => $user_id,
                                'product_id' => $product_id,
                                'quantity' => $quantity,
                                'product_price' => $product_price,
                                'created_at' => date("Y-m-d H:i:s"));
                            $query = $this->db->insert('tbl_cart', $in_array);
                            if (!empty($query)) {
                                $arrayData = array(
                                    'status' => 200,
                                    'message' => 'Ok',
                                    'data' => 'Added to your Cart',
                                    'data1' => 1,
                                    'data2' => ($this->front_model->get_cart($this->userSession->id)),
                                );
                            } else {
                                $arrayData = array(
                                    'status' => 400,
                                    'message' => 'Bad Request',
                                    'data' => "Something went wrong! Please try again later",
                                );
                            }
                        } else {
                            $up_array = array('quantity' => $is_exist->quantity + $quantity,
                                'updated_at' => date("Y-m-d H:i:s"));
                            $update = $this->db->where(array('id' => $is_exist->id, 'user_id' => $user_id, 'product_id' => $product_id))->update('tbl_cart', $up_array);
                            if ($update) {
                                $arrayData = array(
                                    'status' => 200,
                                    'message' => 'Ok',
                                    'data' => 'Added to your Cart',
                                    'data1' => 0,
                                    'data2' => ($this->front_model->get_cart($this->userSession->id)),
                                );
                            } else {
                                $arrayData = array(
                                    'status' => 400,
                                    'message' => 'Bad Request',
                                    'data' => "Something went wrong! Please try again later",
                                );
                            }
                        }
                    } else {
                        $arrayData = array(
                            'status' => 200,
                            'message' => "Ok",
                            'data' => 'Currently out of stock',
                            'data1' => 3,
                        );
                    }
                } else {
                    $arrayData = array(
                        'status' => 200,
                        'message' => "Ok",
                        'data' => 'Login to see the items you added previously',
                        'data1' => 2,
                    );
                }
            } else {
                $arrayData = array(
                    'status' => 400,
                    'message' => 'Bad Request',
                    'data' => 'Something went wrong! Please try again',
                );
            }
        }
        echo json_encode($arrayData);
        exit;
    }

    public function remove_cart()
    {
        $id = $this->input->post('id');
        $new_ship_charge = $this->input->post('ship_charge');
        $sub_total = $this->input->post('sub_total');
        $final_total = $this->input->post('final_total');
        $price = $this->input->post('price');
        $new_sub_total = $sub_total - $price;
        $new_final_total = $new_sub_total + $new_ship_charge;
        if (!empty($id)) {
            if (!empty($this->session->userdata('userSession'))) {
                $cart = $this->db->where(array('id' => $id, 'status' => '1'))->get('tbl_cart')->row();
                $user_id = $this->session->userdata('userSession')->id;
                $up_array = array('status' => '9',
                    'user_id' => $user_id,
                    'updated_at' => date("Y-m-d H:i:s"));
                $query = $this->db->where('id', $id)->update('tbl_cart', $up_array);
                if ($query) {
                    $cart = $this->front_model->get_cart_data($this->userSession->id);
                    $arr = [];
                    foreach ($cart as $row) {
                        $query = $this->db->where(array('id' => $row['product_id'], 'status' => '1'))->get('tbl_product')->result_array();
                        foreach ($query as $key => $value) {
                            $arr[] = $value['shipping_charge'];
                        }
                    }
                    if (!empty($arr)) {
                        $final_ship_charge = max($arr);
                    }
                    $arrayData = array(
                        'status' => 200,
                        'message' => "Ok",
                        'data' => 1,
                        'data1' => ($this->front_model->get_cart($this->userSession->id)),
                        'data3' => round($new_sub_total),
                        'data4' => round($new_final_total),
                        'data5' => $final_ship_charge,
                    );
                } else {
                    $arrayData = array(
                        'status' => 400,
                        'message' => 'Bad Request',
                        'data' => 'Something went wrong! Please try again',
                    );
                }
            } else {
                $arrayData = array(
                    'status' => 200,
                    'message' => "Ok",
                    'data' => 'Login to see the items you added previously',
                    'data1' => 2,
                );
            }
        } else {
            $arrayData = array(
                'status' => 400,
                'message' => 'Bad Request',
                'data' => 'Something went wrong! Please try again',
            );
        }
        echo json_encode($arrayData);
        exit;
    }

    public function increment_quantity()
    {
        if ($this->input->post()) {
            $product_id = $this->input->post('product_id');
            if (!empty($product_id)) {
                if (!empty($this->session->userdata('userSession'))) {
                    $user_id = $this->session->userdata('userSession')->id;
                    $price = $this->input->post('price');
                    $sub_total = $this->input->post('sub_total');
                    $final_total = $this->input->post('final_total');
                    $id = $this->input->post('id');

                    $query = $this->db->where(array('id' => $id, 'status' => '1'))->get('tbl_cart')->row();
                    $final_price = $price + $query->product_price;
                    $final_quantity = 1 + $query->quantity;
                    $new_sub_total = $query->product_price + $sub_total;
                    $new_final_total = $query->product_price + $final_total;
                    $up_array = array('quantity' => $final_quantity,
                        'updated_at' => date("Y-m-d H:i:s"));
                    $update = $this->db->where(array('id' => $query->id, 'user_id' => $user_id, 'product_id' => $product_id))->update('tbl_cart', $up_array);
                    if ($update) {
                        $arrayData = array(
                            'status' => 200,
                            'message' => 'Ok',
                            'data' => round($final_price, 2),
                            'data1' => $final_quantity,
                            'data2' => ($this->front_model->get_cart($this->userSession->id)),
                            'data3' => round($new_sub_total),
                            'data4' => round($new_final_total),
                        );
                    } else {
                        $arrayData = array(
                            'status' => 400,
                            'message' => 'Bad Request',
                            'data' => 'Something went wrong! Please try again',
                        );
                    }
                } else {
                    $arrayData = array(
                        'status' => 200,
                        'message' => "Ok",
                        'data' => 'Login to see the items you added previously',
                        'data1' => 2,
                    );
                }
            } else {
                $arrayData = array(
                    'status' => 400,
                    'message' => 'Bad Request',
                    'data' => 'Something went wrong! Please try again',
                );
            }
        }
        echo json_encode($arrayData);
        exit;
    }

    public function decrement_quantity()
    {
        if ($this->input->post()) {
            $product_id = $this->input->post('product_id');
            if (!empty($product_id)) {
                if (!empty($this->session->userdata('userSession'))) {
                    $user_id = $this->session->userdata('userSession')->id;
                    $price = $this->input->post('price');
                    $id = $this->input->post('id');
                    $sub_total = $this->input->post('sub_total');
                    $final_total = $this->input->post('final_total');
                    $query = $this->db->where(array('id' => $id, 'status' => '1'))->get('tbl_cart')->row();
                    $final_price = $price - $query->product_price;
                    $final_quantity = $query->quantity - 1;
                    $new_sub_total = $sub_total - $query->product_price;
                    $new_ship_charge = $this->input->post('ship_charge');
                    $new_final_total = $new_sub_total + $new_ship_charge;
                    if ($final_quantity != 0) {
                        $up_array = array('quantity' => $final_quantity, 'updated_at' => date("Y-m-d H:i:s"));
                        $update = $this->db->where(array('id' => $query->id, 'user_id' => $user_id, 'product_id' => $product_id))->update('tbl_cart', $up_array);
                        if ($update) {
                            $arrayData = array(
                                'status' => 200,
                                'message' => 'Ok',
                                'data' => round($final_price, 2),
                                'data1' => $final_quantity,
                                'data2' => $this->front_model->get_cart($this->userSession->id),
                                'data3' => round($new_sub_total),
                                'data4' => round($new_final_total),
                                'data5' => $new_ship_charge,
                            );
                        } else {
                            $arrayData = array(
                                'status' => 400,
                                'message' => 'Bad Request',
                                'data' => 'Something went wrong! Please try again',
                            );
                        }
                    } else {
                        $arrayData = array(
                            'status' => 200,
                            'message' => 'Ok',
                            'data' => 0,
                        );
                    }
                } else {
                    $arrayData = array(
                        'status' => 200,
                        'message' => "Ok",
                        'data' => 'Login to see the items you added previously',
                        'data1' => 2,
                    );
                }
            } else {
                $arrayData = array(
                    'status' => 400,
                    'message' => 'Bad Request',
                    'data' => 'Something went wrong! Please try again',
                );
            }
        }
        echo json_encode($arrayData);
        exit;
    }

    public function checkout()
    {
        if (!empty($this->session->userdata('userSession')) && !empty($this->session->userdata('checkoutSession'))) {
            $this->load->view('checkout');
        } else {
            redirect('', 'refresh');
        }
    }

    public function about_us()
    {
        $data['about_us'] = $this->front_model->get_about_us();
        $data['counter'] = $this->front_model->get_counter();
        $data['why_choose_us'] = $this->front_model->get_why_choose_us();
        $this->load->view('about-us', $data);
    }

    public function contact()
    {
        if ($this->input->post()) {

            $name = $this->input->post('cname');
            $email = $this->input->post('cemail');
            $message = $this->input->post('cmessage');
            $in_array = array(
                'name' => ($name) ? ($name) : '',
                'email' => ($email) ? ($email) : '',
                'message' => ($message) ? ($message) : '',
                'status' => '1',
                'created_at' => date("Y-m-d H:i:s"),
            );

            $insert = $this->db->insert('tbl_contact', $in_array);
            $to = 'dcp271298@gmail.com';
            $subject1 = 'Contact inquiry';

            if ($insert) {
                $mail = $this->send_mail_contact($to, $subject1, $name, $email, $message);
                if ($mail) {
                    $arrayData = array(
                        'status' => 200,
                        'message' => 'OK',
                        'data' => "Thanks for your comment. We appreciate your response.");
                    echo json_encode($arrayData);
                    exit;
                } else {
                    $arrayData = array(
                        'status' => 400,
                        'message' => 'OK',
                        'data' => "Something went wrong, Please try again");
                    echo json_encode($arrayData);
                    exit;
                }
            }
        }
        $data['web_info'] = $this->front_model->get_web_setting();
        $this->load->view('contact', $data);
    }

    public function send_mail_contact($to, $subject1, $name, $email, $message)
    {
        $web_info = $this->front_model->get_web_setting();
        $to = $to;
        $message = "
           <!DOCTYPE html PUBLIC '-//W3C//DTD XHTML 1.0 Transitional//EN' 'http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd'>
           <html xmlns='http://www.w3.org/1999/xhtml'>
           <head>
           <meta http-equiv='Content-Type' content='text/html; charset=UTF-8' />
           <link href='http://fonts.googleapis.com/css?family=Open+Sans:400,300,600,700&subset=all' rel='stylesheet' type='text/css' />
           <title>You have new contact inquiry</title>
           <style type='text/css'>
                table {
                    font-family: 'Open Sans',sans-serif;
                }
           </style>
           </head>
           <body>
           <table border='1' cellpadding='0' cellspacing='0' height='100%' width='100%'' id='bodyTable' style='border-collapse: collapse;border-radius: 25px;'>
           <tr>
           <td colspan='2' style='text-align: center;'><h3>" . $web_info->site_name . "</h3></td>
           </tr>
           <table border='0' cellpadding='10' cellspacing='0' width='100%' id='emailContainer'>
           <tr style='background-color: #ead2b6'>
            <td colspan='2' valign='top' style='padding: 8px;text-align: left;'><strong>Name</strong></td>
            <td colspan='2' valign='top' style='padding: 8px;text-align: left;'>" . $name . "</td>
           </tr>
           <tr style='background-color: #ead2b6'>
            <td colspan='2' valign='top' style='padding: 8px;text-align: left;'><strong>Email</strong></td>
            <td colspan='2' valign='top' style='padding: 8px;text-align: left;'>" . $email . "</td>
           </tr>
           <tr style='background-color: #ead2b6'>
            <td colspan='2' valign='top' style='padding: 8px;text-align: left;'><strong>Message</strong></td>
            <td colspan='2' valign='top' style='padding: 8px;text-align: left;'>" . $message . "</td>
           </tr>
           </table>
           <tr>
           <td colspan='2' style='padding: 8px;text-align: right;'>This mail is sent from <a href='" . site_url() . "'> <strong>" . $web_info->site_name . "</strong> </a></td>
           </tr>
           </table>
           </body>
           </html>
       ";

        $pass = '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';
        $url = 'https://api.sendgrid.com/';
        $params = array(
            'to' => $to,
            'subject' => $subject1,
            'html' => $message,
            'from' => 'OrganicStore',
        );
        $request = $url . 'api/mail.send.json';
        $headr = array();
        $headr[] = 'Authorization: Bearer ' . $pass;
        $session = curl_init($request);
        curl_setopt($session, CURLOPT_POST, true);
        curl_setopt($session, CURLOPT_POSTFIELDS, $params);
        curl_setopt($session, CURLOPT_HEADER, false);
        curl_setopt($session, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($session, CURLOPT_HTTPHEADER, $headr);
        $response = curl_exec($session);
        curl_close($session);
        return $response;
    }

    public function newsletter()
    {
        if ($this->input->post()) {

            $email = $this->input->post('newsemail');
            $in_array = array(
                'email_id' => ($email) ? ($email) : '',
                'ip_address' => $_SERVER['REMOTE_ADDR'],
                'status' => '1',
                'created_at' => date("Y-m-d H:i:s"),
            );

            $insert = $this->db->insert('tbl_newsletter', $in_array);

            if ($insert) {
                $arrayData = array(
                    'status' => 200,
                    'message' => 'OK',
                    'data' => "Thank you for your subscription.");
                echo json_encode($arrayData);
                exit;
            } else {
                $arrayData = array(
                    'status' => 400,
                    'message' => 'OK',
                    'data' => "Something went wrong, Please try again");
                echo json_encode($arrayData);
                exit;
            }
        }
    }

    public function tc()
    {
        $data['tc'] = $this->front_model->get_tc();
        $this->load->view('terms-conditions', $data);
    }

    public function myaccount()
    {
        if (!empty($this->session->userdata('userSession'))) {
            $this->load->view('myaccount');
        } else {
            redirect('', 'refresh');
        }
    }

    public function change_profile()
    {
        if (!empty($this->session->userdata('userSession'))) {
            if ($this->input->post()) {
                $user_id = $this->session->userdata('userSession')->id;
                $social_title = $this->input->post('social_title');
                $first_name = $this->input->post('first_name');
                $last_name = $this->input->post('last_name');
                $email = $this->input->post('email');
                $dob = $this->input->post('dob');
                $up_array = array(
                    'social_title' => ($social_title) ? ($social_title) : '',
                    'first_name' => ($first_name) ? ($first_name) : '',
                    'last_name' => ($last_name) ? ($last_name) : '',
                    'email' => ($email) ? ($email) : '',
                    'dob' => ($dob) ? ($dob) : '',
                    'ip_address' => $_SERVER['REMOTE_ADDR'],
                    'status' => '1',
                    'updated_at' => date("Y-m-d H:i:s"),
                );

                $update = $this->db->where('id', $user_id)->update('tbl_customer_details', $up_array);

                if ($update) {
                    $arrayData = array(
                        'status' => 200,
                        'message' => 'OK',
                        'data' => "Profile updated successfully.");
                    echo json_encode($arrayData);
                    exit;
                } else {
                    $arrayData = array(
                        'status' => 400,
                        'message' => 'OK',
                        'data' => "Something went wrong, Please try again");
                    echo json_encode($arrayData);
                    exit;
                }
            } else {
                $arrayData = array(
                    'status' => 400,
                    'message' => 'OK',
                    'data' => "Something went wrong, Please try again");
                echo json_encode($arrayData);
                exit;
            }
        } else {
            redirect('', 'refresh');
        }
    }

    public function change_password()
    {
        if ($this->input->post()) {
            $this->form_validation->set_rules('old_password', 'Old Password', 'trim|required|min_length[8]', array('required' => 'Please Enter Old Password', 'min_length' => 'The Password must be at least 8 characters in length'));

            $this->form_validation->set_rules('new_password', 'New Password', 'trim|required|min_length[8]', array('required' => 'Please Enter New Password', 'min_length' => 'The Password must be at least 8 characters in length'));

            $this->form_validation->set_rules('confirm_new_password', 'New Password Confirmation', 'trim|matches[new_password]', array('matches' => 'Password don\'t match'));

            if ($this->form_validation->run() == false) {
                if (form_error('confirm_new_password')) {
                    $arrayData = array(
                        'status' => 401,
                        'message' => 'confirm_new_password',
                        'error' => true,
                        'confirm_new_password_error' => strip_tags(form_error('confirm_new_password')),
                    );
                }
                if (form_error('new_password')) {
                    $arrayData = array(
                        'status' => 401,
                        'message' => 'new_password',
                        'error' => true,
                        'new_password_error' => strip_tags(form_error('new_password')),
                    );
                }
                if (form_error('old_password')) {
                    $arrayData = array(
                        'status' => 401,
                        'message' => 'old_password',
                        'error' => true,
                        'old_password_error' => strip_tags(form_error('old_password')),
                    );
                }
            } else {
                $user_id = $this->session->userdata('userSession')->id;
                $old_password = $this->input->post('old_password') ? $this->input->post('old_password') : '';
                $old_password1 = md5($old_password);
                $new_password = $this->input->post('new_password') ? $this->input->post('new_password') : '';
                $new_password1 = md5($new_password);
                $customer = $this->db->where(array('status' => '1', 'id' => $user_id))->get('tbl_customer_details')->row();

                if (!empty($customer)) {

                    if ($customer->password == $old_password1) {
                        $up_array = array(
                            'password' => $new_password1,
                            'status' => '1',
                            'updated_at' => date("Y-m-d H:i:s"),
                        );
                        $update_query = $this->db->where('id', $user_id)->update('tbl_customer_details', $up_array);

                        if (!empty($update_query)) {
                            $arrayData = array(
                                'status' => 200,
                                'message' => 'Ok',
                                'data' => 'Your password has been updated successfully!',
                            );
                            $this->session->unset_userdata('userSession');
                        } else {
                            $arrayData = array(
                                'status' => 400,
                                'message' => 'Bad Request',
                                'data' => 'Something went wrong! Please try again later.',
                            );
                        }
                    } else {
                        $arrayData = array(
                            'status' => 400,
                            'message' => 'Ok',
                            'data' => 'Incorrect old password!!!',
                        );

                    }
                } else {
                    $arrayData = array(
                        'status' => 400,
                        'message' => 'Bad Request',
                        'data' => 'Something went wrong! Please try again later.',
                    );
                }
            }
        }
        echo json_encode($arrayData);
        exit;
    }

    public function order_details_modal()
    {
        if ($this->input->post()) {
            $order_id = $this->input->post('order_id');
            $orders = $this->db->where(array('status' => '1', 'order_id' => $order_id))->order_by('id', 'asc')->get('tbl_order_details')->result_array();
            $output = "<tr>
            <th colspan='2' style='border:1px solid #000;text-align: center;text-transform: uppercase;'><h3>Order Details</h3></th>
            </tr>

            <tr style='background-color: #63cc3380'>
             <th align='center ' valign='middle' width='200px ' style='background-color: #63cc3380'> <strong>Order ID</strong> : </th>
             <td valign='top ' style='padding: 8px;text-align: left; '>" . $order_id . "</td>
            </tr>

            <tr style='background: #f7f7f7'>
             <th colspan='2' style='border:1px solid #000;text-align: center;text-transform: uppercase;'><h3>Product details</h3></th>
            </tr>";
            foreach ($orders as $row) {
                $query = $this->db->where(array('status' => '1', 'id' => $row['product_id']))->get('tbl_product')->result_array();
                foreach ($query as $key => $value) {
                    $original_price = $value['price'];
                    $discount_percentage = $value['discount_percentage'];
                    $discount_amount = $discount_percentage / 100;
                    $final_price = $original_price - ($discount_amount * $original_price);
                    $final_amount = $final_price * $row['quantity'];

                    $output .= "<tr style='background-color: #63cc3380 '>
                        <th align='center ' valign='middle' width='200px ' style='background-color: #63cc3380'> <strong>Product Name</strong> : </th>
                        <td valign='top ' style='padding: 8px;text-align: left; '>" . $value['product_name'] . "</td>
                    </tr>

                    <tr style='background-color: #f2f2f2 '>
                        <th align='center ' valign='middle' width='200px ' style='background-color: #f2f2f2 '> <strong>Quantity</strong> : </th>
                        <td valign='top ' style='padding: 8px;text-align: left; '>" . $row['quantity'] . "</td>
                    </tr>

                    <tr style='background-color: #63cc3380'>
                        <th align='center ' valign='middle' width='200px ' style='background-color: #63cc3380'> <strong>Price</strong> : </th>
                        <td valign='top ' style='padding: 8px;text-align: left; '>&#x20B9;" . round($final_price, 2) . "</td>
                    </tr>

                    <tr style='background: #000000'>
                        <td colspan='2' style='height:1px;text-align: center;text-transform: uppercase;'></td>
                    </tr>";
                }
            }
            $output .= "<tr style='background: #f7f7f7'>
                <th colspan='2' style='border:1px solid #000;text-align: center;text-transform: uppercase;'><h3>Payment Details</h3></th>
                </tr>

                <tr style='background-color: #63cc3380'>
                <th align='center ' valign='middle' width='200px ' style='background-color: #63cc3380'> <strong>Paid Amount</strong> : </th>
                <td valign='top ' style='padding: 8px;text-align: left; '>&#x20B9;" . $row['grand_total'] . "</td>
                </tr>

                <tr style='background-color: #f7f7f7 '>
                <th align='center ' valign='middle' width='200px ' style='background-color: #f7f7f7 '> <strong>Payment Mode</strong> : </th>
                <td valign='top ' style='padding: 8px;text-align: left; '>" . $row['payment_mode'] . "</td>
                </tr>";

            if (!empty($output)) {
                $arrayData = array(
                    'status' => 200,
                    'message' => 'OK',
                    'data' => $output,
                );
                echo json_encode($arrayData);
                exit;
            } else {
                $arrayData = array(
                    'status' => 400,
                    'message' => 'OK',
                    'data' => "Something went wrong!!!",
                );
                echo json_encode($arrayData);
                exit;
            }
        }
    }

    public function add_address()
    {
        if ($this->input->post()) {
            $user_id = $this->session->userdata('userSession')->id;
            $add_first_name = $this->input->post('add_first_name') ? $this->input->post('add_first_name') : '';
            $add_last_name = $this->input->post('add_last_name') ? $this->input->post('add_last_name') : '';
            $add_email = $this->input->post('add_email') ? $this->input->post('add_email') : '';
            $add_number = $this->input->post('add_number') ? $this->input->post('add_number') : '';
            $add_address = $this->input->post('add_address') ? $this->input->post('add_address') : '';
            $bill_country = $this->input->post('bill_country') ? $this->input->post('bill_country') : '';
            $bill_state = $this->input->post('bill_state') ? $this->input->post('bill_state') : '';
            $bill_city = $this->input->post('bill_city') ? $this->input->post('bill_city') : '';
            $add_post_code = $this->input->post('add_post_code') ? $this->input->post('add_post_code') : '';
            $in_array = array(
                'user_id' => $user_id,
                'first_name' => $add_first_name,
                'last_name' => $add_last_name,
                'email' => $add_email,
                'mobile_no' => $add_number,
                'address' => $add_address,
                'country' => $bill_country,
                'state' => $bill_state,
                'city' => $bill_city,
                'post_code' => $add_post_code,
                'status' => '1',
                'created_at' => date("Y-m-d H:i:s"),
            );
            $address = $this->db->insert('tbl_billing_address', $in_array);

            if ($address) {
                $arrayData = array(
                    'status' => 200,
                    'message' => 'Ok',
                    'data' => 'Address inserted successfully.',
                );
            } else {
                $arrayData = array(
                    'status' => 400,
                    'message' => 'Bad Request',
                    'data' => 'Something went wrong! Please try again later.',
                );
            }
        }
        echo json_encode($arrayData);
        exit;
    }

    public function remove_address()
    {
        if ($this->input->post()) {
            $user_id = $this->session->userdata('userSession')->id;
            $address_id = $this->input->post('address_id') ? $this->input->post('address_id') : '';

            $up_array = array(
                'status' => '9',
                'updated_at' => date("Y-m-d H:i:s"),
            );
            $address = $this->db->where(array('status' => '1', 'user_id' => $user_id, 'id' => $address_id))->update('tbl_billing_address', $up_array);

            if ($address) {
                $arrayData = array(
                    'status' => 200,
                    'message' => 'Ok',
                    'data' => 'Address deleted successfully.',
                );
            } else {
                $arrayData = array(
                    'status' => 400,
                    'message' => 'Bad Request',
                    'data' => 'Something went wrong! Please try again later.',
                );
            }
        }
        echo json_encode($arrayData);
        exit;
    }

    public function select_address()
    {
        if ($this->input->post()) {
            $user_id = $this->session->userdata('userSession')->id;
            $address_id = $this->input->post('address_id') ? $this->input->post('address_id') : '';

            $up_array = array(
                'selected' => '1',
                'updated_at' => date("Y-m-d H:i:s"),
            );
            $address = $this->db->where(array('status' => '1', 'user_id' => $user_id, 'id' => $address_id))->update('tbl_billing_address', $up_array);

            if ($address) {
                $up_array = array(
                    'selected' => '0',
                    'updated_at' => date("Y-m-d H:i:s"),
                );
                $select_address = $this->db->where(array('status' => '1', 'user_id' => $user_id, 'id!=' => $address_id))->update('tbl_billing_address', $up_array);
                if ($select_address) {
                    $arrayData = array(
                        'status' => 200,
                        'message' => 'Ok',
                        'data' => 'Address selected.',
                    );
                } else {
                    $arrayData = array(
                        'status' => 400,
                        'message' => 'Bad Request',
                        'data' => 'Something went wrong! Please try again later.',
                    );
                }
            } else {
                $arrayData = array(
                    'status' => 400,
                    'message' => 'Bad Request',
                    'data' => 'Something went wrong! Please try again later.',
                );
            }
        }
        echo json_encode($arrayData);
        exit;
    }

    public function faq()
    {
        $data['faq'] = $this->front_model->get_faq();
        $this->load->view('faq', $data);
    }

    public function product()
    {
        $data['product_data'] = $this->front_model->get_latest_product();
        $this->load->view('product', $data);
    }

    public function product_by_category($cat_id)
    {
        $first_id = explode("-", $cat_id);
        $category_id = $first_id[0];
        $query_for_404 = $this->db->where(array('status' => '1', 'id' => $category_id))->get('tbl_product_category')->row();
        if (!empty($query_for_404)) {
            $data['category_id'] = $category_id;
            /* for breadcrumbs */
            $data['category_name'] = $this->db->where(array('status' => '1', 'id' => $category_id))->get('tbl_product_category')->row();
            /* for product-detail page */
            $data['product_data'] = $this->front_model->get_product_by_category_id($category_id);
            $this->load->view('product', $data);
        } else {
            $this->load->view('404');
        }
    }

    public function product_by_subcategory($cat_name, $sub_cat_id)
    {

        $first_id = explode("-", $sub_cat_id);
        $sub_category_id = $first_id[0];
        $data['sub_category_id'] = $sub_category_id;
        $query_for_404 = $this->db->where(array('status' => '1', 'id' => $sub_category_id))->get('tbl_product_subcategory')->row();
        if (!empty($query_for_404)) {
            /* for breadcrumbs */
            $data['sub_category_name'] = $this->db->where(array('tbl_product_subcategory.status' => '1', 'tbl_product_subcategory.id' => $sub_category_id))->join('tbl_product_category', 'tbl_product_category.id = tbl_product_subcategory.category_id', 'left')->get('tbl_product_subcategory')->row();
            /* for product-detail page */
            $data['product_data'] = $this->front_model->get_product_by_subcategory_id($sub_category_id);
            $this->load->view('product', $data);
        } else {
            $this->load->view('404');
        }
    }

    public function product_detail($cat_name, $sub_cat_name, $old_product_id)
    {
        $first_id = explode("-", $old_product_id);
        $product_id = $first_id[0];
        $query_for_404 = $this->db->where(array('status' => '1', 'id' => $product_id))->get('tbl_product')->row();
        if (!empty($query_for_404)) {

            $data['product_detail_data'] = $this->front_model->get_product_detail($product_id);
            $data['product_id'] = $product_id;
            $data['product_gallery'] = $this->front_model->get_product_gallery($product_id);
            $hits = $data['product_detail_data']->hits + 1;
            $up_array = array(
                'hits' => $hits,
                'status' => '1',
                'updated_at' => date("Y-m-d H:i:s"),
            );
            $update = $this->db->where('id', $product_id)
                ->update('tbl_product', $up_array);
            $this->load->view('product-detail', $data);

        } else {
            $this->load->view('404');
        }
    }

    public function load_more_product()
    {
        $keyword = $this->input->post('keyword');
        $category_id = $this->input->post('category_id');
        $sub_category_id = $this->input->post('sub_category_id');
        $per_page = 3;
        $page = (($this->input->post('page')) !== 0) ? ($this->input->post('page')) : '1';
        $start_from = ($page - 1) * $per_page;
        $min_price = $this->input->post('min_price');
        $max_price = $this->input->post('max_price');
        $discount = ($_POST['discount']) ? ($_POST['discount']) : "";
        $popular_picks = ($_POST['popular_picks']) ? ($_POST['popular_picks']) : "";
        $availability = ($this->input->post('availability')) ? ($this->input->post('availability')) : "";
        $list_view = $this->input->post('list_view');
        $sort_by = ($this->input->post('sort_by')) ? ($this->input->post('sort_by')) : "";

        $product_list = $this->front_model->get_filter_products($min_price, $max_price, $discount, $popular_picks, $availability, $sort_by, $start_from, $per_page, $category_id, $sub_category_id, $keyword);
        $output = '';

        if (!empty($product_list)) {
            foreach ($product_list as $pro_key => $pro_value) {
                /* wishlist condition*/
                $user_id = $this->session->userdata('userSession')->id;
                $is_exist = $this->db->where(array('status' => '1', 'user_id' => $user_id, 'product_id' => $pro_value['id']))->get('tbl_wishlist')->row();
                $active = (!empty($is_exist)) ? ('active-wishlist') : '';
                /* wishlist condition */
                $original_price = $pro_value['price'];
                $discount_percentage = $pro_value['discount_percentage'];
                $discount_amount = $discount_percentage / 100;
                $final_price = $original_price - ($discount_amount * $original_price);
                $category_name = $this->db->where(array('status' => '1', 'id' => $pro_value['category_id']))->order_by('id', 'desc')->get('tbl_product_category')->row();
                $sub_category_name = $this->db->where(array('status' => '1', 'id' => $pro_value['sub_category_id']))->order_by('id', 'desc')->get('tbl_product_subcategory')->row();
                if (!empty($list_view)) {
                    $output .= '<div class="item col-lg-4 col-md-4 mb-4 mb-4 ' . $list_view . '">';
                } else {
                    $output .= '<div class="item col-lg-4 col-md-4 mb-4 mb-4">';
                }
                if (!empty($pro_value['discount_percentage'])) {
                    $output .= '<div class="sale-flag-side">
                                    <div class="sale-text">Sale</div>
                                </div>';
                }
                $output .= '<div class="thumbnail card product">
                    <div class="img-event">
                        <a class="group list-group-image"
                           href="' . site_url(url_title(strtolower($category_name->category_name)) . '/' . url_title(strtolower($sub_category_name->sub_category_name)) . '/' . $pro_value['id'] . '-' . url_title(strtolower($pro_value['product_name']))) . '">
                            <img class="img-fluid"
                                 src="' . PRODUCT_IMG_URL . $pro_value['image'] . '"
                                 alt="organicstore">
                        </a>
                    </div>
                    <div class="caption card-body">
                        <h5 class="product-type">' . $category_name->category_name . '</h5>
                        <h3 class="product-name">' . $pro_value['product_name'] . '</h3>
                        <!--starting of list view-->
                        <div class="product-table">
                            ' . $pro_value['short_description'] . '
                            <div class="row m-0">
                                <div class="col p-0">
                                    <h3 class="product-price pull-left">';
                if (!empty($discount_amount) && $discount_amount != 0) {
                    $output .= '&#x20B9;' . $final_price . " ";
                    $output .= '<del>&#x20B9;' . $original_price . '</del>';
                } else {
                    $output .= '&#x20B9;' . $original_price;
                }
                $output .= '</h3>
                            <div class="product-price pull-left">
                                <form class="form-inline">
                                    <div class="quantity buttons_added">
                                        <input type="button" value="-" class="js-qty-down new-minus">
                                        <input type="number" step="1" min="1" max="" name="quantity" value="1" title="Qty" class="input-text js-qty-input text" size="4" pattern="" id="load-product-list-' . $pro_value['id'] . '">
                                        <input type="button" value="+" class="js-qty-up new-plus">
                                        <button type="button" onClick="addToCart(' . $pro_value['id'] . ',' . round($final_price, 2) . ',' . $pro_value['availability'] . ',1)" class="add2">
                                            <i class="fa fa-shopping-bag" aria-hidden="true"></i>
                                        </button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                    <div class="clearfix"></div>
                    <div></div>
                </div>
                        <!--end of list view-->
                        <div class="row m-0 list-n">
                            <div class="col-12 p-0">
                                <h3 class="product-price">';
                if (!empty($discount_amount) && $discount_amount != 0) {
                    $output .= '&#x20B9;' . $final_price . " ";
                    $output .= '<del>&#x20B9;' . $original_price . '</del>';
                } else {
                    $output .= '&#x20B9;' . $original_price;
                }
                $output .= '</h3>
                            </div>
                            <div class="col-12 p-0">
                                <div class="product-price">
                                    <form class="form-inline">
                                        <div class="quantity buttons_added">
                                            <input type="button" value="-" class="js-qty-down new-minus">
                                            <input type="number" step="1" min="1" max="" name="quantity" value="1" title="Qty" class="input-text js-qty-input text" size="4" pattern="" id="load-product-grid-' . $pro_value['id'] . '">
                                            <input type="button" value="+" class="js-qty-up new-plus">
                                            <button type="button" onClick="addToCart(' . $pro_value['id'] . ',' . round($final_price, 2) . ',' . $pro_value['availability'] . ',0)" class="add2">
                                                <i class="fa fa-shopping-bag" aria-hidden="true"></i>
                                            </button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                        <div class="product-select">
                            <button data-toggle="tooltip" data-placement="top"
                                    title="Quick view"
                                    class="add-to-compare round-icon-btn"
                                    data-fancybox="gallery"
                                    data-src="#product' . $pro_value['id'] . '"
                                    data-original-title="Quick view">
                                <i class="fa fa-eye" aria-hidden="true"></i>
                            </button>
                            <button data-toggle="tooltip" data-placement="top" title="Wishlist"
                            class="' . $pro_value['id'] . '-active add-to-wishlist round-icon-btn ' . $active . '" onClick="addToWishlist(' . $pro_value['id'] . ');">
                                <i class="fa fa-heart-o" aria-hidden="true"></i>
                            </button>
                        </div>
                    </div>
                </div>
            </div>';
            }
        }
        $output .= '<div class="clearfix"></div>';
        if (!empty($product_list)) {
            $arrayData = array(
                'status' => 200,
                'message' => 'OK',
                'data' => $output,
            );
            echo json_encode($arrayData);
            exit;
        } else {
            $arrayData = array(
                'status' => 400,
                'message' => 'OK',
                'data' => "<h6>--That's all--</h6>",
            );
            echo json_encode($arrayData);
            exit;
        }

    }

    public function filter_products()
    {
        $keyword = $this->input->post('keyword');
        $category_id = $this->input->post('category_id');
        $sub_category_id = $this->input->post('sub_category_id');
        $per_page = 3;
        $page = (($this->input->post('page')) !== 0) ? ($this->input->post('page')) : '1';
        $start_from = 0;
        $min_price = $this->input->post('min_price');
        $max_price = $this->input->post('max_price');
        $discount = ($_POST['discount']) ? ($_POST['discount']) : "";
        $popular_picks = ($_POST['popular_picks']) ? ($_POST['popular_picks']) : "";
        $availability = ($this->input->post('availability')) ? ($this->input->post('availability')) : "";
        $list_view = $this->input->post('list_view');
        $sort_by = ($this->input->post('sort_by')) ? ($this->input->post('sort_by')) : "";

        $product_list = $this->front_model->get_filter_products($min_price, $max_price, $discount, $popular_picks, $availability, $sort_by, $start_from, $per_page, $category_id, $sub_category_id, $keyword);
        $output = '';

        if (!empty($product_list)) {
            foreach ($product_list as $pro_key => $pro_value) {
                /* wishlist condition*/
                $user_id = $this->session->userdata('userSession')->id;
                $is_exist = $this->db->where(array('status' => '1', 'user_id' => $user_id, 'product_id' => $pro_value['id']))->get('tbl_wishlist')->row();
                $active = (!empty($is_exist)) ? ('active-wishlist') : '';
                /* wishlist condition */
                $original_price = $pro_value['price'];
                $discount_percentage = $pro_value['discount_percentage'];
                $discount_amount = $discount_percentage / 100;
                $final_price = $original_price - ($discount_amount * $original_price);
                $category_name = $this->db->where(array('status' => '1', 'id' => $pro_value['category_id']))->order_by('id', 'desc')->get('tbl_product_category')->row();
                $sub_category_name = $this->db->where(array('status' => '1', 'id' => $pro_value['sub_category_id']))->order_by('id', 'desc')->get('tbl_product_subcategory')->row();
                if (!empty($list_view)) {
                    $output .= '<div class="item col-lg-4 col-md-4 mb-4 mb-4 ' . $list_view . '">';
                } else {
                    $output .= '<div class="item col-lg-4 col-md-4 mb-4 mb-4">';
                }
                if (!empty($pro_value['discount_percentage'])) {
                    $output .= '<div class="sale-flag-side">
                               <div class="sale-text">Sale</div>
                          </div>';
                }
                $output .= '<div class="thumbnail card product">
                    <div class="img-event">
                        <a class="group list-group-image" href="' . site_url(url_title(strtolower($category_name->category_name)) . '/' . url_title(strtolower($sub_category_name->sub_category_name)) . '/' . $pro_value['id'] . '-' . url_title(strtolower($pro_value['product_name']))) . '">
                            <img class="img-fluid" src="' . PRODUCT_IMG_URL . $pro_value['image'] . '" alt="organicstore">
                        </a>
                    </div>
                    <div class="caption card-body">
                        <h5 class="product-type">' . $category_name->category_name . '</h5>
                        <h3 class="product-name">' . $pro_value['product_name'] . '</h3>
                        <!--starting of list view-->
                        <div class="product-table">
                            ' . $pro_value['short_description'] . '
                            <div class="row m-0">
                                <div class="col p-0">
                                    <h3 class="product-price pull-left">';
                if (!empty($discount_amount) && $discount_amount != 0) {
                    $output .= '&#x20B9;' . round($final_price, 2) . " ";
                    $output .= '<del>&#x20B9;' . round($original_price, 2) . '</del>';
                } else {
                    $output .= '&#x20B9;' . round($original_price, 2);
                }
                $output .= '</h3>
                            <div class="product-price pull-left">
                                <form class="form-inline">
                                    <div class="quantity buttons_added">
                                        <input type="button" value="-" class="js-qty-down new-minus">
                                        <input type="number" step="1" min="1" max="" name="quantity" value="1" title="Qty" class="input-text js-qty-input text" size="4" pattern="" id="filter-product-list-' . $pro_value['id'] . '">
                                        <input type="button" value="+" class="js-qty-up new-plus">
                                        <button type="button" onClick="addToCart(' . $pro_value['id'] . ',' . round($final_price, 2) . ',' . $pro_value['availability'] . ',3)" class="add2">
                                            <i class="fa fa-shopping-bag" aria-hidden="true"></i>
                                        </button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                    <div class="clearfix"></div>
                    <div></div>
                </div>
                        <!--end of list view-->
                        <div class="row m-0 list-n">
                            <div class="col-12 p-0">
                                <h3 class="product-price">';
                if (!empty($discount_amount) && $discount_amount != 0) {
                    $output .= '&#x20B9;' . round($final_price, 2) . " ";
                    $output .= '<del>&#x20B9;' . round($original_price, 2) . '</del>';
                } else {
                    $output .= '&#x20B9;' . round($original_price, 2);
                }
                $output .= '</h3>
                            </div>
                            <div class="col-12 p-0">
                                <div class="product-price">
                                    <form class="form-inline">
                                        <div class="quantity buttons_added">
                                            <input type="button" value="-" class="js-qty-down new-minus">
                                            <input type="number" step="1" min="1" max="" name="quantity" value="1" title="Qty" class="input-text js-qty-input text" size="4" pattern="" id="filter-product-grid-' . $pro_value['id'] . '">
                                            <input type="button" value="+" class="js-qty-up new-plus">
                                            <button type="button" onClick="addToCart(' . $pro_value['id'] . ',' . round($final_price, 2) . ',' . $pro_value['availability'] . ',2)" class="add2">
                                                <i class="fa fa-shopping-bag" aria-hidden="true"></i>
                                            </button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                        <div class="product-select">
                            <button data-toggle="tooltip" data-placement="top"
                                    title="Quick view"
                                    class="add-to-compare round-icon-btn"
                                    data-fancybox="gallery"
                                    data-src="#product' . $pro_value['id'] . '"
                                    data-original-title="Quick view">
                                <i class="fa fa-eye" aria-hidden="true"></i>
                            </button>
                            <button data-toggle="tooltip" data-placement="top" title="Wishlist"
                            class="' . $pro_value['id'] . '-active add-to-wishlist round-icon-btn ' . $active . '" onClick="addToWishlist(' . $pro_value['id'] . ');">
                                <i class="fa fa-heart-o" aria-hidden="true"></i>
                            </button>
                        </div>
                    </div>
                </div>
            </div>';
            }
        }
        if (!empty($product_list)) {
            $arrayData = array(
                'status' => 200,
                'message' => 'OK',
                'data' => $output,
            );
            echo json_encode($arrayData);
            exit;
        } else {
            $arrayData = array(
                'status' => 400,
                'message' => 'OK',
                'data' => '<div class="row">
                               <div class="col-md-12 col-12">
                                    <h3>--No result found--</h3>
                               </div>
                           </div>',
            );
            echo json_encode($arrayData);
            exit;
        }
    }

    public function sign_up()
    {
        if ($this->input->post()) {
            $this->form_validation->set_rules('name', 'Name', 'required');
            $this->form_validation->set_rules('email', 'Email', 'trim|required|valid_email');
            $this->form_validation->set_rules('password', 'Password', 'required|min_length[6]|trim');
            $this->form_validation->set_rules('mobile_number', 'Mobile Number', 'required|min_length[10]|max_length[10]');
            $this->form_validation->set_rules('country_code', 'Country Code', 'required');

            if ($this->form_validation->run() == false) {
                $error_validation = validation_errors();
                $first_val_error = substr($error_validation, 0, strpos($error_validation, "</pre>"));
                $error = strip_tags($first_val_error);
                $arrayData = array(
                    'status' => 400,
                    'message' => 'Bad Request',
                    'data' => $error,
                );
            } else {
                $is_exits = $this->db->where(array('email' => $this->input->post('email'),
                    'status' => '1'))
                    ->get('tbl_customer_details')
                    ->row();

                if (empty($is_exits)) {
                    $remote = $_SERVER['REMOTE_ADDR'];
                    $in_array = array(
                        'name' => $this->input->post('name') ? $this->input->post('name') : '',
                        'email' => $this->input->post('email') ? $this->input->post('email') : '',
                        'password' => $this->input->post('password') ? md5($this->input->post('password')) : '',
                        'mobile_number' => $this->input->post('mobile_number') ? ($this->input->post('mobile_number')) : '',
                        'country_code' => $this->input->post('country_code') ? ($this->input->post('country_code')) : '',
                        'ip_address' => $remote,
                        'status' => '1',
                        'created_at' => date("Y-m-d H:i:s"),
                    );

                    $insert = $this->db->insert('tbl_customer_details', $in_array);
                    $to = $this->input->post('email') ? $this->input->post('email') : '';
                    $subject = 'Email verification';
                    $username = $this->input->post('name') ? $this->input->post('name') : '';
                    $this->send_mail_verification($to, $subject, $username);

                    $arrayData = array(
                        'status' => 200,
                        'message' => 'OK',
                        'data' => 'Thank you for registering with ' . WEB_NAME . '. Please verify your account for email. And you can enjoy with ' . WEB_NAME . ' services.',
                    );
                } else {
                    $arrayData = array(
                        'status' => 400,
                        'message' => 'Bad Request',
                        'data' => 'Email id already exits.',
                    );
                }
            }

            echo json_encode($arrayData);
            exit;
        }
    }

    public function billing_address()
    {
        if (!empty($this->session->userdata('userSession'))) {

            if ($this->input->post()) {

                $user_id = $this->userSession->id;
                $bill_first_name = ($_REQUEST['bill_first_name']) ? ($_REQUEST['bill_first_name']) : '';
                $bill_last_name = ($_REQUEST['bill_last_name']) ? ($_REQUEST['bill_last_name']) : '';
                $bill_email = ($_REQUEST['bill_email']) ? ($_REQUEST['bill_email']) : '';
                $bill_number = ($_REQUEST['bill_number']) ? ($_REQUEST['bill_number']) : '';
                $bill_address = ($_REQUEST['bill_address']) ? ($_REQUEST['bill_address']) : '';
                $bill_country = ($_REQUEST['bill_country']) ? ($_REQUEST['bill_country']) : '';
                $bill_state = ($_REQUEST['bill_state']) ? ($_REQUEST['bill_state']) : '';
                $bill_city = ($_REQUEST['bill_city']) ? ($_REQUEST['bill_city']) : '';
                $bill_post_code = ($_REQUEST['bill_post_code']) ? ($_REQUEST['bill_post_code']) : '';

                $billing = $this->front_model->get_billing_details($this->userSession->id);
                if (empty($billing)) {
                    $billing_details = array(
                        'user_id' => $user_id,
                        'first_name' => $bill_first_name,
                        'last_name' => $bill_last_name,
                        'email' => $bill_email,
                        'mobile_no' => $bill_number,
                        'address' => $bill_address,
                        'country' => $bill_country,
                        'state' => $bill_state,
                        'city' => $bill_city,
                        'post_code' => $bill_post_code,
                        'created_at' => date("Y-m-d H:i:s"),
                        'status' => '1',
                    );
                    $insert = $this->db->insert('tbl_billing_address', $billing_details);

                    if ($insert) {
                        $arrayData = array(
                            'status' => 200,
                            'message' => 'OK',
                        );
                    } else {
                        $arrayData = array(
                            'status' => 200,
                            'message' => 'OK',
                        );
                    }
                } else {
                    $billing_details_update = array(
                        'user_id' => $user_id,
                        'first_name' => $bill_first_name,
                        'last_name' => $bill_last_name,
                        'email' => $bill_email,
                        'mobile_no' => $bill_number,
                        'address' => $bill_address,
                        'country' => $bill_country,
                        'state' => $bill_state,
                        'city' => $bill_city,
                        'post_code' => $bill_post_code,
                        'updated_at' => date("Y-m-d H:i:s"),
                        'status' => '1',
                    );
                    $update = $this->db->where('id', $billing->id)->where('user_id', $this->userSession->id)->update('tbl_billing_address', $billing_details_update);

                    if ($update) {
                        $arrayData = array(
                            'status' => 200,
                            'message' => 'OK',
                        );
                    } else {
                        $arrayData = array(
                            'status' => 200,
                            'message' => 'OK',
                        );
                    }
                }

                echo json_encode($arrayData);
                exit;
            }
        } else {
            redirect('', 'refresh');
        }

    }

    public function confirm_order()
    {
        if (!empty($this->session->userdata('userSession'))) {

            if ($this->input->post()) {

                $user_id = $this->userSession->id;
                $order_id = date('Y') . time() . $user_id;
                $first_name = ($_REQUEST['first_name']) ? ($_REQUEST['first_name']) : '';
                $last_name = ($_REQUEST['last_name']) ? ($_REQUEST['last_name']) : '';
                $email = ($_REQUEST['email']) ? ($_REQUEST['email']) : '';
                $mobile_no = ($_REQUEST['mobile_no']) ? ($_REQUEST['mobile_no']) : '';
                $address = ($_REQUEST['address']) ? ($_REQUEST['address']) : '';
                $country = ($_REQUEST['country']) ? ($_REQUEST['country']) : '';
                $state = ($_REQUEST['state']) ? ($_REQUEST['state']) : '';
                $city = ($_REQUEST['city']) ? ($_REQUEST['city']) : '';
                $post_code = ($_REQUEST['post_code']) ? ($_REQUEST['post_code']) : '';
                $sub_total = ($_REQUEST['sub_total']) ? ($_REQUEST['sub_total']) : '';
                $ship_charge = ($_REQUEST['ship_charge']) ? ($_REQUEST['ship_charge']) : '';
                $grand_total = ($_REQUEST['grand_total']) ? ($_REQUEST['grand_total']) : '';
                $additional_note = ($_REQUEST['additional_note']) ? ($_REQUEST['additional_note']) : '';
                if ($_REQUEST['payment_mode'] == 0) {
                    $payment_mode = 'Cash on delivery';
                }
                if ($_REQUEST['payment_mode'] == 1) {
                    $payment_mode = 'Pay via Debit/Credit Card';
                }

                $cart = $this->front_model->get_cart_data($this->userSession->id);

                foreach ($cart as $row) {
                    $product_id = $row['product_id'];
                    $quantity = $row['quantity'];
                    $order_details = array(
                        'order_id' => $order_id,
                        'user_id' => $user_id,
                        'product_id' => $product_id,
                        'quantity' => $quantity,
                        'first_name' => $first_name,
                        'last_name' => $last_name,
                        'email' => $email,
                        'mobile_no' => $mobile_no,
                        'address' => $address,
                        'country' => $country,
                        'state' => $state,
                        'city' => $city,
                        'post_code' => $post_code,
                        'payment_mode' => $payment_mode,
                        'sub_total' => $sub_total,
                        'ship_charge' => $ship_charge,
                        'grand_total' => $grand_total,
                        'additional_note' => $additional_note,
                        'created_at' => date("Y-m-d H:i:s"),
                        'status' => '1',
                    );

                    /*best product logic*/
                    $get_best_product = $this->db->where(array('status' => '1', 'id' => $product_id))->get('tbl_product')->row();
                    $up_array = array(
                        'best_product' => $get_best_product->best_product + 1,
                        'status' => '1',
                        'updated_at' => date("Y-m-d H:i:s"),
                    );
                    $update_product = $this->db->where(array('id' => $product_id, 'status' => '1'))->update('tbl_product', $up_array);
                    /* end of best*/

                    $insert = $this->db->insert('tbl_order_details', $order_details);

                }
                if ($insert) {
                    $paymentSession = $this->session->set_userdata('billingSession', $order_details);
                    if ($_REQUEST['payment_mode'] == 0) {
                        $arrayData = array(
                            'status' => 200,
                            'message' => 'OK',
                            'data' => 'order-received-cod',
                        );
                    } else {
                        $arrayData = array(
                            'status' => 200,
                            'message' => 'OK',
                            'data' => 'payumoney-online-payment',
                        );
                    }
                } else {
                    $arrayData = array(
                        'status' => 400,
                        'message' => 'Something went wrong!!!',
                    );
                }
                echo json_encode($arrayData);
                exit;
            }
        } else {
            redirect('', 'refresh');
        }
    }

    public function cod()
    {
        if (!empty($this->session->userdata('userSession'))) {

            if (!empty($this->session->userdata('billingSession'))) {
                $paymentSession = $this->session->userdata('billingSession');
                $order_id = $paymentSession['order_id'];
                $user_id = $paymentSession['user_id'];
                $customer_email = $paymentSession['email'];
                $txnid = "";
                $data['received'] = $this->db->where(array('status' => '1', 'order_id' => $order_id))->get('tbl_order_details')->result_array();

                $subject = 'Order Details';
                $this->send_order_details(SENDER_MAIL, $customer_email, $subject, $order_id, $txnid);
                $up_array = array('status' => '9');
                $update = $this->db->where(array('user_id' => $user_id, 'status' => '1'))
                    ->update('tbl_cart', $up_array);

                $this->session->unset_userdata('billingSession');
                $this->session->unset_userdata('checkoutSession');

                $this->load->view('order-received', $data);
            }

        } else {
            redirect('', 'refresh');
        }
    }

    public function payumoney()
    {
        if (!empty($this->session->userdata('userSession'))) {

            if (!empty($this->session->userdata('billingSession'))) {
                $paymentSession = $this->session->userdata('billingSession');
                $order_id = $paymentSession['order_id'];
                $user_id = $paymentSession['user_id'];
                $customer_email = $paymentSession['email'];

                $data['merchant_key'] = "lugdF9O0";
                $data['salt'] = "lQLBhPVUfd";
                /* Merchant Key and Salt as provided by Payu. */

                $data['redirect_url'] = "https://sandboxsecure.payu.in"; /* For Sandbox Mode */
                /* $PAYU_BASE_URL = "https://secure.payu.in";   For Production Mode */

                $data['txnid'] = substr(hash('sha256', mt_rand() . microtime()), 0, 20);

                $data['order_details'] = $this->db->where(array('status' => '1', 'order_id' => $order_id))->get('tbl_order_details')->result_array();

                $this->load->view('payumoney', $data);
            }

        } else {
            redirect('', 'refresh');
        }
    }

    public function success()
    {
        $status = $this->input->post("status");
        $firstname = $this->input->post("firstname");
        $amount = $this->input->post("amount");
        $txnid = $this->input->post("txnid");

        $posted_hash = $this->input->post("hash");
        $key = $this->input->post("key");
        $productinfo = $this->input->post("productinfo");
        $email = $this->input->post("email");
        $order_id = $this->input->post("udf1");
        $salt = "lQLBhPVUfd";
        $subject = 'Order Details';
        $user_id = $this->session->userdata('userSession')->id;

        // Salt should be same Post Request

        if (!empty($this->input->post("additionalCharges"))) {
            $additionalCharges = $this->input->post("additionalCharges");
            $retHashSeq = $additionalCharges . '|' . $salt . '|' . $status . '||||||||||' . $order_id . '|' . $email . '|' . $firstname . '|' . $productinfo . '|' . $amount . '|' . $txnid . '|' . $key;
        } else {
            $retHashSeq = $salt . '|' . $status . '||||||||||' . $order_id . '|' . $email . '|' . $firstname . '|' . $productinfo . '|' . $amount . '|' . $txnid . '|' . $key;
        }
        $hash = hash("sha512", $retHashSeq);

        if ($hash != $posted_hash) {
            $data['failure'] = "<h3>Invalid Transaction. Please try again</h3>";
        } else {
            $data['received'] = $this->db->where(array('status' => '1', 'order_id' => $order_id))->get('tbl_order_details')->result_array();
            $data['txnid'] = $txnid;
            $this->send_order_details(SENDER_MAIL, $email, $subject, $order_id, $txnid);

            $up_array = array('status' => '9');
            $update = $this->db->where(array('user_id' => $user_id, 'status' => '1'))
                ->update('tbl_cart', $up_array);

            $in_array = array(
                'order_id' => $order_id,
                'user_id' => $user_id,
                'email' => $email,
                'amount' => $amount,
                'transaction_id' => $txnid,
                'payment_status' => $status,
                'status' => '1',
                'created_at' => date("Y-m-d H:i:s"),
            );
            $insert = $this->db->insert('tbl_payment_details', $in_array);

            $this->session->unset_userdata('billingSession');
            $this->session->unset_userdata('checkoutSession');
        }

        $this->load->view("order-received", $data);

    }
    public function failure()
    {
        $status = $this->input->post("status");
        $firstname = $this->input->post("firstname");
        $amount = $this->input->post("amount");
        $txnid = $this->input->post("txnid");

        $posted_hash = $this->input->post("hash");
        $key = $this->input->post("key");
        $productinfo = $this->input->post("productinfo");
        $email = $this->input->post("email");
        $order_id = $this->input->post("udf1");
        $salt = "lQLBhPVUfd";
        $user_id = $this->session->userdata('userSession')->id;

        // Salt should be same Post Request

        if (!empty($this->input->post("additionalCharges"))) {
            $additionalCharges = $this->input->post("additionalCharges");
            $retHashSeq = $additionalCharges . '|' . $salt . '|' . $status . '||||||||||' . $order_id . '|' . $email . '|' . $firstname . '|' . $productinfo . '|' . $amount . '|' . $txnid . '|' . $key;
        } else {
            $retHashSeq = $salt . '|' . $status . '||||||||||' . $order_id . '|' . $email . '|' . $firstname . '|' . $productinfo . '|' . $amount . '|' . $txnid . '|' . $key;
        }
        $hash = hash("sha512", $retHashSeq);

        if ($hash != $posted_hash) {
            $data['failure'] = "<h3>Invalid Transaction. Please try again</h3>";
        } else {
            $data['failure'] = "<h3>Your order status is " . $status . ".</h3>
                                <h4>Your transaction id for this transaction is " . $txnid . ".";
        }

        $in_array = array(
            'order_id' => $order_id,
            'user_id' => $user_id,
            'email' => $email,
            'amount' => $amount,
            'transaction_id' => $txnid,
            'payment_status' => $status,
            'status' => '1',
            'created_at' => date("Y-m-d H:i:s"),
        );
        $insert = $this->db->insert('tbl_payment_details', $in_array);

        $this->session->unset_userdata('billingSession');
        $this->session->unset_userdata('checkoutSession');

        $this->load->view("order-received", $data);

    }

    public function send_order_details($sender, $to, $subject, $order_id, $txnid)
    {

        $customerDetails = $this->db->where(array('status' => '1', 'order_id' => $order_id))->get('tbl_order_details')->row();

        $customerName = $customerDetails->first_name . ' ' . $customerDetails->last_name;
        $phone_number = $customerDetails->mobile_no;
        $address = $customerDetails->address;
        $post_code = $customerDetails->post_code;
        $city_id = $customerDetails->city;
        $city_data = $this->db->where(array('id' => $city_id))->get('tbl_cities')->row();
        $orderDate = date("d-m-Y");
        $grand_total = $customerDetails->grand_total;
        /* $payment_id = $customerDetails->payment_id;
        $payment_request_id = $customerDetails->payment_request_id; */

        $message = "

        Dear customer, <br>
        Thank you for purchasing from us. <br>
        We are pleased to announce that the processing of your order is underway. <br>
        Of course, we will inform you of its dispatch by phone call. <br>
        Many thanks for the trust you have placed in us. <br>
        See you soon! <br>
        The Organic Store. <br>
       <!DOCTYPE html PUBLIC '-//W3C//DTD XHTML 1.0 Transitional//EN' 'http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd'>
        <html xmlns='http://www.w3.org/1999/xhtml'>
        <head>
            <meta http-equiv='Content-Type' content='text/html; charset=UTF-8' />
            <title>You have new enquiry</title>
            <style>
                tr:nth-child(even) {
                    background-color: #f2f2f2
                }
                #bodyTable tr, #bodyTable td, #bodyTable  th
                {
                    border:none;
                    padding: 10px;
                    vertical-align: middle;
                }
                #bodyTable  th
                {
                    text-transform: uppercase;
                }
            </style>
        </head>

        <body>
            <table border='1' cellpadding='0' cellspacing='0' height='100%' width='100%' ' id='bodyTable ' style='border-collapse: collapse;border-radius: 25px; '>
            <tbody style='border:none;'>
               <tr style='background: #f7f7f7'>
                <th colspan='2' style='border:1px solid #000;text-align: center;text-transform: uppercase;'><h3>Customer details</h3></th>
               </tr>

               <tr style='background-color: #ead2b6 '>
                <th align='center ' valign='middle' width='200px ' style='background-color: #ead2b6 '> <strong>Name</strong> : </th>
                <td valign='top ' style='padding: 8px;text-align: left; '>" . $customerName . "</td>
               </tr>

               <tr style='background-color: #f2f2f2 '>
                <th align='center ' valign='middle' width='200px ' style='background-color: #f2f2f2 '> <strong>Email</strong> : </th>
                <td valign='top ' style='padding: 8px;text-align: left; '>" . $to . "</td>
               </tr>

               <tr style='background-color: #ead2b6 '>
                <th align='center' valign='middle' width='200px ' style='background-color: #ead2b6 '> <strong>Phone Number</strong> : </th>
                <td valign='top' style='padding: 8px;text-align: left; '>" . $phone_number . "</td>
               </tr>

               <tr style='background-color: #ead2b6 '>
                <th align='center' valign='middle' width='200px ' style='background-color: #ead2b6 '> <strong>Billing Address</strong> : </th>
                <td valign='top' style='padding: 8px;text-align: left; '>" . $address . "</td>
               </tr>

               <tr style='background-color: #ead2b6 '>
                <th align='center' valign='middle' width='200px ' style='background-color: #ead2b6 '> <strong>Postcode</strong> : </th>
                <td valign='top' style='padding: 8px;text-align: left; '>" . $post_code . "</td>
               </tr>

               <tr style='background-color: #ead2b6 '>
                <th align='center' valign='middle' width='200px ' style='background-color: #ead2b6 '> <strong>City</strong> : </th>
                <td valign='top' style='padding: 8px;text-align: left; '>" . $city_data->city_name . "</td>
               </tr>

                <tr style='background: #f7f7f7'>
               <th colspan='2' style='border:1px solid #000;text-align: center;text-transform: uppercase;'><h3>Order Details</h3></th>
               </tr>

               <tr style='background-color: #ead2b6 '>
                <th align='center ' valign='middle' width='200px ' style='background-color: #ead2b6 '> <strong>Order ID</strong> : </th>
                <td valign='top ' style='padding: 8px;text-align: left; '>" . $order_id . "</td>
               </tr>

               <tr style='background-color: #f2f2f2 '>
                <th align='center ' valign='middle' width='200px ' style='background-color: #f2f2f2 '> <strong>Order Date</strong> : </th>
                <td valign='top ' style='padding: 8px;text-align: left; '>" . $orderDate . "</td>
               </tr>

               <tr style='background: #f7f7f7'>
                <th colspan='2' style='border:1px solid #000;text-align: center;text-transform: uppercase;'><h3>Product details</h3></th>
               </tr>";

        $product = $this->db->where(array('status' => '1', 'order_id' => $order_id))->get('tbl_order_details')->result_array();
        if (!empty($product)) {
            ;

            foreach ($product as $prodata) {
                $query = $this->db->where(array('status' => '1', 'id' => $prodata['product_id']))->get('tbl_product')->result_array();
                foreach ($query as $key => $value) {
                    $original_price = $value['price'];
                    $discount_percentage = $value['discount_percentage'];
                    $discount_amount = $discount_percentage / 100;
                    $final_price = $original_price - ($discount_amount * $original_price);
                    $final_amount = $final_price * $prodata['quantity'];
                    $message .= "

                    <tr style='background-color: #ead2b6 '>
                        <th align='center ' valign='middle' width='200px ' style='background-color: #ead2b6 '> <strong>Product Name</strong> : </th>
                        <td valign='top ' style='padding: 8px;text-align: left; '>" . $value['product_name'] . "</td>
                    </tr>

                    <tr style='background-color: #f2f2f2 '>
                        <th align='center ' valign='middle' width='200px ' style='background-color: #f2f2f2 '> <strong>Quantity</strong> : </th>
                        <td valign='top ' style='padding: 8px;text-align: left; '>" . $prodata['quantity'] . "</td>
                    </tr>

                    <tr style='background-color: #ead2b6 '>
                        <th align='center ' valign='middle' width='200px ' style='background-color: #ead2b6 '> <strong>Price</strong> : </th>
                        <td valign='top ' style='padding: 8px;text-align: left; '>&#x20B9;" . round($final_price, 2) . "</td>
                    </tr>

                    <tr style='background: #000000'>
                        <td colspan='2' style='height:1px;text-align: center;text-transform: uppercase;'></td>
                    </tr>";
                }
            }
        }
        $message .= "

               <tr style='background: #f7f7f7'>
                <th colspan='2' style='border:1px solid #000;text-align: center;text-transform: uppercase;'><h3>Payment Details</h3></th>
               </tr>

               <tr style='background-color: #f2f2f2 '>
                <th align='center ' valign='middle' width='200px ' style='background-color: #f2f2f2 '> <strong>Payment Method</strong> : </th>
                <td valign='top ' style='padding: 8px;text-align: left; '>" . $customerDetails->payment_mode . "</td>
               </tr>";

        if (!empty($txnid)) {
            $message .= "<tr style='background-color: #f2f2f2 '>
               <th align='center ' valign='middle' width='200px ' style='background-color: #f2f2f2 '> <strong>Transaction Id</strong> : </th>
               <td valign='top ' style='padding: 8px;text-align: left; '>" . $txnid . "</td>
              </tr>";
        }

        $message .= "<tr style='background-color: #f2f2f2 '>
                <th align='center ' valign='middle' width='200px ' style='background-color: #f2f2f2 '> <strong>Paid Amount</strong> : </th>
                <td valign='top ' style='padding: 8px;text-align: left; '>&#x20B9;" . $grand_total . "</td>
               </tr>

               <tr>
                <td colspan='2 ' style='padding: 8px;text-align: right; '>This mail is sent from
                    <a href=' " . site_url() . " '> <strong>" . $sender . "</strong> </a>
                </td>
               </tr>
            </tbody>
               </table>
               </body>
        </html>
       ";

        $pass = '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';
        $url = 'https://api.sendgrid.com/';

        $params = array(
            'to' => $to,
            'subject' => $subject,
            'html' => $message,
            'from' => 'OrganicStore',
        );
        $request = $url . 'api/mail.send.json';
        $headr = array();
        $headr[] = 'Authorization: Bearer ' . $pass;
        $session = curl_init($request);
        curl_setopt($session, CURLOPT_POST, true);
        curl_setopt($session, CURLOPT_POSTFIELDS, $params);
        curl_setopt($session, CURLOPT_HEADER, false);
        curl_setopt($session, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($session, CURLOPT_HTTPHEADER, $headr);
        $response = curl_exec($session);
        curl_close($session);
    }

    //    Get State
    public function getState()
    {
        if ($this->input->post('country_id')) {
            $country_id = $this->input->post('country_id');
            $state = $this->front_model->getStateDb($country_id);
            $output = "";
            if ($state) {
                $output .= "<option value=''>Select State</option>";
                foreach ($state as $row) {
                    $output .= "<option value='" . $row->id . "'>" . $row->state_name . "</option>";
                }
                $arrayData = array(
                    'status' => 200,
                    'message' => 'OK',
                    'data' => "$output");
                echo json_encode($arrayData);
                exit;
            } else {
                $arrayData = array(
                    'status' => 400,
                    'message' => 'OK',
                    'data' => "$output");
                echo json_encode($arrayData);
                exit;
            }
        }
    }

    //    Get City
    public function getCity()
    {
        if ($this->input->post('state_id')) {
            $state_id = $this->input->post('state_id');
            $city = $this->front_model->getCityDb($state_id);
            $output = "";
            if ($city) {
                $output .= "<option value=''>Select City</option>";
                foreach ($city as $row) {
                    $output .= "<option value='" . $row->id . "'>" . $row->city_name . "</option>";
                }
                $arrayData = array(
                    'status' => 200,
                    'message' => 'OK',
                    'data' => "$output");
                echo json_encode($arrayData);
                exit;
            } else {
                $arrayData = array(
                    'status' => 400,
                    'message' => 'OK',
                    'data' => "$output");
                echo json_encode($arrayData);
                exit;
            }
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

}
