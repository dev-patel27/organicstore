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
               <span>Role</span>
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
                              <label class="control-label col-md-3">Role Category
                              <span class="required"> * </span>
                              </label>
                              <div class="col-md-9">
                                 <div class="input-icon right">
                                    <i class="fa"></i>
                                    <select class="required table-group-action-input form-control required" name="" width="100%" id="role_id" readonly disabled="disabled">
                                       <option value="">Select Role</option>
                                       <?php
                                          $role_id = $result['1']->role_id; 
                                          $role = $this->admin_model->get_role_category();
                                          foreach($role as $row_c)
                                          {
                                           
                                             $sel = ($role_id == $row_c['id']) ? 'selected' : '';
                                             echo '<option value="'.$row_c['id'].'" '.$sel.'>'.$row_c['role_name'].'</option>';
                                          }
                                          ?>
                                    </select>
                                 </div>
                              </div>
                           </div>
                        </div>
                     </div>
                     <!-- <span id="results-update"> </span> -->
                     <div class="row">
                        <div class="col-md-12">
                           <div class="form-group">
                              <label class="control-label col-md-3">Module Category
                              <span class="required"> * </span>
                              </label>
                              <div class="col-md-9">
                                 <div class="input-icon right">
                                    <i class="fa"></i>
                                    <select class="required table-group-action-input form-control " name="" width="100%" id="module_id" readonly  disabled="disabled">
                                       <option value="">Select Module</option>
                                       <?php
                                          $module_id = $result['1']->module_id; 
                                          $module = $this->admin_model->get_module_category();
                                          foreach($module as $row_c)
                                          {
                                           
                                             $sel = ($module_id == $row_c['id']) ? 'selected' : ''; 
                                             echo '<option value="'.$row_c['id'].'" '.$sel.'>'.$row_c['module_name'].'</option>';
                                          }
                                          ?>
                                    </select>
                                 </div>
                              </div>
                           </div>
                        </div>
                     </div>
                     <div class="row">
                        <div class="col-md-12">
                           <div class="form-group">
                              <label class="control-label col-md-3">Module Sub category
                              <span class="required"> * </span>
                              </label>
                              <div class="col-md-9">
                                 <div class="input-icon right">
                                    <i class="fa"></i>
                                    <select class="required table-group-action-input form-control" name="" width="100%" id="sub_module_id" readonly  disabled="disabled">
                                       <option value="">Select Sub category</option>
                                        <?php
                                          $sub_module_id = $result['1']->sub_module_id; 
                                          $submodule = $this->admin_model->get_sub_module($module_id);
                                          foreach($submodule as $row_c)
                                          {
                                             if($sub_module_id == $row_c['id'])
                                             {
                                                echo '<option value="'.$row_c['id'].'" selected>'.$row_c['sub_module_name'].'</option>';
                                             }
                                            
                                             
                                          }
                                          ?>

                                    </select>
                                 </div>
                              </div>
                           </div>
                        </div>
                     </div>
                     <div class="row">
                        <div class="col-md-12">
                           <div class="form-group">
                              <label class="control-label col-md-3">Permission
                              <span class="required"> * </span>
                              </label>
                              <div class="col-md-9">
                                 <div class="input-icon right">
                                    <i class="fa"></i>
                                    <input type="checkbox" name="view" value="true" 
                                       <?php if($result['1']->view_permission == "true") { echo 'checked'; } else { echo 'unchecked'; } ?> > view
                                    <input type="checkbox" name="add" value="true" <?php if($result['1']->add_permission == "true" ) { echo 'checked'; } else { echo 'unchecked'; }  ?>> add
                                    <input type="checkbox" name="update" value="true" <?php if($result['1']->update_permission == "true" ) { echo 'checked'; } else { echo 'unchecked'; }  ?>> update
                                    <input type="checkbox" name="delete" value="true" <?php if($result['1']->delete_permission == "true" ) { echo 'checked'; } else { echo 'unchecked'; }  ?> > delete
                                    <input type="checkbox" name="export" value="true" <?php if($result['1']->export_permission == "true") { echo 'checked'; } else { echo 'unchecked'; }  ?>> export
                                 </div>
                              </div>
                           </div>
                        </div>
                     </div>
                     <input type="hidden" name="role_id" value="<?= $result['1']->role_id; ?>">
                     <input type="hidden" name="module_id" value="<?= $result['1']->module_id; ?>">
                     <input type="hidden" name="sub_module_id" value="<?= $result['1']->sub_module_id; ?>">
                     <div class="form-actions">
                        <div class="row">
                           <div class="col-md-12">
                              <div class="row">
                                 <div class="col-md-offset-3 col-md-9">
                                    <button class="btn green" type="submit">Update</button>
                                    <button class="btn default" type="button">Cancel</button>
                                 </div>
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
<script type="text/javascript">
   /*$(document).ready(function() {
      //$('.form-actions').hide();
      $('#role_id').change(function() {
         var role_id = $(this).val();
         
         $("#results-update").empty('');
   
         $.ajax({
            url: "get_ajax_update_role",
            type: "POST",
            data: {role_id : role_id},
            success: function(html){
               $("#results-update").append(html);
               
            }
         });
      });
   });*/
   
    $( "#module_id" ).change(function() {
         var module_id = $('#module_id').val();
         $("#sub_module_id").find('option').remove();
         $.ajax({
            type:'POST',
            url: "<?= ADMIN_BASE_URL?>role/get_sub_module",
            data: { module_id: module_id},
            success:function(html){
         
               $('#sub_module_id').append(html);
   
            }
   
         });
      });
   
</script>
<?php $this->load->view('includes/footer'); ?>