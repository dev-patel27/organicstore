<!-- INCLUDE HEADER -->
<?php $this->load->view('includes/header'); ?>
<link media="all" type="text/css" href="http://fonts.googleapis.com/css?family=Open+Sans:400,300,300italic,400italic,600,600italic,700,700italic,800,800italic" rel="stylesheet">
<script src="http://maps.google.com/maps/api/js?sensor=true" type="text/javascript"></script>
<script src="<?=ADMIN_BASE_URL?>assets/js/script.js" type="text/javascript"></script>
<script src="<?=ADMIN_BASE_URL?>assets/js/jquery-migrate.js" type="text/javascript"></script>
<script src="<?=ADMIN_BASE_URL?>assets/js/jquery.js" type="text/javascript"></script>
<script src="<?=ADMIN_BASE_URL?>assets/js/gmaps.js" type="text/javascript"></script>
<script src="<?=ADMIN_BASE_URL?>assets/css/style_google.css" type="text/javascript"></script>
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
                  <!--<a href="<?php echo ADMIN_BASE_URL. 'dashboard'; ?>">Property</a>-->
                  <span>Page</span>
                  <i class="fa fa-circle"></i>
               </li>
               <li>
                  <span>Dashboard</span>
               </li>
            </ul>
         </div>
         <!-- BEGIN PAGE TITLE-->
         <h1 class="page-title">
            Admin Dashboard
            <!-- <small>statistics, charts, recent events and reports</small> -->
         </h1>
         <!-- END PAGE TITLE-->
         <!-- END PAGE HEADER-->
         <!-- BEGIN DASHBOARD STATS 1-->
         <div class="row">
         </div>
         <div class="row">

             <?php
                $customers = $this->admin_model->get_total_customers();
             ?>
             <div class="col-lg-4 col-xs-12 col-sm-12">
               <a href="<?=ADMIN_BASE_URL.'farm/add-farm/list'?>" class="dashboard-stat dashboard-stat-v2 green">
                  <div class="visual">
                     <i class="fa fa-bar-chart-o"></i>
                  </div>
                  <div class="details">
                     <div class="number">
                        <span data-counter="counterup" data-value="0">
                            <i class="fa fa-cart"></i>
                            <?php
                            $total_farm = $this->admin_model->get_total_farm();
                            echo count($total_farm);
                            ?>
                        </span>
                     </div>
                     <div class="desc"> Total Farm </div>
                  </div>
               </a>
            </div>
             <div class="col-lg-4 col-xs-12 col-sm-12">
               <a class="dashboard-stat dashboard-stat-v2 blue">
                  <div class="visual">
                     <!--<i class="fa fa-comments"></i>-->
                     <i class="fa fa-bar-chart-o"></i>
                  </div>
                  <div class="details">
                     <div class="number">
                        <span data-counter="counterup" data-value="0">
                            <i class="fa fa-cart"></i>
                            <?php
                            $today_farm = $this->admin_model->get_today_farm();
                            echo count($today_farm);
                            ?>
                        </span>
                     </div>
                     <div class="desc"> Today Added Farm </div>
                  </div>
               </a>
            </div>
         </div>
       <!--  <div class="row">
             <div class="col-lg-12 col-xs-12 col-sm-12">
                <?php
                    $customers_map = $this->admin_model->get_total_map_customers();
                    //print_r($customers_map); 
                    
                ?>
                <div class="bs-services divided-bs">
                     <iframe src="http://maps.google.com/maps?q=<?=$customers_map->latitude?>,<?= $customers_map->longitude ?>&output=embed" width="100%" height="300" frameborder="0" style="border:0;" allowfullscreen></iframe>                                                  
                 </div>
            </div>
         </div>-->
         <div class="row">
             <div class="col-lg-12 col-xs-12 col-sm-12">
        			<div class="entry-content">
                <div class="desc"> Farm Location Map </div>        
        				<?php /* === THIS IS WHERE WE WILL ADD OUR MAP USING JS ==== */ ?>
        				<div class="google-map-wrap" itemscope itemprop="hasMap" itemtype="">
        					<div id="google-map" class="google-map">
        					</div>
        				</div>
        
        				<?php /* === MAP DATA === */ ?>
        				<?php
        				$d_data = $this->db->select('farm_city,latitude,longitude,COUNT(latitude) as total')
        				                 ->where('status','1')
        				                 ->where('latitude != ','')
                                         ->group_by('latitude')
                                         ->order_by('total','desc')
                                         ->limit(7)
                                         ->get('tbl_farm')
                                         ->result_array();
                        //echo "<pre>"; print_r($d_data); 
        				$locations = array();
        				if(!empty($d_data)){
                            foreach($d_data as $key => $value){
                    				$locations[] = array(
                    					'google_map' => array(
                    						'lat' => $value['latitude'],
                    						'lng' => $value['longitude'],
                    					),
                    					'location_address' => $value['farm_city'],
                    					'location_name'    => $value['farm_city'],
                    				);
                            }
        				}
        
            			/*	$locations[] = array(
            					'google_map' => array(
            						'lat' => '-6.974426',
            						'lng' => '110.38498099999993',
            					),
            					'location_address' => 'Puri Anjasmoro P5/20 Semarang',
            					'location_name'    => 'Loc B',
            				);
            
            				$locations[] = array(
            					'google_map' => array(
            						'lat' => '-7.002475',
            						'lng' => '110.30163800000003',
            					),
            					'location_address' => 'Ngaliyan Semarang',
            					'location_name'    => 'Loc C',
            				);*/
        				?>
        
        
        				<?php /* === PRINT THE JAVASCRIPT === */ ?>
        
        				<?php
        				/* Set Default Map Area Using First Location */
        				$map_area_lat = isset( $locations[0]['google_map']['lat'] ) ? $locations[0]['google_map']['lat'] : '';
        				$map_area_lng = isset( $locations[0]['google_map']['lng'] ) ? $locations[0]['google_map']['lng'] : '';
        				?>
        
        				<script>
        				jQuery( document ).ready( function($) {
        
        					/* Do not drag on mobile. */
        					var is_touch_device = 'ontouchstart' in document.documentElement;
        
        					var map = new GMaps({
        						el: '#google-map',
        						lat: '<?php echo $map_area_lat; ?>',
        						lng: '<?php echo $map_area_lng; ?>',
        						scrollwheel: false,
        						draggable: ! is_touch_device
        					});
        
        					/* Map Bound */
        					var bounds = [];
        
        					<?php /* For Each Location Create a Marker. */
        					foreach( $locations as $location ){
        						$name = $location['location_name'];
        						$addr = $location['location_address'];
        						$map_lat = $location['google_map']['lat'];
        						$map_lng = $location['google_map']['lng'];
        						?>
        						/* Set Bound Marker */
        						var latlng = new google.maps.LatLng(<?php echo $map_lat; ?>, <?php echo $map_lng; ?>);
        						bounds.push(latlng);
        						/* Add Marker */
        						map.addMarker({
        							lat: <?php echo $map_lat; ?>,
        							lng: <?php echo $map_lng; ?>,
        							title: '<?php echo $name; ?>',
        							infoWindow: {
        								content: '<p><?php echo $name; ?></p>'
        							}
        						});
        					<?php } //end foreach locations ?>
        
        					/* Fit All Marker to map */
        					map.fitLatLngBounds(bounds);
        
        					/* Make Map Responsive */
        					var $window = $(window);
        					function mapWidth() {
        						var size = $('.google-map-wrap').width();
        						$('.google-map').css({width: size + 'px', height: (size/2) + 'px'});
        					}
        					mapWidth();
        					$(window).resize(mapWidth);
        
        				});
        				</script>
        
        				<!--<div class="map-list">
        
        					<h3><span>View in Google Map</span></h3>
        
        					<ul class="google-map-list" itemscope itemprop="hasMap" itemtype="http://schema.org/Map">
        
        						<?php foreach( $locations as $location ){
        							$name = $location['location_name'];
        							$addr = $location['location_address'];
        							$map_lat = $location['google_map']['lat'];
        							$map_lng = $location['google_map']['lng'];
        							?>
        							<li>
        								<a target="_blank" itemprop="url" href="<?php echo 'http://www.google.com/maps/place/' . $map_lat . ',' . $map_lng;?>"><?php echo $name; ?></a>
        								<span itemprop="address" itemscope itemtype="http://schema.org/PostalAddress"><?php echo $addr; ?></span>
        							</li>
        						
        						<?php } //end foreach ?>
        
        					</ul>
        				</div>-->

    			     </div>
			     </div>
         </div>

         <div class="clearfix"></div>

      </div>
   </div>
   <a href="javascript:;" class="page-quick-sidebar-toggler"><i class="icon-login"></i></a>
