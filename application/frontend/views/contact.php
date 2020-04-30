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
                <li class="breadcrumb-item"><a href="index.php"><i class="fa fa-home" aria-hidden="true"></i> Home</a>
                </li>
                <li class="breadcrumb-item">Contact</li>
            </ol>
        </nav>
        <div class="clearfix"></div>
    </div>
    <div class="clearfix"></div>
    <div class="contact-page contact-us">
        <div class="feature map">
            <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3670.1734786511824!2d72.53263041444346!3d23.09074451957234!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x395e833af6f39347%3A0xf1db9065daea7008!2sSilver%20Oak%20College%20of%20Engineering%20and%20Technology!5e0!3m2!1sen!2sin!4v1572697185328!5m2!1sen!2sin"></iframe>
        </div>
        <div class="container">
            <div class="row justify-content-center mb-4">
                <div class="col-md-10">
                    <div class="contact-method">
                        <div class="row">
                            <div class="col-12 col-md-6">
                                <div class="method-block"><i class="fa fa-map-marker"></i>
                                    <div class="method-block_text">
                                        <p>Ahmedabad, Gujarat 382481</p>
                                        <p>India</p>
                                    </div>
                                </div>
                            </div>
                            <?php
                            if (!empty($web_info)) {
                                ?>
                                <div class="col-12 col-md-6">
                                    <div class="method-block"><i class="fa fa-envelope"></i>
                                        <div class="method-block_text">
                                            <p><span>Phone : </span><?= $web_info->cell_number ?></p>
                                            <p><span>Mail : </span><a
                                                        href="mailto:<?= $web_info->email ?>"><?= $web_info->email ?></a>
                                            </p>
                                        </div>
                                    </div>
                                </div>
                                <?php
                            }
                            ?>
                        </div>
                    </div>
                    <div class="leave-message">
                        <h1 class="title">Leave Message</h1>
                        <p>Our staff will call back later and answer your questions.</p>
                        <form name="contact-form" id="contact-form" method="post" onsubmit="return false;">
                            <div class="row">
                                <div class="col-12 col-md-6">
                                    <div class="form-group">
                                        <input class="form-control" type="text" id="cname" name="cname"
                                               placeholder="Name">
                                    </div>
                                </div>
                                <div class="col-12 col-md-6">
                                    <div class="form-group">
                                        <input class="form-control" type="email" id="cemail" name="cemail"
                                               placeholder="Email">
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="form-group">
                                        <textarea class="form-control" id="cmessage" name="cmessage" cols="30" rows="10"
                                                  placeholder="Your message"></textarea>
                                    </div>
                                </div>
                                <div class="col-12 text-center">
                                    <div class="form-group">
                                        <input type="submit" class="btn add-to-cart2" value="Submit">
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!--=======================footer file==============================-->
    <?php include 'includes/footer.php'; ?>
    <!--=======================footer script==============================-->
    <?php include 'includes/footer_scripts.php'; ?>
    </body>
</html>