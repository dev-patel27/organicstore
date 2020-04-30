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
                  <span>Role Permission</span>
                  <i class="fa fa-circle"></i>
               </li>
               <li>
                  <span>Update</span>
               </li>
            </ul>
         </div>
         <!-- END PAGE BREADCRUMBS -->
         <!-- BEGIN PAGE CONTENT INNER -->
         <div class="row">
            <div class="portlet light">
               <div class="portlet-body form">
                  <!-- BEGIN FORM-->
                  <form action="<?= current_url() ?>" id="form_sample_3" method="post" class="form-horizontal" enctype="multipart/form-data">
                     <div class="alert alert-danger display-hide">
                        <button class="close" data-close="alert"></button> You have some form errors. Please check below.
                     </div>
                     <div class="form-body">
                        

                       <!--  <div class="row">
                           <div class="col-md-12">
                              <div class="form-group">
                                 <label class="control-label col-md-3">Role name
                                 <span class="required"> * </span>
                                 </label>
                                 <div class="col-md-9">
                                    <div class="input-icon right">
                                       <i class="fa"></i>
                                       <input type="text" class="required form-control" value="<?= $result['1']->role_name; ?>" placeholder="Role Name" name="name" id="script"  />
                                    </div>
                                 </div>
                              </div>
                           </div>
                        </div> -->

                      <div class="row">
                        <div class="col-md-12">
                          <div class="form-group">
                            <label class="control-label col-md-3">User Type
                               <span class="required"> * </span>
                            </label>
                            <div class="col-md-9">
                              <div class="input-icon right">
                                <i class="fa"></i>
                                <select class="table-group-action-input form-control" name="role_id" width="100%" id="application_id" class="required">
                                  <option value="">Select User Type</option>
                                   <?php
                                  $user = $this->admin_model->get_users();
                                  foreach($user as $row)
                                  {
                                    $selected = ($result['1']->role_id == $row['id']) ? ('selected') : '';
                                    echo '<option value="'.$row['id'].'"'.$selected.'>'.$row['type_name'].'</option>';
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
                                 <label class="control-label col-md-3">Module Permission
                                 <span class="required"> * </span>
                                 </label>
                                 <div class="col-md-9">
                                       <div class="input-icon right">
                                          <i class="fa"></i>
                                          <div class="portlet-body">
                                           <div class="table-scrollable">
                                               <table class="table table-condensed table-hover">
                                                   <thead>
                                                       <tr>
                                                           <th> # </th>
                                                           <th> Module </th>
                                                           <th> View </th>
                                                           <th> Add </th>
                                                           <th> Update </th>
                                                           <th> Delete </th>
                                                           <th> Search </th>
                                                       </tr>
                                                   </thead>
                                                   <tbody>

                                                   <?php
                                                   $row_c = 1;
                                                   $module = $this->admin_model->get_module_category();
                                                   

                                                   foreach ($module as $key => $row) {
                                                      
                                                  


                                                 
                                                      echo '<tr>
                                                              <input type="hidden" name="module_id[]" value="'.$row['id'].'" >
                                                              <td> '.$row_c++.' </td>
                                                              <td> '.$row['module_name'].' </td>';
                                                    ?>

                                                              <td>
                                                                <input type="checkbox" onclick="check(1,<?= $row['id']; ?>)" value="true" 
                                                                <?php
                                                                $view = $this->admin_model->get_module_permission('view_permission', $result['1']->role_id, $row['id']);
                                                                echo (!empty($view)) ? 'checked' : ''; 
                                                                $in_view =  (!empty($view)) ? 'true' : 'false'; 
                                                                ?>
                                                              > 
                                                                  <input type="hidden" name="view[]"  class="1_<?= $row['id']; ?>" value="<?= $in_view; ?>" >
                                                              </td>
                                                              <td>
                                                              <input type="checkbox" onclick="check(2,<?= $row['id']; ?>)" value="true" 
                                                              <?php
                                                                $add = $this->admin_model->get_module_permission('add_permission', $result['1']->role_id, $row['id']);

                                                                echo (!empty($add)) ? 'checked' : '';
                                                                $in_add =  (!empty($add)) ? 'true' : 'false';  
                                                                ?>
                                                              > 
                                                              <input type="hidden" name="add[]"  class="2_<?= $row['id']; ?>" value="<?= $in_add; ?>" >
                                                              </td>
                                                              <td>
                                                              <input type="checkbox"  onclick="check(3,<?= $row['id']; ?>)"  value="true" 
                                                              <?php
                                                                $update = $this->admin_model->get_module_permission('update_permission', $result['1']->role_id, $row['id']);

                                                                echo (!empty($update)) ? 'checked' : ''; 
                                                                $in_update =  (!empty($update)) ? 'true' : 'false';   
                                                                ?>
                                                              >  

                                                              <input type="hidden" name="update[]"  class="3_<?= $row['id']; ?>" value="<?= $in_update; ?>" >
                                                              </td>
                                                              <td> 
                                                              <input type="checkbox"  onclick="check(4,<?= $row['id']; ?>)"  value="true"
                                                              <?php
                                                                $delete = $this->admin_model->get_module_permission('delete_permission', $result['1']->role_id, $row['id']);

                                                                echo (!empty($delete)) ? 'checked' : '';
                                                                $in_delete =  (!empty($delete)) ? 'true' : 'false';  
                                                                ?>
                                                              >  

                                                              <input type="hidden" name="delete[]"  class="4_<?= $row['id']; ?>" value="<?= $in_delete; ?>" >

                                                              </td>
                                                              <td> <input type="checkbox"  onclick="check(5,<?= $row['id']; ?>)"  name="export[]" value="true"
                                                               <?php
                                                                $export = $this->admin_model->get_module_permission('export_permission', $result['1']->role_id, $row['id']);

                                                                echo (!empty($export)) ? 'checked' : '';
                                                                $in_export =  (!empty($export)) ? 'true' : 'false';    
                                                                ?>
                                                              > 
                                                              
                                                              <input type="hidden" name="export[]"  class="5_<?= $row['id']; ?>" value="<?= $in_export; ?>" >

                                                              </td>
                                                    <?php
                                                      echo'</tr>';


                                                  }
                                                
                                                    
                                                 
                                                  ?>
                                                       
                                                   </tbody>
                                               </table>
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
                                    <button class="btn green" type="submit">Update</button>
                                    <button class="btn default" onclick="cancelBtn('<?= site_url('role_permission/list')?>','form_sample_3')" type="button">Cancel</button>
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
     // CKEDITOR.replace( 'summernote_1' );
     // CKEDITOR.replace( 'summernote_2' );
     // CKEDITOR.replace( 'summernote_3' );
   
</script>
<script type="text/javascript">
  function check(permission_ops, module_id) {
      var current_hidden = $('.'+permission_ops+'_'+module_id).val();
      var permission_status = ( (current_hidden == '') || (current_hidden == 'false') ) ? 'true' : 'false';
      $('.'+permission_ops+'_'+module_id).val(permission_status);
  }
</script>
<?php $this->load->view('includes/footer'); ?>