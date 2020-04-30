<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/*
|--------------------------------------------------------------------------
| Display Debug backtrace
|--------------------------------------------------------------------------
|
| If set to TRUE, a backtrace will be displayed along with php errors. If
| error_reporting is disabled, the backtrace will not display, regardless
| of this setting
|
*/
defined('SHOW_DEBUG_BACKTRACE') OR define('SHOW_DEBUG_BACKTRACE', TRUE);

/*
|--------------------------------------------------------------------------
| File and Directory Modes
|--------------------------------------------------------------------------
|
| These prefs are used when checking and setting modes when working
| with the file system.  The defaults are fine on servers with proper
| security, but you may wish (or even need) to change the values in
| certain environments (Apache running a separate process for each
| user, PHP under CGI with Apache suEXEC, etc.).  Octal values should
| always be used to set the mode correctly.
|
*/
defined('FILE_READ_MODE')  OR define('FILE_READ_MODE', 0644);
defined('FILE_WRITE_MODE') OR define('FILE_WRITE_MODE', 0666);
defined('DIR_READ_MODE')   OR define('DIR_READ_MODE', 0755);
defined('DIR_WRITE_MODE')  OR define('DIR_WRITE_MODE', 0755);

/*
|--------------------------------------------------------------------------
| File Stream Modes
|--------------------------------------------------------------------------
|
| These modes are used when working with fopen()/popen()
|
*/
defined('FOPEN_READ')                           OR define('FOPEN_READ', 'rb');
defined('FOPEN_READ_WRITE')                     OR define('FOPEN_READ_WRITE', 'r+b');
defined('FOPEN_WRITE_CREATE_DESTRUCTIVE')       OR define('FOPEN_WRITE_CREATE_DESTRUCTIVE', 'wb'); // truncates existing file data, use with care
defined('FOPEN_READ_WRITE_CREATE_DESTRUCTIVE')  OR define('FOPEN_READ_WRITE_CREATE_DESTRUCTIVE', 'w+b'); // truncates existing file data, use with care
defined('FOPEN_WRITE_CREATE')                   OR define('FOPEN_WRITE_CREATE', 'ab');
defined('FOPEN_READ_WRITE_CREATE')              OR define('FOPEN_READ_WRITE_CREATE', 'a+b');
defined('FOPEN_WRITE_CREATE_STRICT')            OR define('FOPEN_WRITE_CREATE_STRICT', 'xb');
defined('FOPEN_READ_WRITE_CREATE_STRICT')       OR define('FOPEN_READ_WRITE_CREATE_STRICT', 'x+b');

/*
|--------------------------------------------------------------------------
| Exit Status Codes
|--------------------------------------------------------------------------
|
| Used to indicate the conditions under which the script is exit()ing.
| While there is no universal standard for error codes, there are some
| broad conventions.  Three such conventions are mentioned below, for
| those who wish to make use of them.  The CodeIgniter defaults were
| chosen for the least overlap with these conventions, while still
| leaving room for others to be defined in future versions and user
| applications.
|
| The three main conventions used for determining exit status codes
| are as follows:
|
|    Standard C/C++ Library (stdlibc):
|       http://www.gnu.org/software/libc/manual/html_node/Exit-Status.html
|       (This link also contains other GNU-specific conventions)
|    BSD sysexits.h:
|       http://www.gsp.com/cgi-bin/man.cgi?section=3&topic=sysexits
|    Bash scripting:
|       http://tldp.org/LDP/abs/html/exitcodes.html
|
*/
defined('EXIT_SUCCESS')        OR define('EXIT_SUCCESS', 0); // no errors
defined('EXIT_ERROR')          OR define('EXIT_ERROR', 1); // generic error
defined('EXIT_CONFIG')         OR define('EXIT_CONFIG', 3); // configuration error
defined('EXIT_UNKNOWN_FILE')   OR define('EXIT_UNKNOWN_FILE', 4); // file not found
defined('EXIT_UNKNOWN_CLASS')  OR define('EXIT_UNKNOWN_CLASS', 5); // unknown class
defined('EXIT_UNKNOWN_METHOD') OR define('EXIT_UNKNOWN_METHOD', 6); // unknown class member
defined('EXIT_USER_INPUT')     OR define('EXIT_USER_INPUT', 7); // invalid user input
defined('EXIT_DATABASE')       OR define('EXIT_DATABASE', 8); // database error
defined('EXIT__AUTO_MIN')      OR define('EXIT__AUTO_MIN', 9); // lowest automatically-assigned error code
defined('EXIT__AUTO_MAX')      OR define('EXIT__AUTO_MAX', 125); // highest automatically-assigned error code

