<!DOCTYPE html>
<html lang="en">

<head>
    <!--=======================header & start file==============================-->
    <?php include 'includes/start.php'; ?>
    <?php include 'includes/header.php'; ?>
    <!--=======================header & start file==============================-->

    <!-- Navigation -->
    <div class="container">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb breadcrumb2">
                <li class="breadcrumb-item"><a href="<?= site_url('') ?>>"><i class="fa fa-home" aria-hidden="true"></i>
                        Home</a>
                </li>
                <li class="breadcrumb-item">About Us</li>
            </ol>
        </nav>

        <!--  About-us  section  -->
        <?php
        if (!empty($about_us)) {
            echo '<div class="row">
                    <div class="about-us">
                        <div class="container">
                            <div class="our-story">
                                <div class="row">
                                    <div class="col-lg-6 col-md-12">
                                        <div class="our-story_text">
                                            <h1 class="title orange-underline">About Us</h1>
                                            ' . $about_us->description . '
                                        </div>
                                    </div>
                                    <div class="about-us col-lg-6 col-md-12" style="margin-top: 10%;">
                                        <img src="' . ABOUT_US_IMG_URL . $about_us->image . '" class="img-fluid" alt="About-us" title="About-us">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="clearfix"></div>
                </div>';
        }
        ?>
    </div>

    <!--Counter section-->
    <?php
    if (!empty($counter)) {
        ?>
        <div class="counter-section">
            <div class="container">
                <div class="row" id="counter">
                    <?php
                    foreach ($counter as $key => $value) {
                        echo '<div class="col-lg-4 col-md-6 col-sm-6">
                        <div class="counter">
                            <div class="my-counter-class text-center"><img src="' . ABOUT_US_IMG_URL . $value['image'] . '" alt="counter-images"
                                                          title="Counter" class="img-fluid"></div>
                            <h2 class="counter-value" data-count="' . $value['counter_value'] . '">0</h2>
                            <p class="count-text ">' . $value['title'] . '</p>
                        </div>
                    </div>';
                    }
                    ?>
                </div>
            </div>
        </div>
        <?php
    }
    ?>

    <!--why-choose-us section-->
    <?php
    if (!empty($why_choose_us)) {
        ?>
        <div class="why-choose">
            <h2>Why Choose Us</h2>
            <div class="clearfix"></div>
            <div class="container">
                <div class="row">
                    <div class="col-lg-7">
                        <div class="row">
                            <?php
                            foreach ($why_choose_us as $key => $value) {
                                echo '<div class="col-lg-6 col-md-6 mb-4">
                                    <div class="icon-detail">
                                        <img src="' . ABOUT_US_IMG_URL . $value['image'] . '" class="img-fluid" alt="why-choose-image">
                                        <h5>' . $value['title'] . '</h5>
                                    </div>
                                </div>';
                            }
                            ?>
                        </div>
                    </div>
                    <div class="col-lg-5">
                        <div><img src="<?= FRONT_ASSETS_URL ?>/images/page-img/why-choose.jpg" title="" alt=""
                                  class="img-fluid"></div>
                    </div>
                </div>
            </div>
        </div>
        <div class="clearfix"></div>
        <?php
    }
    ?>

    <!--=======================footer file==============================-->
    <?php include 'includes/footer.php'; ?>
    <!--=======================footer script==============================-->
    <?php include 'includes/footer_scripts.php'; ?>
    <script src="<?= FRONT_ASSETS_URL ?>/vendor/jquery/counter.js"></script>
    </body>
</html>
