<?php

class Admin_model extends CI_Model
{

    public $lang_id = array();
    public function __construct()
    {

        parent::__construct();
        $this->lang_id = $this->session->userdata('languageSession');
    }

    public function get_product_category()
    {
        return $this->db->where(array('status' => '1'))->get('tbl_product_category')->result_array();
    }

    public function get_tag()
    {
        return $this->db->where(array('status' => '1'))->get('tbl_tag')->result_array();
    }

    public function get_product_subcategory()
    {
        return $this->db->where(array('status' => '1'))->get('tbl_product_subcategory')->result_array();
    }

    public function get_roles()
    {
        return $this->db->get('tbl_role')->result_array();
    }

    public function get_country_flag($id)
    {
        return $this->db->select('*')
            ->where(array('id' => $id))
            ->get('tbl_countries')->row();
    }

    public function get_countries()
    {
        return $this->db->select('*')
            ->where(array('status' => '1'))
            ->get('tbl_countries')->result_array();
    }

    public function get_area()
    {
        return $this->db->select('*')
            ->where(array('status' => '1'))
            ->group_by('locality')
            ->get('tbl_farm_shop')->result_array();
    }

    public function get_states()
    {
        return $this->db->select('*')
            ->where(array('status' => '1'))
            ->get('tbl_states')->result_array();
    }

    public function get_cities()
    {
        return $this->db->select('*')
            ->where(array('status' => '1'))
            ->get('tbl_cities')->result_array();
    }

    public function get_country_name($country_id)
    {
        return $this->db->select('*')
            ->where(array('id' => $country_id))
            ->get('tbl_countries')->row();
    }

    public function get_farm()
    {
        return $this->db->select('*')
            ->where(array('status' => '1'))
            ->get('tbl_farm')->result_array();
    }

    public function get_manager()
    {
        return $this->db->where(array('status' => '1', 'role_id' => '2'))->get('tbl_admin')->result_array();
    }

    public function get_stateData($countryID)
    {
        return $this->db->select('*')
            ->where(array('country_id' => $countryID))
            ->get('tbl_states')
            ->result_array();
    }

    public function get_cityData($state_ID)
    {
        return $this->db->select('*')
            ->where(array('state_id' => $state_ID))
            ->get('tbl_cities')
            ->result_array();
    }

    public function get_attribute()
    {
        return $this->db->where(array('status' => '1'))
            ->get('tbl_farm_attributes')
            ->result_array();
    }

    public function get_all_countries()
    {
        return $this->db->select('*')
            ->where(array('status' => '1'))
            ->get('tbl_countries')
            ->result_array();
    }

    public function get_last_product()
    {
        return $this->db->select('*')
            ->where(array('status' => '1'))
            ->order_by("id", "desc")
            ->limit(1)
            ->get('tbl_shop_product')->row();
    }

    public function get_shop_size()
    {
        return $this->db->select('*')
            ->where(array('status' => '1'))
            ->get('tbl_shop_size')->result_array();
    }

    public function get_all_shop_sub_category()
    {
        return $this->db->select('*')
            ->where(array('status' => '1', 'parent_id !=' => '0'))
            ->get('tbl_shop_category')->result_array();
    }

    public function get_sub_category_name($shop_sub_cat_id)
    {
        return $this->db->select('*')
            ->where(array('id' => $shop_sub_cat_id))
            ->get('tbl_shop_category')->row();
    }

    public function get_plants()
    {
        return $this->db->where(array('status' => '1'))
            ->get('tbl_farm_plants')
            ->result_array();
    }

    public function get_plants_by_id($id)
    {
        return $this->db->where(array('status' => '1', 'id' => $id))
            ->get('tbl_farm_plants')
            ->row();
    }

    public function get_plants_by_catids($category_id)
    {
        return $this->db->where(array('status' => '1'))
            ->where_in(in_array('category_id', $category_id))
            ->get('tbl_farm_plants')
            ->result_array();
    }

