<!-- INCLUDE HEADER -->
<?php $this->load->view('includes/header');?>
<script src="//code.jquery.com/jquery-3.2.1.min.js"></script>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/fancybox/3.2.5/jquery.fancybox.min.css" />
<script src="https://cdnjs.cloudflare.com/ajax/libs/fancybox/3.2.5/jquery.fancybox.min.js"></script>
<!--<script src="https://maps.googleapis.com/maps/api/js?libraries=places&key=AIzaSyBRg1G7tw3fW4CTKXE1rmXxf4A-lhlQgRU"></script>-->
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
         <!-- BEGIN PAGE BAR -->
         <div class="page-bar">
            <ul class="page-breadcrumb">
               <li>
                  <span>Faq</span>
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
                                             Question : <?= $result[1]->question; ?><br>
                                             Answer : <?= $result[1]->answer; ?><br>
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