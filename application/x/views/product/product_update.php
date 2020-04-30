<!-- INCLUDE HEADER -->
<?php $this->load->view('includes/header'); ?>
<link rel="stylesheet" type="text/css" media="screen"
      href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datetimepicker/4.17.37/css/bootstrap-datetimepicker.min.css"/>
<!-- BEGIN CONTAINER -->
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
            <!-- BEGIN THEME PANEL -->
            <!-- END THEME PANEL -->
            <!-- BEGIN PAGE BAR -->
            <div class="page-bar">
                <ul class="page-breadcrumb">
                    <li>
                        <span>Product</span>
                        <i class="fa fa-circle"></i>
                    </li>
                    <li>
                        <span>Edit</span>
                    </li>
                </ul>
            </div>
            <!-- END PAGE BREADCRUMBS -->
            <!-- BEGIN PAGE CONTENT INNER -->
            <div class="row">
                <div class="portlet light">
                    <div class="portlet-body form">
                        <!-- BEGIN FORM-->
                        <form action="<?= current_url(); ?>" id="form_sample_3" method="post" class="form-horizontal"
                              enctype="multipart/form-data">
                            <div class="alert alert-danger display-hide">
                                <button class="close" data-close="alert"></button>
                                You have some form errors. Please check below.
                            </div>

                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label class="control-label col-md-3">Category
                                            <span class="required"> * </span>
                                        </label>
                                        <div class="col-md-9">
                                            <div class="input-icon right">
                                                <i class="fa"></i>
                                                <select class="required table-group-action-input form-control required"
                                                        onchange="getSubCategory()" id="category_id" name="category_id"
                                                        width="100%" id="">
                                                    <option value="">Select Category</option>
                                                    <?php
                                                    $category = $this->admin_model->get_product_category();
                                                    foreach ($category as $row_c) {
                                                        $selected = ($row_c['id'] == $result['1']->category_id) ? 'selected' : '';
                                                        echo '<option value="' . $row_c['id'] . '" ' . $selected . '>' . $row_c['category_name'] . '</option>';
                                                    }
                                                    ?>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label class="control-label col-md-3">Sub Category
                                            <span class="required"> * </span>
                                        </label>
                                        <div class="col-md-9">
                                            <div class="input-icon right">
                                                <i class="fa"></i>
                                                <!--<select class="required sub_category table-group-action-input form-control required"
                                                        multiple="multiple" name="sub_category_id[]" width="100%"
                                                        id="sub_category_id">
                                                    <?php
                                                /*                                                    $sel = "";
                                                                                                    $result1 = explode(',', $result['1']->sub_category_id);
                                                                                                    $sub_category = $this->db->where(array('status' => '1', 'category_id' => $result['1']->category_id))->get('tbl_product_subcategory')->result_array();
                                                                                                    foreach ($sub_category as $row_c) {
                                                                                                        if (in_array($row_c['id'], $result1)) {
                                                                                                            $selected = 'selected';
                                                                                                        } else {
                                                                                                            $selected = '';
                                                                                                        }
                                                                                                        echo '<option value="' . $row_c['id'] . '" ' . $selected . '>' . $row_c['sub_category_name'] . '</option>';
                                                                                                    }
                                                                                                    */ ?>
                                                </select>-->

                                                <select class="required sub_category table-group-action-input form-control required"
                                                        name="sub_category_id" width="100%"
                                                        id="sub_category_id">
                                                    <option value="">Select Sub Category</option>
                                                    <?php
                                                    $sub_category = $this->admin_model->get_product_subcategory();
                                                    foreach ($sub_category as $row_c) {
                                                        $selected = ($row_c['id'] == $result['1']->sub_category_id) ? 'selected' : '';
                                                        echo '<option value="' . $row_c['id'] . '" ' . $selected . '>' . $row_c['sub_category_name'] . '</option>';
                                                    }
                                                    ?>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!--tags-->
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label class="control-label col-md-3">Tags
                                            <span class="required"> * </span>
                                        </label>
                                        <div class="col-md-9">
                                            <div class="input-icon right">
                                                <i class="fa"></i>
                                                <select class="required tag_name table-group-action-input form-control required"
                                                        multiple="multiple" name="tag_id[]" width="100%">
                                                    <?php
                                                    $sel = "";
                                                    $result1 = explode(',', $result['1']->tag_id);
                                                    $tag = $this->admin_model->get_tag();
                                                    foreach ($tag as $row_c) {
                                                        if (in_array($row_c['id'], $result1)) {
                                                            $selected = 'selected';
                                                        } else {
                                                            $selected = '';
                                                        }
                                                        echo '<option value="' . $row_c['id'] . '" ' . $selected . '>' . $row_c['tag_name'] . '</option>';
                                                    }
                                                    ?>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>


                            <!-- product name -->
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label class="control-label col-md-3">Product Name<span
                                                    class="required"> * </span></label>
                                        <div class="col-md-9">
                                            <div class="input-icon right">
                                                <i class="fa"></i>
                                                <input type="text" name="product_name"
                                                       value="<?= $result['1']->product_name ?>"
                                                       class="form-control required"/>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label class="control-label col-md-3">Image</label>
                                        <div class="col-md-9">
                                            <div class="input-icon right">
                                                <i class="fa"></i>
                                                <input type="file" placeholder="Image" name="image" id="image"/>
                                                <img style="float: right;margin-top: -20px;"
                                                     src="<?= PRODUCT_IMG_URL . $result['1']->image ?>" alt=""
                                                     height="80px" width="100px">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- short-description-->
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label class="control-label col-md-3">Main-Description<span
                                                    class="required"> * </span></label>
                                        <div class="col-md-9">
                                            <div class="input-icon right">
                                                <i class="fa"></i>
                                                <textarea name="short_description" class="form-control required"
                                                          id="summernote_1"><?= $result['1']->short_description ?></textarea>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="portlet box dark">
                                <div class="portlet-title">
                                    <div class="caption">
                                        <h4>Description Section</h4>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label class="control-label col-md-3">Description</label>
                                        <div class="col-md-9">
                                            <div class="input-icon right">
                                                <i class="fa"></i>
                                                <textarea name="description" class="form-control"
                                                          id="summernote_2"><?= $result['1']->description ?></textarea>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>


                            <div class="portlet box dark">
                                <div class="portlet-title">
                                    <div class="caption">
                                        <h4>Additional Information Section</h4>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label class="control-label col-md-3">Pack Sizes (in gram or kg or pcs)<span
                                                    class="required"> * </span></label>
                                        <div class="col-md-9">
                                            <div class="input-icon right">
                                                <i class="fa"></i>
                                                <input type="text" id="per_pack" name="per_pack"
                                                       value="<?= $result['1']->per_pack ?>"
                                                       class="form-control required"/>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label class="control-label col-md-3">Calories</label>
                                        <div class="col-md-9">
                                            <div class="input-icon right">
                                                <i class="fa"></i>
                                                <input type="text" id="calories" name="calories"
                                                       value="<?= $result['1']->calories ?>"
                                                       class="form-control"/>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label class="control-label col-md-3">Nutrition Facts</label>
                                        <div class="col-md-9">
                                            <div class="input-icon right">
                                                <i class="fa"></i>
                                                <textarea name="nutrition" class="form-control"
                                                          id="summernote_3"><?= $result['1']->nutrition ?></textarea>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label class="control-label col-md-3">Storage life</label>
                                        <div class="col-md-9">
                                            <div class="input-icon right">
                                                <i class="fa"></i>
                                                <input type="text" id="storage_life" name="storage_life"
                                                       value="<?= $result['1']->storage_life ?>"
                                                       class="form-control"/>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>


                            <div class="portlet box dark">
                                <div class="portlet-title">
                                    <div class="caption">
                                        <h4>Price Section</h4>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label class="control-label col-md-3">Price<span
                                                    class="required"> * </span></label>
                                        <div class="col-md-9">
                                            <div class="input-icon right">
                                                <i class="fa"></i>
                                                <input type="text" pattern="[+-]?([0-9]*[.])?[0-9]+" id="price" name="price"
                                                       value="<?= round($result['1']->price, 2) ?>"
                                                       class="form-control required"/>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label class="control-label col-md-3">Discount Percentage</label>
                                        <div class="col-md-9">
                                            <div class="input-icon right">
                                                <i class="fa"></i>
                                                <input type="text" pattern="[+-]?([0-9]*[.])?[0-9]+" id="discount_percentage"
                                                       name="discount_percentage"
                                                       value="<?= round($result['1']->discount_percentage, 2) ?>"
                                                       class="form-control"/>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label class="control-label col-md-3">Shipping Charge</label>
                                        <div class="col-md-9">
                                            <div class="input-icon right">
                                                <i class="fa"></i>
                                                <input type="text" pattern="[+-]?([0-9]*[.])?[0-9]+" id="shipping_charge"
                                                       name="shipping_charge"
                                                       value="<?= $result['1']->shipping_charge ?>"
                                                       class="form-control"/>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>


                            <div class="portlet box dark">
                                <div class="portlet-title">
                                    <div class="caption">
                                        <h4>Seo Information</h4>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label class="control-label col-md-3">Meta Title</label>
                                        <div class="col-md-9">
                                            <div class="input-icon right">
                                                <i class="fa"></i>
                                                <input type="text" name="meta_title"
                                                       value="<?= $result['1']->meta_title ?>" class="form-control"/>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <br>
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label class="control-label col-md-3">Meta Description</label>
                                        <div class="col-md-9">
                                            <div class="input-icon right">
                                                <i class="fa"></i>
                                                <textarea name="meta_description"
                                                          class="form-control"><?= $result['1']->meta_description ?></textarea>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label class="control-label col-md-3">Meta Keyword</label>
                                        <div class="col-md-9">
                                            <div class="input-icon right">
                                                <i class="fa"></i>
                                                <textarea name="meta_keyword"
                                                          class="form-control"><?= $result['1']->meta_keyword ?></textarea>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>


                            <div class="form-actions">
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="row" align="center">
                                            <!-- <div class="col-md-offset-3 col-md-9"> -->
                                            <button class="btn green" type="submit">Submit</button>
                                            <button class="btn default"
                                                    onclick="cancelBtn('<?= site_url('product/product/list'); ?>','form_sample_3')"
                                                    type="button">Cancel
                                            </button>
                                            <!-- </div> -->
                                        </div>
                                    </div>
                                    <div class="col-md-6"></div>
                                </div>
                            </div>
                    </div>
                    </form>
                    <!-- END FORM-->
                </div>
            </div>
        </div>
    </div>
