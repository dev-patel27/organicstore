<?php
defined('BASEPATH') or exit('No direct script access allowed');

/*
| -------------------------------------------------------------------------
| URI ROUTING
| -------------------------------------------------------------------------
| This file lets you re-map URI requests to specific controller functions.
|
| Typically there is a one-to-one relationship between a URL string
| and its corresponding controller class/method. The segments in a
| URL normally follow this pattern:
|
|    example.com/class/method/id/
|
| In some instances, however, you may want to remap this relationship
| so that a different class/function is called than the one
| corresponding to the URL.
|
| Please see the user guide for complete details:
|
|    https://codeigniter.com/user_guide/general/routing.html
|
| -------------------------------------------------------------------------
| RESERVED ROUTES
| -------------------------------------------------------------------------
|
| There are three reserved routes:
|
|    $route['default_controller'] = 'welcome';
|
| This route indicates which controller class should be loaded if the
| URI contains no data. In the above example, the "welcome" class
| would be loaded.
|
|    $route['404_override'] = 'errors/page_missing';
|
| This route will tell the Router which controller/method to use if those
| provided in the URL cannot be matched to a valid route.
|
|    $route['translate_uri_dashes'] = FALSE;
|
| This is not exactly a route, but allows you to automatically route
| controller and method names that contain dashes. '-' isn't a valid
| class or method name character, so it requires translation.
| When you set this option to TRUE, it will replace ALL dashes in the
| controller and method URI segments.
|
| Examples:    my-controller/index    -> my_controller/index
|        my-controller/my-method    -> my_controller/my_method
 */
$route['default_controller'] = 'front';
$route['404_override'] = "front/page_not_found";
$route['home'] = "front/index";
$route['wishlist'] = "front/wishlist";
$route['cart'] = "front/cart";
$route['checkout'] = "front/checkout";
$route['about-us'] = "front/about_us";
$route['contact'] = "front/contact";
$route['newsletter'] = "front/newsletter";
$route['terms-conditions'] = "front/tc";
$route['myaccount'] = "front/myaccount";
$route['add-address'] = "front/add_address";
$route['remove-address'] = "front/remove_address";
$route['select-address'] = "front/select_address";
$route['registration'] = "front/registration";
$route['login'] = "front/login";
$route['change-profile'] = "front/change_profile";
$route['change-password'] = "front/change_password";
$route['forgot-password'] = "front/forgot_password";
$route['reset-password/(:any)'] = "front/reset_password/$1";
$route['update-reset-password'] = "front/update_reset_password";
$route['logout'] = "front/logout";
$route['verify-email/(:any)'] = "front/verify_email/$1";
$route['search-listing'] = "front/search_listing";
$route['search-keyword'] = "front/search_listing_by_keyword";
$route['search'] = "front/search_listing_by_click";
$route['search/(:num)'] = "front/search_listing_by_click/$1";
$route['add-wishlist'] = "front/add_wishlist";
$route['add-cart'] = "front/add_cart";
$route['remove-cart'] = "front/remove_cart";
$route['update-cart'] = "front/update_cart";
$route['increment-quantity'] = "front/increment_quantity";
$route['decrement-quantity'] = "front/decrement_quantity";
$route['faq'] = "front/faq";
$route['state'] = "front/getState";
$route['city'] = "front/getCity";
$route['billing-address'] = "front/billing_address";
$route['confirm-order'] = "front/confirm_order";
$route['order-received-online-payment'] = "front/success";
$route['transaction-failed'] = "front/failure";
$route['order-received-cod'] = "front/cod";
$route['payumoney-online-payment'] = "front/payumoney";
$route['order-received-(:any)'] = "front/order_received/$1";
$route['order-details-modal'] = "front/order_details_modal";
$route['product/load-more-product'] = "front/load_more_product";
$route['product/filter-product'] = "front/filter_products";
$route['fruits-vegetables'] = "front/product";
$route['(:any)'] = "front/product_by_category/$1";
$route['(:any)/(:any)'] = "front/product_by_subcategory/$1/$2";
$route['(:any)/(:any)/(:any)'] = "front/product_detail/$1/$2/$3";
$route['translate_uri_dashes'] = true;

//$route['index'] = "front/index";
