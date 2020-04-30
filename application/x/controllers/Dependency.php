<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Dependency extends CI_Controller
{

    public $_loginId = array();
    public $_loginData = array();
    public $lang_id = array();

    function __construct()
    {

        parent::__construct();
        /* Get session data */
        $this->lang_id = $this->session->userdata('languageSession');
        $this->_loginId = $this->session->userdata(APP_NAME);
        $this->_type = $this->_loginId['id']['type'];
        
        if($this->_type == 'user')
        {
             /* Check session empty or not */
            if (!empty($this->_loginId)) {
                $this->_loginData = $this->db->from('tbl_storeusers')->where(array('storeuser_id' => $this->_loginId['id']['id']))->get()->row();
            }
            
        }
        else
        {
             /* Check session empty or not */
            if (!empty($this->_loginId)) {
                $this->_loginData = $this->db->from('tbl_admin')->where(array('id' => 
                    $this->_loginId['id']['id']))->get()->row();
            }
        }

        /* Check session */
        if (empty($this->_loginData)) redirect('x/login');/* Redirect to dashboard Proparty */

        // $this->table_name = "tbl_states";
        // $this->dir_path = "states/"; 
        // $this->name = "states"; 

    }
 




    public function getstate()
    {
        $countryID = $_POST["country_id"];
        $allStates = $this->admin_model->get_stateData($countryID);
      
        $output = '<option value="">Select State</option>';
        foreach ($allStates as $stateData) {

            $output .= '<option value="'.$stateData['id'].'">'.$stateData['state_name'].'</option>';
            # code...
        }

        echo $output;
  

    }    



    public function getstateUpdate()
    {
        $countryID = $_POST["country_id"];
        $allStates = $this->admin_model->get_stateData($countryID);
      
        $output = '<option value="">Select State</option>';
        foreach ($allStates as $stateData) {

            $output .= '<option value="'.$stateData['id'].'">'.$stateData['state_name'].'</option>';
            # code...
        }

        echo $output;
  

    }   




    public function getcity()
    {
        $state_ID = $_POST["state_id"];
        $allCity = $this->admin_model->get_cityData($state_ID);
      
        $output = '<option value="">Select City</option>';
        foreach ($allCity as $cityData) {

            $output .= '<option value="'.$cityData['id'].'">'.$cityData['city_name'].'</option>';
            # code...
        }

        echo $output;
  

    }    




    public function getdeals()
    {
        $sourceID = $_POST["source_id"];
        $allDealsBySource = $this->admin_model->get_sourceData($sourceID);
      
        $output = '<option value="">Select Deal</option>';
        foreach ($allDealsBySource as $DealsData) {

            $output .= '<option value="'.$DealsData['id'].'">'.$DealsData['deal_title'].' - '.$DealsData['deal_contract_id'].'</option>';
            # code...
        }

        echo $output;
  

    } 



    public function getdealsofexcel()
    {
       //echo $_POST["source_id"]; exit;

        // $db_handle = new Dependency();
        $dealID = $_POST["deal_id"];
        $allDealsOfExcel = $this->admin_model->get_dealData($dealID);

        //echo "<pre>"; print_r($allDealsOfExcel); exit;
      
        $output = '

                                 <table class="table table-striped table-bordered table-hover table-checkable" id="datatable_ajax">
                                         <thead>
                                            <tr role="row" class="heading">
                                               
                                               <th width="1%">
                                                  Select
                                               </th>
                                               
                                              <!--  <th width="1%">Date</th> -->
                                               <th width="2%">Deal Title</th>
                                               <th width="1%">Departure</th>
                                               <th width="2%">Dates</th>
                                               <th width="1%">Duration</th>
                                               <th width="2%">BoardBasis</th>
                                               <th width="1%">Extra</th>
                                               <th width="1%">Selling Price &pound;</th>
                                               <th width="1%">Commission Amount</th>
                                               <th width="1%">VAT</th>
                                               <th width="1%">Amount Received</th>
                                               <!-- <th width="1%" data-sortable="false">Actions</th> -->
                                            </tr>
                                         </thead>
                                         <tbody>
                                         </tbody>
                                     

        <br>
            <hr>
                <h3 align="center">Deal Results</h3>
            <hr>';
        foreach ($allDealsOfExcel as $DealsData) {

            $output .= '<tr role="row" class="odd">
                   
                    <td>
                      <input type="radio" name="getselectedradio" class="'.(($DealsData["deal_commission_amount"])*100).'" value="'.$DealsData["deal_selling_price"].'" id="aaa" />
                    </td>
                    <td class="sorting_1">'.$DealsData["deal_title"].'</td>
                    <td>'.$DealsData["deal_airport_code"].'</td>
                    <td>'.$DealsData["deal_start_date"].' to '.$DealsData["deal_end_date"].'</td>
                    <td>'.$DealsData["deal_duration"].'</td>
                    <td>'.$DealsData["deal_board_basis"].'</td>
                    <td>'.$DealsData["deal_extra"].'</td>
                    <td>'.$DealsData["deal_selling_price"].'</td>
                    <td>'.(($DealsData["deal_commission_amount"])*100).'&percnt;</td>
                    <td>'.$DealsData["deal_vat"].'</td>
                    <td>'.$DealsData["deal_amount_received"].'</td>
                   </tr>';
            # code...
        }

        $output .= ' </table>';
        echo $output;
  

    } 


    public function getdealsasprice()
    {
       //echo $_POST["source_id"]; exit;

        // $db_handle = new Dependency();
        $dealPrice = $_POST["deal_price"];
        $allDealsByPrice = $this->admin_model->get_deal_by_price($dealPrice);

        $output = '

                                 <table class="table table-striped table-bordered table-hover table-checkable" id="datatable_ajax">
                                         <thead>
                                            <tr role="row" class="heading">
                                            <!--
                                               <th width="1%">
                                                  <input type="checkbox" class="group-checkable" id="checkbox">
                                               </th>
                                              -->
                                              <!--  <th width="1%">Date</th> -->
                                               <th width="1%">
                                                  Select
                                               </th>
                                               <th width="2%">Deal Title</th>
                                               <th width="1%">Departure</th>
                                               <th width="2%">Dates</th>
                                               <th width="1%">Duration</th>
                                               <th width="2%">BoardBasis</th>
                                               <th width="1%">Extra</th>
                                               <th width="1%">Selling Price &pound;</th>
                                               <th width="1%">Commission Amount</th>
                                               <th width="1%">VAT</th>
                                               <th width="1%">Amount Received</th>
                                               <!-- <th width="1%" data-sortable="false">Actions</th> -->
                                            </tr>
                                         </thead>
                                         <tbody>
                                         </tbody>
                                     




        <br>
            <hr>
                <h3 align="center">Deal Results</h3>
            <hr>';
        foreach ($allDealsByPrice as $dealsByPrice) {

            $output .= '<tr role="row" class="odd">
                    <!--
                    <td><div class="checker"><span><input type="checkbox" value="15" name="id[]"></span></div></td>
                    -->
                    <td>
                      <input type="radio" name="getselectedradio" class="'.(($dealsByPrice["deal_commission_amount"])*100).'" value="'.$dealsByPrice["deal_selling_price"].'" id="aaa" />
                    </td>
                    <td class="sorting_1">'.$dealsByPrice["deal_title"].'</td>
                    <td>'.$dealsByPrice["deal_airport_code"].'</td>
                    <td>'.$dealsByPrice["deal_start_date"].' to '.$dealsByPrice["deal_end_date"].'</td>
                    <td>'.$dealsByPrice["deal_duration"].'</td>
                    <td>'.$dealsByPrice["deal_board_basis"].'</td>
                    <td>'.$dealsByPrice["deal_extra"].'</td>
                    <td>'.$dealsByPrice["deal_selling_price"].'</td>
                    <td>'.(($dealsByPrice["deal_commission_amount"])*100).'&percnt;</td>
                    <td>'.$dealsByPrice["deal_vat"].'</td>
                    <td>'.$dealsByPrice["deal_amount_received"].'</td>
                   </tr>';
            # code...
        }
        $output .= ' </table>';
        echo $output;
  

    } 




    public function getage()
    {

       $dateOfBirth = $_POST["dob_value"];;
        $today = date("Y-m-d");
        $diff = date_diff(date_create($dateOfBirth), date_create($today));
        $output = $diff->format('%y');


        echo $output;
  

    } 

    public function getagents()
    {
        $storeID = $_POST["store_id"];
        $usersByStore = $this->admin_model->get_all_agents_by_store($storeID);

      
        $output = '<option value="">Select Agent</option>';
        foreach ($usersByStore as $storewiseUser) {

            $output .= '<option value="'.$storewiseUser['storeuser_id'].'">'.$storewiseUser['storeuser_fname'].'  '.$storewiseUser['storeuser_lname'].'</option>';
        }

        echo $output;
  

    } 


    public function get_package_sub_category()
    {
    
        $category_id = $_POST["category_id"];
        $sub_category = $this->admin_model->get_package_subcategory_by_catid($category_id);
      
        $output = '<option value="">Select Subcategory</option>';
        foreach ($sub_category as $row) {

            $output .= '<option value="'.$row['id'].'">'.$row['package_subcategory_name'].'</option>';
           
        }

        echo $output;

    }    



    public function get_product_sub_category()
    {
    
        $category_id = $_POST["category_id"];
        $sub_category = $this->admin_model->get_shop_sub_category($category_id);
      
        $output = '<option value="">Select Subcategory</option>';
        foreach ($sub_category as $row) {

            $output .= '<option value="'.$row['id'].'">'.$row['category_name'].'</option>';
           
        }

        $brand = $this->admin_model->get_brand_by_cat_id($category_id);
        $output1 = '<option value="">Select Brand</option>';
        foreach ($brand as $br) {

            $output1 .= '<option value="'.$br['id'].'">'.$br['brand_name'].'</option>';
           
        }
        $data = array('subcategory' => $output,'brand' => $output1);
        
         echo json_encode($data);
         exit;

    } 
    public function get_product()
    {
    
        $category_id = $_POST["category_id"];
        $subcategory_id = $_POST["subcategory_id"];

        $product = $this->admin_model->get_shop_product($category_id,$subcategory_id);
      
        $output = '<option value="">Select Subcategory</option>';
        foreach ($product as $row) {

            $output .= '<option value="'.$row['id'].'">'.$row['product_name'].'</option>';
           
        }

        echo $output;

    } 


    public function get_product_by_subcategory()
    {
        $category_id = $_POST["category_id"];
        $subcategory_id = $_POST["subcategory_id"];
        $productData = $this->db->where(array('status' => '1', 'subcategory_id' => $subcategory_id, 'category_id!=' => '0'))->get('tbl_shop_product')->result_array();

        $output = '<option value="">Select Product</option>';
        foreach ($productData as $product) {
            $output .= '<option value="'.$product['id'].'">'.$product['product_name'].'</option>';
        }

        echo $output;
    } 


    public function get_product_specific_sizes()
    {
        $category_id = $_POST["category_id"];
        $sub_category_id = $_POST["sub_category_id"];
        $productSizes = $this->db->where(array('category_id' => $category_id, 'subcategory_id' => $sub_category_id, 'status' => '1'))->get('tbl_shop_size')->result_array();

        if(!empty($productSizes)) {
            $output = '<option value="">Select Subcategory</option>';
            foreach ($productSizes as $row) {
                $output .= '<option value="'.$row['id'].'">'.$row['size_name'].'</option>';
            }
        }
        else {
            $output = '<option value="">No size available for this product</option>';
        }

        echo $output;
    } 


    public function get_size_by_product_id()
    {

        $product_id = $_POST["product_id"];
    
        $productData = $this->db->where(array('id' => $product_id, 'status' => '1'))->get('tbl_shop_product')->row();
        $category_id = $productData->category_id;
        $sub_category_id = $productData->subcategory_id;
        $productSizes = $this->db->where(array('category_id' => $category_id, 'subcategory_id' => $sub_category_id, 'status' => '1'))->get('tbl_shop_size')->result_array();

        if(!empty($productSizes)) {
            $output = '<option value="">Select Size</option>';
            foreach ($productSizes as $row) {
                $output .= '<option value="'.$row['id'].'">'.$row['size_name'].'</option>';
            }
        }
        else {
            $output = '<option value="">No size available for this product</option>';
        }

        echo $output;

    } 



    public function get_size_of_product()
    {

        $product_id = $_POST["product_id"];
        //$productData = $this->db->where(array('id' => $product_id, 'status' => '1'))->get('tbl_shop_product')->row();
        //$size_id = $productData->category_id;
        $productData = $this->db->where(array('product_id' => $product_id, 'status' => '1'))->get('tbl_shop_product_attribute')->result_array();
        //$sub_category_id = $productData->subcategory_id;
        //$productSizes = $this->db->where(array('category_id' => $category_id, 'subcategory_id' => $sub_category_id, 'status' => '1'))->get('tbl_shop_size')->result_array();

        /*if(!empty($productSizes)) {
            $output = '<option value="">Select Size</option>';
            foreach ($productSizes as $row) {
                $output .= '<option value="'.$row['id'].'">'.$row['size_name'].'</option>';
            }
        }
        else {
            $output = '<option value="">No size available for this product</option>';
        }*/
        //echo "<pre>"; print_r($productData); exit;
        $sizeData = "";
        $color_code = "";
        $color_name = "";
        $quantity = "";
        $price = "";
        if(!empty($productData)) {
                $sizeData .= '<option value="">Select Size</option>';
            foreach ($productData as $row) {
                $size_id = $row['size_id'];
                $size = $this->db->where(array('status' => '1', 'id' => $size_id))->get('tbl_shop_size')->row();
                $sizeData .= '<option value="'.$size->id.'">'.$size->size_name.'</option>';
            }
        }
        else {
            $sizeData = '<option value="">No size available for this product</option>';
            $color_code = "";
            $color_name = "";
            $quantity = "";
            $price = "";
        }



        $color = "";
        $result = array('size' => $sizeData, 'color_code' => $color_code, 'color_name' => $color_name, 'quantity' => $quantity, 'price' => $price);

                echo json_encode($result);

    } 
    


    public function get_product_attributes()
    {

        $product_id = $_POST["product_id"];
        $size_id = $_POST["size_id"];
        $productData = $this->db->where(array('size_id' => $size_id, 'product_id' => $product_id, 'status' => '1'))->get('tbl_shop_product_attribute')->row();
        $attribute_id = "";
        $sizeData = "";
        $color_code = "";
        $color_name = "";
        $quantity = "";
        $price = "";
        $gender = "";
        $sku = "";
        if(!empty($productData)) {
                $attribute_id = $productData->id;
                $color_code = $productData->color_code;
                $color_name = $productData->color_name;
                $quantity = $productData->quantity;
                $price = $productData->price;
                $gender = $productData->gender;
                $sku = $productData->sku;
        }
        else {
            $attribute_id = "";
            $color_code = '';
            $color_name = '';
            $quantity = '';
            $price = '';
            $gender = '';
            $sku = '';
        }



        $color = "";
        $result = array('attribute_id' => $attribute_id, 'color_code' => $color_code, 'color_name' => $color_name, 'quantity' => $quantity, 'price' => $price, 'gender' => $gender, 'sku' => $sku);

                echo json_encode($result);

    } 
    

    public function checkSKU()
    {
        $product_id = $_POST['product_id'];
        $sku_val = $_POST["sku_val"];
        if($product_id != ''){
            $maindata = $this->db->where(array('sku' => $sku_val,'language_id' => $this->lang_id->id,'id' => $product_id, 'status' => '1'))->get('tbl_shop_product')->row();
            if(!empty($maindata)){
                $checkSKU = "";
            }else{
                $checkSKU = $this->db->where(array('sku' => $sku_val,'language_id' => $this->lang_id->id, 'status' => '1'))->get('tbl_shop_product')->result_array();
            }
        }else{
            $checkSKU = $this->db->where(array('sku' => $sku_val,'language_id' => $this->lang_id->id, 'status' => '1'))->get('tbl_shop_product')->result_array();
        }
        $output = "";
        if(!empty($checkSKU)) {
            $output = 'false';
        } else {
            $output = 'true';
        }

        echo $output;

    } 

    public function checkSKUupdate()
    {
    
        $sku_val = $_POST["sku_val"];
        $selected_product = $_POST["selected_product"];
        $checkSKU = $this->db->where(array('sku' => $sku_val, 'status' => '1'))->get('tbl_shop_product_attribute')->row();
        $output = "";
        if(!empty($checkSKU)) {
          if( $checkSKU->product_id != $selected_product ){
            $output = 'false';
          } else {
            $output = 'true';
          }
        } else {
            $output = 'true';
        }

        echo $output;

    } 


    public function deleteTotalCostCloneRow()
    {
        $id = $_POST["hidden_id"];
 
        $this->db->where('id', $id);

        $data = array(
            'status' => '9',
            'updated_at' => date('Y-m-d H:i:s')
        );
       $status = $this->db->update('tbl_booking_total_cost_clone', $data);
      
        $output = '<div class="alert alert-danger" role="alert">Record deleted!</div>';

        echo $output;
  

    } 

    

}