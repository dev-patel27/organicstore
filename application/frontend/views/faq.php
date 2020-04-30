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
                <li class="breadcrumb-item"><a href="<?= site_url('') ?>"><i class="fa fa-home" aria-hidden="true"></i>Home</a>
                </li>
                <li class="breadcrumb-item">Faq</li>
            </ol>
        </nav>

        <!--faq section-->
        <?php
        if (!empty($faq)) {
            ?>
            <div class="row">
                <div class="col-lg-12 mt-2 mb-5">
                    <div id="accordion" role="tablist" class="faq">
                        <?php
                        foreach ($faq as $key => $value) {
                            if ($key == '0') {
                                ?>
                                <div class="card">
                                    <div class="card-header" role="tab" id="heading<?= $value['id'] ?>>">
                                        <a data-toggle="collapse" href="#collapse<?= $value['id'] ?>"
                                           aria-expanded="true"
                                           aria-controls="collapse<?= $value['id'] ?>">
                                            <h5 class="mb-0"> <?= $value['question'] ?> </h5>
                                        </a>
                                    </div>
                                    <div id="collapse<?= $value['id'] ?>" class="collapse show" role="tabpanel"
                                         aria-labelledby="heading<?= $value['id'] ?>"
                                         data-parent="#accordion">
                                        <div class="card-body">
                                            <?= $value['answer'] ?>
                                        </div>
                                    </div>
                                </div>
                                <?php
                            } else {
                                ?>
                                <div class="card">
                                    <div class="card-header" role="tab" id="heading<?= $value['id'] ?>">
                                        <a class="collapsed" data-toggle="collapse" href="#collapse<?= $value['id'] ?>"
                                           aria-expanded="false"
                                           aria-controls="collapse<?= $value['id'] ?>">
                                            <h5 class="mb-0"><?= $value['question'] ?></h5>
                                        </a>
                                    </div>
                                    <div id="collapse<?= $value['id'] ?>" class="collapse" role="tabpanel"
                                         aria-labelledby="heading<?= $value['id'] ?>"
                                         data-parent="#accordion">
                                        <div class="card-body">
                                            <?= $value['answer'] ?>
                                        </div>
                                    </div>
                                </div>
                                <?php
                            }
                        }
                        ?>
                    </div>
                </div>
            </div>
            <?php
        }
        ?>

    </div>
    <div class="clearfix"></div>

    <!--=======================footer file==============================-->
    <?php include 'includes/footer.php'; ?>
    <!--=======================footer script==============================-->
    <?php include 'includes/footer_scripts.php'; ?>
    </body>
</html>
