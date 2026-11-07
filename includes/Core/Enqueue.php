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
        wp_register_style( 'wp-plugin-scaffold-app', self::path( 'build/app.css' ), [], WP_PLUGIN_SCAFFOLD_VERSION );
        wp_register_script( 'wp-plugin-scaffold-app', self::path( 'build/app.js' ), [], WP_PLUGIN_SCAFFOLD_VERSION, true );

        wp_register_style( 'wp-plugin-scaffold-main', self::path( 'css/main.css' ), [], WP_PLUGIN_SCAFFOLD_VERSION );
        wp_register_script( 'wp-plugin-scaffold-main', self::path( 'js/main.js' ), [], WP_PLUGIN_SCAFFOLD_VERSION, true );

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
}
