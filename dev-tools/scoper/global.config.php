<?php

declare(strict_types=1);

return [
    // The prefix configuration. If a non-null value is used, a random prefix
    // will be generated instead.
    //
    // For more see: https://github.com/humbug/php-scoper/blob/master/docs/configuration.md#prefix
    'prefix'                  => 'WPPluginScaffold',

    // When scoping PHP files, there will be scenarios where some of the code being scoped indirectly references the
    // original namespace. These will include, for example, strings or string manipulations. PHP-Scoper has limited
    // support for prefixing such strings. To circumvent that, you can define patchers to manipulate the file to your
    // heart contents.
    //
    // For more see: https://github.com/humbug/php-scoper/blob/master/docs/configuration.md#patchers
    'patchers'                => [
        static function ( string $file_path, string $prefix, string $contents ): string {
            if ( realpath( $file_path ) === realpath( __DIR__ . '/../../composer.json' ) ) {
                $composer         = json_decode( $contents, true, 512, JSON_THROW_ON_ERROR );
                $scoped_namespace = $prefix . '\\WPPluginScaffold\\';

                $composer['autoload']['psr-4']['WPPluginScaffold\\'] = $composer['autoload']['psr-4'][ $scoped_namespace ];

                unset( $composer['autoload']['psr-4'][ $scoped_namespace ] );

                return json_encode( $composer, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES | JSON_THROW_ON_ERROR ) . "\n";
            }

            // Exclud alias classes
            $excluded_alias_classes = [
                'wp-async-request.php',
                'wp-background-process.php',
            ];

            if ( in_array( basename( $file_path ), $excluded_alias_classes ) ) {
                $contents = preg_replace( '/\\\class_alias/', '// \class_alias(', $contents );
            }

            // Fixing Google integration guzzle client version not found issue.
            $files = [
                'AuthHandlerFactory.php',
                'HttpHandlerFactory.php',
                'Client.php'
            ];

            if ( in_array( basename( $file_path ), $files ) ) {
                $contents = str_replace( "defined('\\\\GuzzleHttp\\\\ClientInterface::", "defined('\\FormGent\\GuzzleHttp\\ClientInterface::", $contents );
                $contents = str_replace( "defined('GuzzleHttp\\\\ClientInterface::", "defined('\FormGent\\GuzzleHttp\\ClientInterface::", $contents );
            }

            if ( strpos( $file_path, 'apiclient/src/aliases.php' ) !== false ) {
                $contents = preg_replace( '/\\\class_alias/', '// \class_alias(', $contents );
            }

            return $contents;
        },
    ],

    // List of symbols to consider internal i.e. to leave untouched.
    //
    // For more information see: https://github.com/humbug/php-scoper/blob/master/docs/configuration.md#excluded-symbols
    'exclude-namespaces'      => [
        // 'Acme\Foo'                     // The Acme\Foo namespace (and sub-namespaces)
        // '~^PHPUnit\\\\Framework$~',    // The whole namespace PHPUnit\Framework (but not sub-namespaces)
        // '~^$~',                        // The root namespace only
        'Elementor',
        'PHPUnit',
        'PHP_CodeSniffer',
        'PHPCompatibility',
        'Symfony\Polyfill'
    ],
    'exclude-classes'         => [
        'WP_HTTP_Response',
        'WP_REST_Request',
        'WP_REST_Server',
        'WP_Error',
        'wpdb',
        'WP',
        // 'ReflectionClassConstant',
    ],
    'exclude-functions'       => [
        'dbDelta',
        'get_plugin_data',
        'get_plugins'
    ],
    'exclude-constants'       => [
        '/^SYMFONY\_[\p{L}_]+$/',
        // 'STDIN',
    ],

    // List of symbols to expose.
    //
    // For more information see: https://github.com/humbug/php-scoper/blob/master/docs/configuration.md#exposed-symbols
    'expose-global-constants' => true,
    'expose-global-classes'   => true,
    'expose-global-functions' => true,
    'expose-namespaces'       => [
        // 'Acme\Foo'                     // The Acme\Foo namespace (and sub-namespaces)
        // '~^PHPUnit\\\\Framework$~',    // The whole namespace PHPUnit\Framework (but not sub-namespaces)
        // '~^$~',                        // The root namespace only
        'Elementor'
    ],
    'expose-classes'          => [],
    'expose-functions'        => [],
    'expose-constants'        => [],
];
