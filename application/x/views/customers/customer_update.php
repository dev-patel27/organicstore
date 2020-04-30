<!-- INCLUDE HEADER -->

<?php $this->load->view('includes/header'); ?>

<link rel="stylesheet" type="text/css" media="screen" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datetimepicker/4.17.37/css/bootstrap-datetimepicker.min.css" />

<!-- BEGIN CONTAINER -->

<div class="page-container">

   <!-- BEGIN SIDEBAR -->

   <?php $this->load->view('includes/sidebar'); ?>

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

                  <span>Customers Details</span>

                  <i class="fa fa-circle"></i>

               </li>

               <li>

                  <span>Edit</span>

               </li>

            </ul>

         </div>

         <!-- END PAGE BREADCRUMBS -->

         <!-- BEGIN PAGE CONTENT INNER -->

         <div class="row">

            <div class="portlet light">

               <div class="portlet-body form">

                  <!-- BEGIN FORM-->

                  <form action="<?= current_url(); ?>" id="form_sample_3" method="post" class="form-horizontal" enctype="multipart/form-data">
                     <div class="alert alert-danger display-hide">
                        <button class="close" data-close="alert"></button> You have some form errors. Please check below.
                     </div>
                     <div class="col-md-6 ">
                        <div class="form-body">
                           <div class="form-group">
                              <label class="col-md-4 control-label">Name <span class="required"> * </span></label>
                              <div class="col-md-8">
                                 <div class="input-icon right">
                                    <i class="fa"></i>
                                    <input type="text" class="required form-control" placeholder="Name" name="name" id="" value="<?= $result['1']->name; ?>" /> 
                                 </div>
                              </div>
                           </div>
                           <div class="form-group">
                              <label class="col-md-4 control-label">Email  <span class="required"> * </span></label>
                              <div class="col-md-8">
                                 <div class="input-icon right">
                                    <i class="fa"></i>
                                    <input type="text" class="required form-control" placeholder="Email" name="email" value="<?= $result['1']->email; ?>" id=""  /> 
                                 </div>
                              </div>
                           </div>
                           <div class="form-group">
                              <label class="col-md-4 control-label">Mobile Number  <span class="required"> * </span></label>
                              <div class="col-md-8">
                                 <div class="input-icon right">
                                    <i class="fa"></i>
                                    <input type="text" class="required form-control" placeholder="Mobile Number" value="<?= $result['1']->mobile_number; ?>" name="mobile_number"  id=""  />
                                 </div>
                              </div>
                           </div>

                           <div class="form-group">
                              <label class="col-md-4 control-label">locality  <span class="required"> * </span></label>
                              <div class="col-md-8">
                                 <div class="input-icon right">
                                    <i class="fa"></i>
                                    <input type="text" class="required form-control" placeholder="locality" name="locality" value="<?= $result['1']->locality; ?>" id=""  /> 
                                 </div>
                              </div>
                           </div>
                           <div class="form-group">
                              <label class="col-md-4 control-label">Landmark  <span class="required"> * </span></label>
                              <div class="col-md-8">
                                 <div class="input-icon right">
                                    <i class="fa"></i>
                                    <input type="text" class="required form-control" placeholder="Landmark" name="landmark" value="<?= $result['1']->landmark; ?>" id=""  /> 
                                 </div>
                              </div>
                           </div>
                        </div>
                     </div>
                     <div class="col-md-6 ">
                           <div class="form-group">
                              <label class="col-md-4 control-label">State <span class="required"> * </span></label>
                              <div class="col-md-8">
                                 <div class="input-icon right">
                                    <i class="fa"></i>
                                    <input type="text" class="required form-control" placeholder="State" name="state" value="<?= $result['1']->state; ?>" id=""  /> 
                                 </div>
                              </div>
                           </div>
                           <div class="form-group">
                              <label class="col-md-4 control-label">City <span class="required"> * </span> </label>
                              <div class="col-md-8">
                                 <div class="input-icon right">
                                    <i class="fa"></i>
                                    <input type="text" class="required form-control" placeholder="City" name="city" value="<?= $result['1']->city; ?>" id=""  /> 
                                 </div>
                              </div>
                           </div>
                           <div class="form-group">
                              <label class="col-md-4 control-label">Zip Code  <span class="required"> * </span></label>
                              <div class="col-md-8">
                                 <div class="input-icon right">
                                    <i class="fa"></i>
                                    <input type="text" class="required form-control" placeholder="Zip Code" name="post_code" value="<?= $result['1']->post_code; ?>" id=""  /> 
                                 </div>
                              </div>
                           </div>

                           <div class="form-group">
                              <label class="col-md-4 control-label">Alternate Mobile  <span class="required"> * </span></label>
                              <div class="col-md-8">
                                 <div class="input-icon right">
                                    <i class="fa"></i>
                                    <input type="text" class="required form-control" placeholder="Alternate Mobile" name="alternate_mobile" value="<?= $result['1']->alternate_mobile; ?>" id=""  /> 
                                 </div>
                              </div>
                           </div>

                           <div class="form-group">
                              <label class="col-md-4 control-label">Profile Image </label>
                              <div class="col-md-8">
                                 <div class="input-icon right">
                                    <i class="fa"></i>
                                    <input type="file" class="form-control" name="profile_image" id=""  /> 
                                 </div>
                              </div>
                           </div>

                           <div class="form-group">
                              <div class="col-md-8 ">
                                 <?php
                                    if($result['1']->profile_image == ''){
                                       $image = DEFAULT_IMAGE;
                                    }else{
                                       $image = CUSTOMER_IMG_URL.$result['1']->profile_image;
                                    }
                                 ?>
                                 <div class="pull-right">
                                  <img width="80px" height="40px" src="<?=$image?>">
                                  </div>
                              </div>
                           </div>
                        </div>
                     </div>
                    <div class="portlet light bordered">
                        <div class="portlet-body">
                           <ul class="nav nav-pills">
                              <li class="active">
                                 <a href="#tab_3_1" data-toggle="tab" aria-expanded="true">  Apartment/Villa Society </a>
                              </li>
                              <li class="">
                                 <a href="#tab_3_2" data-toggle="tab" aria-expanded="false">  Independent House </a>
                              </li>
                           </ul>
                           <div class="tab-content">  
                              <div class="tab-pane fade active in" id="tab_3_1">
                                  <div class="row">
                                       <div class="col-md-6">
                                          <div class="form-group">
                                             <div class="col-md-12">
                                                <div class="input-icon right">
                                                   <i class="fa"></i>
                                                   <input type="text" class="form-control " placeholder="Flat Villa" value="<?= $result['1']->flat_villa; ?>"  name="flat_villa" id="li_tab"  />
                                                </div>
                                             </div>
                                          </div>
                                       </div>
                                        <div class="col-md-6">
                                          <div class="form-group">
                                             <div class="col-md-12">
                                                <div class="input-icon right">
                                                   <i class="fa"></i>
                                                   <input type="text" class="form-control " placeholder="Apartment Society Name" value="<?= $result['1']->apartment_society_name; ?>"  name="apartment_society_name" id="li_tab"  />
                                                </div>
                                             </div>
                                          </div>
                                       </div> 
                                  </div>
                              </div>
                              <div class="tab-pane fade" id="tab_3_2">
                                  <div class="row">
                                       <div class="col-md-6">
                                          <div class="form-group">
                                             <div class="col-md-12">
                                                <div class="input-icon right">
                                                   <i class="fa"></i>
                                                   <input type="text" class="form-control " placeholder="House"  value="<?= $result['1']->house; ?>" name="house" id="li_tab"  />
                                                </div>
                                             </div>
                                          </div>
                                       </div>
                                        <div class="col-md-6">
                                          <div class="form-group">
                                             <div class="col-md-12">
                                                <div class="input-icon right">
                                                   <i class="fa"></i>
                                                   <input type="text" class="form-control" placeholder="Street Address"  value="<?= $result['1']->street_address; ?>" name="street_address" id="li_tab"  />
                                                </div>
                                             </div>
                                          </div>
                                       </div>
                                  </div>
                              </div>

                           </div>
                        </div>
                     </div>   

                     <div class="form-actions">
                        <div class="row">
                           <div class="col-md-12">
                              <div class="row" align="center">
                                 <!-- <div class="col-md-offset-3 col-md-9"> -->
                                    <button class="btn green" type="submit">Update</button>

                                    <button class="btn default" onclick="cancelBtn('<?= site_url('customers/customer-details/list');?>','form_sample_3')" type="button">Cancel</button>

                                 <!-- </div> -->

                              </div>

                           </div>

                           <div class="col-md-6"> </div>

                        </div>

                     </div>

                  </form>

                  <!-- END FORM-->

               </div>

            </div>

         </div>

      </div>

   </div>

