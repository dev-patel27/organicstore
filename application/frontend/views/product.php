<!DOCTYPE html>
<html lang="en">
<head>
    <!--=======================header & start file==============================-->
    <?php include 'includes/start.php';?>
    <?php include 'includes/header.php';?>
    <!--=======================header & start file==============================-->

    <div class="container">
        <nav aria-label="breadcrumb" class="bread-boder">
            <div class="row">
                <div class="col-lg-8 col-md-6">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item">
                            <a href="<?=site_url('');?>">
                                <i class="fa fa-home" aria-hidden="true"></i>
                                Home
                            </a>
                        </li>
                        <?php
if ($no_result_found != '') {
    echo '<li class="breadcrumb-item">Search Result</li>';
}
if ($category_name != '') {
    echo '<li class="breadcrumb-item"><a href="' . site_url($category_id . '-' . url_title(strtolower($category_name->category_name))) . '">' . $category_name->category_name . '</a></li>';
}
if ($sub_category_name != '') {
    echo '<li class="breadcrumb-item"><a href="' . site_url($sub_category_name->category_id . '-' . url_title(strtolower($sub_category_name->category_name))) . '">' . $sub_category_name->category_name . '</a></li>';
    echo '<li class="breadcrumb-item"><a href="' . site_url(url_title(strtolower($sub_category_name->category_name)) . '/' . $sub_category_id . '-' . url_title(strtolower($sub_category_name->sub_category_name))) . '">' . $sub_category_name->sub_category_name . '</a></li>';
}
?>
                    </ol>
                </div>
                <div class="col-lg-4 col-md-6 remove-no-result">
                    <div class="row">
                        <div class="col-md-6">
                            <h5 class="float-right">Sort by</h5>
                        </div>
                        <div class="col-md-6">
                            <div class="my-custom-select2">
                                <select class="select-selected2 common-selector" id="sort_by">
                                    <option value="newestfirst">Newest First</option>
                                    <option value="popularity">Popularity</option>
                                    <option value="alphabetical">Alphabetical</option>
                                    <option value="lowtohigh">Price - Low to High</option>
                                    <option value="hightolow">Price - High to Low</option>
                                </select>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="clearfix"></div>
            </div>
            <div class="clearfix"></div>
        </nav>
