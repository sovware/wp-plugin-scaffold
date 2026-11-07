<?php
/**
 * The main plugin file.
 *
 * If we evolve from a canonical plugin into WordPress core, this file would be left behind.
 *
 * @package WPPluginScaffold
 */

declare( strict_types=1 );

namespace WPPluginScaffold;

use WPPluginScaffold\Core\Scaffold;

// Exit if accessed directly.
defined( 'ABSPATH' ) || exit;

/**
 * Class - Plugin
 */
final class Plugin {
	/**
	 * The one true plugin.
	 *
	 * @var ?static
	 */
	private static ?self $instance = null;

	/**
	 * Gets the singleton instance of the plugin.
	 *
	 * @return self The plugin instance.
	 */
	 public static function instance(): self {
		if ( ! isset( self::$instance ) ) {
			self::$instance = new self();
			self::$instance->setup();

			/**
			 * Fires after the main plugin class has been initialized.
			 *
			 * @since 0.1.0
			 *
			 * @param self $instance The main plugin class instance.
			 */
			do_action( 'wp_plugin_scaffold_init', self::$instance );
		}

		return self::$instance;
	}

	/**
	 * Plugin constants.
	 */
	private function constants(): void {
		// This is locally defined in Autoloader::autoload() but is redefined here in case.
		if ( ! defined( 'WP_PLUGIN_SCAFFOLD_DIR' ) ) {
			/**
			 * Plugin directory path.
			 */
			define( 'WP_PLUGIN_SCAFFOLD_DIR', plugin_dir_path( __DIR__ ) );
		}

		/**
		 * Plugin directory URL.
		 */
		define( 'WP_PLUGIN_SCAFFOLD_URL', plugin_dir_url( __DIR__ ) );

		/**
		 * Plugin version.
		 */
		define( 'WP_PLUGIN_SCAFFOLD_VERSION', Scaffold::VERSION );
	}

	/**
	 * Sets up the plugin.
	 */
	private function setup(): void {
		// Define the plugin constants.
		$this->constants();

		Scaffold::instance();
	}

	/**
	 * Prevents the class from being cloned.
	 */
	public function __clone() {
		_doing_it_wrong(
			__FUNCTION__,
			sprintf(
			// translators: %s: Class name.
				esc_html__( 'The %s class should not be cloned.', 'wp-plugin-scaffold' ),
				esc_html( self::class ),
			),
			'0.0.1'
		);
	}

	/**
	 * Prevents the class from being deserialized.
	 */
	public function __wakeup() {
		_doing_it_wrong(
			__FUNCTION__,
			sprintf(
			// translators: %s: Class name.
				esc_html__( 'De-serializing instances of %s is not allowed.', 'wp-plugin-scaffold' ),
				esc_html( self::class ),
			),
			'0.0.1'
		);
	}
}
