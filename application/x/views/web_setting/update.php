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
                  <a href="<?= $this->admin_model->current_page_url(); ?>"><span>Web Setting</span></a>
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
            <div class="col-md-12">
               <!-- BEGIN VALIDATION STATES-->
               <div class="portlet light form-fit ">
                  <div class="portlet-body form">
                     <!-- BEGIN FORM-->
                  <form action="<?= $this->admin_model->current_page_url(); ?>" id="form_sample_3" method="post" class="form-horizontal" enctype="multipart/form-data">
                      <div class="alert alert-danger display-hide">
                          <button class="close" data-close="alert"></button> You have some form errors. Please check below.
                      </div>
                      <div class="form-body">
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

                          <div class="row">
                              <div class="col-md-12">
                                  <div class="form-group">
                                      <label class="control-label col-md-3">Site Name
                                          <span class="required"> * </span>
                                      </label>
                                      <div class="col-md-9">
                                          <div class="input-icon right">
                                              <i class="fa"></i>
                                              <input type="text" value="<?= $result['1']->site_name; ?>" class="required form-control " placeholder="Site Name" name="site_name" id="sitename"  />
                                          </div>
                                      </div>
                                  </div>
                              </div>
                          </div>

                          <?php
                              $social_link = json_decode($result[1]->social_link);
                              $cell_number = json_decode($result[1]->cell_number);
                              //$light_logo = ($result[1]->logo_light=='') ? DEFAULT_IMAGE : LOGO_IMG_URL.$result[1]->logo_light;
                              //$dark_logo = ($result[1]->logo_dark=='') ? DEFAULT_IMAGE : LOGO_IMG_URL.$result[1]->logo_dark;
                              //$footer_logo = ($result[1]->footer_logo=='') ? DEFAULT_IMAGE : LOGO_IMG_URL.$result[1]->footer_logo;
                          ?>
                         <!-- Contact Details-->


                        <div class="portlet box dark">
                          <div class="portlet-title">
                             <div class="caption"> 
                                <h4>Contact Details</h4>
                             </div>
                          </div>
                       </div>
                       <div class="row">
                           <div class="col-md-12">
                              <div class="form-group">
                                 <label class="control-label col-md-3">Address <span class="required"> * </span></label>
                                 <div class="col-md-9">
                                    <div class="input-icon right">
                                       <i class="fa"></i>
                                       <textarea  name="address" class="form-control required" id="summernote_1"><?=$result['1']->address?></textarea>
                                    </div>
                                 </div>
                              </div>
                           </div>
                        </div>


                           <div class="row">
                              <div class="col-md-12">
                                 <div class="form-group">
                                    <label class="control-label col-md-3">Phone no.
                                    <span class="required"> * </span>
                                    </label>
                                    <div class="col-md-9">
                                       <div class="input-icon right">
                                          <i class="fa"></i>
                                          <input type="text" value="<?= $result['1']->cell_number; ?>" class="required form-control " placeholder="Phone no" name="phone_no" id="phone_no" pattern="[\+]{0,1}(\d{10,13}|[\(][\+]{0,1}\d{2,}[\13)]*\d{5,13}|\d{2,6}[\-]{1}\d{2,13}[\-]*\d{3,13})"  />
                                       </div>
                                    </div>
                                 </div>
                              </div>
                           </div>
                         <div class="row">
                              <div class="col-md-12">
                                 <div class="form-group">
                                    <label class="control-label col-md-3">Email ID
                                    <span class="required"> * </span>
                                    </label>
                                    <div class="col-md-9">
                                       <div class="input-icon right">
                                          <i class="fa"></i>
                                          <input type="email" value="<?= $result['1']->email; ?>" class="required form-control " placeholder="Email Address" name="email_address" id="email_address"  />
                                       </div>
                                    </div>
                                 </div>
                              </div>
                           </div>



                          <div class="row">
                              <div class="col-md-12">
                                  <div class="form-group">
                                      <label class="control-label col-md-3">Facebook Link
                                          <span class="required"> * </span>
                                      </label>
                                      <div class="col-md-9">
                                          <div class="input-icon right">
                                              <i class="fa"></i>
                                              <input type="text" value="<?= $social_link->facebook;?>" class="required form-control " placeholder="Facebook Link" name="facebook_link" id="facebook_link" />
                                          </div>
                                      </div>
                                  </div>
                              </div>
                          </div>

                          <div class="row">
                              <div class="col-md-12">
                                  <div class="form-group">
                                      <label class="control-label col-md-3">Twitter Link
                                          <span class="required"> * </span>
                                      </label>
                                      <div class="col-md-9">
                                          <div class="input-icon right">
                                              <i class="fa"></i>
                                              <input type="text" value="<?= $social_link->twitter; ?>" class="required form-control " placeholder="Twitter Link" name="twitter_link" id="twitter_link"  />
                                          </div>
                                      </div>
                                  </div>
                              </div>
                          </div>

                         <div class="row">
                              <div class="col-md-12">
                                  <div class="form-group">
                                      <label class="control-label col-md-3">LinkedIn Link
                                          <span class="required"> * </span>
                                      </label>
                                      <div class="col-md-9">
                                          <div class="input-icon right">
                                              <i class="fa"></i>
                                              <input type="text" value="<?= $social_link->linkedin; ?>" class="required form-control " placeholder="LinkedIn Link" name="linkedin_link" id="linkedin_link"  />
                                          </div>
                                      </div>
                                  </div>
                              </div>
                         </div>


                          <div class="row">
                              <div class="col-md-12">
                                  <div class="form-group">
                                      <label class="control-label col-md-3">Instagram Link
                                          <span class="required"> * </span>
                                      </label>
                                      <div class="col-md-9">
                                          <div class="input-icon right">
                                              <i class="fa"></i>
                                              <input type="text" value="<?= $social_link->instagram; ?>" class="required form-control" placeholder="Instagram Link" name="instagram_link" id="instagram_link"  />
                                          </div>
                                      </div>
                                  </div>
                              </div>
                          </div>


                        <div class="form-actions">
                           <div class="row">
                              <div class="col-md-12">
                                 <div class="row">
                                    <div class="col-md-offset-3 col-md-9">
                                       <button class="btn green" type="submit">Update</button>
                                       <button class="btn default" type="reset">Reset</button>
                                    </div>
                                 </div>
                              </div>
                              <div class="col-md-6"> </div>
                           </div>
                        </div>



                     </div>
                  </form>
                     <!-- END FORM-->
                  </div>
               </div>
               <!-- END VALIDATION STATES-->
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
<?php $this->load->view('includes/footer'); ?>