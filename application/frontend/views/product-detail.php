<!DOCTYPE html>
<html lang="en">

<head>
    <!--=======================header & start file==============================-->
<?php include 'includes/start.php';?>
<!-- <link rel="stylesheet" href="<?=FRONT_ASSETS_URL;?>/css/main.css">
 --><link rel="stylesheet" href="<?=FRONT_ASSETS_URL;?>/vendor/detail-page/style.css">
<link rel="stylesheet" href="<?=FRONT_ASSETS_URL;?>/vendor/jquery/easyzoom.css">
<link rel="stylesheet" href="<?=FRONT_ASSETS_URL;?>/css/product-hover.css">
<?php include 'includes/header.php';?>
    <!--=======================header & start file==============================-->
    <div class="container">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb2 breadcrumb">
                <li class="breadcrumb-item">
                    <a href="<?=site_url('');?>">
                        <i class="fa fa-home" aria-hidden="true"></i> Home
                    </a>
                </li>
                <li class="breadcrumb-item">
                    <a href="<?=site_url($product_detail_data->category_id . '-' . url_title(strtolower($product_detail_data->category_name)));?>">
                        <?=$product_detail_data->category_name;?>
                    </a>
                </li>
                <li class="breadcrumb-item">
                    <a href="<?=site_url(url_title(strtolower($product_detail_data->category_name)) . '/' . $product_detail_data->sub_category_id . '-' . url_title(strtolower($product_detail_data->sub_category_name)));?>">
                        <?=$product_detail_data->sub_category_name;?>
                    </a>
                </li>
                <li class="breadcrumb-item">
                    <a href="<?=site_url(url_title(strtolower($product_detail_data->category_name)) . '/' . url_title(strtolower($product_detail_data->sub_category_name)) . '/' . $product_id . '-' . url_title(strtolower($product_detail_data->product_name)));?>">
                        <?=$product_detail_data->product_name;?>
                    </a>
                </li>
            </ol>
        </nav>
        <div class="clearfix"></div>
    </div>
    <div class="inner-header2">
        <h3><?=$product_detail_data->product_name;?></h3>
    </div>
    <div class="inner-page">
        <div class="container">
            <div class="row justify-content-md-center">
                <div class="col-lg-6">
                <?php
$user_id = $this->session->userdata('userSession')->id;
$is_exist = $this->db->where(array('status' => '1', 'user_id' => $user_id, 'product_id' => $product_id))->get('tbl_wishlist')->row();
$active = (!empty($is_exist)) ? ('active-wishlist') : '';
?>
                    <a class="<?=$product_id?>-active wish-list <?=$active?>" onClick="addToWishlist('<?=$product_id?>');">
                        <i class="fa fa-heart" aria-hidden="true"></i>
                    </a>
                    <div id="sync1" class="owl-carousel owl-theme">
                        <div class="item easyzoom easyzoom--overlay">
                            <a href="<?=PRODUCT_IMG_URL . $product_detail_data->image;?>">
                                <img class="new-ht-wd" src="<?=PRODUCT_IMG_URL . $product_detail_data->image?>" alt="" title="" />
                            </a>
                        </div>
                        <?php
foreach ($product_gallery as $gall_key => $gall_value) {
    ?>
                        <div class="item">
                            <div class="item easyzoom easyzoom--overlay">
                            <a href="<?=GALLERY_IMG_URL . $gall_value['image'];?>">
                                <img class="new-ht-wd" src="<?=GALLERY_IMG_URL . $gall_value['image']?>" alt="" title="" />
                            </a>
                            </div>
                        </div>
                    <?php
}
?>
                    </div>
                    <div id="sync2" class="owl-carousel owl-theme">
                        <div class="item">
                            <img height="100" src="<?=PRODUCT_IMG_URL . 'thumbnail/' . $product_detail_data->thumbnail?>" alt="" title="">
                        </div>
                        <?php
foreach ($product_gallery as $gall_key => $gall_value) {
    ?>
                        <div class="item">
                            <img height="100" src="<?=GALLERY_IMG_URL . 'thumbnail/' . $gall_value['thumbnail']?>" alt="" title="">
                        </div>
                        <?php
}
?>
                    </div>
                </div>
                <?php
