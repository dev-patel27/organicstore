<!-- INCLUDE HEADER -->
<?php $this->load->view('includes/header'); ?>
<script src="//code.jquery.com/jquery-3.2.1.min.js"></script>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/fancybox/3.2.5/jquery.fancybox.min.css"/>
<script src="https://cdnjs.cloudflare.com/ajax/libs/fancybox/3.2.5/jquery.fancybox.min.js"></script>
<div class="page-container">
    <!-- BEGIN SIDEBAR -->
    <?php $this->load->view('includes/sidebar'); ?>
    <!-- END SIDEBAR -->
    <!-- BEGIN CONTENT -->
    <div class="page-content-wrapper">
        <!-- BEGIN CONTENT BODY -->
        <!-- BEGIN PAGE HEAD-->
        <!-- BEGIN PAGE CONTENT BODY -->
        <div class="page-content">
            <!-- BEGIN PAGE HEADER-->
            <!-- BEGIN PAGE BAR -->
            <div class="page-bar">
                <ul class="page-breadcrumb">
                    <li>
                        <span>Product</span>
                        <i class="fa fa-circle"></i>
                    </li>
                    <li>
                        <span>Details</span>
                    </li>
                </ul>
            </div>
            <!-- Page Content -->
            <div class="row">
                <div class="col-md-12">
                    <!-- BEGIN PROFILE SIDEBAR -->
                    <div class="profile-sidebar">
                        <!-- PORTLET MAIN -->
                        <div class="portlet light profile-sidebar-portlet ">
                            <div class="row">
                                <div class="portlet box dark">
                                    <div class="portlet-title">
                                    </div>
                                    <div class="portlet-body">
                                        <div class="tab-content">
                                            <div class="tab-pane active" id="portlet_tab_1">
                                                <div class="row">
                                                    <div class="col-md-6">
                                                        <p>
                                                            <b>Category</b> :
                                                            <?php
                                                            $category_id = $result[1]->category_id;
                                                            $data = $this->db->where('id', $category_id)->get('tbl_product_category')->row();
                                                            echo $data->category_name;
                                                            ?>
                                                            <br><br>
                                                            <b>Sub-Category</b> :
                                                            <?php
                                                            $sub_category_id = $result[1]->sub_category_id;
                                                            $data = $this->db->where('id', $sub_category_id)->get('tbl_product_subcategory')->row();
                                                            echo $data->sub_category_name;

                                                            /*$result1 = explode(',', $result[1]->sub_category_id);
                                                            $count = count($result1);
                                                            foreach ($result1 as $key => $value) {
                                                                $data = $this->db->where('id', $value)->get('tbl_product_subcategory')->row();
                                                                $name = ($count - 1 == $key) ? ($data->sub_category_name . '') : ($data->sub_category_name . ', ');
                                                                echo $name;
                                                            }*/
                                                            ?>
                                                            <br><br>
                                                            <b>Tags</b> :
                                                            <?php
                                                            $result1 = explode(',', $result[1]->tag_id);
                                                            foreach ($result1 as $key => $value) {
                                                                $data = $this->db->where('id', $value)->get('tbl_tag')->row();
                                                                echo "<button class='btn btn-primary'>$data->tag_name</button> ";
                                                            }
                                                            ?>
                                                            <br><br>
                                                            <b>Product Name </b>: <?= $result[1]->product_name; ?>
                                                            <br><br>
                                                            <b>Product Image</b> :<br><br> <img
                                                                    src="<?= PRODUCT_IMG_URL . $result[1]->image; ?>"
                                                                    width="300px" height="300px"
                                                                    alt="<?= $result[1]->product_name; ?>">
                                                            <br><br>


                                                            <b>Main-Description</b>
                                                            :<br> <?= $result[1]->short_description; ?>
                                                        <div class="portlet box dark">
                                                            <div class="portlet-title">
                                                                <div class="caption">
                                                                    <h4>Description Section</h4>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <b>Description</b> : <br><br> <?= $result[1]->description; ?>

                                                        <div class="portlet box dark">
                                                            <div class="portlet-title">
                                                                <div class="caption">
                                                                    <h4>Additional Information Section</h4>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <b>Pack Sizes (in gram or kg or pcs)</b>
                                                        : <?= $result[1]->per_pack; ?>
                                                        <br><br>
                                                        <b>Calories</b> : <?= $result[1]->calories; ?>
                                                        <br><br>
                                                        <b>Nutrition Facts</b> : <?= $result[1]->nutrition; ?>
                                                        <b>Storage life</b> : <?= $result[1]->storage_life; ?>
                                                        <br><br>


                                                        <div class="portlet box dark">
                                                            <div class="portlet-title">
                                                                <div class="caption">
                                                                    <h4>Price Section</h4>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <b>Price</b> : <?= '&#x20B9;' . round($result[1]->price, 2); ?>
                                                        <br><br>
                                                        <b>Discount Percentage</b>
                                                        : <?php
                                                        if (!empty($result[1]->discount_percentage)) {
                                                            echo round($result[1]->discount_percentage,2) . '%';
                                                        } else {
                                                            echo '<b>---</b>';
                                                        }
                                                        ?>
                                                        <br><br>
                                                        <b>Price after discount</b>
                                                        : <?php
                                                        $original_price = $result[1]->price;
                                                        $discount_percentage = $result[1]->discount_percentage;
                                                        $discount_amount = $discount_percentage / 100;
                                                        $final_price = $original_price - ($discount_amount * $original_price);
                                                        echo '&#x20B9;' . round($final_price,2);
                                                        ?>
                                                        <br><br>
                                                        <b>Shipping Charge</b>
                                                        : <?= '&#x20B9;' . round($result[1]->shipping_charge,2); ?>
                                                        <br><br>

                                                        <div class="portlet box dark">
                                                            <div class="portlet-title">
                                                                <div class="caption">
                                                                    <h4>Seo Information</h4>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <b>Meta Title</b> : <?= $result[1]->meta_title; ?>
                                                        <br><br>
                                                        <b>Meta Description</b> : <?= $result[1]->meta_description; ?>
                                                        <br><br>
                                                        <b>Meta Keyword</b> : <?= $result[1]->meta_keyword; ?>
                                                        </p>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <a href="javascript:;" class="page-quick-sidebar-toggler"><i class="icon-login"></i></a>
    </div>
    <!-- End Hotline Content -->
    <!-- INCLUDE FOOTER -->

    <script src="https://maps.googleapis.com/maps/api/js?libraries=places&key=AIzaSyBw771Tyv5YU7rL9b7o3eAOJK_q9T1vkFo"></script>
    <?php $this->load->view('includes/inner_footer'); ?>
    <?php $this->load->view('includes/list_js'); ?>
<?php $this->load->view('includes/footer'); ?>