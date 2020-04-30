<!-- INCLUDE HEADER -->
<?php $this->load->view('includes/header');
//echo '<pre>';print_r($result);exit;?>

<!-- Begain Hotline Content -->

    <div class="page-container">
        <!-- BEGIN CONTENT -->
        <!-- END PAGE BREADCRUMBS -->
                    <!-- BEGIN PAGE CONTENT INNER -->
                    <div class="page-content-wrapper">
                        <!-- BEGIN CONTENT BODY -->
                        <!-- BEGIN PAGE HEAD-->
                        <div class="page-head">
                            <div class="container">
                                <!-- BEGIN PAGE TITLE -->
                                <div class="page-title">
                                    <h1>Admin
                                        <small>Change Password</small>
                                    </h1>
                                </div>
                                <!-- END PAGE TITLE -->
                            </div>
                        </div>
                        <!-- END PAGE HEAD-->
                        <!-- BEGIN PAGE CONTENT BODY -->
                        <div class="page-content">
                            <div class="container">
                                <!-- BEGIN PAGE BREADCRUMBS -->
                                <ul class="page-breadcrumb breadcrumb">
                                    <li>
                                        <a href="<?php echo ADMIN_BASE_URL.'dashboard';?>">Home</a>
                                        <i class="fa fa-circle"></i>
                                    </li>
                                    <!--<li>
                                        <a href="<?php /*echo ADMIN_BASE_URL.$this->_loginData->id.'/edit';*/?>">My Profile</a>
                                        <i class="fa fa-circle"></i>
                                    </li>-->
                                    <li>
                                        <span>Change Password</span>
                                    </li>
                                </ul>
                                <!-- END PAGE BREADCRUMBS -->
                                <!-- BEGIN PAGE CONTENT INNER -->
                                <div class="page-content-inner">
                                    <div class="row">
                                        <div class="col-md-12">
                                            <!-- BEGIN VALIDATION STATES-->
                                            <div class="portlet light form-fit ">
                                                <div class="portlet-title">
                                                    <div class="caption">
                                                        <i class="icon-bubble font-green"></i>
                                                        <span class="caption-subject font-green bold uppercase">Change Password</span>
                                                    </div>
                                                </div>
                                                <div class="portlet-body form">
                                                    <!-- BEGIN FORM-->
                                                    <?php echo form_open( 'x/change-password', array( 'id' =>'form_sample_3', 'class' => 'form-horizontal', 'method' =>'post','enctype'=>'multipart/form-data' ) ); ?>
                                                    <div class="form-body">
                                                        <?php if( $this->session->flashdata('success')  ){ ?>
                                                            <div class="alert alert-success">
                                                                <button class="close" data-close="alert"></button>
                                                                <span><?php echo $this->session->flashdata('success');?> </span>
                                                            </div>
                                                        <?php } ?>
                                                        <?php if( $this->session->flashdata('err_message')  ){ ?>
                                                            <div class="alert alert-danger">
                                                                <button class="close" data-close="alert"></button>
                                                                <span><?php echo $this->session->flashdata('err_message');?> </span>
                                                            </div>
                                                        <?php } ?>
                                                        <div class="alert alert-danger display-hide">
                                                            <button class="close" data-close="alert"></button> You have some form errors. Please check below. </div>
                                                        <?php /*<div class="alert alert-success display-hide">
                                                        <button class="close" data-close="alert"></button> Your form validation is successful! </div>*/ ?>
                                                        <div class="form-group  margin-top-20">
                                                            <label class="control-label col-md-3">Current Password
                                                                <span class="required"> * </span>
                                                            </label>
                                                            <div class="col-md-4">
                                                                <div class="input-icon right">
                                                                    <i class="fa"></i>
                                                                    <input type="password" class="required form-control"
                                                                           name="current_password"
                                                                           onchange="mypassword(this.value)"/>
                                                                    <span id="error_msg" style="color:#e73d4a"> </span>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="form-group  margin-top-20">
                                                            <label class="control-label col-md-3">New Password
                                                                <span class="required"> * </span>
                                                            </label>
                                                            <div class="col-md-4">
                                                                <div class="input-icon right">
                                                                    <i class="fa"></i>
                                                                    <input type="password" value=""
                                                                           class="required  form-control"
                                                                           name="password" id="password"/>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="form-group  margin-top-20">
                                                            <label class="control-label col-md-3">Confirmed Password
                                                                <span class="required"> * </span>
                                                            </label>
                                                            <div class="col-md-4">
                                                                <div class="input-icon right">
                                                                    <i class="fa"></i>
                                                                    <input type="password" value="" class="required form-control" name="confirmed_password"   equalTo ="#password" /> </div>
                                                            </div>
                                                        </div>
                                                        <div class="form-actions">
                                                            <div class="row">
                                                                <div class="col-md-offset-3 col-md-9">
                                                                    <button type="submit" class="btn green" id="addsubmit">Submit
                                                                    </button>
                                                                    <button type="button" class="btn default">Cancel</button>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <?php echo form_close(); ?>
                                                        <!-- END FORM-->
                                                    </div>
                                                </div>
                                                <!-- END VALIDATION STATES-->
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>

<!-- INCLUDE FOOTER -->
<?php $this->load->view('includes/inner_footer'); ?>
<?php $this->load->view('includes/form_js'); ?>

<?php $this->load->view('includes/footer'); ?>