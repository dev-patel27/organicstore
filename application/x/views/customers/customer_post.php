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

                  <span>Add</span>

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
                           <div class="form-group">

                              <label class="col-md-4 control-label">Name <span class="required"> * </span></label>

                              <div class="col-md-8">

                                 <div class="input-icon right">

                                    <i class="fa"></i>

                                    <input type="text" class="required form-control" placeholder="Name" name="name" id="" value="" /> 

                                 </div>

                              </div>

                           </div>

                           <div class="form-group">

                              <label class="col-md-4 control-label">Email  <span class="required"> * </span></label>

                              <div class="col-md-8">

                                 <div class="input-icon right">

                                    <i class="fa"></i>

                                    <input type="text" class="required form-control" placeholder="Email" name="email" value="" id=""  /> 

                                 </div>

                              </div>

                           </div>



                           <div class="form-group">

                              <label class="col-md-4 control-label">Contact Number  <span class="required"> * </span></label>

                              <div class="col-md-8">

                                 <div class="input-icon right">

                                    <i class="fa"></i>

                                    <input type="text" class="required form-control" placeholder="Contact Number" name="contact_number" value="" id=""  /> 

                                 </div>

                              </div>

                           </div>



                            <div class="form-group">

                              <label class="col-md-4 control-label">Date Of Birth  <span class="required"> * </span></label>

                              <div class="col-md-8">

                                 <div class="input-icon right">

                                    <i class="fa"></i>

                                    <input type="text" class="required form-control datetimepicker1" placeholder="Date Of Birth" name="dob" value="" id=""  /> 

                                 </div>

                              </div>

                           </div>



                            <div class="form-group">

                              <label class="col-md-4 control-label">Address  <span class="required"> * </span></label>

                              <div class="col-md-8">

                                 <div class="input-icon right">

                                    <i class="fa"></i>

                                    <input type="text" class="required form-control" placeholder="Address" name="address" value="" id=""  /> 

                                 </div>

                              </div>

                           </div>



                      

                          

                         

                        </div>

                     </div>

                     <div class="col-md-6 ">

                        <div class="form-body">

                           

                           <div class="form-group">

                              <label class="col-md-4 control-label">Country  <span class="required"> * </span></label>

                              <div class="col-md-8">

                                 <div class="input-icon right">

                                    <i class="fa"></i>

                                    <select class="table-group-action-input form-control select_two" name="country_id" width="100%" id="country_id" onchange="get_states()" >

                                       <option value="">Select Country</option>

                                       <?php

                                          $country_r = $this->admin_model->get_countries();

                                          foreach ($country_r as $key => $value) {

                                              //$sel = ($result['1']->country_id == $value['id']) ? 'selected' : '';

                                              echo '<option value="'.$value['id'].'">'.$value['country_name'].'</option>';

                                          }

                                            

                                          ?>

                                    </select>

                                 </div>

                              </div>

                           </div>



                           <div class="form-group">

                              <label class="col-md-4 control-label">State <span class="required"> * </span></label>

                              <div class="col-md-8">

                                 <div class="input-icon right">

                                    <i class="fa"></i>

                                    <select class="table-group-action-input form-control select_two" name="state_id" width="100%" id="state_id" onchange="get_city()" >

                                       <option value="">Select State</option>

                                       

                                    </select>

                                 </div>

                              </div>

                           </div>



                           <div class="form-group">

                              <label class="col-md-4 control-label">City <span class="required"> * </span></label>

                              <div class="col-md-8">

                                 <div class="input-icon right">

                                    <i class="fa"></i>

                                    <select class="table-group-action-input form-control select_two" name="city_id" width="100%" id="city_id" onchange="" >

                                       <option value="">Select City</option>

                                       

                                    </select>

                                 </div>

                              </div>

                           </div>



                           <div class="form-group">

                              <label class="col-md-4 control-label">Zip Code  <span class="required"> * </span></label>

                              <div class="col-md-8">

                                 <div class="input-icon right">

                                    <i class="fa"></i>

                                    <input type="text" class="required form-control" placeholder="Zip Code" name="zip_code" value="" id=""  /> 

                                 </div>

                              </div>

                           </div>



                           <div class="form-group">

                              <label class="col-md-4 control-label">Joined Date  <span class="required"> * </span></label>

                              <div class="col-md-8">

                                 <div class="input-icon right">

                                    <i class="fa"></i>

                                    <input type="text" class="required form-control datetimepicker1" placeholder="Joined Date" name="joined_date" value="" id=""  /> 

                                 </div>

                              </div>

                           </div>

                          

                        </div>

                     </div>


                     <div class="col-md-12">

                        <div class="form-body">
                           
                            <div class="form-group">

                              <label class="col-md-4 control-label">Any Preffered Matches <span class="required"> * </span></label>

                              <div class="col-md-8">

                                 <div class="input-icon right">

                                    <i class="fa"></i>

                                    <select class="table-group-action-input form-control" name="preffered_matches[]" width="100%" id="" multiple >
                                       <option value="India v South Africa">India v South Africa</option>
                                       <option value="India v Australia">India v Australia</option>
                                       <option value="India v New Zealand">India v New Zealand</option>
                                       <option value="India v Pakistan">India v Pakistan</option>
                                       <option value="India v Afghanistan">India v Afghanistan</option>
                                       <option value="India v Windies">India v Windies</option>
                                       <option value="India v England">India v England</option>
                                       <option value="India v Bangladesh">India v Bangladesh</option>
                                       <option value="India v Sri Lanka">India v Sri Lanka</option>
                                       <option value="England v Pakistan">England v Pakistan</option>
                                       <option value="England v South Africa">England v South Africa</option>
                                       <option value="England v Australia">England v Australia</option>
                                       <option value="England v New Zealand">England v New Zealand</option>
                                       <option value="Australia v New Zealand">Australia v New Zealand</option>
                                       <option value="Semi Finals">Semi Finals</option>
                                       <option value="Final">Final</option>
                                    </select>

                                 </div>

                              </div>

                           </div>

                        </div>

                     </div>





                    <div class="portlet light bordered">

                        <div class="portlet-body">

                           <ul class="nav nav-pills">

                              <li class="active">

                                 <a href="#tab_3_1" data-toggle="tab" aria-expanded="true"> Passport Details </a>

                              </li>

                              <li class="">

                                 <a href="#tab_3_2" data-toggle="tab" aria-expanded="false"> Booking Details </a>

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

                                                   <input type="text" class="form-control " placeholder="Passport Number" name="passport_number" id="li_tab"  />

                                                </div>

                                             </div>

                                          </div>

                                       </div>



                                        <div class="col-md-6">

                                          <div class="form-group">

                                             <div class="col-md-12">

                                                <div class="input-icon right">

                                                   <i class="fa"></i>

                                                   <input type="text" class="form-control " placeholder="Name of passport" name="name_of_passport" id="li_tab"  />

                                                </div>

                                             </div>

                                          </div>

                                       </div>



                                       <div class="col-md-6">

                                          <div class="form-group">

                                             <div class="col-md-12">

                                                <div class="input-icon right">

                                                   <i class="fa"></i>

                                                   <input type="text" class="form-control datetimepicker1" placeholder="Date  of Issue" name="date_of_issue" id="li_tab"  />

                                                </div>

                                             </div>

                                          </div>

                                       </div>



                                       <div class="col-md-6">

                                          <div class="form-group">

                                             <div class="col-md-12">

                                                <div class="input-icon right">

                                                   <i class="fa"></i>

                                                   <input type="text" class="form-control datetimepicker1" placeholder="Date  of Expiry" name="date_of_expiry" id="li_tab"  />

                                                </div>

                                             </div>

                                          </div>

                                       </div>



                                        <div class="col-md-6">

                                          <div class="form-group">

                                             <div class="col-md-12">

                                                <div class="input-icon right">

                                                   <i class="fa"></i>

                                                    <select class="table-group-action-input form-control select_two" name="country_of_issue" width="100%">

                                                     <option value="">Select Country</option>

                                                     <?php

                                                        $country_r = $this->admin_model->get_countries();

                                                        foreach ($country_r as $key => $value) {

                                                            //$sel = ($result['1']->country_id == $value['id']) ? 'selected' : '';

                                                            echo '<option value="'.$value['id'].'">'.$value['country_name'].'</option>';

                                                        }

                                                          

                                                        ?>

                                                    </select>

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

                                                   <input type="text" class="form-control " placeholder="Booking ID" name="booking_id" id="li_tab"  />

                                                </div>

                                             </div>

                                          </div>

                                       </div>



                                        <div class="col-md-6">

                                          <div class="form-group">

                                             <div class="col-md-12">

                                                <div class="input-icon right">

                                                   <i class="fa"></i>

                                                   <input type="text" class="form-control datetimepicker1" placeholder="Booking Date" name="booking_date" id="li_tab"  />

                                                </div>

                                             </div>

                                          </div>

                                       </div>



                                       <div class="col-md-6">

                                          <div class="form-group">

                                             <div class="col-md-12">

                                                <div class="input-icon right">

                                                   <i class="fa"></i>

                                                   <input type="text" class="form-control " placeholder="Booking Name" name="booking_name" id="li_tab"  />

                                                </div>

                                             </div>

                                          </div>

                                       </div>



                                       <div class="col-md-6">

                                          <div class="form-group">

                                             <div class="col-md-12">

                                                <div class="input-icon right">

                                                   <i class="fa"></i>

                                                   <select class="table-group-action-input form-control select_two" name="booking_type" width="100%">

                                                     <option value="">Select Booking Type</option>

                                                     <?php

                                                        $booking_type = $this->admin_model->get_booking_type();

                                                        foreach ($booking_type as $key => $value) {

                                                           echo '<option value="'.$value.'">'.$value.'</option>';

                                                        }

                                                          

                                                        ?>

                                                    </select>

                                                </div>

                                             </div>

                                          </div>

                                       </div>



                                      <div class="col-md-6">

                                          <div class="form-group">

                                             <div class="col-md-12">

                                                <div class="input-icon right">

                                                   <i class="fa"></i>

                                                   <input type="text" class="form-control datetimepicker1" placeholder="Journey Date" name="journey_date" id="li_tab"  />

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

                                    <button class="btn green" type="submit">Submit</button>

                                    <button class="btn default" type="button">Cancel</button>

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