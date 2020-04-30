<?php
if (!empty($order_details) || !empty($merchant_key) || !empty($SALT) || !empty($PAYU_BASE_URL) || !empty($txnid)) {

    $email = $order_details[0]['email'];
    $order_id = $order_details[0]['order_id'];
    $first_name = $order_details[0]['first_name'];
    $amount = $order_details[0]['grand_total'];
    $last_name = $order_details[0]['last_name'];
    $phone = $order_details[0]['mobile_no'];
    $product_info = '';
    $count_product = count($order_details);
    foreach ($order_details as $key => $value) {
        $product_info .= ($count_product - 1 == $key) ? ($value['product_id'] . '') : ($value['product_id'] . ',');
    }

    $action = '';

// Hash Sequence
    $hashSequence = $merchant_key . '|' . $txnid . '|' . $amount . '|' . $product_info . '|' . $first_name . '|' . $email . '|' . $order_id . '||||||||||' . $salt;

    $hash = strtolower(hash('sha512', $hashSequence));
    $action = $redirect_url . '/_payment';

}
?>
<html>
<link rel="stylesheet" type="text/css" href="<?=FRONT_ASSETS_URL?>css/style.css"/>
<script src="https://code.jquery.com/jquery-3.5.0.min.js" integrity="sha256-xNzN2a4ltkB44Mc/Jz3pT4iU1cmeR0FkXs4pru/JxaQ=" crossorigin="anonymous"></script>
  <head>


<script>

  /*Animate loader off screen*/
  $(document).ready(function () {
      $(window).load(function () {
          // Animate loader off screen
          $(".se-pre-con").fadeOut("slow");
      });
  });
  /*Animate loader off screen*/

  var hash = '<?php echo $hash ?>';
  function submitPayuForm() {
    if(hash == '') {
      return;
    }
    var payuForm = document.forms.payuForm;
    payuForm.submit();
  }
  </script>
  </head>
  <body onload="submitPayuForm()">
  <div class="se-pre-con"></div>

    <form action="<?php echo $action; ?>" method="post" name="payuForm" id="payuForm">
      <input type="hidden" name="key" value="<?php echo $merchant_key ?>" />
      <input type="hidden" name="hash" value="<?php echo $hash ?>"/>
      <input type="hidden" name="txnid" value="<?php echo $txnid ?>" />
      <table>
        <tr>
          <td><input type="hidden" name="amount" value="<?=$amount?>" /></td>
          <td><input type="hidden" name="firstname" id="firstname" value="<?=$first_name?>" /></td>
        </tr>
        <tr>
          <td><input type="hidden" name="email" id="email" value="<?=$email?>" /></td>
          <td><input type="hidden" name="phone" value="<?=$phone?>" /></td>
        </tr>
        <tr id="productinfo" style="display:none;">
          <td colspan="3"><textarea name="productinfo"><?=$product_info?></textarea></td>
        </tr>
        <tr>
          <td colspan="3"><input type="hidden" name="surl" value="<?=site_url('order-received-online-payment')?>" size="64" /></td>
        </tr>
        <tr>
          <td colspan="3"><input type="hidden" name="furl" value="<?=site_url('transaction-failed')?>" size="64" /></td>
        </tr>

        <tr>
          <td colspan="3"><input type="hidden" name="service_provider" value="payu_paisa" size="64" /></td>
        </tr>
        <tr>
          <td><input type="hidden" name="lastname" id="lastname" value="<?=$last_name?>" /></td>
          <td><input type="hidden" name="curl" value="<?=site_url('')?>" /></td>
          <td><input type="hidden" name="udf1" value="<?=$order_id?>" /></td>
        </tr>
      </table>
    </form>
  </body>
</html>
