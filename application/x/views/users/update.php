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
                <a href="<?= ADMIN_BASE_URL.$this->router->fetch_class().'/add-user/list'; ?>"><span><?= ucfirst($this->router->fetch_class()); ?></span></a>
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
                                        <form action="<?= current_url(); ?>" id="form_sample_3" method="post" class="form-horizontal" enctype="multipart/form-data">
                                            <div class="alert alert-danger display-hide">
                                                <button class="close" data-close="alert"></button> You have some form errors. Please check below.
                                            </div>
                                            <input type="hidden" name="pages[0][id]" value="<?php echo $result[1]->id; ?>" />
                                            

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

                                            <div class="form-body">

                                                <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label class="control-label col-md-3">Type of user
                                         <span class="required"> * </span>
                                    </label>
                                    <div class="col-md-9">
                                        <div class="input-icon right">
                                            <i class="fa"></i>
                                            <select class="table-group-action-input form-control" name="role_id" width="100%" id="role_id" class="required">
                                            <option value="">Select User</option>
                                            <?php
                                            $user = $this->admin_model->get_users();
                                            foreach($user as $row)
                                            {
                                                if($result[1]->role_id==$row['id'])
                                                {
                                                     echo '<option value="'.$row['id'].'" selected>'.$row['type_name'].'</option>';
                                                }
                                                else
                                                {
                                                     echo '<option value="'.$row['id'].'">'.$row['type_name'].'</option>';
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
                                    <label class="control-label col-md-3">Name
                                         <span class="required"> * </span>
                                    </label>
                                    <div class="col-md-9">
                                        <div class="input-icon right">
                                            <i class="fa"></i>
                                            <input type="text" class="required form-control " placeholder="Name" name="name" value="<?= $result[1]->name; ?>" id="name"  />
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label class="control-label col-md-3">Email
                                         <span class="required"> * </span>
                                    </label>
                                    <div class="col-md-9">
                                        <div class="input-icon right">
                                            <i class="fa"></i>
                                            <input type="email" class="required form-control " placeholder="Email Id" name="email" value="<?= $result[1]->email; ?>"  />
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        


                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label class="control-label col-md-3">Password
                                         <span class="required"> * </span>
                                    </label>
                                    <div class="col-md-9">
                                        <div class="input-icon right">
                                            <i class="fa"></i>
                                            <input type="text" class="required form-control " placeholder="Password" value="<?= $result[1]->password; ?>" name="password"  />
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                      
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label class="control-label col-md-3">Mobile Number
                                         <span class="required"> * </span>
                                    </label>
                                    <div class="col-md-9">
                                        <div class="input-icon right">
                                            <i class="fa"></i>
                                            <input type="text" class="required form-control " placeholder="Mobile Numbers" name="mobile_number" id="mobile_number" value="<?= $result[1]->mobile_number; ?>" />
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label class="control-label col-md-3">Address
                                         <span class="required"> * </span>
                                    </label>
                                    <div class="col-md-9">
                                        <div class="input-icon right">
                                            <i class="fa"></i>
                                            <textarea class="required form-control " name="address" id="address"><?= $result[1]->address; ?></textarea>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                         <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label class="control-label col-md-3">Alternate Mobile Number
                                         <span class="required"> * </span>
                                    </label>
                                    <div class="col-md-9">
                                        <div class="input-icon right">
                                            <i class="fa"></i>
                                            <textarea class="required form-control " name="alternate_mobile_number" id="address"><?= $result[1]->alternate_mobile_number; ?></textarea>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                         <div class="row">
                           <div class="col-md-12">
                              <div class="form-group">
                                 <label class="control-label col-md-3">Manager Image </label>
                                 <div class="col-md-9">
                                    <div class="input-icon right">
                                       <i class="fa"></i>
                                       <input type="file"  placeholder="manager_image" name="manager_image" id="manager_image"  />
                                    </div>
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
    CKEDITOR.replace( 'summernote_2' );


</script>
<?php $this->load->view('includes/footer'); ?>