</div>
<!-- End Hotline Content -->
<!-- INCLUDE FOOTER -->
<?php $this->load->view('includes/inner_footer'); ?>
<?php $this->load->view('includes/list_js'); ?>
<?php $this->load->view('includes/footer'); ?>
<!-- <script type="text/javascript" src="<?= BASE_URL ?>assets/js/Chart.bundle.js"></script>
   <script type="text/javascript" src="<?= BASE_URL ?>assets/js/Chart.js"></script> -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.7.2/Chart.bundle.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.7.2/Chart.js"></script>
<script>
   var ctx = document.getElementById("myChart").getContext("2d");
   var gender = ['Men', 'Women', 'Boys', 'Girls', 'Kids', 'Old Age'];
   var myChart = new Chart(ctx, {
           type: 'bar',
           data: {
                 labels: ["Red", "Blue", "Yellow", "Green", "Purple", "Orange"],
                 // labels: gender,
                 datasets: [{
                       label: '# of Votes',
                       data: [12, 19, 3, 5, 2, 3],
                       backgroundColor: ["red", "blue", "yellow", "green", "purple", "orange"]
                            }]
                 },
           options: {
           scales: {
                 yAxes: [{
                       ticks: {
                            beginAtZero:true
                              }
                         }]
                   }
          }
      });
</script>