if(($_SERVER['SERVER_ADDR']=="127.0.0.1") OR ($_SERVER['SERVER_ADDR']=="::1"))
{
	/* ## Common constants */
	define('BASE_URL',"http://".$_SERVER['HTTP_HOST']."/organicstore/");/* define base url */
	define('BASE_DIR',$_SERVER['DOCUMENT_ROOT']."/organicstore");/* define base directory path */
	define('ADMIN_BASE_URL',"http://".$_SERVER['HTTP_HOST']."/organicstore/x/");/* define admin base url */
}
else
{
	/* ## Common constants */
	define('BASE_URL',"http://".$_SERVER['HTTP_HOST'].'/organicstore/');/* define base url */
	define('BASE_DIR',$_SERVER['DOCUMENT_ROOT'].'/organicstore');/* define base directory path */
	define('ADMIN_BASE_URL',"http://".$_SERVER['HTTP_HOST']."/organicstore/x/");/* define admin base url */
}
define('APP_NAME', 'Organic Store');
define('SITE_URL','http://.org');/*  Application Name*/
define('EXT', '.html');/*  URL Extension */

/* Default image URL Path*/
define('BASE_UPLOAD_DIR', BASE_DIR . '/uploads/');
define('BASE_UPLOAD_URL', BASE_URL . 'uploads/');
define('DEFAULT_IMAGE', BASE_UPLOAD_URL . 'no_image.jpg');
define('IMG_URL',BASE_URL."assets/images/");/* define base images URL */
define('NOT_FOUND_ASSETS', BASE_URL . 'x/assets/404-page/');

/*Page image path*/
define('PAGE_IMG_DIR', BASE_UPLOAD_DIR.'page/' );
define('PAGE_IMG_URL', BASE_UPLOAD_URL.'page/' );

define('CUSTOMER_IMG_URL', BASE_UPLOAD_URL.'customer/images/' );
define('CUSTOMER_IMG_DIR', BASE_UPLOAD_DIR.'customer/images/' );


//product images
define('PRODUCT_IMG_DIR', BASE_UPLOAD_DIR.'product/');
define('PRODUCT_IMG_URL', BASE_UPLOAD_URL.'product/');

//gallery images
define('GALLERY_IMG_DIR', BASE_UPLOAD_DIR.'gallery/');
define('GALLERY_IMG_URL', BASE_UPLOAD_URL.'gallery/');

//product category images
define('PRODUCT_CATEGORY_IMG_DIR', BASE_UPLOAD_DIR.'product_category/');
define('PRODUCT_CATEGORY_IMG_URL', BASE_UPLOAD_URL.'product_category/');

//product subcategory images
define('PRODUCT_SUBCATEGORY_IMG_DIR', BASE_UPLOAD_DIR.'product_subcategory/');
define('PRODUCT_SUBCATEGORY_IMG_URL', BASE_UPLOAD_URL.'product_subcategory/');

//about_us
define('ABOUT_US_IMG_DIR', BASE_UPLOAD_DIR.'about_us/');
define('ABOUT_US_IMG_URL', BASE_UPLOAD_URL.'about_us/');

/* SLIDER image path */
define('SLIDER_IMG_DIR', BASE_UPLOAD_DIR.'slider/' );
define('SLIDER_IMG_URL', BASE_UPLOAD_URL.'slider/' );

/* Promotion path */
define('PROMOTION_IMG_DIR', BASE_UPLOAD_DIR.'promotion/' );
define('PROMOTION_IMG_URL', BASE_UPLOAD_URL.'promotion/' );


?>
