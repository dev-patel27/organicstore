<!-- INCLUDE HEADER -->
<?php $this->load->view('includes/header'); ?>
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
                  <span>Tag</span>
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
                    <div class="form-body">
                      <?php //echo "<pre>"; print_r($result); ?>
                      <!-- <div class="row">
                           <div class="col-md-12">
                              <div class="form-group">
                              <label class="col-md-3 control-label">Image </label>
                              <div class="col-md-9">
                                  <div class="col-md-3">
                                    <div class="input-icon right">
                                       <i class="fa"></i>
                                       <input type="file" placeholder="" name="image" id="file" enctype = "multipart/form-data" />
                                    </div>
                                 </div>
                                 <div class="col-md-6" style="float: right;">
                                    <div class="input-icon right">
                                       <img style="height: 100px;" src="<?= PRODUCTS_IMG_URL.$result['1']->image?>">
                                    </div>
                                 </div>
                              </div> 
                           </div>
                        </div> -->


                        <div class="row">
                           <div class="col-md-12">
                              <div class="form-group">
                                 <label class="control-label col-md-3">Tag Name
                                 <span class="required"> * </span>
                                 </label>
                                 <div class="col-md-9">
                                    <div class="input-icon right">
                                       <i class="fa"></i>
                                       <input type="text" class="required form-control" placeholder="Tag Name" value="<?= $result['1']->tag_name ?>" name="tag_name" id="tag_name"  />
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
                                    <button class="btn default" onclick="cancelBtn('<?= site_url('product/tag/list');?>','form_sample_3')" type="button">Cancel</button>
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
   CKEDITOR.replace( 'summernote_2' );
   CKEDITOR.replace( 'summernote_3' );
   
</script>

<?php $this->load->view('includes/footer'); ?>