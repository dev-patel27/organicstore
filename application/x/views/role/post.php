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
               <span>Add</span>
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
                                       <select class="required table-group-action-input form-control required" name="role_id" width="100%" id="" >
                                          <option value="">Select Role</option>
                                          <?php
                                             $role = $this->admin_model->get_role_category();
                                             foreach($role as $row_c)
                                             {
                                                
                                                echo '<option value="'.$row_c['id'].'" >'.$row_c['role_name'].'</option>';
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
                                 <label class="control-label col-md-3">Module Category
                                 <span class="required"> * </span>
                                 </label>
                                 <div class="col-md-9">
                                    <div class="input-icon right">
                                       <i class="fa"></i>
                                       <select class="required table-group-action-input form-control " name="module_id" width="100%" id="module_id" >
                                          <option value="">Select Module</option>
                                          <?php
                                             $role = $this->admin_model->get_module_category();
                                             foreach($role as $row_c)
                                             {
                                                
                                                echo '<option value="'.$row_c['id'].'" >'.$row_c['module_name'].'</option>';
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
                                       <select class="required table-group-action-input form-control" name="sub_module_id" width="100%" id="sub_module_id" >
                                          <option value="">Select Sub category</option>


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
                                        <input type="checkbox" name="view" value="true" > view
                                        <input type="checkbox" name="add" value="true" > add
                                        <input type="checkbox" name="update" value="true" > update
                                        <input type="checkbox" name="delete" value="true" > delete
                                       <input type="checkbox" name="export" value="true" > export
                                    </div>
                                 </div>
                              </div>
                           </div>
                        </div>

                     <?php
                     /*$count_module = 1;
                     $row_count = 1;
                     $module = $this->admin_model->get_module_category();
                     foreach ($module as $key => $row) {

                     echo '

                      <div class="row">
                        <div class="col-md-12">
                           <div class="form-group">
                              <label class="control-label col-md-3">'.$row['module_name'].'
                             
                              </label>
                              <div class="col-md-9">
                                 <div class="portlet-body">
                                    <div class="table-scrollable">
                                       <table class="table table-condensed table-hover">
                                          <tbody>';


                                          $sub_module = $this->admin_model->get_sub_module($row['id']);
                                          foreach ($sub_module as $key => $row_sub) {
                                             
                                             echo 
                                             '
                                             <input type="hidden" name="sub_module_id[]" value="'.$row_sub['id'].'" >
                                             <input type="hidden" name="module_id[]" value="'.$row_sub['module_id'].'" >
                                             <tr>
                                                <td>'.$row_count++.'. '.$row_sub['sub_module_name'].'</td>
                                                <td> 
                                                <input type="hidden" name="view[]" value="0" />
                                                <input class="check" type="checkbox" name="view[]" value="1" > view</td>
                                                <td> 
                                                <input type="hidden" name="add[]" value="0" />
                                                <input class="check" type="checkbox" name="add[]"  value="1" > add</td>
                                                <td> 
                                                <input type="hidden" name="update[]" value="0" />
                                                <input class="check" type="checkbox" name="update[]"  value="1" > update</td>
                                                <td> 
                                                <input type="hidden" name="delete[]" value="0" />
                                                <input class="check" type="checkbox" name="delete[]"  value="1" > delete</td>
                                                <td> 
                                                <input type="hidden" name="export[]" value="0" />
                                                <input class="check" type="checkbox" name="export[]"  value="1" > export</td>
                                             </tr>';
                                          }
                                            
                                           

                                          echo'
                                          </tbody>
                                       </table>
                                    </div>
                                 </div>
                              </div>
                           </div>
                        </div>
                     </div>
                     ';


                     }*/
                     ?>
                    
                     <div class="form-actions">
                        <div class="row">
                           <div class="col-md-12">
                              <div class="row">
                                 <div class="col-md-offset-3 col-md-9">
                                    <button class="btn green" type="submit">Submit</button>
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
   /*  
   $( ".check" ).click(function() {
      if ($('.check').is(':checked')) {
         $(this).attr('value', 'true');
      }
      else
      {
         $(this).attr('value', 'false');
      }
   });
   */

   $( "#module_id" ).change(function() {
      var module_id = $('#module_id').val();
      $("#sub_module_id").find('option').remove();
      $.ajax({
         type:'POST',
         url: "get_sub_module",
         data: { module_id: module_id},
         success:function(html){
      
            $('#sub_module_id').append(html);

         }

      });
   });

</script>
<?php $this->load->view('includes/footer'); ?>