<?php
defined('BASEPATH') or exit('No direct script access allowed');

$route['default_controller'] = 'authentication/login';
$route['404_override'] = '';
$route['translate_uri_dashes'] = false;

/**
 *
 * Authentication Url Routing
 */
$route['x/login'] = "authentication/login";
$route['invr'] = "authentication/login"; /* ### Admin Login */
$route['x'] = "authentication/login"; /* ### Admin Login */
$route['login'] = "authentication/login"; /* ### Admin Login */
//$route['x/(:any)/reset-password'] = "authentication/reset/$1";  /* ### Admin reset password */
$route['x/forgot-password'] = "authentication/forgot"; /* ### forgot password admin by id */
$route['change-store'] = "x/change_store";

/**
 *
 * Admin Url Routing
 */
$route['dashboard'] = "welcome"; /* ### Admin Change Password */
$route['x/change-password'] = "x/change_password"; /* ### Admin Change Password */
$route['logout'] = "x/logout"; /* ### Admin Logout */
$route['x/(:num)/edit'] = "x/update/$1"; /* ### Update admin by id */

/**
 *
 * Page Url Routing
 */

$route['page/list'] = "page/lists"; /* ### Proparty List */
$route['page/add'] = "page/post"; /* ### Proparty List */
$route['page/(:num)/edit'] = "page/update/$1"; /* ### Update Proparty by id */
$route['page/(:num)/delete'] = "page/delete/$1"; /* ### Delete Proparty by id */
$route['page'] = "ajax/getPage"; /* ### Proparty List */

/**
 *
 * Webconfig Url Routing
 */
$route['web-setting/list'] = "web_setting/lists";
$route['web-setting/add'] = "web_setting/post";
$route['web-setting/(:num)/edit'] = "web_setting/update/$1";
$route['web-setting/(:num)/delete'] = "web_setting/delete/$1";
$route['web-setting'] = "Admin/ajax/getWebsetting";

/*faq details*/
$route['faq/add-faq/list'] = "Faq/faq_lists";
$route['faq/add-faq/add'] = "Faq/faq_post";
$route['faq/add-faq/(:num)/edit'] = "Faq/faq_update/$1";
$route['faq/add-faq/(:num)/delete'] = "Faq/faq_delete/$1";
$route['faq/add-faq/(:num)/view'] = "Faq/faq_view/$1";
$route['faq/add-faq'] = "ajax/getFaq";

/**
T&C (terms and conditions)
 **/
$route['tc/tc/list'] = "tc/tc_lists";
$route['tc/tc/add'] = "tc/tc_post";
$route['tc/tc/(:num)/edit'] = "tc/tc_update/$1";
$route['tc/tc/(:num)/delete'] = "tc/tc_delete/$1";
$route['tc/tc/(:num)/view'] = "tc/tc_view/$1";
$route['tc/tc'] = "ajax/getTc";

/**
Product
 */
$route['product/product/list'] = "product/product_lists";
$route['product/product/add'] = "product/product_post";
$route['product/product/(:num)/edit'] = "product/product_update/$1";
$route['product/product/(:num)/delete'] = "product/product_delete/$1";
$route['product/product/(:num)/view'] = "product/product_view/$1";
$route['product/product'] = "ajax/getProduct";
$route['product/subcategory'] = "product/getProduct_subcategory";

/**
Gallery
 */
$route['product/product/(:num)/gallery/list'] = "gallery/gallery_lists/$1";
$route['product/product/(:num)/gallery/add'] = "gallery/gallery_post/$1";
$route['product/product/(:num)/gallery/(:num)/edit'] = "gallery/gallery_update/$1/$2";
$route['product/product/(:num)/gallery/(:num)/delete'] = "gallery/gallery_delete/$1/$2";
$route['gallery/gallery/(:num)'] = "ajax/getGallery/$1";

/**
Product Category
 */
$route['product/category/list'] = "product/product_category_lists";
$route['product/category/add'] = "product/product_category_post";
$route['product/category/(:num)/edit'] = "product/product_category_update/$1";
$route['product/category/(:num)/delete'] = "product/product_category_delete/$1";
$route['product/category/(:num)/view'] = "product/product_category_view/$1";
$route['product/category'] = "ajax/getProduct_Category";

/**
Product Sub Category
 */
$route['product/sub-category/list'] = "product/product_subcategory_lists";
$route['product/sub-category/add'] = "product/product_subcategory_post";
$route['product/sub-category/(:num)/edit'] = "product/product_subcategory_update/$1";
$route['product/sub-category/(:num)/delete'] = "product/product_subcategory_delete/$1";
$route['product/sub-category/(:num)/view'] = "product/product_subcategory_view/$1";
$route['product/sub-category'] = "ajax/getProduct_SubCategory";

$route['product/tag/list'] = "product/tag_lists";
$route['product/tag/add'] = "product/tag_post";
$route['product/tag/(:num)/edit'] = "product/tag_update/$1";
$route['product/tag/(:num)/delete'] = "product/tag_delete/$1";
$route['product/tag'] = "ajax/getTag";

