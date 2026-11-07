<?php

declare( strict_types=1 );

/**
 * Get the rendered contents of a template in the templates directory.
 *
 * The template receives the supplied values in the $args array.
 *
 * @param string $template Template path, with or without the .php extension.
 * @param array  $args     Values available to the template.
 * @return string Rendered template contents, or an empty string if not found.
 */
function wp_plugin_scaffold_get_template_contents( string $template, array $args = [] ): string {
	$templates_directory = realpath( WP_PLUGIN_SCAFFOLD_DIR . 'templates' );

	if ( false === $templates_directory ) {
		return '';
	}

	$template_name = substr( $template, -4 ) === '.php' ? $template : $template . '.php';
	$template_file = realpath( $templates_directory . '/' . ltrim( $template_name, '/\\' ) );

	if (
		false === $template_file
		|| 0 !== strpos( $template_file, $templates_directory . DIRECTORY_SEPARATOR )
		|| ! is_file( $template_file )
		|| ! is_readable( $template_file )
	) {
		return '';
	}

	ob_start();

	try {
		( static function ( string $file, array $args ): void {
			require $file; // phpcs:ignore WordPressVIPMinimum.Files.IncludingFile.UsingVariable -- Load a validated plugin template.
		} )( $template_file, $args );

		return (string) ob_get_clean();
	} catch ( \Throwable $error ) {
		ob_end_clean();
		throw $error;
	}
}

/**
 * Output a template from the templates directory.
 *
 * @param string $template Template path, with or without the .php extension.
 * @param array  $args     Values available to the template.
 */
function wp_plugin_scaffold_render_template( string $template, array $args = [] ): void {
	echo wp_plugin_scaffold_get_template_contents( $template, $args ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- Templates escape their own output.
}
