<!--=======================footer start==============================-->
<div id="newsletter">
    <div class="container">
        <div class="row">
            <div class="col-md-7">
                <h4>Join Our Newsletter Now</h4>
                <p class="m-0">Get E-mail updates about our latest shop and special offers.</p>
            </div>
            <div class="col-md-5">
                <div class="input-group">
                    <input type="email" class="form-control newsletter" name="newsemail" id="newsemail"
                           placeholder="Enter your mail">
                    <span class="input-group-btn">
                        <button class="btn btn-theme" type="button" id="newsletter-form">Subscribe</button>
                    </span>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="container py-5" style="padding-bottom: 1rem !important;">
    <div class="row">
        <?php
$web_info = $this->front_model->get_web_setting();
$social_link = json_decode($web_info->social_link);
?>
        <div class="col-lg-5 col-md-6 col-sm-6 address wow fadeInLeft">
            <div class="footer-logo">
                <img src="assets/images/logo.png" style="width: 30%;" alt="" title=""
                                          class="img-fluid">
            </div>
            <?=$web_info->address;?>
            <p><?=$web_info->cell_number;?></p>
            <p>Email: <a href="mailto:<?=$web_info->email;?>"><?=$web_info->email;?></a></p>
            <ul class="social-2">
                <li><a href="<?=$social_link->facebook;?>" title="facebook"><i class="fa fa-facebook"></i></a></li>
                <li><a href="<?=$social_link->instagram;?>" title="instagram +"><i class="fa fa-instagram"></i></a></li>
                <li><a href="<?=$social_link->twitter;?>" title="twitter"><i class="fa fa-twitter"></i></a></li>
                <li><a href="<?=$social_link->linkedin;?>" title="Linkedin"><i class="fa fa-linkedin"></i></a></li>
            </ul>
        </div>
        <div class="col-lg-4 col-md-6 col-sm-6 footer-link  wow fadeInLeft">
            <h3>Information</h3>
            <ul>
                <li><a href="<?=site_url('')?>">Home</a></li>
                <li><a href="<?=site_url('about-us')?>">About Us</a></li>
                <li><a href="<?=site_url('fruits-vegetables')?>">Products</a></li>
            </ul>
        </div>
        <div class="col-lg-3 col-md-6 col-sm-6 footer-link  wow fadeInLeft">
            <h3>Customer Care</h3>
            <ul>
                <li><a href="<?=site_url('terms-conditions')?>">T&C</a></li>
                <li><a href="<?=site_url('faq')?>">Faq</a></li>
                <li><a href="<?=site_url('contact')?>">Contact</a></li>
            </ul>
        </div>
    </div>
</div>
<footer class="py-4 bg-dark">
    <div class="container copy-right">
        <div class="row">
            <div class="col-md-6 text-white"> Copyright © 2019 <a href="#">Organic Store </a>- All Rights Reserved.
            </div>
            <div class="col-md-6 payment">
                <div class="pull-right"><a href="#"><img src="<?=FRONT_ASSETS_URL?>/images/payumoney.jpg" alt=""
                                                         title=""></a><a href="#"><img
                                src="<?=FRONT_ASSETS_URL?>/images/mr.png" alt="" title=""></a> <a href="#"><img
                                src="<?=FRONT_ASSETS_URL?>/images/visa.png" alt="" title=""></a></div>
            </div>
        </div>
    </div>
</footer>
<!--=======================footer end==============================-->