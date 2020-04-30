<!DOCTYPE html>
<!--[if IE 8]> <html lang="en" class="ie8 no-js"> <![endif]-->
<!--[if IE 9]> <html lang="en" class="ie9 no-js"> <![endif]-->
<!--[if !IE]><!-->
<html lang="en">
<!--<![endif]-->
<!-- BEGIN HEAD -->

<?php $this->load->view('includes/login_header',$page); ?>

<!-- END HEAD -->

<body class="login">
<!-- BEGIN LOGO -->
<div class="logo">
    <h1><?php echo APP_NAME; ?></h1>
    <!-- <img height="95" width="" src="<?php  //echo IMG_URL."sltl-logo.png"; ?>" style="" alt="<?php echo APP_NAME; ?>" /> -->
</div>
<!-- END LOGO -->
<!-- BEGIN LOGIN -->
<div class="content">
    <?php echo form_open('x/', array( 'id' => 'form_sample_3','class' => 'login-form', 'autocomplete' => "off" ) );?>

    <h3 class="form-title font-green">Sign In</h3>

    <?php if( $this->session->flashdata('error') ){ ?>
        <div class="alert alert-danger">
            <button class="close" data-close="alert"></button>
            <span><?php echo $this->session->flashdata('error');?>  </span>
        </div>
    <?php } ?>

    <?php if( $this->session->flashdata('success')){ ?>
        <div class="alert alert-success">
            <button class="close" data-close="alert"></button>
            <span> <?php echo $this->session->flashdata('success'); ?>  </span>
        </div>
    <?php } ?>
    <?php if( isset( $success ) ){ ?>
        <div class="alert alert-success">
            <button class="close" data-close="alert"></button>
            <span> {{ $errors->first('success') }} </span>
        </div>
    <?php } ?>
    <p style="text-align: center;">Sign in to start your session</p>
    <div class="form-group">
        <!--ie8, ie9 does not support html5 placeholder, so we just show field title for that-->
        <label class="control-label visible-ie8 visible-ie9">Email</label>
        <input class="" style="display:none;" type="text" autocomplete="off" placeholder="Email" name="email" id="email"  />
        <input class="required email form-control form-control-solid placeholder-no-fix"  type="text" autocomplete="off" placeholder=" Email" name="email" id="email"  />
    </div>
    <div class="form-group">
        <label class="control-label visible-ie8 visible-ie9">Password</label>
        <input class="" style="display:none;" type="password" autocomplete="off" placeholder=" Password" name="password" id="password" />
        <input class="required form-control form-control-solid placeholder-no-fix" type="password" autocomplete="off" placeholder=" Password" name="password" id="password" />
    </div>
    <div class="form-group" align="center">
        <button type="submit" class="btn green uppercase">Login</button>
        <label class="rememberme check">
            <input type="checkbox" name="remember" value="1" id="remember_me" />Remember </label>
       <!--  <a href=" <?php echo site_url( 'x/forgot-password' ); ?>" id="forget-password" class="forget-password">Forgot Password?</a> -->
    </div>
    <?php echo form_close(); ?>
    <!-- END LOGIN FORM -->

</div>

<div class="copyright hide"> <?= date('y');?> © Metronic. Admin Dashboard Template. </div>
<!-- END LOGIN -->

<?php $this->load->view('includes/login_footer'); ?>
</body>
</html>