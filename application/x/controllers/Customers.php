<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Customers extends CI_Controller
{

    public $_loginId = array();
    public $_loginData = array();

    public function __construct()
    {

        parent::__construct();
        /* Get session data */
        $this->_loginId = $this->session->userdata(APP_NAME);
        $this->_type = $this->_loginId['id']['type'];

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
/* Redirect to dashboard Property */

        //$this->table_name = "tbl_role_category";
        $this->dir_path = "customers/";
        $this->name = "customers";
    }

    public function customer_details_lists()
    {

        $data['page']['page_title'] = APP_NAME . LIST_CUST_DET; /* Add rides title*/
        $data['page']['css'] = 'list_css'; /* add rides css */
        $this->load->view($this->name . '/customer_list', $data); /* load list.php of rides folder for list of rides */

    }

    public function general_notification_list()
    {
        if ($this->input->post()) {
            $message = ($_REQUEST['message']) ? ($_REQUEST['message']) : '';
            if ($message != '') {

                $users_token = $this->db->select('token_id')
                    ->group_by('device_id')
                    ->get('tbl_app_device_token')
                    ->result_array();
                if (!empty($users_token)) {
                    foreach ($users_token as $key => $value) {
                        $msg_res = $this->send_notification($value['token_id'], $message);
                    }
                }
                $in_array = array(

                    'message' => ($_REQUEST['message']) ? ($_REQUEST['message']) : '',
                    'status' => '1',
                    'created_at' => date("Y-m-d H:i:s"),
                );

                $this->db->insert('tbl_notification_message', $in_array);
                if ($msg_res) {
                    $this->session->set_flashdata('success', 'Notification sent successfully');
                } else {
                    $this->session->set_flashdata('error', ERR_MESSAGE);
                }
            }
        }
        $data['page']['page_title'] = APP_NAME . LIST_NOTI_DET; /* Add rides title*/
        $data['page']['css'] = 'list_css'; /* add rides css */
        $this->load->view($this->name . '/general_notification_list', $data); /* load list.php of rides folder for list of rides */

    }

    public function send_notification($to, $data)
    {
        /*$fcmApiKey = 'AAAAFQWk-8c:APA91bHEev0pPUjBnWGwVY85YY2fBiXkWbf3JRRWFknykjl6QoFQ5rRc9ExEsy3NQ5IAJEg-HQI_TBZeCzrp7-5sXjhB0Awm6MxBlisRO34bwS22G2S8jkq2-5BSs2PU2ZplGAcQMBDH';*/
        $fcmApiKey = 'AAAAhwc2TNI:APA91bERQ44USRpaTvrH6Ro1Ox41WpEU5w1068zxY_6MfOaAuoU8j6_tjO3g2oragSsR-mxTugaXNMWoHEPo8nxrE8PJDs7Oc1pmrTcp6hOZ-CZpc0Ml6Lk4oMguylUMkbOxKSbwQz6j';
        $url = 'https://fcm.googleapis.com/fcm/send';
        $fields = array(
            'notification' => array(
                "title" => "MyEcoFarm",
                "image" => "https://firebase.google.com/images/social.png",
                "body" => $data,
            ),
            'to' => $to,
        );
        /*
        {
        "notification":{
        "title":"New Text Message",
        "image":"https://firebase.google.com/images/social.png",
        "body":"Hello how are you? noti"
        },
        "to":"c1Op4yITKTo:APA91bHZ1qiUcGgWHaQeKjpWEXRQxjuKQuLZLkAjAqPOjkefZ5PxWGwKvBW3_gNS65kQnFTdWNG9ylVSJJTIGloahvKVCQDV3rY6QmGjnK-XTcqad59zEZ_gUynpUeeDl1a9XzyE8sxj-j3xWPwU6MmOpiqjjo7lxA"
        }*/
        $fields = json_encode($fields);
        $headers = array(
            'Authorization: key=' . $fcmApiKey,
            'Content-Type: application/json',
        );
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $fields);
        $result = curl_exec($ch);
        return $result;
        curl_close($ch);
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
