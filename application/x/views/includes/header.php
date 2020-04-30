<!DOCTYPE html>
<!--[if IE 8]> <html lang="en" class="ie8 no-js"> <![endif]-->
<!--[if IE 9]> <html lang="en" class="ie9 no-js"> <![endif]-->
<!--[if !IE]><!-->
<html lang="en">
<!--<![endif]-->
<!-- BEGIN HEAD -->
<head>
    <meta charset="utf-8" />
    <title><?php echo $page['page_title']; ?></title>
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta content="width=device-width, initial-scale=1" name="viewport" />
    <meta content="" name="description" />
    <meta content="" name="author" />

<link href="http://fonts.googleapis.com/css?family=Open+Sans:400,300,600,700&subset=all" rel="stylesheet" type="text/css" />
    <?php
        $this->load->view('includes/'.$page['css']);
        echo $this->headerlib->put_headers_css( );

        $default_css = array(
            'bootstrap-wysihtml5/bootstrap-wysihtml5.css',
            'css/layout/layout.min.css',
            'css/layout/default.min.css',
            'css/layout/custom.min.css'
        );
        echo $this->headerlib->put_css( $default_css );
    ?>

<link rel="shortcut icon" href= "<?php echo BASE_URL; ?>assets/images/logo.png" />
</head>

<!-- END HEAD -->

<body class="page-header-fixed page-sidebar-closed-hide-logo page-content-white 
<?php
$segment = $this->uri->segment(1);
if(($segment=='tradesheet') OR ($segment=='chartsheet')) { echo 'page-sidebar-closed';}
?>
">

 <div class="page-wrapper">

<!-- BEGIN HEADER -->
   <div class="page-header navbar navbar-fixed-top" style="background: linear-gradient(90deg, rgba(204, 217, 178, 1) 0%, rgba(57, 107, 52, 1) 100%) !important;">
                <!-- BEGIN HEADER INNER -->
                <div class="page-header-inner ">
                    <!-- BEGIN LOGO -->
                    <div class="page-logo">
                        <a href="<?= ADMIN_BASE_URL ?>" style="text-decoration:  none;padding: 5px 0;">
                        <img src="<?= IMG_URL.'logo.png' ?>" style="width: 49px;margin: 0px 0;height: auto;" >
                        </a>
                        <div class="menu-toggler sidebar-toggler">
                            <span></span>
                        </div>
                    </div>
                    <!-- END LOGO -->
                    <!-- BEGIN RESPONSIVE MENU TOGGLER -->
                    <a href="javascript:;" class="menu-toggler responsive-toggler" data-toggle="collapse" data-target=".navbar-collapse">
                        <span></span>
                    </a>
					
                    <!-- END RESPONSIVE MENU TOGGLER -->
                    <!-- BEGIN TOP NAVIGATION MENU -->
                    <div class="top-menu">
                        <ul class="nav navbar-nav pull-right">
                            <?php
                                  
                           if($this->_type == 'user')
                           {
                               //$ass_stores = $this->_loginData->assigned_stores; 
                               //$ex_store =  explode(',',$this->_loginData->assigned_stores);
                               
                               $ex_store = $this->admin_model->get_users_stores($this->_loginData->storeuser_id);
                               
                               $sel_store =  $this->_loginData->active_store;
                               
                               $multiple_role = $this->admin_model->get_user_multiple_role($this->_loginData->storeuser_id ,$sel_store);
                               $store_drop = count($multiple_role);
                              
                               
                           
                           echo '
                          
                           <li class="dropdown dropdown-user">
                               <form action="'.site_url('change-store').'" method="POST">
                               <select class="table-group-action-input form-control input-inline input-small input-sm" style="margin-top: 10px;margin-left:5px;" onchange="this.form.submit()" name="store_id">';
                               echo '<option value="0" >Select Store</option>';
                               foreach ($ex_store as $key => $value) {
                                   
                                   //$get_store = $this->admin_model->get_store_by_id($value);
                                   $sel = ($sel_store==$value['store_id']) ? 'selected' : '';
                                   echo '<option value="'.$value['store_id'].'" '.$sel.'>'.$value['store_name'].'</option>';
                               }

                            echo '
                                 
                               </select>';
                            if($store_drop > 1)
                            {
                               echo'
                               <select class="table-group-action-input form-control input-inline input-small input-sm" style="margin-top: 10px;margin-left:5px;" onchange="this.form.submit()" name="role_id" >';
                               echo '<option value="0" >Select Role</option>';
                               foreach ($multiple_role as $key => $value) {
                                   $sel_role = $this->_loginData->storeuser_role;
                                   $sel = ($sel_role==$value['role_permission_id']) ? 'selected' : '';
                                   echo '<option value="'.$value['role_permission_id'].'" '.$sel.'>'.$value['role_name'].'</option>';
                               }

                                echo '</select>';
                                
                            }   
                            echo '</form>';
                            echo '</li>';

                           }

                           ?>
                            <!-- BEGIN USER LOGIN DROPDOWN -->
                            <!-- DOC: Apply "dropdown-dark" class after below "dropdown-extended" to change the dropdown styte -->
                            <li class="dropdown dropdown-user">
                                <a href="<?php echo ADMIN_BASE_URL. 'logout'; ?>" class="dropdown-toggle">
                                    <!-- <img alt="" class="img-circle" src="<?php  echo IMG_URL.$this->_loginData->image; ?>"><?php  //echo DEFAULT_IMAGE; ?> -->
                                    <span class="username username-hide-on-mobile" style="color: #fff;font-weight: bold;">
                                    <?php
                                   
                                    if($this->_type == 'user')
                                    {
                                        echo $this->_loginData->storeuser_fname. ' '.$this->_loginData->storeuser_lname; 
                                    }
                                    else
                                    {
                                        echo $this->_loginData->name;
                                    }
                                    ?>


                                    </span> 
                                    <i class="fa fa-power-off" aria-hidden="true" style="margin-right: 6px;color: #fff;font-weight: bold;"></i>

                                </a>
                               <!--  <ul class="dropdown-menu dropdown-menu-default">
                                    <li>
                                        <a href="<?php echo ADMIN_BASE_URL. 'logout'; ?>">
                                            <i class="icon-key"></i> Log Out </a>
                                    </li>
                                </ul> -->
                            </li>
                            <!-- END USER LOGIN DROPDOWN -->

                            <!-- END QUICK SIDEBAR TOGGLER -->
                        </ul>
                    </div>
                    <!-- END TOP NAVIGATION MENU -->
                </div>
                <!-- END HEADER INNER -->
            </div>
    

<!-- END HEADER -->

<div class="clearfix"> </div>

