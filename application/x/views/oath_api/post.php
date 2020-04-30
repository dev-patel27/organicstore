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
                  <!--<a href="<?php echo ADMIN_BASE_URL. 'property'; ?>">Property</a>-->
                  <span>API</span>
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
                  <form action="<?= $this->admin_model->current_page_url(); ?>" id="form_sample_3" method="post" class="form-horizontal" enctype="multipart/form-data">
                     <div class="alert alert-danger display-hide">
                        <button class="close" data-close="alert"></button> You have some form errors. Please check below.
                     </div>


                     <div class="form-body">


                <?php 
               //echo "<pre>"; print_r($store); exit;
               ?>

                     <div class="row">
                        <div class="col-md-12">
                           <div class="form-group">
                              <label class="control-label col-md-3">Select Store
                              <span class="required"> * </span>
                              </label>
                             <div class="col-md-9">
                              <div class="input-icon right">
                              <i class="fa"></i>
                              <select class="required table-group-action-input form-control" name="store_id" width="100%" id="" >
                              <option value="">Select Store</option>

                              <?php
                                 foreach($store as $str)
                                 {
                                 
                                    if($this->_type == 'user')
                                    {
                                       if($this->_loginData->active_store == $str['store_id'])
                                       {
                                          echo '<option value="'.$str['store_id'].'" selected>'.$str['store_name'].'</option>';
                                       }
                                    }
                                    else
                                    {
                                        echo '<option value="'.$str['store_id'].'">'.$str['store_name'].'</option>';
                                    }
                                 }
                               ?>    
                              </select>
                              </div>
                              </div>
                           </div>
                        </div>
                     </div>


                      <hr>
                        <h3 align="center">Facebook OAuth API</h3>
                      <hr>


                       
                        <div class="row">
                           <div class="col-md-12">
                              <div class="form-group">
                                 <label class="control-label col-md-3">Client ID
                                 <span class="required"> * </span>
                                 </label>
                                 <div class="col-md-9">
                                    <div class="input-icon right">
                                       <i class="fa"></i>
                                       <input type="text" class="form-control required" placeholder="Client ID" name="fb_client_id" id=""  />
                                    </div>
                                 </div>
                              </div>
                           </div>
                        </div>


                       
                        <div class="row">
                           <div class="col-md-12">
                              <div class="form-group">
                                 <label class="control-label col-md-3">Client Secret
                                 <span class="required"> * </span>
                                 </label>
                                 <div class="col-md-9">
                                    <div class="input-icon right">
                                       <i class="fa"></i>
                                       <input type="text" class="form-control required" placeholder="Client Secret" name="fb_client_secret" id=""  />
                                    </div>
                                 </div>
                              </div>
                           </div>
                        </div>



                       
                        <div class="row">
                           <div class="col-md-12">
                              <div class="form-group">
                                 <label class="control-label col-md-3">Authorization Base URL
                                 <span class="required"> * </span>
                                 </label>
                                 <div class="col-md-9">
                                    <div class="input-icon right">
                                       <i class="fa"></i>
                                       <input type="text" class="form-control required" placeholder="Authorization Base URL" name="fb_authorization_base_url" id=""  />
                                    </div>
                                 </div>
                              </div>
                           </div>
                        </div>


                       
                        <div class="row">
                           <div class="col-md-12">
                              <div class="form-group">
                                 <label class="control-label col-md-3">Token URL
                                 <span class="required"> * </span>
                                 </label>
                                 <div class="col-md-9">
                                    <div class="input-icon right">
                                       <i class="fa"></i>
                                       <input type="text" class="form-control required" placeholder="Token URL" name="fb_token_url" id=""  />
                                    </div>
                                 </div>
                              </div>
                           </div>
                        </div>


                       
                        <div class="row">
                           <div class="col-md-12">
                              <div class="form-group">
                                 <label class="control-label col-md-3">Redirect URL
                                 <span class="required"> * </span>
                                 </label>
                                 <div class="col-md-9">
                                    <div class="input-icon right">
                                       <i class="fa"></i>
                                       <input type="text" class="form-control required" placeholder="Redirect URL" name="fb_redirect_url" id=""  />
                                    </div>
                                 </div>
                              </div>
                           </div>
                        </div>





                      <hr>
                        <h3 align="center">Google OAuth API</h3>
                      <hr>


                       
                        <div class="row">
                           <div class="col-md-12">
                              <div class="form-group">
                                 <label class="control-label col-md-3">Client ID
                                 <span class="required"> * </span>
                                 </label>
                                 <div class="col-md-9">
                                    <div class="input-icon right">
                                       <i class="fa"></i>
                                       <input type="text" class="form-control required" placeholder="Client ID" name="google_client_id" id=""  />
                                    </div>
                                 </div>
                              </div>
                           </div>
                        </div>


                       
                        <div class="row">
                           <div class="col-md-12">
                              <div class="form-group">
                                 <label class="control-label col-md-3">Client Secret
                                 <span class="required"> * </span>
                                 </label>
                                 <div class="col-md-9">
                                    <div class="input-icon right">
                                       <i class="fa"></i>
                                       <input type="text" class="form-control required" placeholder="Client Secret" name="google_client_secret" id=""  />
                                    </div>
                                 </div>
                              </div>
                           </div>
                        </div>



                       
                        <div class="row">
                           <div class="col-md-12">
                              <div class="form-group">
                                 <label class="control-label col-md-3">Authorization Base URL
                                 <span class="required"> * </span>
                                 </label>
                                 <div class="col-md-9">
                                    <div class="input-icon right">
                                       <i class="fa"></i>
                                       <input type="text" class="form-control required" placeholder="Authorization Base URL" name="google_authorization_base_url" id=""  />
                                    </div>
                                 </div>
                              </div>
                           </div>
                        </div>


                       
                        <div class="row">
                           <div class="col-md-12">
                              <div class="form-group">
                                 <label class="control-label col-md-3">Token URL
                                 <span class="required"> * </span>
                                 </label>
                                 <div class="col-md-9">
                                    <div class="input-icon right">
                                       <i class="fa"></i>
                                       <input type="text" class="form-control required" placeholder="Token URL" name="google_token_url" id=""  />
                                    </div>
                                 </div>
                              </div>
                           </div>
                        </div>


                       
                        <div class="row">
                           <div class="col-md-12">
                              <div class="form-group">
                                 <label class="control-label col-md-3">Scope
                                 <span class="required"> * </span>
                                 </label>
                                 <div class="col-md-9">
                                    <div class="input-icon right">
                                       <i class="fa"></i>
                                       <input type="text" class="form-control required" placeholder="Scope" name="google_scope" id=""  />
                                    </div>
                                 </div>
                              </div>
                           </div>
                        </div>








                        <!-- <div class="row">
                           <div class="col-md-12">
                              <div class="form-group">
                                 <label class="control-label col-md-3">Status
                                <span class="required"> * </span>
                                 </label>
                                 <div class="col-md-9">
                                    <div class="input-icon right">
                                       <i class="fa"></i>

                                       <label><input type="radio" class="form-control required" name="status" value="0">Inactive</label>
                                       <label><input type="radio" class="form-control required" name="status" value="1">Active</label>                        
                                    </div>
                                 </div>
                              </div>
                           </div>
                        </div> -->


                     </div>
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
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.9.0/moment-with-locales.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datetimepicker/4.17.47/js/bootstrap-datetimepicker.min.js"></script>
<script type="text/javascript">
   $('.datetimepicker1').datetimepicker({ 
      //format: 'dd-MM-yyyy', 
      //format: 'YYYY-MM-DD hh:mm A'  
      format: 'YYYY-MM-DD'   
   });
