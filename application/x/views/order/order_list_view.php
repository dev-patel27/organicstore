<!-- INCLUDE HEADER -->
<?php $this->load->view('includes/header');?>
<link rel="stylesheet" type="text/css" media="screen" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datetimepicker/4.17.37/css/bootstrap-datetimepicker.min.css" />
<!-- BEGIN CONTAINER -->
<div class="page-container">
   <!-- BEGIN SIDEBAR -->
   <?php $this->load->view('includes/sidebar');?>
   <!-- END SIDEBAR -->
   <!-- BEGIN CONTENT -->
   <div class="page-content-wrapper">
      <!-- BEGIN CONTENT BODY -->
      <!-- BEGIN PAGE HEAD-->
      <!-- BEGIN PAGE CONTENT BODY -->
      <div class="page-content" >
         <!-- BEGIN PAGE HEADER-->
         <!-- BEGIN THEME PANEL -->
         <!-- END THEME PANEL -->
         <!-- BEGIN PAGE BAR -->
         <div class="page-bar">
            <ul class="page-breadcrumb">
               <li>
                  <span>Order</span>
                  <i class="fa fa-circle"></i>
               </li>
               <li>
                  <span>View</span>
               </li>
            </ul>
         </div>
         <!-- END PAGE BREADCRUMBS -->
         <!-- BEGIN PAGE CONTENT INNER -->
         <div class="row">
            <div class="portlet light">
               <div class="portlet-body form">
                  <!-- BEGIN FORM-->
                     <div class="alert alert-danger display-hide">
                        <button class="close" data-close="alert"></button> You have some form errors. Please check below.
                     </div>
                     <div class="col-md-12 ">
                        <div class="form-horizontal">
                           <div class="form-group">
                              <label class="col-md-3 control-label">Order ID<span class="required"> : </span></label>
                              <div class="col-md-9" style="position: relative;top: 8px;">
                                    <p><?=$result['0']->order_id;?></p>
                              </div>
                           </div>
                            <div class="form-group">
                              <label class="col-md-3 control-label">Email<span class="required"> : </span></label>
                              <div class="col-md-9" style="position: relative;top: 8px;">
                                    <p><?=$result['0']->email;?></p>
                              </div>
                           </div>
                            <div class="form-group">
                              <label class="col-md-3 control-label">Contact Number<span class="required"> : </span></label>
                              <div class="col-md-9" style="position: relative;top: 8px;">
                                    <p><?=$result['0']->mobile_no;?></p>
                              </div>
                           </div>
                            <div class="form-group">
                              <label class="col-md-3 control-label">Total Amount<span class="required"> : </span></label>
                              <div class="col-md-9" style="position: relative;top: 8px;">
                                    <p>₹<?=$result['0']->grand_total;?></p>
                              </div>
                           </div>


                            <div class="form-group">
                              <label class="col-md-3 control-label">Order Date <span class="required"> : </span></label>
                              <div class="col-md-9" style="position: relative;top: 8px;">
                                 <p><?php echo date('d/m/Y', strtotime($result['0']->created_at)); ?></p>
                              </div>
                           </div>
                           <?php
/* if($result['0']->order_status == 0) {
$status_name = '<span class="label label-sm label-danger">Cancelled</span>';
}
elseif ($result['0']->order_status == 1) {
$status_name = '<span class="label label-sm label-success">Success</span>';
}
elseif ($result['0']->order_status == 2) {
$status_name = '<span class="label label-sm label-info">Confirmed</span>';
}
elseif ($result['0']->order_status == 3) {
$status_name = '<span class="label label-sm label-default">Shipped</span>';
}
elseif ($result['0']->order_status == 4) {
$status_name = '<span class="label label-sm label-primary">Delivered</span>';
}
elseif ($result['0']->order_status == 5) {
$status_name = '<span class="label label-sm label-warning">Reject</span>';
}
else {
$status_name = "";
} */
?>
                            <!-- <div class="form-group">
                              <label class="col-md-3 control-label">Order Status <span class="required"> : </span></label>
                              <div class="col-md-9" style="position: relative;top: 8px;">
                                 <p><?php /* echo $status_name; */?></p>
                              </div> -->
                           </div>


                                     <div class="portlet light bordered">
                                       <div class="portlet-body">
                                          <ul class="nav nav-pills">
                                             <li class="active">
                                                <a data-toggle="tab" aria-expanded="true">Address </a>
                                             </li>
                                          </ul>
                                          <div class="tab-content">
                                             <div class="tab-pane fade active in" id="tab_4_1">
                                                <p>
                                                First Name : <?=$result[0]->first_name;?><br>
                                                Last Name : <?=$result[0]->last_name;?><br>
                                                Email : <?=$result[0]->email;?><br>
                                                Mobile number : <?=$result[0]->mobile_no;?><br>
                                                Address : <?=$result[0]->address;?><br>
                                                <?php
$country = $this->admin_model->get_country_name($result[0]->country);
$state = $this->admin_model->get_state_by_id($result[0]->state);
$city = $this->admin_model->get_city_by_id($result[0]->city);
?>
                                                Country Name : <?=$country->country_name;?><br>
                                                State Name : <?=$state->state_name;?><br>
                                                City Name : <?=$city->city_name;?><br>
                                                Post Code : <?=$result[0]->post_code;?><br>
                                                Note : <?=$result[0]->additional_note;?><br>
                                                </p>
                                             </div>

                                          </div>
                                       </div>
                                    </div>
                           <div class="col-md-12">
                           <?php
$get_products = $this->admin_model->get_orders($result['0']->order_id);
foreach ($get_products as $row) {
    $result_data = $this->admin_model->get_product_by_id($row["product_id"]);
    foreach ($result_data as $value) {
        $category = $this->db->where(array('status' => '1', 'id' => $value["category_id"]))->get('tbl_product_category')->result_array();
        if ($value['product_name'] != "") {
            /*echo "<pre>"; print_r($color); */
            $eximg = $value["image"];

            ?>
                                <div class="col-md-6">

                                    <div class="form-group" style="border: 1px solid #ccc;">
                                      <div class="col-md-4">
                                                  <?php
if ($eximg == "") {
                $image = '<img width="150px" height="150px" src="' . DEFAULT_IMAGE . '">';
            } else {
                $image = '<img src="' . PRODUCT_IMG_URL . $eximg . '"  width="100px" height="100px" alt="" style="margin: 10px 5px;">';
            }
            echo $image;
            ?>
                                      </div>
                                      <div class="col-md-8" style="position: relative;top: 8px;">
                                         <p>Product Name : <?php echo $value['product_name']; ?></p>
                                         <p>Category : <?php echo $category[0]['category_name']; ?></p>
                                         <p>Quantity : <?php echo $row['quantity']; ?></p>
                                         <p>Price : ₹<?php echo $value['price']; ?></p>
                                      </div>
                                   </div>
                                </div>
                               <?php
}
    }

}
?>

                        </div>

                           <hr>

                     </div>
                  <!-- END FORM-->
               </div>
            </div>
         </div>
      </div>
   </div>
</div>
<!-- INCLUDE FOOTER -->
<?php $this->load->view('includes/inner_footer');?>
<?php $this->load->view('includes/form_js');?>
<?php
$jsArray = array(
    'ckeditor/ckeditor.js',

);
echo $this->headerlib->put_js($jsArray);
?>
<?php $this->load->view('includes/footer');?>