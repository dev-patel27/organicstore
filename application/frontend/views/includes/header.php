<!--Animate loader off screen-->
<script>
$(document).ready(function (e) {
    $(window).load(function () {
        // Animate loader off screen
        $(".se-pre-con").fadeOut("slow");
    });
});
</script>
<!--Animate loader off screen-->
<body>
<div class="se-pre-con"></div>
<div class="clearfix"></div>
<nav class="navbar navbar-expand-lg navbar-dark bg-white" style="margin-top: -14px;">
    <div class="container" style="margin-bottom: -8px;">
        <a class="navbar-brand" href="<?=site_url()?>">
            <img src="<?=FRONT_ASSETS_URL?>images/logo.png" alt="" title="" style="height: 80px !important;"
                 class="img-fluid my-img">
        </a>
        <button class="navbar-toggler navbar-toggler-right" type="button" data-toggle="collapse"
                data-target="#navbarResponsive" aria-controls="navbarResponsive" aria-expanded="false"
                aria-label="Toggle navigation"><span class="navbar-toggler-icon"></span> <span
                    class="navbar-toggler-icon"></span> <span class="navbar-toggler-icon"></span></button>
        <div class="collapse navbar-collapse" id="navbarResponsive">
            <ul class="navbar-nav">
                <li class="nav-item">
                    <a class="nav-link" href="<?=site_url()?>"> Home </a>
                </li>
                <li class="nav-item">
                    <a style="width: 120%;" class="nav-link" href="<?=site_url('fruits-vegetables')?>">Products</a>
                </li>
                <li class="nav-item">
                    <a style="width: 120%;" class="nav-link" href="<?=site_url('about-us')?>">About Us</a>
                </li>
                <li class="nav-item">
                    <a style="width: 120%;margin-left: 20px;" class="nav-link" href="<?=site_url('contact')?>">Contact
                        Us</a>
                </li>
                <?php
if (!$this->session->userdata('userSession')) {
    ?>
                <li class="nav-item col-md-4" style="top: 10px;">
                       <div class="col-12">
                        <a href="#" data-toggle="modal" data-backdrop="false" data-target="#LogInModal">Login</a> / <a href="#" data-toggle="modal" data-backdrop="false" data-target="#RegistrationModal">Register <i class="fa fa-id-card-o" aria-hidden="true"></i></a>
                        </div>
                </li>
                <?php
} else {
    ?>
<?php
}
?>
            </ul>
                <?php
if ($this->session->userdata('userSession')) {
    ?>
            <div class="rate-price nav-1">
                <ul>
                    <li class="dropdown">
                        <a href="<?=site_url('myaccount')?>">
                            <i class="fa fa-user-circle-o" aria-hidden="true"></i>
                        </a>
                    </li>
                    <?php
} else {
    ?>
            <div class="rate-price nav-1" style="width: 10% !important;">
                <ul>
<?php
}
?>
                    <li>
                        <a href="<?=site_url('wishlist')?>">
                            <i class="fa fa-heart-o" aria-hidden="true"></i>
                            <?php
$wishlist = $this->front_model->get_wishlist($this->userSession->id);
$total_wishlist = count($wishlist);
?>
                            <span class="circle-2 my-wishlist"><?=$total_wishlist?></span>
                        </a>
                    </li>
                    <li>
                        <a href="<?=site_url('cart')?>">
                            <i class="fa fa-shopping-bag" aria-hidden="true"></i>
                            <?php
$cart = $this->front_model->get_cart($this->userSession->id);
if (!empty($cart)) {
    echo '<span class="circle-2 my-cart">' . $cart . '</span>';
} else {
    echo '<span class="circle-2 my-cart">0</span>';
}
?>
                        </a>
                    </li>
                </ul>
            </div>
        </div>

        <div class="clearfix"></div>
    </div>
    <div class="clearfix"></div>
</nav>

<!-- ------- LOGIN ------- -->
<div class="modal fade" id="LogInModal" tabindex="-1" role="dialog" aria-labelledby="modalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close my-close" data-dismiss="modal">
                    <span aria-hidden="true">×</span>
                    <span class="sr-only">Close</span>
                </button>
            </div>
            <div class="modal-body">
                <form name="login-form" id="login-form">
                    <!-- Form Title -->
                    <div class="form-heading text-center">
                        <div class="title">Sign In</div>
                        <!-- Social Line -->
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <input type="text" placeholder="Username / E-mail" id="login_id" name="login_id"/>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <input type="password" placeholder="Password" name="login_password" id="login_password"/>
                            <a class="forgot-pass" data-toggle="modal" data-target="#ForgotModal" data-backdrop="false"
                               data-dismiss="modal" href="#">Forgot?</a>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12 text-center">
                            <button class="btn btn-md my-btn-success">Sign In</button>
                        </div>
                    </div>
                    <div class="mt-3">
                        <hr>
                    </div>
                    <div class="row justify-content-center">
                        <div class="input-field col-md-12 text-center">
                            <p class="margin medium-small">
                                <a href="#" data-toggle="modal" data-target="#RegistrationModal" data-backdrop="false"
                                   data-dismiss="modal">New to <strong>Organic
                                        Store?</strong> Create an account
                                </a>
                            </p>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<!-- ------- LOGIN Ends ------- -->