    public function get_plants_by_catid($category_id)
    {
        return $this->db->where(array('status' => '1', 'category_id' => $category_id))
            ->get('tbl_farm_plants')
            ->result_array();
    }

    public function get_category()
    {
        return $this->db->where(array('status' => '1'))
            ->get('tbl_category')
            ->result_array();
    }

    public function get_total_customers()
    {
        return $this->db->where(array('status' => '1'))->get('tbl_customer_details')->result_array();
    }

    public function get_total_map_customers()
    {
        return $this->db->where(array('status' => '1'))->get('tbl_customer_details')->row();
    }

    public function get_today_customers()
    {
        $to_date = date("Y-m-d");
        $this->db->where('created_at >= "' . $to_date . ' 00:00:00"AND"' . $to_date . ' 23:59:59"');
        return $this->db->where(array('status' => '1'))->get('tbl_customer_details')->result_array();

    }

    ##comman
    public function count_dashboard($table_name)
    {
        return $this->db->where(array('status' => '1'))->get($table_name)->num_rows();
    }
    public function get_module_id($role_id)
    {
        return $this->db->select('module_id')->where(array('status' => '1', 'role_id' => $role_id))->get('tbl_module_permission')->result();
    }

    public function get_module_ul()
    {
        return $this->db->where(array('status' => '1'))->get('tbl_module')->result_array();
    }

    public function get_li($module_id)
    {
        return $this->db->where(array('status' => '1', 'module_id' => $module_id))->get('tbl_module_li')->result();
    }

    public function check_permission($contoller_name, $role_id, $permission)
    {

        $data = $this->db->select('rwx')
            ->where('tbl_module_permission.role_id', $role_id)
            ->where('tbl_module_permission.status', '1')
            ->where('tbl_module_li.li_controller', $contoller_name)
            ->join('tbl_module_li', 'tbl_module_li.module_id = tbl_module_permission.module_id')
            ->get('tbl_module_permission')->row();

        if (empty($data)) {
            $data = $this->db->select('rwx')
                ->where('tbl_module_permission.role_id', $role_id)
                ->where('tbl_module_permission.status', '1')
                ->where('tbl_module.ul_controller', $contoller_name)
                ->join('tbl_module', 'tbl_module.id = tbl_module_permission.module_id')
                ->get('tbl_module_permission')->row();
        }

        $user_permission = explode(',', $data->rwx);
        //$explode_permission = explode(',',$permission);
        $method_permisson = $permission['0'];

        if (in_array($method_permisson, $user_permission)) {
            return true;
        } else {
            return false;
        }

        /* for($i=0; $i<$count_ex_permisson; $i++)
    {
    //echo $permission[$i];
    if(in_array($permission[$i],$user_permission))
    {
    return true;
    }
    else
    {
    return false;
    }
    }*/

    }

    public function in_array_any($needles, $haystack)
    {
        return (bool) array_intersect($needles, $haystack);
    }

    public function get_num_to_string($number)
    {
        $decimal = round($number - ($no = floor($number)), 2) * 100;
        $hundred = null;
        $digits_length = strlen($no);
        $i = 0;
        $str = array();
        $words = array(0 => '', 1 => 'one', 2 => 'two',
            3 => 'three', 4 => 'four', 5 => 'five', 6 => 'six',
            7 => 'seven', 8 => 'eight', 9 => 'nine',
            10 => 'ten', 11 => 'eleven', 12 => 'twelve',
            13 => 'thirteen', 14 => 'fourteen', 15 => 'fifteen',
            16 => 'sixteen', 17 => 'seventeen', 18 => 'eighteen',
            19 => 'nineteen', 20 => 'twenty', 30 => 'thirty',
            40 => 'forty', 50 => 'fifty', 60 => 'sixty',
            70 => 'seventy', 80 => 'eighty', 90 => 'ninety');
        $digits = array('', 'hundred', 'thousand', 'lakh', 'crore');
        while ($i < $digits_length) {
            $divider = ($i == 2) ? 10 : 100;
            $number = floor($no % $divider);
            $no = floor($no / $divider);
            $i += $divider == 10 ? 1 : 2;
            if ($number) {
                $plural = (($counter = count($str)) && $number > 9) ? 's' : null;
                $hundred = ($counter == 1 && $str[0]) ? ' and ' : null;
                $str[] = ($number < 21) ? $words[$number] . ' ' . $digits[$counter] . $plural . ' ' . $hundred : $words[floor($number / 10) * 10] . ' ' . $words[$number % 10] . ' ' . $digits[$counter] . $plural . ' ' . $hundred;
            } else {
                $str[] = null;
            }

        }
        $Rupees = implode('', array_reverse($str));
        $paise = ($decimal) ? "and " . ($words[$decimal / 10] . " " . $words[$decimal % 10]) . ' Paise' : '';
        return '<strong>INR ' . ($Rupees ? ucwords($Rupees) . 'Rupees ' : '') . ucwords($paise) . ' Only</strong>';

    }

