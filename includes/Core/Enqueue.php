<?php

declare( strict_types=1 );

namespace WPPluginScaffold\Core;

// Exit if accessed directly.
defined( 'ABSPATH' ) || exit;

class Enqueue {

    public function __construct() {
        $this->register();
    }

    public function register(): void {
        add_action( 'admin_enqueue_scripts', [ $this, 'admin_enqueue' ] );
        add_action( 'wp_enqueue_scripts', [ $this, 'public_enqueue' ] );
    }

    public function admin_enqueue(): void {
        $this->enqueue_demo_assets();
    }

    public function public_enqueue(): void {
        $this->enqueue_demo_assets();
    }

    private function enqueue_demo_assets(): void {
        wp_enqueue_style( 'wp-plugin-scaffold-demo', self::path( 'css/demo.css' ), [], WP_PLUGIN_SCAFFOLD_VERSION );
        wp_enqueue_script( 'wp-plugin-scaffold-demo', self::path( 'js/demo.js' ), [], WP_PLUGIN_SCAFFOLD_VERSION, true );
    }

    public static function path( string $path ) {
        return WP_PLUGIN_SCAFFOLD_URL . "assets/{$path}";
    }
}
