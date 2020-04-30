            <div class="page-sidebar-wrapper">
                    <!-- BEGIN SIDEBAR -->
                    <!-- DOC: Set data-auto-scroll="false" to disable the sidebar from auto scrolling/focusing -->
                    <!-- DOC: Change data-auto-speed="200" to adjust the sub menu slide up/down speed -->
                    <div class="page-sidebar navbar-collapse collapse" >
					
                        <ul class="page-sidebar-menu  page-header-fixed
                        " data-keep-expanded="false" data-auto-scroll="true" data-slide-speed="200" style="padding-top: 20px">
                            <!-- DOC: To remove the sidebar toggler from the sidebar you just need to completely remove the below "sidebar-toggler-wrapper" LI element -->
                            <!-- BEGIN SIDEBAR TOGGLER BUTTON -->
                            <li class="sidebar-toggler-wrapper hide">
                                <div class="sidebar-toggler">
                                    <span></span>
                                </div>
                            </li>
                            <li class="nav-item">
                                <a href="<?php echo ADMIN_BASE_URL. 'dashboard'; ?>" class="nav-link ">
                                    <i class="icon-home"></i>
                                    <span class="title">Dashboard</span>
                                    <span class="selected"></span>
                                </a>
                            </li>

                            <?php
                              
                                $role_id = $this->_loginData->role_id;
                              if($role_id != '1')
                              {
                                  $module_array = $this->admin_model->get_sidebar_module_by_role_id($role_id);
                                  //echo "<pre>"; print_r($module_array); exit;
                                  if(!empty($module_array))
                                  {
                                      foreach ($module_array as $row) {
                                          
                                        echo '
                                          <li class="nav-item">
                                              <a href="javascript:;" class="nav-link nav-toggle">
                                                      <i class="icon-puzzle"></i>
                                                      <span class="title">'.$row['module_name'].'</span>
                                                      <span class="arrow"></span>
                                              </a>
                                              <ul class="sub-menu" style="display: none;">';

                                              $sub_module_array = $this->admin_model->get_sub_module( $row['module_id']);
                                              foreach ($sub_module_array as $row_sub) {
                                              
                                              $url = site_url(strtolower(url_title($row['module_name'])).'/'.url_title(strtolower($row_sub['sub_module_name'])).'/list');

                                              echo '
                                                    <li class="nav-item">
                                                        <a href="'.$url.'" class="nav-link">
                                                          <span class="title">'.$row_sub['sub_module_name'].'</span>
                                                        </a>
                                                    </li>';
                                              }
                                        echo '
                                              </ul>
                                          </li>';
                                      }
                                  }
                              }else{
                                
                                $module_array = $this->admin_model->get_module_category();
                                if(!empty($module_array))
                                {
                                    foreach ($module_array as $row) {
                                        
                                      echo '
                                        <li class="nav-item">
                                            <a href="javascript:;" class="nav-link nav-toggle">
                                                    <i class="icon-puzzle"></i>
                                                    <span class="title">'.$row['module_name'].'</span>
                                                    <span class="arrow"></span>
                                            </a>
                                            <ul class="sub-menu" style="display: none;">';

                                            $sub_module_array = $this->admin_model->get_sub_module($row['id']);
                                            foreach ($sub_module_array as $row_sub) {
                                            
                                            $url = site_url(url_title(strtolower($row['module_name'])).'/'.url_title(strtolower($row_sub['sub_module_name'])).'/list');

                                            echo '
                                                  <li class="nav-item">
                                                      <a href="'.$url.'" class="nav-link">
                                                        <span class="title">'.$row_sub['sub_module_name'].'</span>
                                                      </a>
                                                  </li>';
                                            }
                                      echo '
                                            </ul>
                                        </li>';
                                    }
                                }

                              }
                            
                            ?>


                            <!--
                            <li class="nav-item">
                                        <a href="<?= ADMIN_BASE_URL. 'client_data/1/edit'; ?>" class="nav-link ">
                                            <i class="icon-user"></i>
                                            <span class="title">Client Data</span>
                                            <span class="selected"></span>
                                        </a>
                            </li>-->
                            
                            <!-- <li class="nav-item">
                                <div class="logo">
                                    <img height="95" width="190" src="<?php  echo IMG_URL."sltl-logo.png"; ?>" style="" alt="<?php echo APP_NAME; ?>" />
                                </div>
                            </li> -->
                            <?php
                            if($role_id == '1') {?>
                            <li class="nav-item  ">
                                <a href="javascript:;" class="nav-link nav-toggle">
                                <i class="icon-puzzle"></i>
                                <span class="title">Module</span>
                                <span class="arrow"></span>
                                </a>
                                <ul class="sub-menu">
                                   <li class="nav-item">
                                      <a href="<?= ADMIN_BASE_URL. 'module_category/list'; ?>" class="nav-link">
                                      <span class="title">Module Category</span>
                                      </a>
                                   </li>

                                    <li class="nav-item">
                                      <a href="<?= ADMIN_BASE_URL. 'module_subcategory/list'; ?>" class="nav-link">
                                      <span class="title">Module Subcategory</span>
                                      </a>
                                   </li>
                                  <li class="nav-item">
                                     <a href="<?= ADMIN_BASE_URL. 'role_permission/list'; ?>" class="nav-link">
                                     <span class="title">Role Permission</span>
                                     </a>
                                  </li>


                                </ul>
                             </li>
                              <li class="nav-item">
                                          <a href="<?= ADMIN_BASE_URL. 'web-setting/1/edit'; ?>" class="nav-link ">
                                              <i class="icon-settings"></i>
                                              <span class="title">Web Setting</span>
                                              <span class="selected"></span>
                                          </a>
                              </li>
                             <?php } ?>

                            <?php
                            if($this->_type == 'user') {?>
                            <li class="nav-item  ">
                                <a href="javascript:;" class="nav-link nav-toggle">
                                <i class="icon-puzzle"></i>
                                <span class="title">Setting</span>
                                <span class="arrow"></span>
                                </a>
                                <ul class="sub-menu">
                                   <li class="nav-item">
                                      <a href="<?= ADMIN_BASE_URL. 'setting/profile/edit'; ?>" class="nav-link">
                                      <span class="title">Profile</span>
                                      </a>
                                   </li>
                                </ul>
                             </li>
                             <?php } ?>
                           
						</ul>
                        <!-- END SIDEBAR MENU -->
                        <!-- END SIDEBAR MENU -->
                    </div>
                    <!-- END SIDEBAR -->
                </div>