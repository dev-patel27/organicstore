<!DOCTYPE html>
<html lang="en">

<head>
    <!--=======================header & start file==============================-->
    <?php include 'includes/start.php';?>
    <?php include 'includes/header.php';?>
    <!--=======================header & start file==============================-->

    <div class="clearfix"></div>
    </div>
    <div class="clearfix"></div>
    </nav>

    <!-- Navigation -->
    <div class="container">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb breadcrumb2">
                <li class="breadcrumb-item"><a href="index.php"><i class="fa fa-home" aria-hidden="true"></i> Home</a>
                </li>
                <li class="breadcrumb-item">Checkout</li>
            </ol>
        </nav>
        <?php
$user_id = $this->session->userdata('userSession')->id;
$query = $this->db->where(array('status' => '1', 'user_id' => $user_id, 'selected' => '1'))->get('tbl_billing_address')->row();
?>
        <form method="post" id="billing-form">
        <div class="row mb-5">
            <div class="col-12 col-xl-7">
                <h5 class="font-weight-bold">Billing details</h5>
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="email">First name</label>
                            <input type="text" name="bill_first_name" id="bill_first_name" class="form-control" value="<?=$query->first_name?>">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="email">Last name</label>
                            <input type="text" name="bill_last_name" id="bill_last_name" class="form-control" value="<?=$query->last_name?>">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="email">Email address</label>
                            <input type="text" name="bill_email" id="bill_email" class="form-control" value="<?=$query->email?>">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="mobile">Mobile Number</label>
                            <input type="text" name="bill_number" id="bill_number" class="form-control" value="<?=$query->mobile_no?>">
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="form-group">
                            <label for="address">Address </label>
                            <textarea name="bill_address" id="bill_address" class="form-control"><?=$query->address?></textarea>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <label for="Country">Country</label>
                        <select class="form-control" value="<?=$query->country?>" name="bill_country" id="bill_country" onchange="getCountry()">
                        <option value="">Select Country</option>
                            <?php
$country = $this->db->where(array('status' => '1', 'id' => $query->country))->get('tbl_countries')->row();
$selected = ($country->id == $query->country) ? 'selected' : '';
echo '<option value="' . $country->id . '" ' . $selected . '>' . $country->country_name . '</option>';

$country = $this->front_model->getCountryDb();
foreach ($country as $row) {
    echo "<option value='" . $row->id . "'>" . $row->country_name . "</option>";
}
?>
                        </select>
                    </div>
                    <div class="col-md-6">
                        <label for="State">State</label>
                        <select class="form-control" name="bill_state" id="bill_state" onchange="getState()">
                            <option value="">Select State</option>
                            <?php
$state = $this->db->where(array('status' => '1', 'id' => $query->state))->get('tbl_states')->row();
$selected = ($state->id == $query->state) ? 'selected' : '';
echo '<option value="' . $state->id . '" ' . $selected . '>' . $state->state_name . '</option>';
?>
                        </select>
                    </div>
                    <div class="col-md-6">
                        <label for="City">City</label>
                        <select class="form-control" name="bill_city" id="bill_city">
                            <option value="">Select City</option>
                            <?php
$city = $this->db->where(array('status' => '1', 'id' => $query->city))->get('tbl_cities')->row();
$selected = ($city->id == $query->city) ? 'selected' : '';
echo '<option value="' . $city->id . '" ' . $selected . '>' . $city->city_name . '</option>';
?>
                        </select>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="email">Postcode / ZIP</label>
                            <input type="text" name="bill_post_code" id="bill_post_code" class="form-control" value="<?=$query->post_code?>">
                        </div>
                    </div>
        </form>
                    <div class="col-md-12">
                        <div class="clearfix"></div>
                        <hr>
                        <div class="clearfix"></div>
                    </div>
                    <div class="col-md-12">
                            <textarea class="input-text form-control input-lg"                      name="additional_note" id="additional_note" placeholder="Notes about your order, eg. special instructions for delivery." rows="3" cols="4"></textarea>
                    </div>
                </div>
            </div>
            <?php
