<!-- INCLUDE HEADER -->
<?php $this->load->view('includes/header'); ?>
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
        <div class="page-content" >
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
                        <span>list</span>
                    </li>
                </ul>
                <div class="page-toolbar">
                    <div class="btn-group">
                        <button type="button" class="btn blue" onclick="location.href = 'add';" >Add Product</button>
                    </div>
                </div>
            </div>
            <!-- END PAGE BAR -->
            <!-- BEGIN PAGE TITLE-->
            <!-- END PAGE TITLE-->
            <!-- END PAGE HEADER-->
            <div class="row">
                <div class="col-md-12">
                    <!-- Begin: life time stats -->
                    <div class="portlet light portlet-fit portlet-datatable ">
                        <div class="portlet-title line-border">
                            <div class="form-body filter">
                                <div class=" col-md-3">
                                    <label>Product Name</label>
                                    <div class="input-group">
                                        <input type="text" placeholder="Product Name" class="form-control form-filter" name="product_name">
                                    </div>
                                </div>
                                <div class=" col-md-3">
                                    <label>Category Name</label>
                                    <div class="input-group">
                                        <input type="text" placeholder="Category Name" class="form-control form-filter" name="category_name">
                                    </div>
                                </div>

                                <div class=" col-md-3">
                                    <label>Create At</label>
                                    <div class="input-group">
                                        <div data-date-format="dd/mm/yyyy" class="input-group date date-picker margin-bottom-5">
                                            <input name="form_created_at"  id="form_created_at" type="text" placeholder="From" readonly="" class="form-control form-filter input-sm">
                                            <span class="input-group-btn">
                                 <button type="button" class="btn btn-sm default">
                                 <i class="fa fa-calendar"></i>
                                 </button>
                                 </span>
                                        </div>
                                        <div data-date-format="dd/mm/yyyy" class="input-group date date-picker">
                                            <input name="to_created_at" id="to_created_at" onchange="DateCheck()"  type="text" placeholder="To" readonly="" class="form-control form-filter input-sm">
                                            <span class="input-group-btn">
                                 <button type="button" class="btn btn-sm default">
                                 <i class="fa fa-calendar"></i>
                                 </button>
                                 </span>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-3 margin-top-20 pull-right">
                                    <div class="margin-bottom-5">
                                        <button class="btn btn-sm green btn-outline filter-submit margin-bottom">
                                            <i class="fa fa-search"></i> Search</button>
                                    </div>
                                    <button class="btn btn-sm red btn-outline filter-cancel" style="width:80px">
                                        <i class="fa fa-times"></i> Reset</button>
                                </div>
                            </div>
                        </div>
                        <?php if ($this->session->flashdata('error')) { ?>
                            <div class="alert alert-danger">
                                <button class="close" data-close="alert"></button>
                                <span><?php echo $this->session->flashdata('error'); ?></span>
                            </div>
                        <?php } ?>
                        <?php if( $this->session->flashdata('success') ){ ?>
                            <div class="alert alert-success">
                                <button class="close" data-close="alert"></button>
                                <span> <?php echo $this->session->flashdata('success');?> </span>
                            </div>
                        <?php } ?>
                        <div class="portlet-body">
                            <div class="table-container">
                                <div class="table-actions-wrapper">
                                    <span> </span>
                                    <select class="table-group-action-input form-control input-inline input-small input-sm">
                                        <option value="">Select...</option>
                                        <!--
                                           <option value="1">Active</option>
                                           <option value="0">In-active</option>
                                           -->
                                        <option value="9">Delete</option>
                                    </select>
                                    <button class="btn btn-sm green table-group-action-submit">
                                        <i class="fa fa-check"></i> Submit</button>
                                </div>
                                <table class="table table-striped table-bordered table-hover table-checkable" id="datatable_ajax">
                                    <thead>
                                    <tr role="row" class="heading">
                                        <th width="1%">
                                            <input type="checkbox" class="group-checkable" id="checkbox">
                                        </th>
                                        <th width="2%">Category</th>
                                        <th width="2%">Sub Category</th>
                                        <th width="2%">Product Name</th>
                                        <th width="2%">Main-Description</th>
                                        <th width="2%">Main-Image</th>
                                        <th width="2%">Stock Availability</th>
                                        <th width="2%">Deal of the Week</th>
                                        <th width="2%">Featured Products</th>
                                        <th width="1%">Status</th>
                                        <th width="1%">Created At</th>
                                        <th width="1%" data-sortable="false">Actions</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                    <!-- End: life time stats -->
                </div>
            </div>
        </div>
    </div>
    <a href="javascript:;" class="page-quick-sidebar-toggler"><i class="icon-login"></i></a>
</div>
<!-- End Hotline Content -->
<!-- INCLUDE FOOTER -->
<?php $this->load->view('includes/inner_footer'); ?>
<?php $this->load->view('includes/list_js'); ?>
<script>
    $(document).ready(function () {
        TableDatatablesAjax.init('datatable_ajax', '<?php echo ADMIN_BASE_URL .'product/product'; ?>');
    });

    function insert_status(checked,id)
    {
        $.ajax({
            type: "POST",
            url:  "<?php echo site_url('product/product/list')?>",
            data: {checked :checked,id:id },
            success: function(response) {
                var response_data = JSON.parse(response);
            }
        });
    }

    function insert_status1(checked1,id1)
    {
        $.ajax({
            type: "POST",
            url:  "<?php echo site_url('product/product/list')?>",
            data: {checked1 :checked1,id1:id1 },
            success: function(response) {
                var response_data = JSON.parse(response);
            }
        });
    }

    function insert_status2(checked2,id2)
    {
        $.ajax({
            type: "POST",
            url:  "<?php echo site_url('product/product/list')?>",
            data: {checked2 :checked2,id2:id2},
            success: function(response) {
                var response_data = JSON.parse(response);
            }
        });
    }
</script>
<?php $this->load->view('includes/footer'); ?>