$original_price = $product_detail_data->price;
$discount_percentage = $product_detail_data->discount_percentage;
$discount_amount = $discount_percentage / 100;
$final_price = $original_price - ($discount_amount * $original_price);
?>
                <div class="col-lg-6  product-text">
                    <div class="row">
                        <div class="col-md-6 col-sm-6 col-6">
                            <h3 style="width: 320px;"><?=$product_detail_data->product_name;?></h3>
                            <img src="<?=FRONT_ASSETS_URL?>/images/star.png" alt="" title="">
                            <img src="<?=FRONT_ASSETS_URL?>/images/star.png" alt="" title="">
                            <img src="<?=FRONT_ASSETS_URL?>/images/star.png" alt="" title="">
                            <img src="<?=FRONT_ASSETS_URL?>/images/star.png" alt="" title="">
                            <img src="<?=FRONT_ASSETS_URL?>/images/star.png" alt="" title="">
                        </div>
                        <div class="col-md-6 col-sm-6 text-right col-6">
                            <?php
if (!empty($discount_percentage)) {
    echo '<div class="price-css">
            <span>&#x20B9;' . round($original_price, 2) . '</span>
            <div class="clearfix"></div>
            &#x20B9;' . round($final_price, 2) .
        '</div>';
} else {
    echo '<div class="price-css">
            <div class="clearfix"></div>
            &#x20B9;' . $original_price .
        '</div>';
}
?>

                        </div>
                        <div class="col-md-14">
                            <div class="mt-3">
                                <?=$product_detail_data->short_description;?>
                                <div class="mt-3 text-2">
                                    <p>
                                    <span>Availability</span>: &nbsp;&nbsp;
                                    <?php
if ($product_detail_data->availability == 1) {
    echo '<img src="' . FRONT_ASSETS_URL . '/images/available.png" alt="" title="">&nbsp;In Stock';
} else {
    echo '<img src="' . FRONT_ASSETS_URL . '/images/not-available.png" alt="" title="">&nbsp;Out of Stock';
}
?>
                                    </p>
                                </div>
                                <div class="quality">
                                    <div class="row">
                                        <div class="col-md-6 col-sm-6">
                                            <div class="quantity-wd input-group">
                                                <h4>Quality :</h4>
                                                <span class="input-group-btn">
                                                    <button type="button" class="btn btn-default btn-number" disabled="disabled" data-type="minus" data-field="quant[1]">
                                                    <i class="fa fa-minus"></i>
                                                    </button>
                                                </span>
                                                <input type="text" name="quant[1]" class="input-number" id="product-detail-<?=$product_id?>" value="1" max="50" min="1">
                                                <span class="input-group-btn">
                                                    <button type="button" class="btn btn-default btn-number" data-type="plus" data-field="quant[1]">
                                                    <i class="fa fa-plus"></i>
                                                    </button>
                                                </span>
                                            </div>
                                        </div>
                                        <div class="col-md-6 col-sm-6">
                                            <a href="#" class="btn add-to-cart2" onClick="addToCart('<?=$product_id?>','<?=round($final_price, 2)?>','<?=$product_detail_data->availability?>','detail')">Add To Cart</a>
                                        </div>
                                    </div>
                                </div>
                                <div class="clearfix"></div>
                                <div class="share">
                                    <h3 class="pull-left">Share : &nbsp; &nbsp;</h3>
                                    <div class="pull-left">
                                        <ul class="social-network3">
                                            <li><a href="http://www.facebook.com/sharer.php?u=<?=urlencode(current_url());?>" class="facebook-icon" title=""><i class="fa fa-facebook"></i></a></li>
                                            <li><a href="http://www.twitter.com/share?url=<?=urlencode(current_url());?>" class="twitter-icon" title=""><i class="fa fa-twitter"></i></a></li>
                                            <li><a href="https://www.linkedin.com/shareArticle?mini=true&url=<?=urlencode(current_url());?>" class="linkedin-icon" title=""><i class="fa fa-linkedin"></i></a></li>
                                        </ul>
                                    </div>
                                </div>
                                <div class="clearfix"></div>
                                <div class="row categories">
                                    <div class="col-md-5">
                                        <h3 class="pull-left"> Categories :
                                            <span>&nbsp;<?=$product_detail_data->category_name?> </span>
                                        </h3>
                                    </div>
                                    <div class="col-md-6">
                                        <h3 class="pull-left"> Tags :
                                            <span>&nbsp;
                                            <?php
