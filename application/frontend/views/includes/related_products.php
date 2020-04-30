<?php
$related_product = $this->db->where(array('id !=' => $product_id, 'sub_category_id' => $product_detail_data->sub_category_id))->order_by('id', 'desc')->get('tbl_product')->result_array();
if (!empty($related_product)) {
    ?>
        <div class="related">
            <div class="col-md-12">
                <h2 class="icon-css">Related Products</h2>
                <div class="owl-carousel latest-products owl-theme wow fadeIn">
                <?php
$count_mod = 1;
    foreach ($related_product as $rel_key => $rel_value) {
        $original_price = $rel_value['price'];
        $discount_percentage = $rel_value['discount_percentage'];
        $discount_amount = $discount_percentage / 100;
        $final_price = $original_price - ($discount_amount * $original_price);
        $category_name = $this->db->where(array('status' => '1', 'id' => $rel_value['category_id']))->order_by('id', 'desc')->get('tbl_product_category')->row();
        $sub_category_name = $this->db->where(array('status' => '1', 'id' => $rel_value['sub_category_id']))->order_by('id', 'desc')->get('tbl_product_subcategory')->row();
        ?>
                    <div class="item">
                        <div class="product">
                            <div class='badge'>
                                <a class="product-img index-product-img"
                                   href="<?=site_url(url_title(strtolower($category_name->category_name)) . '/' . url_title(strtolower($sub_category_name->sub_category_name)) . '/' . $rel_value['id'] . '-' . url_title(strtolower($rel_value['product_name'])))?>">
                                    <?php
if (!empty($rel_value['discount_percentage'])) {
            echo '<div class="text">Sale ' . round($discount_percentage, 2) . '%</div>';
        }
        ?>
                                    <img src="<?=PRODUCT_IMG_URL . $rel_value['image']?>" alt="organicstore">
                                </a>
                            </div>
                            <h5 class="product-type"><?=$category_name->category_name;?></h5>
                            <h3 class="product-name"><?=$rel_value['product_name']?></h3>
                            <h3 class="product-price">
                                <?php
if (!empty($discount_amount) && $discount_amount != 0) {
            echo '&#x20B9;' . round($final_price, 2) . " ";
            echo '<del>&#x20B9;' . round($original_price, 2) . '</del>';
        } else {
            echo '&#x20B9;' . round($original_price, 2);
        }
        ?>
                            </h3>
                            <div class="product-select">
                                <button data-toggle="tooltip" data-placement="top" title="Quick view"
                                        class="add-to-compare round-icon-btn" data-fancybox="gallery"
                                        data-src="#latest<?=$rel_value['id'];?>">
                                    <i class="fa fa-eye" aria-hidden="true"></i>
                                </button>
                                <?php
$user_id = $this->session->userdata('userSession')->id;
        $is_exist = $this->db->where(array('status' => '1', 'user_id' => $user_id, 'product_id' => $rel_value['id']))->get('tbl_wishlist')->row();
        $active = (!empty($is_exist)) ? ('active-wishlist') : '';
        ?>
                                <button data-toggle="tooltip" data-placement="top" title="Wishlist"
                                class="<?=$rel_value['id']?>-active add-to-wishlist round-icon-btn <?=$active?>"
                                        onClick="addToWishlist('<?=$rel_value['id']?>');">
                                    <i class="fa fa-heart-o" aria-hidden="true"></i>
                                </button>
                            </div>
                        </div>
                    </div>
                    <?php
if (($count_mod++ % 15) == 0) {
            break;
        }
    }
    ?>
            </div>
        </div>
    </div>
    <?php
}
?>

<?php
if (!empty($related_product)) {
    foreach ($related_product as $rel_key => $rel_value) {
        $original_price = $rel_value['price'];
        $discount_percentage = $rel_value['discount_percentage'];
        $discount_amount = $discount_percentage / 100;
        $final_price = $original_price - ($discount_amount * $original_price);
        $category_name = $this->db->where(array('status' => '1', 'id' => $rel_value['category_id']))->order_by('id', 'desc')->get('tbl_product_category')->row();
        $tag_id = explode(',', $rel_value['tag_id']);
        ?>
        <div id="latest<?=$rel_value['id'];?>" class="popup-fcy">
            <div class="row">
                <div class="col-md-6 text-center">
                    <img src="<?=PRODUCT_IMG_URL . $rel_value['image']?>" alt="organicstore" title="organicstore"
                         class="img-fluid">
                </div>
                <div class="col-md-6">
                    <div class="product_meta">
                        <p>Availability :
                            <?php
if (!empty($rel_value['availability']) && $rel_value['availability'] != 0) {
            echo '<span><img src="' . FRONT_ASSETS_URL . 'images/available.png" alt="" title=""> In Stock</span>';
        } else {
            echo '<span style="color: #f00 !important;"><img src="' . FRONT_ASSETS_URL . 'images/not-available.png" alt="" title=""> Out of Stock</span>';
        }
        ?>
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
        }
        ?>
                            </span>
                        </p>
                    </div>
                    <div class="product-dis">
                        <h3><?=$rel_value['product_name']?></h3>
                        <hr>
                        <?=$rel_value['short_description']?>
                        <div class="row">
                            <div class="col-2 pr-0">
                            <input type="number" class="input-text qty text" name="quantity" id="related-<?=$rel_value['id']?>" min="1" value="1" title="Qty" size="4">

                            </div>
                            <div class="col-10">
                                <div>
                                    <div class="row">
                                        <div class="col-6">
                                            <div class="add_to_cart">
                                                <a href="#" onClick="addToCart('<?=$rel_value['id']?>','<?=round($final_price, 2)?>','<?=$rel_value['availability']?>',$('#related-'+<?=$rel_value['id']?>).val())">
                                                ADD TO CART</a>
                                            </div>
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