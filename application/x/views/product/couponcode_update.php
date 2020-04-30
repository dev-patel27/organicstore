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
                  <span>Coupon</span>
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
                        <div class="row">
                           <div class="col-md-12">
                              <div class="form-group">
                                 <label class="control-label col-md-3">Coupon Name
                                 <span class="required"> * </span>
                                 </label>
                                 <div class="col-md-9">
                                    <div class="input-icon right">
                                       <i class="fa"></i>
                                       <input type="text" class="required form-control" placeholder="Coupon Name" value="<?= $result['1']->coupon_name ?>" name="coupon_name" id="coupon_name"  />
                                    </div>
                                 </div>
                              </div>
                           </div>
                        </div>
                     </div>

                     <div class="row">
                           <div class="col-md-12">
                              <div class="form-group">
                                 <label class="control-label col-md-3">Price
                                 <span class="required"> * </span>
                                 </label>
                                 <div class="col-md-9">
                                    <div class="input-icon right">
                                       <i class="fa"></i>
                                       <input type="text" class="required form-control" placeholder="Price" value="<?= $result['1']->price ?>" name="price" id="price"  />
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
<!--                                 <div class="col-md-offset-3 col-md-9">-->
                                    <button class="btn green" type="submit">Submit</button>
                                    <button class="btn default" onclick="cancelBtn('<?= site_url('product/coupon-code/list');?>','form_sample_3')" type="button">Cancel</button>
<!--                                 </div>-->
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
//   $jsArray = array(
//       'ckeditor/ckeditor.js',
//
//   );
   echo $this->headerlib->put_js( $jsArray );
   ?>
<script>
   // Replace the <textarea id="editor1"> with a CKEditor
   // instance, using default configuration.
   
</script>

<?php $this->load->view('includes/footer'); ?>