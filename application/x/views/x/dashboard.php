
<?php $this->load->view('includes/header');?>

<!-- BEGIN CONTAINER -->
<div class="page-container">
<!-- BEGIN SIDEBAR -->
<?php $this->load->view('includes/sidebar');?>
<!-- END SIDEBAR -->
<!-- BEGIN CONTENT -->
<div class="page-content-wrapper">
<!-- BEGIN CONTENT BODY -->
<!-- BEGIN PAGE HEAD-->

<!-- BEGIN PAGE CONTENT BODY -->
<div class="page-content" style="min-height:1112px">
                        <!-- BEGIN PAGE HEADER-->
                        <!-- BEGIN THEME PANEL -->

                        <!-- END THEME PANEL -->
                        <!-- BEGIN PAGE BAR -->
                        <div class="page-bar">
                            <ul class="page-breadcrumb">
                                <li>
                                    <a href="<?php echo ADMIN_BASE_URL . 'dashboard'; ?>">Home</a>
                                    <i class="fa fa-circle"></i>
                                </li>
                                <li>
                                    <span>Dashboard</span>
                                </li>
                            </ul>

                        </div>
                        <!-- END PAGE BAR -->
                        <!-- BEGIN PAGE TITLE-->
                        <h1 class="page-title"> Dashboard
                            <small>dashboard &amp; statistics</small>
                        </h1>
                        <!-- END PAGE TITLE-->
                        <!-- END PAGE HEADER-->

<div class="row">
   <!-- <div class="col-lg- col-md-3 col-sm-6 col-xs-12">
        <div class="dashboard-stat2 ">
            <div class="display">
                <div class="number">
                    <h3 class="font-purple-soft">
                        <span data-counter="counterup" data-value="276"><?php //echo $total_main_category; ?></span>
                    </h3>
                    <small>Main Categories(something)</small>
                </div>
                <div class="icon">
                    <i class="icon-user"></i>
                </div>
            </div>
        </div>
    </div>

    <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
        <div class="dashboard-stat2 ">
            <div class="display">
                <div class="number">
                    <h3 class="font-red-haze">
                        <span data-counter="counterup" data-value="1349"><?php //echo $total_sub_category; ?></span>
                    </h3>
                    <small>Sub Categories(something)</small>
                </div>
                <div class="icon">
                    <i class="fa fa-flag"></i>
                </div>
            </div>
        </div>
    </div>
    <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
        <div class="dashboard-stat2 ">
            <div class="display">
                <div class="number">
                    <h3 class="font-blue-sharp">
                        <span data-counter="counterup" data-value="567"><?php //echo $total_hotline; ?></span>
                    </h3>
                    <small>Hotlines(something)</small>
                </div>
                <div class="icon">
                    <i class="fa fa-trophy"></i>
                </div>
            </div>
        </div>
    </div>
    <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
        <div class="dashboard-stat2 ">
            <div class="display">
                <div class="number">
                    <h3 class="font-blue-sharp">
                        <span data-counter="counterup" data-value="567"><?php // echo $total_happy_feedback; ?></span>
                    </h3>
                    <small>Happy Feedbacks(something)</small>
                </div>
                <div class="icon">
                    <i class="fa fa-glass"></i>
                </div>
            </div>
        </div>
    </div>
    <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
        <div class="dashboard-stat2 ">
            <div class="display">
                <div class="number">
                    <h3 class="font-green-sharp">
                        <span data-counter="counterup" data-value="7800">// echo $total_sad_feedback; ></span>
                    </h3>
                    <small>Sad Feedbacks(something)</small>
                </div>
                <div class="icon">
                    <i class="fa fa-calendar"></i>
                </div>
            </div>
        </div>
    </div>
	-->
		<div class="page-logo" align="center">
            <a href="#">
                <img class="logo-default" height="70px" width="40%" src="<?php echo IMG_URL . "renter.jpg"; ?>" style="" alt="<?php echo APP_NAME; ?>" />

            </a>
        </div>


</div>
</div>

</div>

 <a href="javascript:;" class="page-quick-sidebar-toggler"><i class="icon-login"></i></a>



</div>

<!-- End Hotline Content -->

<!-- INCLUDE FOOTER -->
<?php $this->load->view('includes/inner_footer');?>
<?php $this->load->view('includes/dashboard_js');?>

<?php $this->load->view('includes/footer');?>