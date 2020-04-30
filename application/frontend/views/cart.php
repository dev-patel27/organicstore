<!DOCTYPE html>
<html lang="en">

<head>
    <!--=======================header & start file==============================-->
    <?php include 'includes/start.php';?>
        <link rel="stylesheet" href="<?=FRONT_ASSETS_URL?>/vendor/functioning-cart/functioning-cart.css">

        <?php include 'includes/header.php';?>
            <!--=======================header & start file==============================-->
            <script id="shopping-cart--list-item-template" type="text/template">
            </script>
            <div class="container">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb breadcrumb2">
                        <li class="breadcrumb-item">
                            <a href="index.php">
                                <i class="fa fa-home" aria-hidden="true"></i> Home
                            </a>
                        </li>
                        <li class="breadcrumb-item">Cart</li>
                    </ol>
                </nav>
                <div class="row">
    <div class="col-lg-8 col-md-12">
      <div class="table-responsive wishlist-table">
      <?php
if (!empty($output)) {
    ?>
        <table class="table rm-class wishlist-table">
          <thead class="title-h">
            <tr>
              <th colspan="2" style="padding-left: 45px;" class="product-price">Product Detail</th>
              <th width="105px" class="product-subtotal text-center unit-price"><p>Price</p></th>
              <th class="text-center product-add-date"><p>Quantity</p></th>
              <th class="text-center add-to-3-th"> <p>Total</p> </th>
            </tr>
          </thead>
          <tbody>
              <?=$output?>
            <tr>
              <td colspan="7"><ul class="share-link">
                  <li><span>Share</span></li>
                  <li><a href="http://www.facebook.com/sharer.php?u=<?=urlencode(current_url());?>" class="icoFacebook" title=""><i class="fa fa-facebook"></i></a></li>
                  <li><a href="http://www.twitter.com/share?url=<?=urlencode(current_url());?>" class="icoTwitter" title=""><i class="fa fa-twitter"></i></a></li>
                  <li><a href="https://www.linkedin.com/shareArticle?mini=true&url=<?=urlencode(current_url());?>" class="icoLinkedin" title=""><i class="fa fa-linkedin"></i></a></li>
                </ul></td>
            </tr>
          </tbody>
        </table>
        <?php
}
?>
      </div>
    </div>
<?php
if (empty($output)) {
    echo '<div class="empty-wishlist" style="width: 943px;">' . $empty_cart . '</div>';
}
?>
  <div class="col-lg-4 remove-cart col-md-12">
    <div class="_grid cart-totals">
        <?php
if (!empty($this->session->userdata('userSession'))) {
    $cart = $this->front_model->get_cart_data($this->userSession->id);
    $sub_total = 0;
    $arr = [];
    foreach ($cart as $row) {
        $product_price = $row['product_price'];
        $quantity = $row['quantity'];
        $total_price = $product_price * $quantity;
        $sub_total += $total_price;
        $query = $this->db->where(array('id' => $row['product_id'], 'status' => '1'))->get('tbl_product')->result_array();
        foreach ($query as $key => $value) {
            $arr[] = $value['shipping_charge'];
        }
    }
    if (!empty($arr)) {
        $final_ship_charge = max($arr);
    }

    $total = $sub_total + $final_ship_charge;
    if ($sub_total > 100) {
        $final_ship_charge1 = 'Free';
        $total1 = $sub_total;
    } else {
        $final_ship_charge1 = '₹' . $final_ship_charge;
        $total1 = $total;
    }
}
?>
        <input type="hidden" id="old-ship-charge" value="<?=$final_ship_charge?>">
        <div>
            <div class="cart_totals">
                <div class="table-responsive">
                    <table cellspacing="0" class="table table-borderless">
                        <tbody>
                            <tr class="cart-subtotal _column subtotal" id="subtotalCtr">
                                <th class="cart-totals-key">Subtotal</th>
                                <th class="text-right cart-totals-value">
                                    ₹<span class="sub-total"><?=round($sub_total)?></span>
                                </th>
                            </tr>
                            <tr class="cart-subtotal _column shipping" id="shippingCtr">
                                <th class="cart-totals-key">Shipping</th>
                                <th class="text-right cart-totals-value">
                                    <span class="ship-charge"><?=$final_ship_charge1;?></span>
                                </th>
                            </tr>
                            <tr class="_column total" id="totalCtr">
                                <th class="cart-totals-key">Total</th>
                                <th class="text-right cart-totals-value">
                                ₹<span class="final-total"><?=round($total1)?></span>
                                </th>
                            </tr>
                        </tbody>
                    </table>
                    <a href="<?=site_url('checkout')?>" class="btn cart w-100">
                        Proceed to checkout</a>
                </div>
            </div>
        </div>
    </div>
</div>
</div>

</div>
<div class="clearfix"></div>
<div class="container">
    <div class="row">
        <div class="col-lg-8 col-md-12">
            <div class="empty-wishlist" style="width: 943px;"></div>
        </div>
    </div>
</div>
    <!--=======================footer file==============================-->
    <?php include 'includes/footer.php';?>
    <!--=======================footer script==============================-->
    <?php include 'includes/footer_scripts.php';?>
    <script src="<?=FRONT_ASSETS_URL?>/vendor/functioning-cart/functioning-cart.js"></script>
    <script src="<?=FRONT_ASSETS_URL?>/vendor/functioning-cart/zepto.min.js"></script>
    <script src="<?=FRONT_ASSETS_URL?>/vendor/jquery/number-plsu-min.js" type="text/javascript"></script>
    <script>
        if($('.my-class').hasClass('login-up')){
            toastr.error("Please login first");
            $("#LogInModal").modal("show");
        }
        if($('.my-cl').hasClass('rem-cls')){
           $('.remove-cart').hide();
        }

        function wcqib_refresh_quantity_increments() {
            jQuery("div.quantity:not(.buttons_added), td.quantity:not(.buttons_added)").each(function(a, b) {
                var c = jQuery(b);
                c.addClass("buttons_added"), c.children().first().before('<input type="button" value="-" class="minus" />'), c.children().last().after('<input type="button" value="+" class="plus" />')
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
        }), jQuery(document).on("click", ".plus, .minus", function() {
            var a = jQuery(this).closest(".quantity").find(".qty"),
                b = parseFloat(a.val()),
                c = parseFloat(a.attr("max")),
                d = parseFloat(a.attr("min")),
                e = a.attr("step");
            b && "" !== b && "NaN" !== b || (b = 0), "" !== c && "NaN" !== c || (c = ""), "" !== d && "NaN" !== d || (d = 0), "any" !== e && "" !== e && void 0 !== e && "NaN" !== parseFloat(e) || (e = 1), jQuery(this).is(".plus") ? c && b >= c ? a.val(c) : a.val((b + parseFloat(e)).toFixed(e.getDecimals())) : d && b <= d ? a.val(d) : b > 0 && a.val((b - parseFloat(e)).toFixed(e.getDecimals())), a.trigger("change")
        });
  </script>
    </body>
</html>