$tag_id = explode(',', $product_detail_data->tag_id);
$query = $this->db->where('status', '1')->where_in('id', $tag_id)->get('tbl_tag')->result_array();
$count = count($query);
foreach ($query as $tag_key => $tag_value) {
    $tag_name = ($tag_key < $count - 1) ? ($tag_value['tag_name'] . ',') : $tag_value['tag_name'];
    echo $tag_name;
}
?>
                                            </span>
                                        </h3>
                                    </div>
                                    <div class="clearfix"></div>
                                    <div class="list-3 row">
                                        <div class="col-lg-4">
                                            <img src="<?=FRONT_ASSETS_URL?>/images/shield.png" alt=""> 10 days return
                                        </div>
                                        <div class="col-lg-4">
                                            <img src="<?=FRONT_ASSETS_URL?>/images/shipping.png" alt=""> Quick Delivery
                                        </div>
                                        <div class="col-lg-4">
                                            <img src="<?=FRONT_ASSETS_URL?>/images/transfer.png" alt=""> 35% Cashback
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="clearfix"> </div>
                <div class="col-md-12">
                    <div id="tabs" class="description">
                        <div>
                            <nav>
                                <div class="nav nav-tabs nav-fill" id="nav-tab" role="tablist">
                                    <?php
if (!empty($product_detail_data->description)) {
    ?>
                                    <a class="active" id="nav-home-tab" data-toggle="tab" href="#nav-home" role="tab" aria-controls="nav-home" aria-selected="true">Description</a>
                                    &nbsp;|&nbsp;
                                    <?php
}
if (empty($product_detail_data->description)) {
    $active1 = (empty($product_detail_data->description)) ? ('show active') : 'show';
    $aria_selected = (empty($product_detail_data->description)) ? ('true') : 'false';
}
?>
                                    <a class="<?=$active1?>" id="nav-profile-tab" data-toggle="tab" href="#nav-profile" role="tab" aria-controls="nav-profile" aria-selected="<?=$aria_selected;?>">Additional information</a>
                                    &nbsp;|&nbsp;
                                    <a class="" id="nav-contact-tab" data-toggle="tab" href="#nav-contact" role="tab" aria-controls="nav-contact" aria-selected="false">Reviews
                                    </a>
                                </div>
                            </nav>
                            <div class="tab-content" id="nav-tabContent">
                            <?php
if (!empty($product_detail_data->description)) {
    ?>
                                <div class="tab-pane fade show des-scroll active text-1" id="nav-home" role="tabpanel" aria-labelledby="nav-home-tab">
                                    <?=$product_detail_data->description;?>
                                    <!-- snippet location product_description -->
                                </div>
                                                                    <?php
}
?>

                                <div class="tab-pane fade <?=$active1?>" id="nav-profile" role="tabpanel" aria-labelledby="nav-profile-tab">
                                    <table class="table">
                                        <tbody>
                                            <tr>
                                            <?php
if (!empty($product_detail_data->calories)) {
    ?>
                                                <th width="20%">
                                                    <div align="left">Calories</div>
                                                </th>
                                                <td><?=$product_detail_data->calories;?></td>
                                                <?php
}
?>
                                            </tr>
                                            <tr>
                                            <?php
if (!empty($product_detail_data->nutrition)) {
    ?>

                                                <th>
                                                    <div align="left">Nutrition</div>
                                                </th>
                                                <td><?=$product_detail_data->nutrition?></td>
                                                <?php
}
?>
                                            </tr>
                                            <tr>
                                            <?php
if (!empty($product_detail_data->storage_life)) {
    ?>

                                                <th>
                                                    <div align="left">Storage life</div>
                                                </th>
                                                <td><?=$product_detail_data->storage_life?></td>
                                                <?php
}
?>
                                            </tr>
                                            <tr>
                                            <?php