$route['product/coupon-code/list'] = "product/couponcode_lists";
$route['product/coupon-code/add'] = "product/couponcode_post";
$route['product/coupon-code/(:num)/edit'] = "product/couponcode_update/$1";
$route['product/coupon-code/(:num)/delete'] = "product/couponcode_delete/$1";
$route['product/coupon-code'] = "ajax/getCoupon_code";

/*customers details*/
$route['customers/customer-details/list'] = "customers/customer_details_lists";
$route['customers/customer-details/add'] = "customers/customer_details_post";
$route['customers/customer-details/(:num)/edit'] = "customers/customer_details_update/$1";
$route['customers/customer-details/(:num)/delete'] = "customers/customer_details_delete/$1";
$route['customers/customer-details/(:num)/view'] = "customers/customer_details_view/$1";
$route['customers/customer-details'] = "ajax/getCustomer_details";

/*customers details*/
$route['customers/general-notification/list'] = "customers/general_notification_list";
$route['customers/general-notification/add'] = "customers/general_notification_post";

/**
Order list
 */
$route['order-list/order-list/list'] = "order_list/order_lists";
$route['order-list/order-list/(:num)/view'] = "order_list/order_list_view/$1";
$route['order-list/order-list'] = "ajax/getOrder_list";

/**
About US
 */
$route['about-us/about-us/list'] = "about_us/about_us_lists";
$route['about-us/about-us/add'] = "about_us/about_us_post";
$route['about-us/about-us/(:num)/edit'] = "about_us/about_us_update/$1";
$route['about-us/about-us/(:num)/delete'] = "about_us/about_us_delete/$1";
$route['about-us/about-us/(:num)/view'] = "about_us/about_us_view/$1";
$route['about-us/about-us'] = "ajax/getAbout_us";

$route['about-us/counter/list'] = "about_us/counter_lists";
$route['about-us/counter/add'] = "about_us/counter_post";
$route['about-us/counter/(:num)/edit'] = "about_us/counter_update/$1";
$route['about-us/counter/(:num)/delete'] = "about_us/counter_delete/$1";
$route['about-us/counter/(:num)/view'] = "about_us/counter_view/$1";
$route['about-us/counter'] = "ajax/getCounter";

$route['about-us/why-choose-us/list'] = "about_us/why_choose_us_lists";
$route['about-us/why-choose-us/add'] = "about_us/why_choose_us_post";
$route['about-us/why-choose-us/(:num)/edit'] = "about_us/why_choose_us_update/$1";
$route['about-us/why-choose-us/(:num)/delete'] = "about_us/why_choose_us_delete/$1";
$route['about-us/why-choose-us/(:num)/view'] = "about_us/why_choose_us_view/$1";
$route['about-us/why-choose-us'] = "ajax/getWhy_choose_us";
/**
end of about us
 */

/**
Newsletters Module*/
$route['newsletters/subscriber/list'] = "newsletters/n_subscriber_lists";
$route['newsletters/subscriber/(:num)/delete'] = "newsletters/n_subscriber_delete/$1";
$route['newsletters/subscriber'] = "ajax/getNewsletters";

/**
 *
 * slider Url Routing
 */
$route['slider/slider-image/list'] = "slider/slider_image_lists";
$route['slider/slider-image/add'] = "slider/slider_image_post";
$route['slider/slider-image/(:num)/edit'] = "slider/slider_image_update/$1";
$route['slider/slider-image/(:num)/delete'] = "slider/slider_image_delete/$1";
$route['slider/slider-image'] = "ajax/getSliderimage";

/**
 *
 * Promotion
 */
$route['promotion/promotion/list'] = "Promotion/promotion_lists";
$route['promotion/promotion/add'] = "Promotion/promotion_post";
$route['promotion/promotion/(:num)/edit'] = "Promotion/promotion_update/$1";
$route['promotion/promotion/(:num)/delete'] = "Promotion/promotion_delete/$1";
$route['promotion/promotion'] = "ajax/get_promotion";

/**
Contact
 */
$route['contact-us/contact-us/list'] = "contact_us/contact_us_lists";
$route['contact-us/contact-us/(:num)/delete'] = "contact_us/contact_us_delete/$1";
$route['contact-us/contact-us/(:num)/view'] = "contact_us/contact_us_view/$1";
$route['contact-us/contact-us'] = "ajax/getContact_us";

/**
 *
 * Module Category Url Routing
 */

$route['module_category/list'] = "module_category/lists";
$route['module_category/add'] = "module_category/post";
$route['module_category/(:num)/edit'] = "module_category/update/$1";
$route['module_category/(:num)/delete'] = "module_category/delete/$1";
$route['module_category/(:num)/inactive'] = "module_category/inactive/$1";
$route['module_category/(:num)/active'] = "module_category/active/$1";
$route['module_category'] = "ajax/getModule_category";

