<!DOCTYPE html>
<html lang="en">
<head>
    <!--=======================header & start file==============================-->
    <?php include 'includes/start.php';?>
    <?php include 'includes/header.php';?>
    <!--=======================header & start file==============================-->


    <!-- Start of WOWSlider-->
    <?php include 'includes/slider.php';?>
    <!--end of wow slider -->


    <div class="clearfix"></div>
    <div class="banner-patten mt-4 mb-4">
        <div class="container">
            <div class="banner-div" style="top:0">
                <div class="row m-0">
                    <div class="col-lg-4 col-md-4 col-sm-4 boder-left wow fadeInLeft"><img
                                src="<?=FRONT_ASSETS_URL?>/images/shipping.png" alt="" title="">
                        <h4 class="text-uppercase">Free Shipping</h4>
                        <p>For all order over 99&#x20B9;</p>
                    </div>
                    <div class="col-lg-4 col-md-4 col-sm-4 boder-left wow fadeInLeft"><img
                                src="<?=FRONT_ASSETS_URL?>/images/timing.png" alt="" title="">
                        <h4 class="text-uppercase"> Delivery On Time</h4>
                        <p>Trustable &amp; Fast Delivery Services</p>
                    </div>
                    <div class="col-lg-4 col-md-4 col-sm-4 wow fadeInLeft"><img
                                src="<?=FRONT_ASSETS_URL?>/images/card.png" alt="" title="">
                        <h4 class="text-uppercase">Secure Payment</h4>
                        <p>100% secure payment </p>
                        <p></p>
                    </div>
                </div>
                <div class="clearfix"></div>
            </div>
        </div>
    </div>
    <!-- hero slider -->

    <!-- latest products -->
    <?php include 'includes/latest_products.php';?>
    <!-- latest products -->

    <!--featured products-->
    <?php include 'includes/featured_products.php';?>
    <!--featured products-->

    <!--Best Seller-->
    <?php include 'includes/best_seller.php';?>
    <!--Best Seller-->

    <!-- Start of promotion-->
    <?php include 'includes/promotion.php';?>
    <!--end of promotion -->

    <!--deal of the week-->
    <?php include 'includes/deal_of_the_week.php';?>
    <!--deal of the week-->

    <div class="clearfix"></div>

    <!--=======================footer file==============================-->
    <?php include 'includes/footer.php';?>
    <!--=======================footer script==============================-->
    <?php include 'includes/footer_scripts.php';?>
    <script type="text/javascript" src="assets/wow-slider/engine1/wowslider.js"></script>
    <script type="text/javascript" src="assets/wow-slider/engine1/script.js"></script>
    </body>
</html>