<!-- BEGIN HEADER MENU -->
<div class="page-header-menu">
    <div class="container">

        <?php
        //print_r($this->uri->segment(2));
        $url_encode = $this->uri->segment(2);
        $p_active = '';
        $u_active = '';
        $pa_active = '';
        $s_active = '';
        $d_active = '';
        $h_active = '';
        
        if ($url_encode == 'page' || $url_encode == 'page') {
            $u_active = 'active';
        }
        elseif ($url_encode == 'dashboard' || $url_encode == '') {
            $d_active = 'active';
        }
        //echo $active;
        ?>

        <!-- BEGIN MEGA MENU -->
        <!-- DOC: Apply "hor-menu-light" class after the "hor-menu" class below to have a horizontal menu with white background -->
        <!-- DOC: Remove data-hover="dropdown" and data-close-others="true" attributes below to disable the dropdown opening on mouse hover -->
        <div class="hor-menu  ">
            <ul class="nav navbar-nav">
                <li class="menu-dropdown classic-menu-dropdown <?php echo $d_active;  ?>">
                    <a href="<?php echo ADMIN_BASE_URL. 'dashboard'; ?>"> Home </a>
                </li>
                
                <li class="menu-dropdown classic-menu-dropdown <?php echo $u_active;  ?>">
                    <a href="javascript:"> Proparty </a>
                    <ul class="dropdown-menu pull-left">
						<li class=" ">
						    <a href="<?php echo site_url(). '/x/proparty_type/list'; ?>" class="nav-link nav-toggle ">
                                <i class="icon-sidebar-toggler"></i> View Proparty Type
                                <span class="arrow"></span>
                            </a>
                        </li>
						<li class=" ">
						    <a href="<?php echo site_url(). '/x/proparty_type/add'; ?>" class="nav-link nav-toggle ">
                                <i class="icon-settings"></i> Add Proparty Type
                                <span class="arrow"></span>
                            </a>
                        </li>
                        <li class=" ">
						    <a href="<?php echo site_url(). '/x/proparty/list'; ?>" class="nav-link nav-toggle ">
                                <i class="icon-settings"></i> View Proparty
                                <span class="arrow"></span>
                            </a>
                        </li>
                        <li class=" ">
                            <a href="<?php echo site_url(). '/x/proparty/add'; ?>" class="nav-link nav-toggle ">
                                <i class="icon-settings"></i> Add Proparty
                                <span class="arrow"></span>
                            </a>
                        </li>
                    </ul>
                </li>
            </ul>
            </li>
            </ul>
        </div>
        <!-- END MEGA MENU -->
    </div>
</div>
<!-- END HEADER MENU -->
