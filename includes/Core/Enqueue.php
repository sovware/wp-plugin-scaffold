<?php

declare( strict_types=1 );

namespace WPPluginScaffold\Core;

// Exit if accessed directly.
defined( 'ABSPATH' ) || exit;

class Enqueue {

    public function __construct() {
        add_action( 'init', [ $this, 'register' ] );
        add_action( 'admin_enqueue_scripts', [ $this, 'admin_enqueue' ] );
        add_action( 'wp_enqueue_scripts', [ $this, 'public_enqueue' ] );
    }

    public function register(): void {
        wp_register_style( 'wp-plugin-scaffold-app', self::css_path( 'build/app' ), [], WP_PLUGIN_SCAFFOLD_VERSION );
        wp_register_script( 'wp-plugin-scaffold-app', self::js_path( 'build/app' ), self::js_dependencies( 'build/app' ), WP_PLUGIN_SCAFFOLD_VERSION, true );

        wp_register_style( 'wp-plugin-scaffold-main', self::css_path( 'css/main' ), [], WP_PLUGIN_SCAFFOLD_VERSION );
        wp_register_script( 'wp-plugin-scaffold-main', self::js_path( 'js/main' ), self::js_dependencies( 'js/main' ), WP_PLUGIN_SCAFFOLD_VERSION, true );
    }

    public function admin_enqueue(): void {
        $this->enqueue_demo_assets();
    }

    public function public_enqueue(): void {
        $this->enqueue_demo_assets();
    }

    private function enqueue_demo_assets(): void {
        wp_enqueue_style( 'wp-plugin-scaffold-app' );
        wp_enqueue_script( 'wp-plugin-scaffold-app' );

        wp_enqueue_style( 'wp-plugin-scaffold-main' );
        wp_enqueue_script( 'wp-plugin-scaffold-main' );
    }

    public static function path( string $path ) {
        return WP_PLUGIN_SCAFFOLD_URL . "assets/{$path}";
    }

    /** Return the URL for an extensionless CSS path in the current text direction. */
    public static function css_path( string $path ): string {
        return self::path( $path . ( is_rtl() ? '-rtl' : '' ) . '.css' );
    }

    /** Return the URL for an extensionless JS path. */
    public static function js_path( string $path ): string {
        return self::path( $path . '.js' );
    }

    /** Load dependencies from the asset metadata beside an extensionless JS path. */
    public static function js_dependencies( string $path ): array {
        $asset_file = WP_PLUGIN_SCAFFOLD_DIR . 'assets/' . $path . '.asset.php';

        if ( ! is_readable( $asset_file ) ) {
            return [];
        }

        $asset = require $asset_file;

        return is_array( $asset ) && isset( $asset['dependencies'] ) && is_array( $asset['dependencies'] )
            ? $asset['dependencies']
            : [];
    }
}
