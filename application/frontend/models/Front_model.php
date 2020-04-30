<?php

class Front_model extends CI_Model
{
    public function getCountryDb()
    {
        $this->db->select('country_name');
        $this->db->select('id');
        $this->db->from('tbl_countries');
        $this->db->order_by('country_name', 'asc');
        $query = $this->db->get();
        return $query->result();

    }

    public function getStateDb($country_id)
    {
        return $this->db->where(array('status' => '1', 'country_id' => $country_id))->order_by('id', 'asc')->get('tbl_states')->result();
    }

    public function getCityDb($state_id)
    {
        $this->db->select('city_name');
        $this->db->select('id');
        $this->db->from('tbl_cities');
        $this->db->order_by('city_name', 'asc');
        $this->db->where('state_id', $state_id);
        $query = $this->db->get();
        return $query->result();
    }

    public function get_billing_details($user_id)
    {
        return $this->db->where(array('status' => '1', 'user_id' => $user_id))->get('tbl_billing_address')->row();
    }

    public function get_about_us()
    {
        return $this->db->where(array('status' => '1'))->limit(1)->order_by('id', 'desc')->get('tbl_about_us')->row();
    }

    public function get_counter()
    {
        return $this->db->where(array('status' => '1'))->limit(3)->order_by('id', 'desc')->get('tbl_counter')->result_array();
    }

    public function get_why_choose_us()
    {
        return $this->db->where(array('status' => '1'))->limit(4)->order_by('id', 'desc')->get('tbl_why_choose_us')->result_array();
    }

    public function get_faq()
    {
        return $this->db->where(array('status' => '1'))->order_by('id', 'desc')->get('tbl_faq')->result_array();
    }

    public function get_tc()
    {
        return $this->db->where(array('status' => '1'))->order_by('id', 'desc')->get('tbl_tc')->result_array();
    }

    public function get_web_setting()
    {
        return $this->db->where(array('status' => '1'))->get('tbl_web_setting')->row();
    }

    public function get_slider()
    {
        return $this->db->where(array('status' => '1'))->order_by('id', 'desc')->get('tbl_slider_image')->result_array();
    }

    public function get_product_category()
    {
        return $this->db->where(array('status' => '1'))->order_by('id', 'desc')->get('tbl_product_category')->result_array();
    }

    public function get_product_subcategory($category_id)
    {
        return $this->db->where(array('status' => '1', 'category_id' => $category_id))->order_by('id', 'desc')->get('tbl_product_subcategory')->result_array();
    }

    public function get_product($category_id, $sub_category_id)
    {
        return $this->db->where(array('status' => '1', 'category_id' => $category_id, 'sub_category_id' => $sub_category_id))->order_by('id', 'desc')->get('tbl_product')->result_array();
    }

    public function get_product_detail($product_id)
    {
        return $this->db->where(array('tbl_product.status' => '1', 'tbl_product.id' => $product_id))
            ->join('tbl_product_category', 'tbl_product_category.id = tbl_product.category_id', 'left')
            ->join('tbl_product_subcategory', 'tbl_product_subcategory.id = tbl_product.sub_category_id', 'left')
            ->join('tbl_tag', 'tbl_tag.id = tbl_product.tag_id', 'left')
            ->get('tbl_product')->row();
    }

    public function get_product_gallery($product_id)
    {
        return $this->db->where(array('status' => '1', 'product_id' => $product_id))->order_by('id', 'desc')->get('tbl_gallery')->result_array();
    }

    public function get_product_by_category_id($category_id)
    {
        return $this->db->where(array('status' => '1', 'category_id' => $category_id))->order_by('id', 'desc')->get('tbl_product')->result_array();
    }

    public function get_product_by_subcategory_id($sub_category_id)
    {
        return $this->db->where(array('status' => '1', 'sub_category_id' => $sub_category_id))->order_by('id', 'desc')->get('tbl_product')->result_array();
    }

    public function get_latest_product()
    {
        return $this->db->where(array('status' => '1'))->order_by('id', 'desc')->get('tbl_product')->result_array();
    }

    public function get_best_seller_product()
    {
        return $this->db->where(array('status' => '1', 'best_product!=' => '0'))->order_by('best_product', 'desc')->limit(15)->get('tbl_product')->result_array();
    }

    public function get_deal_of_the_week_product()
    {
        return $this->db->where(array('status' => '1', 'deal_week' => '1'))->order_by('id', 'desc')->limit(15)->get('tbl_product')->result_array();
    }

    public function get_featured_product()
    {
        return $this->db->where(array('status' => '1', 'featured_products' => '1'))->order_by('id', 'desc')->limit(15)->get('tbl_product')->result_array();
    }

    public function get_wishlist($user_id)
    {
        return $this->db->where(array('status' => '1', 'user_id' => $user_id))->order_by('id', 'desc')->get('tbl_wishlist')->result_array();
    }

    public function get_cart($user_id)
    {
        $this->db->select_sum('quantity')->where(array('status' => '1', 'user_id' => $user_id))->order_by('id', 'desc');
        $result = $this->db->get('tbl_cart')->row();
        return $result->quantity;
    }

    public function get_cart_data($user_id)
    {
        return $this->db->where(array('status' => '1', 'user_id' => $user_id))->order_by('id', 'desc')->get('tbl_cart')->result_array();
    }

