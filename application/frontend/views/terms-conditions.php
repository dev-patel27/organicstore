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
                <li class="breadcrumb-item">Terms Conditions</li>
            </ol>
        </nav>
        <?php
        if (!empty($tc)) {
            ?>
            <div class="row">
                <div class="col-lg-12 mt-2 mb-5">
                    <div class="terms-text">
                        <?php
                        $i = 1;
                        foreach ($tc as $key => $value) {
                            echo '<div>
                                    <h2>' . $i . '. ' . $value['title'] . '</h2>
                                    ' . $value['description'] . '
                                </div>';
                            $i++;
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
    </div>
    <div class="clearfix"></div>
    <!--=======================footer file==============================-->
    <?php include 'includes/footer.php'; ?>
    <!--=======================footer script==============================-->
    <?php include 'includes/footer_scripts.php'; ?>
    </body>
</html>