</div>
</div>
<!-- INCLUDE FOOTER -->
<?php $this->load->view('includes/inner_footer'); ?>
<?php $this->load->view('includes/form_js'); ?>
<?php
$jsArray = array(
    'ckeditor/ckeditor.js',

);
echo $this->headerlib->put_js($jsArray);
?>
<script src="<?php echo BASE_URL ?>x/assets/ckfinder/ckfinder.js"></script>
<script type="text/javascript"
        src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.9.0/moment-with-locales.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datetimepicker/4.17.47/js/bootstrap-datetimepicker.min.js"></script>
<script>
    $('.datetimepicker1').datetimepicker({
        //format: 'DD-MM-YYYY',
        //format: 'YYYY-MM-DD hh:mm A'
        format: 'DD-MM-YYYY'
    });
</script>
<script>
    CKEDITOR.replace('summernote_1');
    CKEDITOR.replace('summernote_2');
    CKEDITOR.replace('summernote_3');

    function getSubCategory() {
        let category_id = $('#category_id').val();
        if (category_id != "") {
            $.ajax({
                method: 'POST',
                url: "<?= ADMIN_BASE_URL . '/product/subcategory'?>",
                data: {category_id: category_id},
                success: function (response) {
                    var response_data = JSON.parse(response);
                    if (response_data.status == 200) {
                        $("#sub_category_id").html(response_data.data);
                    }
                }
            });
        } else {
            $('#sub_category_id').html('');
        }
    }

    $(document).ready(function () {
        $('.tag_name').select2();
    });

    /*$(document).ready(function () {
        $('.sub_category').select2();
    });*/

</script>
<?php $this->load->view('includes/footer'); ?>