    public function currency_convert($num)
    {
        $x = round($num);
        $x_number_format = number_format($x);
        $x_array = explode(',', $x_number_format);
        $x_parts = array('k', 'm', 'b', 't');
        $x_count_parts = count($x_array) - 1;
        $x_display = $x;
        $x_display = $x_array[0] . ((int) $x_array[1][0] !== 0 ? '.' . $x_array[1][0] : '');
        $x_display .= $x_parts[$x_count_parts - 1];
        return $x_display;
    }

    public function current_page_url()
    {
        return (isset($_SERVER['HTTPS'])) ? "https://" : "http://" . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];

    }

    public function time_ago($datetime, $full = false)
    {
        $now = new DateTime;
        $ago = new DateTime($datetime);
        $diff = $now->diff($ago);

        $diff->w = floor($diff->d / 7);
        $diff->d -= $diff->w * 7;

        $string = array(
            'y' => 'year',
            'm' => 'month',
            'w' => 'week',
            'd' => 'day',
            'h' => 'hour',
            'i' => 'min',
            's' => 'sec',
        );
        foreach ($string as $k => &$v) {
            if ($diff->$k) {
                $v = $diff->$k . ' ' . $v . ($diff->$k > 1 ? 's' : '');
            } else {
                unset($string[$k]);
            }
        }

        if (!$full) {
            $string = array_slice($string, 0, 1);
        }

        return $string ? implode(', ', $string) . '' : 'just now';
    }

    /* Permission Role */

    public function get_module_category()
    {
        return $this->db->where(array('status' => '1'))->get('tbl_module_category')->result_array();
    }

    public function get_sub_module($module_id)
    {
        return $this->db->where(array('status' => '1', 'module_id' => $module_id))->get('tbl_module_subcategory')->result_array();
    }

    public function get_role_category()
    {
        return $this->db->where(array('status' => '1'))->get('tbl_role_category')->result_array();
    }

    public function get_non_assign_role_category()
    {
        $query = $this->db->query("select * from tbl_role_category where status = 1 AND id NOT IN(select role_id from tbl_role where status = '1')");
        return $query->result_array();

    }

    public function get_assign_role_category()
    {
        $query = $this->db->query("select * from tbl_role_category where status = 1 AND id IN(select role_id from tbl_role where status = '1')");
        return $query->result_array();

    }

    public function get_module_by_role_id($role_id)
    {
        return $this->db->select('tbl_role.*, tbl_module_category.module_name')
            ->where(array('tbl_role.status' => 1, 'tbl_role.role_id' => $role_id))
            ->join('tbl_module_category', 'tbl_module_category.id = tbl_role.module_id', 'left')
            ->group_by('tbl_role.module_id')
            ->get('tbl_role')
            ->result_array();
    }

    public function get_sidebar_module_by_role_id($role_id)
    {
        return $this->db->select('tbl_role.*, tbl_module_category.module_name')
            ->where(array('tbl_role.status' => 1, 'tbl_role.role_id' => $role_id, 'view_permission' => 'true'))
            ->join('tbl_module_category', 'tbl_module_category.id = tbl_role.module_id', 'left')
            ->group_by('tbl_role.module_id')
            ->get('tbl_role')
            ->result_array();
    }

    public function get_sub_module_by_module_id($role_id, $module_id)
    {
        return $this->db->select('tbl_role.*, tbl_module_category.module_name,  tbl_module_subcategory.sub_module_name')
            ->where(array('tbl_role.status' => 1, 'tbl_role.role_id' => $role_id, 'tbl_role.module_id' => $module_id))
            ->join('tbl_module_category', 'tbl_module_category.id = tbl_role.module_id', 'left')
            ->join('tbl_module_subcategory', 'tbl_module_subcategory.id = tbl_role.sub_module_id', 'left')
            ->get('tbl_role')
            ->result_array();
    }

    public function get_module_by_not_assign($role_id)
    {
        $query = $this->db->query("select * from tbl_module_category where status = 1 AND id NOT IN(select module_id from tbl_role where role_id='" . $role_id . "' AND status = '1')");
        return $query->result_array();
    }

    public function get_module_permission($column_permission, $role_id, $module_id)
    {
        return $this->db->where(array('status' => '1',
            'module_id' => $module_id,
            'role_id' => $role_id,
            $column_permission => 'true',
        ))->get('tbl_role')->row_array();
    }

    public function get_store_role()
    {
        return $this->db->select('tbl_role_category.*, store_name')
            ->where(array('tbl_role_category.status' => '1'))
            ->join('tbl_store', 'tbl_store.store_id = tbl_role_category.store_id', 'left')
            ->get('tbl_role_category')->result_array();
    }

    public function get_users_stores($user_id)
    {
        return $this->db->select('tbl_user_store_permission.*, store_name')
            ->where(array('tbl_user_store_permission.status' => '1', 'tbl_user_store_permission.user_id' => $user_id))
            ->group_by('tbl_user_store_permission.store_id')
            ->join('tbl_store', 'tbl_store.store_id = tbl_user_store_permission.store_id', 'left')
            ->get('tbl_user_store_permission')->result_array();

    }

    public function get_users()
    {
        return $this->db->where(array('status' => '1'))->get('tbl_user_type')->result_array();
    }

    public function get_user_multiple_role($user_id, $store_id)
    {
        return $this->db->select('tbl_user_store_permission.*, store_name, role_name')
            ->where(array('tbl_user_store_permission.status' => '1',
                'tbl_user_store_permission.user_id' => $user_id,
                'tbl_user_store_permission.store_id' => $store_id,
            ))

            ->join('tbl_store', 'tbl_store.store_id = tbl_user_store_permission.store_id', 'left')
            ->join('tbl_role_category', 'tbl_role_category.id = tbl_user_store_permission.role_permission_id', 'left')
            ->get('tbl_user_store_permission')->result_array();
    }

    public function check_role_permission()
    {
        $last = $this->uri->total_segments();
        $module = $this->uri->segment(1);

        $sub_module = $this->uri->segment($last - 1);
        $operation_segment = $this->uri->segment($last);
        $role_id = $this->_loginData->role_id;
        $segments = $this->uri->segment_array();

        /*var_dump($segments);
        exit;*/

        if (($operation_segment == 'list') or ($operation_segment == 'view')) {

            $sql = $this->db->where('tbl_role.view_permission', 'true');
        } else if ($operation_segment == 'edit') {
            $module = $this->uri->segment(1);
            $sub_module = $this->uri->segment(2);
            $sql = $this->db->where('tbl_role.update_permission', 'true');
        } else if ($operation_segment == 'delete') {
            $module = $this->uri->segment(1);
            $sub_module = $this->uri->segment(2);
            $sql = $this->db->where('tbl_role.delete_permission', 'true');
        } else if ($operation_segment == 'add') {
            $sql = $this->db->where('tbl_role.add_permission', 'true');
        } else if ($operation_segment == 'export') {
            $module = $this->uri->segment(1);
            $sub_module = $this->uri->segment(2);
            $sql = $this->db->where('tbl_role.export_permission', 'true');
        }

        $sql = $this->db
            ->select('tbl_role.*, tbl_module_category.module_name')
            ->where(array('tbl_role.status' => 1, 'tbl_role.role_id' => $role_id,
                'tbl_module_category.slug_module_name' => $module,

            ))
            ->join('tbl_module_category', 'tbl_module_category.id = tbl_role.module_id', 'left')

            ->get('tbl_role')->row();

        if (empty($sql)) {redirect('permission-not-found');exit;}
    }

    public function check_role_permission_ajax($permission_number, $type)
    {
        if ($type != '1') {
            $last = $this->uri->total_segments();

            $operation_segment = $this->uri->segment($last);
            $role_id = $this->_loginData->role_id;

            $module = $this->uri->segment(1);
            $sub_module = $this->uri->segment(2);

            $sql = $this->db
                ->select('tbl_role.*, tbl_module_category.module_name')
                ->where(array('tbl_role.status' => 1, 'tbl_role.role_id' => $role_id,
                    'tbl_module_category.slug_module_name' => $module,

                ))
                ->join('tbl_module_category', 'tbl_module_category.id = tbl_role.module_id', 'left')

                ->get('tbl_role')->row();

            if ($permission_number == '9') {

                if ($sql->delete_permission == 'true') {
                    return $sql;
                }

            } elseif (($permission_number == '1') or ($permission_number == '2')) {
                if ($sql->update_permission == 'true') {
                    return $sql;
                }

            }
        } else {
            return '1';
        }

    }

    /*Store Module*/
    public function get_languages()
    {
        return $this->db->where(array('status' => '1'))
            ->get('tbl_languages')
            ->result_array();
    }

    public function get_state_by_id($state_id)
    {
        return $this->db->where(array('id' => $state_id))
            ->get('tbl_states')
            ->row();
    }

    public function get_city_by_id($city_id)
    {
        return $this->db->where(array('id' => $city_id))
            ->get('tbl_cities')
            ->row();
    }
    /*end*/

    public function get_orders($order_id)
    {
        return $this->db->where(array('status' => '1', 'order_id' => $order_id))
            ->get('tbl_order_details')
            ->result_array();
    }

    public function get_product_by_id($product_id)
    {
        return $this->db->where(array('status' => '1', 'id' => $product_id))
            ->order_by("product_name", "asc")
            ->get('tbl_product')
            ->result_array();
    }

    public function get_product()
    {
        return $this->db->where(array('status' => '1'))
            ->order_by("product_name", "asc")
            ->get('tbl_shop_product')
            ->result_array();
    }

    public function get_all_color()
    {
        return $this->db->where(array('status' => '1'))
            ->where("language_id", $this->lang_id->id)
            ->get('tbl_shop_product_color')
            ->result_array();
    }

    public function get_shop_product($category_id, $subcategory_id)
    {
        return $this->db->where(array('status' => '1', 'category_id' => $category_id, 'subcategory_id' => $subcategory_id))
            ->order_by("product_name", "asc")
            ->get('tbl_shop_product')
            ->result_array();
    }

    public function send_message($numbers, $message)
    {
        // Account details
        $apiKey = urlencode('0Q7ZAuoNcBk-wE8A4R4RsorBya08om4cf3W1mVEQ2a');

        // Message details
        $numbers = array($numbers);
        $sender = urlencode('TXTLCL');
        $message = rawurlencode($message);

        $numbers = implode(',', $numbers);

        // Prepare data for POST request
        $data = array('apikey' => $apiKey, 'numbers' => $numbers, "sender" => $sender, "message" => $message);

        // Send the POST request with cURL
        $ch = curl_init('https://api.textlocal.in/send/');
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $response = curl_exec($ch);
        curl_close($ch);

        // Process your response here
        //echo $response;
    }

}
