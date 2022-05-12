<?php
/**
 * Plugin Name: Backdrop Updater
 * Version: 1.0.0
 * Author: Benjamin Lu
 * Author URI: http://benjlu.com
 * License: GPLv2 or later
 * License URI: http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain: backdrop-updater
 * Domain Path: /languages/
**/

/**
 * Table of Content
 *
 * 1.0 - Forbidden Access
 * 2.0 - Required Files
 * 3.0 - Register Default Post Type
 * 4.0 - Plugin Text Domain
 */

/**
 * 1.0 - Forbidden Access
 */
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * 2.0 - Required Files
 */
if ( file_exists( plugin_dir_path( __FILE__ ) . '/vendor/autoload.php' ) ) {
	require_once plugin_dir_path( __FILE__ ) . '/vendor/autoload.php';
}
