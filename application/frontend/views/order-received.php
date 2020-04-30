<!DOCTYPE html>
<html lang="en">

<head>
    <!--=======================header & start file==============================-->
    <?php include 'includes/start.php';?>
    <?php include 'includes/header.php';?>
            <!--=======================header & start file==============================-->

            <!-- Navigation -->
    <div class="container">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb breadcrumb2">
                <li class="breadcrumb-item">
                  <a href="<?=site_url('')?>">
                  <i class="fa fa-home" aria-hidden="true"></i> Home
                  </a>
                </li>
                <?php
if (!empty($failure)) {
    echo '<li class="breadcrumb-item">Transcation failed</li>';
} else {
    echo '<li class="breadcrumb-item">Order Received</li>';
}
?>
            </ol>
        </nav>
        <br>
        <?php
if (!empty($failure)) {
    echo '<div class="row">
    <div class="col-lg-8 col-md-12">
        <div class="empty-wishlist" style="width: 943px;">
            <div class="container">
                <div class="row">
                    <div class="displayFlex">' . $failure . '</div>
                </div>
            </div>
        </div>
    </div>
</div>';
}
?>
        <?php
if (!empty($received)) {
    ?>
        <div class="row">
            <div class="col-12">
                <h5 class="font-weight-bold">Order received</h5>
            </div>
            <div class="col-12 mt-5 mb-5">
                <h5 class="text-center font-weight-bold text-uppercase">
                  Thank you. Your order has been received.
                </h5>
            </div>
            <div class="col-6 text-right font-weight-bold">
              <a href="<?=site_url('fruits-vegetables')?>">  Return to shop
                <i class="fa fa-shopping-bag" aria-hidden="true"></i>
              </a>
            </div>
            <div class="col-6 text-left font-weight-bold">
              <a href="#" data-toggle="modal" data-backdrop="false" data-target="#LogInModal">
                Login</a> /
                <a href="#" data-toggle="modal" data-backdrop="false" data-target="#RegistrationModal">Register
                <i class="fa fa-id-card-o" aria-hidden="true"></i>
              </a>
            </div>
            <div class="clearfix"> </div>
            <div class="col-md-6 mt-4 mb-4">
                <div class="row m-0">
                    <div class="col order-details">
                        <div class="form-group font-weight-bold">Order number:</div>
                        <div class="form-group font-weight-bold"><?php if (!empty($txnid)) {?>Transcation Id:<?php }?></div>
                        <div class="form-group font-weight-bold">Date:</div>
                        <div class="form-group font-weight-bold">Total:</div>
                        <div class="form-group font-weight-bold">Payment method:</div>
                    </div>
                    <div class="col order-details">
                        <div class="form-group text-right"> <?=$received[0]['order_id']?></div>
                        <div class="form-group text-right"><?php if (!empty($txnid)) {echo $txnid;}?></div>
                        <div class="form-group text-right"> <?=date("M d, Y l", strtotime($received[0]['created_at']))?> </div>
                        <div class="form-group text-right"> &#x20B9;<?=$received[0]['grand_total']?></div>
                        <div class="form-group text-right"> <?=$received[0]['payment_mode']?> </div>
                    </div>
                </div>
            </div>
            <div class="col-md-6 mt-4 mb-4">
                <div class="row m-0 order-details">
                    <div class="col">
                        <div class="form-group font-weight-bold">
                            <h4>Product</h4>
                        </div>
                        <div class="form-group">
                        <?php
foreach ($received as $row) {
        $query = $this->db->where(array('status' => '1', 'id' => $row['product_id']))->get('tbl_product')->result_array();
        foreach ($query as $key => $value) {
            $original_price = $value['price'];
            $discount_percentage = $value['discount_percentage'];
            $discount_amount = $discount_percentage / 100;
            $final_price = $original_price - ($discount_amount * $original_price);
            $final_amount = $final_price * $row['quantity'];
            ?>
                        <div class="row product1">
                          <div class="col">
                            <p><?=$value['product_name']?>, <?=round($final_price, 2)?> × <?=$row['quantity']?></p>
                          </div>
                        </div>
                        <?php
}
    }
    ?>
                        </div>
                    </div>
                    <div class="col">
                        <div class="form-group text-right">
                            <h4>Total</h4>
                        </div>
                        <div class="form-group">
                        <?php
foreach ($received as $row1) {
        $query = $this->db->where(array('status' => '1', 'id' => $row1['product_id']))->get('tbl_product')->result_array();
        foreach ($query as $key1 => $value1) {
            $original_price = $value1['price'];
            $discount_percentage = $value1['discount_percentage'];
            $discount_amount = $discount_percentage / 100;
            $final_price = $original_price - ($discount_amount * $original_price);
            $final_amount = $final_price * $row1['quantity'];
            ?>
            <div class="row amount1">
              <div class="col">
                <div class="form-group text-right">&#x20B9;<?=round($final_amount, 2)?></div>
                </div>
            </div>

                <?php
}
    }
    ?>
    </div>
                    </div>
                    <div class="clearfix"></div>
                    <div class="col-12">
                        <hr>
                    </div>
                    <div class="clearfix"></div>
                    <div class="col-12">
                        <div class="form-group text-right">
                            <h4>&#x20B9;<?=$received[0]['sub_total']?></h4>
                        </div>
                    </div>
                    <div class="col order-details">
                        <div class="form-group font-weight-bold">
                            <h4>Shipping</h4>
                        </div>
                        <div class="form-group font-weight-bold">
                            <h4>Payment method:</h4>
                        </div>
                    </div>
                    <div class="col order-details">
                        <div class="form-group text-right"><?php $ship_charge = ($received[0]['ship_charge'] != 0) ? ('&#x20B9;' . $received[0]['ship_charge'] . ' via Flat rate') : 'FREE';
    echo $ship_charge;
    ?></div>
                        <div class="form-group text-right"><?=$received[0]['payment_mode']?></div>
                    </div>
                </div>
                <div class="row m-0">
                    <div class="col order-details">
                        <div class="form-group font-weight-bold">
                            <h4>Total:</h4>
                        </div>
                    </div>
                    <div class="col order-details">
                        <div class="form-group text-right">
                            <h4>&#x20B9;<?=$received[0]['grand_total']?></h4>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <?php
}
?>
    </div>
    <div class="clearfix"></div>
    <!--=======================footer file==============================-->
    <?php include 'includes/footer.php';?>
        <!--=======================footer script==============================-->
    <?php include 'includes/footer_scripts.php';?>
    <script>
    $(window).on('load', function () {

      target = $('.product1').height();
      $('.amount1').height(target);

    });
    </script>
    </body>
</html>