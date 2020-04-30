<!DOCTYPE html>
<!--[if IE 8]> <html lang="en" class="ie8 no-js"> <![endif]-->
<!--[if IE 9]> <html lang="en" class="ie9 no-js"> <![endif]-->
<!--[if !IE]><!-->
<html lang="en">
<!--<![endif]-->
<!-- BEGIN HEAD -->

<?php $this->load->view('includes/login_header',$page); ?>

<!-- END HEAD -->

<body class=" login">
<!-- BEGIN LOGO -->
<div class="logo">
    <img height="75" width="" src="<?php  echo IMG_URL."logo.png"; ?>" style="" alt="<?php echo APP_NAME; ?>" />
</div>
<!-- END LOGO -->
<!-- BEGIN LOGIN -->
<div class="content">

    <!-- BEGIN LOGIN FORM -->
    <?php echo form_open('x/'.$email.'/reset-password', array( 'id' => 'form_sample_3','class' => 'login-form' ) );?>


    <h3 class="form-title font-green">Reset Password</h3>

    <?php if( $this->session->flashdata('err_message')){ ?>
        <div class="alert alert-danger">
            <button class="close" data-close="alert"></button>
            <span> <?php echo $this->session->flashdata('err_message');?> </span>
        </div>
    <?php } ?>


    <div class="form-group">
        <label class="control-label visible-ie8 visible-ie9">New Password</label>
        <input class="required strongpassword form-control form-control-solid placeholder-no-fix" type="password" autocomplete="off" placeholder="New Password" name="password" id="password" /> </div>
    <div class="form-group">
        <label class="control-label visible-ie8 visible-ie9">Confirm Password</label>
        <input class="required form-control form-control-solid placeholder-no-fix" equalTo ="#password" type="password" autocomplete="off" placeholder="Confirm Password" name="confirm_password" id="confirm_password" /> </div>
    <div class="form-actions">
        <a id="back-btn" href="<?php echo site_url(); ?>" class="btn btn-default">Back</a>
        <button type="submit" class="btn green uppercase pull-right">Change Password</button>
    </div>

    <?php echo form_close(); ?>
    <!-- END LOGIN FORM -->



</div>

<div class="copyright hide"> 2014 © Metronic. Admin Dashboard Template. </div>
<!-- END LOGIN -->

<?php $this->load->view('includes/login_footer'); ?>
</body>
</html>