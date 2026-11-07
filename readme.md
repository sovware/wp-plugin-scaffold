# WP Plugin Scaffold

Create a new plugin project with Composer:

```sh
composer create-project syedgalib/wp-plugin-scaffold my-plugin
cd my-plugin
composer plugin:setup
```

The setup command asks for the plugin name, optional description, text domain, and PHP namespace. The text domain becomes the main PHP filename and the prefix for hooks, constants, and asset handles. When working from a source checkout, run `composer install` before `composer plugin:setup`.
