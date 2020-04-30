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
                  <span>Customer</span>
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
                              <div class="caption">
                                 <?php //echo "<pre>"; print_r($result['1']); exit; ?>
                                 <?= ucfirst($result['1']->name);?> 
                              </div>
                           </div>
                           <div class="portlet-body">
                              <div class="tab-content">
                                 <div class="tab-pane active" id="portlet_tab_1">
                                    <div class="row">
                                       <div class="col-md-6">
                                          <p>
                                             Email : <?= $result[1]->email; ?><br>
                                             Contact Number : <?= $result[1]->mobile_number; ?><br>
                                             City : <?= $result[1]->city; ?><br>
                                             State : <?= $result[1]->state; ?><br>
                                             Post Code : <?= $result[1]->post_code; ?><br>
                                              Profile :
                                             <?php 
                                                if($result[1]->profile_image=="")
                                                  {
                                                     $image = '<img width="80px" height="40px" src="'.DEFAULT_IMAGE.'">';
                                                  }
                                                  else
                                                  {
                                                     $image = '<a data-fancybox="gallery"  href="'.CUSTOMER_IMG_URL.$result[1]->profile_image.'" >
                                                         <img src="'.CUSTOMER_IMG_URL.$result[1]->profile_image.'"  width="150px" height="150px" alt="">
                                                         </a>';
                                                  }
                                                  echo $image;
                                             ?>
                                            
                                          </p>
                                       </div>
                                        <div class="portlet light bordered">
                                          <div class="portlet-body">
                                             <ul class="nav nav-pills">
                                                <li class="active">
                                                   <a href="#tab_4_1" data-toggle="tab" aria-expanded="true"> Apartment/Villa Society </a>
                                                </li>
                                                <li class="">
                                                   <a href="#tab_4_2" data-toggle="tab" aria-expanded="false"> Independent House </a>
                                                </li>
                                             </ul>
                                             <div class="tab-content">
                                                <div class="tab-pane fade active in" id="tab_4_1">
                                                   <p>
                                                   Flat Villa : <?= $result[1]->flat_villa; ?><br>
                                                   Apartment/Society Name : <?= $result[1]->apartment_society_name; ?><br>
                                                   </p>
                                                </div>
                                                <div class="tab-pane fade" id="tab_4_2">
                                                   <p>
                                                   House : <?= $result[1]->house; ?><br>
                                                   Street Address : <?= $result[1]->street_address; ?><br>
                                                   </p>
                                                </div>
                                               
                                             </div>
                                          </div>
                                       </div>
                                       <div class="col-md-6">
                                          <p>
                                             Locality : <?= $result[1]->locality; ?><br>
                                             Landmark : <?= $result[1]->landmark; ?><br>
                                             Alternate Mobile : <?= $result[1]->alternate_mobile; ?><br>
                                           
                                          </p>
                                            <div class="bs-services divided-bs">
                                                 <iframe src="http://maps.google.com/maps?q=<?=$result[1]->latitude?>,<?= $result[1]->longitude ?>&output=embed" width="100%" height="300" frameborder="0" style="border:0;" allowfullscreen></iframe>                                                  
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