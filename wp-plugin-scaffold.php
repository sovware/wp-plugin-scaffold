<?php
/**
 * WordPress Plugin Scaffold
 *
 * @package     wp-plugin-scaffold
 * @author      Syed Galib Ahmed
 * @license     GPL-2.0-or-later
 *
 * @wordpress-plugin
 * Plugin Name:       WP Plugin Scaffold
 * Plugin URI:        https://github.com/syedgalib/wp-plugin-scaffold
 * Description:       A quick starter for WordPress plugin.
 * Version:           0.0.1
 * Requires at least: 6.9
 * Requires PHP:      7.4
 * Author:            Syed Galib Ahmed
 * Author URI:        https://github.com/syedgalib/wp-plugin-scaffold/graphs/contributors
 * License:           GPLv2 or later
 * License URI:       https://www.gnu.org/licenses/old-licenses/gpl-2.0.html
 * Text Domain:       wp-plugin-scaffold
 * Domain Path:       /languages
 */

declare (strict_types = 1);

namespace WPPluginScaffold;

// Exit if accessed directly.
defined( 'ABSPATH' ) || exit();

require_once __DIR__ . '/includes/Autoloader.php';

// If autoloader failed, we cannot proceed.
if ( ! Autoloader::autoload() ) {
	return;
}

// Load the plugin.
if ( class_exists( Plugin::class ) ) {
	Plugin::instance();
}
