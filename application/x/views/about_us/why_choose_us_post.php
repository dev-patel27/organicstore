<?php $this->load->view('includes/header'); ?>
<link rel="stylesheet" type="text/css" media="screen" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datetimepicker/4.17.37/css/bootstrap-datetimepicker.min.css" />
<div class="page-container">
   <?php $this->load->view('includes/sidebar'); ?>
   <div class="page-content-wrapper">
      <div class="page-content" >
         <div class="page-bar">
            <ul class="page-breadcrumb">
               <li>
                  <span>Why choose us</span>
                  <i class="fa fa-circle"></i>
               </li>
               <li>
                  <span>Add</span>
               </li>
            </ul>
         </div>
         <div class="row">
            <div class="portlet light">
               <div class="portlet-body form">
                  <form action="<?= current_url(); ?>" id="form_sample_3" method="post" class="form-horizontal" enctype="multipart/form-data">
                     <div class="alert alert-danger display-hide">
                        <button class="close" data-close="alert"></button> You have some form errors. Please check below.
                     </div>


                      <div class="row">
                          <div class="col-md-12">
                              <div class="form-group">
                                  <label class="control-label col-md-3">Title <span class="required"> * </span></label>
                                  <div class="col-md-9">
                                      <div class="input-icon right">
                                          <i class="fa"></i>
                                          <input type="text" name="title" class="form-control required" />
                                      </div>
                                  </div>
                              </div>
                          </div>
                      </div>

                      <br>
                      <div class="row">
                          <div class="col-md-12">
                              <div class="form-group">
                                  <label class="control-label col-md-3">Image <span class="required"> * </span></label>
                                  <div class="col-md-9">
                                      <div class="input-icon right">
                                          <i class="fa"></i>
                                          <input type="file" class="required form-control allow-number-only" placeholder="Image" name="image" id="image"   />
                                      </div>
                                  </div>
                              </div>
                          </div>
                      </div>


                      <div class="form-actions">
                        <div class="row">
                           <div class="col-md-12">
                              <div class="row" align="center">
                                 <button class="btn green" type="submit">Submit</button>
                                 <button class="btn default" onclick="cancelBtn('<?= site_url('about-us/why-choose-us/list')?>','form_sample_3')" type="button">Cancel</button>
                              </div>
                           </div>
                           <div class="col-md-6"> </div>
                        </div>
                     </div>
                  </form>
               </div>
            </div>
         </div>
      </div>
   </div>
</div>
<?php $this->load->view('includes/inner_footer'); ?>
<?php $this->load->view('includes/form_js'); ?>
<?php
   $jsArray = array(
       'ckeditor/ckeditor.js',
   );
   echo $this->headerlib->put_js( $jsArray );
   ?>
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