<?php
if (!empty($no_result_found)) {
    echo $no_result_found;
} else {
    ?>
        <div class="row">
            <div class="col-lg-3 col-md-12">
                <div class="inner-left-menu">
                    <h3>Departments</h3>
                    <div class="list-css">
                        <ul>
                            <?php
$category = $this->front_model->get_product_category();
    foreach ($category as $key => $value) {
        echo '<li><a href="' . site_url($value['id'] . '-' . url_title(strtolower($value['category_name']))) . '">' . $value['category_name'] . '</a></li>';
    }?>
                        </ul>
                    </div>
                    <h3>Filter By Price</h3>
                    <div class="price-range-block">
                        <p id="price_show">0 - 500</p>
                        <div id="price_range"></div>
                        <div class="row">
                            <div class="col-9 ml-4 p-0">
                                <input type="hidden" class="common-selector" id="min_price" value="0"/>
                                <input type="hidden" class="common-selector" id="max_price" value="500"/>
                            </div>
                        </div>
                        <br>
                    </div>
                    <h3>Discount</h3>
                    <div class="list-css">
                        <ul>
                            <li>
                                <!-- Default unchecked -->
                                <div class="custom-control custom-checkbox">
                                    <input type="checkbox" class="common-selector discount custom-control-input"
                                           id="upto5"
                                           value="upto5">
                                    <label class="custom-control-label" for="upto5">Upto 5%</label>
                                </div>
                            </li>
                            <li>
                                <div class="custom-control custom-checkbox">
                                    <input type="checkbox" class="common-selector discount custom-control-input"
                                           id="bet5to10"
                                           value="bet5to10">
                                    <label class="custom-control-label" for="bet5to10">5% - 10%</label>
                                </div>
                            </li>
                            <li>
                                <div class="custom-control custom-checkbox">
                                    <input type="checkbox" class="common-selector discount custom-control-input"
                                           id="bet15to25"
                                           value="bet15to25">
                                    <label class="custom-control-label" for="bet15to25">15% - 25%</label>
                                </div>
                            </li>
                            <li>
                                <div class="custom-control custom-checkbox">
                                    <input type="checkbox" class="common-selector discount custom-control-input"
                                           id="more25"
                                           value="more25">
                                    <label class="custom-control-label" for="more25">More than 25%</label>
                                </div>
                            </li>
                        </ul>
                    </div>
                    <h3>Popular Picks</h3>
                    <div class="list-css">
                        <ul>
                            <li>
                                <!-- Default unchecked -->
                                <div class="custom-control custom-checkbox">
                                    <input type="checkbox" class="common-selector popular-picks custom-control-input"
                                           id="deal"
                                           value="deal">
                                    <label class="custom-control-label" for="deal">Deal of the week</label>
                                </div>
                            </li>
                            <li>
                                <div class="custom-control custom-checkbox">
                                    <input type="checkbox" class="common-selector popular-picks custom-control-input"
                                           id="new"
                                           value="new">
                                    <label class="custom-control-label" for="new">New Products</label>
                                </div>
                            </li>
                            <li>
                                <div class="custom-control custom-checkbox">
                                    <input type="checkbox" class="common-selector popular-picks custom-control-input"
                                           id="featured"
                                           value="featured">
                                    <label class="custom-control-label" for="featured">Featured
                                        Products</label>
                                </div>
                            </li>
                            <li>
                                <div class="custom-control custom-checkbox">
                                    <input type="checkbox" class="common-selector popular-picks custom-control-input"
                                           id="best"
                                           value="best">
                                    <label class="custom-control-label" for="best">Bestsellers</label>
                                </div>
                            </li>
                        </ul>
                    </div>
                    <h3>Availability</h3>
                    <div class="list-css">
                        <ul>
                            <li>
                                <!-- Default unchecked -->
                                <div class="custom-control custom-checkbox">
                                    <input type="checkbox" class="common-selector availability custom-control-input"
                                           id="1" value="1">
                                    <label class="custom-control-label" for="1">Exclude Out Of Stock</label>
                                </div>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
            <?php
}
$product_list = $this->front_model->get_latest_product();
if (!empty($product_data)) {
    ?>
                <div class="col-lg-9 col-md-12">
                    <div class="row">
                        <div class="col-12">
                            <div class="right-heading">
                                <div class="row">
                                    <div class="col-md-4 col-4">
                                        <!--<h3>Shop Grid</h3>-->
                                    </div>
                                    <div class="col-md-8 col-8">
                                        <div class="product-filter">
                                            <div class="view-method">
                                                <a href="#" id="grid">
                                                    <i class="fa fa-th-large"></i>
                                                </a>
                                                <a href="#" id="list">
                                                    <i class="fa fa-list"></i>
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="clearfix"></div>
                            <div id="products" class="row view-group">
                                <?php
$count_mod = 1;
    foreach ($product_data as $pro_key => $pro_value) {
        /* wishlist condition*/
        $user_id = $this->session->userdata('userSession')->id;
        $is_exist = $this->db->where(array('status' => '1', 'user_id' => $user_id, 'product_id' => $pro_value['id']))->get('tbl_wishlist')->row();
        $active = (!empty($is_exist)) ? ('active-wishlist') : '';
        /* wishlist condition */
        $original_price = $pro_value['price'];
        $discount_percentage = $pro_value['discount_percentage'];
        $discount_amount = $discount_percentage / 100;
        $final_price = $original_price - ($discount_amount * $original_price);
        $category_name = $this->db->where(array('status' => '1', 'id' => $pro_value['category_id']))->order_by('id', 'desc')->get('tbl_product_category')->row();
        $sub_category_name = $this->db->where(array('status' => '1', 'id' => $pro_value['sub_category_id']))->order_by('id', 'desc')->get('tbl_product_subcategory')->row();?>
                                    <div class="item col-lg-4 col-md-4 mb-4 mb-4">
                                        <?php
if (!empty($pro_value['discount_percentage'])) {
            echo '<div class="sale-flag-side">
                    <div class="sale-text">Sale</div>
                </div>';
        }?>
        <div class="thumbnail card product">
            <div class="img-event">
                <a class="group list-group-image"
                    href="<?=site_url(url_title(strtolower($category_name->category_name)) . '/' . url_title(strtolower($sub_category_name->sub_category_name)) . '/' . $pro_value['id'] . '-' . url_title(strtolower($pro_value['product_name'])))?>">
                    <img class="img-fluid"
                            src="<?=PRODUCT_IMG_URL . $pro_value['image']?>"
                            alt="organicstore">
                </a>
            </div>
            <div class="caption card-body">
                <h5 class="product-type"><?=$category_name->category_name;?></h5>
                <h3 class="product-name"><?=$pro_value['product_name']?></h3>
                <!--starting of list view-->
                <div class="product-table">
                    <?=$pro_value['short_description']?>
                    <div class="row m-0">
                        <div class="col p-0">
                            <h3 class="product-price pull-left">
                                                                <?php
if (!empty($discount_amount) && $discount_amount != 0) {
            echo '&#x20B9;' . round($final_price, 2) . " ";
            echo '<del>&#x20B9;' . round($original_price, 2) . '</del>';
        } else {
            echo '&#x20B9;' . round($original_price, 2);
        }?>
            </h3>
            <div class="product-price pull-left">
                <form class="form-inline">
                    <div class="quantity buttons_added">
                        <input type="button" value="-" class="js-qty-down new-minus">
                        <input type="number" step="1" min="1" max="" name="quantity" value="1" title="Qty" class="input-text js-qty-input text" size="4" pattern="" id="product-list-<?=$pro_value['id']?>">
                        <input type="button" value="+" class="js-qty-up new-plus">
                        <button onClick="addToCart('<?=$pro_value['id']?>','<?=round($final_price, 2)?>','<?=$pro_value['availability']?>','list')" class="add2">
                            <i class="fa fa-shopping-bag" aria-hidden="true"></i>
                        </button>
                    </div>
                </form>
            </div>
            </div>
        </div>
        <div class="clearfix"></div>
        <div></div>
    </div>
    <!--end of list view-->
    <div class="row m-0 list-n">
        <div class="col-12 p-0">
            <h3 class="product-price">
                <?php
if (!empty($discount_amount) && $discount_amount != 0) {
            echo '&#x20B9;' . round($final_price, 2) . " ";
            echo '<del>&#x20B9;' . round($original_price, 2) . '</del>';
        } else {
            echo '&#x20B9;' . round($original_price, 2);
        }?>
            </h3>
                </div>
                <div class="col-12 p-0">
                    <div class="product-price">
                        <form class="form-inline">
                            <div class="quantity buttons_added">
                                <input type="button" value="-" class="js-qty-down new-minus">
                                <input type="number" step="1" min="1" max="" name="quantity" value="1" title="Qty" class="input-text js-qty-input text" size="4" pattern="" id="product-grid-<?=$pro_value['id']?>">
                                <input type="button" value="+" class="js-qty-up new-plus">
                                <button onClick="addToCart('<?=$pro_value['id']?>','<?=round($final_price, 2)?>','<?=$pro_value['availability']?>','grid')" class="add2">
                                        <i class="fa fa-shopping-bag" aria-hidden="true"></i>
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <div class="product-select">
                <button data-toggle="tooltip" data-placement="top"
                        title="Quick view"
                        class="add-to-compare round-icon-btn"
                        data-fancybox="gallery"
                        data-src="#product<?=$pro_value['id'];?>"
                        data-original-title="Quick view">
                    <i class="fa fa-eye" aria-hidden="true"></i>
                </button>
                <button data-toggle="tooltip" data-placement="top" title="Wishlist"
                class="<?=$pro_value['id']?>-active add-to-wishlist round-icon-btn <?=$active?>" onClick="addToWishlist('<?=$pro_value['id']?>');">
                    <i class="fa fa-heart-o" aria-hidden="true"></i>
                </button>
            </div>
            </div>
        </div>
    </div>
                                    <?php
$last_id = $pro_value['id'];
        if (($count_mod++ % 3) == 0) {
            break;
        }
    }?>
                                <div class="clearfix"></div>
                            </div>
                        </div>
                    </div>

                    <!-- Load More -->
                    <div class="text-center ajax-load col">
                        <nav aria-label="Page navigation example">
                            <div>
                                <div class="row">
                                    <div class="col-12">
                                        <img id="loader-gif" height="70px" width="70px"
                                             src="<?=FRONT_ASSETS_URL . '/images/loader.gif'?>" alt="">
                                        <div class="add_to_cart">
                                            <a href="#" class="show-more-gif">
                                                Show More
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </nav>
                    </div>
                    <div class="text-center no-results-found"></div>
                </div>
                <?php
}?>
        </div>
        <div class="clearfix"></div>
    </div>
    <div class="pd-overlay" style="display: none;"></div>

    <!-- quick view -> fancy box popup-->
    <?php
