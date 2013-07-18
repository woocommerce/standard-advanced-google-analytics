<?php
/**
 * Standard Advanced Google Anaytics
 *
 * Adds advanced Google Analytics options to the Standard Global Dashboard. Specifically,
 * you can expect to see
 *
 * @package   Standard Advanced Google Analytics
 * @author    8BIT <info@8bit.io>
 * @license   GPL-2.0+
 * @link      http://8bit.io
 * @copyright 2013 8BIT
 *
 * @wordpress-plugin
 * Plugin Name: Standard Advanced Google Analytics
 * Plugin URI:  http://github.com/eightbit/standard-advanced-google-analytics/
 * Description: Introduces support for "Multiple top-level domains" and "Display Advertiser Support" into the Standard dashboard.
 * Version:     1.0.0
 * Author:      8BIT
 * Author URI:  http://8bit.io
 * Text Domain: standard-advanced-google-analytics-locale
 * License:     GPL-2.0+
 * License URI: http://www.gnu.org/licenses/gpl-2.0.txt
 * Domain Path: /lang
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
} // end if

require_once( plugin_dir_path( __FILE__ ) . 'class-standard-advanced-google-analytics.php' );

// Delete options whenever the plugin is deactivated
register_deactivation_hook( __FILE__, array( 'Standard_Advanced_Google_Analytics', 'deactivate' ) );

Standard_Advanced_Google_Analytics::get_instance();