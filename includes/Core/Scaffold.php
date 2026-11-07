<?php
/**
 * WordPress Plugin Scaffold - Main class of the plugin.
 *
 * @package WPPluginScaffold\Core
 */

declare( strict_types=1 );

namespace WPPluginScaffold\Core;

// Exit if accessed directly.
defined( 'ABSPATH' ) || exit;

/**
 * WordPress Plugin Scaffold - Main class of the plugin.
 */
final class Scaffold {

	public const VERSION = '0.0.1';

	/**
	 * Scaffold instance
	 *
	 * @var \PluginScaffold\Core\Scaffold
	 */
	private static self $instance;

	/**
	 * Get the scaffold instance
	 *
	 * @return \PluginScaffold\Core\Scaffold
	 */
	public static function instance(): self {
		if ( ! isset( self::$instance ) ) {
			self::$instance = new self();

			self::$instance->init();
		}

		return self::$instance;
	}

	/**
	 * Initialize the services
	 *
	 * @internal For use by instance initialization only.
	 */
	public function init(): void {
		// Initialize the services here

		add_action( 'init', function() {
		    add_action( 'admin_notices', function() {
                wp_admin_notice(
         			esc_html( "The WP plugin scaffold has been loaded successfully" ),
         			array(
        				'type'    => 'success',
        				'dismiss' => false,
         			),
                );
      		} );
		} );

		/**
		 * Fires after the plugin has been initialized.
		 *
		 * @since 0.0.1
		 *
		 * @param \PluginScaffold\Core\Scaffold $scaffold The plugin singleton instance.
		 */
		do_action( 'wp_plugin_scaffold_init', $this );
	}
}