if (!empty($product_data)) {
    foreach ($product_data as $pro_key => $pro_value) {
        $original_price = $pro_value['price'];
        $discount_percentage = $pro_value['discount_percentage'];
        $discount_amount = $discount_percentage / 100;
        $final_price = $original_price - ($discount_amount * $original_price);
        $category_name = $this->db->where(array('status' => '1', 'id' => $pro_value['category_id']))->order_by('id', 'desc')->get('tbl_product_category')->row();
        $tag_id = explode(',', $pro_value['tag_id']);?>
            <div id="product<?=$pro_value['id'];?>" class="popup-fcy">
                <div class="row">
                    <div class="col-md-6 text-center">
                        <img src="<?=PRODUCT_IMG_URL . $pro_value['image']?>" alt="organicstore" title="organicstore" class="img-fluid">
                    </div>
                    <div class="col-md-6">
                        <div class="product_meta">
                            <p>Availability :
                                <?php
if (!empty($pro_value['availability']) && $pro_value['availability'] != 0) {
            echo '<span><img src="' . FRONT_ASSETS_URL . 'images/available.png" alt="" title=""> In Stock</span>';
        } else {
            echo '<span style="color: #f00 !important;"><img src="' . FRONT_ASSETS_URL . 'images/not-available.png" alt="" title=""> Out of Stock</span>';
        }?>
                            </p>
                            <p>Categories :
                                <span>
                                <?=$category_name->category_name;?>
                            </span>
                            </p>
                            <p>Tags :
                                <span>
                                <?php
foreach ($tag_id as $tag_key => $tag_value) {
            $query_tag_name = $this->db->where('id', $tag_value)->get('tbl_tag')->row();
            echo $query_tag_name->tag_name . ' ';
        }?>
                            </span>
                            </p>
                        </div>
                        <div class="product-dis">
                            <h3><?=$pro_value['product_name']?></h3>
                            <hr>
                            <?=$pro_value['short_description']?>
                            <div class="row">
                                <div class="col-2 pr-0">
                                <input type="number" class="input-text qty text" name="quantity" id="product-pop-<?=$pro_value['id']?>" min="1" max="50" value="1" title="Qty" size="4">
                                </div>
                                <div class="col-10">
                                    <div>
                                        <div class="row">
                                            <div class="col-6">
                                                <div class="add_to_cart">
                                                    <a href="#" onClick="addToCart('<?=$pro_value['id']?>','<?=round($final_price, 2)?>','<?=$pro_value['availability']?>',$('#product-pop-'+<?=$pro_value['id']?>).val())">
                                                ADD TO CART</a>                                     </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-12 mt-4 p-0">
                                    <hr class="m-0 p-0">
                                </div>
                                <div class="col-md-12 mb-4 p-0">
                                    <hr class="m-0 p-0">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <?php
}
}
?>
    <input type="hidden" id="keyword" value="<?=$keyword?>">
    <input type="hidden" id="category_id" value="<?=$category_id?>">
    <input type="hidden" id="sub_category_id" value="<?=$sub_category_id?>">
    <div style="margin-top: 50px;"></div>

    <!--=======================footer file==============================-->
    <?php include 'includes/footer.php';?>
    <!--=======================footer script==============================-->
    <?php include 'includes/footer_scripts.php';?>

    <script type="text/javascript">
        $(document).ready(function () {
            /* load-more on scroll*/
            var action = 'inactive';
            var page = 1;

            function loadmore(page) {
                let keyword = $('#keyword').val();
                let min_price = $('#min_price').val();
                let max_price = $('#max_price').val();
                let category_id = $('#category_id').val();
                let sub_category_id = $('#sub_category_id').val();
                if ($("#min_price").val() === '[object Object]') {
                    min_price = 0;
                }
                if ($("#max_price").val() === '[object Object]') {
                    max_price = 500;
                }
                var discount = get_filter("discount");
                var popular_picks = get_filter("popular-picks");
                let availability;
                $('.availability:checked').each(function () {
                    availability = $(this).val();
                });
                let sort_by = $('#sort_by').val();
                if ($(".item").hasClass("list-group-item")) {
                    var list_view = "list-group-item";
                }
                if ($(".item").hasClass("list-group-item")) {
                    var list_view = "list-group-item";
                }
                $.ajax({
                    type: 'POST',
                    url: '<?php echo site_url('product/load-more-product'); ?>',
                    data: {
                        keyword: keyword,
                        category_id: category_id,
                        sub_category_id: sub_category_id,
                        min_price: min_price,
                        max_price: max_price,
                        discount: discount,
                        popular_picks: popular_picks,
                        availability: availability,
                        list_view: list_view,
                        sort_by: sort_by,
                        page: page
                    },
                    beforeSend: function () {
                        $('.ajax-load').show();
                    },
                    complete: function () {
                        $('.ajax-load').hide();
                    },
                    success: function (response) {
                        let response_data = JSON.parse(response);
                        if (response_data.status == 200) {
                            $('#products').append(response_data.data);
                            action = 'inactive';
                        } else if (response_data.status == 400) {
                            $('.no-results-found').show();
                            $('.no-results-found').html(response_data.data);
                            action = 'active';
                        }
                    }
                });
            }

            $(window).scroll(function () {
                if ($(window).scrollTop() + $(window).height() > ($("#products").height() + 200) && action == 'inactive') {
                    action = 'active';
                    setTimeout(function () {
                        loadmore(page);
                    }, 1000);
                    page++;
                }
            });

            /* filtering products */
            $('.common-selector').change(function () {
                priceFilter();
                page = 1;
            });

            function get_filter(class_name) {
                var filter = [];
                $('.' + class_name + ':checked').each(function () {
                    filter.push($(this).val());
                });
                return filter;
            }

            function priceFilter() {
                action = "inactive";
                $('.no-results-found').hide();
                let keyword = $('#keyword').val();
                let category_id = $('#category_id').val();
                let sub_category_id = $('#sub_category_id').val();
                let min_price = $('#min_price').val();
                let max_price = $('#max_price').val();
                if ($("#min_price").val() === '[object Object]') {
                    min_price = 0;
                }
                if ($("#max_price").val() === '[object Object]') {
                    max_price = 500;
                }
                var discount = get_filter("discount");
                var popular_picks = get_filter("popular-picks");
                let availability;
                $('.availability:checked').each(function () {
                    availability = $(this).val();
                });
                let sort_by = $('#sort_by').val();
                if ($(".item").hasClass("list-group-item")) {
                    var list_view = "list-group-item";
                }
                $.ajax({
                    type: 'POST',
                    url: '<?php echo site_url('product/filter-product'); ?>',
                    data: {
                        keyword: keyword,
                        category_id: category_id,
                        sub_category_id: sub_category_id,
                        min_price: min_price,
                        max_price: max_price,
                        discount: discount,
                        popular_picks: popular_picks,
                        availability: availability,
                        list_view: list_view,
                        sort_by: sort_by
                    },
                    beforeSend: function () {
                        $('.pd-overlay').show();
                    },
                    complete: function () {
                        $('.pd-overlay').hide();
                        $('.ajax-load').hide();
                    },
                    success: function (response) {
                        let response_data = JSON.parse(response);
                        if (response_data.status == 200) {
                            $('#products').html(response_data.data);
                            action = 'inactive';
                        } else if (response_data.status == 400) {
                            action = 'active';
                            $('#products').html(response_data.data);
                        }
                    }
                });
            }

            $('#price_range').slider({
                range: true,
                orientation: "horizontal",
                min: 0,
                max: 500,
                values: [0, 500],
                step: 10,
                stop: function (event, ui) {
                    $('#price_show').html(ui.values[0] + ' - ' + ui.values[1]);
                    $('#min_price').val(ui.values[0]);
                    $('#max_price').val(ui.values[1]);
                    priceFilter();
                    page = 1;
                }
            });
        });

        /** for no result found*/
        if($('#no-products-found').hasClass('no-products-found')){
            $('.remove-no-result').hide();
        }


        function wcqib_refresh_quantity_increments() {
            jQuery("div.quantity:not(.buttons_added), td.quantity:not(.buttons_added)").each(function(a, b) {
                var c = jQuery(b);
                c.addClass("buttons_added"), c.children().first().before('<input type="button" value="-" class="new-minus" />'), c.children().last().after('<input type="button" value="+" class="new-plus" />')
            })
        }
        String.prototype.getDecimals || (String.prototype.getDecimals = function() {
            var a = this,
                b = ("" + a).match(/(?:\.(\d+))?(?:[eE]([+-]?\d+))?$/);
            return b ? Math.max(0, (b[1] ? b[1].length : 0) - (b[2] ? +b[2] : 0)) : 0
        }), jQuery(document).ready(function() {
            wcqib_refresh_quantity_increments()
        }), jQuery(document).on("updated_wc_div", function() {
            wcqib_refresh_quantity_increments()
        }), jQuery(document).on("click", ".new-plus, .new-minus", function() {
            var a = jQuery(this).closest(".quantity").find(".js-qty-input"),
                b = parseFloat(a.val()),
                c = parseFloat(a.attr("max")),
                d = parseFloat(a.attr("min")),
                e = a.attr("step");
            b && "" !== b && "NaN" !== b || (b = 0), "" !== c && "NaN" !== c || (c = ""), "" !== d && "NaN" !== d || (d = 0), "any" !== e && "" !== e && void 0 !== e && "NaN" !== parseFloat(e) || (e = 1), jQuery(this).is(".new-plus") ? c && b >= c ? a.val(c) : a.val((b + parseFloat(e)).toFixed(e.getDecimals())) : d && b <= d ? a.val(d) : b > 0 && a.val((b - parseFloat(e)).toFixed(e.getDecimals())), a.trigger("change")
        });
    </script>
    <script src="<?=FRONT_ASSETS_URL?>vendor/price_range/jquery-ui.min.js"></script>
    <script src="<?=FRONT_ASSETS_URL?>vendor/jquery/mega-menu.js"></script>
    <script src="<?=FRONT_ASSETS_URL?>vendor/price_range/price_range_script.js"></script>
    <script src="<?=FRONT_ASSETS_URL?>vendor/jquery/grid-list.js"></script>
    </body>
</html>
