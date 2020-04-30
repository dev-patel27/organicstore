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
    <img height="75" width="" src="<?php  echo IMG_URL."renter.jpg"; ?>" style="" alt="<?php echo APP_NAME; ?>" />
</div>
<!-- END LOGO -->
<!-- BEGIN LOGIN -->
<div class="content">
    <!-- BEGIN FORGOT PASSWORD FORM -->

    <?php echo form_open( '/x/forgot-password', array( 'id' =>'form_sample_3', 'class' => 'login-form'  ) ); ?>

    <h3 class="font-green">Forget Password ?</h3>
    <?php if( $this->session->flashdata('email_not_exist')){ ?>
        <div class="alert alert-danger">
            <button class="close" data-close="alert"></button>
            <span> <?php echo $this->session->flashdata('email_not_exist'); ?> </span>
        </div>
    <?php } ?>
    <?php if( $this->session->flashdata('send_success')){ ?>
        <div class="alert alert-success">
            <button class="close" data-close="alert"></button>
            <span> <?php echo $this->session->flashdata('send_success'); ?>  </span>
        </div>
    <?php } ?>
    <p> Enter your e-mail address below to reset your password. </p>
    <div class="form-group">
        <input class="required email form-control placeholder-no-fix" type="text" autocomplete="off" placeholder="Email" name="email" /> </div>
    <div class="form-actions">
        <a id="back-btn" href=" <?php echo site_url(); ?>" class="btn btn-default">Back</a>
        <button type="submit" class="btn btn-success uppercase pull-right">Submit</button>
    </div>
    <?php echo form_close(); ?>
    <!-- END FORGOT PASSWORD FORM -->

</div>

<div class="copyright hide"> 2014 © Metronic. Admin Dashboard Template. </div>
<!-- END LOGIN -->

<?php $this->load->view('includes/login_footer'); ?>
</body>
</html>