    public function get_filter_products($min_price, $max_price, $discount, $popular_picks, $availability, $sort_by, $start_from, $per_page, $category_id, $sub_category_id, $keyword)
    {
        if (!empty($keyword) && $keyword != '') {
            $sql = $this->db->where(array('tbl_product.status' => '1'))
                ->group_start()
                ->like('tbl_product.product_name', $keyword, 'both')
                ->or_like('tbl_product_category.category_name', $keyword, 'both')
                ->or_like('tbl_product_subcategory.sub_category_name', $keyword, 'both')
                ->limit($per_page, $start_from)
                ->join('tbl_product_category', 'tbl_product_category.id = tbl_product.category_id', 'left')
                ->join('tbl_product_subcategory', 'tbl_product_subcategory.id = tbl_product.sub_category_id', 'left')
                ->group_end();
        }
        if (!empty($category_id) && $category_id != '') {
            if ($sort_by == 'alphabetical' || $sort_by == 'popularity' || $sort_by == 'lowtohigh' || $sort_by == 'hightolow') {
                $sql = $this->db->group_start();
                $sql = $this->db->where(array('tbl_product.category_id' => $category_id));
                $sql = $this->db->group_end();
            } else {
                $sql = $this->db->group_start();
                $sql = $this->db->where(array('tbl_product.category_id' => $category_id))->order_by('id', 'desc');
                $sql = $this->db->group_end();
            }
        }
        if (!empty($sub_category_id) && $sub_category_id != '') {
            if ($sort_by == 'alphabetical' || $sort_by == 'popularity' || $sort_by == 'lowtohigh' || $sort_by == 'hightolow' || $sort_by == 'newestfirst') {
                $sql = $this->db->group_start();
                $sql = $this->db->where(array('tbl_product.sub_category_id' => $sub_category_id));
                $sql = $this->db->group_end();
            } else {
                $sql = $this->db->group_start();
                $sql = $this->db->where(array('tbl_product.sub_category_id' => $sub_category_id))->order_by('id', 'desc');
                $sql = $this->db->group_end();
            }
        }
        if (isset($min_price, $max_price) || (isset($discount) && !empty($discount)) || (isset($popular_picks) && !empty($popular_picks)) || (isset($availability) && !empty($availability) && $availability == 1) || (isset($sort_by) && !empty($sort_by))) {
            if (isset($min_price, $max_price)) {
                $sql = $this->db->group_start();
                $sql = $this->db->where(DISCOUNT_PRICE . '>= ' . $min_price . ' AND ' . DISCOUNT_PRICE . ' <= ' . $max_price . '');
                $sql = $this->db->group_end();
            }
            if (isset($discount) && !empty($discount)) {
                $sql = $this->db->group_start();
                if (in_array("upto5", $discount)) {
                    $sql = $this->db->or_where("tbl_product.discount_percentage < 5");
                }
                if (in_array("bet5to10", $discount)) {
                    $sql = $this->db->or_where("tbl_product.discount_percentage BETWEEN 5 AND 10");
                }
                if (in_array("bet15to25", $discount)) {
                    $sql = $this->db->or_where("tbl_product.discount_percentage BETWEEN 15 AND 25");
                }
                if (in_array("more25", $discount)) {
                    $sql = $this->db->or_where("tbl_product.discount_percentage > 25");
                }
                $sql = $this->db->group_end();
            }
            if (isset($popular_picks) && !empty($popular_picks)) {
                if (in_array("new", $popular_picks)) {
                    $sql = $this->db->order_by('id', 'desc');
                }
                if (in_array("deal", $popular_picks) || in_array("featured", $popular_picks) || in_array("best", $popular_picks)) {
                    $sql = $this->db->group_start();
                    if (in_array("deal", $popular_picks)) {
                        $sql = $this->db->or_where('tbl_product.deal_week', '1');
                    }
                    if (in_array("featured", $popular_picks)) {
                        $sql = $this->db->or_where('tbl_product.featured_products', '1');
                    }
                    if (in_array("best", $popular_picks)) {
                        $sql = $this->db->or_where('tbl_product.best_product', '1');
                    }
                    $sql = $this->db->group_end();
                }
            }
            if (isset($availability) && !empty($availability) && $availability == 1) {
                $sql = $this->db->group_start();
                $sql = $this->db->where('tbl_product.availability', '1');
                $sql = $this->db->group_end();
            }
            if (isset($sort_by) && !empty($sort_by)) {
                if ($sort_by == 'newestfirst') {
                    $sql = $this->db->order_by('tbl_product.id', 'desc');
                } else if ($sort_by == 'alphabetical') {
                    $sql = $this->db->order_by('product_name', 'asc');
                } else if ($sort_by == 'popularity') {
                    $sql = $this->db->order_by('tbl_product.hits', 'desc');
                } else if ($sort_by == 'lowtohigh') {
                    $sql = $this->db->order_by(DISCOUNT_PRICE, 'asc');
                } else if ($sort_by == 'hightolow') {
                    $sql = $this->db->order_by(DISCOUNT_PRICE, 'desc');
                }
            }
        }
        return $sql = $this->db->where('tbl_product.status', '1')->limit($per_page, $start_from)->get('tbl_product')->result_array();
    }
}
