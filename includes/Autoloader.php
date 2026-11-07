<?php
/**
 * PSR-4 Autoloader for PHP classes inside plugin.
 *
 * Ensures that autoloaders are present, and logs an Admin notice if not.
 *
 * @package WPPluginScaffold
 */

declare( strict_types=1 );

namespace WPPluginScaffold;

// Exit if accessed directly.
defined( 'ABSPATH' ) || exit;

/**
 * Class - Autoloader
 */
final class Autoloader {
	/**
	 * Whether the autoloader has been loaded.
	 *
	 * @var bool
	 */
	protected static bool $is_loaded = false;

	/**
	 * Attempt to autoload the Composer dependencies.
	 */
	public static function autoload(): bool {
		if ( self::$is_loaded ) {
			return self::$is_loaded;
		}

		$autoloader = plugin_dir_path( __DIR__ ) . '/vendor/vendor-src/autoload.php';

		self::$is_loaded = self::require_autoloader( $autoloader );

		if ( ! self::$is_loaded ) {
			return false;
		}

		// This is conditionally redefined in Plugin::constants().
		define( 'WP_PLUGIN_SCAFFOLD_DIR', plugin_dir_path( __DIR__ ) );

		return self::$is_loaded;
	}

	/**
	 * Attempts to load the autoloader file, if it exists.
	 *
	 * @param string $autoloader_file The path to the autoloader file.
	 */
	private static function require_autoloader( string $autoloader_file ): bool {
		if ( ! is_readable( $autoloader_file ) ) {
			self::missing_autoloader_notice();

			return false;
		}

		return (bool) require_once $autoloader_file; // phpcs:ignore WordPressVIPMinimum.Files.IncludingFile.UsingVariable -- Autoloader is a Composer file.
	}

	/**
	 * Displays a notice if the autoloader is missing.
	 */
	private static function missing_autoloader_notice(): void {
		// Defer notice until translation functions are available.
		add_action(
			'init',
			static function () {
				$error_message = __( 'WP Plugin Scaffold: The Composer autoloader was not found. If you installed the plugin from the GitHub source code, make sure to run `composer install`.', 'mcp-adapter' );

				// Log a notice.
				_doing_it_wrong(
					self::class,
					esc_html( $error_message ),
					'0.0.1'
				);

				// Log an admin notice.
				$hooks = array(
					'admin_notices',
					'network_admin_notices',
				);
				foreach ( $hooks as $hook ) {
					add_action(
						$hook,
						static function () use ( $error_message ) {
							wp_admin_notice(
								esc_html( $error_message ),
								array(
									'type'    => 'error',
									'dismiss' => false,
								),
							);
						}
					);
				}
			}
		);
	}
}
