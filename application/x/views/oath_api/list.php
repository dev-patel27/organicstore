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
                  <span>API</span>
                  <i class="fa fa-circle"></i>
               </li>
               <li>
                  <span>list</span>
               </li>
            </ul>
            <div class="page-toolbar">
               <div class="btn-group">
                  <button type="button" class="btn blue" onclick="location.href = 'add';" >Add New API</button>
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
                           <label>Store Name</label>
                           <div class="input-group">
                              <input type="text" placeholder="State Name" class="form-control form-filter" name="store_name">
                           </div>
                        </div>
<!-- 
                        <div class=" col-md-3">
                           <label>Email</label>
                           <div class="input-group">
                              <input type="email" placeholder="Email" class="form-control form-filter" name="storeuser_email">
                           </div>
                        </div> -->

                        <!--  <div class=" col-md-3">
                           <label>Title</label>
                           <div class="input-group">
                              <input type="text" placeholder="Title" class="form-control form-filter" name="title">
                           </div>
                           </div> -->
       <!--                  <div class=" col-md-3">
                           <label>Script Date</label>
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
                        </div> -->
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
                                <!--  <th width="1%">Date</th> -->
                                 <th width="2%">Store</th>
                                 <th width="2%">Facebook API</th>
                                 <th width="2%">Google API</th>
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
       TableDatatablesAjax.init('datatable_ajax', '<?php echo ADMIN_BASE_URL .'configurations/oauth-api'; ?>');
   
   });
</script>
<script type="text/javascript">
    //fix menu overflow under the responsive table 
    // hide menu on click... (This is a must because when we open a menu )
    $(document).click(function (event) {
        //hide all our dropdowns
        $('.dropdown-menu[data-parent]').hide();

    });
    $(document).on('click', '.table-striped [data-toggle="dropdown"]', function () {
        // if the button is inside a modal
        /*if ($('body').hasClass('modal-open')) {
            throw new Error("This solution is not working inside a responsive table inside a modal, you need to find out a way to calculate the modal Z-index and add it to the element")
            return true;
        }*/
        $buttonGroup = $(this).parent();
        if (!$buttonGroup.attr('data-attachedUl')) {
            var ts = +new Date;
            $ul = $(this).siblings('ul');
            $ul.attr('data-parent', ts);
            $buttonGroup.attr('data-attachedUl', ts);
            $(window).resize(function () {
                $ul.css('display', 'none').data('top');
            });
        } else {
            $ul = $('[data-parent=' + $buttonGroup.attr('data-attachedUl') + ']');
        }
        if (!$buttonGroup.hasClass('open')) {
            $ul.css('display', 'none');
            return;
        }
        dropDownFixPosition($(this).parent(), $ul);
        function dropDownFixPosition(button, dropdown) {
            var dropDownTop = button.offset().top + button.outerHeight();
            dropdown.css('top', dropDownTop + "px");
            dropdown.css('left', button.offset().left + "px");
            dropdown.css('position', "absolute");
            dropdown.css('width', dropdown.width());
            dropdown.css('heigt', dropdown.height());
            dropdown.css('display', 'block');
            dropdown.appendTo('body');
        }
    });
</script>                  
    

<?php $this->load->view('includes/footer'); ?>