</script>
<script type="text/javascript">
   document.getElementById('myfield').setAttribute('maxlength',30)
   CharacterCount = function(TextArea,FieldToCount){
      var myField = document.getElementById(TextArea);
      var myLabel = document.getElementById(FieldToCount); 
      if(!myField || !myLabel){return false}; // catches errors
      var MaxChars =  myField.maxLengh;
      if(!MaxChars){MaxChars =  myField.getAttribute('maxlength') ; };  if(!MaxChars){return false};
      var remainingChars =   MaxChars - myField.value.length
      myLabel.innerHTML = remainingChars+" Characters Remaining of Maximum "+MaxChars
   }
   //SETUP!!
   setInterval(function(){CharacterCount('myfield','CharCountLabel1')},55);
</script>

<script type="text/javascript">
   $('#plus_one_live_call').click(function ()
      {
         var clone_div = $('.live_call_twitter_clone').html();
         $('.live_call_twitter').append('<div class="live_call_twitter_clone">'+clone_div+'<button type="button" class="mb-xs mr-xs btn btn-info removemore_live_call pull-right"><i class="fa fa-remove"></i></button></div>');
         call_datepicker();
      }
   );

   $(document).on('click', '.removemore_live_call', function () {
      $(this).parents('.live_call_twitter_clone').remove();
   });

   $('#plus_one_result_update').click(function ()
      {

         var clone_div = $('.update_call_twitter_clone').html();
         $('.update_call_twitter').append('<div class="update_call_twitter_clone">'+clone_div+'<button type="button" class="mb-xs mr-xs btn btn-info removemore_update_call pull-right"><i class="fa fa-remove"></i></button></div>');
         call_datepicker();

      }
   );

   $(document).on('click', '.removemore_update_call', function () {
      $(this).parents('.update_call_twitter_clone').remove();
   });


    $('#plus_one_chart').click(function ()
      {
         $(".select2").select2("destroy");
         var clone_div = $('.row_chart').html();

         $('.chart_p').append('<div class="row_chart">'+clone_div+'<button type="button" class="mb-xs mr-xs btn btn-info removemore_chart pull-right"><i class="fa fa-remove"></i></button></div>');
         $('.select2').select2();
      }
   );

   $(document).on('click', '.removemore_chart', function () {
      $(this).parents('.row_chart').remove();
   });


   function call_datepicker()
   {
      $('.datetimepicker1').datetimepicker({ 
         format: 'YYYY-MM-DD'   
      });
   }

</script>




<?php $this->load->view('includes/footer'); ?>