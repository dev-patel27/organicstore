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

                  <span>Notification </span>

                  <i class="fa fa-circle"></i>

               </li>

               <li>

                  <span>Send</span>

               </li>

            </ul>

         </div>

         <!-- END PAGE BREADCRUMBS -->

         <!-- BEGIN PAGE CONTENT INNER -->

         <div class="row">

            <div class="portlet light">

               <div class="portlet-body form">

                  <!-- BEGIN FORM-->

                  <?php if ($this->session->flashdata('error')) { ?>
                  <div class="alert alert-danger">
                     <button class="close" data-close="alert"></button>
                     <span><?php echo $this->session->flashdata('error'); ?></span>
                  </div>
                  <?php } ?>
                  <?php if( $this->session->flashdata('success') ){ ?>
                  <div class="alert alert-success">
                     <button class="close" data-close="alert"></button>
                     <span> <?php echo $this->session->flashdata('success');?> </span>
                  </div>
                  <?php } ?>
                  <form action="<?= current_url(); ?>" id="form_sample_3" method="post" class="form-horizontal" enctype="multipart/form-data">

                     <div class="alert alert-danger display-hide">

                        <button class="close" data-close="alert"></button> You have some form errors. Please check below.

                     </div>

                     <div class="col-md-12 ">
                           <div class="form-group">

                              <label class="col-md-3 control-label">Message <span class="required"> * </span></label>

                              <div class="col-md-9">

                                 <div class="input-icon right">

                                    <i class="fa"></i>

                                    <textarea type="text" rows="10" cols="70" class="required form-control" name="message" id=""></textarea> 

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

                                    <button class="btn green" type="submit">Send</button>

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

<?php $this->load->view('includes/footer'); ?>