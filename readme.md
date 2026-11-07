# WP Plugin Scaffold

1. Create a new plugin project with Composer:

   ```sh
   composer create-project sovware/wp-plugin-scaffold my-plugin
   ```

2. Enter the project directory:

   ```sh
   cd my-plugin
   ```

3. Personalize the plugin:

   ```sh
   composer plugin:setup
   ```

The setup command asks for the plugin name, optional description, optional Plugin URI, Author, and Author URI, text domain, and PHP namespace. Leave the URI and author fields blank to keep their existing values. The text domain becomes the main PHP filename and the prefix for hooks, constants, and asset handles. When working from a source checkout, run `composer install` before `composer plugin:setup`.
