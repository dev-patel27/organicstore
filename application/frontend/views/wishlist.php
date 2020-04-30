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
    <!-- Navigation -->
<div class="container">
  <nav aria-label="breadcrumb">
    <ol class="breadcrumb2 breadcrumb">
      <li class="breadcrumb-item"><a href="index.php"><i class="fa fa-home" aria-hidden="true"></i> Home</a></li>
      <li class="breadcrumb-item">Wishlist</li>
    </ol>
  </nav>
  <div class="row">
    <div class="col-lg-12 mt-4">
      <div class="table-responsive wishlist-table">
      <?php
if (!empty($output)) {
    ?>
        <table class="table rm-class wishlist-table">
          <thead class="title-h">
            <tr>
              <th colspan="2" class="product-price">Product Detail</th>
              <th width="105px" class="product-subtotal text-center unit-price"><p>Unit Price</p></th>
              <th class="text-center product-add-date"><p>Date Added</p></th>
              <th class="text-center add-to-3-th"> <p>Stock Status</p> </th>
              <th class="add-to-cart-th"><p>Add to Cart</p></th>
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
} else {
    echo '<div class="empty-wishlist">' . $empty_wishlist . '</div>';
}
?>
<div class="empty-wishlist"></div>
      </div>
    </div>
  </div>
</div>
<div class="clearfix"></div>
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
  </script>
    </body>
</html>