</div>

<!-- INCLUDE FOOTER -->

<?php $this->load->view('includes/inner_footer'); ?>

<?php $this->load->view('includes/form_js'); ?>

<?php

   $jsArray = array(

       'ckeditor/ckeditor.js',

   

   );

   echo $this->headerlib->put_js( $jsArray );

   ?>

<script>

   // Replace the <textarea id="editor1"> with a CKEditor

   // instance, using default configuration.

   CKEDITOR.replace( 'summernote_1' );

   

</script>

<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.9.0/moment-with-locales.js"></script>

<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datetimepicker/4.17.47/js/bootstrap-datetimepicker.min.js"></script>

<script type="text/javascript">

   $('.datetimepicker1').datetimepicker({ 

      //format: 'dd-MM-yyyy', 

      //format: 'YYYY-MM-DD hh:mm A'  

      format: 'YYYY-MM-DD'   

   });

</script>

<script type="text/javascript">

   function get_package_sub_category()

   {

      var category_id = $('#category_id').val();

      $.ajax({

        type: "POST",

        url: "<?= ADMIN_BASE_URL ?>dependency/get_package_sub_category",

        data:'category_id='+category_id,

        success: function(data){

          $("#sub_category_id").html(data);

        }

      });

   }



   function get_states()

   {

      var country_id = $('#country_id').val();

      $.ajax({

        type: "POST",

        url: "<?= ADMIN_BASE_URL ?>dependency/getstate",

        data:'country_id='+country_id,

        success: function(data){

          $("#state_id").html(data);

        }

      });

   }



    function get_city()

   {

      var state_id = $('#state_id').val();

      $.ajax({

        type: "POST",

        url: "<?= ADMIN_BASE_URL ?>dependency/getcity",

        data:'state_id='+state_id,

        success: function(data){

          $("#city_id").html(data);

        }

      });

   }





   $(document).ready(function() {

       $(".allow-number-only").keydown(function (e) {

           // Allow: backspace, delete, tab, escape, enter and .

           if ($.inArray(e.keyCode, [46, 8, 9, 27, 13, 110, 190]) !== -1 ||

                // Allow: Ctrl+A, Command+A

               (e.keyCode === 65 && (e.ctrlKey === true || e.metaKey === true)) || 

                // Allow: home, end, left, right, down, up

               (e.keyCode >= 35 && e.keyCode <= 40)) {

                    // let it happen, don't do anything

                    return;

           }

           // Ensure that it is a number and stop the keypress

           if ((e.shiftKey || (e.keyCode < 48 || e.keyCode > 57)) && (e.keyCode < 96 || e.keyCode > 105)) {

               e.preventDefault();

           }

       });

   });

</script>

<?php $this->load->view('includes/footer'); ?>