<!-- ------- REGISTRATION ------- -->
<div class="modal fade" id="RegistrationModal" tabindex="-1" role="dialog" aria-labelledby="modalLabel"
     aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close my-close" data-dismiss="modal"><span aria-hidden="true">×</span><span
                            class="sr-only">Close</span></button>
            </div>
            <div class="modal-body">
                <form name="reg_form" id="reg-form">
                    <!-- Form Title -->
                    <div class="form-heading text-center">
                        <div class="title">Registration</div>
                        <p class="title-description">Already have an account?
                            <a href="#" data-toggle="modal" data-target="#LogInModal" data-dismiss="modal">
                                <strong>Sign in</strong>.
                            </a>
                        </p>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <input type="text" name="first_name" id="first_name" placeholder="First Name"/>
                        </div>
                        <div class="col-md-6">
                            <input type="text" name="last_name" id="last_name" placeholder="Last Name"/>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <input type="text" name="username" id="username" placeholder="Username"/>
                        </div>
                        <div class="col-md-6">
                            <input type="text" name="email" id="email" placeholder="Email Address" />
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <input type="password" name="password" id="password" placeholder="Password"/>
                        </div>
                        <div class="col-md-6">
                            <input type="password" name="re_password" id="re_password" placeholder="Re-password"/>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12 text-center">
                            <button class="btn btn-md my-btn-success">Create Account</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<!-- ------- REGISTRATION Ends ------- -->


<!-- ------- FORGOT FORM ------- -->
<div class="modal fade" id="ForgotModal" tabindex="-1" role="dialog" aria-labelledby="modalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close my-close" data-dismiss="modal">
                    <span aria-hidden="true">×</span>
                    <span class="sr-only">Close</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="forgotpass-form" name="forgotpass-form">
                    <!-- Form Title -->
                    <div class="form-heading text-center">
                        <div class="title">Forgot Password?</div>
                        <p class="title-description">We'll email you a link to reset it.</p>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <input type="text" name="forgot_email" id="forgot_email" placeholder="Your E-mail Address"/>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12 text-center">
                            <button class="btn btn-md my-btn-success">Send Mail</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<!-- ------- FORGOT FORM ends ------- -->


<!-- Navigation -->
<div class="container search-div">
    <div class="row">
        <div class=" col-lg-3 col-md-4">
            <div class="all-cate-custom dropdown dropdown-toggle dropcss" type="button"         id="dropdownMenu1" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                <span class="all-cate-sub">Shop by Category</span>
                <ul class="dropdown-menu multi-level" role="menu" aria-labelledby="dropdownMenu">
                    <?php
$category = $this->front_model->get_product_category();
foreach ($category as $key => $value) {
    $query_category = $this->db->where(array('status' => '1', 'category_id' => $value['id']))->group_by('id')->get('tbl_product')->row();
    if (!empty($query_category)) {
        ?>
                            <li class="dropdown-submenu">
                                <a class="dropdown-item"
                                   onclick="window.location.href='<?=site_url($value['id'] . '-' . url_title(strtolower($value['category_name'])))?>'"
                                   href="javascript:void(0);" tabindex="-1"><?=$value['category_name']?></a>
                                <ul class="dropdown-menu">
                                    <?php
$sub_category = $this->front_model->get_product_subcategory($value['id']);
        foreach ($sub_category as $key1 => $value1) {
            $query_subcategory = $this->db->where(array('status' => '1', 'category_id' => $value['id'], 'sub_category_id' => $value1['id']))->group_by('id')->get('tbl_product')->row();
            if (!empty($query_subcategory)) {
                ?>
                            <li class="dropdown-submenu">
                                <a class="dropdown-item"
                                    onclick="window.location.href='<?=site_url(url_title(strtolower($value['category_name'])) . '/' . $value1['id'] . '-' . url_title(strtolower($value1['sub_category_name'])))?>'"
                                    href="javascript:void(0);"><?=$value1['sub_category_name']?></a>
                                <ul class="dropdown-menu">
                                    <?php
$product = $this->front_model->get_product($value['id'], $value1['id']);
                foreach ($product as $key2 => $value2) {
                    ?>
                            <li class="dropdown-item">
                                <a onclick="window.location.href='<?=site_url(url_title(strtolower($value['category_name'])) . '/' . url_title(strtolower($value1['sub_category_name'])) . '/' . $value2['id'] . '-' . url_title(strtolower($value2['product_name'])))?>'"
                                    href="javascript:void(0);"><?=$value2['product_name']?></a>
                            </li>
                            <?php
}
                ?>
                    </ul>
                </li>
                <?php
}
            ?>
<?php
}
        ?>
    </ul>
</li>
<?php
}
}
?>
                </ul>
            </div>
        </div>
        <div class="col-lg-9 col-md-8">
            <div class="input-group filter-by">
                <input type="hidden" name="search_param" value="all" id="search_param">
                <input type="text" class="search-placeholder form-control" id="search-top" name="search_top" placeholder="What do you need?">
                <span class="input-group-btn">
                    <button class="btn btn-default search-bt" type="button">SEARCH</button>
                </span>
            </div>
            <div class="suggestion" style="display: none;" id="suggestion"></div>
        </div>
    </div>
</div>
<!-- Navigation -->
