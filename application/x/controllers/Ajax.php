<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Ajax extends CI_Controller
{

    public $_loginId = array();
    public $_loginData = array();
    public $lang_id = array();

    public function __construct()
    {

        parent::__construct();
        /* Get session data */

        $this->lang_id = $this->session->userdata('languageSession');
        $this->_loginId = $this->session->userdata(APP_NAME);

        if (!empty($this->_loginId)) {
            $this->_loginData = $this->db->from('tbl_admin')->where(array('id' => $this->_loginId['id']['id']))->get()->row();
        }
        if ($this->_loginData->role_id != '1') {
            $permission = $this->admin_model->check_role_permission();
        }
        $this->_type = $this->_loginData->role_id;

        /* Check session */
        if (empty($this->_loginData)) {
            redirect('x/login');
        }
/* Redirect to dashboard Proparty */

    }

    /*module permission*/

    public function getModule_category()
    {
        $table_name = 'tbl_module_category';
        $segment_first = 'module_category';
        $permission_module = 'module_category';

        $start = $_POST['start'];
        $length = $_POST['length'];
        $order_column = $_POST['order'][0]['column'];
        $order_dir = $_POST['order'][0]['dir'];
        $draw = $_POST['draw'];
        $skip = $draw - $length;
        if (!isset($start)) {
            redirect('404', 'refersh');
        }
        $fieldArray = array('id', 'module_name', 'status', 'created_at');
        $fieldArray = array_combine(range(1, count($fieldArray)), $fieldArray);

        $customActionStatus = "";
        $customActionMessage = "";

        if (isset($_POST['customActionType']) && $_POST['customActionType'] == 'group_action') {

            $this->db->where_in('id', $_POST['id']);
            $data = array(
                'status' => $_POST['customActionName'],
                'updated_at' => date('Y-m-d H:i:s'),
            );
            $updateData = $this->db->update($table_name, $data);

            if ($updateData) {
                $customActionStatus = "OK";
                $customActionMessage = "Group action successfully has been completed";
            }

        }

        /* ## Search by functionality */

        /* Search by question */
        if (isset($_POST['module_category']) && $_POST['module_category'] != '') {
            $sql = $this->db->like('module_name', $_POST['module_category'], 'after');
        }

        $sql = $this->db->from($table_name);
        $to_date = date("Y-m-d");

        /* Search bt from created date */
        if ((isset($_POST['to_created_at']) && $_POST['to_created_at'] == '') && (isset($_POST['form_created_at']) && $_POST['form_created_at'] != '')) {
            $sql = $this->db->where('created_at >= "' . date('Y-m-d', strtotime(str_replace('/', '-', $_POST['form_created_at']))) . ' 00:00:00" AND "' . $to_date . ' 23:59:59"');
        }
        /* Search bt to created date */
        if ((isset($_POST['to_created_at']) && $_POST['to_created_at'] != '') && (isset($_POST['form_created_at']) && $_POST['form_created_at'] == '')) {
            $sql = $this->db->where('created_at <=', date('Y-m-d', strtotime(str_replace('/', '-', $_POST['to_created_at']))) . ' 23:59:59');
        }

        /* Search bt to and from created date */
        if ((isset($_POST['to_created_at']) && $_POST['to_created_at'] != '') && (isset($_POST['form_created_at']) && $_POST['form_created_at'] != '')) {
            $sql = $this->db->where('created_at >= "' . date('Y-m-d', strtotime(str_replace('/', '-', $_POST['form_created_at']))) . ' 00:00:00" AND created_at<="' . date('Y-m-d', strtotime(str_replace('/', '-', $_POST['to_created_at']))) . ' 23:59:59"');
        }
        /* Search by status */
        if (isset($_POST['status']) && $_POST['status'] != '') {
            $sql = $this->db->where('status', $_POST['status']);
        }
        $sql = $this->db
            ->select($fieldArray)
            ->where('status !=', '9')
            ->order_by($fieldArray[$order_column], $order_dir);

        if ($length > 0) {
            $sql = $sql->limit($length, $start);
        }
        $records = $this->db->get()->result();
        $count = $this->db->select($fieldArray)
            ->from($table_name)
            ->where('status !=', '9')
            ->order_by($fieldArray[$order_column], $order_dir)->get()->num_rows();

        $array = json_decode(json_encode($records), true);

        $i = $start + 1;
        $data = array();
        foreach ($array as $key => $rows) {

            /*status*/

            if ($rows['status'] == 0) {
                $status = '<span class="label label-sm label-info">In-active</span>';
            } else {
                $status = '<span class="label label-sm label-success">Active</span>';
            }

            $data[] = array(

                '<input type="checkbox" value="' . $rows['id'] . '"  name="id[]">',
                $rows['module_name'],
                $status,
                date('d/m/Y', strtotime($rows['created_at'])),
                '<a class="btn green btn-outline margin-bottom-5 padding-all7" title="Edit"  href="' . ADMIN_BASE_URL . $segment_first . '/' . $rows['id'] . '/edit' . '" ><i class="fa fa-edit"></i> </a>
                <a class="btn red btn-outline margin-bottom-5 padding-all7" title="Delete" href="javascript:;" onclick=" var ans = confirm( \' Are you sure you want to delete this record?\'); if( ans ){ window.location.href=\' ' . ADMIN_BASE_URL . $segment_first . '/' . $rows['id'] . '/delete' . '\'; }"><i class="fa fa-trash"></i></a>

                ',
            );
            $i++;
        }

        echo $this->common_response($_POST['draw'], $customActionStatus, $customActionMessage, $data, $count);
        exit;
    }

    /* Store Function starts */

    public function getStore()
    {
        $table_name = 'tbl_store';
        $segment_first = 'stores/store-list';

        $start = $_POST['start'];
        $length = $_POST['length'];
        $order_column = $_POST['order'][0]['column'];
        $order_dir = $_POST['order'][0]['dir'];
        $draw = $_POST['draw'];
        $skip = $draw - $length;
        if (!isset($start)) {
            redirect('404', 'refersh');
        }
        $fieldArray = array('store_id', 'store_name', 'store_email', 'website', 'contact_number', 'status', 'created_at');
        $fieldArray = array_combine(range(1, count($fieldArray)), $fieldArray);

        $customActionStatus = "";
        $customActionMessage = "";

        if (isset($_POST['customActionType']) && $_POST['customActionType'] == 'group_action') {

            $permission = $this->admin_model->check_role_permission_ajax($_POST['customActionName'], $this->_type);

            if (!$permission) {

                $customActionStatus = "OK";
                $customActionMessage = "Permission not found.";

            } else {

                $this->db->where_in('store_id', $_POST['id']);
                $data = array(
                    'status' => $_POST['customActionName'],
                    'updated_at' => date('Y-m-d H:i:s'),
                );
                $updateData = $this->db->update($table_name, $data);

                if ($updateData) {
                    $customActionStatus = "OK";
                    $customActionMessage = "Group action successfully has been completed";
                }
            }

        }

        /* ## Search by functionality */

        /* Search by question */
        /* if( isset( $_POST['origin'] ) && $_POST['origin'] != '' ){
        $sql = $this->db->like('origin_code', $_POST['origin'], 'after');
        }

        if( isset( $_POST['destination'] ) && $_POST['destination'] != '' ){
        $sql = $this->db->like('destination_code', $_POST['destination'], 'after');
        }*/

        $sql = $this->db->from($table_name);
        $to_date = date("Y-m-d");

        /* Search bt from created date */
        if ((isset($_POST['to_created_at']) && $_POST['to_created_at'] == '') && (isset($_POST['form_created_at']) && $_POST['form_created_at'] != '')) {
            $sql = $this->db->where('created_at >= "' . date('Y-m-d', strtotime(str_replace('/', '-', $_POST['form_created_at']))) . ' 00:00:00" AND "' . $to_date . ' 23:59:59"');
        }
        /* Search bt to created date */
        if ((isset($_POST['to_created_at']) && $_POST['to_created_at'] != '') && (isset($_POST['form_created_at']) && $_POST['form_created_at'] == '')) {
            $sql = $this->db->where('created_at <=', date('Y-m-d', strtotime(str_replace('/', '-', $_POST['to_created_at']))) . ' 23:59:59');
        }

        /* Search bt to and from created date */
        if ((isset($_POST['to_created_at']) && $_POST['to_created_at'] != '') && (isset($_POST['form_created_at']) && $_POST['form_created_at'] != '')) {
            $sql = $this->db->where('created_at >= "' . date('Y-m-d', strtotime(str_replace('/', '-', $_POST['form_created_at']))) . ' 00:00:00" AND created_at<="' . date('Y-m-d', strtotime(str_replace('/', '-', $_POST['to_created_at']))) . ' 23:59:59"');
        }
        /* Search by status */
        if (isset($_POST['status']) && $_POST['status'] != '') {
            $sql = $this->db->where('status', $_POST['status']);
        }

        if ($this->_type == 'user') {
            $sql = $this->db
                ->select($fieldArray)
                ->where('status !=', '9')
                ->where('store_id', $this->_loginData->active_store)
                ->order_by($fieldArray[$order_column], $order_dir);

            if ($length > 0) {
                $sql = $sql->limit($length, $start);
            }
            $records = $this->db->get()->result();
            $count = $this->db->select($fieldArray)
                ->from($table_name)
                ->where('status !=', '9')
                ->where('store_id', $this->_loginData->active_store)
                ->order_by($fieldArray[$order_column], $order_dir)->get()->num_rows();
        } else {
            $sql = $this->db
                ->select($fieldArray)
                ->where('status !=', '9')
                ->order_by($fieldArray[$order_column], $order_dir);

            if ($length > 0) {
                $sql = $sql->limit($length, $start);
            }
            $records = $this->db->get()->result();
            $count = $this->db->select($fieldArray)
                ->from($table_name)
                ->where('status !=', '9')
                ->order_by($fieldArray[$order_column], $order_dir)->get()->num_rows();
        }

        $array = json_decode(json_encode($records), true);

        $i = $start + 1;
        $data = array();
        foreach ($array as $key => $rows) {

            /*status*/

            if ($rows['status'] == 0) {
                $status = '<span class="label label-sm label-info">In-active</span>';
            } else {
                $status = '<span class="label label-sm label-success">Active</span>';
            }

            $data[] = array(

                '<input type="checkbox" value="' . $rows['store_id'] . '"  name="id[]">',
                $rows['store_name'],
                $rows['store_email'],
                $rows['website'],
                $rows['contact_number'],
                $status,
                date('d/m/Y', strtotime($rows['created_at'])),
                '<a class="btn green btn-outline margin-bottom-5 padding-all7" title="Edit"  href="' . ADMIN_BASE_URL . $segment_first . '/' . $rows['store_id'] . '/edit' . '" ><i class="fa fa-edit"></i> </a>
                <a class="btn dark btn-outline margin-bottom-5 padding-all7" title="View"  href="#" ><i class="fa fa-bars"></i> </a>
                ',
            );
            $i++;
        }

        echo $this->common_response($_POST['draw'], $customActionStatus, $customActionMessage, $data, $count);
        exit;
    }
    /* Store Function ends */

    /* Credit card function starts */

    public function getCredit_cards()
    {
        $table_name = 'tbl_credit_cards';
        $segment_first = 'stores/credit-cards';

        $start = $_POST['start'];
        $length = $_POST['length'];
        $order_column = $_POST['order'][0]['column'];
        $order_dir = $_POST['order'][0]['dir'];
        $draw = $_POST['draw'];
        $skip = $draw - $length;
        if (!isset($start)) {
            redirect('404', 'refersh');
        }
        $fieldArray = array('tbl_credit_cards.id', 'tbl_store.store_name', 'tbl_credit_cards.card_name', 'tbl_credit_cards.status', 'tbl_credit_cards.created_at');
        $fieldArray = array_combine(range(1, count($fieldArray)), $fieldArray);

        $customActionStatus = "";
        $customActionMessage = "";

        if (isset($_POST['customActionType']) && $_POST['customActionType'] == 'group_action') {

            $permission = $this->admin_model->check_role_permission_ajax($_POST['customActionName'], $this->_type);

            if (!$permission) {

                $customActionStatus = "OK";
                $customActionMessage = "Permission not found.";

            } else {

                $this->db->where_in('id', $_POST['id']);
                $data = array(
                    'status' => $_POST['customActionName'],
                    'updated_at' => date('Y-m-d H:i:s'),
                );
                $updateData = $this->db->update($table_name, $data);

                if ($updateData) {
                    $customActionStatus = "OK";
                    $customActionMessage = "Group action successfully has been completed";
                }
            }

        }

        /* ## Search by functionality */

        /* Search by question */
        if (isset($_POST['store_name']) && $_POST['store_name'] != '') {
            $sql = $this->db->like('tbl_store.store_name', $_POST['store_name'], 'after');
        }

        if (isset($_POST['card_name']) && $_POST['card_name'] != '') {
            $sql = $this->db->like('tbl_credit_cards.card_name', $_POST['card_name'], 'after');
        }

        $sql = $this->db->from($table_name);
        $to_date = date("Y-m-d");

        /* Search bt from created date */
        if ((isset($_POST['to_created_at']) && $_POST['to_created_at'] == '') && (isset($_POST['form_created_at']) && $_POST['form_created_at'] != '')) {
            $sql = $this->db->where('tbl_credit_cards.created_at >= "' . date('Y-m-d', strtotime(str_replace('/', '-', $_POST['form_created_at']))) . ' 00:00:00" AND "' . $to_date . ' 23:59:59"');
        }
        /* Search bt to created date */
        if ((isset($_POST['to_created_at']) && $_POST['to_created_at'] != '') && (isset($_POST['form_created_at']) && $_POST['form_created_at'] == '')) {
            $sql = $this->db->where('tbl_credit_cards.created_at <=', date('Y-m-d', strtotime(str_replace('/', '-', $_POST['to_created_at']))) . ' 23:59:59');
        }

        /* Search bt to and from created date */
        if ((isset($_POST['to_created_at']) && $_POST['to_created_at'] != '') && (isset($_POST['form_created_at']) && $_POST['form_created_at'] != '')) {
            $sql = $this->db->where('tbl_credit_cards.created_at >= "' . date('Y-m-d', strtotime(str_replace('/', '-', $_POST['form_created_at']))) . ' 00:00:00" AND tbl_credit_cards.created_at<="' . date('Y-m-d', strtotime(str_replace('/', '-', $_POST['to_created_at']))) . ' 23:59:59"');
        }
        /* Search by status */
        if (isset($_POST['status']) && $_POST['status'] != '') {
            $sql = $this->db->where('tbl_credit_cards.status', $_POST['status']);
        }

        if ($this->_type == 'user') {

            $sql = $this->db
                ->select($fieldArray)
                ->where('tbl_credit_cards.status !=', '9')
                ->where('tbl_credit_cards.store_id', $this->_loginData->active_store)
                ->join('tbl_store', 'tbl_store.store_id = tbl_credit_cards.store_id')
                ->order_by($fieldArray[$order_column], $order_dir);

            if ($length > 0) {
                $sql = $sql->limit($length, $start);
            }
            $records = $this->db->get()->result();
            $count = $this->db->select($fieldArray)
                ->from($table_name)
                ->where('tbl_credit_cards.status !=', '9')
                ->where('tbl_credit_cards.store_id', $this->_loginData->active_store)
                ->join('tbl_store', 'tbl_store.store_id = tbl_credit_cards.store_id')
                ->order_by($fieldArray[$order_column], $order_dir)->get()->num_rows();

        } else {
            $sql = $this->db
                ->select($fieldArray)
                ->where('tbl_credit_cards.status !=', '9')
                ->join('tbl_store', 'tbl_store.store_id = tbl_credit_cards.store_id')
                ->order_by($fieldArray[$order_column], $order_dir);

            if ($length > 0) {
                $sql = $sql->limit($length, $start);
            }
            $records = $this->db->get()->result();
            $count = $this->db->select($fieldArray)
                ->from($table_name)
                ->where('tbl_credit_cards.status !=', '9')
                ->join('tbl_store', 'tbl_store.store_id = tbl_credit_cards.store_id')
                ->order_by($fieldArray[$order_column], $order_dir)->get()->num_rows();

        }

        $array = json_decode(json_encode($records), true);

        $i = $start + 1;
        $data = array();
        foreach ($array as $key => $rows) {

            /*status*/

            if ($rows['status'] == 0) {
                $status = '<span class="label label-sm label-info">In-active</span>';
            } else {
                $status = '<span class="label label-sm label-success">Active</span>';
            }

            $data[] = array(

                '<input type="checkbox" value="' . $rows['id'] . '"  name="id[]">',
                $rows['store_name'],
                $rows['card_name'],
                $status,
                date('d/m/Y', strtotime($rows['created_at'])),
                '<a class="btn green btn-outline margin-bottom-5 padding-all7" title="Edit"  href="' . ADMIN_BASE_URL . $segment_first . '/' . $rows['id'] . '/edit' . '" ><i class="fa fa-edit"></i> </a>
                <a class="btn red btn-outline margin-bottom-5 padding-all7" title="Delete" href="javascript:;" onclick=" var ans = confirm( \' Are you sure you want to delete this record?\'); if( ans ){ window.location.href=\' ' . ADMIN_BASE_URL . $segment_first . '/' . $rows['id'] . '/delete' . '\'; }"><i class="fa fa-trash"></i></a>
                ',
            );
            $i++;
        }

        echo $this->common_response($_POST['draw'], $customActionStatus, $customActionMessage, $data, $count);
        exit;
    }

    /* Credit card function ends */

    public function getModule_subcategory()
    {
        $table_name = 'tbl_module_subcategory';
        $segment_first = 'module_subcategory';
        $permission_module = 'module_subcategory';

        $start = $_POST['start'];
        $length = $_POST['length'];
        $order_column = $_POST['order'][0]['column'];
        $order_dir = $_POST['order'][0]['dir'];
        $draw = $_POST['draw'];
        $skip = $draw - $length;
        if (!isset($start)) {
            redirect('404', 'refersh');
        }
        $fieldArray = array('tbl_module_subcategory.id', 'tbl_module_category.module_name', 'tbl_module_subcategory.sub_module_name', 'tbl_module_subcategory.status', 'tbl_module_subcategory.created_at');
        $fieldArray = array_combine(range(1, count($fieldArray)), $fieldArray);

        $customActionStatus = "";
        $customActionMessage = "";

        if (isset($_POST['customActionType']) && $_POST['customActionType'] == 'group_action') {

            $this->db->where_in('id', $_POST['id']);
            $data = array(
                'status' => $_POST['customActionName'],
                'updated_at' => date('Y-m-d H:i:s'),
            );
            $updateData = $this->db->update($table_name, $data);

            if ($updateData) {
                $customActionStatus = "OK";
                $customActionMessage = "Group action successfully has been completed";
            }

        }

        /* ## Search by functionality */

        /* Search by question */
        if (isset($_POST['module_category']) && $_POST['module_category'] != '') {
            $sql = $this->db->like('tbl_module_category.module_name', $_POST['module_category'], 'after');
        }

        $sql = $this->db->from($table_name);
        $to_date = date("Y-m-d");

        /* Search bt from created date */
        if ((isset($_POST['to_created_at']) && $_POST['to_created_at'] == '') && (isset($_POST['form_created_at']) && $_POST['form_created_at'] != '')) {
            $sql = $this->db->where('tbl_module_subcategory.created_at >= "' . date('Y-m-d', strtotime(str_replace('/', '-', $_POST['form_created_at']))) . ' 00:00:00" AND "' . $to_date . ' 23:59:59"');
        }
        /* Search bt to created date */
        if ((isset($_POST['to_created_at']) && $_POST['to_created_at'] != '') && (isset($_POST['form_created_at']) && $_POST['form_created_at'] == '')) {
            $sql = $this->db->where('tbl_module_subcategory.created_at <=', date('Y-m-d', strtotime(str_replace('/', '-', $_POST['to_created_at']))) . ' 23:59:59');
        }

        /* Search bt to and from created date */
        if ((isset($_POST['to_created_at']) && $_POST['to_created_at'] != '') && (isset($_POST['form_created_at']) && $_POST['form_created_at'] != '')) {
            $sql = $this->db->where('tbl_module_subcategory.created_at >= "' . date('Y-m-d', strtotime(str_replace('/', '-', $_POST['form_created_at']))) . ' 00:00:00" AND tbl_module_subcategory.created_at<="' . date('Y-m-d', strtotime(str_replace('/', '-', $_POST['to_created_at']))) . ' 23:59:59"');
        }
        /* Search by status */
        if (isset($_POST['status']) && $_POST['status'] != '') {
            $sql = $this->db->where('tbl_module_subcategory.status', $_POST['status']);
        }
        $sql = $this->db
            ->select($fieldArray)
            ->where('tbl_module_subcategory.status !=', '9')
            ->join('tbl_module_category', 'tbl_module_category.id = tbl_module_subcategory.module_id', 'left')
            ->order_by($fieldArray[$order_column], $order_dir);

        if ($length > 0) {
            $sql = $sql->limit($length, $start);
        }
        $records = $this->db->get()->result();
        $count = $this->db->select($fieldArray)
            ->from($table_name)
            ->where('tbl_module_subcategory.status !=', '9')
            ->join('tbl_module_category', 'tbl_module_category.id = tbl_module_subcategory.module_id', 'left')
            ->order_by($fieldArray[$order_column], $order_dir)->get()->num_rows();

        $array = json_decode(json_encode($records), true);

        $i = $start + 1;
        $data = array();
        foreach ($array as $key => $rows) {

            /*status*/

            if ($rows['status'] == 0) {
                $status = '<span class="label label-sm label-info">In-active</span>';
            } else {
                $status = '<span class="label label-sm label-success">Active</span>';
            }

            $data[] = array(

                '<input type="checkbox" value="' . $rows['id'] . '"  name="id[]">',
                $rows['module_name'],
                $rows['sub_module_name'],
                $status,
                date('d/m/Y', strtotime($rows['created_at'])),
                '<a class="btn green btn-outline margin-bottom-5 padding-all7" title="Edit"  href="' . ADMIN_BASE_URL . $segment_first . '/' . $rows['id'] . '/edit' . '" ><i class="fa fa-edit"></i> </a>
                <a class="btn red btn-outline margin-bottom-5 padding-all7" title="Delete" href="javascript:;" onclick=" var ans = confirm( \' Are you sure you want to delete this record?\'); if( ans ){ window.location.href=\' ' . ADMIN_BASE_URL . $segment_first . '/' . $rows['id'] . '/delete' . '\'; }"><i class="fa fa-trash"></i></a>

                ',
            );
            $i++;
        }

        echo $this->common_response($_POST['draw'], $customActionStatus, $customActionMessage, $data, $count);
        exit;
    }

    public function getRole()
    {
        $table_name = 'tbl_role';
        $segment_first = 'role';
        $permission_module = 'role';

        $start = $_POST['start'];
        $length = $_POST['length'];
        $order_column = $_POST['order'][0]['column'];
        $order_dir = $_POST['order'][0]['dir'];
        $draw = $_POST['draw'];
        $skip = $draw - $length;
        if (!isset($start)) {
            redirect('404', 'refersh');
        }
        $fieldArray = array('tbl_role.id', 'tbl_role_category.role_name', 'tbl_module_category.module_name', 'tbl_module_subcategory.sub_module_name', 'tbl_role.view_permission', 'tbl_role.add_permission', 'tbl_role.update_permission', 'tbl_role.delete_permission', 'tbl_role.export_permission', 'tbl_role.status', 'tbl_role.created_at', 'tbl_role.role_id');
        $fieldArray = array_combine(range(1, count($fieldArray)), $fieldArray);

        $customActionStatus = "";
        $customActionMessage = "";

        if (isset($_POST['customActionType']) && $_POST['customActionType'] == 'group_action') {

            $this->db->where_in('id', $_POST['id']);
            $data = array(
                'status' => $_POST['customActionName'],
                'updated_at' => date('Y-m-d H:i:s'),
            );
            $updateData = $this->db->update($table_name, $data);

            if ($updateData) {
                $customActionStatus = "OK";
                $customActionMessage = "Group action successfully has been completed";
            }

        }

        /* ## Search by functionality */

        /* Search by question */
        if (isset($_POST['role_name']) && $_POST['role_name'] != '') {
            $sql = $this->db->like('tbl_role_category.role_name', $_POST['role_name'], 'after');
        }
        if (isset($_POST['module_category']) && $_POST['module_category'] != '') {
            $sql = $this->db->like('tbl_module_category.module_name', $_POST['module_category'], 'after');
        }

        $sql = $this->db->from($table_name);
        $to_date = date("Y-m-d");

        /* Search bt from created date */
        if ((isset($_POST['to_created_at']) && $_POST['to_created_at'] == '') && (isset($_POST['form_created_at']) && $_POST['form_created_at'] != '')) {
            $sql = $this->db->where('tbl_role.created_at >= "' . date('Y-m-d', strtotime(str_replace('/', '-', $_POST['form_created_at']))) . ' 00:00:00" AND "' . $to_date . ' 23:59:59"');
        }
        /* Search bt to created date */
        if ((isset($_POST['to_created_at']) && $_POST['to_created_at'] != '') && (isset($_POST['form_created_at']) && $_POST['form_created_at'] == '')) {
            $sql = $this->db->where('tbl_role.created_at <=', date('Y-m-d', strtotime(str_replace('/', '-', $_POST['to_created_at']))) . ' 23:59:59');
        }

        /* Search bt to and from created date */
        if ((isset($_POST['to_created_at']) && $_POST['to_created_at'] != '') && (isset($_POST['form_created_at']) && $_POST['form_created_at'] != '')) {
            $sql = $this->db->where('tbl_role.created_at >= "' . date('Y-m-d', strtotime(str_replace('/', '-', $_POST['form_created_at']))) . ' 00:00:00" AND tbl_role.created_at<="' . date('Y-m-d', strtotime(str_replace('/', '-', $_POST['to_created_at']))) . ' 23:59:59"');
        }
        /* Search by status */
        if (isset($_POST['status']) && $_POST['status'] != '') {
            $sql = $this->db->where('tbl_role.status', $_POST['status']);
        }
        $sql = $this->db
            ->select($fieldArray)
            ->where('tbl_role.status !=', '9')
            ->join('tbl_module_category', 'tbl_module_category.id = tbl_role.module_id', 'left')
            ->join('tbl_module_subcategory', 'tbl_module_subcategory.id = tbl_role.sub_module_id', 'left')
            ->join('tbl_role_category', 'tbl_role_category.id = tbl_role.role_id', 'left')
            ->order_by($fieldArray[$order_column], $order_dir);

        if ($length > 0) {
            $sql = $sql->limit($length, $start);
        }
        $records = $this->db->get()->result();
        $count = $this->db->select($fieldArray)
            ->from($table_name)
            ->where('tbl_module_subcategory.status !=', '9')
            ->join('tbl_module_category', 'tbl_module_category.id = tbl_role.module_id', 'left')
            ->join('tbl_module_subcategory', 'tbl_module_subcategory.id = tbl_role.sub_module_id', 'left')
            ->join('tbl_role_category', 'tbl_role_category.id = tbl_role.role_id', 'left')
            ->order_by($fieldArray[$order_column], $order_dir)->get()->num_rows();

        $array = json_decode(json_encode($records), true);

        $i = $start + 1;
        $data = array();
        foreach ($array as $key => $rows) {

            /*status*/

            if ($rows['status'] == 0) {
                $status = '<span class="label label-sm label-info">In-active</span>';
            } else {
                $status = '<span class="label label-sm label-success">Active</span>';
            }

            $data[] = array(

                '<input type="checkbox" value="' . $rows['id'] . '"  name="id[]">',
                $rows['role_name'],
                $rows['module_name'],
                $rows['sub_module_name'],
                $rows['view_permission'],
                $rows['add_permission'],
                $rows['update_permission'],
                $rows['delete_permission'],
                $rows['export_permission'],
                $status,
                date('d/m/Y', strtotime($rows['created_at'])),
                '
                <a class="btn green btn-outline margin-bottom-5 padding-all7" title="Edit"  href="' . ADMIN_BASE_URL . $segment_first . '/' . $rows['id'] . '/edit' . '" ><i class="fa fa-edit"></i> </a>

                <a class="btn red btn-outline margin-bottom-5 padding-all7" title="Delete" href="javascript:;" onclick=" var ans = confirm( \' Are you sure you want to delete this record?\'); if( ans ){ window.location.href=\' ' . ADMIN_BASE_URL . $segment_first . '/' . $rows['id'] . '/delete' . '\'; }"><i class="fa fa-trash"></i></a>
                ',
            );
            $i++;
        }

        echo $this->common_response($_POST['draw'], $customActionStatus, $customActionMessage, $data, $count);
        exit;
    }

    public function getRole_permission()
    {
        $table_name = 'tbl_role_category';
        $segment_first = 'role_permission';
        $permission_module = 'role_permission';

        $start = $_POST['start'];
        $length = $_POST['length'];
        $order_column = $_POST['order'][0]['column'];
        $order_dir = $_POST['order'][0]['dir'];
        $draw = $_POST['draw'];
        $skip = $draw - $length;
        if (!isset($start)) {
            redirect('404', 'refersh');
        }
        $fieldArray = array('tbl_role_category.id', 'tbl_role_category.role_name', 'tbl_role_category.status', 'tbl_role_category.created_at');
        $fieldArray = array_combine(range(1, count($fieldArray)), $fieldArray);

        $customActionStatus = "";
        $customActionMessage = "";

        if (isset($_POST['customActionType']) && $_POST['customActionType'] == 'group_action') {

            $this->db->where_in('tbl_role_category.id', $_POST['id']);
            $data = array(
                'status' => $_POST['customActionName'],
                'updated_at' => date('Y-m-d H:i:s'),
            );
            $updateData = $this->db->update($table_name, $data);

            if ($updateData) {
                $customActionStatus = "OK";
                $customActionMessage = "Group action successfully has been completed";
            }

        }

        /* ## Search by functionality */

        /* Search by question */
        if (isset($_POST['role_name']) && $_POST['role_name'] != '') {
            $sql = $this->db->like('tbl_role_category.role_name', $_POST['role_name'], 'after');
        }

        if (isset($_POST['store_name']) && $_POST['store_name'] != '') {
            $sql = $this->db->like('tbl_store.store_name', $_POST['store_name'], 'after');
        }

        $sql = $this->db->from($table_name);
        $to_date = date("Y-m-d");

        /* Search bt from created date */
        if ((isset($_POST['to_created_at']) && $_POST['to_created_at'] == '') && (isset($_POST['form_created_at']) && $_POST['form_created_at'] != '')) {
            $sql = $this->db->where('tbl_role_category.created_at >= "' . date('Y-m-d', strtotime(str_replace('/', '-', $_POST['form_created_at']))) . ' 00:00:00" AND "' . $to_date . ' 23:59:59"');
        }
        /* Search bt to created date */
        if ((isset($_POST['to_created_at']) && $_POST['to_created_at'] != '') && (isset($_POST['form_created_at']) && $_POST['form_created_at'] == '')) {
            $sql = $this->db->where('tbl_role_category.created_at <=', date('Y-m-d', strtotime(str_replace('/', '-', $_POST['to_created_at']))) . ' 23:59:59');
        }

        /* Search bt to and from created date */
        if ((isset($_POST['to_created_at']) && $_POST['to_created_at'] != '') && (isset($_POST['form_created_at']) && $_POST['form_created_at'] != '')) {
            $sql = $this->db->where('tbl_role_category.created_at >= "' . date('Y-m-d', strtotime(str_replace('/', '-', $_POST['form_created_at']))) . ' 00:00:00" AND tbl_role_category.created_at<="' . date('Y-m-d', strtotime(str_replace('/', '-', $_POST['to_created_at']))) . ' 23:59:59"');
        }
        /* Search by status */
        if (isset($_POST['tbl_role_category.status']) && $_POST['status'] != '') {
            $sql = $this->db->where('tbl_role_category.status', $_POST['status']);
        }
        $sql = $this->db
            ->select($fieldArray)
            ->where('tbl_role_category.status !=', '9')
            ->order_by($fieldArray[$order_column], $order_dir);

        if ($length > 0) {
            $sql = $sql->limit($length, $start);
        }
        $records = $this->db->get()->result();
        $count = $this->db->select($fieldArray)
            ->from($table_name)
            ->where('tbl_role_category.status !=', '9')
            ->order_by($fieldArray[$order_column], $order_dir)->get()->num_rows();

        $array = json_decode(json_encode($records), true);

        $i = $start + 1;
        $data = array();
        foreach ($array as $key => $rows) {

            /*status*/

            if ($rows['status'] == 0) {
                $status = '<span class="label label-sm label-info">In-active</span>';
            } else {
                $status = '<span class="label label-sm label-success">Active</span>';
            }

            $data[] = array(

                '<input type="checkbox" value="' . $rows['id'] . '"  name="id[]">',
                $rows['role_name'],
                $status,
                date('d/m/Y', strtotime($rows['created_at'])),
                '<a class="btn green btn-outline margin-bottom-5 padding-all7" title="Edit"  href="' . ADMIN_BASE_URL . $segment_first . '/' . $rows['id'] . '/edit' . '" ><i class="fa fa-edit"></i> </a>
                <a class="btn red btn-outline margin-bottom-5 padding-all7" title="Delete" href="javascript:;" onclick=" var ans = confirm( \' Are you sure you want to delete this record?\'); if( ans ){ window.location.href=\' ' . ADMIN_BASE_URL . $segment_first . '/' . $rows['id'] . '/delete' . '\'; }"><i class="fa fa-trash"></i></a>

                ',
            );
            $i++;
        }

        echo $this->common_response($_POST['draw'], $customActionStatus, $customActionMessage, $data, $count);
        exit;
    }

    public function getRole_category()
    {
        $table_name = 'tbl_role_category';
        $segment_first = 'role_category';
        $permission_module = 'role_category';

        $start = $_POST['start'];
        $length = $_POST['length'];
        $order_column = $_POST['order'][0]['column'];
        $order_dir = $_POST['order'][0]['dir'];
        $draw = $_POST['draw'];
        $skip = $draw - $length;
        if (!isset($start)) {
            redirect('404', 'refersh');
        }
        $fieldArray = array('id', 'role_name', 'status', 'created_at');
        $fieldArray = array_combine(range(1, count($fieldArray)), $fieldArray);

        $customActionStatus = "";
        $customActionMessage = "";

        if (isset($_POST['customActionType']) && $_POST['customActionType'] == 'group_action') {

            $this->db->where_in('id', $_POST['id']);
            $data = array(
                'status' => $_POST['customActionName'],
                'updated_at' => date('Y-m-d H:i:s'),
            );
            $updateData = $this->db->update($table_name, $data);

            if ($updateData) {
                $customActionStatus = "OK";
                $customActionMessage = "Group action successfully has been completed";
            }

        }

        /* ## Search by functionality */

        /* Search by question */
        if (isset($_POST['role_name']) && $_POST['role_name'] != '') {
            $sql = $this->db->like('role_name', $_POST['role_name'], 'after');
        }

        $sql = $this->db->from($table_name);
        $to_date = date("Y-m-d");

        /* Search bt from created date */
        if ((isset($_POST['to_created_at']) && $_POST['to_created_at'] == '') && (isset($_POST['form_created_at']) && $_POST['form_created_at'] != '')) {
            $sql = $this->db->where('created_at >= "' . date('Y-m-d', strtotime(str_replace('/', '-', $_POST['form_created_at']))) . ' 00:00:00" AND "' . $to_date . ' 23:59:59"');
        }
        /* Search bt to created date */
        if ((isset($_POST['to_created_at']) && $_POST['to_created_at'] != '') && (isset($_POST['form_created_at']) && $_POST['form_created_at'] == '')) {
            $sql = $this->db->where('created_at <=', date('Y-m-d', strtotime(str_replace('/', '-', $_POST['to_created_at']))) . ' 23:59:59');
        }

        /* Search bt to and from created date */
        if ((isset($_POST['to_created_at']) && $_POST['to_created_at'] != '') && (isset($_POST['form_created_at']) && $_POST['form_created_at'] != '')) {
            $sql = $this->db->where('created_at >= "' . date('Y-m-d', strtotime(str_replace('/', '-', $_POST['form_created_at']))) . ' 00:00:00" AND created_at<="' . date('Y-m-d', strtotime(str_replace('/', '-', $_POST['to_created_at']))) . ' 23:59:59"');
        }
        /* Search by status */
        if (isset($_POST['status']) && $_POST['status'] != '') {
            $sql = $this->db->where('status', $_POST['status']);
        }
        $sql = $this->db
            ->select($fieldArray)
            ->where('status !=', '9')
            ->order_by($fieldArray[$order_column], $order_dir);

        if ($length > 0) {
            $sql = $sql->limit($length, $start);
        }
        $records = $this->db->get()->result();
        $count = $this->db->select($fieldArray)
            ->from($table_name)
            ->where('status !=', '9')
            ->order_by($fieldArray[$order_column], $order_dir)->get()->num_rows();

        $array = json_decode(json_encode($records), true);

        $i = $start + 1;
        $data = array();
        foreach ($array as $key => $rows) {

            /*status*/

            if ($rows['status'] == 0) {
                $status = '<span class="label label-sm label-info">In-active</span>';
            } else {
                $status = '<span class="label label-sm label-success">Active</span>';
            }

            $data[] = array(

                '<input type="checkbox" value="' . $rows['id'] . '"  name="id[]">',
                $rows['role_name'],
                $status,
                date('d/m/Y', strtotime($rows['created_at'])),
                '<a class="btn green btn-outline margin-bottom-5 padding-all7" title="Edit"  href="' . ADMIN_BASE_URL . $segment_first . '/' . $rows['id'] . '/edit' . '" ><i class="fa fa-edit"></i> </a>
                <a class="btn red btn-outline margin-bottom-5 padding-all7" title="Delete" href="javascript:;" onclick=" var ans = confirm( \' Are you sure you want to delete this record?\'); if( ans ){ window.location.href=\' ' . ADMIN_BASE_URL . $segment_first . '/' . $rows['id'] . '/delete' . '\'; }"><i class="fa fa-trash"></i></a>

                ',
            );
            $i++;
        }

        echo $this->common_response($_POST['draw'], $customActionStatus, $customActionMessage, $data, $count);
        exit;
    }

    /*end module permission*/

    public function getStoreusers()
    {
        $table_name = 'tbl_storeusers';
        $segment_first = 'stores/users';
        $start = $_POST['start'];
        $length = $_POST['length'];
        $order_column = $_POST['order'][0]['column'];
        $order_dir = $_POST['order'][0]['dir'];
        $draw = $_POST['draw'];
        $skip = $draw - $length;
        if (!isset($start)) {
            redirect('404', 'refersh');
        }
        $fieldArray = array('tbl_storeusers.storeuser_id', 'tbl_storeusers.storeuser_fname', 'tbl_storeusers.storeuser_lname', 'tbl_storeusers.storeuser_email', 'tbl_storeusers.storeuser_phone', 'tbl_storeusers.storeuser_image', 'tbl_storeusers.status', 'tbl_storeusers.created_at');
        $fieldArray = array_combine(range(1, count($fieldArray)), $fieldArray);

        $customActionStatus = "";
        $customActionMessage = "";

        if (isset($_POST['customActionType']) && $_POST['customActionType'] == 'group_action') {

            $permission = $this->admin_model->check_role_permission_ajax($_POST['customActionName'], $this->_type);

            if (!$permission) {

                $customActionStatus = "OK";
                $customActionMessage = "Permission not found.";

            } else {

                $this->db->where_in('storeuser_id', $_POST['id']);
                $data = array(
                    'status' => $_POST['customActionName'],
                    'updated_at' => date('Y-m-d H:i:s'),
                );
                $updateData = $this->db->update($table_name, $data);

                if ($updateData) {
                    $customActionStatus = "OK";
                    $customActionMessage = "Group action successfully has been completed";
                }
            }

        }

        $sql = $this->db->from($table_name);
        $to_date = date("Y-m-d");

        if (isset($_POST['tbl_storeusers.storeuser_fname']) && $_POST['storeuser_fname'] != '') {
            $sql = $this->db->like('storeuser_fname', $_POST['storeuser_fname'], 'after');
        }
        if (isset($_POST['email']) && $_POST['email'] != '') {
            $sql = $this->db->like('tbl_storeusers.storeuser_email', $_POST['storeuser_email'], 'after');
        }

        /* Search bt from created date */
        if ((isset($_POST['to_created_at']) && $_POST['to_created_at'] == '') && (isset($_POST['form_created_at']) && $_POST['form_created_at'] != '')) {
            $sql = $this->db->where('tbl_storeusers.created_at >= "' . date('Y-m-d', strtotime(str_replace('/', '-', $_POST['form_created_at']))) . ' 00:00:00" AND "' . $to_date . ' 23:59:59"');
        }
        /* Search bt to created date */
        if ((isset($_POST['to_created_at']) && $_POST['to_created_at'] != '') && (isset($_POST['form_created_at']) && $_POST['form_created_at'] == '')) {
            $sql = $this->db->where('tbl_storeusers.created_at <=', date('Y-m-d', strtotime(str_replace('/', '-', $_POST['to_created_at']))) . ' 23:59:59');
        }

        /* Search bt to and from created date */
        if ((isset($_POST['to_created_at']) && $_POST['to_created_at'] != '') && (isset($_POST['form_created_at']) && $_POST['form_created_at'] != '')) {
            $sql = $this->db->where('tbl_storeusers.created_at >= "' . date('Y-m-d', strtotime(str_replace('/', '-', $_POST['form_created_at']))) . ' 00:00:00" AND tbl_storeusers.created_at<="' . date('Y-m-d', strtotime(str_replace('/', '-', $_POST['to_created_at']))) . ' 23:59:59"');
        }

        /* Search by status */
        if (isset($_POST['status']) && $_POST['status'] != '') {
            $sql = $this->db->where('tbl_storeusers.status', $_POST['status']);
        }

        if ($this->_type == 'user') {

            $sql = $this->db
                ->select($fieldArray)
                ->where('tbl_storeusers.status !=', '9')
                ->where('tbl_user_store_permission.store_id', $this->_loginData->active_store)
                ->join('tbl_user_store_permission', 'tbl_user_store_permission.user_id = tbl_storeusers.storeuser_id', 'left')
                ->group_by('tbl_user_store_permission.user_id')
                ->order_by($fieldArray[$order_column], $order_dir);

            if ($length > 0) {
                $sql = $sql->limit($length, $start);
            }
            $records = $this->db->get()->result();
            $count = $this->db->select($fieldArray)
                ->from($table_name)
                ->where('tbl_storeusers.status !=', '9')
                ->where('tbl_user_store_permission.store_id', $this->_loginData->active_store)
                ->join('tbl_user_store_permission', 'tbl_user_store_permission.user_id = tbl_storeusers.storeuser_id', 'left')
                ->group_by('tbl_user_store_permission.user_id')
                ->order_by($fieldArray[$order_column], $order_dir)->get()->num_rows();
        } else {
            $sql = $this->db
                ->select($fieldArray)
                ->where('status !=', '9')
                ->order_by($fieldArray[$order_column], $order_dir);

            if ($length > 0) {
                $sql = $sql->limit($length, $start);
            }
            $records = $this->db->get()->result();
            $count = $this->db->select($fieldArray)
                ->from($table_name)
                ->where('status !=', '9')
                ->order_by($fieldArray[$order_column], $order_dir)->get()->num_rows();
        }

        $array = json_decode(json_encode($records), true);

        $i = $start + 1;
        $data = array();
        foreach ($array as $key => $rows) {

            /*status*/

            if ($rows['storeuser_image'] == "") {
                $image = '<img width="80px" height="auto" src="' . DEFAULT_IMAGE . '">';
            } else {
                $image = '<a data-fancybox="gallery" href="' . USER_IMG_URL . $rows['storeuser_image'] . '" >
                            <img width="80px" height="auto" src="' . USER_IMG_URL . $rows['storeuser_image'] . '">
                            </a>';

            }

            if ($rows['status'] == 0) {
                $status = '<span class="label label-sm label-info">In-active</span>';
            } else {
                $status = '<span class="label label-sm label-success">Active</span>';
            }

            $data[] = array(

                '<input type="checkbox" value="' . $rows['storeuser_id'] . '"  name="id[]">',
                $rows['storeuser_fname'],
                $rows['storeuser_lname'],
                $rows['storeuser_email'],
                $rows['storeuser_phone'],
                $image,
                $status,
                date('d/m/Y', strtotime($rows['created_at'])),

                '<div class="btn-group">
                    <a class="btn green-haze btn-outline  margin-bottom-5 padding-all7" href="javascript:;" data-toggle="dropdown" data-hover="dropdown" data-close-others="true" aria-expanded="false">Select Action <i class="fa fa-angle-down"></i></a>
                        <ul class="dropdown-menu pull-right">


                            <li>
                                <a title="Edit" href="' . ADMIN_BASE_URL . $segment_first . '/' . $rows['storeuser_id'] . '/edit' . '" ><i class="fa fa-edit"></i> Edit</a>
                            </li>

                            <li>
                                <a title="Delete" href="javascript:;" onclick=" var ans = confirm( \' Are you sure you want to delete this record?\'); if( ans ){ window.location.href=\' ' . ADMIN_BASE_URL . $segment_first . '/' . $rows['storeuser_id'] . '/delete' . '\'; }"><i class="fa fa-trash-o"></i> Delete</a>
                            </li>



                        </ul>
                </div>

                ',
            );
            $i++;
        }

        echo $this->common_response($_POST['draw'], $customActionStatus, $customActionMessage, $data, $count);
        exit;
    }

    /* Get Inquiry starts here */

    public function getInquiry()
    {
        $table_name = 'tbl_inquiry';
        $segment_first = 'booking/inquiry';
        $start = $_POST['start'];
        $length = $_POST['length'];
        $order_column = $_POST['order'][0]['column'];
        $order_dir = $_POST['order'][0]['dir'];
        $draw = $_POST['draw'];
        $skip = $draw - $length;
        if (!isset($start)) {
            redirect('404', 'refersh');
        }
        $fieldArray = array('tbl_inquiry.id', 'tbl_source.source_name', 'tbl_storeusers.storeuser_fname', 'tbl_storeusers.storeuser_lname', 'tbl_inquiry.customer_one', 'tbl_inquiry.customer_two', 'tbl_inquiry.email', 'tbl_inquiry.phone', 'tbl_inquiry.security_code_one', 'tbl_inquiry.security_code_two', 'tbl_case_status.case_name', 'tbl_inquiry.created_at', 'tbl_inquiry.status');
        $fieldArray = array_combine(range(1, count($fieldArray)), $fieldArray);

        $customActionStatus = "";
        $customActionMessage = "";

        if (isset($_POST['customActionType']) && $_POST['customActionType'] == 'group_action') {

            $permission = $this->admin_model->check_role_permission_ajax($_POST['customActionName'], $this->_type);

            if (!$permission) {

                $customActionStatus = "OK";
                $customActionMessage = "Permission not found.";

            } else {

                $this->db->where_in('id', $_POST['id']);
                $data = array(
                    'status' => $_POST['customActionName'],
                    'updated_at' => date('Y-m-d H:i:s'),
                );
                $updateData = $this->db->update($table_name, $data);

                if ($updateData) {
                    $customActionStatus = "OK";
                    $customActionMessage = "Group action successfully has been completed";
                }
            }

        }

        $sql = $this->db->from($table_name);
        $to_date = date("Y-m-d");

        if (isset($_POST['source_name']) && $_POST['source_name'] != '') {
            $sql = $this->db->like('tbl_source.source_name', $_POST['source_name'], 'after');
        }

        if (isset($_POST['agent_name']) && $_POST['agent_name'] != '') {
            $sql = $this->db->like('tbl_storeusers.storeuser_fname', $_POST['agent_name'], 'after');
        }

        if (isset($_POST['customer_one']) && $_POST['customer_one'] != '') {
            $sql = $this->db->like('tbl_inquiry.customer_one', $_POST['customer_one'], 'after');
        }

        if (isset($_POST['case_status']) && $_POST['case_status'] != '') {
            $sql = $this->db->like('tbl_case_status.case_name', $_POST['case_status'], 'after');
        }

        /* Search bt from created date */
        if ((isset($_POST['to_created_at']) && $_POST['to_created_at'] == '') && (isset($_POST['form_created_at']) && $_POST['form_created_at'] != '')) {
            $sql = $this->db->where('created_at >= "' . date('Y-m-d', strtotime(str_replace('/', '-', $_POST['form_created_at']))) . ' 00:00:00" AND "' . $to_date . ' 23:59:59"');
        }
        /* Search bt to created date */
        if ((isset($_POST['to_created_at']) && $_POST['to_created_at'] != '') && (isset($_POST['form_created_at']) && $_POST['form_created_at'] == '')) {
            $sql = $this->db->where('created_at <=', date('Y-m-d', strtotime(str_replace('/', '-', $_POST['to_created_at']))) . ' 23:59:59');
        }

        /* Search bt to and from created date */
        if ((isset($_POST['to_created_at']) && $_POST['to_created_at'] != '') && (isset($_POST['form_created_at']) && $_POST['form_created_at'] != '')) {
            $sql = $this->db->where('created_at >= "' . date('Y-m-d', strtotime(str_replace('/', '-', $_POST['form_created_at']))) . ' 00:00:00" AND created_at<="' . date('Y-m-d', strtotime(str_replace('/', '-', $_POST['to_created_at']))) . ' 23:59:59"');
        }

        /* Search by status */
        if (isset($_POST['status']) && $_POST['status'] != '') {
            $sql = $this->db->where('status', $_POST['status']);
        }

        $sql = $this->db
            ->select($fieldArray)
            ->where('tbl_inquiry.status !=', '9')
            ->join('tbl_source', 'tbl_source.id = tbl_inquiry.source_id', 'left')
            ->join('tbl_storeusers', 'tbl_storeusers.storeuser_id = tbl_inquiry.storeuser_id', 'left')
            ->join('tbl_case_status', 'tbl_case_status.id = tbl_inquiry.case_status_id', 'left')
            ->order_by($fieldArray[$order_column], $order_dir);

        if ($length > 0) {
            $sql = $sql->limit($length, $start);
        }
        $records = $this->db->get()->result();
        $count = $this->db->select($fieldArray)
            ->from($table_name)
            ->where('tbl_inquiry.status !=', '9')
            ->join('tbl_source', 'tbl_source.id = tbl_inquiry.source_id', 'left')
            ->join('tbl_storeusers', 'tbl_storeusers.storeuser_id = tbl_inquiry.storeuser_id', 'left')
            ->join('tbl_case_status', 'tbl_case_status.id = tbl_inquiry.case_status_id', 'left')
            ->order_by($fieldArray[$order_column], $order_dir)->get()->num_rows();

        $array = json_decode(json_encode($records), true);

        $i = $start + 1;
        $data = array();
        foreach ($array as $key => $rows) {

            /*status*/

            if ($rows['status'] == 0) {
                $status = '<span class="label label-sm label-info">In-active</span>';
            } else {
                $status = '<span class="label label-sm label-success">Active</span>';
            }

            $fname = $rows['storeuser_fname'];
            $lname = $rows['storeuser_lname'];

            $agent_name = $fname . ' ' . $lname;

            $data[] = array(

                '<input type="checkbox" value="' . $rows['id'] . '"  name="id[]">',
                $rows['source_name'],
                $rows['customer_one'],
                $rows['customer_two'],
                $rows['email'],
                $rows['phone'],
                $rows['security_code_one'],
                $rows['security_code_two'],
                $agent_name,
                $rows['case_name'],
                $status,
                '<div class="btn-group">
                    <a class="btn green-haze btn-outline  margin-bottom-5 padding-all7" href="javascript:;" data-toggle="dropdown" data-hover="dropdown" data-close-others="true" aria-expanded="false">Select Action <i class="fa fa-angle-down"></i></a>
                        <ul class="dropdown-menu pull-right">


                            <li>
                                <a title="Edit" href="' . ADMIN_BASE_URL . $segment_first . '/' . $rows['id'] . '/edit' . '" ><i class="fa fa-edit"></i> Change Case Status</a>
                            </li>

                            <li>
                                <a title="Delete" href="javascript:;" onclick=" var ans = confirm( \' Are you sure you want to delete this record?\'); if( ans ){ window.location.href=\' ' . ADMIN_BASE_URL . $segment_first . '/' . $rows['id'] . '/delete' . '\'; }"><i class="fa fa-trash-o"></i> Delete</a>
                            </li>

                            <li>
                                <a title="Book Now" href="#" ><i class="fa fa-list"></i> Book Now </a>
                            </li>

                            <li>
                                <a title="Send Email" href="#" ><i class="fa fa-envelope"></i> Send Email </a>
                            </li>



                        </ul>
                </div>

                ',
            );
            $i++;
        }

        echo $this->common_response($_POST['draw'], $customActionStatus, $customActionMessage, $data, $count);
        exit;
    }

    /* Get Inquiry ends here */

    public function getFaq()
    {
        $table_name = 'tbl_faq';
        $segment_first = 'faq/add-faq';

        $start = $_POST['start'];
        $length = $_POST['length'];
        $order_column = $_POST['order'][0]['column'];
        $order_dir = $_POST['order'][0]['dir'];
        $draw = $_POST['draw'];
        $skip = $draw - $length;
        if (!isset($start)) {
            redirect('404', 'refersh');
        }
        $fieldArray = array('id', 'question', 'answer', 'status', 'created_at');
        $fieldArray = array_combine(range(1, count($fieldArray)), $fieldArray);

        $customActionStatus = "";
        $customActionMessage = "";

        if (isset($_POST['customActionType']) && $_POST['customActionType'] == 'group_action') {

            $permission = $this->admin_model->check_role_permission_ajax($_POST['customActionName'], $this->_type);

            if (!$permission) {

                $customActionStatus = "OK";
                $customActionMessage = "Permission not found.";

            } else {

                $this->db->where_in('id', $_POST['id']);
                $data = array(
                    'status' => $_POST['customActionName'],
                    'updated_at' => date('Y-m-d H:i:s'),
                );
                $updateData = $this->db->update($table_name, $data);

                if ($updateData) {
                    $customActionStatus = "OK";
                    $customActionMessage = "Group action successfully has been completed";
                }
            }

        }

        /* ## Search by functionality */

        /* Search by question */
        if (isset($_POST['question']) && $_POST['question'] != '') {
            $sql = $this->db->like('question', $_POST['question'], 'after');
        }

        $sql = $this->db->from($table_name);
        $to_date = date("Y-m-d");

        /* Search bt from created date */
        if ((isset($_POST['to_created_at']) && $_POST['to_created_at'] == '') && (isset($_POST['form_created_at']) && $_POST['form_created_at'] != '')) {
            $sql = $this->db->where('created_at >= "' . date('Y-m-d', strtotime(str_replace('/', '-', $_POST['form_created_at']))) . ' 00:00:00" AND "' . $to_date . ' 23:59:59"');
        }
        /* Search bt to created date */
        if ((isset($_POST['to_created_at']) && $_POST['to_created_at'] != '') && (isset($_POST['form_created_at']) && $_POST['form_created_at'] == '')) {
            $sql = $this->db->where('created_at <=', date('Y-m-d', strtotime(str_replace('/', '-', $_POST['to_created_at']))) . ' 23:59:59');
        }

        /* Search bt to and from created date */
        if ((isset($_POST['to_created_at']) && $_POST['to_created_at'] != '') && (isset($_POST['form_created_at']) && $_POST['form_created_at'] != '')) {
            $sql = $this->db->where('created_at >= "' . date('Y-m-d', strtotime(str_replace('/', '-', $_POST['form_created_at']))) . ' 00:00:00" AND created_at<="' . date('Y-m-d', strtotime(str_replace('/', '-', $_POST['to_created_at']))) . ' 23:59:59"');
        }
        /* Search by status */
        if (isset($_POST['status']) && $_POST['status'] != '') {
            $sql = $this->db->where('status', $_POST['status']);
        }

        $sql = $this->db
            ->select($fieldArray)
            ->where('status !=', '9')
            ->order_by($fieldArray[$order_column], $order_dir);

        if ($length > 0) {
            $sql = $sql->limit($length, $start);
        }
        $records = $this->db->get()->result();
        $count = $this->db->select($fieldArray)
            ->from($table_name)
            ->where('status !=', '9')
            ->order_by($fieldArray[$order_column], $order_dir)->get()->num_rows();

        $array = json_decode(json_encode($records), true);

        $i = $start + 1;
        $data = array();
        foreach ($array as $key => $rows) {

            /*status*/

            if ($rows['status'] == 0) {
                $status = '<span class="label label-sm label-info">In-active</span>';
            } else {
                $status = '<span class="label label-sm label-success">Active</span>';
            }

            $short_content = (strlen($rows['answer']) > 100) ? substr($rows['answer'], 0, 100) . "..." : $rows['answer'];

            $data[] = array(

                '<input type="checkbox" value="' . $rows['id'] . '"  name="id[]">',
                $rows['question'],
                $short_content,
                $status,
                date('d/m/Y', strtotime($rows['created_at'])),
                '<a class="btn green btn-outline margin-bottom-5 padding-all7" title="Edit"  href="' . ADMIN_BASE_URL . $segment_first . '/' . $rows['id'] . '/edit' . '" ><i class="fa fa-edit"></i> </a>
                <a class="btn red btn-outline margin-bottom-5 padding-all7" title="Delete" href="javascript:;" onclick=" var ans = confirm( \' Are you sure you want to delete this record?\'); if( ans ){ window.location.href=\' ' . ADMIN_BASE_URL . $segment_first . '/' . $rows['id'] . '/delete' . '\'; }"><i class="fa fa-trash"></i></a>
                <a class="btn dark btn-outline margin-bottom-5 padding-all7" title="View"  href="' . ADMIN_BASE_URL . $segment_first . '/' . $rows['id'] . '/view' . '" ><i class="fa fa-bars"></i> </a>
                ',
            );
            $i++;
        }

        echo $this->common_response($_POST['draw'], $customActionStatus, $customActionMessage, $data, $count);
        exit;
    }

    /* Customer Details Ajax Function starts here */

    public function getCustomer_details()
    {
        $table_name = 'tbl_customer_details';
        $segment_first = 'customers/customer-details';

        $start = $_POST['start'];
        $length = $_POST['length'];
        $order_column = $_POST['order'][0]['column'];
        $order_dir = $_POST['order'][0]['dir'];
        $draw = $_POST['draw'];
        $skip = $draw - $length;
        if (!isset($start)) {
            redirect('404', 'refersh');
        }
        $fieldArray = array('id', 'first_name', 'last_name', 'email', 'status', 'username', 'created_at');
        $fieldArray = array_combine(range(1, count($fieldArray)), $fieldArray);

        $customActionStatus = "";
        $customActionMessage = "";

        if (isset($_POST['customActionType']) && $_POST['customActionType'] == 'group_action') {

            $permission = $this->admin_model->check_role_permission_ajax($_POST['customActionName'], $this->_type);

            if (!$permission) {

                $customActionStatus = "OK";
                $customActionMessage = "Permission not found.";

            } else {

                $this->db->where_in('id', $_POST['id']);
                $data = array(
                    'status' => $_POST['customActionName'],
                    'updated_at' => date('Y-m-d H:i:s'),
                );
                $updateData = $this->db->update($table_name, $data);

                if ($updateData) {
                    $customActionStatus = "OK";
                    $customActionMessage = "Group action successfully has been completed";
                }
            }

        }

        /* ## Search by functionality */

        /* Search by question */
        if (isset($_POST['name']) && $_POST['name'] != '') {
            $sql = $this->db->like('first_name', $_POST['name'], 'after');
        }

        if (isset($_POST['email']) && $_POST['email'] != '') {
            $sql = $this->db->like('email', $_POST['email'], 'after');
        }

        if (isset($_POST['username']) && $_POST['username'] != '') {
            $sql = $this->db->like('username', $_POST['username'], 'after');
        }

        $sql = $this->db->from($table_name);
        $to_date = date("Y-m-d");

        /* Search bt from created date */
        if ((isset($_POST['to_created_at']) && $_POST['to_created_at'] == '') && (isset($_POST['form_created_at']) && $_POST['form_created_at'] != '')) {
            $sql = $this->db->where('created_at >= "' . date('Y-m-d', strtotime(str_replace('/', '-', $_POST['form_created_at']))) . ' 00:00:00" AND "' . $to_date . ' 23:59:59"');
        }
        /* Search bt to created date */
        if ((isset($_POST['to_created_at']) && $_POST['to_created_at'] != '') && (isset($_POST['form_created_at']) && $_POST['form_created_at'] == '')) {
            $sql = $this->db->where('created_at <=', date('Y-m-d', strtotime(str_replace('/', '-', $_POST['to_created_at']))) . ' 23:59:59');
        }

        /* Search bt to and from created date */
        if ((isset($_POST['to_created_at']) && $_POST['to_created_at'] != '') && (isset($_POST['form_created_at']) && $_POST['form_created_at'] != '')) {
            $sql = $this->db->where('created_at >= "' . date('Y-m-d', strtotime(str_replace('/', '-', $_POST['form_created_at']))) . ' 00:00:00" AND created_at<="' . date('Y-m-d', strtotime(str_replace('/', '-', $_POST['to_created_at']))) . ' 23:59:59"');
        }
        /* Search by status */
        if (isset($_POST['status']) && $_POST['status'] != '') {
            $sql = $this->db->where('status', $_POST['status']);
        }

        $sql = $this->db
            ->select($fieldArray)
            ->where('status !=', '9')
            ->order_by($fieldArray[$order_column], $order_dir);

        if ($length > 0) {
            $sql = $sql->limit($length, $start);
        }
        $records = $this->db->get()->result();
        $count = $this->db->select($fieldArray)
            ->from($table_name)
            ->where('status !=', '9')
            ->order_by($fieldArray[$order_column], $order_dir)->get()->num_rows();

        $array = json_decode(json_encode($records), true);

        $i = $start + 1;
        $data = array();
        foreach ($array as $key => $rows) {

            /*status*/

            if ($rows['status'] == 0) {
                $status = '<span class="label label-sm label-info">In-active</span>';
            } else {
                $status = '<span class="label label-sm label-success">Active</span>';
            }

            $data[] = array(

                '<input type="checkbox" value="' . $rows['id'] . '"  name="id[]">',
                $rows['id'],
                ucfirst($rows['first_name']) . " " . ucfirst($rows['last_name']),
                $rows['username'],
                $rows['email'],
                $status,
                date('d/m/Y', strtotime($rows['created_at'])),
                '<a class="btn green btn-outline margin-bottom-5 padding-all7" title="Edit"  href="' . ADMIN_BASE_URL . $segment_first . '/' . $rows['id'] . '/edit' . '" ><i class="fa fa-edit"></i> </a>
                <!--<a class="btn red btn-outline margin-bottom-5 padding-all7" title="Delete" href="javascript:;" onclick=" var ans = confirm( \' Are you sure you want to delete this record?\'); if( ans ){ window.location.href=\' ' . ADMIN_BASE_URL . $segment_first . '/' . $rows['id'] . '/delete' . '\'; }"><i class="fa fa-trash"></i></a>-->
                <a class="btn dark btn-outline margin-bottom-5 padding-all7" title="View"  href="' . ADMIN_BASE_URL . $segment_first . '/' . $rows['id'] . '/view' . '" ><i class="fa fa-bars"></i> </a>
                ',
            );
            $i++;
        }

        echo $this->common_response($_POST['draw'], $customActionStatus, $customActionMessage, $data, $count);
        exit;
    }

    /* Customer Details Ajax Function ends here */

    /* Customer Details Ajax Function starts here */

//    t&c (terms and condition)
    public function getTc()
    {
        $table_name = 'tbl_tc';
        $segment_first = 'tc/tc';

        $start = $_POST['start'];
        $length = $_POST['length'];
        $order_column = $_POST['order'][0]['column'];
        $order_dir = $_POST['order'][0]['dir'];
        $draw = $_POST['draw'];
        $skip = $draw - $length;
        if (!isset($start)) {
            redirect('404', 'refersh');
        }
        $fieldArray = array('id', 'title', 'description', 'created_at', 'status');
        $fieldArray = array_combine(range(1, count($fieldArray)), $fieldArray);

        $customActionStatus = "";
        $customActionMessage = "";

        if (isset($_POST['customActionType']) && $_POST['customActionType'] == 'group_action') {

            $permission = $this->admin_model->check_role_permission_ajax($_POST['customActionName'], $this->_type);

            if (!$permission) {

                $customActionStatus = "OK";
                $customActionMessage = "Permission not found.";

            } else {

                $this->db->where_in('id', $_POST['id']);
                $data = array(
                    'status' => $_POST['customActionName'],
                    'updated_at' => date('Y-m-d H:i:s'),
                );
                $updateData = $this->db->update($table_name, $data);

                if ($updateData) {
                    $customActionStatus = "OK";
                    $customActionMessage = "Group action successfully has been completed";
                }
            }

        }

        /* ## Search by functionality */

        if (isset($_POST['title']) && $_POST['title'] != '') {
            $sql = $this->db->like('title', $_POST['title'], 'both');
        }
        /* Search by question */

        $sql = $this->db->from($table_name);
        $to_date = date("Y-m-d");

        /* Search bt from created date */
        if ((isset($_POST['to_created_at']) && $_POST['to_created_at'] == '') && (isset($_POST['form_created_at']) && $_POST['form_created_at'] != '')) {
            $sql = $this->db->where('created_at >= "' . date('Y-m-d', strtotime(str_replace('/', '-', $_POST['form_created_at']))) . ' 00:00:00" AND "' . $to_date . ' 23:59:59"');
        }
        /* Search bt to created date */
        if ((isset($_POST['to_created_at']) && $_POST['to_created_at'] != '') && (isset($_POST['form_created_at']) && $_POST['form_created_at'] == '')) {
            $sql = $this->db->where('created_at <=', date('Y-m-d', strtotime(str_replace('/', '-', $_POST['to_created_at']))) . ' 23:59:59');
        }

        /* Search bt to and from created date */
        if ((isset($_POST['to_created_at']) && $_POST['to_created_at'] != '') && (isset($_POST['form_created_at']) && $_POST['form_created_at'] != '')) {
            $sql = $this->db->where('created_at >= "' . date('Y-m-d', strtotime(str_replace('/', '-', $_POST['form_created_at']))) . ' 00:00:00" AND created_at<="' . date('Y-m-d', strtotime(str_replace('/', '-', $_POST['to_created_at']))) . ' 23:59:59"');
        }
        /* Search by status */
        if (isset($_POST['status']) && $_POST['status'] != '') {
            $sql = $this->db->where('status', $_POST['status']);
        }
        $sql = $this->db
            ->select($fieldArray)
            ->where('status !=', '9')
            ->order_by($fieldArray[$order_column], $order_dir);

        if ($length > 0) {
            $sql = $sql->limit($length, $start);
        }

        $records = $this->db->get()->result();
        $count = $this->db->select($fieldArray)
            ->from($table_name)
            ->where('status !=', '9')
            ->order_by($fieldArray[$order_column], $order_dir)->get()->num_rows();

        $array = json_decode(json_encode($records), true);

        $i = $start + 1;
        $data = array();
        foreach ($array as $key => $rows) {
            if ($rows['status'] == 0) {
                $status = '<span class="label label-sm label-info">In-active</span>';
            } else {
                $status = '<span class="label label-sm label-success">Active</span>';
            }

            $short_content = (strlen($rows['description']) > 100) ? substr($rows['description'], 0, 100) . "..." : $rows['description'];

            $data[] = array(
                '<input type="checkbox" value="' . $rows['id'] . '"  name="id[]">',
                $rows['title'],
                $short_content,
                $status,
                date('d/m/Y', strtotime($rows['created_at'])),
                '<a class="btn green btn-outline margin-bottom-5 padding-all7" title="Edit"  href="' . ADMIN_BASE_URL . $segment_first . '/' . $rows['id'] . '/edit' . '" ><i class="fa fa-edit"></i> </a>
                <a class="btn red btn-outline margin-bottom-5 padding-all7" title="Delete" href="javascript:;" onclick=" var ans = confirm( \' Are you sure you want to delete this record?\'); if( ans ){ window.location.href=\' ' . ADMIN_BASE_URL . $segment_first . '/' . $rows['id'] . '/delete' . '\'; }"><i class="fa fa-trash"></i></a>
                <a class="btn dark btn-outline margin-bottom-5 padding-all7" title="View"  href="' . ADMIN_BASE_URL . $segment_first . '/' . $rows['id'] . '/view' . '" ><i class="fa fa-bars"></i> </a>
                ');
            $i++;
        }

        echo $this->common_response($_POST['draw'], $customActionStatus, $customActionMessage, $data, $count);
        exit;

    }

    /*Newsletters Module*/

    public function getNewsletters()
    {
        $table_name = 'tbl_newsletter';
        $segment_first = 'newsletters/subscriber';

        $start = $_POST['start'];
        $length = $_POST['length'];
        $order_column = $_POST['order'][0]['column'];
        $order_dir = $_POST['order'][0]['dir'];
        $draw = $_POST['draw'];
        $skip = $draw - $length;
        if (!isset($start)) {
            redirect('404', 'refersh');
        }
        $fieldArray = array('tbl_newsletter.id', 'tbl_newsletter.email_id', 'tbl_newsletter.ip_address', 'tbl_newsletter.status', 'tbl_newsletter.created_at');
        $fieldArray = array_combine(range(1, count($fieldArray)), $fieldArray);

        $customActionStatus = "";
        $customActionMessage = "";

        if (isset($_POST['customActionType']) && $_POST['customActionType'] == 'group_action') {

            $permission = $this->admin_model->check_role_permission_ajax($_POST['customActionName'], $this->_type);

            if (!$permission) {

                $customActionStatus = "OK";
                $customActionMessage = "Permission not found.";

            } else {

                $this->db->where_in('tbl_newsletter.id', $_POST['id']);
                $data = array(
                    'status' => $_POST['customActionName'],
                    'updated_at' => date('Y-m-d H:i:s'),
                );
                $updateData = $this->db->update($table_name, $data);

                if ($updateData) {
                    $customActionStatus = "OK";
                    $customActionMessage = "Group action successfully has been completed";
                }
            }

        }

        /* ## Search by functionality */

        /* Search by question */

        if (isset($_POST['email']) && $_POST['email'] != '') {
            $sql = $this->db->like('tbl_newsletter.email_id', $_POST['email'], 'after');
        }

        $sql = $this->db->from($table_name);
        $to_date = date("Y-m-d");

        /* Search bt from created date */
        if ((isset($_POST['to_created_at']) && $_POST['to_created_at'] == '') && (isset($_POST['form_created_at']) && $_POST['form_created_at'] != '')) {
            $sql = $this->db->where('tbl_newsletter.created_at >= "' . date('Y-m-d', strtotime(str_replace('/', '-', $_POST['form_created_at']))) . ' 00:00:00" AND "' . $to_date . ' 23:59:59"');
        }
        /* Search bt to created date */
        if ((isset($_POST['to_created_at']) && $_POST['to_created_at'] != '') && (isset($_POST['form_created_at']) && $_POST['form_created_at'] == '')) {
            $sql = $this->db->where('tbl_newsletter.created_at <=', date('Y-m-d', strtotime(str_replace('/', '-', $_POST['to_created_at']))) . ' 23:59:59');
        }

        /* Search bt to and from created date */
        if ((isset($_POST['to_created_at']) && $_POST['to_created_at'] != '') && (isset($_POST['form_created_at']) && $_POST['form_created_at'] != '')) {
            $sql = $this->db->where('tbl_newsletter.created_at >= "' . date('Y-m-d', strtotime(str_replace('/', '-', $_POST['form_created_at']))) . ' 00:00:00" AND tbl_newsletter.created_at<="' . date('Y-m-d', strtotime(str_replace('/', '-', $_POST['to_created_at']))) . ' 23:59:59"');
        }
        /* Search by status */
        if (isset($_POST['tbl_newsletter.status']) && $_POST['status'] != '') {
            $sql = $this->db->where('tbl_newsletter.status', $_POST['status']);
        }

        if ($this->_type == 'user') {

            $sql = $this->db
                ->select($fieldArray)
                ->where('tbl_newsletter.status !=', '9')
                ->order_by($fieldArray[$order_column], $order_dir);

            if ($length > 0) {
                $sql = $sql->limit($length, $start);
            }
            $records = $this->db->get()->result();
            $count = $this->db->select($fieldArray)
                ->from($table_name)
                ->where('tbl_newsletter.status !=', '9')
                ->order_by($fieldArray[$order_column], $order_dir)->get()->num_rows();

        } else {

            $sql = $this->db
                ->select($fieldArray)
                ->where('tbl_newsletter.status !=', '9')
                ->order_by($fieldArray[$order_column], $order_dir);

            if ($length > 0) {
                $sql = $sql->limit($length, $start);
            }
            $records = $this->db->get()->result();
            $count = $this->db->select($fieldArray)
                ->from($table_name)
                ->where('tbl_newsletter.status !=', '9')
                ->order_by($fieldArray[$order_column], $order_dir)->get()->num_rows();
        }

        $array = json_decode(json_encode($records), true);

        $i = $start + 1;
        $data = array();
        foreach ($array as $key => $rows) {

            /*status*/

            if ($rows['status'] == 0) {
                $status = '<span class="label label-sm label-info">In-active</span>';
            } else {
                $status = '<span class="label label-sm label-success">Active</span>';
            }

            $data[] = array(

                '<input type="checkbox" value="' . $rows['id'] . '"  name="id[]">',
                $rows['email_id'],
                $rows['ip_address'],
                $status,
                date('d/m/Y', strtotime($rows['created_at'])),
                '<a class="btn red btn-outline margin-bottom-5 padding-all7" title="Delete" href="javascript:;" onclick=" var ans = confirm( \' Are you sure you want to delete this record?\'); if( ans ){ window.location.href=\' ' . ADMIN_BASE_URL . $segment_first . '/' . $rows['id'] . '/delete' . '\'; }"><i class="fa fa-trash"></i></a>
                ',
            );
            $i++;
        }

        echo $this->common_response($_POST['draw'], $customActionStatus, $customActionMessage, $data, $count);
        exit;
    }

    public function getContact_us()
    {
        $table_name = 'tbl_contact';
        $segment_first = 'contact-us/contact-us';

        $start = $_POST['start'];
        $length = $_POST['length'];
        $order_column = $_POST['order'][0]['column'];
        $order_dir = $_POST['order'][0]['dir'];
        $draw = $_POST['draw'];
        $skip = $draw - $length;
        if (!isset($start)) {
            redirect('404', 'refersh');
        }
        $fieldArray = array('id', 'name', 'email', 'message', 'created_at', 'status');
        $fieldArray = array_combine(range(1, count($fieldArray)), $fieldArray);

        $customActionStatus = "";
        $customActionMessage = "";

        if (isset($_POST['customActionType']) && $_POST['customActionType'] == 'group_action') {

            $permission = $this->admin_model->check_role_permission_ajax($_POST['customActionName'], $this->_type);

            if (!$permission) {

                $customActionStatus = "OK";
                $customActionMessage = "Permission not found.";

            } else {

                $this->db->where_in('id', $_POST['id']);
                $data = array(
                    'status' => $_POST['customActionName'],
                    'updated_at' => date('Y-m-d H:i:s'),
                );
                $updateData = $this->db->update($table_name, $data);

                if ($updateData) {
                    $customActionStatus = "OK";
                    $customActionMessage = "Group action successfully has been completed";
                }
            }

        }

        /* ## Search by functionality */

        /*if( isset( $_POST['button_name'] ) && $_POST['button_name'] != '' ){
        $sql = $this->db->like('button_name', $_POST['button_name'], 'both');
        }

        if( isset( $_POST['title'] ) && $_POST['title'] != '' ){
        $sql = $this->db->like('title', $_POST['title'], 'both');
        }*/
        /* Search by question */

        $sql = $this->db->from($table_name);
        $to_date = date("Y-m-d");

        /* Search bt from created date */
        if ((isset($_POST['to_created_at']) && $_POST['to_created_at'] == '') && (isset($_POST['form_created_at']) && $_POST['form_created_at'] != '')) {
            $sql = $this->db->where('created_at >= "' . date('Y-m-d', strtotime(str_replace('/', '-', $_POST['form_created_at']))) . ' 00:00:00" AND "' . $to_date . ' 23:59:59"');
        }
        /* Search bt to created date */
        if ((isset($_POST['to_created_at']) && $_POST['to_created_at'] != '') && (isset($_POST['form_created_at']) && $_POST['form_created_at'] == '')) {
            $sql = $this->db->where('created_at <=', date('Y-m-d', strtotime(str_replace('/', '-', $_POST['to_created_at']))) . ' 23:59:59');
        }

        /* Search bt to and from created date */
        if ((isset($_POST['to_created_at']) && $_POST['to_created_at'] != '') && (isset($_POST['form_created_at']) && $_POST['form_created_at'] != '')) {
            $sql = $this->db->where('created_at >= "' . date('Y-m-d', strtotime(str_replace('/', '-', $_POST['form_created_at']))) . ' 00:00:00" AND created_at<="' . date('Y-m-d', strtotime(str_replace('/', '-', $_POST['to_created_at']))) . ' 23:59:59"');
        }
        /* Search by status */
        if (isset($_POST['status']) && $_POST['status'] != '') {
            $sql = $this->db->where('status', $_POST['status']);
        }
        $sql = $this->db
            ->select($fieldArray)
            ->where('status !=', '9')
            ->order_by($fieldArray[$order_column], $order_dir);

        if ($length > 0) {
            $sql = $sql->limit($length, $start);
        }

        $records = $this->db->get()->result();
        $count = $this->db->select($fieldArray)
            ->from($table_name)
            ->where('status !=', '9')
            ->order_by($fieldArray[$order_column], $order_dir)->get()->num_rows();

        $array = json_decode(json_encode($records), true);

        $i = $start + 1;
        $data = array();
        foreach ($array as $key => $rows) {
            if ($rows['status'] == 0) {
                $status = '<span class="label label-sm label-info">In-active</span>';
            } else {
                $status = '<span class="label label-sm label-success">Active</span>';
            }

            $short_content = (strlen($rows['message']) > 100) ? substr($rows['message'], 0, 100) . "..." : $rows['message'];

            $data[] = array(
                '<input type="checkbox" value="' . $rows['id'] . '"  name="id[]">',
                $rows['name'],
                $rows['email'],
                $short_content,
                $status,
                date('d/m/Y', strtotime($rows['created_at'])),
                '<a class="btn red btn-outline margin-bottom-5 padding-all7" title="Delete" href="javascript:;" onclick=" var ans = confirm( \' Are you sure you want to delete this record?\'); if( ans ){ window.location.href=\' ' . ADMIN_BASE_URL . $segment_first . '/' . $rows['id'] . '/delete' . '\'; }"><i class="fa fa-trash"></i></a>
                <a class="btn dark btn-outline margin-bottom-5 padding-all7" title="View"  href="' . ADMIN_BASE_URL . $segment_first . '/' . $rows['id'] . '/view' . '" ><i class="fa fa-bars"></i> </a>
                ');
            $i++;
        }

        echo $this->common_response($_POST['draw'], $customActionStatus, $customActionMessage, $data, $count);
        exit;

    }

//    about_us
    public function getAbout_us()
    {
        $table_name = 'tbl_about_us';
        $segment_first = 'about-us/about-us';

        $start = $_POST['start'];
        $length = $_POST['length'];
        $order_column = $_POST['order'][0]['column'];
        $order_dir = $_POST['order'][0]['dir'];
        $draw = $_POST['draw'];
        $skip = $draw - $length;
        if (!isset($start)) {
            redirect('404', 'refersh');
        }
        $fieldArray = array('id', 'image', 'description', 'created_at', 'status');
        $fieldArray = array_combine(range(1, count($fieldArray)), $fieldArray);

        $customActionStatus = "";
        $customActionMessage = "";

        if (isset($_POST['customActionType']) && $_POST['customActionType'] == 'group_action') {

            $permission = $this->admin_model->check_role_permission_ajax($_POST['customActionName'], $this->_type);

            if (!$permission) {

                $customActionStatus = "OK";
                $customActionMessage = "Permission not found.";

            } else {

                $this->db->where_in('id', $_POST['id']);
                $data = array(
                    'status' => $_POST['customActionName'],
                    'updated_at' => date('Y-m-d H:i:s'),
                );
                $updateData = $this->db->update($table_name, $data);

                if ($updateData) {
                    $customActionStatus = "OK";
                    $customActionMessage = "Group action successfully has been completed";
                }
            }

        }

        /* ## Search by functionality */

        if (isset($_POST['description']) && $_POST['description'] != '') {
            $sql = $this->db->like('description', $_POST['description'], 'both');
        }
        /* Search by question */

        $sql = $this->db->from($table_name);
        $to_date = date("Y-m-d");

        /* Search bt from created date */
        if ((isset($_POST['to_created_at']) && $_POST['to_created_at'] == '') && (isset($_POST['form_created_at']) && $_POST['form_created_at'] != '')) {
            $sql = $this->db->where('created_at >= "' . date('Y-m-d', strtotime(str_replace('/', '-', $_POST['form_created_at']))) . ' 00:00:00" AND "' . $to_date . ' 23:59:59"');
        }
        /* Search bt to created date */
        if ((isset($_POST['to_created_at']) && $_POST['to_created_at'] != '') && (isset($_POST['form_created_at']) && $_POST['form_created_at'] == '')) {
            $sql = $this->db->where('created_at <=', date('Y-m-d', strtotime(str_replace('/', '-', $_POST['to_created_at']))) . ' 23:59:59');
        }

        /* Search bt to and from created date */
        if ((isset($_POST['to_created_at']) && $_POST['to_created_at'] != '') && (isset($_POST['form_created_at']) && $_POST['form_created_at'] != '')) {
            $sql = $this->db->where('created_at >= "' . date('Y-m-d', strtotime(str_replace('/', '-', $_POST['form_created_at']))) . ' 00:00:00" AND created_at<="' . date('Y-m-d', strtotime(str_replace('/', '-', $_POST['to_created_at']))) . ' 23:59:59"');
        }
        /* Search by status */
        if (isset($_POST['status']) && $_POST['status'] != '') {
            $sql = $this->db->where('status', $_POST['status']);
        }
        $sql = $this->db
            ->select($fieldArray)
            ->where('status !=', '9')
            ->order_by($fieldArray[$order_column], $order_dir);

        if ($length > 0) {
            $sql = $sql->limit($length, $start);
        }

        $records = $this->db->get()->result();
        $count = $this->db->select($fieldArray)
            ->from($table_name)
            ->where('status !=', '9')
            ->order_by($fieldArray[$order_column], $order_dir)->get()->num_rows();

        $array = json_decode(json_encode($records), true);

        $i = $start + 1;
        $data = array();
        foreach ($array as $key => $rows) {
            if ($rows['status'] == 0) {
                $status = '<span class="label label-sm label-info">In-active</span>';
            } else {
                $status = '<span class="label label-sm label-success">Active</span>';
            }

            $images = explode(",", $rows['image']);
            $image = '';
            foreach ($images as $key => $value) {
                if ($value == "") {
                    $image = '<img width="80px" height="80px" src="' . DEFAULT_IMAGE . '">';
                } else {
                    $image = '<img width="120px" height="80px" src="' . ABOUT_US_IMG_URL . $value . '">';
                }
            }

            $short_content = (strlen($rows['description']) > 100) ? substr($rows['description'], 0, 100) . "..." : $rows['description'];

            $data[] = array(
                '<input type="checkbox" value="' . $rows['id'] . '"  name="id[]">',
                $short_content,
                $image,
                $status,
                date('d/m/Y', strtotime($rows['created_at'])),
                '<a class="btn green btn-outline margin-bottom-5 padding-all7" title="Edit"  href="' . ADMIN_BASE_URL . $segment_first . '/' . $rows['id'] . '/edit' . '" ><i class="fa fa-edit"></i> </a>
                <a class="btn red btn-outline margin-bottom-5 padding-all7" title="Delete" href="javascript:;" onclick=" var ans = confirm( \' Are you sure you want to delete this record?\'); if( ans ){ window.location.href=\' ' . ADMIN_BASE_URL . $segment_first . '/' . $rows['id'] . '/delete' . '\'; }"><i class="fa fa-trash"></i></a>
                <a class="btn dark btn-outline margin-bottom-5 padding-all7" title="View"  href="' . ADMIN_BASE_URL . $segment_first . '/' . $rows['id'] . '/view' . '" ><i class="fa fa-bars"></i> </a>
                ');
            $i++;
        }

        echo $this->common_response($_POST['draw'], $customActionStatus, $customActionMessage, $data, $count);
        exit;

    }

    public function getwhy_choose_us()
    {
        $table_name = 'tbl_why_choose_us';
        $segment_first = 'about-us/why-choose-us';

        $start = $_POST['start'];
        $length = $_POST['length'];
        $order_column = $_POST['order'][0]['column'];
        $order_dir = $_POST['order'][0]['dir'];
        $draw = $_POST['draw'];
        $skip = $draw - $length;
        if (!isset($start)) {
            redirect('404', 'refersh');
        }
        $fieldArray = array('id', 'title', 'image', 'created_at', 'status');
        $fieldArray = array_combine(range(1, count($fieldArray)), $fieldArray);

        $customActionStatus = "";
        $customActionMessage = "";

        if (isset($_POST['customActionType']) && $_POST['customActionType'] == 'group_action') {

            $permission = $this->admin_model->check_role_permission_ajax($_POST['customActionName'], $this->_type);

            if (!$permission) {

                $customActionStatus = "OK";
                $customActionMessage = "Permission not found.";

            } else {

                $this->db->where_in('id', $_POST['id']);
                $data = array(
                    'status' => $_POST['customActionName'],
                    'updated_at' => date('Y-m-d H:i:s'),
                );
                $updateData = $this->db->update($table_name, $data);

                if ($updateData) {
                    $customActionStatus = "OK";
                    $customActionMessage = "Group action successfully has been completed";
                }
            }

        }

        /* ## Search by functionality */

        if (isset($_POST['title']) && $_POST['title'] != '') {
            $sql = $this->db->like('title', $_POST['title'], 'both');
        }
        /* Search by question */

        $sql = $this->db->from($table_name);
        $to_date = date("Y-m-d");

        /* Search bt from created date */
        if ((isset($_POST['to_created_at']) && $_POST['to_created_at'] == '') && (isset($_POST['form_created_at']) && $_POST['form_created_at'] != '')) {
            $sql = $this->db->where('created_at >= "' . date('Y-m-d', strtotime(str_replace('/', '-', $_POST['form_created_at']))) . ' 00:00:00" AND "' . $to_date . ' 23:59:59"');
        }
        /* Search bt to created date */
        if ((isset($_POST['to_created_at']) && $_POST['to_created_at'] != '') && (isset($_POST['form_created_at']) && $_POST['form_created_at'] == '')) {
            $sql = $this->db->where('created_at <=', date('Y-m-d', strtotime(str_replace('/', '-', $_POST['to_created_at']))) . ' 23:59:59');
        }

        /* Search bt to and from created date */
        if ((isset($_POST['to_created_at']) && $_POST['to_created_at'] != '') && (isset($_POST['form_created_at']) && $_POST['form_created_at'] != '')) {
            $sql = $this->db->where('created_at >= "' . date('Y-m-d', strtotime(str_replace('/', '-', $_POST['form_created_at']))) . ' 00:00:00" AND created_at<="' . date('Y-m-d', strtotime(str_replace('/', '-', $_POST['to_created_at']))) . ' 23:59:59"');
        }
        /* Search by status */
        if (isset($_POST['status']) && $_POST['status'] != '') {
            $sql = $this->db->where('status', $_POST['status']);
        }
        $sql = $this->db
            ->select($fieldArray)
            ->where('status !=', '9')
            ->order_by($fieldArray[$order_column], $order_dir);

        if ($length > 0) {
            $sql = $sql->limit($length, $start);
        }

        $records = $this->db->get()->result();
        $count = $this->db->select($fieldArray)
            ->from($table_name)
            ->where('status !=', '9')
            ->order_by($fieldArray[$order_column], $order_dir)->get()->num_rows();

        $array = json_decode(json_encode($records), true);

        $i = $start + 1;
        $data = array();
        foreach ($array as $key => $rows) {
            if ($rows['status'] == 0) {
                $status = '<span class="label label-sm label-info">In-active</span>';
            } else {
                $status = '<span class="label label-sm label-success">Active</span>';
            }

            $images = explode(",", $rows['image']);
            $image = '';
            foreach ($images as $key => $value) {
                if ($value == "") {
                    $image = '<img width="80px" height="80px" src="' . DEFAULT_IMAGE . '">';
                } else {
                    $image = '<img width="80px" height="80px" src="' . ABOUT_US_IMG_URL . $value . '">';
                }
            }

            $data[] = array(
                '<input type="checkbox" value="' . $rows['id'] . '"  name="id[]">',
                $rows['title'],
                $image,
                $status,
                date('d/m/Y', strtotime($rows['created_at'])),
                '<a class="btn green btn-outline margin-bottom-5 padding-all7" title="Edit"  href="' . ADMIN_BASE_URL . $segment_first . '/' . $rows['id'] . '/edit' . '" ><i class="fa fa-edit"></i> </a>
                <a class="btn red btn-outline margin-bottom-5 padding-all7" title="Delete" href="javascript:;" onclick=" var ans = confirm( \' Are you sure you want to delete this record?\'); if( ans ){ window.location.href=\' ' . ADMIN_BASE_URL . $segment_first . '/' . $rows['id'] . '/delete' . '\'; }"><i class="fa fa-trash"></i></a>
                ');
            $i++;
        }

        echo $this->common_response($_POST['draw'], $customActionStatus, $customActionMessage, $data, $count);
        exit;

    }

    // counter
    public function getCounter()
    {
        $table_name = 'tbl_counter';
        $segment_first = 'about-us/counter';

        $start = $_POST['start'];
        $length = $_POST['length'];
        $order_column = $_POST['order'][0]['column'];
        $order_dir = $_POST['order'][0]['dir'];
        $draw = $_POST['draw'];
        $skip = $draw - $length;
        if (!isset($start)) {
            redirect('404', 'refersh');
        }
        $fieldArray = array('id', 'image', 'title', 'counter_value', 'created_at', 'status');
        $fieldArray = array_combine(range(1, count($fieldArray)), $fieldArray);

        $customActionStatus = "";
        $customActionMessage = "";

        if (isset($_POST['customActionType']) && $_POST['customActionType'] == 'group_action') {

            $permission = $this->admin_model->check_role_permission_ajax($_POST['customActionName'], $this->_type);

            if (!$permission) {

                $customActionStatus = "OK";
                $customActionMessage = "Permission not found.";

            } else {

                $this->db->where_in('id', $_POST['id']);
                $data = array(
                    'status' => $_POST['customActionName'],
                    'updated_at' => date('Y-m-d H:i:s'),
                );
                $updateData = $this->db->update($table_name, $data);

                if ($updateData) {
                    $customActionStatus = "OK";
                    $customActionMessage = "Group action successfully has been completed";
                }
            }

        }

        /* ## Search by functionality */

        if (isset($_POST['title']) && $_POST['title'] != '') {
            $sql = $this->db->like('title', $_POST['title'], 'both');
        }
        /* Search by question */

        $sql = $this->db->from($table_name);
        $to_date = date("Y-m-d");

        /* Search bt from created date */
        if ((isset($_POST['to_created_at']) && $_POST['to_created_at'] == '') && (isset($_POST['form_created_at']) && $_POST['form_created_at'] != '')) {
            $sql = $this->db->where('created_at >= "' . date('Y-m-d', strtotime(str_replace('/', '-', $_POST['form_created_at']))) . ' 00:00:00" AND "' . $to_date . ' 23:59:59"');
        }
        /* Search bt to created date */
        if ((isset($_POST['to_created_at']) && $_POST['to_created_at'] != '') && (isset($_POST['form_created_at']) && $_POST['form_created_at'] == '')) {
            $sql = $this->db->where('created_at <=', date('Y-m-d', strtotime(str_replace('/', '-', $_POST['to_created_at']))) . ' 23:59:59');
        }

        /* Search bt to and from created date */
        if ((isset($_POST['to_created_at']) && $_POST['to_created_at'] != '') && (isset($_POST['form_created_at']) && $_POST['form_created_at'] != '')) {
            $sql = $this->db->where('created_at >= "' . date('Y-m-d', strtotime(str_replace('/', '-', $_POST['form_created_at']))) . ' 00:00:00" AND created_at<="' . date('Y-m-d', strtotime(str_replace('/', '-', $_POST['to_created_at']))) . ' 23:59:59"');
        }
        /* Search by status */
        if (isset($_POST['status']) && $_POST['status'] != '') {
            $sql = $this->db->where('status', $_POST['status']);
        }
        $sql = $this->db
            ->select($fieldArray)
            ->where('status !=', '9')
            ->order_by($fieldArray[$order_column], $order_dir);

        if ($length > 0) {
            $sql = $sql->limit($length, $start);
        }

        $records = $this->db->get()->result();
        $count = $this->db->select($fieldArray)
            ->from($table_name)
            ->where('status !=', '9')
            ->order_by($fieldArray[$order_column], $order_dir)->get()->num_rows();

        $array = json_decode(json_encode($records), true);

        $i = $start + 1;
        $data = array();
        foreach ($array as $key => $rows) {
            if ($rows['status'] == 0) {
                $status = '<span class="label label-sm label-info">In-active</span>';
            } else {
                $status = '<span class="label label-sm label-success">Active</span>';
            }

            $images = explode(",", $rows['image']);
            $image = '';
            foreach ($images as $key => $value) {
                if ($value == "") {
                    $image = '<img width="80px" height="80px" src="' . DEFAULT_IMAGE . '">';
                } else {
                    $image = '<img width="80px" height="80px" src="' . ABOUT_US_IMG_URL . $value . '">';
                }
            }
            $data[] = array(
                '<input type="checkbox" value="' . $rows['id'] . '"  name="id[]">',
                $image,
                $rows['title'],
                $rows['counter_value'],
                $status,
                date('d/m/Y', strtotime($rows['created_at'])),
                '<a class="btn green btn-outline margin-bottom-5 padding-all7" title="Edit"  href="' . ADMIN_BASE_URL . $segment_first . '/' . $rows['id'] . '/edit' . '" ><i class="fa fa-edit"></i> </a>
                <a class="btn red btn-outline margin-bottom-5 padding-all7" title="Delete" href="javascript:;" onclick=" var ans = confirm( \' Are you sure you want to delete this record?\'); if( ans ){ window.location.href=\' ' . ADMIN_BASE_URL . $segment_first . '/' . $rows['id'] . '/delete' . '\'; }"><i class="fa fa-trash"></i></a>
                ');
            $i++;
        }

        echo $this->common_response($_POST['draw'], $customActionStatus, $customActionMessage, $data, $count);
        exit;
    }

    /*product category*/
    public function getProduct_category()
    {
        $table_name = 'tbl_product_category';
        $segment_first = 'product/category';

        $start = $_POST['start'];
        $length = $_POST['length'];
        $order_column = $_POST['order'][0]['column'];
        $order_dir = $_POST['order'][0]['dir'];
        $draw = $_POST['draw'];
        $skip = $draw - $length;
        if (!isset($start)) {
            redirect('404', 'refersh');
        }
        $fieldArray = array('id', 'category_name', 'created_at', 'status');
        $fieldArray = array_combine(range(1, count($fieldArray)), $fieldArray);

        $customActionStatus = "";
        $customActionMessage = "";

        if (isset($_POST['customActionType']) && $_POST['customActionType'] == 'group_action') {

            $permission = $this->admin_model->check_role_permission_ajax($_POST['customActionName'], $this->_type);

            if (!$permission) {

                $customActionStatus = "OK";
                $customActionMessage = "Permission not found.";

            } else {

                $this->db->where_in('id', $_POST['id']);
                $data = array(
                    'status' => $_POST['customActionName'],
                    'updated_at' => date('Y-m-d H:i:s'),
                );
                $updateData = $this->db->update($table_name, $data);

                if ($updateData) {
                    $customActionStatus = "OK";
                    $customActionMessage = "Group action successfully has been completed";
                }
            }

        }

        /* ## Search by functionality */

        if (isset($_POST['category_name']) && $_POST['category_name'] != '') {
            $sql = $this->db->like('category_name', $_POST['category_name'], 'both');
        }
        /* Search by question */

        $sql = $this->db->from($table_name);
        $to_date = date("Y-m-d");

        /* Search bt from created date */
        if ((isset($_POST['to_created_at']) && $_POST['to_created_at'] == '') && (isset($_POST['form_created_at']) && $_POST['form_created_at'] != '')) {
            $sql = $this->db->where('created_at >= "' . date('Y-m-d', strtotime(str_replace('/', '-', $_POST['form_created_at']))) . ' 00:00:00" AND "' . $to_date . ' 23:59:59"');
        }
        /* Search bt to created date */
        if ((isset($_POST['to_created_at']) && $_POST['to_created_at'] != '') && (isset($_POST['form_created_at']) && $_POST['form_created_at'] == '')) {
            $sql = $this->db->where('created_at <=', date('Y-m-d', strtotime(str_replace('/', '-', $_POST['to_created_at']))) . ' 23:59:59');
        }

        /* Search bt to and from created date */
        if ((isset($_POST['to_created_at']) && $_POST['to_created_at'] != '') && (isset($_POST['form_created_at']) && $_POST['form_created_at'] != '')) {
            $sql = $this->db->where('created_at >= "' . date('Y-m-d', strtotime(str_replace('/', '-', $_POST['form_created_at']))) . ' 00:00:00" AND created_at<="' . date('Y-m-d', strtotime(str_replace('/', '-', $_POST['to_created_at']))) . ' 23:59:59"');
        }
        /* Search by status */
        if (isset($_POST['status']) && $_POST['status'] != '') {
            $sql = $this->db->where('status', $_POST['status']);
        }
        $sql = $this->db
            ->select($fieldArray)
            ->where('status !=', '9')
            ->order_by($fieldArray[$order_column], $order_dir);

        if ($length > 0) {
            $sql = $sql->limit($length, $start);
        }

        $records = $this->db->get()->result();
        $count = $this->db->select($fieldArray)
            ->from($table_name)
            ->where('status !=', '9')
            ->order_by($fieldArray[$order_column], $order_dir)->get()->num_rows();

        $array = json_decode(json_encode($records), true);

        $i = $start + 1;
        $data = array();
        foreach ($array as $key => $rows) {
            if ($rows['status'] == 0) {
                $status = '<span class="label label-sm label-info">In-active</span>';
            } else {
                $status = '<span class="label label-sm label-success">Active</span>';
            }

            /*$images = explode(",", $rows['category_image']);
            $image = '';
            foreach ($images as $key => $value) {
            if ($value == "") {
            $image = '<img width="80px" height="80px" src="' . DEFAULT_IMAGE . '">';
            } else {
            $image = '<img width="80px" height="80px" src="' . PRODUCT_CATEGORY_IMG_URL . $value . '">';
            }
            }*/

            $data[] = array(
                '<input type="checkbox" value="' . $rows['id'] . '"  name="id[]">',
                $rows['category_name'],
                /*$image,*/
                $status,
                date('d/m/Y', strtotime($rows['created_at'])),
                '<a class="btn green btn-outline margin-bottom-5 padding-all7" title="Edit"  href="' . ADMIN_BASE_URL . $segment_first . '/' . $rows['id'] . '/edit' . '" ><i class="fa fa-edit"></i> </a>
                <a class="btn red btn-outline margin-bottom-5 padding-all7" title="Delete" href="javascript:;" onclick=" var ans = confirm( \' Are you sure you want to delete this record?\'); if( ans ){ window.location.href=\' ' . ADMIN_BASE_URL . $segment_first . '/' . $rows['id'] . '/delete' . '\'; }"><i class="fa fa-trash"></i></a>
                ');
            $i++;
        }

        echo $this->common_response($_POST['draw'], $customActionStatus, $customActionMessage, $data, $count);
        exit;
    }

    public function getProduct_subcategory()
    {
        $table_name = 'tbl_product_subcategory';
        $segment_first = 'product/sub-category';

        $start = $_POST['start'];
        $length = $_POST['length'];
        $order_column = $_POST['order'][0]['column'];
        $order_dir = $_POST['order'][0]['dir'];
        $draw = $_POST['draw'];
        $skip = $draw - $length;
        if (!isset($start)) {
            redirect('404', 'refersh');
        }
        $fieldArray = array('tbl_product_subcategory.id', 'tbl_product_category.category_name', 'tbl_product_subcategory.sub_category_name', 'tbl_product_subcategory.created_at', 'tbl_product_subcategory.status');
        $fieldArray = array_combine(range(1, count($fieldArray)), $fieldArray);

        $customActionStatus = "";
        $customActionMessage = "";

        if (isset($_POST['customActionType']) && $_POST['customActionType'] == 'group_action') {

            $permission = $this->admin_model->check_role_permission_ajax($_POST['customActionName'], $this->_type);

            if (!$permission) {

                $customActionStatus = "OK";
                $customActionMessage = "Permission not found.";

            } else {

                $this->db->where_in('tbl_product_subcategory.id', $_POST['id']);
                $data = array(
                    'tbl_product_subcategory.status' => $_POST['customActionName'],
                    'tbl_product_subcategory.updated_at' => date('Y-m-d H:i:s'),
                );
                $updateData = $this->db->update($table_name, $data);

                if ($updateData) {
                    $customActionStatus = "OK";
                    $customActionMessage = "Group action successfully has been completed";
                }
            }

        }

        /* ## Search by functionality */

        if (isset($_POST['sub_category_name']) && $_POST['sub_category_name'] != '') {
            $sql = $this->db->like('tbl_product_subcategory.sub_category_name', $_POST['sub_category_name'], 'both');
        }
        /* Search by question */

        $sql = $this->db->from($table_name);
        $to_date = date("Y-m-d");

        /* Search bt from created date */
        if ((isset($_POST['to_created_at']) && $_POST['to_created_at'] == '') && (isset($_POST['form_created_at']) && $_POST['form_created_at'] != '')) {
            $sql = $this->db->where('tbl_product_subcategory.created_at >= "' . date('Y-m-d', strtotime(str_replace('/', '-', $_POST['form_created_at']))) . ' 00:00:00" AND "' . $to_date . ' 23:59:59"');
        }
        /* Search bt to created date */
        if ((isset($_POST['to_created_at']) && $_POST['to_created_at'] != '') && (isset($_POST['form_created_at']) && $_POST['form_created_at'] == '')) {
            $sql = $this->db->where('tbl_product_subcategory.created_at <=', date('Y-m-d', strtotime(str_replace('/', '-', $_POST['to_created_at']))) . ' 23:59:59');
        }

        /* Search bt to and from created date */
        if ((isset($_POST['to_created_at']) && $_POST['to_created_at'] != '') && (isset($_POST['form_created_at']) && $_POST['form_created_at'] != '')) {
            $sql = $this->db->where('tbl_product_subcategory.created_at >= "' . date('Y-m-d', strtotime(str_replace('/', '-', $_POST['form_created_at']))) . ' 00:00:00" AND tbl_product_subcategory.created_at<="' . date('Y-m-d', strtotime(str_replace('/', '-', $_POST['to_created_at']))) . ' 23:59:59"');
        }
        /* Search by status */
        if (isset($_POST['status']) && $_POST['status'] != '') {
            $sql = $this->db->where('tbl_product_subcategory.status', $_POST['status']);
        }
        $sql = $this->db
            ->select($fieldArray)
            ->join('tbl_product_category', 'tbl_product_category.id = tbl_product_subcategory.category_id', 'left')
            ->where('tbl_product_subcategory.status !=', '9')
            ->order_by($fieldArray[$order_column], $order_dir);

        if ($length > 0) {
            $sql = $sql->limit($length, $start);
        }

        $records = $this->db->get()->result();
        $count = $this->db->select($fieldArray)
            ->from($table_name)
            ->join('tbl_product_category', 'tbl_product_category.id = tbl_product_subcategory.category_id', 'left')
            ->where('tbl_product_subcategory.status !=', '9')
            ->order_by($fieldArray[$order_column], $order_dir)->get()->num_rows();

        $array = json_decode(json_encode($records), true);

        $i = $start + 1;
        $data = array();
        foreach ($array as $key => $rows) {
            if ($rows['status'] == 0) {
                $status = '<span class="label label-sm label-info">In-active</span>';
            } else {
                $status = '<span class="label label-sm label-success">Active</span>';
            }

            /*$images = explode(",", $rows['sub_category_image']);
            $image = '';
            foreach ($images as $key => $value) {
            if ($value == "") {
            $image = '<img width="80px" height="80px" src="' . DEFAULT_IMAGE . '">';
            } else {
            $image = '<img width="80px" height="80px" src="' . PRODUCT_SUBCATEGORY_IMG_URL . $value . '">';
            }
            }*/
            $data[] = array(
                '<input type="checkbox" value="' . $rows['id'] . '" name="id[]">',
                $rows['category_name'],
                $rows['sub_category_name'],
                /*$image,*/
                $status,
                date('d/m/Y', strtotime($rows['created_at'])),
                '<a class="btn green btn-outline margin-bottom-5 padding-all7" title="Edit"  href="' . ADMIN_BASE_URL . $segment_first . '/' . $rows['id'] . '/edit' . '" ><i class="fa fa-edit"></i> </a>
                <a class="btn red btn-outline margin-bottom-5 padding-all7" title="Delete" href="javascript:;" onclick=" var ans = confirm( \' Are you sure you want to delete this record?\'); if( ans ){ window.location.href=\' ' . ADMIN_BASE_URL . $segment_first . '/' . $rows['id'] . '/delete' . '\'; }"><i class="fa fa-trash"></i></a>
                ');
            $i++;
        }
        echo $this->common_response($_POST['draw'], $customActionStatus, $customActionMessage, $data, $count);
        exit;
    }

    public function getProduct()
    {
        $table_name = 'tbl_product';
        $segment_first = 'product/product';

        $start = $_POST['start'];
        $length = $_POST['length'];
        $order_column = $_POST['order'][0]['column'];
        $order_dir = $_POST['order'][0]['dir'];
        $draw = $_POST['draw'];
        $skip = $draw - $length;
        if (!isset($start)) {
            redirect('404', 'refersh');
        }
        $fieldArray = array('tbl_product.id', 'tbl_product_category.category_name', 'tbl_product.sub_category_id', 'tbl_product_subcategory.sub_category_name', 'tbl_product.product_name', 'tbl_product.short_description', 'tbl_product.image', 'tbl_product.availability', 'tbl_product.deal_week', 'tbl_product.featured_products', 'tbl_product.created_at', 'tbl_product.status');
        $fieldArray = array_combine(range(1, count($fieldArray)), $fieldArray);

        $customActionStatus = "";
        $customActionMessage = "";

        if (isset($_POST['customActionType']) && $_POST['customActionType'] == 'group_action') {

            $permission = $this->admin_model->check_role_permission_ajax($_POST['customActionName'], $this->_type);

            if (!$permission) {

                $customActionStatus = "OK";
                $customActionMessage = "Permission not found.";

            } else {

                $this->db->where_in('tbl_product.id', $_POST['id']);
                $data = array(
                    'tbl_product.status' => $_POST['customActionName'],
                    'tbl_product.updated_at' => date('Y-m-d H:i:s'),
                );
                $updateData = $this->db->update($table_name, $data);

                if ($updateData) {
                    $customActionStatus = "OK";
                    $customActionMessage = "Group action successfully has been completed";
                }
            }

        }

        /* ## Search by functionality */

        if (isset($_POST['category_name']) && $_POST['category_name'] != '') {
            $sql = $this->db->like('tbl_product_category.category_name', $_POST['category_name'], 'both');
        }

        if (isset($_POST['product_name']) && $_POST['product_name'] != '') {
            $sql = $this->db->like('tbl_product.product_name', $_POST['product_name'], 'both');
        }
        /* Search by question */

        $sql = $this->db->from($table_name);
        $to_date = date("Y-m-d");

        /* Search bt from created date */
        if ((isset($_POST['to_created_at']) && $_POST['to_created_at'] == '') && (isset($_POST['form_created_at']) && $_POST['form_created_at'] != '')) {
            $sql = $this->db->where('tbl_product.created_at >= "' . date('Y-m-d', strtotime(str_replace('/', '-', $_POST['form_created_at']))) . ' 00:00:00" AND "' . $to_date . ' 23:59:59"');
        }
        /* Search bt to created date */
        if ((isset($_POST['to_created_at']) && $_POST['to_created_at'] != '') && (isset($_POST['form_created_at']) && $_POST['form_created_at'] == '')) {
            $sql = $this->db->where('tbl_product.created_at <=', date('Y-m-d', strtotime(str_replace('/', '-', $_POST['to_created_at']))) . ' 23:59:59');
        }

        /* Search bt to and from created date */
        if ((isset($_POST['to_created_at']) && $_POST['to_created_at'] != '') && (isset($_POST['form_created_at']) && $_POST['form_created_at'] != '')) {
            $sql = $this->db->where('tbl_product.created_at >= "' . date('Y-m-d', strtotime(str_replace('/', '-', $_POST['form_created_at']))) . ' 00:00:00" AND tbl_product.created_at<="' . date('Y-m-d', strtotime(str_replace('/', '-', $_POST['to_created_at']))) . ' 23:59:59"');
        }
        /* Search by status */
        if (isset($_POST['status']) && $_POST['status'] != '') {
            $sql = $this->db->where('tbl_product.status', $_POST['status']);
        }
        $sql = $this->db
            ->select($fieldArray)
            ->join('tbl_product_category', 'tbl_product_category.id = tbl_product.category_id', 'left')
            ->join('tbl_product_subcategory', 'tbl_product_subcategory.id = tbl_product.sub_category_id', 'left')
            ->where('tbl_product.status !=', '9')
            ->order_by($fieldArray[$order_column], $order_dir);

        if ($length > 0) {
            $sql = $sql->limit($length, $start);
        }

        $records = $this->db->get()->result();
        $count = $this->db->select($fieldArray)
            ->from($table_name)
            ->join('tbl_product_category', 'tbl_product_category.id = tbl_product.category_id', 'left')
            ->join('tbl_product_subcategory', 'tbl_product_subcategory.id = tbl_product.sub_category_id', 'left')
            ->where('tbl_product.status !=', '9')
            ->order_by($fieldArray[$order_column], $order_dir)->get()->num_rows();

        $array = json_decode(json_encode($records), true);
        $i = $start + 1;
        $data = array();
        foreach ($array as $key => $rows) {
            if ($rows['status'] == 0) {
                $status = '<span class="label label-sm label-info">In-active</span>';
            } else {
                $status = '<span class="label label-sm label-success">Active</span>';
            }

            $images = explode(",", $rows['image']);
            $image = '';
            foreach ($images as $key => $value) {
                if ($value == "") {
                    $image = '<img width="80px" height="80px" src="' . DEFAULT_IMAGE . '">';
                } else {
                    $image = '<img width="80px" height="80px" src="' . PRODUCT_IMG_URL . $value . '">';
                }
            }

            $short_content = (strlen($rows['short_description']) > 100) ? substr($rows['short_description'], 0, 100) . "..." : $rows['short_description'];
            $availability = ($rows['availability'] == '1') ? 'checked' : '';
            $deal_week = ($rows['deal_week'] == '1') ? 'checked' : '';
            $featured_products = ($rows['featured_products'] == '1') ? 'checked' : '';
            $name = '';
            /*$result1 = explode(',', $rows['sub_category_id']);
            $count1 = count($result1);
            foreach ($result1 as $key1 => $value1) {
            $data1 = $this->db->where('id', $value1)->get('tbl_product_subcategory')->row();
            if (!empty($data1)) {
            $name .= ($count1 - 1 == $key1) ? ($data1->sub_category_name . '') : ($data1->sub_category_name . ', ');
            } else {
            $name .= '';
            }
            }*/

            $data[] = array(
                '<input type="checkbox" value="' . $rows['id'] . '" name="id[]">',
                $rows['category_name'],
                $rows['sub_category_name'],
                $rows['product_name'],
                $short_content,
                $image,
                '<input type="checkbox" name="availability" onchange="insert_status(this.checked,' . $rows['id'] . ')" ' . $availability . '>',
                '<input type="checkbox" name="deal_week" onchange="insert_status1(this.checked,' . $rows['id'] . ')" ' . $deal_week . '>',
                '<input type="checkbox" name="featured_products" onchange="insert_status2(this.checked,' . $rows['id'] . ')" ' . $featured_products . '>',
                $status,
                date('d/m/Y', strtotime($rows['created_at'])),
                '<a class="btn green btn-outline margin-bottom-5 padding-all7" title="Edit"  href="' . ADMIN_BASE_URL . $segment_first . '/' . $rows['id'] . '/edit' . '" ><i class="fa fa-edit"></i> </a>
                 <a class="btn red btn-outline margin-bottom-5 padding-all7" title="Delete" href="javascript:;" onclick=" var ans = confirm( \' Are you sure you want to delete this record?\'); if( ans ){ window.location.href=\' ' . ADMIN_BASE_URL . $segment_first . '/' . $rows['id'] . '/delete' . '\'; }"><i class="fa fa-trash"></i></a>
                 <a class="btn dark btn-outline margin-bottom-5 padding-all7" title="View"  href="' . ADMIN_BASE_URL . $segment_first . '/' . $rows['id'] . '/view' . '" ><i class="fa fa-bars"></i> </a>
                 <div class="btn-group">
                     <a class="btn green-haze btn-outline  margin-bottom-5 padding-all7" href="javascript:;" data-toggle="dropdown" data-hover="dropdown" data-close-others="true" aria-expanded="false"><i class="fa fa-plus"></i></a>
                         <ul class="dropdown-menu pull-right">
                             <li>
                                 <a title="Sample" href="' . ADMIN_BASE_URL . $segment_first . '/' . $rows['id'] . '/gallery/list' . '"><i class="fa fa-angle-down" aria-hidden="true"></i> Gallery</a>
                             </li>
                         </ul>
                  </div>
                ');
            $i++;
        }
        echo $this->common_response($_POST['draw'], $customActionStatus, $customActionMessage, $data, $count);
        exit;
    }

    /* getCouponcode starts here */
    public function getCoupon_code()
    {
        $table_name = 'tbl_coupon_code';
        $segment_first = 'product/coupon-code';
        $start = $_POST['start'];
        $length = $_POST['length'];
        $order_column = $_POST['order'][0]['column'];
        $order_dir = $_POST['order'][0]['dir'];
        $draw = $_POST['draw'];
        $skip = $draw - $length;
        if (!isset($start)) {
            redirect('404', 'refersh');
        }
        $fieldArray = array('id', 'coupon_name', 'price', 'status', 'created_at');
        $fieldArray = array_combine(range(1, count($fieldArray)), $fieldArray);

        $customActionStatus = "";
        $customActionMessage = "";

        if (isset($_POST['customActionType']) && $_POST['customActionType'] == 'group_action') {

            $permission = $this->admin_model->check_role_permission_ajax($_POST['customActionName'], $this->_type);

            if (!$permission) {

                $customActionStatus = "OK";
                $customActionMessage = "Permission not found.";

            } else {

                $this->db->where_in('id', $_POST['id']);
                $data = array(
                    'status' => $_POST['customActionName'],
                    'updated_at' => date('Y-m-d H:i:s'),
                );
                $updateData = $this->db->update($table_name, $data);

                if ($updateData) {
                    $customActionStatus = "OK";
                    $customActionMessage = "Group action successfully has been completed";
                }
            }

        }

        /* ## Search by functionality */

        /* Search by question */
        if (isset($_POST['coupon_name']) && $_POST['coupon_name'] != '') {
            $sql = $this->db->like('coupon_name', $_POST['coupon_name'], 'after');
        }

        // if( isset( $_POST['email'] ) && $_POST['email'] != '' ){
        //     $sql = $this->db->like('email', $_POST['email'], 'after');
        // }

        $sql = $this->db->from($table_name);
        $to_date = date("Y-m-d");

        /* Search bt from created date */
        if ((isset($_POST['to_created_at']) && $_POST['to_created_at'] == '') && (isset($_POST['form_created_at']) && $_POST['form_created_at'] != '')) {
            $sql = $this->db->where('created_at >= "' . date('Y-m-d', strtotime(str_replace('/', '-', $_POST['form_created_at']))) . ' 00:00:00" AND "' . $to_date . ' 23:59:59"');
        }
        /* Search bt to created date */
        if ((isset($_POST['to_created_at']) && $_POST['to_created_at'] != '') && (isset($_POST['form_created_at']) && $_POST['form_created_at'] == '')) {
            $sql = $this->db->where('created_at <=', date('Y-m-d', strtotime(str_replace('/', '-', $_POST['to_created_at']))) . ' 23:59:59');
        }

        /* Search bt to and from created date */
        if ((isset($_POST['to_created_at']) && $_POST['to_created_at'] != '') && (isset($_POST['form_created_at']) && $_POST['form_created_at'] != '')) {
            $sql = $this->db->where('created_at >= "' . date('Y-m-d', strtotime(str_replace('/', '-', $_POST['form_created_at']))) . ' 00:00:00" AND created_at<="' . date('Y-m-d', strtotime(str_replace('/', '-', $_POST['to_created_at']))) . ' 23:59:59"');
        }
        /* Search by status */
        if (isset($_POST['status']) && $_POST['status'] != '') {
            $sql = $this->db->where('status', $_POST['status']);
        }

        if ($this->_type == 'user') {

            $sql = $this->db
                ->select($fieldArray)
                ->where('status !=', '9')
                ->order_by($fieldArray[$order_column], $order_dir);

            if ($length > 0) {
                $sql = $sql->limit($length, $start);
            }
            $records = $this->db->get()->result();
            $count = $this->db->select($fieldArray)
                ->from($table_name)
                ->where('status !=', '9')
                ->order_by($fieldArray[$order_column], $order_dir)->get()->num_rows();

        } else {
            $sql = $this->db
                ->select($fieldArray)
                ->where('status !=', '9')
                ->order_by($fieldArray[$order_column], $order_dir);

            if ($length > 0) {
                $sql = $sql->limit($length, $start);
            }
            $records = $this->db->get()->result();
            $count = $this->db->select($fieldArray)
                ->from($table_name)
                ->where('status !=', '9')
                ->order_by($fieldArray[$order_column], $order_dir)->get()->num_rows();

        }

        $array = json_decode(json_encode($records), true);

        $i = $start + 1;
        $data = array();
        foreach ($array as $key => $rows) {

            /*status*/

            if ($rows['status'] == 0) {
                $status = '<span class="label label-sm label-info">In-active</span>';
            } else {
                $status = '<span class="label label-sm label-success">Active</span>';
            }

            // $image ='<img src="'.CATEGORY_IMG_URL.$rows['image'].'" style="width: 100px;">';

            $data[] = array(

                '<input type="checkbox" value="' . $rows['id'] . '"  name="id[]">',
                /* $image,*/
                $rows['coupon_name'],
                $rows['price'],
                $status,
                date('d/m/Y', strtotime($rows['created_at'])),
                '<a class="btn green btn-outline margin-bottom-5 padding-all7" title="Edit"  href="' . ADMIN_BASE_URL . $segment_first . '/' . $rows['id'] . '/edit' . '" ><i class="fa fa-edit"></i> </a>
                <a class="btn red btn-outline margin-bottom-5 padding-all7" title="Delete" href="javascript:;" onclick=" var ans = confirm( \' Are you sure you want to delete this record?\'); if( ans ){ window.location.href=\' ' . ADMIN_BASE_URL . $segment_first . '/' . $rows['id'] . '/delete' . '\'; }"><i class="fa fa-trash"></i></a>
                ',
            );
            $i++;
        }

        echo $this->common_response($_POST['draw'], $customActionStatus, $customActionMessage, $data, $count);
        exit;

        echo $this->common_response($_POST['draw'], $customActionStatus, $customActionMessage, $data, $count);
        exit;
    }

    public function getTag()
    {
        $table_name = 'tbl_tag';
        $segment_first = 'product/tag';
        $start = $_POST['start'];
        $length = $_POST['length'];
        $order_column = $_POST['order'][0]['column'];
        $order_dir = $_POST['order'][0]['dir'];
        $draw = $_POST['draw'];
        $skip = $draw - $length;
        if (!isset($start)) {
            redirect('404', 'refersh');
        }
        $fieldArray = array('id', 'tag_name', 'status', 'created_at');
        $fieldArray = array_combine(range(1, count($fieldArray)), $fieldArray);

        $customActionStatus = "";
        $customActionMessage = "";

        if (isset($_POST['customActionType']) && $_POST['customActionType'] == 'group_action') {

            $permission = $this->admin_model->check_role_permission_ajax($_POST['customActionName'], $this->_type);

            if (!$permission) {

                $customActionStatus = "OK";
                $customActionMessage = "Permission not found.";

            } else {

                $this->db->where_in('id', $_POST['id']);
                $data = array(
                    'status' => $_POST['customActionName'],
                    'updated_at' => date('Y-m-d H:i:s'),
                );
                $updateData = $this->db->update($table_name, $data);

                if ($updateData) {
                    $customActionStatus = "OK";
                    $customActionMessage = "Group action successfully has been completed";
                }
            }

        }

        /* ## Search by functionality */

        /* Search by question */
        if (isset($_POST['tag_name']) && $_POST['tag_name'] != '') {
            $sql = $this->db->like('tag_name', $_POST['tag_name'], 'after');
        }

        // if( isset( $_POST['email'] ) && $_POST['email'] != '' ){
        //     $sql = $this->db->like('email', $_POST['email'], 'after');
        // }

        $sql = $this->db->from($table_name);
        $to_date = date("Y-m-d");

        /* Search bt from created date */
        if ((isset($_POST['to_created_at']) && $_POST['to_created_at'] == '') && (isset($_POST['form_created_at']) && $_POST['form_created_at'] != '')) {
            $sql = $this->db->where('created_at >= "' . date('Y-m-d', strtotime(str_replace('/', '-', $_POST['form_created_at']))) . ' 00:00:00" AND "' . $to_date . ' 23:59:59"');
        }
        /* Search bt to created date */
        if ((isset($_POST['to_created_at']) && $_POST['to_created_at'] != '') && (isset($_POST['form_created_at']) && $_POST['form_created_at'] == '')) {
            $sql = $this->db->where('created_at <=', date('Y-m-d', strtotime(str_replace('/', '-', $_POST['to_created_at']))) . ' 23:59:59');
        }

        /* Search bt to and from created date */
        if ((isset($_POST['to_created_at']) && $_POST['to_created_at'] != '') && (isset($_POST['form_created_at']) && $_POST['form_created_at'] != '')) {
            $sql = $this->db->where('created_at >= "' . date('Y-m-d', strtotime(str_replace('/', '-', $_POST['form_created_at']))) . ' 00:00:00" AND created_at<="' . date('Y-m-d', strtotime(str_replace('/', '-', $_POST['to_created_at']))) . ' 23:59:59"');
        }
        /* Search by status */
        if (isset($_POST['status']) && $_POST['status'] != '') {
            $sql = $this->db->where('status', $_POST['status']);
        }

        if ($this->_type == 'user') {

            $sql = $this->db
                ->select($fieldArray)
                ->where('status !=', '9')
                ->order_by($fieldArray[$order_column], $order_dir);

            if ($length > 0) {
                $sql = $sql->limit($length, $start);
            }
            $records = $this->db->get()->result();
            $count = $this->db->select($fieldArray)
                ->from($table_name)
                ->where('status !=', '9')
                ->order_by($fieldArray[$order_column], $order_dir)->get()->num_rows();

        } else {
            $sql = $this->db
                ->select($fieldArray)
                ->where('status !=', '9')
                ->order_by($fieldArray[$order_column], $order_dir);

            if ($length > 0) {
                $sql = $sql->limit($length, $start);
            }
            $records = $this->db->get()->result();
            $count = $this->db->select($fieldArray)
                ->from($table_name)
                ->where('status !=', '9')
                ->order_by($fieldArray[$order_column], $order_dir)->get()->num_rows();

        }

        $array = json_decode(json_encode($records), true);

        $i = $start + 1;
        $data = array();
        foreach ($array as $key => $rows) {

            /*status*/

            if ($rows['status'] == 0) {
                $status = '<span class="label label-sm label-info">In-active</span>';
            } else {
                $status = '<span class="label label-sm label-success">Active</span>';
            }

            // $image ='<img src="'.CATEGORY_IMG_URL.$rows['image'].'" style="width: 100px;">';

            $data[] = array(

                '<input type="checkbox" value="' . $rows['id'] . '"  name="id[]">',
                /* $image,*/
                $rows['tag_name'],
                $status,
                date('d/m/Y', strtotime($rows['created_at'])),
                '<a class="btn green btn-outline margin-bottom-5 padding-all7" title="Edit"  href="' . ADMIN_BASE_URL . $segment_first . '/' . $rows['id'] . '/edit' . '" ><i class="fa fa-edit"></i> </a>
                <a class="btn red btn-outline margin-bottom-5 padding-all7" title="Delete" href="javascript:;" onclick=" var ans = confirm( \' Are you sure you want to delete this record?\'); if( ans ){ window.location.href=\' ' . ADMIN_BASE_URL . $segment_first . '/' . $rows['id'] . '/delete' . '\'; }"><i class="fa fa-trash"></i></a>
                ',
            );
            $i++;
        }

        echo $this->common_response($_POST['draw'], $customActionStatus, $customActionMessage, $data, $count);
        exit;

        echo $this->common_response($_POST['draw'], $customActionStatus, $customActionMessage, $data, $count);
        exit;
    }

    public function getGallery($product_id)
    {
        $table_name = 'tbl_gallery';
        $segment_first = 'gallery/gallery';

        $start = $_POST['start'];
        $length = $_POST['length'];
        $order_column = $_POST['order'][0]['column'];
        $order_dir = $_POST['order'][0]['dir'];
        $draw = $_POST['draw'];
        $skip = $draw - $length;
        if (!isset($start)) {
            redirect('404', 'refersh');
        }
        $fieldArray = array('id', 'product_id', 'image', 'created_at', 'status');
        $fieldArray = array_combine(range(1, count($fieldArray)), $fieldArray);

        $customActionStatus = "";
        $customActionMessage = "";

        if (isset($_POST['customActionType']) && $_POST['customActionType'] == 'group_action') {

            $permission = $this->admin_model->check_role_permission_ajax($_POST['customActionName'], $this->_type);

            if (!$permission) {

                $customActionStatus = "OK";
                $customActionMessage = "Permission not found.";

            } else {

                $this->db->where_in('id', $_POST['id']);
                $this->db->where_in('product_id', $product_id);
                $data = array(
                    'status' => $_POST['customActionName'],
                    'updated_at' => date('Y-m-d H:i:s'),
                );
                $updateData = $this->db->update($table_name, $data);

                if ($updateData) {
                    $customActionStatus = "OK";
                    $customActionMessage = "Group action successfully has been completed";
                }
            }

        }

        /* ## Search by functionality */

        if (isset($_POST['product_name']) && $_POST['product_name'] != '') {
            $sql = $this->db->like('product_name', $_POST['product_name'], 'both');
        }
        /* Search by question */

        $sql = $this->db->from($table_name);
        $to_date = date("Y-m-d");

        /* Search bt from created date */
        if ((isset($_POST['to_created_at']) && $_POST['to_created_at'] == '') && (isset($_POST['form_created_at']) && $_POST['form_created_at'] != '')) {
            $sql = $this->db->where('created_at >= "' . date('Y-m-d', strtotime(str_replace('/', '-', $_POST['form_created_at']))) . ' 00:00:00" AND "' . $to_date . ' 23:59:59"');
        }
        /* Search bt to created date */
        if ((isset($_POST['to_created_at']) && $_POST['to_created_at'] != '') && (isset($_POST['form_created_at']) && $_POST['form_created_at'] == '')) {
            $sql = $this->db->where('created_at <=', date('Y-m-d', strtotime(str_replace('/', '-', $_POST['to_created_at']))) . ' 23:59:59');
        }

        /* Search bt to and from created date */
        if ((isset($_POST['to_created_at']) && $_POST['to_created_at'] != '') && (isset($_POST['form_created_at']) && $_POST['form_created_at'] != '')) {
            $sql = $this->db->where('created_at >= "' . date('Y-m-d', strtotime(str_replace('/', '-', $_POST['form_created_at']))) . ' 00:00:00" AND created_at<="' . date('Y-m-d', strtotime(str_replace('/', '-', $_POST['to_created_at']))) . ' 23:59:59"');
        }
        /* Search by status */
        if (isset($_POST['status']) && $_POST['status'] != '') {
            $sql = $this->db->where('status', $_POST['status']);
        }
        $sql = $this->db
            ->select($fieldArray)
            ->where('status !=', '9')
            ->where('product_id =', $product_id)
            ->order_by($fieldArray[$order_column], $order_dir);

        if ($length > 0) {
            $sql = $sql->limit($length, $start);
        }

        $records = $this->db->get()->result();
        $count = $this->db->select($fieldArray)
            ->from($table_name)
            ->where('status !=', '9')
            ->order_by($fieldArray[$order_column], $order_dir)->get()->num_rows();

        $array = json_decode(json_encode($records), true);

        $i = $start + 1;
        $data = array();
        foreach ($array as $key => $rows) {
            if ($rows['status'] == 0) {
                $status = '<span class="label label-sm label-info">In-active</span>';
            } else {
                $status = '<span class="label label-sm label-success">Active</span>';
            }

            $images = explode(",", $rows['image']);
            $image = '';
            foreach ($images as $key => $value) {
                if ($value == "") {
                    $image = '<img width="80px" height="80px" src="' . DEFAULT_IMAGE . '">';
                } else {
                    $image = '<img width="80px" height="80px" src="' . GALLERY_IMG_URL . $value . '">';
                }
            }

            $data[] = array(
                '<input type="checkbox" value="' . $rows['id'] . '" name="id[]">',
                $image,
                $status,
                date('d/m/Y', strtotime($rows['created_at'])),
                '<a class="btn green btn-outline margin-bottom-5 padding-all7" title="Edit"  href="' . ADMIN_BASE_URL . 'product/' . 'product/' . $rows['product_id'] . '/gallery/' . $rows['id'] . '/edit' . '" ><i class="fa fa-edit"></i> </a>
                 <a class="btn red btn-outline margin-bottom-5 padding-all7" title="Delete" href="javascript:;" onclick=" var ans = confirm( \' Are you sure you want to delete this record?\'); if( ans ){ window.location.href=\' ' . ADMIN_BASE_URL . 'product/product' . '/' . $rows['product_id'] . '/gallery/' . $rows['id'] . '/delete' . '\'; }"><i class="fa fa-trash"></i></a>
                 ');
            $i++;
        }
        echo $this->common_response($_POST['draw'], $customActionStatus, $customActionMessage, $data, $count);
        exit;
    }

    public function getOrder_list()
    {
        $table_name = 'tbl_order_details';
        $segment_first = 'order-list/order-list';

        $start = $_POST['start'];
        $length = $_POST['length'];
        $order_column = $_POST['order'][0]['column'];
        $order_dir = $_POST['order'][0]['dir'];
        $draw = $_POST['draw'];
        $skip = $draw - $length;
        if (!isset($start)) {
            redirect('404', 'refersh');
        }
        $fieldArray = array('id', 'order_id', 'first_name', 'last_name', 'email', 'grand_total', 'mobile_no', 'address', 'payment_mode', 'created_at', 'status');
        $fieldArray = array_combine(range(1, count($fieldArray)), $fieldArray);

        $customActionStatus = "";
        $customActionMessage = "";

        if (isset($_POST['customActionType']) && $_POST['customActionType'] == 'group_action') {

            $permission = $this->admin_model->check_role_permission_ajax($_POST['customActionName'], $this->_type);

            if (!$permission) {

                $customActionStatus = "OK";
                $customActionMessage = "Permission not found.";

            } else {

                $this->db->where_in('id', $_POST['id']);
                $data = array(
                    'status' => $_POST['customActionName'],
                    'updated_at' => date('Y-m-d H:i:s'),
                );
                $updateData = $this->db->update($table_name, $data);

                if ($updateData) {
                    $customActionStatus = "OK";
                    $customActionMessage = "Group action successfully has been completed";
                }
            }

        }

        /* ## Search by functionality */

        if (isset($_POST['email']) && $_POST['email'] != '') {
            $sql = $this->db->like('email', $_POST['email'], 'both');
        }

        if (isset($_POST['order_id']) && $_POST['order_id'] != '') {
            $sql = $this->db->like('order_id', $_POST['order_id'], 'both');
        }

        if (isset($_POST['mobile_no']) && $_POST['mobile_no'] != '') {
            $sql = $this->db->like('mobile_no', $_POST['mobile_no'], 'both');
        }
        /* Search by question */

        $sql = $this->db->from($table_name);
        $to_date = date("Y-m-d");

        /* Search bt from created date */
        if ((isset($_POST['to_created_at']) && $_POST['to_created_at'] == '') && (isset($_POST['form_created_at']) && $_POST['form_created_at'] != '')) {
            $sql = $this->db->where('created_at >= "' . date('Y-m-d', strtotime(str_replace('/', '-', $_POST['form_created_at']))) . ' 00:00:00" AND "' . $to_date . ' 23:59:59"');
        }
        /* Search bt to created date */
        if ((isset($_POST['to_created_at']) && $_POST['to_created_at'] != '') && (isset($_POST['form_created_at']) && $_POST['form_created_at'] == '')) {
            $sql = $this->db->where('created_at <=', date('Y-m-d', strtotime(str_replace('/', '-', $_POST['to_created_at']))) . ' 23:59:59');
        }

        /* Search bt to and from created date */
        if ((isset($_POST['to_created_at']) && $_POST['to_created_at'] != '') && (isset($_POST['form_created_at']) && $_POST['form_created_at'] != '')) {
            $sql = $this->db->where('created_at >= "' . date('Y-m-d', strtotime(str_replace('/', '-', $_POST['form_created_at']))) . ' 00:00:00" AND created_at<="' . date('Y-m-d', strtotime(str_replace('/', '-', $_POST['to_created_at']))) . ' 23:59:59"');
        }
        /* Search by status */
        if (isset($_POST['status']) && $_POST['status'] != '') {
            $sql = $this->db->where('status', $_POST['status']);
        }
        $sql = $this->db
            ->select($fieldArray)
            ->where('status !=', '9')
            ->order_by($fieldArray[$order_column], $order_dir)
            ->group_by('order_id');

        if ($length > 0) {
            $sql = $sql->limit($length, $start);
        }

        $records = $this->db->get()->result();
        $count = $this->db->select($fieldArray)
            ->from($table_name)
            ->group_by('order_id')
            ->where('status !=', '9')
            ->order_by($fieldArray[$order_column], $order_dir)
            ->group_by('order_id')->get()->num_rows();

        $array = json_decode(json_encode($records), true);
        $i = $start + 1;
        $data = array();
        foreach ($array as $key => $rows) {
            if ($rows['status'] == 0) {
                $status = '<span class="label label-sm label-info">In-active</span>';
            } else {
                $status = '<span class="label label-sm label-success">Active</span>';
            }

            $short_content = (strlen($rows['address']) > 100) ? substr($rows['address'], 0, 100) . "..." : $rows['address'];

            $data[] = array(
                '<input type="checkbox" value="' . $rows['id'] . '" name="id[]">',
                $rows['order_id'],
                ucfirst($rows['first_name']) . " " . ucfirst($rows['last_name']),
                $rows['email'],
                $rows['mobile_no'],
                $short_content,
                "₹" . $rows['grand_total'],
                $rows['payment_mode'],
                $status,
                date('d/m/Y', strtotime($rows['created_at'])),
                '<a class="btn dark btn-outline margin-bottom-5 padding-all7" title="View"  href="' . ADMIN_BASE_URL . $segment_first . '/' . $rows['id'] . '/view' . '" ><i class="fa fa-bars"></i> </a>
                ');
            $i++;
        }
        echo $this->common_response($_POST['draw'], $customActionStatus, $customActionMessage, $data, $count);
        exit;
    }

    public function getUserdetails()
    {
        $table_name = 'tbl_admin';
        $segment_first = 'users/add-user';

        $start = $_POST['start'];
        $length = $_POST['length'];
        $order_column = $_POST['order'][0]['column'];
        $order_dir = $_POST['order'][0]['dir'];
        $draw = $_POST['draw'];
        $skip = $draw - $length;
        if (!isset($start)) {
            redirect('404', 'refersh');
        }
        $fieldArray = array('id', 'name', 'email', 'role_id', 'mobile_number', 'address', 'type', 'alternate_mobile_number', 'manager_image', 'status', 'created_at');
        $fieldArray = array_combine(range(1, count($fieldArray)), $fieldArray);

        $customActionStatus = "";
        $customActionMessage = "";

        if (isset($_POST['customActionType']) && $_POST['customActionType'] == 'group_action') {

            $permission = $this->admin_model->check_role_permission_ajax($_POST['customActionName'], $this->_type);

            if (!$permission) {

                $customActionStatus = "OK";
                $customActionMessage = "Permission not found.";

            } else {

                $this->db->where_in('id', $_POST['id']);
                $data = array(
                    'status' => $_POST['customActionName'],
                    'updated_at' => date('Y-m-d H:i:s'),
                );
                $updateData = $this->db->update($table_name, $data);

                if ($updateData) {
                    $customActionStatus = "OK";
                    $customActionMessage = "Group action successfully has been completed";
                }
            }

        }

        /* ## Search by functionality */

        /* Search by question */
        if (isset($_POST['name']) && $_POST['name'] != '') {
            $sql = $this->db->like('name', $_POST['name'], 'after');
        }

        if (isset($_POST['email']) && $_POST['email'] != '') {
            $sql = $this->db->like('email', $_POST['email'], 'after');
        }

        $sql = $this->db->from($table_name);
        $to_date = date("Y-m-d");

        /* Search bt from created date */
        if ((isset($_POST['to_created_at']) && $_POST['to_created_at'] == '') && (isset($_POST['form_created_at']) && $_POST['form_created_at'] != '')) {
            $sql = $this->db->where('created_at >= "' . date('Y-m-d', strtotime(str_replace('/', '-', $_POST['form_created_at']))) . ' 00:00:00" AND "' . $to_date . ' 23:59:59"');
        }
        /* Search bt to created date */
        if ((isset($_POST['to_created_at']) && $_POST['to_created_at'] != '') && (isset($_POST['form_created_at']) && $_POST['form_created_at'] == '')) {
            $sql = $this->db->where('created_at <=', date('Y-m-d', strtotime(str_replace('/', '-', $_POST['to_created_at']))) . ' 23:59:59');
        }

        /* Search bt to and from created date */
        if ((isset($_POST['to_created_at']) && $_POST['to_created_at'] != '') && (isset($_POST['form_created_at']) && $_POST['form_created_at'] != '')) {
            $sql = $this->db->where('created_at >= "' . date('Y-m-d', strtotime(str_replace('/', '-', $_POST['form_created_at']))) . ' 00:00:00" AND created_at<="' . date('Y-m-d', strtotime(str_replace('/', '-', $_POST['to_created_at']))) . ' 23:59:59"');
        }
        /* Search by status */
        if (isset($_POST['status']) && $_POST['status'] != '') {
            $sql = $this->db->where('status', $_POST['status']);
        }

        $sql = $this->db
            ->select($fieldArray)
            ->where('status !=', '9')
            ->where('type != ', 'Admin')
            ->order_by($fieldArray[$order_column], $order_dir);

        if ($length > 0) {
            $sql = $sql->limit($length, $start);
        }
        $records = $this->db->get()->result();
        $count = $this->db->select($fieldArray)
            ->from($table_name)
            ->where('status !=', '9')
            ->where('type != ', 'Admin')
            ->order_by($fieldArray[$order_column], $order_dir)->get()->num_rows();

        $array = json_decode(json_encode($records), true);

        $i = $start + 1;
        $data = array();
        foreach ($array as $key => $rows) {

            if ($rows['status'] == 0) {
                $status = '<span class="label label-sm label-info">In-active</span>';
            } else {
                $status = '<span class="label label-sm label-success">Active</span>';
            }

            if ($rows['manager_image'] == "") {
                $image = '<img width="80px" height="40px" src="' . DEFAULT_IMAGE . '">';
            } else {
                $image = '<img width="80px" height="40px" src="' . FARM_MANAGED_IMG_URL . $rows['manager_image'] . '">';
            }

            $data[] = array(

                '<input type="checkbox" value="' . $rows['id'] . '"  name="id[]">',
                $rows['id'],
                $rows['type'],
                $rows['name'],
                $rows['email'],
                $rows['mobile_number'],
                $rows['address'],
                $rows['alternate_mobile_number'],
                $image,
                $status,
                date('d/m/Y', strtotime($rows['created_at'])),
                '<a class="btn green btn-outline margin-bottom-5 padding-all7" title="Edit"  href="' . ADMIN_BASE_URL . $segment_first . '/' . $rows['id'] . '/edit' . '" ><i class="fa fa-edit"></i> </a>
                <a class="btn red btn-outline margin-bottom-5 padding-all7" title="Delete" href="javascript:;" onclick=" var ans = confirm( \' Are you sure you want to delete this record?\'); if( ans ){ window.location.href=\' ' . ADMIN_BASE_URL . $segment_first . '/' . $rows['id'] . '/delete' . '\'; }"><i class="fa fa-trash"></i></a>
                <!--<a class="btn dark btn-outline margin-bottom-5 padding-all7" title="View"  href="' . ADMIN_BASE_URL . $segment_first . '/' . $rows['id'] . '/view' . '" ><i class="fa fa-bars"></i> </a>-->
                ',
            );
            $i++;
        }

        echo $this->common_response($_POST['draw'], $customActionStatus, $customActionMessage, $data, $count);
        exit;
    }

    /*cms*/

    public function getPages()
    {
        $table_name = 'tbl_pages';
        $segment_first = 'cms/pages';

        $start = $_POST['start'];
        $length = $_POST['length'];
        $order_column = $_POST['order'][0]['column'];
        $order_dir = $_POST['order'][0]['dir'];
        $draw = $_POST['draw'];
        $skip = $draw - $length;
        if (!isset($start)) {
            redirect('404', 'refersh');
        }
        $fieldArray = array('id', 'shipping', 'money_refund', 'delivery', 'status', 'created_at');
        $fieldArray = array_combine(range(1, count($fieldArray)), $fieldArray);

        $customActionStatus = "";
        $customActionMessage = "";

        if (isset($_POST['customActionType']) && $_POST['customActionType'] == 'group_action') {

            $permission = $this->admin_model->check_role_permission_ajax($_POST['customActionName'], $this->_type);

            if (!$permission) {

                $customActionStatus = "OK";
                $customActionMessage = "Permission not found.";

            } else {

                $this->db->where_in('id', $_POST['id']);
                $data = array(
                    'status' => $_POST['customActionName'],
                    'updated_at' => date('Y-m-d H:i:s'),
                );
                $updateData = $this->db->update($table_name, $data);

                if ($updateData) {
                    $customActionStatus = "OK";
                    $customActionMessage = "Group action successfully has been completed";
                }
            }

        }

        /* ## Search by functionality */

        /* Search by question */
        if (isset($_POST['name']) && $_POST['name'] != '') {
            $sql = $this->db->like('name', $_POST['name'], 'after');
        }

        $sql = $this->db->from($table_name);
        $to_date = date("Y-m-d");

        /* Search bt from created date */
        if ((isset($_POST['to_created_at']) && $_POST['to_created_at'] == '') && (isset($_POST['form_created_at']) && $_POST['form_created_at'] != '')) {
            $sql = $this->db->where('created_at >= "' . date('Y-m-d', strtotime(str_replace('/', '-', $_POST['form_created_at']))) . ' 00:00:00" AND "' . $to_date . ' 23:59:59"');
        }
        /* Search bt to created date */
        if ((isset($_POST['to_created_at']) && $_POST['to_created_at'] != '') && (isset($_POST['form_created_at']) && $_POST['form_created_at'] == '')) {
            $sql = $this->db->where('created_at <=', date('Y-m-d', strtotime(str_replace('/', '-', $_POST['to_created_at']))) . ' 23:59:59');
        }

        /* Search bt to and from created date */
        if ((isset($_POST['to_created_at']) && $_POST['to_created_at'] != '') && (isset($_POST['form_created_at']) && $_POST['form_created_at'] != '')) {
            $sql = $this->db->where('created_at >= "' . date('Y-m-d', strtotime(str_replace('/', '-', $_POST['form_created_at']))) . ' 00:00:00" AND tbl_pages.created_at<="' . date('Y-m-d', strtotime(str_replace('/', '-', $_POST['to_created_at']))) . ' 23:59:59"');
        }
        /* Search by status */
        if (isset($_POST['status']) && $_POST['status'] != '') {
            $sql = $this->db->where('status', $_POST['status']);
        }

        if ($this->_type == 'user') {

            $sql = $this->db
                ->select($fieldArray)
                ->where('status !=', '9')
                ->where('language_id', $this->lang_id->id)
                ->order_by($fieldArray[$order_column], $order_dir);

            if ($length > 0) {
                $sql = $sql->limit($length, $start);
            }
            $records = $this->db->get()->result();
            $count = $this->db->select($fieldArray)
                ->from($table_name)
                ->where('status !=', '9')
                ->where('language_id', $this->lang_id->id)
                ->order_by($fieldArray[$order_column], $order_dir)->get()->num_rows();

        } else {

            $sql = $this->db
                ->select($fieldArray)
                ->where('status !=', '9')
                ->where('language_id', $this->lang_id->id)
                ->order_by($fieldArray[$order_column], $order_dir);

            if ($length > 0) {
                $sql = $sql->limit($length, $start);
            }
            $records = $this->db->get()->result();
            $count = $this->db->select($fieldArray)
                ->from($table_name)
                ->where('status !=', '9')
                ->where('language_id', $this->lang_id->id)
                ->order_by($fieldArray[$order_column], $order_dir)->get()->num_rows();
        }

        $array = json_decode(json_encode($records), true);

        $i = $start + 1;
        $data = array();
        foreach ($array as $key => $rows) {

            /*status*/

            if ($rows['status'] == 0) {
                $status = '<span class="label label-sm label-info">In-active</span>';
            } else {
                $status = '<span class="label label-sm label-success">Active</span>';
            }

            $data[] = array(

                // '<!--<input type="checkbox" value="' . $rows['id'] . '"  name="id[]">-->',
                $rows['shipping'],
                $rows['money_refund'],
                $rows['delivery'],
                $status,
                date('d/m/Y', strtotime($rows['created_at'])),
                '<a class="btn green btn-outline margin-bottom-5 padding-all7" title="Edit"  href="' . ADMIN_BASE_URL . $segment_first . '/' . $rows['id'] . '/edit' . '" ><i class="fa fa-edit"></i> </a>
                <!--<a class="btn red btn-outline margin-bottom-5 padding-all7" title="Delete" href="javascript:;" onclick=" var ans = confirm( \' Are you sure you want to delete this record?\'); if( ans ){ window.location.href=\' ' . ADMIN_BASE_URL . $segment_first . '/' . $rows['id'] . '/delete' . '\'; }"><i class="fa fa-trash"></i></a>-->
                <a class="btn dark btn-outline margin-bottom-5 padding-all7" title="View"  href="' . ADMIN_BASE_URL . $segment_first . '/' . $rows['id'] . '/view' . '" ><i class="fa fa-bars"></i> </a>

                ',
            );
            $i++;
        }

        echo $this->common_response($_POST['draw'], $customActionStatus, $customActionMessage, $data, $count);
        exit;
    }

    public function get_promotion()
    {
        $table_name = 'tbl_promotion';
        $segment_first = 'promotion/promotion';
        $start = $_POST['start'];
        $length = $_POST['length'];
        $order_column = $_POST['order'][0]['column'];
        $order_dir = $_POST['order'][0]['dir'];
        $draw = $_POST['draw'];
        $skip = $draw - $length;
        if (!isset($start)) {
            redirect('404', 'refersh');
        }
        $fieldArray = array('id', 'image', 'status', 'created_at');
        $fieldArray = array_combine(range(1, count($fieldArray)), $fieldArray);

        $customActionStatus = "";
        $customActionMessage = "";

        if (isset($_POST['customActionType']) && $_POST['customActionType'] == 'group_action') {

            $permission = $this->admin_model->check_role_permission_ajax($_POST['customActionName'], $this->_type);

            if (!$permission) {

                $customActionStatus = "OK";
                $customActionMessage = "Permission not found.";

            } else {

                $this->db->where_in('id', $_POST['id']);
                $data = array(
                    'status' => $_POST['customActionName'],
                    'updated_at' => date('Y-m-d H:i:s'),
                );
                $updateData = $this->db->update($table_name, $data);

                if ($updateData) {
                    $customActionStatus = "OK";
                    $customActionMessage = "Group action successfully has been completed";
                }
            }

        }

        $sql = $this->db->from($table_name);
        $to_date = date("Y-m-d");

        /* Search bt from created date */
        if ((isset($_POST['to_created_at']) && $_POST['to_created_at'] == '') && (isset($_POST['form_created_at']) && $_POST['form_created_at'] != '')) {
            $sql = $this->db->where('created_at >= "' . date('Y-m-d', strtotime(str_replace('/', '-', $_POST['form_created_at']))) . ' 00:00:00" AND "' . $to_date . ' 23:59:59"');
        }
        /* Search bt to created date */
        if ((isset($_POST['to_created_at']) && $_POST['to_created_at'] != '') && (isset($_POST['form_created_at']) && $_POST['form_created_at'] == '')) {
            $sql = $this->db->where('created_at <=', date('Y-m-d', strtotime(str_replace('/', '-', $_POST['to_created_at']))) . ' 23:59:59');
        }

        /* Search bt to and from created date */
        if ((isset($_POST['to_created_at']) && $_POST['to_created_at'] != '') && (isset($_POST['form_created_at']) && $_POST['form_created_at'] != '')) {
            $sql = $this->db->where('created_at >= "' . date('Y-m-d', strtotime(str_replace('/', '-', $_POST['form_created_at']))) . ' 00:00:00" AND created_at<="' . date('Y-m-d', strtotime(str_replace('/', '-', $_POST['to_created_at']))) . ' 23:59:59"');
        }
        /* Search by status */
        if (isset($_POST['status']) && $_POST['status'] != '') {
            $sql = $this->db->where('status', $_POST['status']);
        }

        if ($this->_type == 'user') {

            $sql = $this->db
                ->select($fieldArray)
                ->where('status !=', '9')
                ->order_by($fieldArray[$order_column], $order_dir);

            if ($length > 0) {
                $sql = $sql->limit($length, $start);
            }
            $records = $this->db->get()->result();
            $count = $this->db->select($fieldArray)
                ->from($table_name)
                ->where('status !=', '9')
                ->order_by($fieldArray[$order_column], $order_dir)->get()->num_rows();

        } else {
            $sql = $this->db
                ->select($fieldArray)
                ->where('status !=', '9')
                ->order_by($fieldArray[$order_column], $order_dir);

            if ($length > 0) {
                $sql = $sql->limit($length, $start);
            }
            $records = $this->db->get()->result();
            $count = $this->db->select($fieldArray)
                ->from($table_name)
                ->where('status !=', '9')
                ->order_by($fieldArray[$order_column], $order_dir)->get()->num_rows();

        }

        $array = json_decode(json_encode($records), true);

        $i = $start + 1;
        $data = array();
        foreach ($array as $key => $rows) {

            /*status*/

            if ($rows['status'] == 0) {
                $status = '<span class="label label-sm label-info">In-active</span>';
            } else {
                $status = '<span class="label label-sm label-success">Active</span>';
            }

            $image = '<img src="' . PROMOTION_IMG_URL . $rows['image'] . '" style="width: 100px;">';

            $data[] = array(

                '<input type="checkbox" value="' . $rows['id'] . '"  name="id[]">',
                $image,
                $status,
                date('d/m/Y', strtotime($rows['created_at'])),
                '<a class="btn green btn-outline margin-bottom-5 padding-all7" title="Edit"  href="' . ADMIN_BASE_URL . $segment_first . '/' . $rows['id'] . '/edit' . '" ><i class="fa fa-edit"></i> </a>
                <a class="btn red btn-outline margin-bottom-5 padding-all7" title="Delete" href="javascript:;" onclick=" var ans = confirm( \' Are you sure you want to delete this record?\'); if( ans ){ window.location.href=\' ' . ADMIN_BASE_URL . $segment_first . '/' . $rows['id'] . '/delete' . '\'; }"><i class="fa fa-trash"></i></a>
                ',
            );
            $i++;
        }

        echo $this->common_response($_POST['draw'], $customActionStatus, $customActionMessage, $data, $count);
        exit;

        echo $this->common_response($_POST['draw'], $customActionStatus, $customActionMessage, $data, $count);
        exit;
    }

// slider image
    public function getSliderimage()
    {
        $table_name = 'tbl_slider_image';
        $segment_first = 'slider/slider-image';

        $start = $_POST['start'];
        $length = $_POST['length'];
        $order_column = $_POST['order'][0]['column'];
        $order_dir = $_POST['order'][0]['dir'];
        $draw = $_POST['draw'];
        $skip = $draw - $length;
        if (!isset($start)) {
            redirect('404', 'refersh');
        }
        $fieldArray = array('id', 'image', 'status', 'created_at');
        $fieldArray = array_combine(range(1, count($fieldArray)), $fieldArray);

        $customActionStatus = "";
        $customActionMessage = "";

        if (isset($_POST['customActionType']) && $_POST['customActionType'] == 'group_action') {

            $permission = $this->admin_model->check_role_permission_ajax($_POST['customActionName'], $this->_type);

            if (!$permission) {

                $customActionStatus = "OK";
                $customActionMessage = "Permission not found.";

            } else {

                $this->db->where_in('id', $_POST['id']);
                $data = array(
                    'status' => $_POST['customActionName'],
                    'updated_at' => date('Y-m-d H:i:s'),
                );
                $updateData = $this->db->update($table_name, $data);

                if ($updateData) {
                    $customActionStatus = "OK";
                    $customActionMessage = "Group action successfully has been completed";
                }
            }

        }

        /* ## Search by functionality */

        $sql = $this->db->from($table_name);
        $to_date = date("Y-m-d");

        /* Search bt from created date */
        if ((isset($_POST['to_created_at']) && $_POST['to_created_at'] == '') && (isset($_POST['form_created_at']) && $_POST['form_created_at'] != '')) {
            $sql = $this->db->where('created_at >= "' . date('Y-m-d', strtotime(str_replace('/', '-', $_POST['form_created_at']))) . ' 00:00:00" AND "' . $to_date . ' 23:59:59"');
        }
        /* Search bt to created date */
        if ((isset($_POST['to_created_at']) && $_POST['to_created_at'] != '') && (isset($_POST['form_created_at']) && $_POST['form_created_at'] == '')) {
            $sql = $this->db->where('created_at <=', date('Y-m-d', strtotime(str_replace('/', '-', $_POST['to_created_at']))) . ' 23:59:59');
        }

        /* Search bt to and from created date */
        if ((isset($_POST['to_created_at']) && $_POST['to_created_at'] != '') && (isset($_POST['form_created_at']) && $_POST['form_created_at'] != '')) {
            $sql = $this->db->where('created_at >= "' . date('Y-m-d', strtotime(str_replace('/', '-', $_POST['form_created_at']))) . ' 00:00:00" AND created_at<="' . date('Y-m-d', strtotime(str_replace('/', '-', $_POST['to_created_at']))) . ' 23:59:59"');
        }
        /* Search by status */
        if (isset($_POST['status']) && $_POST['status'] != '') {
            $sql = $this->db->where('status', $_POST['status']);
        }

        if ($this->_type == 'user') {

            $sql = $this->db
                ->select($fieldArray)
                ->where('status !=', '9')
                ->order_by($fieldArray[$order_column], $order_dir);

            if ($length > 0) {
                $sql = $sql->limit($length, $start);
            }
            $records = $this->db->get()->result();
            $count = $this->db->select($fieldArray)
                ->from($table_name)
                ->where('status !=', '9')
                ->order_by($fieldArray[$order_column], $order_dir)->get()->num_rows();

        } else {
            $sql = $this->db
                ->select($fieldArray)
                ->where('status !=', '9')
                ->order_by($fieldArray[$order_column], $order_dir);

            if ($length > 0) {
                $sql = $sql->limit($length, $start);
            }
            $records = $this->db->get()->result();
            $count = $this->db->select($fieldArray)
                ->from($table_name)
                ->where('status !=', '9')
                ->order_by($fieldArray[$order_column], $order_dir)->get()->num_rows();

        }

        $array = json_decode(json_encode($records), true);

        $i = $start + 1;
        $data = array();
        foreach ($array as $key => $rows) {

            /*status*/

            if ($rows['status'] == 0) {
                $status = '<span class="label label-sm label-info">In-active</span>';
            } else {
                $status = '<span class="label label-sm label-success">Active</span>';
            }

            $image = '<img src="' . SLIDER_IMG_URL . $rows['image'] . '" style="width: 100px;">';

            $data[] = array(

                '<input type="checkbox" value="' . $rows['id'] . '"  name="id[]">',
                $image,
                $status,
                date('d/m/Y', strtotime($rows['created_at'])),
                '<a class="btn green btn-outline margin-bottom-5 padding-all7" title="Edit"  href="' . ADMIN_BASE_URL . $segment_first . '/' . $rows['id'] . '/edit' . '" ><i class="fa fa-edit"></i> </a>
                <a class="btn red btn-outline margin-bottom-5 padding-all7" title="Delete" href="javascript:;" onclick=" var ans = confirm( \' Are you sure you want to delete this record?\'); if( ans ){ window.location.href=\' ' . ADMIN_BASE_URL . $segment_first . '/' . $rows['id'] . '/delete' . '\'; }"><i class="fa fa-trash"></i></a>
                ',
            );
            $i++;
        }

        echo $this->common_response($_POST['draw'], $customActionStatus, $customActionMessage, $data, $count);
        exit;
    }

##Common Function

    public function isJSON($string)
    {
        return is_string($string) && is_array(json_decode($string, true)) ? true : false;
    }

    public function common_response($post_draw, $customActionStatus, $customActionMessage, $data, $count)
    {
        $responceArray = array(
            'data' => array(),
            'draw' => (int) $post_draw,
            'customActionStatus' => ($customActionStatus != '') ? $customActionStatus : 0,
            'customActionMessage' => ($customActionMessage != '') ? $customActionMessage : '',
            'recordsTotal' => 0,
            'recordsFiltered' => 0,
        );

        if (!empty($data)) {
            $responceArray = array(
                'data' => $data,
                'draw' => (int) $post_draw,
                'customActionStatus' => ($customActionStatus != '') ? $customActionStatus : 0,
                'customActionMessage' => ($customActionMessage != '') ? $customActionMessage : '',
                'recordsTotal' => $count,
                'recordsFiltered' => $count,
            );
        }

        return json_encode($responceArray);

    }

//end
}