/**
 *
 * Module Category Url Routing
 */

$route['module_subcategory/list'] = "module_subcategory/lists";
$route['module_subcategory/add'] = "module_subcategory/post";
$route['module_subcategory/(:num)/edit'] = "module_subcategory/update/$1";
$route['module_subcategory/(:num)/delete'] = "module_subcategory/delete/$1";
$route['module_subcategory/(:num)/inactive'] = "module_subcategory/inactive/$1";
$route['module_subcategory/(:num)/active'] = "module_subcategory/active/$1";
$route['module_subcategory'] = "ajax/getModule_subcategory";

/**
 *
 * Role Url Routing
 */

$route['role_category/list'] = "role_category/lists";
$route['role_category/add'] = "role_category/post";
$route['role_category/(:num)/edit'] = "role_category/update/$1";
$route['role_category/(:num)/delete'] = "role_category/delete/$1";
$route['role_category/(:num)/inactive'] = "role_category/inactive/$1";
$route['role_category/(:num)/active'] = "role_category/active/$1";
$route['role_category'] = "ajax/getRole_category";

/**
 *
 * Role Url Routing
 */

$route['role/list'] = "role/lists";
$route['role/add'] = "role/post";
/*$route['role/edit'] = "role/update"; */
$route['role/(:num)/delete'] = "role/delete/$1";
$route['role/(:num)/edit'] = "role/update/$1";
$route['role/(:num)/inactive'] = "role/inactive/$1";
$route['role/(:num)/active'] = "role/active/$1";
$route['role'] = "ajax/getRole";
$route['role/get_sub_module'] = "role/get_sub_module";

/**
 *
 * Role Url Routing
 */

$route['module/module-category/list'] = "module_category/lists";
$route['module/module-category/add'] = "module_category/post";
$route['module/module-category/(:num)/edit'] = "module_category/update/$1";
$route['module/module-category/(:num)/delete'] = "module_category/delete/$1";
$route['module/module-category/(:num)/inactive'] = "module_category/inactive/$1";
$route['module/module-category/(:num)/active'] = "module_category/active/$1";
$route['module_category'] = "ajax/getModule_category";

/**
 *
 * Role Url Routing
 */

$route['role_permission/list'] = "role_permission/lists";
$route['role_permission/add'] = "role_permission/post";
$route['role_permission/(:num)/edit'] = "role_permission/update/$1";
$route['role_permission/(:num)/delete'] = "role_permission/delete/$1";
$route['role_permission/(:num)/inactive'] = "role_permission/inactive/$1";
$route['role_permission/(:num)/active'] = "role_permission/active/$1";
$route['role_permission'] = "ajax/getRole_permission";

/*   API Url routing   */

$route['v1/api/user-register'] = "api/user_register";
$route['v1/api/user-login'] = "api/user_login";
$route['v1/api/user-logout'] = "api/user_logout";

$route['v1/api/get-profile'] = "api/get_profile";
$route['v1/api/edit-profile'] = "api/edit_profile";
$route['v1/api/forgot-password'] = "api/forgot_password";
$route['v1/api/change-password'] = "api/change_password";
$route['v1/api/get-farm'] = "api/get_farm";
$route['v1/api/get-farm-by-id'] = "api/get_farm_by_id";
$route['v1/api/edit-address'] = "api/edit_Address";
$route['v1/api/get-faq'] = "api/get_faq";
$route['v1/api/get-app-data'] = "api/get_app_data";
$route['v1/api/edit-pincode'] = "api/edit_pincode";
$route['v1/api/get-plants-by-cat-id'] = "api/get_plants_by_cat_id";
$route['v1/api/get-plants-count-by-cat-id'] = "api/get_plants_count_by_cat_id";
$route['v1/api/confirm-payment'] = "api/confirm_payment";
$route['v1/api/get-city'] = "api/get_city";
$route['v1/api/get-city-by-farm'] = "api/get_city_by_farm";

$route['v1/api/get-plants-by-cat'] = "api/get_plants_by_cat";
$route['v1/api/get-farm-by-user-id'] = "api/get_farm_by_user_id";
$route['v1/api/get-visit-time'] = "api/get_visit_time";
$route['v1/api/add-visit-request'] = "api/add_visit_request";
$route['v1/api/confirm-plants'] = "api/confirm_plants";
$route['v1/api/get-confirm-farm-plants'] = "api/get_confirm_farm_plants";

$route['v1/api/get-user-farm'] = "api/get_user_farm";
$route['v1/api/get-user-farm-by-plants'] = "api/get_user_farm_by_plants";
$route['v1/api/get-farm-mapping-plants'] = "api/get_farm_mapping_plants";
$route['v1/api/post-plants-rating'] = "api/post_plants_rating";

$route['v1/api/app-token'] = "api/app_token";
$route['v1/api/check-login'] = "api/check_login";

$route['v1/api/country'] = "api/get_country";
