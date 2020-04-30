<?php $this->load->view('includes/header'); ?>
<link rel="stylesheet" type="text/css" media="screen"
      href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datetimepicker/4.17.37/css/bootstrap-datetimepicker.min.css"/>
<div class="page-container">
    <?php $this->load->view('includes/sidebar'); ?>
    <div class="page-content-wrapper">
        <div class="page-content">
            <div class="page-bar">
                <ul class="page-breadcrumb">
                    <li>
                        <span>Product</span>
                        <i class="fa fa-circle"></i>
                    </li>
                    <li>
                        <span>Add</span>
                    </li>
                </ul>
            </div>
            <div class="row">
                <div class="portlet light">
                    <div class="portlet-body form">
                        <form action="<?= current_url(); ?>" id="form_sample_3" method="post" class="form-horizontal"
                              enctype="multipart/form-data">
                            <div class="alert alert-danger display-hide">
                                <button class="close" data-close="alert"></button>
                                You have some form errors. Please check below.
                            </div>

                            <!--category-->
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
                                                        echo '<option value="' . $row_c['id'] . '">' . $row_c['category_name'] . '</option>';
                                                    }
                                                    ?>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Sub category-->
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label class="control-label col-md-3">Sub Category
                                            <span class="required"> * </span>
                                        </label>
                                        <!--<div class="col-md-9">
                                            <div class="input-icon right">
                                                <i class="fa"></i>
                                                <select class="required sub_category table-group-action-input form-control required"
                                                        multiple="multiple" name="sub_category_id[]" width="100%"
                                                        id="sub_category_id">
                                                    <?php
/*                                                    /*$sub_category = $this->admin_model->get_product_subcategory();
                                                    foreach ($sub_category as $row_c) {
                                                        echo '<option value="' . $row_c['id'] . '">' . $row_c['sub_category_name'] . '</option>';
                                                    }*/
                                                    ?>
                                                </select>
                                            </div>
                                        </div>-->
                                        <div class="col-md-9">
                                            <div class="input-icon right">
                                                <i class="fa"></i>
                                                <select class="required table-group-action-input form-control required" id="sub_category_id" name="sub_category_id" width="100%" id="" >
                                                    <option value="">Select Sub Category</option>
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
                                                    $tag = $this->admin_model->get_tag();
                                                    foreach ($tag as $row_c) {
                                                        echo '<option value="' . $row_c['id'] . '">' . $row_c['tag_name'] . '</option>';
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
                                                <input type="text" name="product_name" class="form-control required"/>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label class="control-label col-md-3">Image <span
                                                    class="required"> * </span></label>
                                        <div class="col-md-9">
                                            <div class="input-icon right">
                                                <i class="fa"></i>
                                                <input type="file" class="required form-control allow-number-only"
                                                       placeholder="Image" name="image" id="image"/>
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
                                                          id="summernote_1"></textarea>
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
                                                          id="summernote_2"></textarea>
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
                                                          id="summernote_3"></textarea>
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
                                                <input type="text" id="price" pattern="[+-]?([0-9]*[.])?[0-9]+"
                                                       name="price"
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
                                                <input type="text" id="discount_percentage" pattern="[+-]?([0-9]*[.])?[0-9]+"
                                                       name="discount_percentage" class="form-control"/>
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
                                                <input type="text" id="shipping_charge" name="shipping_charge"
                                                       pattern="[+-]?([0-9]*[.])?[0-9]+" class="form-control"/>
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
                                                <input type="text" name="meta_title" class="form-control"/>
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
                                                <textarea name="meta_description" class="form-control"></textarea>
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
                                                <textarea name="meta_keyword" class="form-control"></textarea>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>


                            <div class="form-actions">
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="row" align="center">
                                            <button class="btn green" type="submit">Submit</button>
                                            <button class="btn default"
                                                    onclick="cancelBtn('<?= site_url('product/product/list'); ?>','form_sample_3')"
                                                    type="button">Cancel
                                            </button>
                                        </div>
                                    </div>
                                    <div class="col-md-6"></div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?php $this->load->view('includes/inner_footer'); ?>
<?php $this->load->view('includes/form_js'); ?>
<?php
$jsArray = array(
    'ckeditor/ckeditor.js',
);
echo $this->headerlib->put_js($jsArray);
?>
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

</script>
<?php $this->load->view('includes/footer'); ?>
