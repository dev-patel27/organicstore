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

                  <span>Faq</span>

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
                    <div class="col-md-12 ">
                        <br>
                        <div class="form-group">
                           <label class="col-md-3 control-label">Question <span class="required"> * </span></label>
                           <div class="col-md-9">
                              <div class="input-icon right">
                                 <i class="fa"></i>
                                 <input type="text" class="required form-control" placeholder="Question" name="question" id="question" value="<?=$result['1']->question?>" /> 
                              </div>
                           </div>
                        </div>

                        <div class="row">
                           <div class="col-md-12">
                              <div class="form-group">
                                 <label class="control-label col-md-3">Answer                            
                                 <span class="required"> * </span>     
                                 </label>
                                 <div class="col-md-9">
                                    <div class="input-icon right">
                                       <i class="fa"></i>
                                        <textarea rows="6" class="" class="required" name="answer" cols="50" id="summernote_1" ><?=$result['1']->answer?></textarea> 
                                    
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

                                    <button class="btn default" onclick="cancelBtn('<?= site_url('faq/add-faq/list');?>','form_sample_3')" type="button">Cancel</button>

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