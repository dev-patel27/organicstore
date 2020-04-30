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
                  <span>T&C</span>
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

                      <div class="row">
                          <div class="col-md-12">
                              <div class="form-group">
                                  <label class="control-label col-md-3">Title<span class="required"> * </span></label>
                                  <div class="col-md-9">
                                      <div class="input-icon right">
                                          <i class="fa"></i>
                                          <input type="text" name="title" class="form-control required" value="<?=$result['1']->title?>" />
                                      </div>
                                  </div>
                              </div>
                          </div>
                      </div>

                     <div class="row">
                       <div class="col-md-12">
                          <div class="form-group">
                             <label class="control-label col-md-3">Description <span class="required"> * </span></label>
                             <div class="col-md-9">
                                <div class="input-icon right">
                                   <i class="fa"></i>
                                   <textarea  name="description" class="form-control required" id="summernote_1"><?=$result['1']->description?></textarea>
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
                   <button class="btn default" onclick="cancelBtn('<?= site_url('tc/tc/list');?>','form_sample_3')" type="button">Cancel</button>
                   <!-- </div> -->
                   </div>
                   </div>
                   <div class="col-md-6"> </div>
                   </div>
                   </div>
               </form>
               </div>
               <!-- END FORM-->
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
<script src="<?php echo BASE_URL ?>x/assets/ckfinder/ckfinder.js"></script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.9.0/moment-with-locales.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datetimepicker/4.17.47/js/bootstrap-datetimepicker.min.js"></script>
<script>
   $('.datetimepicker1').datetimepicker({ 
   //format: 'DD-MM-YYYY', 
   //format: 'YYYY-MM-DD hh:mm A'  
   format: 'DD-MM-YYYY'  
   });
</script>
<script>
   CKEDITOR.replace( 'summernote_1' );
   
</script>
<?php $this->load->view('includes/footer'); ?>