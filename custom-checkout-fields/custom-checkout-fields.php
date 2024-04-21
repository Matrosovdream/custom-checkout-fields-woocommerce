<?php

/**
 * @file
 * Custom checkout fields on product Tag
 */

/**
 * Plugin name: Custom checkout fields on product Tag
 * Author: Stan Matrosov
 * Author URI: 
 * Description: 
 * Version: 1.0
 * License: GPL2
 */


// Sanity check
if (!defined('ABSPATH')) die('Direct access is not allowed.');

// defines
define('CCF_PLUGIN_DIR_ABS', WP_PLUGIN_DIR . '/custom-checkout-fields');
define('CCF_PLUGIN_DIR', plugin_dir_url( __FILE__ ));


// Classes
require_once('classes/helper.class.php');
require_once('classes/admin.class.php');

// Ajax
require_once('ajax/file_upload.php');

// ACF
require_once('ACF/extra_forms.php');

// Hooks
require_once('hooks/checkout.php');
require_once('hooks/order.admin.php');




































