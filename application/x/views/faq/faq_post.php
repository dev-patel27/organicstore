<!-- INCLUDE HEADER -->
<?php $this->load->view('includes/header'); ?>
<link rel="stylesheet" type="text/css" media="screen" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datetimepicker/4.17.37/css/bootstrap-datetimepicker.min.css" />
<script src="//ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script>
<script src="https://maps.googleapis.com/maps/api/js?libraries=places&key=AIzaSyBRg1G7tw3fW4CTKXE1rmXxf4A-lhlQgRU"></script>
<!-- BEGIN CONTAINER -->
<div class="page-container">
   <?php $this->load->view('includes/sidebar'); ?>
   <div class="page-content-wrapper">
      <div class="page-content" >
         <div class="page-bar">
            <ul class="page-breadcrumb">
               <li>
                  <span>Faq</span>
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
                     <div class="col-md-12 ">
                        <div class="form-group">
                           <label class="col-md-3 control-label">Question <span class="required"> * </span></label>
                           <div class="col-md-9">
                              <div class="input-icon right">
                                 <i class="fa"></i>
                                 <input type="text" class="required form-control" placeholder="Question" name="question" id="question" value="" /> 
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
                                        <textarea rows="6" class="" class="required" name="answer" cols="50" id="summernote_1" ></textarea> 
                                    
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
                              <button class="btn green" type="submit">Submit</button>
                              <button class="btn default" onclick="cancelBtn('<?= site_url('faq/add-faq/list');?>','form_sample_3')" type="button">Cancel</button>
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