<!-- BEGIN HEADER TOP -->
<div class="page-header-top">
    <div class="container">
        <!-- BEGIN LOGO -->
        <div class="page-logo">
            <a href="#">
                <img class="logo-default" height="50" width="" src="<?php  echo IMG_URL."logo1.png"; ?>" style="" alt="<?php echo APP_NAME; ?>" />

            </a>
        </div>
        <!-- END LOGO -->
        <!-- BEGIN RESPONSIVE MENU TOGGLER -->
        <a href="javascript:;" class="menu-toggler"></a>
        <!-- END RESPONSIVE MENU TOGGLER -->
        <!-- BEGIN TOP NAVIGATION MENU -->
        <div class="top-menu">
            <ul class="nav navbar-nav pull-right">
               
                <!-- BEGIN USER LOGIN DROPDOWN -->
               <li class="dropdown dropdown-user dropdown-dark">
                    <a href="javascript:;" class="dropdown-toggle" data-toggle="dropdown" data-hover="dropdown" data-close-others="true">

                        <img alt="" class="img-circle" src="<?php echo DEFAULT_IMAGE; ?>">
                        <span class="username username-hide-mobile"><?php echo $this->_loginData->name; ?></span>
                    </a>
                    <ul class="dropdown-menu dropdown-menu-default">
                        <!--<li>
                            <a href="<?php /*echo ADMIN_BASE_URL.$this->_loginData->id.'/edit'.EXT; */?>">

                                <i class="icon-user"></i> My Profile </a>
                        </li>
                        <li>
                            <a href="<?php echo ADMIN_BASE_URL. 'change-password'; ?>">
                                <i class="icon-lock"></i> Change Password </a>
                        </li>-->
                        <li>
                            <a href="<?php echo ADMIN_BASE_URL. 'logout'; ?>">
                                <i class="icon-key"></i> Logout </a>
                        </li>
                    </ul>
                </li>
                <!-- END USER LOGIN DROPDOWN -->

            </ul>
        </div>
        <!-- END TOP NAVIGATION MENU -->
    </div>
</div>
<!-- END HEADER TOP -->