if (!empty($product_detail_data->per_pack)) {
    ?>

                                                <th>
                                                    <div align="left">Quantity</div>
                                                </th>
                                                <td><?=$product_detail_data->per_pack?></td>
                                                <?php
}
?>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                                <div class="tab-pane fade" id="nav-contact" role="tabpanel" aria-labelledby="nav-contact-tab">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="row m-0 text-center-m" style="overflow-y: scroll;height: 320px;">
                                                <div class="col-lg-2 col-md-3 col-sm-2 text-center mb-3"><img src="<?=FRONT_ASSETS_URL?>/images/review1.jpg" alt="" title="" class="radius image-boder img-fluid"></div>
                                                <div class="col-lg-10 col-md-9 col-sm-10">
                                                    <h2 class="font-15 mt-10">Daryl Michaels <span class="font-13 text-themecolor">Product: Mobile Phone</span></h2>
                                                    <span class="fa fa-star checked font-13"></span> <span class="fa fa-star checked font-13"></span> <span class="fa fa-star checked font-13"></span> <span class="fa fa-star font-13"></span> <span class="fa fa-star font-13"></span> &nbsp;<span class="red">1 Min ago </span>
                                                    <div class="mt-1">
                                                        <p>Cras sit amet nibh libero, in gravida nulla. Nulla vel metus scelerisque ante sollicitudin.</p>
                                                    </div>
                                                </div>
                                                <div class="clearfix"></div>
                                                <div class="col-12">
                                                    <hr>
                                                </div>
                                                <div class="clearfix"></div>
                                                <div class="col-lg-2 col-md-3 col-sm-2 text-center"><img src="<?=FRONT_ASSETS_URL?>/images/review2.jpg" alt="" title="" class="radius image-boder img-fluid"></div>
                                                <div class="col-lg-10 col-md-9 col-sm-10">
                                                    <h2 class="font-15 mt-10">Daryl Michaels <span class="font-13 text-themecolor">Product: Mobile Phone</span></h2>
                                                    <span class="fa fa-star checked font-13"></span> <span class="fa fa-star checked font-13"></span> <span class="fa fa-star checked font-13"></span> <span class="fa fa-star font-13"></span> <span class="fa fa-star font-13"></span> <span class="red">&nbsp;1 Min ago </span>
                                                    <div class="mt-1">
                                                        <p>Cras sit amet nibh libero, in gravida nulla. Nulla vel metus scelerisque ante sollicitudin.</p>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <h4>Write Your Review</h4>
                                            <p class="mb-3">Your email address will not be published.</p>
                                            <form class="review-form">
                                                <div class="form-group">
                                                    <input class="form-control" type="text" placeholder="Your Name">
                                                </div>
                                                <div class="form-group">
                                                    <input class="form-control" type="email" placeholder="Email Address">
                                                </div>
                                                <div class="form-group">
                                                    <textarea class="form-control" rows="5" placeholder="Your review"></textarea>
                                                </div>
                                                <div class="form-group">
                                                    <div class="input-rating"> <strong>Your Rating:</strong>
                                                        <div class="stars">
                                                            <input type="radio" id="star5" name="rating" value="5">
                                                            <label for="star5"></label>
                                                            <input type="radio" id="star4" name="rating" value="4">
                                                            <label for="star4"></label>
                                                            <input type="radio" id="star3" name="rating" value="3">
                                                            <label for="star3"></label>
                                                            <input type="radio" id="star2" name="rating" value="2">
                                                            <label for="star2"></label>
                                                            <input type="radio" id="star1" name="rating" value="1">
                                                            <label for="star1"></label>
                                                        </div>
                                                    </div>
                                                    <button class="btn add-to-cart3">Submit</button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                    <div class="clearfix"></div>
                                    <div class="clearfix"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="clearfix"></div>
                <?php include 'includes/related_products.php';?>
            </div>
        </div>
    </div>
    <!--=======================footer file==============================-->
    <?php include 'includes/footer.php';?>
    <?php include 'includes/footer_scripts.php';?>

    <!-- popur -->
    <!--easyzoom-->
    <script src="<?=FRONT_ASSETS_URL;?>vendor/jquery/easyzoom.js"></script>
    <script src="<?=FRONT_ASSETS_URL;?>vendor/jquery/easyzoom-script.js"></script>

    <!--owl.carousel-->
    <script src="<?=FRONT_ASSETS_URL;?>owlcarousel/owl.carousel.js"></script>
    <!--owl.carousel-->
    <!--related-products-->
    <script src="<?=FRONT_ASSETS_URL;?>vendor/detail-page/related-products.js"></script>
    <script src="<?=FRONT_ASSETS_URL;?>vendor/detail-page/index.js"></script>
    <!--related-products-->
    <script src="<?=FRONT_ASSETS_URL;?>vendor/jquery/quality.js"></script>
    <script type="text/javascript" src="<?=FRONT_ASSETS_URL;?>wow-slider/engine1/script.js"></script>

    <script>
        if ($('#sync1').hasClass("owl-theme")) {
            $("#sync1").addClass('new-ht-wd');
        }
    </script>
    </body>
</html>