if (!empty($this->session->userdata('userSession'))) {
    $cart = $this->front_model->get_cart_data($this->userSession->id);
    $sub_total = 0;
    $arr = [];
    $quantity = '';
    $product_price = '';
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
        $total1 = $sub_total;
    } else {
        $total1 = $total;
    }
}
?>
            <div class="col-12 col-xl-5">
                <div class="cart_totals">
                    <div class="table-responsive">
                        <table cellspacing="0" class="table table-borderless mb-0">
                            <tbody>
                            <tr>
                                <th>Product</th>
                                <th class="text-right">Quantity</th>
                                <th class="text-right">Total</th>
                            </tr>
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
            echo '<tr class="product-boder">
                <td class="flat-rate">
                    <strong>' . $value['product_name'] . '</strong>
                </td>
                <td class="text-center">' . $row['quantity'] . '</td>
            <td class="text-right amount">₹' . $value['price'] . '</td>
            </tr>';
            $arr[] = $value['shipping_charge'];
        }
    }
}
?>
                            </tr>
                            <tr class="product-boder">
                                <td><strong>Subtotal</strong></td>
                                <td class="text-center">
                                    <i class="fa fa-arrow-right" aria-hidden="true"></i>
                                </td>
                                <td align="right">₹<span id="sub-total"><?=round($sub_total)?></span></td>
                            </tr>
                            <tr>
                                <td><strong>Shipping</strong></td>
                                <td class="text-center">
                                    <i class="fa fa-arrow-right" aria-hidden="true"></i>
                                </td>
                                <td align="right"><?php
if ($sub_total > 100) {
    echo 'FREE';
} else {
    echo '₹' . '<span id="ship-charge">' . $final_ship_charge . '</span>';
}
?>
                                </td>
                            </tr>
                            <tr>
                                <td><strong>Total:</strong></td>
                                <td class="text-center">
                                    <i class="fa fa-arrow-right" aria-hidden="true"></i>
                                </td>
                                <td align="right">₹<span id="grand-total"><?=round($total1)?></span></td>
                            </tr>
                            </tbody>
                        </table>
                        <div class="ul-css m-0">
                            <ul class="m-0 ml-3">
                                <li>
                                    <input type="radio" name="payment_mode" id="cod" class="payment_mode input-radio" value="cheque" data-order_button_text="">
                                    <label for="payment_method_cheque">Cash on delivery</label>
                                </li>
                                <li>
                                    <p>
                                        Your personal data will be used to process your order, support your experience throughout this website, and for other purposes described in our
                                        <a href="<?=site_url('privacy_policy')?>">privacy policy</a>.
                                    </p>
                                </li>
                                <li>
                                    <input type="radio" class="payment_mode" name="payment_mode" id="bank_transfer" value="bank">
                                    <label for="payment_method_bacs"> Pay via Debit/Credit Card </label>
                                    <div>
                                        <p>Payment card issued to users (cardholders) to enable the cardholder to pay a merchant for goods and services based on the cardholder's promise to the card issuer to pay them for the amounts plus the other agreed charges.</p>
                                    </div>
                                </li>
                                <li>
                                    <a id="bill-add" href="#" class="btn cart w-100" data-toggle="modal" data-backdrop="false" data-target="#confirmOrderModal"> Place order </a>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    </div>
    </div>
    <div class="clearfix"></div>
    </div>
    <div class="clearfix"></div>

    <div class="modal fade" id="confirmOrderModal" tabindex="-1" role="dialog" aria-labelledby="modalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" style="width: 400px !important;">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close my-close" data-dismiss="modal">
                    <span aria-hidden="true">×</span>
                    <span class="sr-only">Close</span>
                </button>
            </div>
            <div class="modal-body">
                <form name="confirm-order-form" id="confirm-order-form">
                    <!-- Form Title -->
                    <div class="form-heading text-center">
                        <div class="title"></div>
                        <!-- Social Line -->
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="Signup-in-right">
                                <br>
                                <h2>Organic Store</h2>
                                <h4>Do you want to place the order?</h4>
                                <hr>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="login-btn-last">
                                <button class="yes-place-order btn" id="confirmOrder"> Yes </button>
                                <button class="not-place-order btn" data-dismiss="modal"> No </button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
    <!--=======================footer file==============================-->
    <?php include 'includes/footer.php';?>
    <!--=======================footer script==============================-->
    <?php include 'includes/footer_scripts.php';?>
    </body>
</html>

